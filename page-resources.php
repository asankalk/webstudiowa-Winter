<?php
/** Resources hub template. @package WebStudioWA */
$articles = wswa_get_resource_articles();
get_header();
?>
<section class="resources-hero"><div class="container resources-hero__grid"><div>
<p class="eyebrow"><?php esc_html_e('Web Studio WA Resources', 'winter'); ?></p>
<h1><?php esc_html_e('WordPress resources for safer, smarter websites', 'winter'); ?></h1>
<p><?php esc_html_e('Helpful WordPress guides for business owners, covering website security, access management, maintenance, SEO, accessibility and social media feeds.', 'winter'); ?></p>
<div class="hero__actions"><a class="button button--primary" href="#resource-articles"><?php esc_html_e('Browse articles', 'winter'); ?></a><a class="button button--ghost" href="<?php echo esc_url(home_url('/plugins/')); ?>"><?php esc_html_e('View plugins', 'winter'); ?></a></div>
</div><div class="resources-hero__visual" aria-label="<?php esc_attr_e('Web Studio WA resources library preview', 'winter'); ?>"><i></i><i></i><i></i><i></i></div></div></section>

<section class="section resources-categories"><div class="container section__heading"><p class="eyebrow"><?php esc_html_e('Browse by topic', 'winter'); ?></p><h2><?php esc_html_e('Practical resources for website care', 'winter'); ?></h2></div><div class="container resources-category-grid">
<?php foreach ([['WordPress Security', 'Practical ways to review admin access and build better website routines.'], ['WordPress Maintenance', 'Helpful notes for updates, backups, monitoring and reliable ongoing care.'], ['WordPress Plugins', 'Guides for choosing, using and supporting useful WordPress workflows.'], ['SEO & Accessibility', 'Plain-language advice for alt text, image quality and usable content.'], ['Social Media Feeds', 'Explainers for Instagram, Facebook and API-based feed connections.'], ['Website Care', 'Practical support ideas for keeping a business website useful and current.']] as [$title, $text]) : ?>
<article class="resource-card"><h3><?php echo esc_html($title); ?></h3><p><?php echo esc_html($text); ?></p></article>
<?php endforeach; ?></div></section>

<section class="section resources-articles" id="resource-articles"><div class="container section__heading"><p class="eyebrow"><?php esc_html_e('Featured guides', 'winter'); ?></p><h2><?php esc_html_e('Featured WordPress guides', 'winter'); ?></h2><p><?php esc_html_e('Practical guides for WordPress security, maintenance, accessibility, social feeds and plugin workflows.', 'winter'); ?></p></div><div class="container planned-article-grid">
<?php foreach ($articles as $slug => $article) : ?>
<a class="planned-article-card" href="<?php echo esc_url(home_url('/resources/' . $slug . '/')); ?>"><span><?php echo esc_html($article['category']); ?></span><h3><?php echo esc_html($article['title']); ?></h3><p><?php echo esc_html($article['excerpt']); ?></p><strong><?php esc_html_e('Read guide', 'winter'); ?> <b aria-hidden="true">→</b></strong></a>
<?php endforeach; ?></div></section>

<section class="resources-plugin-cta"><div class="container"><p class="eyebrow"><?php esc_html_e('Web Studio WA plugins', 'winter'); ?></p><h2><?php esc_html_e('Explore Web Studio WA plugins', 'winter'); ?></h2><p><?php esc_html_e('Our plugins are built from real website support needs, with a focus on practical admin workflows, clean display and ongoing maintenance.', 'winter'); ?></p><a class="button button--primary" href="<?php echo esc_url(home_url('/plugins/')); ?>"><?php esc_html_e('View WordPress plugins', 'winter'); ?></a></div></section>
<section class="resources-contact-cta"><div class="container"><p class="eyebrow"><?php esc_html_e('Practical website support', 'winter'); ?></p><h2><?php esc_html_e('Need help with your WordPress website?', 'winter'); ?></h2><p><?php esc_html_e('Web Studio WA can help with website maintenance, plugin setup, admin access reviews and practical improvements.', 'winter'); ?></p><a class="button button--primary" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Web Studio WA', 'winter'); ?></a></div></section>
<?php get_footer();
