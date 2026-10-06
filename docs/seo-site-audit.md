# Web Studio WA SEO and marketing code audit

Audit date: 2026-10-07  
Scope: theme code, templates, local content structure and publicly configured routes. Search Console data was not available during this code audit. No traffic, impression, ranking, analytics or crawl statistics are asserted here.

## Executive summary

The theme has a sound local-service foundation: clear service routes, responsive templates, a structured Plugins section, a Resources hub and fallback metadata/schema logic. The highest return now comes from publishing the Resources pages, strengthening service-specific internal links, and using Search Console to validate indexing and demand rather than guessing.

## Priority score

| Priority | Finding | Recommended action |
| --- | --- | --- |
| Critical | Resource URLs need the safe creator run on production before the linked cards can resolve. | Run tools/create-resource-pages.php, then save permalinks. |
| High | Search performance and indexing coverage cannot be assessed without Search Console. | Verify ownership, sitemap, index coverage and URL inspection. |
| High | Service pages need an ongoing supporting-content and case-study programme. | Publish helpful guides and outcome-led client stories. |
| Medium | Local relevance can be strengthened through consistent Perth/WA proof and business-profile work. | Keep service wording locally relevant; maintain Google Business Profile. |
| Low | Rich-result enhancements should be validated rather than expanded blindly. | Test existing structured data and avoid duplicate SEO-plugin schema. |

## Current site structure review

The primary structure is clear: homepage, services, hosting, clients, Plugins, Resources and contact. The WordPress-managed menu supports three levels, including plugin children. Resources now acts as an internal-linking hub for Admin Watch, SocialFeed, maintenance and contact journeys.

## Homepage SEO review

The homepage has dedicated Perth/Western Australia metadata, LocalBusiness/ProfessionalService structured data and service-navigation markup. Keep the headline and first screen focused on the main commercial offer; use internal links to relevant service pages and avoid adding a large amount of generic copy above key conversion actions.

## Service pages SEO review

Service templates have a single H1, service-specific summaries, supporting imagery and enquiry CTAs. The next opportunity is unique proof: project outcomes, typical scope, local examples and FAQs for each service. Do not duplicate the same broad claims across every page.

## Plugin pages SEO review

Plugins and Admin Watch now have purpose-written titles and descriptions. Admin Watch is accurately positioned as visibility, review and privacy-conscious awareness; it must not be described as attack prevention or a replacement for a security suite. SocialFeed should continue to use cautious development-status wording.

## Resources and content hub SEO review

The hub has descriptive cards, categories, article routes, internal CTAs and reusable article layout. Each article has one H1, headings, checklist, relevant CTA and related-guide links. Publishing the missing child pages is the immediate dependency.

## Technical SEO review

The theme has title-tag support, canonical and description fallback output when Rank Math is inactive, Open Graph metadata, homepage local-business schema and preload handling for key hero imagery. Rank Math integration is present, so new schema should be tested for duplication before adding further JSON-LD. Confirm live robots.txt, XML sitemap, canonical host and HTTP redirect behaviour in Search Console and browser tools.

## Internal linking review

Current links connect Resources to Admin Watch, SocialFeed, Plugins, website maintenance and contact. Continue linking relevant service pages to Resources guides and client examples. Add contextual links only where they help the visitor; avoid footer-like lists of keyword links inside body copy.

## Conversion and lead-generation review

The contact CTA remains visible across key commercial routes. Plugins provide detail-page actions, while Admin Watch sends users to WordPress.org and support. Recommended next test: add a short, low-pressure access-review enquiry CTA on the Admin Watch page and measure qualified contact submissions, not just clicks.

## Content gap analysis

Prioritise published versions of the 12 starter guides, then add:

1. A practical WordPress maintenance checklist for Perth small businesses.
2. A guide to planning a website redesign without losing useful content.
3. A case-study format showing problem, approach, delivered pages and next steps.
4. A guide to choosing website hosting support for a business website.
5. A plain-language guide to website accessibility checks.

## Local SEO opportunities for Perth and Western Australia

Use genuine local details only: relevant project locations, service-area proof, local testimonials and consistent business contact details. Keep the Google Business Profile complete, choose accurate categories, respond to reviews, add current photos and link to the most relevant service page. Do not create doorway pages for suburbs without a distinct useful purpose.

## Google Search Console and Google Business Profile recommendations

1. Verify the preferred HTTPS property and submit the XML sitemap.
2. Use URL Inspection for the homepage, every service page, Plugins, Resources and selected articles after publishing.
3. Review Indexing, Page Experience and Core Web Vitals reports before prioritising performance work.
4. Review query/page patterns monthly to identify content opportunities; do not react to short-term fluctuations.
5. In Google Business Profile, keep name, phone, website URL, hours and service details consistent with the site.

## Immediate fixes completed in this task

- Replaced the awkward Admin Watch wordmark card with a compact official icon badge.
- Preserved local people-and-dashboard artwork and populated product interface visuals.
- Confirmed no public GitHub links exist in the Admin Watch template.
- Added dedicated SEO titles/descriptions for Plugins, Admin Watch and Resources.
- Confirmed the plugin grid caps at three columns and the responsive/mobile menu behaviour is preserved.
- Confirmed Resource cards use real article URLs and the article layout provides headings, checklists, related links and CTAs.

## Next recommended improvements

- Run the resource-page creation script on production and submit the resulting URLs for inspection.
- Review live metadata output with and without Rank Math active to ensure one title, description and canonical per page.
- Add real screenshots for Admin Watch and SocialFeed when available.
- Add a small number of genuine client outcome stories with clear consent.

## Future content plan

Publish the twelve prepared Resources guides in themed clusters: access and website care first, image accessibility second, then social-feed connection guides. Link each new guide from one relevant service/plugin page and one related guide. Review Search Console data after sufficient indexing time and expand only topics showing useful demand or conversion intent.

## SEO improvement pass completed

- Added contextual reading links from Admin Watch to access-review and security guides.
- Added SocialFeed links to social connection and Meta-permission guides.
- Added a Plugins-to-Resources route and a Website Maintenance route to Resources and Admin Watch.
- Added dedicated Google Search Console and Google Business Profile operating checklists.
- Kept the current Rank Math-aware metadata/schema safeguards; no duplicate JSON-LD was added.

## Resource creation dependency

The resource creator is ready but must be run on production before the twelve linked URLs can resolve. Run php wp-content/themes/winter/tools/create-resource-pages.php from /home/webstud5/public_html, then save permalinks.

## 30-day and 90-day action plan

**First 30 days:** create Resource pages, save permalinks, inspect priority URLs, submit the sitemap, and confirm one canonical/title/description per tested page.

**Within 90 days:** publish the guide clusters, add approved project evidence, review Search Console trends monthly, and improve pages based on verified query and conversion signals.

See docs/google-search-console-checklist.md and docs/google-business-profile-checklist.md for the live-tool and manual-business work.
