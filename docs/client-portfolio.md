# Our Clients Portfolio

Last updated: 2026-10-19

## Implementation

The Our Clients page is rendered by `page-our-clients.php`. It calls `wswa_clients()` in `inc/helpers.php`, then outputs every card with the shared `portfolio-card` markup. The card design, responsive grid, dark information panel, hover overlay and thumbnail rules are in `assets/scss/main.scss`; `assets/css/main.css` is the committed production build output.

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

The base card CSS uses `object-fit: cover`. The image must therefore occupy the full source canvas with no empty margins and must not be stretched or distorted.

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
3. Add one record to `wswa_default_clients()` in `inc/helpers.php`. Use the canonical URL, category, exact approved copy, a full-preview alt attribute and `uses_snapshot => true` for screenshots.
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
- The portfolio copy, category, URL, image alt text, card markup, CSS, Origin image and every other client thumbnail remain unchanged.
