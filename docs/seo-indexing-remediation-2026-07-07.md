# Web Studio WA SEO Indexing Remediation

## Original Issue Summary

Google Search Console indexing review showed the main service pages were generally healthy, but default WordPress remnant URLs and sitemap bloat were still creating avoidable indexing noise.

Preferred canonical host:

`https://webstudiowa.com.au/`

## Audit Findings

Healthy public pages that should remain indexable:

- `https://webstudiowa.com.au/`
- `https://webstudiowa.com.au/about-us/`
- `https://webstudiowa.com.au/services/`
- `https://webstudiowa.com.au/web-design/`
- `https://webstudiowa.com.au/website-redesign/`
- `https://webstudiowa.com.au/website-maintenance/`
- `https://webstudiowa.com.au/web-hosting/`
- `https://webstudiowa.com.au/our-clients/`
- `https://webstudiowa.com.au/contact/`

Problem URLs identified:

- `https://webstudiowa.com.au/hello-world/`
- `https://webstudiowa.com.au/category/uncategorized/`

Additional findings:

- The repository is a custom theme-only repo, not a full WordPress install.
- Rank Math is active on the live site, but its settings are not stored in this repository.
- No `.htaccess` or Nginx config is versioned in this repo, so redirect fixes must be handled safely in WordPress theme code.
- Live homepage and service pages currently show a single canonical tag and standard indexable robots meta output.
- The live author archive `https://webstudiowa.com.au/author/admin/` is already `noindex`.
- The live sitemap index currently includes:
  - `post-sitemap.xml`
  - `page-sitemap.xml`
  - `category-sitemap.xml`

## Files Changed

- `inc/setup.php`
- `docs/seo-indexing-remediation-2026-07-07.md`
- `docs/project-status.md`
- `CHANGELOG.md`

## Redirects Added

Added theme-level `301` redirects for:

- `/hello-world/` -> `/`
- `/category/uncategorized/` -> `/`

Implementation notes:

- Redirects are handled in `template_redirect`.
- This avoids admin, AJAX, cron, and REST requests.
- Redirects are single-hop and point directly to `https://webstudiowa.com.au/`.

## Canonical And Host Consistency

Code audit results:

- No hardcoded `http://webstudiowa.com.au`
- No hardcoded `http://www.webstudiowa.com.au`
- No hardcoded `https://www.webstudiowa.com.au`
- Theme fallback canonical output exists, but only runs when Rank Math is not active.
- Live public pages tested showed one canonical tag each.

Live host behavior before remediation:

- `https://www.webstudiowa.com.au/` already redirects to `https://webstudiowa.com.au/`
- `http://webstudiowa.com.au/` already redirects to `https://webstudiowa.com.au/`

Because that host normalization is already being handled upstream, no extra server-host redirect logic was added in theme code.

## Rank Math And Manual WordPress Admin Steps

These items cannot be safely completed from this theme repo because they are controlled in the live WordPress database and Rank Math settings:

### Rank Math SEO > Sitemap Settings

- Disable Posts sitemap if the site is not using blog posts.
- Disable Categories sitemap if category archives are not part of the SEO strategy.

### Rank Math SEO > Titles & Meta

- Keep Author Archives set to `noindex`.
- Set Category Archives to `noindex` if category archives remain enabled for any reason.

### WordPress Content Cleanup

- Delete, trash, or unpublish the default `Hello World` post in WordPress admin.
- Confirm no important content relies on the default `Uncategorized` category archive.

### WordPress User/Profile Or Schema Source Cleanup

If any profile or schema settings still reference an old host in the database:

- Update admin user profile website URL to `https://webstudiowa.com.au/`
- Update any Rank Math business/schema profile URL source to `https://webstudiowa.com.au/`

## Testing Performed

### Code And Local Checks

- Searched the repository for:
  - duplicate canonical logic
  - hardcoded noindex output
  - old `http://` and `www` host references
  - internal links to `/hello-world/`
  - internal links to `/category/uncategorized/`
- Verified the repo contains no server config files for redirects.
- Verified the live deployment workflow deploys from `main`.

### Live Checks Before Deployment

Observed before code remediation:

- `curl -I https://webstudiowa.com.au/` -> `200`
- `curl -I https://www.webstudiowa.com.au/` -> single redirect to `https://webstudiowa.com.au/`
- `curl -I http://webstudiowa.com.au/` -> single redirect to `https://webstudiowa.com.au/`
- `curl -I https://webstudiowa.com.au/hello-world/` -> `200`
- `curl -I https://webstudiowa.com.au/category/uncategorized/` -> `200`

Also confirmed:

- Homepage has one canonical tag.
- `/services/` has one canonical tag.
- `/author/admin/` currently outputs `follow, noindex`.

### Local Validation To Run Before Merge/Deployment

Run:

```bash
npm install
npm run build
find . -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Deployment Status

Current branch for remediation work:

`fix/webstudiowa-indexing-cleanup`

Important:

- The existing GitHub Actions deployment pipeline deploys from `main`.
- This remediation branch should be validated first.
- Merge or push to `main` only after checks are complete and deployment is intended.

## Post-Deployment Validation

After deployment, run:

```bash
curl -I https://webstudiowa.com.au/hello-world/
curl -I https://webstudiowa.com.au/category/uncategorized/
curl -I https://webstudiowa.com.au/
curl -I https://webstudiowa.com.au/services/
curl -I https://webstudiowa.com.au/web-design/
curl -I https://webstudiowa.com.au/web-hosting/
curl -I https://webstudiowa.com.au/contact/
```

Expected:

- `/hello-world/` returns a single-hop `301` to `https://webstudiowa.com.au/`
- `/category/uncategorized/` returns a single-hop `301` to `https://webstudiowa.com.au/`
- Core public pages return `200`
- Core public pages have one self-referencing canonical
- Core public pages do not output `noindex`

## Google Search Console Validation Steps

1. Open URL Inspection.
2. Test:
   - `https://webstudiowa.com.au/hello-world/`
   - `https://webstudiowa.com.au/category/uncategorized/`
   - `https://webstudiowa.com.au/`
   - `https://webstudiowa.com.au/services/`
   - `https://webstudiowa.com.au/web-design/`
3. Confirm old URLs redirect and important pages are indexable.
4. Resubmit sitemap if sitemap configuration changed in Rank Math.
5. Click Validate Fix for:
   - Duplicate, Google chose different canonical than user
   - Page with redirect
   - Not found 404
   - Excluded by noindex tag
   - Crawled - currently not indexed

## Anything That Could Not Be Completed From Code

- Deleting or unpublishing the default Hello World post
- Changing Rank Math sitemap settings
- Disabling post/category sitemaps in Rank Math
- Confirming all schema/profile URLs stored in the database
- Verifying sitemap cleanup after Rank Math settings are changed
