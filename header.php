<?php
/**
 * Header template.
 *
 * @package WebStudioWA
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('Skip to content', 'winter'); ?></a>
<header class="site-header" data-site-header>
    <div class="container header__inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(wswa_asset('img/web-studio-wa.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php endif; ?>
        </a>
        <button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="primary-menu">
            <span></span><span></span><span></span>
            <span class="screen-reader-text"><?php esc_html_e('Menu', 'winter'); ?></span>
        </button>
        <nav class="primary-nav" id="primary-menu" data-primary-nav aria-label="<?php esc_attr_e('Primary navigation', 'winter'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'fallback_cb' => 'wswa_fallback_menu',
                'menu_class' => 'menu',
            ]);
            ?>
        </nav>
        <a class="header__cta" href="mailto:<?php echo esc_attr(wswa_get_field('contact_email')); ?>"><?php esc_html_e('Get a quote', 'winter'); ?></a>
    </div>
</header>
<main id="main">

