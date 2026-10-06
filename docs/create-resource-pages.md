# Create Resources pages on GreenGeeks

The theme contains safe starter content in inc/resource-articles.php and uses page-resource-article.php for the 12 Resources child pages. The script only creates missing pages; it never deletes or overwrites an existing page or its content.

## Run once from cPanel Terminal

    cd /home/webstud5/public_html
    php wp-content/themes/winter/tools/create-resource-pages.php

The script will create the Resources parent page only when it is missing. It then checks each required URL beneath Resources, creates only missing child pages, assigns the resource article template, and prints each created or skipped item.

After it finishes, go to **WordPress Admin → Settings → Permalinks → Save Changes**. This refreshes rewrite rules without changing your selected permalink structure.

## Verify

1. Open /resources/.
2. Click every resource card.
3. Confirm all 12 article URLs open without a 404.
4. Confirm each page has the correct title, category, checklist and related CTA.

## Troubleshooting

- **File not found:** Confirm the deployed theme is at wp-content/themes/winter/ and run the command from /home/webstud5/public_html.
- **Article URL returns a 404:** Go to **Settings → Permalinks** and choose **Save Changes**.
- **A page already exists:** The script prints “Skipped” and leaves that page unchanged.
- **Editing content later:** The starter data is in inc/resource-articles.php (which normalises the existing resource content). Existing page editor content is deliberately not overwritten by the script.

## Adding a future guide

Add its data to the resource article dataset, then add a linked card on /resources/. Re-run the script: it will create only the new missing child page.
