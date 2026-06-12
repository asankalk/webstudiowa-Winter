<?php
/**
 * Homepage sections.
 *
 * @package WebStudioWA
 */

$hero_image = wswa_image_url(wswa_get_field('hero_image'), wswa_asset('img/hero-workspace.svg'));
?>
<section class="hero">
    <div class="container hero__grid">
        <div class="hero__content">
            <p class="eyebrow"><?php echo esc_html(wswa_get_field('hero_eyebrow')); ?></p>
            <h1><?php echo esc_html(wswa_get_field('hero_title')); ?></h1>
            <p><?php echo esc_html(wswa_get_field('hero_text')); ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?php echo esc_url(wswa_get_field('hero_primary_url')); ?>"><?php echo esc_html(wswa_get_field('hero_primary_label')); ?></a>
                <a class="button button--ghost" href="<?php echo esc_url(wswa_get_field('hero_secondary_url')); ?>"><?php echo esc_html(wswa_get_field('hero_secondary_label')); ?></a>
            </div>
        </div>
        <div class="hero__media">
            <img src="<?php echo esc_url($hero_image); ?>" alt="<?php esc_attr_e('Modern web design workspace', 'winter'); ?>">
        </div>
    </div>
    <div class="container stats">
        <?php foreach ((array) wswa_get_field('stats') as $stat) : ?>
            <div class="stat">
                <strong><?php echo esc_html($stat['value'] ?? ''); ?></strong>
                <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section intro">
    <div class="container intro__grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('Strategy, design, build', 'winter'); ?></p>
            <h2><?php echo esc_html(wswa_get_field('intro_title')); ?></h2>
        </div>
        <p><?php echo esc_html(wswa_get_field('intro_text')); ?></p>
    </div>
</section>

<section class="section services" id="services">
    <div class="container section__heading">
        <p class="eyebrow"><?php esc_html_e('Services We Offer', 'winter'); ?></p>
        <h2><?php echo esc_html(wswa_get_field('services_title')); ?></h2>
        <p><?php echo esc_html(wswa_get_field('services_text')); ?></p>
    </div>
    <div class="container service-grid">
        <?php foreach ((array) wswa_get_field('services') as $service) : ?>
            <article class="service-card">
                <span><?php echo esc_html($service['number'] ?? ''); ?></span>
                <h3><?php echo esc_html($service['title'] ?? ''); ?></h3>
                <p><?php echo esc_html($service['text'] ?? ''); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section hosting" id="hosting">
    <div class="container hosting__grid">
        <div class="hosting__content">
            <p class="eyebrow"><?php esc_html_e('Website Hosting', 'winter'); ?></p>
            <h2><?php echo esc_html(wswa_get_field('hosting_title')); ?></h2>
            <p><?php echo esc_html(wswa_get_field('hosting_text')); ?></p>
            <div class="feature-list">
                <?php foreach ((array) wswa_get_field('hosting_features') as $feature) : ?>
                    <div>
                        <h3><?php echo esc_html($feature['title'] ?? ''); ?></h3>
                        <p><?php echo esc_html($feature['text'] ?? ''); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="plan-grid">
            <?php foreach ((array) wswa_get_field('hosting_plans') as $plan) : ?>
                <article class="plan-card">
                    <p><?php echo esc_html($plan['audience'] ?? ''); ?></p>
                    <h3><?php echo esc_html($plan['name'] ?? ''); ?></h3>
                    <div class="price"><strong><?php echo esc_html($plan['price'] ?? ''); ?></strong><span><?php echo esc_html($plan['period'] ?? ''); ?></span></div>
                    <a href="#contact"><?php esc_html_e('Get Started Now', 'winter'); ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section clients">
    <div class="container section__heading">
        <p class="eyebrow"><?php esc_html_e('Our Clients', 'winter'); ?></p>
        <h2><?php echo esc_html(wswa_get_field('clients_title')); ?></h2>
    </div>
    <div class="container client-grid">
        <?php foreach ((array) wswa_get_field('clients') as $client) : ?>
            <article class="client-card">
                <span><?php echo esc_html($client['type'] ?? ''); ?></span>
                <h3><?php echo esc_html($client['name'] ?? ''); ?></h3>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section why">
    <div class="container why__grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('Why Web Studio WA?', 'winter'); ?></p>
            <h2><?php echo esc_html(wswa_get_field('why_title')); ?></h2>
        </div>
        <div class="why-list">
            <?php foreach ((array) wswa_get_field('why_items') as $item) : ?>
                <div>
                    <span><?php echo esc_html($item['number'] ?? ''); ?></span>
                    <strong><?php echo esc_html($item['title'] ?? ''); ?></strong>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section contact-cta" id="contact">
    <div class="container contact-cta__inner">
        <div>
            <p class="eyebrow"><?php esc_html_e('Contact', 'winter'); ?></p>
            <h2><?php echo esc_html(wswa_get_field('contact_title')); ?></h2>
            <p><?php echo esc_html(wswa_get_field('contact_text')); ?></p>
        </div>
        <div class="contact-card">
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', wswa_get_field('contact_phone'))); ?>"><?php echo esc_html(wswa_get_field('contact_phone')); ?></a>
            <a href="mailto:<?php echo esc_attr(wswa_get_field('contact_email')); ?>"><?php echo esc_html(wswa_get_field('contact_email')); ?></a>
            <span><?php echo esc_html(wswa_get_field('contact_address')); ?></span>
        </div>
    </div>
</section>

