# SocialFeed landing page

- **Template:** `page-socialfeed.php`
- **Logo:** `assets/img/socialfeed-logo.svg`
- **URL:** `/plugins/socialfeed/`

The page includes a product hero, feature overview, CSS-based plugin-interface screenshot placeholders, setup steps, client-website benefits, development status, FAQ, and support CTA. Replace the placeholder cards with real screenshots when they are available; no external images are used.

Related pages:

- `/plugins/socialfeed/terms/`
- `/plugins/socialfeed/privacy/`
- `/plugins/socialfeed/support/`

## WordPress admin setup

1. Go to **Pages → Add New** and create a parent page named **Plugins** with the slug `plugins` if it does not already exist.
2. Create a page named **SocialFeed** with the slug `socialfeed` and set **Parent** to **Plugins**. WordPress will create `/plugins/socialfeed/`.
3. The `page-socialfeed.php` template is selected automatically by the theme hierarchy; no template selection is needed.
4. Create the Terms, Privacy, and Support pages beneath SocialFeed as needed, using the slugs `terms`, `privacy`, and `support`.
5. Add SocialFeed to the WordPress Plugins menu as a child of WordPress Plugins, if required.
