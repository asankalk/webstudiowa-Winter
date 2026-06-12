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
    wp_enqueue_style('winter-style', WSWA_THEME_URI . '/assets/css/main.css', [], WSWA_VERSION);
    wp_enqueue_script('winter-main', WSWA_THEME_URI . '/assets/js/main.js', [], WSWA_VERSION, true);
});

add_action('wp_head', function () {
    if (! is_singular()) {
        return;
    }

    $description = get_the_excerpt();
    if (! $description && function_exists('get_field')) {
        $description = wswa_get_field('hero_text');
    }
    $description = $description ?: get_bloginfo('description');

    if ($description) {
        printf('<meta name="description" content="%s">' . "\n", esc_attr(wp_strip_all_tags($description)));
    }

    if (is_front_page()) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => 'Web Studio WA',
            'url' => home_url('/'),
            'email' => 'hello@webstudiowa.com.au',
            'telephone' => '0410 930 327',
            'areaServed' => 'Western Australia',
            'description' => 'Web design, development, website maintenance and hosting services for Western Australian businesses.',
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

