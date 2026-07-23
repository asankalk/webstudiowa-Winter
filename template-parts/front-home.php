<?php
/**
 * Homepage sections.
 *
 * @package WebStudioWA
 */

$hero_image = wswa_image_url(wswa_get_field('hero_image'), wswa_asset('img/hero-workspace.svg'));
$featured_clients = wswa_clients([
    'featured_only' => true,
    'limit' => 8,
]);
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
            <img src="<?php echo esc_url($hero_image); ?>" alt="<?php esc_attr_e('Modern web design workspace', 'winter'); ?>" width="1200" height="900" decoding="async" fetchpriority="high">
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
        <div>
            <p><?php echo esc_html(wswa_get_field('intro_text')); ?></p>
            <div class="section__actions section__actions--left">
                <a class="button button--ghost" href="<?php echo esc_url(wswa_page_url('about-us')); ?>"><?php esc_html_e('About Web Studio WA', 'winter'); ?></a>
            </div>
        </div>
    </div>
</section>

<section class="section services" id="services">
    <div class="container section__heading">
        <p class="eyebrow"><?php esc_html_e('Services We Offer', 'winter'); ?></p>
        <h2><?php echo esc_html(wswa_get_field('services_title')); ?></h2>
        <p><?php echo esc_html(wswa_get_field('services_text')); ?></p>
    </div>
    <div class="container service-grid">
        <?php foreach (wswa_services() as $service) : ?>
            <article class="service-card">
                <img class="service-card__image" src="<?php echo esc_url($service['image']); ?>" alt="<?php echo esc_attr($service['title']); ?>" width="1200" height="900" loading="lazy" decoding="async">
                <span class="service-card__icon" aria-hidden="true"><i class="<?php echo esc_attr($service['icon']); ?>"></i></span>
                <h3><?php echo esc_html($service['title'] ?? ''); ?></h3>
                <p><?php echo esc_html($service['summary']); ?></p>
                <a class="button button--primary service-card__button" href="<?php echo esc_url(wswa_page_url($service['slug'])); ?>" aria-label="<?php echo esc_attr($service['cta_label'] ?? sprintf(__('Read more about %s', 'winter'), $service['title'])); ?>"><?php esc_html_e('Read More', 'winter'); ?></a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section hosting" id="hosting">
    <div class="container hosting-home">
        <div class="hosting-home__intro">
            <div class="hosting__content">
                <p class="eyebrow"><?php esc_html_e('Website Hosting', 'winter'); ?></p>
                <h2><?php echo esc_html(wswa_get_field('hosting_title')); ?></h2>
                <p><?php echo esc_html(wswa_get_field('hosting_text')); ?></p>
            </div>
            <div class="feature-list">
                <?php foreach ((array) wswa_get_field('hosting_features') as $feature) : ?>
                    <div>
                        <h3><?php echo esc_html($feature['title'] ?? ''); ?></h3>
                        <p><?php echo esc_html($feature['text'] ?? ''); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="plan-grid plan-grid--home">
            <?php foreach (wswa_hosting_plans() as $plan) : ?>
                <article class="plan-card">
                    <p><?php echo esc_html($plan['audience'] ?? ''); ?></p>
                    <h3><?php echo esc_html($plan['name'] ?? ''); ?></h3>
                    <div class="price"><strong><?php echo esc_html($plan['price'] ?? ''); ?></strong><span><?php echo esc_html($plan['period'] ?? ''); ?></span></div>
                    <dl class="plan-specs">
                        <div>
                            <dt><?php esc_html_e('Space', 'winter'); ?></dt>
                            <dd><?php echo esc_html($plan['storage']); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Domains / websites', 'winter'); ?></dt>
                            <dd><?php echo esc_html($plan['websites']); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Bandwidth', 'winter'); ?></dt>
                            <dd><?php echo esc_html($plan['bandwidth']); ?></dd>
                        </div>
                        <div>
                            <dt><?php esc_html_e('Email accounts', 'winter'); ?></dt>
                            <dd><?php echo esc_html($plan['email_accounts']); ?></dd>
                        </div>
                    </dl>
                    <a class="button button--primary plan-card__button" href="<?php echo esc_url($plan['purchase_url']); ?>" target="_blank" rel="noopener"><?php esc_html_e('Purchase package', 'winter'); ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section clients" id="clients">
    <div class="container section__heading">
        <p class="eyebrow"><?php esc_html_e('Our Clients', 'winter'); ?></p>
        <h2><?php echo esc_html(wswa_get_field('clients_title')); ?></h2>
        <p><?php esc_html_e('A curated selection of websites, redesigns and support partnerships delivered for Australian businesses.', 'winter'); ?></p>
    </div>
    <div class="client-marquee" aria-label="<?php esc_attr_e('Selected client websites', 'winter'); ?>">
        <div class="client-track">
            <?php for ($i = 0; $i < 2; $i++) : ?>
                <?php foreach ($featured_clients as $client) : ?>
                    <a class="client-snapshot" href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener">
                        <div class="client-snapshot__media">
                            <img class="<?php echo ! empty($client['uses_snapshot']) ? 'is-website-preview' : ''; ?>" src="<?php echo esc_url($client['image']); ?>" alt="<?php echo esc_attr($client['image_alt'] ?? $client['name']); ?>" width="520" height="390" loading="lazy" decoding="async">
                        </div>
                        <div class="client-snapshot__body">
                            <span><?php echo esc_html($client['type']); ?></span>
                            <strong><?php echo esc_html($client['name']); ?></strong>
                            <?php if (! empty($client['summary'])) : ?>
                                <p><?php echo esc_html($client['summary']); ?></p>
                            <?php endif; ?>
                            <small><?php esc_html_e('View website', 'winter'); ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endfor; ?>
        </div>
    </div>
    <div class="container section__actions">
        <a class="button button--primary" href="<?php echo esc_url(wswa_page_url('our-clients')); ?>"><?php esc_html_e('View all clients', 'winter'); ?></a>
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
            <div class="section__actions section__actions--left">
                    <a class="button button--primary" href="<?php echo esc_url(wswa_page_url('contact')); ?>"><?php esc_html_e('Contact Us', 'winter'); ?></a>
            </div>
        </div>
        <div class="contact-card">
            <?php echo winter_get_business_phone_link(); ?>
            <a href="mailto:<?php echo esc_attr(wswa_get_field('contact_email')); ?>"><?php echo esc_html(wswa_get_field('contact_email')); ?></a>
            <span><?php echo esc_html(wswa_get_field('contact_address')); ?></span>
        </div>
    </div>
</section>
