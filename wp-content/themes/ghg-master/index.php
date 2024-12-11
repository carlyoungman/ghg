<?php
/*==================================
|	  Index Page Template
==================================*/
?>

<?php
use BOILERPLATE_THEME\Core\Module\Template;

get_header();
$display_page_header = get_field('display_page_header');
if (!empty($display_page_header)):
	get_template_part('/template-parts/page-header');
endif;
?>
<?php Template::get_flexible_components(); ?>
<?php get_footer(); ?>
