# Resources hub

`page-resources.php` powers `/resources/` as Web Studio WA's clickable SEO resource hub. It has topic cards, 12 linked guide cards, a plugin CTA and a contact CTA.

## Article template

`page-resource-article.php` is a shared layout. `inc/resource-articles.php` exposes the starter content, excerpts, sections, checklists, related guides and internal CTAs. `inc/setup.php` automatically selects that layout for a recognised child page of Resources; no template needs to be chosen in the editor.

Use the safe page creator described in [create-resource-pages.md](create-resource-pages.md) to create these child pages. It skips existing pages without changing them:

- `/resources/how-to-check-who-can-edit-your-wordpress-website/`
- `/resources/why-wordpress-admin-access-should-be-reviewed-regularly/`
- `/resources/how-to-monitor-wordpress-404-errors-without-a-heavy-plugin/`
- `/resources/wordpress-admin-vs-editor-what-access-should-staff-have/`
- `/resources/how-to-reduce-risk-when-giving-website-access-to-contractors/`
- `/resources/wordpress-security-checklist-for-small-business-websites/`
- `/resources/how-to-find-images-missing-alt-text-in-wordpress/`
- `/resources/why-image-alt-text-matters-for-seo-and-accessibility/`
- `/resources/wordpress-image-seo-checklist-for-small-business-websites/`
- `/resources/why-instagram-and-facebook-feeds-stop-working-on-websites/`
- `/resources/how-to-add-social-feeds-to-wordpress-without-manual-tokens/`
- `/resources/meta-app-review-explained-for-wordpress-website-owners/`

The category strategy is WordPress Security, WordPress Maintenance, WordPress Plugins, SEO & Accessibility, Social Media Feeds and Website Care. Each guide links to an appropriate Admin Watch, SocialFeed, Plugins, maintenance or contact next step.

Run on GreenGeeks/cPanel Terminal:

    cd /home/webstud5/public_html
    php wp-content/themes/winter/tools/create-resource-pages.php

Then go to **WordPress Admin → Settings → Permalinks → Save Changes**.

## Menu suggestion

Add **Resources** to the Primary Menu. The recommended primary structure is Home, About, Services, WordPress Plugins (Admin Watch and SocialFeed), Resources, Hosting, Clients and Contact.
