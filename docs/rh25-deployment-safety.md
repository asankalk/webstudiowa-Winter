# RH-25 deployment safety gate

Prepared 2 November 2026 (Australia/Perth). This change is a reviewable proposal; no hosting connection, workflow dispatch, secret/environment update or deployment was performed while preparing it. Do not merge or enable it as part of website archival without a separate deployment decision.

## Resulting workflow behavior

Pushes to main run the existing PHP/JS syntax, Sass build, responsive, navigation and portfolio checks, but do not connect to hosting. Remote operations require a manual workflow_dispatch on main, repository variable WSWA_RH25_TARGET_APPROVED=true, and the production environment. The default operation is dry-run; deploy additionally requires the exact confirmation DEPLOY. The rollout variable must remain unset/false until all acceptance items below are verified.

The job's environment declaration does not itself configure required reviewers. A repository owner must separately verify the production environment's required reviewer/branch rules, and ensure no bypass is being relied on, before authorizing the rollout variable. Environment protection was not readable through the available connector and is not claimed as configured. [GitHub environment protections](https://docs.github.com/en/actions/how-tos/deploy/configure-and-manage-deployments/manage-environments)

The deployment helper rejects hosts other than sgpr200.websitehostserver.net or 23.106.55.199, accounts other than webstud5, and paths other than /home/webstud5/public_html/wp-content/themes/winter. It requires an independently verified LIVE_KNOWN_HOSTS entry matching the configured host/port; the previous ssh-keyscan fallback is removed. SSH uses strict host-key checking and batch authentication. The server must report the expected hostname and user, the canonical path must match exactly, and theme ownership/files/write permission must pass before rsync.

Dry-run checks the remote identity/path and uses rsync --dry-run without --delete. It does not create a hosting snapshot, create a missing theme path, upload files or remove files. Deployment first creates a unique no-clobber theme snapshot outside public_html, validates its archive and records its SHA-256; any failure prevents transfer. Both modes omit rsync deletion. Stale theme files require a separately reviewed removal plan; they are not silently purged. [rsync dry-run and deletion semantics](https://download.samba.org/pub/rsync/rsync.1)

## Existing target remains unverified

No secret values were inspected. Existing LIVE_HOST, LIVE_PORT and LIVE_THEME_PATH may still refer to the original EcoSite host; the old deployment guide records 107.6.176.102. Current RH-25 public-site routing is not proof of the values stored in deployment secrets. A single unauthenticated TCP probe on 2026-11-02 at 21:37 Perth received SSH-2.0-OpenSSH_8.0 from sgpr200.websitehostserver.net:22. This establishes port reachability only; it does not verify the configured LIVE_PORT, authentication, permissions or host-key trust. No target secret or key trust has been invented.

## Activation checklist — separate approval required

1. Preserve the original EcoSite service, the full cPanel migration archive and all existing rollback archives. Verify independent recovery before deployment acceptance; a pre-deploy theme tar is not a whole-site/database backup.
2. Confirm the exact RH-25 SSH port, dedicated deploy identity, canonical winter path and ownership. Obtain the SSH host key/fingerprint independently from an authenticated provider/control-panel source. Do not trust an unverified network scan.
3. In a secure user-controlled flow, review/update only the required production LIVE_* secret values after approval. Never print them in chat, documentation or workflow logs. Pin the verified matching hostname/port key in LIVE_KNOWN_HOSTS.
4. Configure/verify production environment required reviewers and main-only deployment branch policy. Keep WSWA_RH25_TARGET_APPROVED unset until these controls, least privilege and the destination metadata have been reviewed. Adding an environment to YAML alone is not approval protection.
5. Re-run all repository gates and physical iPhone Safari acceptance when available. A draft PR is not production release evidence. Preserve all failed-test evidence and do not bypass failures.
6. After explicit approval, enable the rollout variable and manually dispatch dry-run. This still requires the configured production environment approval. Review its identity result, exact theme destination and itemized differences; verify there are no unrelated paths or deletions.
7. Only after a satisfactory dry run and a new production decision, dispatch deploy with DEPLOY. The verified server-side theme snapshot gates copying. A failure stops deployment and preserves the snapshot; no automatic retry is authorized.
8. Verify retained main WordPress functionality, responsive/browser gates and critical integrations with separately approved test mail/OAuth/form recipients/accounts. Do not submit real customer communications as a hidden check.

## Rollback and archival interaction

A revert push now validates only; a Git revert does not itself restore hosting. Use the retained verified theme snapshot and exact canonical path under a separately approved rollback procedure, or manually dispatch the reviewed reverted commit after production approval. Never restore the whole cPanel account over unrelated current services as a theme rollback.

Do not run deployments while Demo1/Pretium capture is in progress. Demo1's AJCC repository has a separate main-triggered demo workflow and requires independent retirement/coordination. Demo3 has a Winter remote but is not an allowed target in this RH-25 helper. No AJCC workflow was changed.

## Validation record

The helper has mock-only regression tests for old/wrong hosts/accounts/paths, invalid ports, absent/unmatched pins, missing deployment confirmation, no remote action during local validation, no snapshot during dry-run, identity failure, snapshot failure, snapshot-before-transfer order and absence of rsync deletion. The existing build job runs these checks before remote operations. These mocks do not establish actual SSH access or remote identity.

Current production environment configuration, secret target values, SSH authentication/port and independently trusted host key remain acceptance blockers. Physical iPhone Safari remains a manual check, not Playwright WebKit.

### Local proposal checks — 2 November 2026

Passed: clean npm install/dependency audit (zero reported vulnerabilities), Sass build (no compiled asset changes), all 29 PHP file syntax checks, JavaScript syntax, outer/remote Bash syntax, YAML parsing, diff whitespace checks and the mock-only deployment safety regression suite. Chromium/WebKit navigation checks passed; portfolio checks passed 18 viewport/engine cases. The full published-page responsive suite was deliberately stopped before completion to preserve the MacBook's limited free space (about 4.76 GiB remaining); partial evidence is retained locally and no full responsive PASS is claimed. It must complete before any production release. Physical iPhone Safari was unavailable. No workflow was dispatched and no hosting authentication or deployment was attempted.
