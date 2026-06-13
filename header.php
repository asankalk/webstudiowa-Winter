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
            <img src="<?php echo esc_url(wswa_asset('img/web-studio-wa.webp')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="190" height="165" decoding="async">
        </a>
        <button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="primary-menu">
            <span></span><span></span><span></span>
            <span class="screen-reader-text"><?php esc_html_e('Menu', 'winter'); ?></span>
        </button>
        <nav class="primary-nav" id="primary-menu" data-primary-nav aria-label="<?php esc_attr_e('Primary navigation', 'winter'); ?>">
            <?php wswa_fallback_menu(); ?>
        </nav>
        <?php if (! is_page('contact')) : ?>
            <a class="header__cta" href="<?php echo esc_url(wswa_page_url('contact')); ?>"><?php esc_html_e('Get a quote', 'winter'); ?></a>
        <?php endif; ?>
    </div>
</header>
<main id="main">
