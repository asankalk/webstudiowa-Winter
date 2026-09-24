<?php
/**
 * SocialFeed plugin landing page.
 *
 * Applied automatically to a page with the slug "socialfeed", including
 * /plugins/socialfeed/ when SocialFeed is a child of the Plugins page.
 *
 * @package WebStudioWA
 */

get_header();
?>
<section class="socialfeed-hero">
    <div class="container socialfeed-hero__grid">
        <div class="socialfeed-hero__copy">
            <p class="eyebrow"><?php esc_html_e('Web Studio WA Plugin', 'winter'); ?></p>
            <img class="socialfeed-logo" src="<?php echo esc_url(wswa_asset('img/socialfeed-logo.svg')); ?>" alt="<?php esc_attr_e('SocialFeed', 'winter'); ?>" width="330" height="82">
            <h1><?php esc_html_e('SocialFeed for WordPress', 'winter'); ?></h1>
            <p> <?php esc_html_e('Display Instagram and Facebook content on your WordPress website with a cleaner, client-friendly feed plugin built by Web Studio WA.', 'winter'); ?></p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?php echo esc_url(home_url('/plugins/socialfeed/support/')); ?>"><?php esc_html_e('Get support', 'winter'); ?></a>
                <a class="button button--ghost" href="<?php echo esc_url(home_url('/plugins/socialfeed/privacy/')); ?>"><?php esc_html_e('View privacy details', 'winter'); ?></a>
            </div>
        </div>
        <div class="socialfeed-preview" aria-label="<?php esc_attr_e('SocialFeed plugin dashboard preview', 'winter'); ?>">
            <div class="socialfeed-preview__bar"><span></span><span></span><span></span><strong>SocialFeed</strong></div>
            <div class="socialfeed-preview__body">
                <aside><b><?php esc_html_e('Instagram', 'winter'); ?></b><span><?php esc_html_e('Facebook', 'winter'); ?></span><span><?php esc_html_e('Display', 'winter'); ?></span><span><?php esc_html_e('Status & Tools', 'winter'); ?></span></aside>
                <div class="socialfeed-preview__content">
                    <p><?php esc_html_e('Connected feeds', 'winter'); ?></p>
                    <div class="socialfeed-preview__profile"><i></i><span><strong>@yourbusiness</strong><small><?php esc_html_e('Instagram account connected', 'winter'); ?></small></span><em><?php esc_html_e('Active', 'winter'); ?></em></div>
                    <div class="socialfeed-preview__tiles"><i></i><i></i><i></i><i></i><i></i><i></i></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section socialfeed-overview">
    <div class="container section__heading socialfeed-heading">
        <p class="eyebrow"><?php esc_html_e('Simple connections', 'winter'); ?></p>
        <h2><?php esc_html_e('Connect your social content to your website', 'winter'); ?></h2>
        <p><?php esc_html_e('SocialFeed helps WordPress site owners display selected Instagram and Facebook content in a clean, responsive layout without asking clients to manually copy long access tokens.', 'winter'); ?></p>
    </div>
    <div class="container socialfeed-feature-grid">
        <?php
        $features = [
            ['01', 'Instagram feed display'], ['02', 'Facebook page content support'], ['03', 'OAuth-based connection flow'],
            ['04', 'Responsive grid layouts'], ['05', 'Cached feed output for performance'], ['06', 'Simple WordPress admin settings'],
        ];
        foreach ($features as [$number, $feature]) :
        ?>
            <article class="socialfeed-feature"><span><?php echo esc_html($number); ?></span><h3><?php echo esc_html($feature); ?></h3></article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section socialfeed-interface">
    <div class="container section__heading socialfeed-heading">
        <p class="eyebrow"><?php esc_html_e('Plugin interface', 'winter'); ?></p>
        <h2><?php esc_html_e('Designed for a simple WordPress admin experience', 'winter'); ?></h2>
    </div>
    <div class="container socialfeed-shot-grid">
        <?php
        $screens = [
            ['Instagram settings', 'Connect an account and choose a feed.'],
            ['Facebook connection', 'Guide clients through an OAuth connection.'],
            ['Display controls', 'Set layouts that suit your website.'],
        ];
        foreach ($screens as [$title, $description]) :
        ?>
            <article class="socialfeed-shot">
                <div class="socialfeed-shot__ui"><span></span><span></span><span></span><i></i><i></i><i></i><i></i></div>
                <h3><?php echo esc_html($title); ?></h3><p><?php echo esc_html($description); ?></p><small><?php esc_html_e('Screenshot coming soon', 'winter'); ?></small>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="section socialfeed-process">
    <div class="container socialfeed-process__grid">
        <div class="socialfeed-heading"><p class="eyebrow"><?php esc_html_e('How it works', 'winter'); ?></p><h2><?php esc_html_e('A straightforward way to show your latest content', 'winter'); ?></div>
        <ol class="socialfeed-steps">
            <li><span>1</span><div><h3><?php esc_html_e('Install the plugin', 'winter'); ?></h3><p><?php esc_html_e('Add SocialFeed to your WordPress website.', 'winter'); ?></p></div></li>
            <li><span>2</span><div><h3><?php esc_html_e('Connect Instagram or Facebook', 'winter'); ?></h3><p><?php esc_html_e('Use the guided connection flow through Web Studio WA.', 'winter'); ?></p></div></li>
            <li><span>3</span><div><h3><?php esc_html_e('Choose your display settings', 'winter'); ?></h3><p><?php esc_html_e('Set the feed, layout and front-end presentation.', 'winter'); ?></p></div></li>
            <li><span>4</span><div><h3><?php esc_html_e('Place the feed', 'winter'); ?></h3><p><?php esc_html_e('Use a shortcode or page block area where it makes sense.', 'winter'); ?></p></div></li>
        </ol>
    </div>
</section>

<section class="section socialfeed-built">
    <div class="container socialfeed-built__grid">
        <div><p class="eyebrow"><?php esc_html_e('For client websites', 'winter'); ?></p><h2><?php esc_html_e('Built for real client websites', 'winter'); ?></h2></div>
        <ul>
            <li><?php esc_html_e('No messy manual token handling for clients', 'winter'); ?></li>
            <li><?php esc_html_e('Responsive front-end display', 'winter'); ?></li>
            <li><?php esc_html_e('Caching to reduce repeated API requests', 'winter'); ?></li>
            <li><?php esc_html_e('Settings grouped for Instagram, Facebook, Display and Status/Tools', 'winter'); ?></li>
            <li><?php esc_html_e('Designed for ongoing support by Web Studio WA', 'winter'); ?></li>
        </ul>
    </div>
</section>

<section class="section socialfeed-status">
    <div class="container socialfeed-status__card">
        <p class="eyebrow"><?php esc_html_e('Status and availability', 'winter'); ?></p>
        <h2><?php esc_html_e('Currently being developed and tested', 'winter'); ?></h2>
        <p><?php esc_html_e('SocialFeed is currently being developed and tested for Web Studio WA client websites. Public availability, supported networks and final features may change as the plugin is refined.', 'winter'); ?></p>
        <p class="socialfeed-status__links"><a href="<?php echo esc_url(home_url('/plugins/socialfeed/terms/')); ?>"><?php esc_html_e('Terms', 'winter'); ?></a><a href="<?php echo esc_url(home_url('/plugins/socialfeed/privacy/')); ?>"><?php esc_html_e('Privacy', 'winter'); ?></a><a href="<?php echo esc_url(home_url('/plugins/socialfeed/support/')); ?>"><?php esc_html_e('Support', 'winter'); ?></a></p>
    </div>
</section>

<section class="section socialfeed-faq">
    <div class="container section__heading socialfeed-heading"><p class="eyebrow"><?php esc_html_e('FAQ', 'winter'); ?></p><h2><?php esc_html_e('Questions about SocialFeed', 'winter'); ?></h2></div>
    <div class="container socialfeed-faq__grid">
        <?php
        $faqs = [
            ['What is SocialFeed?', 'SocialFeed is a Web Studio WA WordPress plugin for displaying social feeds on websites.'],
            ['Does SocialFeed support Instagram?', 'Instagram support is planned and depends on Meta permissions and API approval.'],
            ['Does SocialFeed support Facebook Pages?', 'Facebook Page support is planned and depends on Meta permissions and API approval.'],
            ['Do clients need to copy access tokens?', 'The goal is an OAuth-based connection flow instead of manually copying access tokens.'],
            ['Is SocialFeed available publicly yet?', 'SocialFeed is currently in development and testing for Web Studio WA client websites.'],
            ['Where can I get support?', 'Visit the SocialFeed support page for help with testing or connecting an account.'],
        ];
        foreach ($faqs as [$question, $answer]) :
        ?>
            <article><h3><?php echo esc_html($question); ?></h3><p><?php echo esc_html($answer); ?></p></article>
        <?php endforeach; ?>
    </div>
</section>

<section class="socialfeed-cta">
    <div class="container"><p class="eyebrow"><?php esc_html_e('Web Studio WA support', 'winter'); ?></p><h2><?php esc_html_e('Need help with SocialFeed?', 'winter'); ?></h2><p><?php esc_html_e('If you are testing SocialFeed or need help connecting a social account, contact Web Studio WA support.', 'winter'); ?></p><a class="button button--primary" href="<?php echo esc_url(home_url('/plugins/socialfeed/support/')); ?>"><?php esc_html_e('SocialFeed support', 'winter'); ?></a></div>
</section>
<?php get_footer();
