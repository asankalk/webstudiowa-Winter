<?php
/**
 * Page template.
 *
 * @package WebStudioWA
 */

get_header();
?>
<section class="section page-hero">
    <div class="container narrow">
        <?php while (have_posts()) : the_post(); ?>
            <p class="eyebrow"><?php echo esc_html(get_bloginfo('name')); ?></p>
            <h1><?php the_title(); ?></h1>
            <div class="entry-content"><?php the_content(); ?></div>
        <?php endwhile; ?>
    </div>
</section>
<?php
get_footer();

