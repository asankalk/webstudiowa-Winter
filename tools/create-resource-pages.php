<?php
/**
 * Create missing Resources pages without changing existing content.
 *
 * Run from the WordPress public_html directory:
 * php wp-content/themes/winter/tools/create-resource-pages.php
 */

if (PHP_SAPI !== 'cli') {
    exit("This script must be run from the command line.\n");
}

$public_root = dirname(__DIR__, 4);
$wp_load = $public_root . '/wp-load.php';
$theme_dir = dirname(__DIR__);

if (! file_exists($wp_load)) {
    exit("Error: wp-load.php was not found at {$wp_load}. Run this from the deployed Winter theme path.\n");
}

require_once $wp_load;

if (! defined('WSWA_THEME_DIR')) {
    define('WSWA_THEME_DIR', $theme_dir);
}

require_once $theme_dir . '/inc/helpers.php';
require_once $theme_dir . '/inc/resource-articles.php';

function wswa_resource_page_notice(string $message): void
{
    fwrite(STDOUT, $message . PHP_EOL);
}

$resources = get_page_by_path('resources', OBJECT, 'page');

if (! $resources) {
    $resources_id = wp_insert_post([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => 'Resources',
        'post_name' => 'resources',
        'post_content' => '',
    ], true);

    if (is_wp_error($resources_id)) {
        exit('Error: could not create Resources parent: ' . $resources_id->get_error_message() . PHP_EOL);
    }

    $resources = get_post((int) $resources_id);
    wswa_resource_page_notice('Created Resources parent page.');
} else {
    wswa_resource_page_notice('Skipped existing Resources parent page.');
}

foreach (wswa_get_resource_articles() as $slug => $article) {
    $path = 'resources/' . $slug;
    $existing = get_page_by_path($path, OBJECT, 'page');

    if ($existing && (int) $existing->post_parent === (int) $resources->ID) {
        wswa_resource_page_notice("Skipped existing article page: {$path}");
        continue;
    }

    $page_id = wp_insert_post([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => $article['title'],
        'post_name' => $slug,
        'post_parent' => (int) $resources->ID,
        'post_content' => '',
    ], true);

    if (is_wp_error($page_id)) {
        wswa_resource_page_notice("Error creating {$path}: " . $page_id->get_error_message());
        continue;
    }

    update_post_meta((int) $page_id, '_wp_page_template', 'page-resource-article.php');
    wswa_resource_page_notice("Created article page: {$path}");
}

wswa_resource_page_notice('Done. In WordPress Admin go to Settings → Permalinks and select Save Changes.');
