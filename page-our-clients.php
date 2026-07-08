<?php
/**
 * Our clients page template.
 *
 * @package WebStudioWA
 */

$clients = wswa_clients();

get_header();
?>
<section class="section page-hero">
    <div class="container narrow">
        <p class="eyebrow"><?php esc_html_e('Our clients', 'winter'); ?></p>
        <h1><?php esc_html_e('Selected client work', 'winter'); ?></h1>
        <p><?php esc_html_e('A cleaner look at the businesses that trust Web Studio WA for website launches, redesigns and ongoing support.', 'winter'); ?></p>
    </div>
</section>

<section class="section">
    <div class="container client-portfolio">
        <?php foreach ($clients as $client) : ?>
            <article class="portfolio-card">
                <a class="portfolio-card__media" href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener">
                    <img class="<?php echo ! empty($client['uses_snapshot']) ? 'is-website-preview' : ''; ?>" src="<?php echo esc_url($client['image']); ?>" alt="<?php echo esc_attr($client['name']); ?>" width="520" height="390" loading="lazy" decoding="async">
                </a>
                <div class="portfolio-card__details">
                    <span><?php echo esc_html($client['type']); ?></span>
                    <h2><a href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($client['name']); ?></a></h2>
                    <?php if (! empty($client['summary'])) : ?>
                        <p><?php echo esc_html($client['summary']); ?></p>
                    <?php endif; ?>
                    <a class="text-link" href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener"><?php esc_html_e('Visit Website', 'winter'); ?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php
get_footer();
