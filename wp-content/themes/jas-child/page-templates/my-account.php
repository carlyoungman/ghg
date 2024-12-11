<?php
/*
Template Name: My account
*/

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
echo do_shortcode( '[woocommerce_my_account]' );
Template::get_flexible_components();
get_footer();
