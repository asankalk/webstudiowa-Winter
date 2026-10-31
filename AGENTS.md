# Web Studio WA development rules

All future development must pass mobile responsiveness testing before production deployment. Follow `docs/mobile-responsiveness.md` and its reusable checklist. Test all published pages at 320, 375, 390, 393, 414, 430, 768, 1024 and 1440px, including menu open/closed states. Run PHP/JS syntax checks, the Sass build and Chromium/WebKit responsive tests. Preserve branding, desktop design, business content, pricing, links and SEO metadata unless explicitly authorised. Document physical iPhone Safari verification honestly when unavailable.

Use the established GitHub Actions SSH deployment and its verified pre-deploy theme snapshot. Do not bypass failed checks, expose credentials or overwrite unrelated work. Keep GitHub documentation and the Google Drive technical handover current with dated causes, solutions and deployment evidence.

## Hosting and migration documentation

The private [`asankalk/documentations`](https://github.com/asankalk/documentations) repository is the durable, cross-device source of truth for Web Studio WA hosting, DNS, email, integrations, deployment, backup, migration and troubleshooting records. For changes that affect those areas, update the relevant `web-studio-wa` documentation and its append-only changelog in the same review cycle, using `VERIFIED`, `HISTORICAL`, or `PENDING` evidence labels and never recording secret values. Do not change production DNS, mail routing, hosting targets, deployment secrets or migration state without explicit owner approval. Before a hosting migration, retain the current deployment destination until the replacement identity, path, host key, permissions, backup and dry-run evidence have been verified; keep `rsync --delete` disabled for a new destination until that gate is met.
