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

function winter_sanitize_business_phone(string $phone): string
{
    $phone = trim(wp_strip_all_tags($phone));

    return $phone !== '' ? $phone : '0470 442 762';
}

function winter_get_business_phone(): string
{
    $phone = get_theme_mod('winter_business_phone', '0470 442 762');

    return winter_sanitize_business_phone((string) $phone);
}

function winter_get_business_phone_tel(): string
{
    $digits = preg_replace('/\D+/', '', winter_get_business_phone());

    if (! is_string($digits) || $digits === '') {
        return '+61470442762';
    }

    if (str_starts_with($digits, '61')) {
        return '+' . $digits;
    }

    if (str_starts_with($digits, '0')) {
        return '+61' . substr($digits, 1);
    }

    return '+' . $digits;
}

function winter_get_business_phone_link(): string
{
    return sprintf(
        '<a href="tel:%1$s">%2$s</a>',
        esc_attr(winter_get_business_phone_tel()),
        esc_html(winter_get_business_phone())
    );
}

function wswa_fallback_menu(): void
{
    echo '<ul class="menu">';
    printf('<li><a href="%s">%s</a></li>', esc_url(home_url('/')), esc_html__('Home', 'winter'));
    printf('<li><a href="%s">%s</a></li>', esc_url(wswa_page_url('about-us')), esc_html__('About us', 'winter'));
    printf('<li class="menu-item-has-children"><a href="%s">%s</a>', esc_url(wswa_page_url('services')), esc_html__('Services', 'winter'));
    echo '<ul class="sub-menu">';
    foreach (wswa_services() as $service) {
        printf('<li><a href="%s">%s</a></li>', esc_url(wswa_page_url($service['slug'])), esc_html($service['title']));
    }
    echo '</ul></li>';
    printf('<li><a href="%s">%s</a></li>', esc_url(wswa_page_url('web-hosting')), esc_html__('Web Hosting', 'winter'));
    printf('<li><a href="%s">%s</a></li>', esc_url(wswa_page_url('our-clients')), esc_html__('Our clients', 'winter'));
    printf('<li><a href="%s">%s</a></li>', esc_url(wswa_page_url('contact')), esc_html__('Contact', 'winter'));
    echo '</ul>';
}

function wswa_page_url(string $slug, string $anchor = ''): string
{
    $page = get_page_by_path($slug);
    $url = $page ? get_permalink($page) : home_url('/' . trim($slug, '/') . '/');

    return $url . ($anchor ? '#' . ltrim($anchor, '#') : '');
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

function wswa_live_image(string $path): string
{
    return 'https://webstudiowa.com.au/wp-content/uploads/' . ltrim($path, '/');
}

function wswa_client_snapshot(string $url): string
{
    return 'https://s.wordpress.com/mshots/v1/' . rawurlencode($url) . '?w=900';
}

function wswa_services(): array
{
    return [
        [
            'title' => 'Web Site Design',
            'slug' => 'web-design',
            'summary' => 'Affordable, custom website design in Perth with responsive layouts, clear messaging and polished user experiences.',
            'details' => 'We plan, design and build professional websites that reflect your business, load quickly, work across devices and give visitors a clear path to contact you.',
            'body' => 'A new website build gives your business a strong digital foundation: clear service pages, fast responsive layouts, practical SEO structure and a design that feels trustworthy from the first visit.',
            'cta_label' => 'Read more about website design',
            'number' => '01',
            'icon' => 'fa-solid fa-laptop-code',
            'image' => wswa_asset('img/service-web-design.webp'),
            'hero_image' => wswa_asset('img/service-web-design.webp'),
            'support_image' => wswa_asset('img/avrix-support-1.webp'),
            'features' => ['Custom responsive design', 'WordPress setup and page build', 'SEO-friendly content structure', 'Launch and handover support'],
        ],
        [
            'title' => 'Website Redesign',
            'slug' => 'website-redesign',
            'summary' => 'Modernise an existing site with stronger structure, SEO-friendly content, mobile responsiveness and better conversion paths.',
            'details' => 'Redesign projects focus on improving the user journey, updating dated visuals, tightening page content and keeping important existing SEO value intact.',
            'body' => 'A redesign is ideal when your current site still has value but no longer reflects your business. We reshape the site experience, sharpen the design and improve performance without losing sight of existing content and search visibility.',
            'cta_label' => 'Read more about website redesign',
            'number' => '02',
            'icon' => 'fa-solid fa-wand-magic-sparkles',
            'image' => wswa_asset('img/service-website-redesign.webp'),
            'hero_image' => wswa_asset('img/service-website-redesign.webp'),
            'support_image' => wswa_asset('img/avrix-about.webp'),
            'features' => ['Existing website review', 'Modern page redesign', 'Mobile and performance improvements', 'Content and conversion path cleanup'],
        ],
        [
            'title' => 'Web Site Maintenance',
            'slug' => 'website-maintenance',
            'summary' => 'Keep your website secure and fresh with content updates, software maintenance, security patches and practical support.',
            'details' => 'Maintenance support can include WordPress updates, plugin checks, backups, security fixes, small content changes and advice when something needs attention.',
            'body' => 'Maintenance keeps your site healthy after launch. We help with updates, checks, content changes and practical fixes so the website remains current, secure and useful for your customers.',
            'cta_label' => 'Read more about website maintenance',
            'number' => '03',
            'icon' => 'fa-solid fa-screwdriver-wrench',
            'image' => wswa_asset('img/service-website-maintenance.webp'),
            'hero_image' => wswa_asset('img/service-website-maintenance.webp'),
            'support_image' => wswa_asset('img/avrix-support-5.webp'),
            'features' => ['WordPress and plugin updates', 'Backups and security checks', 'Small content updates', 'Friendly technical support'],
        ],
    ];
}

function wswa_service_by_slug(string $slug): ?array
{
    foreach (wswa_services() as $service) {
        if ($service['slug'] === $slug) {
            return $service;
        }
    }

    return null;
}

function wswa_hosting_plans(): array
{
    return [
        [
            'name' => 'Starter Hosting',
            'slug' => 'starter-hosting',
            'audience' => 'For small business',
            'price' => '$14.95',
            'period' => '/mo',
            'summary' => 'A simple managed hosting option for small websites and brochure-style business sites.',
            'features' => ['WordPress-ready hosting', 'Email and DNS guidance', 'Security-focused setup', 'Friendly technical support'],
            'storage' => '2 GB SSD Storage',
            'websites' => '1 Website Included',
            'bandwidth' => '50 GB Monthly Bandwidth',
            'email_accounts' => '10 Business Email Accounts',
            'databases' => '5 Databases',
            'support' => 'Standard Support',
            'purchase_url' => 'https://clients.iwebnode.com/index.php?rp=/store/web-hosting/starter-hosting',
        ],
        [
            'name' => 'Business Hosting',
            'slug' => 'business-hosting',
            'audience' => 'For medium business',
            'price' => '$19.95',
            'period' => '/mo',
            'summary' => 'A balanced hosting package for growing business websites that need extra performance headroom.',
            'features' => ['Managed WordPress support', 'Migration assistance', 'Performance monitoring', 'Priority support guidance'],
            'storage' => '5 GB SSD Storage',
            'websites' => 'Up to 5 Websites',
            'bandwidth' => '100 GB Monthly Bandwidth',
            'email_accounts' => '25 Business Email Accounts',
            'databases' => '10 Databases',
            'support' => 'Priority Support',
            'purchase_url' => 'https://clients.iwebnode.com/index.php?rp=/store/web-hosting/business-hosting',
        ],
        [
            'name' => 'Pro Hosting',
            'slug' => 'pro-hosting',
            'audience' => 'For larger business',
            'price' => '$39.95',
            'period' => '/mo',
            'summary' => 'A stronger managed hosting package for larger websites, higher traffic and more active maintenance needs.',
            'features' => ['Higher resource allocation', 'Advanced migration support', 'Extra backup guidance', 'Ongoing optimisation advice'],
            'storage' => '7 GB SSD Storage',
            'websites' => 'Up to 10 Websites',
            'bandwidth' => '200 GB Monthly Bandwidth',
            'email_accounts' => '50 Business Email Accounts',
            'databases' => '25 Databases',
            'support' => 'Premium Support',
            'purchase_url' => 'https://clients.iwebnode.com/index.php?rp=/store/web-hosting/pro-hosting',
        ],
    ];
}

function wswa_clients(): array
{
    return [
        [
            'name' => 'Vending WA',
            'type' => 'New Website',
            'url' => 'https://www.vendingwa.com.au/',
            'image' => wswa_asset('img/client-vending-wa.webp'),
        ],
        [
            'name' => 'Pretium Group',
            'type' => 'New Website',
            'url' => 'https://www.pretiumgroup.com.au/',
            'image' => wswa_asset('img/client-pretium-group.webp'),
        ],
        [
            'name' => 'Cricketers Club',
            'type' => 'Website Maintenance',
            'url' => 'https://cricketersclub.com.au/',
            'image' => wswa_asset('img/client-cricketers-club.webp'),
        ],
        [
            'name' => 'Pretium Funding',
            'type' => 'Website Redesign',
            'url' => 'https://www.pretiumfunding.com.au/',
            'image' => wswa_asset('img/client-pretium-funding.webp'),
        ],
        [
            'name' => 'HP Debt Solutions',
            'type' => 'Website Redesign',
            'url' => 'https://www.hpdebtsolutions.com.au/',
            'image' => wswa_asset('img/client-hp-debt-solutions.webp'),
        ],
    ];
}

function wswa_defaults(): array
{
    return [
        'hero_eyebrow' => 'Web Design Perth & Hosting Support',
        'hero_title' => 'Build Your Presence Online',
        'hero_text' => 'Web Studio WA creates responsive, SEO-friendly websites, custom web applications, ongoing website care and reliable hosting support for businesses across Western Australia.',
        'hero_primary_label' => 'Start a project',
        'hero_primary_url' => wswa_page_url('contact'),
        'hero_secondary_label' => 'View services',
        'hero_secondary_url' => wswa_page_url('services'),
        'hero_image' => wswa_asset('img/avrix-hero.webp'),
        'stats' => [
            ['value' => '10+', 'label' => 'Years of experience'],
            ['value' => '2017', 'label' => 'Established in WA'],
            ['value' => '100%', 'label' => 'Responsive builds'],
        ],
        'intro_title' => 'Unlocking Digital Brilliance',
        'intro_text' => 'Step into a world where simplicity converges with modern technology. We analyse, design and develop tailored solutions that help your vision become a fast, accessible and measurable digital experience.',
        'services_title' => 'Services that move your business forward',
        'services_text' => 'From first launch to redesigns, maintenance and custom systems, every service is shaped around performance, usability and growth.',
        'services' => wswa_services(),
        'hosting_title' => 'Fast, managed hosting for business websites',
        'hosting_text' => 'Hosting packages are managed through iWebNode, the dedicated hosting platform used by Web Studio WA for client hosting, WordPress support, migration help and friendly technical assistance.',
        'hosting_features' => [
            ['title' => 'Managed WordPress', 'text' => 'Automatic updates, strong performance and hassle-free management without needing technical skills.'],
            ['title' => 'Dedicated Support', 'text' => 'Reliable support focused on fast responses and keeping your website running smoothly.'],
            ['title' => 'Website Transfer', 'text' => 'Careful migration support designed to move websites with minimal downtime.'],
        ],
        'hosting_plans' => wswa_hosting_plans(),
        'clients_title' => 'Selected client work',
        'clients' => wswa_clients(),
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
        'contact_phone' => '0470 442 762',
        'contact_address' => 'We are a Western Australia based Company',
    ];
}
