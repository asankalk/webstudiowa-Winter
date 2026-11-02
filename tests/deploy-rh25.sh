#!/usr/bin/env bash
# Safety regression tests use mocks only: no remote host or credentials.
set -euo pipefail
test_root="$(mktemp -d)"
trap 'rm -rf -- "$test_root"' EXIT
mkdir -p "$test_root/bin" "$test_root/runner"
export TEST_CALLS="$test_root/calls"
cat > "$test_root/bin/ssh-keygen" <<'MOCK'
#!/usr/bin/env bash
exit "${MOCK_PIN_RESULT:-0}"
MOCK
cat > "$test_root/bin/ssh" <<'MOCK'
#!/usr/bin/env bash
input="$(cat)"
if [[ "$input" == *'REMOTE'* ]]; then exit 98; fi
if [[ "$input" == *'backup_path='* ]]; then
  echo snapshot >> "$TEST_CALLS"
  exit "${MOCK_SNAPSHOT_RESULT:-0}"
fi
echo identity >> "$TEST_CALLS"
exit "${MOCK_IDENTITY_RESULT:-0}"
MOCK
cat > "$test_root/bin/rsync" <<'MOCK'
#!/usr/bin/env bash
for arg in "$@"; do
  case "$arg" in --delete|--delete-*) exit 97 ;; esac
done
printf 'rsync %s\n' "$*" >> "$TEST_CALLS"
MOCK
chmod 700 "$test_root/bin/ssh-keygen" "$test_root/bin/ssh" "$test_root/bin/rsync"
export PATH="$test_root/bin:$PATH"
export RUNNER_TEMP="$test_root/runner" LIVE_HOST=sgpr200.websitehostserver.net LIVE_PORT=22
export LIVE_USER=webstud5 LIVE_THEME_PATH=/home/webstud5/public_html/wp-content/themes/winter
export LIVE_KNOWN_HOSTS='mock pinned public host key'
export DEPLOY_OPERATION=dry-run CONFIRM_PRODUCTION= GITHUB_RUN_ID=123 GITHUB_RUN_ATTEMPT=1

must_fail() {
  : > "$TEST_CALLS"
  if env "$@" bash tools/deploy-rh25.sh execute >/dev/null 2>&1; then
    echo 'Unexpected accepted unsafe configuration.' >&2; exit 1
  fi
  test ! -s "$TEST_CALLS"
}
must_fail LIVE_HOST=old-host.example
must_fail LIVE_USER=other-account
must_fail LIVE_THEME_PATH=/home/webstud5/public_html/demo3/wp-content/themes/winter
must_fail LIVE_THEME_PATH=/home/webstud5/public_html
must_fail LIVE_PORT=0
must_fail LIVE_PORT=65536
must_fail LIVE_KNOWN_HOSTS=
must_fail MOCK_PIN_RESULT=1
must_fail DEPLOY_OPERATION=deploy CONFIRM_PRODUCTION=

: > "$TEST_CALLS"
bash tools/deploy-rh25.sh validate >/dev/null
test ! -s "$TEST_CALLS"
bash tools/deploy-rh25.sh execute >/dev/null
test "$(head -n 1 "$TEST_CALLS")" = identity
grep -q '^rsync .*--dry-run' "$TEST_CALLS"
! grep -q snapshot "$TEST_CALLS"

: > "$TEST_CALLS"
if MOCK_IDENTITY_RESULT=1 bash tools/deploy-rh25.sh execute >/dev/null 2>&1; then exit 1; fi
test "$(cat "$TEST_CALLS")" = identity

: > "$TEST_CALLS"
if DEPLOY_OPERATION=deploy CONFIRM_PRODUCTION=DEPLOY MOCK_SNAPSHOT_RESULT=1 bash tools/deploy-rh25.sh execute >/dev/null 2>&1; then exit 1; fi
test "$(wc -l < "$TEST_CALLS" | tr -d ' ')" = 2
test "$(tail -n 1 "$TEST_CALLS")" = snapshot

: > "$TEST_CALLS"
DEPLOY_OPERATION=deploy CONFIRM_PRODUCTION=DEPLOY bash tools/deploy-rh25.sh execute >/dev/null
test "$(sed -n '1p' "$TEST_CALLS")" = identity
test "$(sed -n '2p' "$TEST_CALLS")" = snapshot
grep -q '^rsync ' "$TEST_CALLS"
! grep '^rsync ' "$TEST_CALLS" | grep -q -- --dry-run
printf '%s\n' 'RH-25 safety checks passed using mocks; no remote connection was made.'
