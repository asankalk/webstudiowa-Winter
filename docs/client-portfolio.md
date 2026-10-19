# Our Clients Portfolio

Last updated: 2026-10-19

## Implementation

The Our Clients page is rendered by `page-our-clients.php`. It calls `wswa_clients()` in `inc/helpers.php`, resolves its curated image with `wswa_portfolio_preview()`, then outputs every card with the shared `portfolio-card` markup. The card design, responsive grid, dark information panel, hover overlay and thumbnail rules are in `assets/scss/main.scss`; `assets/css/main.css` is the committed production build output.

Every website link uses `target="_blank"` with `rel="noopener"`. The image alt text must describe the website preview rather than repeat the project name alone.

`wswa_clients()` uses published `wswa_client` posts in WordPress when they exist, sorted by ascending `menu_order` and then ascending date. The hard-coded records returned by `wswa_default_clients()` are a resilient fallback and are merged into a populated client list only when the same normalised website URL is not already present. This prevents duplicate cards while allowing code-added defaults to appear on existing sites.

The current ordering is not newest-first: existing database-managed cards retain their menu order and any new fallback record is appended. Do not reorder existing cards merely to promote a new project. To make an installed site's client record display first, adjust that record's WordPress `menu_order` deliberately and verify it does not alter other client entries.

## Images and screenshot workflow

Client image assets are stored in `assets/img/` and named `client-<normalised-client-name>.webp`. Use a real current homepage capture, not a logo. Keep the original capture outside the repository.

Use `client-origin-facility-services.webp` as the approved visual reference. Its header-and-hero desktop viewport fills the entire thumbnail canvas and is the standard for all website-preview images.

For a website-preview capture:

1. Confirm the client URL resolves to the current production site and visually inspect the capture before using it.
2. Capture the desktop viewport only—not the entire vertically scrolling homepage. Make the client header and hero prominent and readable.
3. Use the existing Origin Facility Services source dimensions and proportions: 1240 x 720. Resize proportionally from a matching desktop viewport; do not add side padding, letterboxing or a canvas around the website.
4. Export WebP at quality 82 (for example, `cwebp -q 82 -m 6`).
5. Inspect the encoded WebP and confirm the image is loaded through `wswa_asset()` with descriptive alt text and `uses_snapshot => true`.

The image link and image use a matching `1240 / 720` aspect ratio. The image fills 100% of its media container width and height, uses `object-fit: cover` with top alignment, and has no padding or mobile maximum-width cap. Its source must fill the entire canvas with no added blank margins, stretching or distortion. Natural whitespace in the captured website header is acceptable; added letterboxing is not.

### Permanent thumbnail quality-control checklist

- [ ] Compare the finished image side by side with `client-origin-facility-services.webp`.
- [ ] Confirm the source is a desktop viewport with a readable header and hero, not a full-page screenshot.
- [ ] Confirm the WebP is 1240 x 720 and contains no side padding, letterboxing, or unreadably small website content.
- [ ] Confirm no stretching, distorted proportions, or unintended crop of the header/hero.
- [ ] Inspect the finished card at desktop and mobile widths after scrolling it into view so `loading="lazy"` has completed.
- [ ] Confirm the image fills the card image area, while the existing rounded corners, hover state, card copy, links and other client assets are unchanged.

## Adding a future client

1. Check `git status`, fetch the current `origin/main`, and create a dedicated `codex/` feature branch from it.
2. Verify the prospective website, make and inspect a desktop-viewport screenshot using Origin Facility Services as the visual reference, then add the WebP under `assets/img/`.
3. Add one record to `wswa_default_clients()` in `inc/helpers.php`. Use the canonical URL, category, exact approved copy, a descriptive desktop-preview alt attribute and `uses_snapshot => true` for screenshots.
4. Do not edit the shared card markup or existing client records unless the requested change requires it. The template applies external-link behaviour uniformly.
5. Run `php -l inc/helpers.php`, `npm ci`, `npm run build`, `git diff --check`, and inspect `git diff --stat` / the staged diff. Check the responsive source rules: the portfolio is two columns above 980 px and one column at 980 px and below.
6. Commit the PHP, WebP and documentation; push the feature branch and open a pull request. Never merge the pull request without explicit approval because `.github/workflows/deploy-theme.yml` runs on pushes to `main`.

## 2026-10-19: Applecross Junior Cricket Club

- Added the `Applecross Junior Cricket Club` default portfolio record in `inc/helpers.php`.
- Added `assets/img/client-applecross-junior-cricket-club.webp` (initially 1240 x 775, WebP quality 82), made from a verified full-page homepage capture taken 2026-10-19.
- The current live club homepage was available and showed the current club design, registration, fixtures and community content at capture time.
- This branch starts from `origin/main` commit `97bbdfb`; branch, commit, pull request, test evidence and deployment status are recorded in the accompanying Google Drive handover after the GitHub workflow completes.
- Deployment status: awaiting review and explicit approval; no merge or production deployment is authorised by this change.

## 2026-10-19: Production deployment confirmed

- PR [#2](https://github.com/asankalk/webstudiowa-Winter/pull/2) was merged into `main` with merge commit `8f34746d2954b1cd5d90c834406c21feed8aa477` after explicit user approval.
- GitHub Actions run [#52](https://github.com/asankalk/webstudiowa-Winter/actions/runs/39166404322) completed successfully. Both the Build Theme job and the Deploy To Live Server SSH/rsync job passed.
- Live verification passed at `https://webstudiowa.com.au/our-clients/`: the portfolio contains six cards, including Applecross Junior Cricket Club. Its initial full-page WebP loaded with the expected descriptive alt text; all three card links use the intended HTTPS destination, `target="_blank"`, and `rel="noopener"`.
- Responsive verification passed: the live grid is two columns at a 1440 px viewport and one column at 390 px. The thumbnail was checked after scrolling it into view so its lazy-loaded image had completed.

## 2026-10-19: Applecross thumbnail correction

- The initial Applecross thumbnail was rejected because it proportionally shrank a full-page screenshot into a padded canvas. This left excessive blank side space and made the website content unreadably small.
- Replaced it with a 1240 x 720 WebP desktop-viewport capture showing the club header and hero. It uses the same full-canvas, readable header-and-hero approach as the approved Origin Facility Services thumbnail.
- The portfolio copy, category, URL, card markup, CSS, Origin image and every other client thumbnail remain unchanged. The Applecross alt text was subsequently corrected to identify it as a desktop website preview, rather than a full-page preview.


## Permanent desktop and mobile display requirement

Every client website thumbnail must visually fill its image container on both desktop and mobile. Do not reintroduce a fixed mobile image width, centred small image, logo tile, padding, letterboxing or a vertically compressed full-page capture. The dark information panels, titles, descriptions, categories, website URLs and card ordering must be preserved when updating previews.

- Keep the media area and `<img>` at the same 1240:720 ratio, `width: 100%`, `height: 100%`, zero padding and `object-fit: cover`; top alignment protects the website header. Matching source/container ratios avoid unwanted cropping or distortion.
- Use one portfolio column through 980px and two above it, with the existing 24px card gap and 24px rounded corners.
- Capture at 1240 × 720 CSS pixels and device scale 1, after visible hero images/fonts load. Capture the viewport directly, never pad/letterbox or squeeze a tall capture into a short canvas. Inspect video/slider heroes so a real rendered frame is visible.
- Encode the original-resolution capture with `cwebp -q 82 -m 6`; inspect the encoded image, not only the PNG. Compare it with Origin Facility Services, then inspect the rendered card at mobile and desktop widths. Do not enlarge a low-resolution logo or miniature screenshot.
- WordPress-managed clients can have a featured image or remote mshots screenshot that overrides the default record. For the six curated clients, `wswa_portfolio_preview()` selects the approved local asset by normalised website URL **only in the Our Clients template**. It changes only image/alt/snapshot presentation fields, leaving stored business copy, categories, URLs, order and homepage rendering alone. Unknown clients retain their existing configured image until a proper capture is added.
- Asset URLs include the local image modification time, so revised captures appear immediately rather than waiting for an old image cache. Keep approved source filenames in `assets/img/` and source PNGs outside Git.

### Required regression checks

```sh
php tests/portfolio-helper.php
npm run test:portfolio -- --local  # candidate CSS and local curated images over published markup
npm run test:portfolio           # deployed HTML and assets, without substitutions
npm run test:responsive -- --local
npm run test:navigation -- --local
npm run build
```

The portfolio audit covers all six cards at 320, 375, 390, 393, 414, 430, 768, 1024 and 1440px in Chromium and WebKit. It verifies loaded 1240 × 720 sources, full image/container width and height, the shared ratio, no image padding, cover fit, preserved external-link attributes, dark panels, columns, card gap and no horizontal page overflow. It captures full-page and individual mobile-card screenshots. Candidate mode executes the isolated PHP preview contract (including stored-content and unknown-client preservation), then substitutes its resulting image URLs/local assets over current published markup; actual WordPress rendering is verified after deployment. The GitHub production build runs this audit before SSH deployment alongside the site-wide mobile checks.

### Thumbnail release checklist

- [ ] Inspect original and encoded captures next to Origin; reject logo tiles, blurry upscales, blank side margins and compressed full pages.
- [ ] Complete lazy loading and verify every card image fills its media box at all required widths.
- [ ] Confirm the six client identities, business text, categories, order, external destinations, target/rel attributes, dark panel styling and rounded corners remain intact.
- [ ] Verify one mobile/tablet column, two desktop columns, uniform aspect ratio and 24px card spacing.
- [ ] Run the portfolio contract/browser tests, global mobile gate, PHP/JS syntax, Sass build and diff checks.
- [ ] On physical iPhone Safari, confirm loaded previews, orientation and no horizontal dragging; record unavailable device testing explicitly rather than claiming it.
- [ ] Deploy through the established Actions workflow with a verified theme backup; record commit, workflow result and live mobile/desktop verification here and in the technical handover.

## 2026-10-19 — full-width mobile thumbnail correction

**Causes:** the 640px media query set every `.portfolio-card img` to `max-width: 190px` with automatic side margins, shrinking even valid Origin/Applecross captures. The general image rule also padded non-snapshot images by 30px and used contain fit. Its 16:10 image box differed from the approved 1240:720 sources. The first four published WordPress records selected remote mshots screenshots; their local fallback WebPs were low-resolution logo tiles with substantial blank canvas. Replacing those files alone would not change the published card images.

**Changes:** removed the mobile cap/centering and padded contain presentation. The media link and image now share the exact desktop-viewport aspect ratio with full-width/full-height cover fit and top alignment. Captured fresh 1240 × 720 website viewports for Vending WA, Pretium Group, Pretium Funding and HP Debt Solutions on 19 October 2026; inspected and encoded WebP at quality 82/method 6. Retained the already suitable Origin Facility Services and Applecross desktop captures. Added the portfolio-only curated preview lookup and image cache versions so all six published cards use the approved sources, including WordPress-managed records. Original card copy, categories, destinations, order, dark panels, hover treatment, rounded corners and grid spacing are preserved.

**Verification:** source screenshots and encoded WebPs were visually inspected against Origin. The isolated PHP preview contract and the 18 Chromium/WebKit viewport cases passed, checking all 108 image/viewport combinations. Site-wide checks and deployment/live evidence are recorded below after release.

The pre-deployment site-wide audit also passed all 540 cases across 30 published pages, nine widths and both engines; both navigation suites passed. All 29 PHP files, JavaScript syntax, clean install, Sass build, workflow parsing, dependency audit (zero vulnerabilities) and diff whitespace checks passed. The candidate test exercises the PHP preview contract and local CSS/image substitutions; final WordPress HTML and assets are verified live after deployment.
