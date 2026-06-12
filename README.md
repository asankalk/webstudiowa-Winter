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

## Updates

Winter checks `https://github.com/asankalk/webstudiowa-Winter` for GitHub releases. Publish a release or tag such as `v1.0.1`, update `Version:` in `style.css`, and include release notes. WordPress will show the update in Dashboard > Updates and the release body appears as the changelog.

If the repository is private, installed sites need access to GitHub. Define `WINTER_GITHUB_TOKEN` in `wp-config.php` or provide the token with the `winter_github_token` filter.

Use a child theme for site-specific template edits. Content entered through ACF and normal WordPress settings is stored in the database and is preserved during theme updates.

## License

Winter is licensed under GPL-2.0-or-later. See `LICENSE`.

## Content Sources

Default copy and contact details were adapted from `https://webstudiowa.com.au/`.
Hosting plan names, prices and hosting feature copy were adapted from `https://iwebnode.com/`.
