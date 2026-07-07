# Changelog

All notable changes to Winter from Web Studio WA are documented here.

## Unreleased

- Added GitHub Actions deployment workflow for build and SSH `rsync` deployment from `main`.
- Added deployment documentation covering secrets, SSH setup, backups, rollback, and troubleshooting.
- Hardened repository ignore rules to keep credentials, backups, logs, keys, and environment files out of Git.
- Added theme-level redirects for default WordPress remnant URLs that should not remain indexable.
- Added SEO indexing remediation documentation and manual Rank Math cleanup guidance.

## 1.0.2 - 2026-06-13

- Fixed launch button readability so primary and secondary buttons use blue backgrounds with white text.
- Reworked the footer into clean Company and Services link columns and removed contact details.
- Tightened desktop and mobile logo sizing.
- Made mobile navigation and dropdown backgrounds solid white for readability.
- Removed service detail number badges and improved client hover contrast.

## 1.0.1 - 2026-06-13

- Locked the production colour system to the Dodger Blue palette and removed the temporary colour switcher.
- Cleaned duplicate SEO output when Rank Math is active and added Rank Math title/description filters for core service pages.
- Added structured navigation data for Website Design, Website Redesign, Website Maintenance and Web Hosting sitelink targets.
- Added LCP image preloads for key page heroes.
- Removed unnecessary front-end block/global styles for the custom theme templates.
- Optimised local WebP image usage and tightened performance readiness.

## 1.0.0 - 2026-06-12

- Initial Winter theme release.
- Added responsive homepage for web design, maintenance, custom development and hosting services.
- Added ACF-powered editable homepage sections.
- Added Sass source and compiled production CSS.
- Added GitHub release-based WordPress theme update support.
