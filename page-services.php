<?php

/**
 * Services page template.
 *
 * @package WebStudioWA
 */

$services = wswa_services();

get_header();
?>
<section class="section page-hero">
    <div class="container narrow">

        <h1><?php esc_html_e('Web design, redesign and maintenance', 'winter'); ?></h1>
        <p><?php esc_html_e('Choose the service that matches where your website is today. Each service has its own page with more detail, visuals and next steps.', 'winter'); ?></p>
    </div>
</section>

<section class="section services-detail">
    <div class="container detail-stack">
        <?php foreach ($services as $service) : ?>
            <article class="detail-card" id="<?php echo esc_attr($service['slug']); ?>">
                <div class="detail-card__media">
                    <img src="<?php echo esc_url($service['image']); ?>" alt="<?php echo esc_attr($service['title']); ?>" width="1200" height="900" loading="lazy" decoding="async">
                </div>
                <div class="detail-card__content">
                    <span><?php echo esc_html($service['number']); ?></span>
                    <h2><?php echo esc_html($service['title']); ?></h2>
                    <p><?php echo esc_html($service['details']); ?></p>
                    <ul class="check-list">
                        <li><?php esc_html_e('Responsive website layout', 'winter'); ?></li>
                        <li><?php esc_html_e('SEO-friendly page structure', 'winter'); ?></li>
                        <li><?php esc_html_e('Clear calls to action', 'winter'); ?></li>
                    </ul>
                    <a class="button button--primary" href="<?php echo esc_url(wswa_page_url($service['slug'])); ?>" aria-label="<?php echo esc_attr($service['cta_label'] ?? sprintf(__('Read more about %s', 'winter'), $service['title'])); ?>"><?php esc_html_e('Read More', 'winter'); ?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section image-feature image-feature--reverse">
    <div class="container image-feature__grid">
        <img src="<?php echo esc_url(wswa_asset('img/webstudiowa-about.webp')); ?>" alt="<?php esc_attr_e('Web Studio WA design and growth visual', 'winter'); ?>" width="1200" height="800" loading="lazy" decoding="async">
        <div>
            <p class="eyebrow"><?php esc_html_e('Focused service pages', 'winter'); ?></p>
            <h2><?php esc_html_e('Every service has a clear path forward', 'winter'); ?></h2>
            <p><?php esc_html_e('Browse Web Site Design, Website Redesign or Web Site Maintenance from the Services dropdown and choose the page that matches your current website stage.', 'winter'); ?></p>
        </div>
    </div>
</section>
<?php
get_footer();
