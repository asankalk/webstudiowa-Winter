<?php
/**
 * About us page template.
 *
 * @package WebStudioWA
 */

get_header();
?>
<section class="section page-hero page-hero--split about-hero">
    <div class="container page-hero__grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('About Web Studio WA', 'winter'); ?></p>
            <h1><?php esc_html_e('Perth web design with practical support', 'winter'); ?></h1>
            <p><?php esc_html_e('Since 2017, Web Studio WA has helped Western Australian businesses create professional websites that look polished, work smoothly and stay manageable after launch.', 'winter'); ?></p>
        </div>
        <img src="<?php echo esc_url(wswa_asset('img/avrix-about.webp')); ?>" alt="<?php esc_attr_e('Web Studio WA project workspace', 'winter'); ?>" width="1200" height="800" decoding="async" fetchpriority="high">
    </div>
</section>

<section class="section">
    <div class="container content-grid">
        <div>
            <p class="eyebrow"><?php esc_html_e('How we work', 'winter'); ?></p>
            <h2><?php esc_html_e('Clear planning, modern design and dependable care', 'winter'); ?></h2>
        </div>
        <div class="rich-text">
            <p><?php esc_html_e('We believe every business should be able to access great design without unnecessary complexity. Our process starts with understanding your goals, then shaping a site structure, design and content flow around the people you want to reach.', 'winter'); ?></p>
            <p><?php esc_html_e('From concept through launch, we focus on responsive layouts, clean content, accessible navigation, SEO-friendly foundations and practical handover support.', 'winter'); ?></p>
            <p><?php esc_html_e('Our commitment continues after launch through maintenance, hosting guidance and friendly technical support when your website needs attention.', 'winter'); ?></p>
        </div>
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
<?php
get_footer();
