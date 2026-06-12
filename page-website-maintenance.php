<?php
/**
 * Website maintenance service page.
 *
 * @package WebStudioWA
 */

get_header();
get_template_part('template-parts/service', 'detail', ['service' => wswa_service_by_slug('website-maintenance')]);
get_footer();
