<?php
/*
Template Name: Order Tracking
*/

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
echo do_shortcode( '[woocommerce_order_tracking]' );
Template::get_flexible_components();
get_footer();
