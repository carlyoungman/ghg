<?php
/*
Template Name: Checkout
*/

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
echo do_shortcode( '[woocommerce_checkout]' );
Template::get_flexible_components();
get_footer();
