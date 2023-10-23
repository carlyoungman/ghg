<?php

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
Template::get_flexible_components();

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package BOILERPLATE_THEME
 */


while ( have_posts() ) :
	the_post();
	the_content();
endwhile;


get_footer();
