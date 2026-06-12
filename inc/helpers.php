<?php
/**
 * Theme helper functions and default content.
 *
 * @package WebStudioWA
 */

if (! defined('ABSPATH')) {
    exit;
}

function wswa_asset(string $path): string
{
    return WSWA_THEME_URI . '/assets/' . ltrim($path, '/');
}

function wswa_get_field(string $name, $default = null)
{
    if (function_exists('get_field')) {
        $value = get_field($name);
        if ($value !== null && $value !== false && $value !== '') {
            return $value;
        }
    }

    $defaults = wswa_defaults();
    return array_key_exists($name, $defaults) ? $defaults[$name] : $default;
}

function wswa_fallback_menu(): void
{
    $items = [
        ['label' => __('Home', 'winter'), 'url' => home_url('/')],
        ['label' => __('Services', 'winter'), 'url' => home_url('/#services')],
        ['label' => __('Hosting', 'winter'), 'url' => home_url('/#hosting')],
        ['label' => __('Contact', 'winter'), 'url' => home_url('/#contact')],
    ];

    echo '<ul class="menu">';
    foreach ($items as $item) {
        printf('<li><a href="%s">%s</a></li>', esc_url($item['url']), esc_html($item['label']));
    }
    echo '</ul>';
}

function wswa_image_url($image, string $fallback): string
{
    if (is_array($image) && ! empty($image['url'])) {
        return $image['url'];
    }

    if (is_numeric($image)) {
        $src = wp_get_attachment_image_url((int) $image, 'large');
        if ($src) {
            return $src;
        }
    }

    if (is_string($image) && $image !== '') {
        return $image;
    }

    return $fallback;
}

function wswa_defaults(): array
{
    return [
        'hero_eyebrow' => 'Web Design Perth & Hosting Support',
        'hero_title' => 'Build Your Presence Online',
        'hero_text' => 'Web Studio WA creates responsive, SEO-friendly websites, custom web applications, ongoing website care and reliable hosting support for businesses across Western Australia.',
        'hero_primary_label' => 'Start a project',
        'hero_primary_url' => '#contact',
        'hero_secondary_label' => 'View services',
        'hero_secondary_url' => '#services',
        'hero_image' => wswa_asset('img/hero-workspace.svg'),
        'stats' => [
            ['value' => '10+', 'label' => 'Years of experience'],
            ['value' => '2017', 'label' => 'Established in WA'],
            ['value' => '100%', 'label' => 'Responsive builds'],
        ],
        'intro_title' => 'Unlocking Digital Brilliance',
        'intro_text' => 'Step into a world where simplicity converges with modern technology. We analyse, design and develop tailored solutions that help your vision become a fast, accessible and measurable digital experience.',
        'services_title' => 'Services that move your business forward',
        'services_text' => 'From first launch to redesigns, maintenance and custom systems, every service is shaped around performance, usability and growth.',
        'services' => [
            ['title' => 'Web Design', 'text' => 'Affordable, custom website design in Perth with responsive layouts, clear messaging and polished user experiences.', 'number' => '01'],
            ['title' => 'Website Redesign', 'text' => 'Modernise an existing site with stronger structure, SEO-friendly content, mobile responsiveness and better conversion paths.', 'number' => '02'],
            ['title' => 'Website Maintenance', 'text' => 'Keep your website secure and fresh with content updates, software maintenance, security patches and practical support.', 'number' => '03'],
            ['title' => 'Custom Web Applications', 'text' => 'Automate workflows and create tailored web solutions using reliable development practices and scalable architecture.', 'number' => '04'],
        ],
        'hosting_title' => 'Fast, managed hosting for business websites',
        'hosting_text' => 'Hosting details are based on iWebNode plans: secure, reliable website hosting with WordPress support, migration help and friendly technical assistance.',
        'hosting_features' => [
            ['title' => 'Managed WordPress', 'text' => 'Automatic updates, strong performance and hassle-free management without needing technical skills.'],
            ['title' => 'Dedicated Support', 'text' => 'Reliable support focused on fast responses and keeping your website running smoothly.'],
            ['title' => 'Website Transfer', 'text' => 'Careful migration support designed to move websites with minimal downtime.'],
        ],
        'hosting_plans' => [
            ['name' => 'Starter Hosting', 'audience' => 'For small business', 'price' => '$14.95', 'period' => '/mo'],
            ['name' => 'Business Hosting', 'audience' => 'For medium business', 'price' => '$19.95', 'period' => '/mo'],
            ['name' => 'Pro Hosting', 'audience' => 'For large business', 'price' => '$39.95', 'period' => '/mo'],
        ],
        'clients_title' => 'Selected client work',
        'clients' => [
            ['name' => 'Vending WA', 'type' => 'New Website'],
            ['name' => 'Pretium Lending', 'type' => 'New Website'],
            ['name' => 'Cricketers Club', 'type' => 'Website Maintenance'],
            ['name' => 'Pretium Funding', 'type' => 'Website Redesign'],
            ['name' => 'HP Debt Solutions', 'type' => 'Website Redesign'],
        ],
        'why_title' => 'Unlock revenue growth for your business',
        'why_items' => [
            ['title' => 'Fast Development', 'number' => '01'],
            ['title' => 'Full Flexibility', 'number' => '02'],
            ['title' => 'Modern Design', 'number' => '03'],
            ['title' => 'Simple Maintenance', 'number' => '04'],
        ],
        'contact_title' => 'Ready to build something sharper?',
        'contact_text' => 'Talk to Web Studio WA about web design, redesigns, website maintenance, hosting or custom applications.',
        'contact_email' => 'hello@webstudiowa.com.au',
        'contact_phone' => '0410 930 327',
        'contact_address' => 'We are a Western Australia based Company',
    ];
}
