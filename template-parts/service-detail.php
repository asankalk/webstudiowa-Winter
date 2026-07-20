<?php

/**
 * Single service detail template part.
 *
 * @package WebStudioWA
 */

$service = $args['service'] ?? null;

if (! $service) {
    return;
}
?>
<section class="section page-hero page-hero--split service-hero">
    <div class="container page-hero__grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('Services', 'winter'); ?></p>
            <h1><?php echo esc_html($service['title']); ?></h1>
            <p><?php echo esc_html($service['summary']); ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?php echo esc_url(wswa_page_url('contact', $service['slug'])); ?>"><?php esc_html_e('Start this service', 'winter'); ?></a>
                <a class="button button--ghost" href="<?php echo esc_url(wswa_page_url('services')); ?>"><?php esc_html_e('All services', 'winter'); ?></a>
            </div>
        </div>
        <img src="<?php echo esc_url($service['hero_image']); ?>" alt="<?php echo esc_attr($service['title']); ?>" width="1200" height="900" decoding="async" fetchpriority="high">
    </div>
</section>

<section class="section">
    <div class="container service-included">
        <div class="service-included__intro">
            <p class="eyebrow"><?php echo esc_html($service['included_eyebrow'] ?? __('What\'s included', 'winter')); ?></p>
            <h2><?php echo esc_html($service['included_heading'] ?? $service['title']); ?></h2>
        </div>
        <figure class="service-included__media">
            <img src="<?php echo esc_url($service['included_image'] ?? $service['support_image']); ?>" alt="<?php echo esc_attr($service['included_image_alt'] ?? ($service['title'] . ' support visual')); ?>" width="900" height="675" loading="lazy" decoding="async">
        </figure>
        <div class="service-included__body">
            <p><?php echo esc_html($service['included_text'] ?? $service['details']); ?></p>
        </div>
        <div class="service-included__support">
            <p class="service-included__support-label"><?php esc_html_e('Included support', 'winter'); ?></p>
            <ul class="check-list service-included__list">
                <?php foreach ($service['features'] as $feature) : ?>
                    <li><?php echo esc_html($feature); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section class="section image-feature">
    <div class="container image-feature__grid">
        <img src="<?php echo esc_url($service['support_image']); ?>" alt="<?php echo esc_attr($service['title'] . ' visual'); ?>" width="900" height="675" loading="lazy" decoding="async">
        <div>
            <p class="eyebrow"><?php esc_html_e('Built for business websites', 'winter'); ?></p>
            <h2><?php esc_html_e('A practical path from idea to launch', 'winter'); ?></h2>
            <p><?php esc_html_e('Web Studio WA keeps the process straightforward: define the goal, shape the content, build the pages, test the experience and support the website after it goes live.', 'winter'); ?></p>
        </div>
    </div>
</section>
