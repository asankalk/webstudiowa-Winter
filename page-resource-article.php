<?php
/**
 * Shared template for Resources child pages.
 *
 * @package WebStudioWA
 */

$article = wswa_resource_article((string) get_post_field('post_name', get_queried_object_id()));

if (! $article) {
    get_template_part('page');
    return;
}

get_header();
?>
<article class="resource-article">
    <header class="resource-article__hero"><div class="container">
        <p class="eyebrow"><?php echo esc_html($article['category']); ?></p>
        <h1><?php echo esc_html($article['title']); ?></h1>
        <p><?php echo esc_html($article['intro']); ?></p>
        <a class="resource-article__back" href="<?php echo esc_url(home_url('/resources/')); ?>">← <?php esc_html_e('Back to resources', 'winter'); ?></a>
    </div></header>

    <section class="section resource-article__content"><div class="container resource-article__grid"><div>
        <h2><?php esc_html_e('What to consider', 'winter'); ?></h2>
        <?php foreach ($article['points'] as $point) : ?><p><?php echo esc_html($point); ?></p><?php endforeach; ?>
        <h2><?php esc_html_e('A practical checklist', 'winter'); ?></h2>
        <ul><?php foreach ($article['checklist'] as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?></ul>
        <h2><?php esc_html_e('Keep the next step simple', 'winter'); ?></h2>
        <p><?php esc_html_e('This guide is general information for website owners, not legal or cybersecurity advice. When something needs a closer look, document the issue and get the right support before making broad changes.', 'winter'); ?></p>
    </div><aside class="resource-article__aside"><p class="eyebrow"><?php esc_html_e('Related support', 'winter'); ?></p>
        <h2><?php echo esc_html($article['cta_label']); ?></h2>
        <p><?php esc_html_e('Explore the relevant Web Studio WA service or plugin, or get in touch to discuss your website.', 'winter'); ?></p>
        <a class="button button--primary" href="<?php echo esc_url(home_url($article['cta_url'])); ?>"><?php echo esc_html($article['cta_label']); ?></a>
        <a class="text-link" href="<?php echo esc_url(home_url($article['secondary_url'])); ?>"><?php echo esc_html($article['secondary_label']); ?> →</a>
    </aside></div></section>

    <section class="resource-article__cta"><div class="container"><p class="eyebrow"><?php esc_html_e('Web Studio WA resources', 'winter'); ?></p><h2><?php esc_html_e('Practical guidance for better website decisions', 'winter'); ?></h2><p><?php esc_html_e('Browse more WordPress guides, explore our plugins, or speak with Web Studio WA about ongoing website care.', 'winter'); ?></p><div class="hero__actions"><a class="button button--primary" href="<?php echo esc_url(home_url('/resources/')); ?>"><?php esc_html_e('Browse resources', 'winter'); ?></a><a class="button button--ghost" href="<?php echo esc_url(home_url('/plugins/')); ?>"><?php esc_html_e('View plugins', 'winter'); ?></a></div></div></section>
</article>
<?php get_footer();
