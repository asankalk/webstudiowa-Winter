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
        <p><?php esc_html_e('A collection of businesses that trust Web Studio WA for new websites, redesigns and ongoing website support.', 'winter'); ?></p>
    </div>
</section>

<section class="section">
    <div class="container client-portfolio">
        <?php foreach ($clients as $client) : ?>
            <article class="portfolio-card">
                <a href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener">
                    <img src="<?php echo esc_url(wswa_client_snapshot($client['url'])); ?>" alt="<?php echo esc_attr($client['name'] . ' website snapshot'); ?>">
                </a>
                <div>
                    <span><?php echo esc_html($client['type']); ?></span>
                    <h2><a href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($client['name']); ?></a></h2>
                    <a class="text-link" href="<?php echo esc_url($client['url']); ?>" target="_blank" rel="noopener"><?php esc_html_e('Visit Website', 'winter'); ?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php
get_footer();
