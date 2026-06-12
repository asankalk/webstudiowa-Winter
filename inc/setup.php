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

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('winter-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', [], null);
    wp_enqueue_style('winter-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css', [], '7.0.1');
    wp_enqueue_style('winter-style', WSWA_THEME_URI . '/assets/css/main.css', [], WSWA_VERSION);
    wp_enqueue_style('winter-custom', WSWA_THEME_URI . '/assets/css/custom.css', ['winter-style'], WSWA_VERSION);
    wp_enqueue_script('winter-main', WSWA_THEME_URI . '/assets/js/main.js', [], WSWA_VERSION, true);
});

function wswa_style_switcher_enabled(): bool
{
    $enabled = ! defined('WSWA_DISABLE_STYLE_SWITCHER') || ! WSWA_DISABLE_STYLE_SWITCHER;

    return (bool) apply_filters('wswa_style_switcher_enabled', $enabled);
}

add_action('wp_head', function () {
    if (! wswa_style_switcher_enabled()) {
        return;
    }

    echo "<script>(function(){try{var p=localStorage.getItem('wswaPalette');if(p){document.documentElement.setAttribute('data-palette',p);}}catch(e){}}());</script>\n";
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

add_filter('pre_get_document_title', function ($title) {
    if (is_admin()) {
        return $title;
    }

    $payload = wswa_seo_payload();

    return $payload['title'] ?? $title;
}, 20);

add_action('wp_head', function () {
    if (! is_singular() && ! is_front_page()) {
        return;
    }

    $payload = wswa_seo_payload();
    $title = wp_strip_all_tags($payload['title'] ?? wp_get_document_title());
    $description = wp_strip_all_tags($payload['description'] ?? get_bloginfo('description'));
    $keywords = implode(', ', array_unique($payload['keywords'] ?? []));
    $canonical = wp_get_canonical_url() ?: home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));

    if ($description) {
        printf('<meta name="description" content="%s">' . "\n", esc_attr($description));
    }

    if ($keywords) {
        printf('<meta name="keywords" content="%s">' . "\n", esc_attr($keywords));
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
            'telephone' => '0410 930 327',
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

function wswa_ensure_core_pages(): void
{
    foreach (wswa_core_pages() as $slug => $title) {
        if (get_page_by_path($slug)) {
            continue;
        }

        wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => '',
        ]);
    }
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
