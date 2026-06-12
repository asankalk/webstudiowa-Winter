<?php
/**
 * ACF local fields.
 *
 * @package WebStudioWA
 */

if (! defined('ABSPATH')) {
    exit;
}

add_filter('acf/settings/save_json', fn () => WSWA_THEME_DIR . '/acf-json');
add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = WSWA_THEME_DIR . '/acf-json';
    return $paths;
});

add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_wswa_home',
        'title' => 'Homepage Sections',
        'fields' => [
            ['key' => 'field_wswa_hero_tab', 'label' => 'Hero', 'type' => 'tab'],
            ['key' => 'field_wswa_hero_eyebrow', 'label' => 'Eyebrow', 'name' => 'hero_eyebrow', 'type' => 'text'],
            ['key' => 'field_wswa_hero_title', 'label' => 'Title', 'name' => 'hero_title', 'type' => 'text'],
            ['key' => 'field_wswa_hero_text', 'label' => 'Text', 'name' => 'hero_text', 'type' => 'textarea', 'rows' => 4],
            ['key' => 'field_wswa_hero_image', 'label' => 'Hero Image', 'name' => 'hero_image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium'],
            ['key' => 'field_wswa_hero_primary_label', 'label' => 'Primary Button Label', 'name' => 'hero_primary_label', 'type' => 'text'],
            ['key' => 'field_wswa_hero_primary_url', 'label' => 'Primary Button URL', 'name' => 'hero_primary_url', 'type' => 'url'],
            ['key' => 'field_wswa_hero_secondary_label', 'label' => 'Secondary Button Label', 'name' => 'hero_secondary_label', 'type' => 'text'],
            ['key' => 'field_wswa_hero_secondary_url', 'label' => 'Secondary Button URL', 'name' => 'hero_secondary_url', 'type' => 'url'],
            [
                'key' => 'field_wswa_stats',
                'label' => 'Stats',
                'name' => 'stats',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add stat',
                'sub_fields' => [
                    ['key' => 'field_wswa_stat_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text'],
                    ['key' => 'field_wswa_stat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'],
                ],
            ],
            ['key' => 'field_wswa_content_tab', 'label' => 'Content', 'type' => 'tab'],
            ['key' => 'field_wswa_intro_title', 'label' => 'Intro Title', 'name' => 'intro_title', 'type' => 'text'],
            ['key' => 'field_wswa_intro_text', 'label' => 'Intro Text', 'name' => 'intro_text', 'type' => 'textarea', 'rows' => 4],
            ['key' => 'field_wswa_services_title', 'label' => 'Services Title', 'name' => 'services_title', 'type' => 'text'],
            ['key' => 'field_wswa_services_text', 'label' => 'Services Text', 'name' => 'services_text', 'type' => 'textarea', 'rows' => 3],
            [
                'key' => 'field_wswa_services',
                'label' => 'Services',
                'name' => 'services',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add service',
                'sub_fields' => [
                    ['key' => 'field_wswa_service_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                    ['key' => 'field_wswa_service_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 3],
                    ['key' => 'field_wswa_service_number', 'label' => 'Number', 'name' => 'number', 'type' => 'text'],
                ],
            ],
            ['key' => 'field_wswa_hosting_tab', 'label' => 'Hosting', 'type' => 'tab'],
            ['key' => 'field_wswa_hosting_title', 'label' => 'Hosting Title', 'name' => 'hosting_title', 'type' => 'text'],
            ['key' => 'field_wswa_hosting_text', 'label' => 'Hosting Text', 'name' => 'hosting_text', 'type' => 'textarea', 'rows' => 3],
            [
                'key' => 'field_wswa_hosting_features',
                'label' => 'Hosting Features',
                'name' => 'hosting_features',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add feature',
                'sub_fields' => [
                    ['key' => 'field_wswa_hosting_feature_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                    ['key' => 'field_wswa_hosting_feature_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 2],
                ],
            ],
            [
                'key' => 'field_wswa_hosting_plans',
                'label' => 'Hosting Plans',
                'name' => 'hosting_plans',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add plan',
                'sub_fields' => [
                    ['key' => 'field_wswa_hosting_plan_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text'],
                    ['key' => 'field_wswa_hosting_plan_audience', 'label' => 'Audience', 'name' => 'audience', 'type' => 'text'],
                    ['key' => 'field_wswa_hosting_plan_price', 'label' => 'Price', 'name' => 'price', 'type' => 'text'],
                    ['key' => 'field_wswa_hosting_plan_period', 'label' => 'Period', 'name' => 'period', 'type' => 'text'],
                ],
            ],
            ['key' => 'field_wswa_clients_tab', 'label' => 'Clients & Contact', 'type' => 'tab'],
            ['key' => 'field_wswa_clients_title', 'label' => 'Clients Title', 'name' => 'clients_title', 'type' => 'text'],
            [
                'key' => 'field_wswa_clients',
                'label' => 'Clients',
                'name' => 'clients',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add client',
                'sub_fields' => [
                    ['key' => 'field_wswa_client_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text'],
                    ['key' => 'field_wswa_client_type', 'label' => 'Project Type', 'name' => 'type', 'type' => 'text'],
                ],
            ],
            ['key' => 'field_wswa_why_title', 'label' => 'Why Title', 'name' => 'why_title', 'type' => 'text'],
            [
                'key' => 'field_wswa_why_items',
                'label' => 'Why Items',
                'name' => 'why_items',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add item',
                'sub_fields' => [
                    ['key' => 'field_wswa_why_item_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                    ['key' => 'field_wswa_why_item_number', 'label' => 'Number', 'name' => 'number', 'type' => 'text'],
                ],
            ],
            ['key' => 'field_wswa_contact_title', 'label' => 'Contact Title', 'name' => 'contact_title', 'type' => 'text'],
            ['key' => 'field_wswa_contact_text', 'label' => 'Contact Text', 'name' => 'contact_text', 'type' => 'textarea', 'rows' => 3],
            ['key' => 'field_wswa_contact_email', 'label' => 'Email', 'name' => 'contact_email', 'type' => 'email'],
            ['key' => 'field_wswa_contact_phone', 'label' => 'Phone', 'name' => 'contact_phone', 'type' => 'text'],
            ['key' => 'field_wswa_contact_address', 'label' => 'Address', 'name' => 'contact_address', 'type' => 'text'],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
                ],
            ],
            [
                [
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ],
            ],
        ],
        'position' => 'acf_after_title',
        'style' => 'seamless',
        'active' => true,
    ]);
});

