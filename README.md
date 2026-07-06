# Winter WordPress Theme

Winter is a modern responsive WordPress theme from Web Studio WA, using ACF-powered homepage sections, Sass and GitHub release-based updates.

## Setup

1. Activate the `Winter` theme in WordPress.
2. Activate `Advanced Custom Fields` from Plugins. The plugin has been installed at `wp-content/plugins/advanced-custom-fields`.
3. Create or edit the homepage and set it as the static front page in Settings > Reading.
4. Edit homepage sections from the page editor under `Homepage Sections`.

## Development

Run Sass builds from this theme directory:

```bash
npm install
npm run build
```

Source Sass lives in `assets/scss/main.scss`; compiled CSS is loaded from `assets/css/main.css`.
The compiled CSS file is committed to the repository and should remain committed because the live server only needs the built output.

## Deployment

Production deployment is designed to flow from local development to GitHub and then to the live WordPress server through GitHub Actions.

High-level flow:

`Local VS Code -> GitHub -> GitHub Actions -> Live WordPress theme folder`

The production branch is `main`. After GitHub Actions secrets are configured, pushes to `main` can build the theme and deploy it over SSH with `rsync`.

See [docs/deployment.md](docs/deployment.md) for the full setup guide, backup checklist, required secrets, rollback steps, and troubleshooting help.

## Updates

Winter checks `https://github.com/asankalk/webstudiowa-Winter` for GitHub releases. Publish a release or tag such as `v1.0.1`, update `Version:` in `style.css`, and include release notes. WordPress will show the update in Dashboard > Updates and the release body appears as the changelog.

If the repository is private, installed sites need access to GitHub. Define `WINTER_GITHUB_TOKEN` in `wp-config.php` or provide the token with the `winter_github_token` filter.

Use a child theme for site-specific template edits. Content entered through ACF and normal WordPress settings is stored in the database and is preserved during theme updates.

## Versioning And Releases

When you want to ship a new version:

1. Update the version number in `style.css`.
2. Update the matching version constant in `functions.php`.
3. Update the package version in `package.json` if you want the build metadata aligned.
4. Add release notes to `CHANGELOG.md`.
5. Run `npm install` if needed, then `npm run build`.
6. Commit the changes and push to GitHub.

Example:

```bash
git add .
git commit -m "Release Winter 1.0.3"
git push origin main
```

If you also use GitHub release-based theme updates for installed WordPress sites:

1. Create a Git tag such as `v1.0.3`.
2. Push the tag to GitHub.
3. Create a GitHub release from that tag.

Example:

```bash
git tag v1.0.3
git push origin v1.0.3
```

The difference between the two release paths:

- GitHub Actions deployment updates your own live server directly from `main`.
- GitHub release-based theme updates let installed WordPress sites detect and download a new packaged theme release.

For most day-to-day changes on your own server, push to `main` after testing locally. Use GitHub releases when you want WordPress sites to receive a formal versioned update.

## License

Winter is licensed under GPL-2.0-or-later. See `LICENSE`.

## Content Sources

Default copy and contact details were adapted from `https://webstudiowa.com.au/`.
Hosting plan names, prices and hosting feature copy were adapted from `https://iwebnode.com/`.
