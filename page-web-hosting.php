<?php
/**
 * Web hosting page template.
 *
 * @package WebStudioWA
 */

$plans = wswa_hosting_plans();

get_header();
?>
<section class="section page-hero page-hero--split">
    <div class="container page-hero__grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('Web Hosting', 'winter'); ?></p>
            <h1><?php echo esc_html(wswa_get_field('hosting_title')); ?></h1>
            <p><?php echo esc_html(wswa_get_field('hosting_text')); ?></p>
            <p><?php esc_html_e('iWebNode is our dedicated hosting platform for Web Studio WA clients, providing the web hosting store and client portal used for these packages.', 'winter'); ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="#packages"><?php esc_html_e('View packages', 'winter'); ?></a>
                <a class="button button--primary" href="https://iwebnode.com/" target="_blank" rel="noopener"><?php esc_html_e('Visit iWebNode', 'winter'); ?></a>
            </div>
        </div>
        <img src="<?php echo esc_url(wswa_asset('img/iwebnode-hosting-section.png')); ?>" alt="<?php esc_attr_e('Website hosting and growth visual', 'winter'); ?>">
    </div>
</section>

<section class="section hosting hosting--page" id="packages">
    <div class="container section__heading">
        <p class="eyebrow"><?php esc_html_e('Packages', 'winter'); ?></p>
        <h2><?php esc_html_e('Choose a hosting package', 'winter'); ?></h2>
        <p><?php esc_html_e('Packages are purchased through iWebNode, the hosting platform used by Web Studio WA for client hosting and support.', 'winter'); ?></p>
    </div>
    <div class="container plan-grid plan-grid--three">
        <?php foreach ($plans as $plan) : ?>
            <article class="plan-card">
                <p><?php echo esc_html($plan['audience']); ?></p>
                <h3><?php echo esc_html($plan['name']); ?></h3>
                <div class="price"><strong><?php echo esc_html($plan['price']); ?></strong><span><?php echo esc_html($plan['period']); ?></span></div>
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
                <a class="button button--primary plan-card__button" href="<?php echo esc_url($plan['purchase_url']); ?>" target="_blank" rel="noopener"><?php esc_html_e('Purchase this package', 'winter'); ?></a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section image-feature">
    <div class="container image-feature__grid">
        <img src="<?php echo esc_url(wswa_asset('img/iwebnode-hosting-section.png')); ?>" alt="<?php esc_attr_e('iWebNode hosting platform visual', 'winter'); ?>">
        <div>
            <p class="eyebrow"><?php esc_html_e('iWebNode hosting', 'winter'); ?></p>
            <h2><?php esc_html_e('Hosting powered through our dedicated client platform', 'winter'); ?></h2>
            <p><?php esc_html_e('Web Studio WA uses iWebNode for hosting orders, client accounts and package management, so clients can purchase hosting directly while still receiving friendly Web Studio WA support.', 'winter'); ?></p>
            <a class="button button--primary" href="https://iwebnode.com/" target="_blank" rel="noopener"><?php esc_html_e('Visit iWebNode', 'winter'); ?></a>
        </div>
    </div>
</section>
<?php
get_footer();
