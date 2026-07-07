# Winter Theme Deployment

## Overview

Deployment flow:

`Local VS Code -> GitHub -> GitHub Actions -> Live WordPress theme folder`

Use `main` as the production branch. Any push to `main` can trigger the deployment workflow after the repository secrets are configured.

The preferred deployment method remains SSH + `rsync`. FTP and explicit FTPS details may be available for the hosting account, but they should only be used if SSH is unavailable or unsuitable for automation.

## Web Studio WA Hosting Details

These confirmed values are safe to document because they are not passwords or private keys:

- cPanel user: `webstud5`
- Primary domain: `webstudiowa.com.au`
- Shared IP: `107.6.176.102`
- Home directory: `/home/webstud5`
- Live theme path: `/home/webstud5/public_html/wp-content/themes/winter/`
- FTP server: `ftp.webstudiowa.com.au`
- FTP / explicit FTPS port: `21`

Important:

- FTP details are available, but the preferred workflow is still SSH + `rsync`.
- Do not switch to FTP/FTPS deployment unless SSH is confirmed to be unavailable.
- Do not place real passwords, FTP passwords, or SSH private keys in repository files.

## Before You Enable Live Deployment

Complete this checklist first:

1. Confirm the live server supports SSH access.
2. Confirm `rsync` is available on the live server.
3. Confirm the full live theme path for the `winter` theme directory.
4. Back up the current live theme folder before the first automated deployment.
5. Add the deployment public key to the server user account.
6. Add the required GitHub repository secrets.
7. Test with a small change before relying on the workflow for normal releases.

Recommended backup command for SSH users:

```bash
cp -a /path/to/wp-content/themes/winter /path/to/wp-content/themes/winter-backup-$(date +%Y%m%d-%H%M%S)
```

Replace the placeholder path with the real live server path before running it.

## Values To Add As GitHub Secrets

Use these values in GitHub Actions after SSH is confirmed:

- `LIVE_HOST`: `webstudiowa.com.au`
- `LIVE_PORT`: `22`
- `LIVE_USER`: `webstud5`
- `LIVE_THEME_PATH`: `/home/webstud5/public_html/wp-content/themes/winter/`
- `LIVE_SSH_KEY`: private deployment SSH key, generated separately and never committed

Note:

- `LIVE_PORT` should only be set to `22` after confirming SSH is enabled on the hosting account.

## Required GitHub Secrets

Add these secrets in GitHub under `Settings -> Secrets and variables -> Actions`.

- `LIVE_HOST`: Live server hostname or IP address.
- `LIVE_PORT`: SSH port, usually `22`.
- `LIVE_USER`: SSH username used for deployment.
- `LIVE_SSH_KEY`: Private SSH key for the deploy user.
- `LIVE_THEME_PATH`: Full path to the live theme directory, for example `/home/USERNAME/public_html/wp-content/themes/winter/`.

Optional secrets:

- `LIVE_KNOWN_HOSTS`: Exact `known_hosts` entry for the live server. Recommended for stricter host verification.
- `DEPLOY_PATH`: Optional extra path note if you want to keep a separate secret for documentation or future workflows.

## Generate An SSH Key

Create a dedicated deploy key locally:

```bash
ssh-keygen -t ed25519 -C "github-actions-winter-deploy" -f ~/.ssh/winter_deploy
```

This creates:

- Private key: `~/.ssh/winter_deploy`
- Public key: `~/.ssh/winter_deploy.pub`

Keep the private key secret. Copy the contents of the private key file into the GitHub secret named `LIVE_SSH_KEY`.

## Add The Public Key On The Server

Add the contents of `~/.ssh/winter_deploy.pub` to the deploy user's `~/.ssh/authorized_keys` file on the live server.

Typical hosting control panel/server questions to confirm:

- Does the hosting account allow SSH?
- Which user owns the WordPress files?
- Does that user have write access to the theme directory?
- Is `rsync` installed?

## How To Add Secrets In GitHub

1. Open the GitHub repository.
2. Go to `Settings`.
3. Open `Secrets and variables`.
4. Open `Actions`.
5. Add each required secret exactly as named in this document.

## How Deployment Works

The workflow in `.github/workflows/deploy-theme.yml`:

1. Runs on pushes to `main`.
2. Installs Node.js dependencies with `npm ci`.
3. Builds the compiled CSS with `npm run build`.
4. Verifies the expected theme files exist.
5. Connects to the live server over SSH.
6. Uses `rsync --delete` to sync the theme folder contents to `${{ secrets.LIVE_THEME_PATH }}`.

The current workflow also supports a manual `workflow_dispatch` trigger in GitHub Actions for controlled runs after secrets have been configured.

Deployment exclusions include:

- `.git/`
- `.github/`
- `node_modules/`
- `.DS_Store`
- `*.log`
- `.env`
- `backups/`
- `backup/`
- `*.sql`
- `*.zip`
- `README.md`
- `docs/`
- build source files not needed on the server such as `assets/scss/`

## Test Deployment Safely

1. Back up the live theme folder.
2. Add all required secrets.
3. Make a small non-destructive change locally.
4. Run:

```bash
npm install
npm run build
```

5. Commit the change.
6. Push to `main`.
7. Watch the Actions run in GitHub.
8. Confirm the live site updated correctly.
9. Clear any WordPress/plugin/server/CDN cache if the change is not visible.

## Still Need To Confirm With Hosting

- Is SSH enabled for cPanel user `webstud5`?
- What is the SSH port?
- Does the server allow SSH key authentication?
- Is `rsync` available on the server?
- Can the `webstud5` user write to `/home/webstud5/public_html/wp-content/themes/winter/`?
- Is there a staging site available for safer testing?

## First Backup Command

Run this on the server before the first live deployment:

```bash
cp -a /home/webstud5/public_html/wp-content/themes/winter /home/webstud5/public_html/wp-content/themes/winter-backup-$(date +%Y%m%d-%H%M%S)
```

## SSH Test Commands

These checks help confirm SSH and `rsync` readiness:

```bash
ssh webstud5@webstudiowa.com.au
rsync --version
ls -la /home/webstud5/public_html/wp-content/themes/
```

## Roll Back

If the live deployment causes issues:

1. Restore the backup theme folder on the server.
2. Revert the Git commit locally or on GitHub.
3. Push the revert to `main` after the backup has been restored or after you are ready to redeploy.

If using SSH, rollback is usually easiest by restoring the backup copy created before the first automated deployment.

## SFTP Fallback

If SSH or `rsync` is not available, do not enable the current workflow yet.

Instead, confirm:

- SFTP-only access is available.
- The exact remote path is known.
- The hosting provider allows automated uploads.

At that point, create a separate SFTP-based workflow and keep it disabled until tested. Do not guess the provider-specific settings.

## If SSH Is Not Available

- The current SSH/`rsync` workflow cannot be used without SSH access.
- The existing SFTP/FTPS example workflow may need to be converted into an active workflow.
- FTP/FTPS deployment would require separate GitHub Secrets.
- If possible, create a dedicated FTP account for deployment rather than using the main cPanel password directly.

## Important Warnings

- Do not edit the live theme directly.
- Make changes locally, commit them, push them, and let GitHub Actions deploy them.
- Do not commit credentials, keys, database exports, backups, or environment files.
- Back up the live theme before the first automated deployment.
- Do not enable automated deletion on a live server until the first backup is confirmed.

## Troubleshooting

### Permission denied

- Confirm the deploy user is correct.
- Confirm the public key is in `authorized_keys`.
- Confirm the deploy user can write to the live theme directory.

### Host key verification failed

- Add `LIVE_KNOWN_HOSTS` in GitHub using the correct server fingerprint.
- If you rely on `ssh-keyscan`, confirm the hostname and port are correct.

### Wrong theme path

- Confirm the full live path to `wp-content/themes/winter/`.
- Confirm the path ends at the theme folder, not the themes parent folder.

### Build failed

- Run `npm ci` and `npm run build` locally first.
- Confirm `package-lock.json` matches `package.json`.

### CSS not updating

- Confirm `assets/css/main.css` was rebuilt.
- Confirm the deployed theme is the active theme in WordPress.
- Clear plugin cache, server cache, and CDN cache.

### WordPress cache or CDN cache

- Purge all caches after deployment.
- Re-test in a private browser window.

## Missing Details You Still Need To Confirm

Fill in these live server details before enabling deployment:
- Whether SSH access is available
- Whether `rsync` is available
- Hosting provider or server panel in use, such as cPanel, Plesk, Cloudways, SiteGround, or VentraIP
