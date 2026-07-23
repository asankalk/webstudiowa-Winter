# Project Context

Last updated: 2026-07-23

Contact form is hard-coded and protected with Cloudflare Turnstile, nonce, and honeypot. See `docs/form-audit.md`.

## Project Identity

- Theme name: Winter
- Theme folder name: `winter`
- Text domain: `winter`
- Repository: `git@github.com:asankalk/webstudiowa-Winter.git`
- Remote origin: `git@github.com:asankalk/webstudiowa-Winter.git`
- Current branch at scan time: `main`
- Live site: `https://webstudiowa.com.au`
- Live theme path: `/home/webstud5/public_html/wp-content/themes/winter/`

## Theme Folder Structure

Top-level theme files and folders currently in use:

```text
winter/
├── .github/workflows/deploy-theme.yml
├── assets/
│   ├── css/
│   │   ├── custom.css
│   │   └── main.css
│   ├── img/
│   ├── js/
│   │   └── main.js
│   └── scss/
│       └── main.scss
├── docs/
├── inc/
│   ├── acf.php
│   ├── helpers.php
│   ├── setup.php
│   └── updater.php
├── template-parts/
│   ├── front-home.php
│   └── service-detail.php
├── 404.php
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── page-about-us.php
├── page-contact.php
├── page-our-clients.php
├── page-services.php
├── page-web-design.php
├── page-web-hosting.php
├── page-website-maintenance.php
├── page-website-redesign.php
├── page.php
├── package.json
├── package-lock.json
├── style.css
└── theme.json
```

Notes:

- `design-mockups/` exists locally as an untracked workspace folder and is not part of the theme deployment path.
- `acf-json/` is referenced in code but was not present in the scanned folder at the time of this review.

## Build Process

Build tooling is Node-based and defined in `package.json`.

- Install dependencies: `npm install`
- Production asset build: `npm run build`
- Watch mode: `npm run watch`
- Build output: `assets/css/main.css`
- SCSS source: `assets/scss/main.scss`
- Sass compiler: `sass` from `devDependencies`

Commands were confirmed locally on 2026-07-20:

- `npm install` completed successfully
- `npm run build` completed successfully

## Compiled CSS Tracking And Deployment

Compiled CSS is tracked in Git and deployed.

- `assets/css/main.css` is a tracked file.
- `assets/css/custom.css` is a tracked file.
- The GitHub Actions deploy workflow excludes `assets/scss/` from deployment.
- The deploy workflow does not exclude `assets/css/`, so compiled CSS is what gets shipped to the live server.
- `custom.css` is loaded after `main.css` and is intended for small live-site overrides, but SCSS should still be treated as the primary source when broader style changes are needed.

## Deployment Workflow

Deployment flow:

1. Local changes are made in VS Code / Codex.
2. Changes are committed and pushed to `main`.
3. GitHub Actions runs `.github/workflows/deploy-theme.yml`.
4. Actions installs Node dependencies and runs `npm run build`.
5. Actions deploys the theme to the live server over SSH using `rsync`.
6. The live theme updates at `/home/webstud5/public_html/wp-content/themes/winter/`.

Workflow facts from `.github/workflows/deploy-theme.yml`:

- Triggered on pushes to `main`
- Can also be started manually with `workflow_dispatch`
- Uses Node.js 20
- Runs `npm ci`
- Runs `npm run build`
- Validates required files and directories before deploy
- Uses `webfactory/ssh-agent`
- Uses SSH host key setup with either `LIVE_KNOWN_HOSTS` or `ssh-keyscan`
- Deploys with `rsync -az --delete`

Deployment exclusions in the workflow:

- `.git/`
- `.github/`
- `node_modules/`
- `.DS_Store`
- log files
- `.env` files
- backup archives and SQL dumps
- `README.md`
- `docs/`
- `package.json`
- `package-lock.json`
- `assets/scss/`

Implications:

- Live deploys receive PHP templates, `inc/` files, images, JS, `style.css`, `theme.json`, and compiled CSS.
- Documentation does not deploy to production.
- Source SCSS does not deploy to production.
- `rsync --delete` means files removed from Git can also be removed on the live theme path.

## Live Server Details

Known non-secret hosting details:

- cPanel user: `webstud5`
- Domain: `webstudiowa.com.au`
- Home directory: `/home/webstud5`
- Live theme path: `/home/webstud5/public_html/wp-content/themes/winter/`
- Deployment transport: SSH + `rsync`
- Secret handling: host, port, user, SSH key, known hosts, and live path are supplied through GitHub Secrets

## Main Template Files

- `style.css`: WordPress theme header and version metadata
- `functions.php`: theme bootstrap, constants, and required `inc/` modules
- `header.php`: site header, brand, fallback navigation, header CTA, opens `<main>`
- `footer.php`: site footer, company/service links, closes `<main>`
- `front-page.php`: front-page entry point, loads `template-parts/front-home.php`
- `page.php`: generic page template
- `index.php`: fallback index template
- `404.php`: 404 page template

Primary page templates:

- `page-about-us.php`
- `page-services.php`
- `page-web-design.php`
- `page-website-redesign.php`
- `page-website-maintenance.php`
- `page-web-hosting.php`
- `page-our-clients.php`
- `page-contact.php`

Shared template parts:

- `template-parts/front-home.php`: homepage sections
- `template-parts/service-detail.php`: reusable service detail layout used by service pages

## Main SCSS, CSS, And JS Files

- SCSS source: `assets/scss/main.scss`
- Compiled CSS: `assets/css/main.css`
- Small override layer: `assets/css/custom.css`
- JavaScript: `assets/js/main.js`

`assets/js/main.js` currently handles:

- mobile menu toggle
- sticky/scrolled header state

## Header And Footer Structure

Header structure in `header.php`:

- logo image using `wswa_asset('img/web-studio-wa.webp')`
- fallback primary navigation built by `wswa_fallback_menu()`
- mobile menu toggle button
- header CTA linking to the contact page, hidden on the contact page itself

Footer structure in `footer.php`:

- reversed logo image
- company summary text
- company links column
- services links column
- bottom copyright row

## Homepage / Front Page Structure

`front-page.php` delegates to `template-parts/front-home.php`.

Main homepage sections:

- Hero
- Stats
- Intro
- Services
- Hosting
- Our Clients
- Why Web Studio WA
- Contact CTA

Content model:

- Homepage fields come from ACF when available.
- `wswa_get_field()` falls back to defaults in `wswa_defaults()` if ACF is unavailable or fields are empty.
- Featured client cards are pulled from the `wswa_client` custom post type through `wswa_clients()`.

## Services Section Files

Primary files:

- `template-parts/front-home.php`: homepage services grid
- `page-services.php`: all-services overview page
- `template-parts/service-detail.php`: shared service detail layout
- `page-web-design.php`
- `page-website-redesign.php`
- `page-website-maintenance.php`

Service data source:

- `wswa_services()` in `inc/helpers.php`

Current service slugs:

- `web-design`
- `website-redesign`
- `website-maintenance`

## Hosting / Pricing Section Files

Primary files:

- `template-parts/front-home.php`: homepage hosting teaser and plan cards
- `page-web-hosting.php`: dedicated hosting/packages page

Hosting data source:

- `wswa_hosting_plans()` in `inc/helpers.php`

Notes:

- Plans are hardcoded in PHP helper data, with ACF-backed homepage text fields around them.
- Purchase links currently point to iWebNode.

## Our Clients Section Files

Primary files:

- `template-parts/front-home.php`: homepage marquee / featured clients
- `page-our-clients.php`: full client portfolio grid
- `inc/setup.php`: custom post type registration for `wswa_client`
- `inc/acf.php`: client ACF fields
- `inc/helpers.php`: client seeding, lookup, and formatting helpers

Key client logic:

- `wswa_client` custom post type
- `wswa_seed_default_clients()`
- `wswa_clients()`
- `wswa_prepare_client()`
- `wswa_client_snapshot()`

Current design note:

- The current homepage client marquee and portfolio cards already use darker details areas with light text.
- Future card refinements should be reviewed visually before implementation.

## Contact / CTA / Footer Files

Primary files:

- `template-parts/front-home.php`: homepage contact CTA
- `page-contact.php`: contact form page
- `footer.php`: footer layout
- `inc/setup.php`: contact form handler
- `inc/helpers.php`: centralized phone helpers and fallback contact defaults

Contact handling:

- Form posts to `admin-post.php`
- Action: `wswa_contact`
- Handlers: `admin_post_wswa_contact` and `admin_post_nopriv_wswa_contact`
- Email destination comes from `wswa_get_field('contact_email')`

Phone handling:

- Customizer setting `winter_business_phone`
- Helper output via `winter_get_business_phone_link()`
- Tel formatting handled by `winter_get_business_phone_tel()`

## Customizer Files And Settings

Customizer registration lives in `inc/setup.php`.

Current customizer section:

- Section: `winter_contact_details`
- Setting: `winter_business_phone`
- Sanitizer: `winter_sanitize_business_phone()`

This is the current central source for the public business phone number and should be preferred over hardcoded phone strings in templates.

## ACF Usage

ACF is in active use if the plugin is installed.

Files:

- `inc/acf.php`

Behavior:

- Registers local ACF field groups in PHP
- Configures save/load paths for `acf-json`
- Gracefully falls back when ACF functions are unavailable

Field groups currently defined:

- `Homepage Sections`
- `Client Details`

Homepage ACF covers:

- hero content
- stats repeater
- intro text
- services heading text
- hosting heading text and features
- hosting plan summary fields
- clients title
- why items
- contact title, text, email, phone, address

Client ACF covers:

- project type
- website URL
- feature on homepage toggle

## Reusable Helper Functions

Important helper areas in `inc/helpers.php`:

- `wswa_asset()`: theme asset URL helper
- `wswa_get_field()`: ACF-aware field getter with default fallback
- `wswa_page_url()`: page lookup helper by slug
- `wswa_image_url()`: flexible image field resolver
- `wswa_services()`: services data source
- `wswa_service_by_slug()`: service lookup
- `wswa_hosting_plans()`: hosting plan data source
- `wswa_clients()`: client query/fallback provider
- `wswa_prepare_client()`: client card formatter
- `wswa_default_clients()`: seed data fallback
- `winter_get_business_phone()`: central phone getter
- `winter_get_business_phone_tel()`: tel-link formatter
- `winter_get_business_phone_link()`: clickable phone markup

Important setup/behavior functions in `inc/setup.php`:

- theme support and asset enqueue setup
- `wswa_preferred_public_origin()` and `wswa_preferred_public_url()`
- SEO metadata and Rank Math sitemap filters
- `wswa_ensure_core_pages()` and related page bootstrap helpers
- `wswa_handle_contact_form()`

Other important infrastructure:

- `inc/updater.php`: GitHub-based theme update integration

## Core Content Architecture Notes

- Navigation is currently rendered with `wswa_fallback_menu()` in `header.php`, even though menu locations are registered.
- Services and hosting plans are primarily data-driven from helpers, not custom post types.
- Client content is a custom post type with ACF support plus seeded fallback data.
- Homepage and some shared copy rely on ACF fields with PHP defaults as backup.
- Contact email/address fields are ACF-backed through `wswa_get_field()`.
- The business phone number is intended to be managed centrally through the Customizer.

## Important Project Rules

- Do not commit secrets.
- Do not hardcode server credentials.
- Do not edit the live theme directly.
- Use Customizer and ACF where appropriate for editable content.
- Prefer SCSS source files first when a style change belongs in the main theme styling system.
- Run `npm run build` after style changes that affect `assets/scss/main.scss`.
- Use `assets/css/custom.css` only for small targeted override work when appropriate.
- Run PHP lint if PHP is available.
- Check `git diff` before committing.
- Push to `main` only when ready for live deployment.
- Treat GitHub Actions deploys as live production deploys.
- Avoid removing files casually because `rsync --delete` can delete them on the live server too.

## Recent Known Changes And Working Assumptions

- The GitHub deployment pipeline has been tested and is working.
- A temporary footer deployment test marker was previously used during deployment verification.
- `docs/project-status.md` says that temporary footer marker was later cleaned up.
- PHP compatibility issues were addressed by updating the server PHP version.
- The business phone number should continue to be managed centrally through the Customizer and rendered with clickable `tel:` links.
- The Our Clients design direction may still be revisited, but mock-up-first review is preferred before production edits.
- Future design refresh work should be approved via mock-up first, then applied to the production theme.

## Validation Performed During This Review

Completed on 2026-07-20:

- scanned theme file structure
- reviewed `.github/workflows/deploy-theme.yml`
- confirmed `npm install`
- confirmed `npm run build`
- confirmed PHP CLI availability
- ran PHP lint across all theme PHP files with no syntax errors

## Open Notes / Possible Follow-up

- `acf-json/` is configured in code but was not present in the theme folder during this scan.
- If ACF field changes are made in wp-admin later, consider whether JSON sync should be added to version control.
- `design-mockups/` is currently untracked and should stay out of deploy commits unless intentionally added.
