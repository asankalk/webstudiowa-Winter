<?php
/**
 * Website redesign service page.
 *
 * @package WebStudioWA
 */

get_header();
get_template_part('template-parts/service', 'detail', ['service' => wswa_service_by_slug('website-redesign')]);
get_footer();
