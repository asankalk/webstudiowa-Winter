# Admin Watch Central landing page

- **Template:** `page-admin-watch.php`
- **URL:** `/plugins/admin-watch/`
- **Official logo assets:** `assets/img/admin-watch/admin-watch-icon.png` and `assets/img/admin-watch/admin-watch-wordmark.png`
- **Hero visual:** `assets/img/admin-watch/admin-watch-team-dashboard.svg`

The landing page includes a plugin hero/dashboard placeholder, problem overview, features, screenshot placeholders, process, privacy positioning, audience, download links, FAQ, and CTA.

Public links:

- [WordPress.org](https://wordpress.org/plugins/adminwatch-central/)
- [Support forum](https://wordpress.org/support/plugin/adminwatch-central/)

The official Admin Watch logo assets were copied from the local Admin Watch plugin's `logos/` folder into the theme. Public GitHub links were removed because the repository is private. The hero uses the official icon in a compact product badge rather than a large floating wordmark card; its vertical padding and dashboard illustration are intentionally constrained for a balanced first screen. The five interface cards are populated CSS mini-dashboard visuals that can be replaced with product screenshots later. The Plugins index uses the official Admin Watch icon and the SocialFeed SVG logo.

The Plugins index uses an auto-fit grid: two plugins use two equal-width columns; three or more plugins use no more than three columns. It becomes two columns at tablet widths and one on mobile.

## WordPress admin setup

Create a page named **Admin Watch** with slug `admin-watch`, set its parent to **Plugins**, and publish. WordPress automatically applies `page-admin-watch.php` to `/plugins/admin-watch/`.
