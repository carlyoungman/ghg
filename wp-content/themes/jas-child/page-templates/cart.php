<?php
/*
Template Name: My Basket
*/

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
echo do_shortcode( '[woocommerce_cart]' );
Template::get_flexible_components();
get_footer();
