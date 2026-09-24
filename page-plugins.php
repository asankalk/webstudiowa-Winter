<?php
/**
 * Web Studio WA plugins index page.
 *
 * @package WebStudioWA
 */

get_header();
?>
<section class="plugins-hero">
    <div class="container plugins-hero__grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('Web Studio WA Plugins', 'winter'); ?></p>
            <h1><?php esc_html_e('WordPress plugins built for practical websites', 'winter'); ?></h1>
            <p><?php esc_html_e('Explore Web Studio WA plugins designed to help business websites connect services, display content and support better day-to-day website management.', 'winter'); ?></p>
        </div>
        <div class="plugins-hero__mockup" aria-label="<?php esc_attr_e('Web Studio WA plugin library preview', 'winter'); ?>">
            <div class="plugins-hero__mockup-bar"><span></span><span></span><span></span></div>
            <div class="plugins-hero__mockup-card"><i></i><div><strong><?php esc_html_e('SocialFeed', 'winter'); ?></strong><small><?php esc_html_e('Social media feeds', 'winter'); ?></small></div><em><?php esc_html_e('Plugin', 'winter'); ?></em></div>
            <div class="plugins-hero__mockup-lines"><i></i><i></i><i></i></div>
        </div>
    </div>
</section>

<section class="section plugins-listing">
    <div class="container section__heading">
        <p class="eyebrow"><?php esc_html_e('Plugin library', 'winter'); ?></p>
        <h2><?php esc_html_e('Available plugins', 'winter'); ?></h2>
    </div>
    <div class="container plugins-listing__grid">
        <article class="plugin-card">
            <div class="plugin-card__visual">
                <img src="<?php echo esc_url(wswa_asset('img/socialfeed-logo.svg')); ?>" alt="<?php esc_attr_e('SocialFeed', 'winter'); ?>" width="330" height="82">
                <div class="plugin-card__feed"><i></i><i></i><i></i><i></i><i></i><i></i></div>
            </div>
            <div class="plugin-card__content">
                <div class="plugin-card__meta"><span><?php esc_html_e('Social media feeds', 'winter'); ?></span><b><?php esc_html_e('In development', 'winter'); ?></b></div>
                <h2><?php esc_html_e('SocialFeed', 'winter'); ?></h2>
                <p><?php esc_html_e('Display Instagram and Facebook content on your WordPress website with a cleaner, client-friendly feed plugin built by Web Studio WA.', 'winter'); ?></p>
                <ul>
                    <li><?php esc_html_e('Instagram feed display', 'winter'); ?></li>
                    <li><?php esc_html_e('Facebook page content support', 'winter'); ?></li>
                    <li><?php esc_html_e('OAuth-based connection flow', 'winter'); ?></li>
                    <li><?php esc_html_e('Responsive layouts', 'winter'); ?></li>
                </ul>
                <a class="button button--primary" href="<?php echo esc_url(home_url('/plugins/socialfeed/')); ?>"><?php esc_html_e('View SocialFeed', 'winter'); ?></a>
            </div>
        </article>
    </div>
</section>

<section class="section plugins-future">
    <div class="container"><p><?php esc_html_e('More Web Studio WA plugins will be added here as they become available.', 'winter'); ?></p></div>
</section>

<section class="plugins-cta">
    <div class="container">
        <p class="eyebrow"><?php esc_html_e('WordPress functionality', 'winter'); ?></p>
        <h2><?php esc_html_e('Need a WordPress plugin for your website?', 'winter'); ?></h2>
        <p><?php esc_html_e('Web Studio WA can help plan, build and support practical WordPress functionality for business websites.', 'winter'); ?></p>
        <a class="button button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Web Studio WA', 'winter'); ?></a>
    </div>
</section>
<?php get_footer();
