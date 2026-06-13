<?php
/**
 * Footer template.
 *
 * @package WebStudioWA
 */

$email = wswa_get_field('contact_email');
$phone = wswa_get_field('contact_phone');
$address = wswa_get_field('contact_address');
?>
</main>
<footer class="site-footer">
    <div class="container footer__grid">
        <div>
            <a class="brand footer__brand" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(wswa_asset('img/web-studio-wa-reversed.webp')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="190" height="165" loading="lazy" decoding="async">
            </a>
            <p><?php esc_html_e("Web design, development, optimisation and hosting support. Let's bring your vision to life.", 'winter'); ?></p>
        </div>
        <div>
            <h2><?php esc_html_e('Company', 'winter'); ?></h2>
            <?php wswa_fallback_menu(); ?>
        </div>
        <?php if (! is_page('contact')) : ?>
            <div>
                <h2><?php esc_html_e('Contact Info', 'winter'); ?></h2>
                <ul class="footer-contact">
                    <li><?php echo esc_html($address); ?></li>
                    <li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
                    <li><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <div class="container footer__bottom">
        <p>&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>.</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
