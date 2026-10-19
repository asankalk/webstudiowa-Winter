# Mobile responsiveness — permanent release standard

All future Web Studio WA development must pass mobile responsiveness testing before production deployment. Preserve business content, pricing, links, SEO metadata, branding and desktop presentation unless the task explicitly requires a change.

## Navigation

At widths up to 1100 CSS pixels, the primary navigation is a nonmodal disclosure. It starts closed. Every submenu starts collapsed; a separate 44 × 44 px button controls its `aria-expanded` state and `aria-controls` target. Parent anchors retain their normal destinations. Only one sibling branch opens at each level, so SocialFeed can open inside WordPress Plugins without closing its ancestor. Closing/reopening the menu resets all branches.

The hamburger, outside clicks, link activation, focus leaving the header and Escape close the menu. Escape inside an expanded branch first collapses that branch and restores focus to its toggle; Escape at the main toggle closes the navigation. Tab/Shift+Tab and Enter/Space use native link/button semantics. The disclosure does not trap focus or lock page scrolling. Overscroll containment keeps internal menu scrolling from chaining into the document where supported; normal page scrolling remains available outside the nonmodal panel.

Focus entering content closes the panel even in Safari, where mouse clicks need not focus buttons. JavaScript measures the real sticky header bottom rather than assuming an 82px logo height. The menu scrolls vertically within `100dvh`, with `100vh` fallback and bottom safe-area padding. Resize, scroll and visual viewport changes remeasure the available space. Desktop hover/focus flyouts remain available above 1100px. Match CSS and JavaScript breakpoints when updating navigation.

## Layout and touch standards

- Fix overflowing elements at their source. Do not hide document overflow to disguise layout errors. Grid/flex children must be allowed to shrink; text and long URLs must wrap. Keep intentional clipped decoration/marquee content contained locally.
- Shared action groups wrap with a 12px gap. At 640px and below they stack full width. Buttons have at least 44px height, flexible width, readable labels and visible focus states; preserve brand colours.
- Main content continues to collapse at 980px. Mobile headings scale down at 640px; the About hero must override its desktop-specific 300px minimum track. Contact cards, form controls, plugin mockups, prices and responsive images must fit at 320px.
- Contact Turnstile uses `data-size="compact"` (150px): the normal and flexible modes both require at least 300px and overflow the padded 320px form; see [Cloudflare widget sizes](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/widget-configurations/). Preserve nonce, honeypot and server-side verification. Do not submit real enquiries during a visual audit.
- Footer Company/Services remain two `minmax(0, 1fr)` columns up to 980px with the brand/description spanning both. Links provide 44px tap height, normal wrapping and consistent gaps. Below 300px, use one column. Preserve the desktop grid and dark gradient.
- CSS/JS enqueue versions use each asset's modification time. Do not bump `WSWA_VERSION` just to invalidate assets: it is also used by the core-page seeder.

## Automated checks

```sh
npm ci
npm run build
npx playwright install --with-deps chromium webkit
npm run test:responsive -- --local  # candidate CSS/JS against current published HTML
npm run test:responsive           # deployed live assets
npm run test:navigation -- --local # short-height / keyboard / parent links
npm run test:navigation           # repeat against deployed assets
node --check assets/js/main.js
find . -name '*.php' -not -path './node_modules/*' -print0 | xargs -0 -n1 php -l
git diff --check
```

`AUDIT_URL` defaults to the production origin. `AUDIT_OUTPUT` defaults to `/tmp/wswa-responsive`; use a directory outside the repository. The audit inventories published pages from the WordPress REST API, covers every page at 320, 375, 390, 393, 414, 430, 768, 1024 and 1440px in Chromium and WebKit, measures document width and rendered elements, checks closed/open navigation and footer columns on every page, and exercises the shared accordion hierarchy on Home. It saves page inventory, results and screenshots. Candidate mode substitutes local CSS/JS and the compact Turnstile attribute into otherwise live HTML; PHP lint is separate. This does not replace rendering newly changed PHP templates in WordPress.

The production Actions build runs these checks before the dependent SSH deployment job and preserves the audit artifact even on failure. Do not bypass failures. Device Safari is a separate check: Playwright WebKit is not physical iPhone Safari.

## Reusable change checklist

- [ ] Fetch latest main; preserve unrelated local changes; inspect the actual deployment workflow.
- [ ] Review each changed template plus Home, About, Clients, all service pages, Hosting, Resources and article pages, Plugins, AdminWatch, SocialFeed, Contact and legal/support pages.
- [ ] At every required width: no document overflow or unintended offscreen elements; logo/headings visible; paragraphs/URLs wrap; images, cards, prices and form controls fit.
- [ ] Menu starts closed; submenus start collapsed; test About, Services, Plugins and SocialFeed grandchildren; sibling accordion, real links, keyboard, Escape, outside click and focus exit work.
- [ ] Test short portrait/landscape heights, open-menu scrolling, last-link reachability, resizing across breakpoints and page scroll after closing.
- [ ] Support and other button groups have gaps and labels fit; footer shows aligned Company/Services columns; touch targets are comfortable.
- [ ] Inspect representative mobile/tablet/desktop screenshots; run syntax/build/browser checks and dependency audit.
- [ ] On a physical iPhone Safari, test expanded/collapsed browser controls, safe areas, orientation changes, menu scrolling and contact challenge. Record device/iOS version and result; explicitly identify unavailable device verification.
- [ ] Confirm a rollback point; merge the tested change; monitor both Actions jobs; verify live assets and affected pages; append evidence to GitHub and the technical handover.

## Deployment and rollback

Use `.github/workflows/deploy-theme.yml`, the existing main-triggered SSH/rsync workflow. The build job gates deployment on syntax/build and responsive tests. Production runs are serialized without cancellation. Immediately before rsync, the deploy job checks the existing winter theme, saves `$HOME/winter-deploy-backups/winter-<run-id>-<attempt>.tar.gz` on the server outside the web root, validates the archive and logs its SHA-256. Backup failure prevents rsync. This is a theme snapshot, not a database backup; this release does not change WordPress data. Existing WPvivid restore-point freshness has not been independently verified.

For code rollback, revert the release merge on main and push; the same checks and deployment run. For emergency restoration with authorised hosting SSH access, inspect the archive with `tar -tzf`, preserve the failed theme, then extract the recorded archive into the parent themes directory. Restore its original winter directory name and permissions, purge hosting/WordPress caches, verify Home/navigation/Contact, and reconcile Git with the restored code. Never guess the destination or restore database data for a CSS/JS rollback. Keep backups until the release is accepted; prune only under an agreed retention policy. Repository baseline for this release: `03f10d06611d2093643143fc480ffa58f3dfb32c`.

## 2026-10-19 — reported issues and corrective work

1. **Menu too long:** mobile CSS explicitly exposed every `.sub-menu`; JS only toggled the outer panel. No height/scroll limit existed and the 82px fixed top ignored the taller logo. Added per-level accordion buttons and ARIA, reset/close/keyboard logic, measured header position, dynamic viewport height and internal scrolling. Header switches at 1100px to avoid the crowded 1024px desktop row.
2. **Horizontal scrolling/clipping:** reproduced a 472px document at a 320px viewport. The support CTA row reached 472px and the contact card's intrinsic minimum widened the grid to 340px. Desktop About hero minimum tracks and fixed heading sizes were further narrow-screen risks. Added shrinkable grid children, wrapping text, scalable mobile headings, a specific single-track About override, compact Turnstile (its flexible mode still enforces a 300px minimum), form and card sizing. No document-level overflow suppression added.
3. **Website Support buttons touching/overflowing:** `.section__actions` lacked both gap and wrap. Added 12px gaps/wrapping and full-width mobile stacks, shared by other action groups, with flexible button sizing and minimum tap height.
4. **Footer long vertical sections:** the 640px rule collapsed the entire grid to one column. Retained two navigation columns with the brand spanning both, wrapped labels and 44px link height; exceptionally narrow fallback below 300px. Desktop gradient/content preserved.

Validation and final release evidence are appended after deployment. Build dependency audit also identified two pre-existing vulnerable transitive Sass dependencies; the lockfile updates immutable/source-map-js within existing allowed ranges and `npm audit` now reports zero vulnerabilities.

### Pre-deployment verification

The final candidate audit passed all **540 page/viewport/engine cases**: 30 published pages × 9 widths × Chromium/WebKit, zero failures. This includes all 12 requested main pages plus Services, 12 resource articles and five legal/support pages. The separate navigation suite passed in both engines at a 390 × 420 short viewport and desktop, covering actual internal scrolling, final-link reachability, keyboard activation/Escape, focus exit, resize reset, real parent links, desktop third-level flyout bounds, four CTA labels/heights/gaps and mobile footer columns. Representative screenshots were visually inspected. All 28 PHP files, JavaScript syntax, Sass build, clean npm install, dependency audit (zero vulnerabilities), workflow YAML/shell parsing and diff whitespace checks passed. Physical iPhone Safari remains unverified.

### Production release — 2026-10-19

Implementation `379290b9afe0eb88964aee9dc94bea75ee4a69ad` was merged through [PR #5](https://github.com/asankalk/webstudiowa-Winter/pull/5) as `f666827f4a2f782ba9905271a300d1d6641e0f36`. [GitHub Actions run 39192949308](https://github.com/asankalk/webstudiowa-Winter/actions/runs/39192949308) completed successfully, including 540/540 Ubuntu Chromium/WebKit candidate cases, both navigation suites, the verified backup and SSH/rsync deployment.

The original pre-release theme is archived outside the web root at `$HOME/winter-deploy-backups/winter-39192949308-1.tar.gz`; its verified SHA-256 is `abd18745bda05f508da94b86d1816c4326f8b392d21448945b3fed4fd3fbf6cc`. This archive and baseline `03f10d06611d2093643143fc480ffa58f3dfb32c` are the rollback points for the mobile UI release. A normal Git rollback is `git revert -m 1 f666827f4a2f782ba9905271a300d1d6641e0f36`, followed by the established main deployment; review the revert and verify the site. Emergency archive restore follows the procedure above.

Live verification with **no local asset substitution** passed all **540/540 cases** across the same 30 pages, nine widths and both engines. Both live navigation suites passed. Live main/custom CSS and JavaScript exactly matched the committed bytes; uncached and ordinary page HTML exposed numeric asset modification-time versions, and Contact rendered the compact challenge attribute. Mobile support-button and footer screenshots were inspected, including the fully loaded footer logo. No reproducible major issue remained in the tested browsers. Physical iPhone Safari remains the explicit manual verification limitation.

A small audit-only follow-up makes compact challenge substitution idempotent when testing pages that already contain the new attribute; it changes no production UI behaviour. The release record and handover preserve earlier history.
