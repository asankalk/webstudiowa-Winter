<?php
/**
 * Contact page template.
 *
 * @package WebStudioWA
 */

$status = sanitize_key($_GET['contact'] ?? '');

get_header();
?>
<section class="section page-hero">
    <div class="container contact-form-wrap">
        <p class="eyebrow"><?php esc_html_e('Contact', 'winter'); ?></p>
        <h1><?php echo esc_html(wswa_get_field('contact_title')); ?></h1>
        <p><?php echo esc_html(wswa_get_field('contact_text')); ?></p>
    </div>
</section>

<section class="section contact-page">
    <div class="container contact-form-wrap">
        <p class="contact-location"><?php echo esc_html(wswa_get_field('contact_address')); ?></p>
        <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="wswa_contact">
            <?php wp_nonce_field('wswa_contact', 'wswa_contact_nonce'); ?>
            <?php if ($status === 'sent') : ?>
                <p class="form-alert form-alert--success"><?php esc_html_e('Thanks, your message has been sent.', 'winter'); ?></p>
            <?php elseif ($status === 'spam_failed') : ?>
                <p class="form-alert"><?php esc_html_e('Spam protection check failed. Please try again.', 'winter'); ?></p>
            <?php elseif ($status) : ?>
                <p class="form-alert"><?php esc_html_e('Please check the form details and try again.', 'winter'); ?></p>
            <?php endif; ?>
            <div class="wswa-honeypot" aria-hidden="true">
                <label for="company_website">
                    <?php esc_html_e('Company website', 'winter'); ?>
                </label>
                <input id="company_website" type="text" name="company_website" autocomplete="off" tabindex="-1">
            </div>
            <label>
                <?php esc_html_e('Name', 'winter'); ?>
                <input type="text" name="name" required>
            </label>
            <label>
                <?php esc_html_e('Email', 'winter'); ?>
                <input type="email" name="email" required>
            </label>
            <label>
                <?php esc_html_e('Phone', 'winter'); ?>
                <input type="tel" name="phone">
            </label>
            <label>
                <?php esc_html_e('What can we help with?', 'winter'); ?>
                <select name="service">
                    <option value="Web Site Design"><?php esc_html_e('Web Site Design', 'winter'); ?></option>
                    <option value="Website Redesign"><?php esc_html_e('Website Redesign', 'winter'); ?></option>
                    <option value="Web Site Maintenance"><?php esc_html_e('Web Site Maintenance', 'winter'); ?></option>
                    <option value="Web Hosting"><?php esc_html_e('Web Hosting', 'winter'); ?></option>
                </select>
            </label>
            <label>
                <?php esc_html_e('Message', 'winter'); ?>
                <textarea name="message" rows="6" required></textarea>
            </label>
            <?php if (wswa_get_turnstile_site_key() !== '') : ?>
                <div class="wswa-turnstile">
                    <div class="cf-turnstile" data-sitekey="<?php echo esc_attr(wswa_get_turnstile_site_key()); ?>"></div>
                </div>
            <?php endif; ?>
            <button class="button button--primary" type="submit"><?php esc_html_e('Send enquiry', 'winter'); ?></button>
        </form>
    </div>
</section>
<?php
get_footer();
