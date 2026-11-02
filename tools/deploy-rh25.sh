#!/usr/bin/env bash
# Run only through the reviewed workflow after production approval.
set -euo pipefail
umask 077

fail() { printf '%s\n' "$1" >&2; exit 1; }
phase="${1:-}"
case "$phase" in validate|execute) ;; *) fail 'Expected validate or execute.' ;; esac
case "${DEPLOY_OPERATION:-}" in dry-run|deploy) ;; *) fail 'Unsupported operation.' ;; esac
if [ "$DEPLOY_OPERATION" = deploy ]; then
  [ "${CONFIRM_PRODUCTION:-}" = DEPLOY ] || fail 'Explicit deployment confirmation is missing.'
fi
case "${LIVE_HOST:-}" in sgpr200.websitehostserver.net|23.106.55.199) ;; *) fail 'Host is not the approved RH-25 destination.' ;; esac
[ "${LIVE_USER:-}" = webstud5 ] || fail 'Unexpected destination account.'
[ "${LIVE_THEME_PATH:-}" = /home/webstud5/public_html/wp-content/themes/winter ] || fail 'Unexpected destination theme path.'
[[ "${LIVE_PORT:-}" =~ ^[0-9]{1,5}$ ]] || fail 'SSH port must be numeric.'
(( 10#$LIVE_PORT >= 1 && 10#$LIVE_PORT <= 65535 )) || fail 'SSH port is out of range.'
[ -n "${LIVE_KNOWN_HOSTS:-}" ] || fail 'Independently verified pinned host key is required.'
[ -n "${RUNNER_TEMP:-}" ] && [ -d "$RUNNER_TEMP" ] || fail 'Runner temporary directory is unavailable.'

known_hosts="$(mktemp "$RUNNER_TEMP/wswa-known-hosts.XXXXXX")"
trap 'rm -f -- "$known_hosts"' EXIT
printf '%s\n' "$LIVE_KNOWN_HOSTS" > "$known_hosts"
host_lookup="$LIVE_HOST"
[ "$LIVE_PORT" = 22 ] || host_lookup="[$LIVE_HOST]:$LIVE_PORT"
ssh-keygen -F "$host_lookup" -f "$known_hosts" >/dev/null || fail 'Pinned host key does not match the configured host and port.'
[ -f style.css ] && [ -f functions.php ] && [ -d assets ] || fail 'Local theme payload is incomplete.'
if [ "$phase" = validate ]; then
  printf '%s\n' 'RH-25 configuration validated; no remote connection made.'
  exit 0
fi

ssh_args=(ssh -p "$LIVE_PORT" -o BatchMode=yes -o StrictHostKeyChecking=yes
  -o "UserKnownHostsFile=$known_hosts" -o ConnectTimeout=20
  -o ServerAliveInterval=30 -o ServerAliveCountMax=3)
destination="$LIVE_USER@$LIVE_HOST"
"${ssh_args[@]}" "$destination" bash -s -- "$LIVE_THEME_PATH" <<'REMOTE_IDENTITY'
set -euo pipefail
test "$(id -un)" = webstud5
test "$(hostname -f)" = sgpr200.websitehostserver.net
test "$1" = /home/webstud5/public_html/wp-content/themes/winter
test ! -L "$1"
test "$(readlink -f -- "$1")" = /home/webstud5/public_html/wp-content/themes/winter
test "$(stat -c %U -- "$1")" = webstud5
test -f "$1/style.css"
test -f "$1/functions.php"
test -w "$1"
command -v rsync >/dev/null
printf '%s\n' 'Verified RH-25 account, hostname, canonical theme path and permissions.'
REMOTE_IDENTITY

if [ "$DEPLOY_OPERATION" = deploy ]; then
  [[ "${GITHUB_RUN_ID:-}" =~ ^[0-9]+$ ]] || fail 'Invalid run ID.'
  [[ "${GITHUB_RUN_ATTEMPT:-}" =~ ^[0-9]+$ ]] || fail 'Invalid run attempt.'
  "${ssh_args[@]}" "$destination" bash -s -- "$LIVE_THEME_PATH" "$GITHUB_RUN_ID-$GITHUB_RUN_ATTEMPT" <<'REMOTE_SNAPSHOT'
set -euo pipefail
set -C
umask 077
theme_path="$1"
test "$(id -un)" = webstud5
test "$(hostname -f)" = sgpr200.websitehostserver.net
test "$(readlink -f -- "$theme_path")" = /home/webstud5/public_html/wp-content/themes/winter
test -f "$theme_path/style.css"
test -f "$theme_path/functions.php"
backup_root=/home/webstud5/winter-deploy-backups
test ! -L "$backup_root"
mkdir -p -- "$backup_root"
test "$(readlink -f -- "$backup_root")" = /home/webstud5/winter-deploy-backups
chmod 700 "$backup_root"
backup_path="$backup_root/winter-$2.tar.gz"
test ! -e "$backup_path"
tar -czf - -C "$(dirname "$theme_path")" "$(basename "$theme_path")" > "$backup_path"
tar -tzf "$backup_path" >/dev/null
sha256sum "$backup_path"
printf '%s\n' 'Verified pre-deployment theme snapshot; database is not included.'
REMOTE_SNAPSHOT
fi

rsync_args=(-az --itemize-changes)
if [ "$DEPLOY_OPERATION" = dry-run ]; then
  # No snapshot, mkdir, upload or deletion is performed by this branch.
  rsync_args+=(--dry-run)
fi
printf -v ssh_transport '%q ' "${ssh_args[@]}"
rsync "${rsync_args[@]}" \
  --exclude='.git/' --exclude='.github/' --exclude='node_modules/' \
  --exclude='.DS_Store' --exclude='*.log' --exclude='.env' --exclude='.env.*' \
  --exclude='backups/' --exclude='backup/' --exclude='*.sql' --exclude='*.zip' \
  --exclude='*.tar' --exclude='*.tar.gz' --exclude='*.tgz' --exclude='README.md' \
  --exclude='docs/' --exclude='tests/' --exclude='tools/' \
  --exclude='package-lock.json' --exclude='package.json' --exclude='assets/scss/' \
  -e "$ssh_transport" ./ "$destination:$LIVE_THEME_PATH/"
printf '%s\n' 'Approved operation finished without rsync deletion.'
