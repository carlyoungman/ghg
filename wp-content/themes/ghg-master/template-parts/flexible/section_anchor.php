<?php
/**
 * Template file for displaying a section anchor
 *
 * @package ED_BOILERPLATE_THEME
 */
if (!defined('ABSPATH')):
	exit();
endif;
$base = 'section-anchor';
$section_anchor = get_sub_field('section_anchor');
?>

<section class="<?php echo esc_attr($base); ?>"
		 id="<?php echo esc_attr($section_anchor); ?>">
</section>

