# Web Studio WA development rules

All future development must pass mobile responsiveness testing before production deployment. Follow `docs/mobile-responsiveness.md` and its reusable checklist. Test all published pages at 320, 375, 390, 393, 414, 430, 768, 1024 and 1440px, including menu open/closed states. Run PHP/JS syntax checks, the Sass build and Chromium/WebKit responsive tests. Preserve branding, desktop design, business content, pricing, links and SEO metadata unless explicitly authorised. Document physical iPhone Safari verification honestly when unavailable.

Use the established GitHub Actions SSH deployment and its verified pre-deploy theme snapshot. Do not bypass failed checks, expose credentials or overwrite unrelated work. Keep GitHub documentation and the Google Drive technical handover current with dated causes, solutions and deployment evidence.
