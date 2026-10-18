# Our Clients Portfolio

Last updated: 2026-10-19

## Implementation

The Our Clients page is rendered by `page-our-clients.php`. It calls `wswa_clients()` in `inc/helpers.php`, then outputs every card with the shared `portfolio-card` markup. The card design, responsive grid, dark information panel, hover overlay and thumbnail rules are in `assets/scss/main.scss`; `assets/css/main.css` is the committed production build output.

Every website link uses `target="_blank"` with `rel="noopener"`. The image alt text must describe the website preview rather than repeat the project name alone.

`wswa_clients()` uses published `wswa_client` posts in WordPress when they exist, sorted by ascending `menu_order` and then ascending date. The hard-coded records returned by `wswa_default_clients()` are a resilient fallback and are merged into a populated client list only when the same normalised website URL is not already present. This prevents duplicate cards while allowing code-added defaults to appear on existing sites.

The current ordering is not newest-first: existing database-managed cards retain their menu order and any new fallback record is appended. Do not reorder existing cards merely to promote a new project. To make an installed site's client record display first, adjust that record's WordPress `menu_order` deliberately and verify it does not alter other client entries.

## Images and screenshot workflow

Client image assets are stored in `assets/img/` and named `client-<normalised-client-name>.webp`. Use a real current homepage capture, not a logo. Keep the original capture outside the repository.

For a full-page capture:

1. Confirm the client URL resolves to the current production site and visually inspect the capture before using it.
2. Capture a desktop viewport at 1440 px wide with a browser tool that supports a full-page screenshot.
3. Preserve the entire page without distortion. For a very tall page, resize proportionally and pad it to the 16:10 portfolio-card canvas instead of cropping the top or bottom.
4. Export as WebP at 1240 x 775 where that canvas suits the capture. The Applecross card used WebP quality 82 (`cwebp -q 82 -m 6`).
5. Inspect the encoded WebP and confirm the image is loaded through `wswa_asset()` with descriptive alt text and `uses_snapshot => true`.

The base card CSS uses `object-fit: cover`; a precomposed 16:10 canvas is therefore the preferred way to show a complete tall homepage without runtime distortion or unwanted crop.

## Adding a future client

1. Check `git status`, fetch the current `origin/main`, and create a dedicated `codex/` feature branch from it.
2. Verify the prospective website, make and inspect the full-page screenshot, then add the WebP under `assets/img/`.
3. Add one record to `wswa_default_clients()` in `inc/helpers.php`. Use the canonical URL, category, exact approved copy, a full-preview alt attribute and `uses_snapshot => true` for screenshots.
4. Do not edit the shared card markup or existing client records unless the requested change requires it. The template applies external-link behaviour uniformly.
5. Run `php -l inc/helpers.php`, `npm ci`, `npm run build`, `git diff --check`, and inspect `git diff --stat` / the staged diff. Check the responsive source rules: the portfolio is two columns above 980 px and one column at 980 px and below.
6. Commit the PHP, WebP and documentation; push the feature branch and open a pull request. Never merge the pull request without explicit approval because `.github/workflows/deploy-theme.yml` runs on pushes to `main`.

## 2026-10-19: Applecross Junior Cricket Club

- Added the `Applecross Junior Cricket Club` default portfolio record in `inc/helpers.php`.
- Added `assets/img/client-applecross-junior-cricket-club.webp` (1240 x 775, WebP quality 82), made from a verified full-page homepage capture taken 2026-10-19.
- The current live club homepage was available and showed the current club design, registration, fixtures and community content at capture time.
- This branch starts from `origin/main` commit `97bbdfb`; branch, commit, pull request, test evidence and deployment status are recorded in the accompanying Google Drive handover after the GitHub workflow completes.
- Deployment status: awaiting review and explicit approval; no merge or production deployment is authorised by this change.
