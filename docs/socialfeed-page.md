# Web Studio WA plugin pages

- **Plugin index template:** `page-plugins.php` for `/plugins/`
- **SocialFeed template:** `page-socialfeed.php` for `/plugins/socialfeed/`
- **Logo:** `assets/img/socialfeed-logo.svg`

The plugin index includes a product-library hero, SocialFeed card, future-plugin note, and contact CTA. The SocialFeed page includes a product hero, feature overview, CSS-based plugin-interface screenshot placeholders, setup steps, client-website benefits, development status, FAQ, and support CTA. Replace the placeholders with real screenshots when they are available; no external images are used.

Related pages:

- `/plugins/socialfeed/terms/`
- `/plugins/socialfeed/privacy/`
- `/plugins/socialfeed/support/`

## WordPress admin setup

1. Go to **Pages → Add New** and create a parent page named **Plugins** with the slug `plugins` if it does not already exist. The theme automatically applies `page-plugins.php`.
2. Create a page named **SocialFeed** with the slug `socialfeed` and set **Parent** to **Plugins**. WordPress will create `/plugins/socialfeed/`.
3. The `page-socialfeed.php` template is selected automatically by the theme hierarchy; no template selection is needed.
4. Create the Terms, Privacy, and Support pages beneath SocialFeed as needed, using the slugs `terms`, `privacy`, and `support`.
5. Add **Plugins** or **WordPress Plugins** to the Primary Menu, add SocialFeed beneath it, and optionally nest Terms, Privacy, and Support under SocialFeed. The theme supports three menu levels.
