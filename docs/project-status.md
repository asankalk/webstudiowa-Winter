# Winter Theme Project Status

## Current Status

This file lists what has already been completed in the `winter` theme repository and what still needs to be done before live deployment is fully ready.

Last known repository state:

- Branch: `main`
- Remote: `git@github.com:asankalk/webstudiowa-Winter.git`
- Deployment workflow added and pushed to GitHub
- Confirmed hosting environment details documented for Web Studio WA

## Completed

### Repository And Git Setup

- Confirmed the local theme folder is already a Git repository.
- Confirmed the current branch is `main`.
- Confirmed the Git remote points to `git@github.com:asankalk/webstudiowa-Winter.git`.
- Confirmed local changes were committed and pushed successfully.

### Theme Audit

- Scanned the theme folder structure.
- Confirmed the theme folder name is `winter`.
- Confirmed the WordPress theme name is `Winter`.
- Reviewed key files including `style.css`, `functions.php`, `package.json`, `package-lock.json`, `README.md`, `CHANGELOG.md`, `.gitignore`, and `theme.json`.
- Confirmed the build flow is:

```bash
npm install
npm run build
```

- Confirmed compiled CSS is expected to be committed because `assets/css/main.css` is tracked and used directly by the theme.

### Safety And Security Review

- Reviewed `.gitignore`.
- Added ignore rules for sensitive and unwanted files such as:
  - `.env`
  - `.env.*`
  - `node_modules/`
  - `vendor/`
  - `wp-config.php`
  - `*.sql`
  - backup folders
  - log files
  - private keys such as `id_rsa`, `*.pem`, and `*.key`
- Searched the theme repository for obvious committed secrets or credentials.
- No committed secrets were found in the theme repository during the scan.

### Deployment Pipeline

- Added GitHub Actions workflow:
  - `.github/workflows/deploy-theme.yml`
- Configured the workflow to:
  - trigger on push to `main`
  - support manual `workflow_dispatch`
  - run `npm ci`
  - run `npm run build`
  - validate key theme files
  - deploy via SSH and `rsync`
  - exclude unnecessary and sensitive files
- Added a disabled SFTP example workflow:
  - `.github/workflows/deploy-theme-sftp.yml.example`

### Documentation

- Updated `README.md` with deployment and versioning guidance.
- Updated `CHANGELOG.md` with deployment setup notes.
- Added deployment guide:
  - `docs/deployment.md`
- Added project status guide:
  - `docs/project-status.md`
- Documented confirmed non-secret Web Studio WA hosting details.

### PHP Check

- Ran PHP syntax linting across the theme.
- No PHP syntax errors were found in the theme files.

### Confirmed Hosting Details

- cPanel user: `webstud5`
- Primary domain: `webstudiowa.com.au`
- Shared IP: `107.6.176.102`
- Home directory: `/home/webstud5`
- Live theme path: `/home/webstud5/public_html/wp-content/themes/winter/`
- FTP server: `ftp.webstudiowa.com.au`
- FTP / explicit FTPS port: `21`
- Confirmed the preferred deployment path is still SSH + `rsync`, not FTP.

## Still To Do

### GitHub Secrets

These secrets still need to be added in GitHub Actions:

- `LIVE_HOST`
- `LIVE_PORT`
- `LIVE_USER`
- `LIVE_SSH_KEY`
- `LIVE_THEME_PATH`

Optional:

- `LIVE_KNOWN_HOSTS`
- `DEPLOY_PATH`

### Live Server Details To Confirm

These values are still missing and must be confirmed before enabling live deployment:

- SSH port
- Whether SSH access is available
- Whether `rsync` is available
- Whether SSH key authentication is allowed
- Whether the `webstud5` user can write to `/home/webstud5/public_html/wp-content/themes/winter/`
- Whether a staging site is available

### Pre-Deployment Safety Steps

- Back up the current live `winter` theme folder.
- Confirm the backup has been created successfully.
- Generate a dedicated SSH deploy key if not already created.
- Add the public deploy key to the server user account.
- Confirm the deploy user has write access to the live theme directory.
- Confirm the SSH port before setting `LIVE_PORT` to `22`.

### Deployment Testing

- Add the required GitHub secrets.
- Make a small safe theme change locally.
- Run:

```bash
npm install
npm run build
```

- Commit and push to `main`.
- Watch the GitHub Actions run.
- Confirm the live website updates correctly.
- Clear WordPress, server, and CDN caches if needed.

## Important Warnings

- Do not commit credentials, SSH keys, database exports, or backup archives.
- Do not edit the live theme directly if GitHub Actions deployment is being used.
- Do not enable automated deployment until the live path is confirmed.
- The workflow uses `rsync --delete`, so removed local files can also be removed from the live server.
- Do not rely on `rsync --delete` until the first live backup is confirmed.

## Suggested Next Actions

1. Collect the live server SSH and path details.
2. Confirm SSH is enabled for `webstud5` and verify the SSH port.
3. Back up the current live theme folder.
4. Add the GitHub secrets.
5. Test one small deployment to confirm the workflow behaves as expected.
6. Keep updating this file as tasks are completed.
