<?php
/**
 * Footer template.
 *
 * @package WebStudioWA
 */
?>
</main>
<footer class="site-footer">
    <div class="container footer__grid">
        <div>
            <a class="brand footer__brand" href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(wswa_asset('img/web-studio-wa-reversed.webp')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="165" height="143" loading="lazy" decoding="async">
            </a>
            <p><?php esc_html_e("Web design, development, optimisation and hosting support. Let's bring your vision to life.", 'winter'); ?></p>
        </div>
        <div>
            <h2><?php esc_html_e('Company', 'winter'); ?></h2>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'winter'); ?></a></li>
                <li><a href="<?php echo esc_url(wswa_page_url('about-us')); ?>"><?php esc_html_e('About us', 'winter'); ?></a></li>
                <li><a href="<?php echo esc_url(wswa_page_url('our-clients')); ?>"><?php esc_html_e('Our clients', 'winter'); ?></a></li>
                <li><a href="<?php echo esc_url(wswa_page_url('contact')); ?>"><?php esc_html_e('Contact us', 'winter'); ?></a></li>
            </ul>
        </div>
        <div>
            <h2><?php esc_html_e('Services', 'winter'); ?></h2>
            <ul class="footer-links">
                <li><a href="<?php echo esc_url(wswa_page_url('web-design')); ?>"><?php esc_html_e('Web Design', 'winter'); ?></a></li>
                <li><a href="<?php echo esc_url(wswa_page_url('website-maintenance')); ?>"><?php esc_html_e('Website Maintenance', 'winter'); ?></a></li>
                <li><a href="<?php echo esc_url(wswa_page_url('website-redesign')); ?>"><?php esc_html_e('Website Redesign', 'winter'); ?></a></li>
                <li><a href="<?php echo esc_url(wswa_page_url('web-hosting')); ?>"><?php esc_html_e('Web Hosting', 'winter'); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="container footer__bottom">
        <p>
            &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>.
            <!-- Temporary deployment test marker. Remove after GitHub Actions path test. -->
            <span style="display:inline-block;margin-left:0.5rem;font-size:0.68rem;opacity:0.72;">DEPLOY TEST - WebStudio GitHub Pipeline</span>
        </p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
