<?php
/**
 * Theme setup, assets and SEO helpers.
 *
 * @package WebStudioWA
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function () {
    load_theme_textdomain('winter', WSWA_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', [
        'height' => 80,
        'width' => 320,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    register_nav_menus([
        'primary' => __('Primary Menu', 'winter'),
        'footer' => __('Footer Menu', 'winter'),
    ]);
});

add_action('init', function () {
    register_post_type('wswa_client', [
        'labels' => [
            'name' => __('Clients', 'winter'),
            'singular_name' => __('Client', 'winter'),
            'add_new' => __('Add Client', 'winter'),
            'add_new_item' => __('Add New Client', 'winter'),
            'edit_item' => __('Edit Client', 'winter'),
            'new_item' => __('New Client', 'winter'),
            'view_item' => __('View Client', 'winter'),
            'search_items' => __('Search Clients', 'winter'),
            'not_found' => __('No clients found.', 'winter'),
            'not_found_in_trash' => __('No clients found in Trash.', 'winter'),
            'menu_name' => __('Clients', 'winter'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions'],
        'rewrite' => false,
    ]);
});

add_action('admin_init', function () {
    if (! current_user_can('edit_posts')) {
        return;
    }

    wswa_seed_default_clients();
});

add_action('customize_register', function (WP_Customize_Manager $wp_customize) {
    $wp_customize->add_section('winter_contact_details', [
        'title' => __('Web Studio WA Contact Details', 'winter'),
        'priority' => 160,
    ]);

    $wp_customize->add_setting('winter_business_phone', [
        'default' => '0470 442 762',
        'sanitize_callback' => 'winter_sanitize_business_phone',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('winter_business_phone', [
        'label' => __('Phone Number', 'winter'),
        'section' => 'winter_contact_details',
        'type' => 'text',
    ]);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('winter-style', WSWA_THEME_URI . '/assets/css/main.css', [], WSWA_VERSION);
    wp_enqueue_style('winter-custom', WSWA_THEME_URI . '/assets/css/custom.css', ['winter-style'], WSWA_VERSION);
    wp_enqueue_script('winter-main', WSWA_THEME_URI . '/assets/js/main.js', [], WSWA_VERSION, true);
});

add_action('wp_enqueue_scripts', function () {
    if (is_admin()) {
        return;
    }

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
}, 100);

add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
});

function wswa_preferred_public_origin(): string
{
    return 'https://webstudiowa.com.au';
}

function wswa_preferred_public_url(string $path = '/'): string
{
    return trailingslashit(wswa_preferred_public_origin()) . ltrim($path, '/');
}

function wswa_is_frontend_request(): bool
{
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
        return false;
    }

    if (defined('REST_REQUEST') && REST_REQUEST) {
        return false;
    }

    return true;
}

add_action('template_redirect', function () {
    if (! wswa_is_frontend_request()) {
        return;
    }

    $request_path = wp_parse_url(home_url(add_query_arg([], $GLOBALS['wp']->request ?? '')), PHP_URL_PATH);
    $normalized_path = trim((string) $request_path, '/');

    if ($normalized_path === 'hello-world' || $normalized_path === 'category/uncategorized') {
        wp_safe_redirect(wswa_preferred_public_url(), 301);
        exit;
    }
}, 0);

function wswa_seo_payload(): array
{
    $base_keywords = [
        'web design Perth',
        'website design Perth',
        'Perth web design agency',
        'WordPress web design Perth',
        'SEO friendly websites Perth',
        'website redesign Perth',
        'website maintenance Perth',
        'business web hosting Perth',
        'small business website design WA',
        'responsive website design',
        'custom web development Perth',
        'digital marketing Perth',
    ];

    $pages = [
        'front' => [
            'title' => 'Web Design Perth & Website Hosting WA | Web Studio WA',
            'description' => 'Web Studio WA creates responsive, SEO-friendly websites, WordPress redesigns, website maintenance and managed hosting for businesses across Perth and Western Australia.',
            'keywords' => $base_keywords,
        ],
        'about-us' => [
            'title' => 'About Web Studio WA | Perth Website Design Company',
            'description' => 'Learn about Web Studio WA, a Western Australia based website design, redesign, maintenance and hosting company supporting local businesses online.',
            'keywords' => array_merge($base_keywords, ['Western Australia web design company', 'Perth website designers']),
        ],
        'services' => [
            'title' => 'Website Design, Redesign & Maintenance Services Perth',
            'description' => 'Explore Web Studio WA services for custom website design, website redesign, WordPress maintenance, responsive builds and SEO-friendly website improvements in Perth.',
            'keywords' => array_merge($base_keywords, ['website services Perth', 'WordPress maintenance Perth']),
        ],
        'web-design' => [
            'title' => 'Web Site Design Perth | Responsive Website Design WA',
            'description' => 'Custom web site design in Perth for small businesses needing responsive layouts, clear messaging, SEO-friendly structure and professional WordPress builds.',
            'keywords' => array_merge($base_keywords, ['custom website design Perth', 'small business web design Perth']),
        ],
        'website-redesign' => [
            'title' => 'Website Redesign Perth | Modernise Your Business Website',
            'description' => 'Website redesign services in Perth to improve dated websites with stronger structure, mobile responsiveness, conversion paths and SEO-friendly content.',
            'keywords' => array_merge($base_keywords, ['website redesign agency Perth', 'modern website redesign Perth']),
        ],
        'website-maintenance' => [
            'title' => 'Website Maintenance Perth | WordPress Support WA',
            'description' => 'Website maintenance and WordPress support in Perth including content updates, plugin checks, security patches, backups and practical technical help.',
            'keywords' => array_merge($base_keywords, ['WordPress support Perth', 'website care plans Perth']),
        ],
        'web-hosting' => [
            'title' => 'Business Web Hosting Perth | Managed WordPress Hosting WA',
            'description' => 'Managed business web hosting packages through iWebNode for Web Studio WA clients, with WordPress support, migration help and friendly local assistance.',
            'keywords' => array_merge($base_keywords, ['managed WordPress hosting Perth', 'iWebNode hosting']),
        ],
        'our-clients' => [
            'title' => 'Our Clients | Web Design Portfolio Perth WA',
            'description' => 'View selected Web Studio WA client websites, redesigns and website maintenance work for Australian and Western Australian businesses.',
            'keywords' => array_merge($base_keywords, ['web design portfolio Perth', 'Perth website examples']),
        ],
        'contact' => [
            'title' => 'Contact Web Studio WA | Website Design Perth',
            'description' => 'Contact Web Studio WA, a Western Australia based company for web design, website redesign, WordPress maintenance and business web hosting.',
            'keywords' => array_merge($base_keywords, ['contact web designer Perth', 'website quote Perth']),
        ],
    ];

    if (is_front_page()) {
        return $pages['front'];
    }

    if (is_page()) {
        $slug = (string) get_post_field('post_name', get_queried_object_id());
        if (isset($pages[$slug])) {
            return $pages[$slug];
        }
    }

    $description = get_the_excerpt() ?: get_bloginfo('description');

    return [
        'title' => trim(get_the_title() . ' | ' . get_bloginfo('name')),
        'description' => $description,
        'keywords' => $base_keywords,
    ];
}

function wswa_rank_math_active(): bool
{
    return defined('RANK_MATH_VERSION') || function_exists('rank_math');
}

add_filter('rank_math/sitemap/exclude_post_type', function ($exclude, $type) {
    if ($type === 'post') {
        return true;
    }

    return $exclude;
}, 10, 2);

add_filter('rank_math/sitemap/exclude_taxonomy', function ($exclude, $type) {
    if ($type === 'category') {
        return true;
    }

    return $exclude;
}, 10, 2);

add_filter('rank_math/sitemap/enable_caching', '__return_false');

add_filter('pre_get_document_title', function ($title) {
    if (is_admin()) {
        return $title;
    }

    $payload = wswa_seo_payload();

    return $payload['title'] ?? $title;
}, 20);

function wswa_frontend_title(string $title): string
{
    if (is_admin()) {
        return $title;
    }

    $payload = wswa_seo_payload();

    return $payload['title'] ?? $title;
}

function wswa_frontend_description(string $description): string
{
    if (is_admin()) {
        return $description;
    }

    $payload = wswa_seo_payload();

    return $payload['description'] ?? $description;
}

add_filter('rank_math/frontend/title', 'wswa_frontend_title', 20);
add_filter('rank_math/frontend/description', 'wswa_frontend_description', 20);
add_filter('rank_math/opengraph/facebook/title', 'wswa_frontend_title', 20);
add_filter('rank_math/opengraph/facebook/description', 'wswa_frontend_description', 20);
add_filter('rank_math/opengraph/twitter/title', 'wswa_frontend_title', 20);
add_filter('rank_math/opengraph/twitter/description', 'wswa_frontend_description', 20);

add_action('wp_head', function () {
    if (! is_singular() && ! is_front_page()) {
        return;
    }

    if (wswa_rank_math_active()) {
        return;
    }

    $payload = wswa_seo_payload();
    $title = wp_strip_all_tags($payload['title'] ?? wp_get_document_title());
    $description = wp_strip_all_tags($payload['description'] ?? get_bloginfo('description'));
    $canonical = wp_get_canonical_url() ?: home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));

    if ($description) {
        printf('<meta name="description" content="%s">' . "\n", esc_attr($description));
    }

    printf('<link rel="canonical" href="%s">' . "\n", esc_url($canonical));
    printf('<meta property="og:title" content="%s">' . "\n", esc_attr($title));
    printf('<meta property="og:description" content="%s">' . "\n", esc_attr($description));
    printf('<meta property="og:type" content="%s">' . "\n", is_front_page() ? 'website' : 'article');
    printf('<meta property="og:url" content="%s">' . "\n", esc_url($canonical));
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

    if (is_front_page()) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => ['LocalBusiness', 'ProfessionalService'],
            'name' => 'Web Studio WA',
            'url' => home_url('/'),
            'email' => 'hello@webstudiowa.com.au',
            'telephone' => winter_get_business_phone_tel(),
            'areaServed' => [
                ['@type' => 'AdministrativeArea', 'name' => 'Western Australia'],
                ['@type' => 'City', 'name' => 'Perth'],
            ],
            'description' => $description,
            'knowsAbout' => $payload['keywords'],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Website services and hosting',
                'itemListElement' => [
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Web Site Design', 'url' => wswa_page_url('web-design')]],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Website Redesign', 'url' => wswa_page_url('website-redesign')]],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Web Site Maintenance', 'url' => wswa_page_url('website-maintenance')]],
                    ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Business Web Hosting', 'url' => wswa_page_url('web-hosting')]],
                ],
            ],
        ];

        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
    }
}, 1);

function wswa_sitelink_pages(): array
{
    return [
        'web-design' => [
            'name' => 'Website Design',
            'description' => 'Custom responsive website design for Perth and Western Australian businesses.',
        ],
        'website-redesign' => [
            'name' => 'Website Redesign',
            'description' => 'Modern website redesign services to improve structure, mobile usability and conversions.',
        ],
        'website-maintenance' => [
            'name' => 'Website Maintenance',
            'description' => 'WordPress maintenance, website care, updates and practical support.',
        ],
        'web-hosting' => [
            'name' => 'Web Hosting',
            'description' => 'Managed business web hosting packages through iWebNode and Web Studio WA support.',
        ],
    ];
}

add_action('wp_head', function () {
    if (! is_front_page()) {
        return;
    }

    $items = [];
    $position = 1;

    foreach (wswa_sitelink_pages() as $slug => $item) {
        $items[] = [
            '@type' => 'SiteNavigationElement',
            'position' => $position++,
            'name' => $item['name'],
            'description' => $item['description'],
            'url' => wswa_page_url($slug),
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => 'Web Studio WA primary services',
        'itemListElement' => $items,
    ]) . '</script>' . "\n";
}, 20);

add_action('wp_head', function () {
    $preload = '';

    if (is_front_page()) {
        $preload = wswa_image_url(wswa_get_field('hero_image'), wswa_asset('img/avrix-hero.webp'));
    } elseif (is_page('about-us')) {
        $preload = wswa_asset('img/avrix-about.webp');
    } elseif (is_page('web-hosting')) {
        $preload = wswa_asset('img/iwebnode-hosting-section.webp');
    } elseif (is_page(['web-design', 'website-redesign', 'website-maintenance'])) {
        $service = wswa_service_by_slug((string) get_post_field('post_name', get_queried_object_id()));
        $preload = $service['hero_image'] ?? '';
    }

    if ($preload) {
        printf('<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n", esc_url($preload));
    }
}, 2);

add_action('admin_notices', function () {
    if (! current_user_can('activate_plugins') || function_exists('acf_add_local_field_group')) {
        return;
    }

    echo '<div class="notice notice-warning"><p>';
    echo esc_html__('Web Studio WA theme uses Advanced Custom Fields. Install and activate ACF to edit homepage sections from the page editor.', 'winter');
    echo '</p></div>';
});

function wswa_core_pages(): array
{
    return [
        'home' => 'Home',
        'about-us' => 'About us',
        'services' => 'Services',
        'web-design' => 'Web Site Design',
        'website-redesign' => 'Website Redesign',
        'website-maintenance' => 'Web Site Maintenance',
        'web-hosting' => 'Web Hosting',
        'our-clients' => 'Our clients',
        'contact' => 'Contact',
    ];
}

function wswa_core_page_content(string $slug): string
{
    $content = [
        'home' => '<p>Web Studio WA creates responsive, SEO-friendly websites, custom web applications, ongoing website care and reliable hosting support for businesses across Western Australia.</p>',
        'about-us' => '<p>Web Studio WA is a Western Australia based web design and hosting support company helping local businesses build clear, modern and practical websites.</p><p>We focus on responsive website design, website redesign, WordPress maintenance and managed hosting support.</p>',
        'services' => '<p>Our services cover new website design, website redesign and practical website maintenance for small businesses that need a stronger online presence.</p>',
        'web-design' => '<p>Affordable, custom website design in Perth with responsive layouts, clear messaging and polished user experiences.</p>',
        'website-redesign' => '<p>Modernise an existing website with stronger structure, SEO-friendly content, mobile responsiveness and better conversion paths.</p>',
        'website-maintenance' => '<p>Keep your website secure and fresh with content updates, software maintenance, security patches and practical support.</p>',
        'web-hosting' => '<p>Managed hosting packages are purchased through iWebNode, the hosting platform used by Web Studio WA for client hosting and support.</p>',
        'our-clients' => '<p>View selected client websites, redesigns and website maintenance work completed by Web Studio WA.</p>',
        'contact' => '<p>Web Studio WA is a Western Australia based company. Use the contact form to send us your project details.</p>',
    ];

    return $content[$slug] ?? '';
}

function wswa_find_core_page(string $slug, string $title): ?WP_Post
{
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => ['publish', 'draft', 'pending', 'private', 'future'],
        'posts_per_page' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
    ]);

    $title_match = null;

    foreach ($pages as $page) {
        if ($page->post_name === $slug) {
            return $page;
        }

        if (! $title_match && strcasecmp($page->post_title, $title) === 0) {
            $title_match = $page;
        }
    }

    return $title_match;
}

function wswa_upsert_core_page(string $slug, string $title): int
{
    $page = wswa_find_core_page($slug, $title);
    $content = wswa_core_page_content($slug);

    if (! $page) {
        return (int) wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => $content,
        ]);
    }

    $updates = [
        'ID' => $page->ID,
        'post_title' => $title,
        'post_name' => $slug,
        'post_status' => 'publish',
    ];

    if (trim((string) $page->post_content) === '' && $content) {
        $updates['post_content'] = $content;
    }

    wp_update_post($updates);

    return (int) $page->ID;
}

function wswa_set_static_home_page(): void
{
    $home_id = wswa_upsert_core_page('home', 'Home');

    if ($home_id <= 0) {
        return;
    }

    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_id);
}

function wswa_ensure_core_pages(): void
{
    foreach (wswa_core_pages() as $slug => $title) {
        wswa_upsert_core_page($slug, $title);
    }

    wswa_set_static_home_page();
}

function wswa_core_pages_exist(): bool
{
    foreach (array_keys(wswa_core_pages()) as $slug) {
        if (! get_page_by_path($slug)) {
            return false;
        }
    }

    return true;
}

add_action('after_switch_theme', 'wswa_ensure_core_pages');
add_action('admin_init', function () {
    if (get_option('wswa_core_pages_ready') === WSWA_VERSION && wswa_core_pages_exist()) {
        return;
    }

    wswa_ensure_core_pages();
    update_option('wswa_core_pages_ready', WSWA_VERSION);
});

add_action('init', function () {
    if (get_option('wswa_core_pages_ready') === WSWA_VERSION && wswa_core_pages_exist()) {
        return;
    }

    wswa_ensure_core_pages();
    update_option('wswa_core_pages_ready', WSWA_VERSION);
}, 5);

function wswa_handle_contact_form(): void
{
    if (! isset($_POST['wswa_contact_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wswa_contact_nonce'])), 'wswa_contact')) {
        wp_safe_redirect(add_query_arg('contact', 'invalid', wp_get_referer() ?: wswa_page_url('contact')));
        exit;
    }

    $name = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $phone = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $service = sanitize_text_field(wp_unslash($_POST['service'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if (! $name || ! is_email($email) || ! $message) {
        wp_safe_redirect(add_query_arg('contact', 'missing', wp_get_referer() ?: wswa_page_url('contact')));
        exit;
    }

    $body = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nService: {$service}\n\nMessage:\n{$message}";
    $sent = wp_mail(
        wswa_get_field('contact_email'),
        sprintf('Website enquiry from %s', $name),
        $body,
        ['Reply-To: ' . $name . ' <' . $email . '>']
    );

    wp_safe_redirect(add_query_arg('contact', $sent ? 'sent' : 'error', wswa_page_url('contact')));
    exit;
}

add_action('admin_post_wswa_contact', 'wswa_handle_contact_form');
add_action('admin_post_nopriv_wswa_contact', 'wswa_handle_contact_form');
