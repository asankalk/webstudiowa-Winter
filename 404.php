<?php
/**
 * 404 template.
 *
 * @package WebStudioWA
 */

get_header();
?>
<section class="section page-hero">
    <div class="container narrow">
        <p class="eyebrow"><?php esc_html_e('404', 'winter'); ?></p>
        <h1><?php esc_html_e('Page not found', 'winter'); ?></h1>
        <p><?php esc_html_e('The page you are looking for may have moved. Head back home or contact Web Studio WA for help.', 'winter'); ?></p>
        <a class="button button--primary" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back home', 'winter'); ?></a>
    </div>
</section>
<?php
get_footer();

