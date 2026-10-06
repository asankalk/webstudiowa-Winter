<?php
/**
 * Template Name: Resource Article
 *
 * Shared template for Resources child pages.
 *
 * @package WebStudioWA
 */

$article = wswa_get_resource_article_by_slug((string) get_post_field('post_name', get_queried_object_id()));

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
        <?php foreach ($article['sections'] as $section) : ?>
            <h2><?php echo esc_html($section['heading']); ?></h2>
            <?php foreach ($section['paragraphs'] as $paragraph) : ?><p><?php echo esc_html($paragraph); ?></p><?php endforeach; ?>
        <?php endforeach; ?>
        <h2><?php esc_html_e('Helpful next steps', 'winter'); ?></h2>
        <p><?php esc_html_e('Choose the next step that matches the way your website is managed. The following links provide related tools and support options.', 'winter'); ?></p>
        <p class="resource-article__context-links"><?php foreach ($article['context_links'] as [$url, $label]) : ?><a href="<?php echo esc_url(home_url($url)); ?>"><?php echo esc_html($label); ?></a><?php endforeach; ?></p>
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

    <?php if (! empty($article['related_slugs'])) : ?>
        <section class="section resource-article__related"><div class="container">
            <p class="eyebrow"><?php esc_html_e('Keep reading', 'winter'); ?></p>
            <h2><?php esc_html_e('Related WordPress guides', 'winter'); ?></h2>
            <div class="resource-article__related-grid">
                <?php foreach (array_slice($article['related_slugs'], 0, 3) as $related_slug) : $related = wswa_get_resource_article_by_slug($related_slug); if (! $related) { continue; } ?>
                    <a href="<?php echo esc_url(home_url('/resources/' . $related_slug . '/')); ?>"><span><?php echo esc_html($related['category']); ?></span><strong><?php echo esc_html($related['title']); ?> →</strong></a>
                <?php endforeach; ?>
            </div>
        </div></section>
    <?php endif; ?>

    <section class="resource-article__cta"><div class="container"><p class="eyebrow"><?php esc_html_e('Web Studio WA resources', 'winter'); ?></p><h2><?php esc_html_e('Practical guidance for better website decisions', 'winter'); ?></h2><p><?php esc_html_e('Browse more WordPress guides, explore our plugins, or speak with Web Studio WA about ongoing website care.', 'winter'); ?></p><div class="hero__actions"><a class="button button--primary" href="<?php echo esc_url(home_url($article['support_url'])); ?>"><?php echo esc_html($article['support_label']); ?></a><a class="button button--ghost" href="<?php echo esc_url(home_url('/resources/')); ?>"><?php esc_html_e('Browse resources', 'winter'); ?></a></div></div></section>
</article>
<?php get_footer();
