<?php
/**
 * Template file for displaying inline forms
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if (!defined('ABSPATH')):
	exit();
endif;
$base = 'faqs';
$content = get_sub_field('content');
$options = get_sub_field('options');
$options_array = [
	['background', $base . '--background-off-white has-background'],
];
$FAQs = get_sub_field('FAQs');
?>
<section class="<?php
echo esc_attr($base);
Template::apply_classes($options_array, $options);
?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div class="<?php echo esc_attr($base); ?>__content-wrap">
				<?php get_template_part('template-parts/content-block', null, [
    	'data' => [
    		'base' => $base,
    		'content' => $content,
    	],
    ]); ?>
			</div>
			<div class="<?php echo esc_attr($base); ?>__faq-wrap">
				<ul class="<?php echo esc_attr($base); ?>__faqs">
					<?php foreach ($FAQs as $FAQ): ?>
						<li class="<?php echo esc_attr($base); ?>__faq">
							<?php if ($FAQ['Question']): ?>
								<p class="<?php echo esc_attr(
        	$base
        ); ?>__faq__question"><span><?php echo esc_html(
	$FAQ['Question']
); ?></span>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
										 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
										 stroke-linejoin="round">
										<path d="m6 9 6 6 6-6"/>
									</svg>
								</p>
							<?php endif; ?>
							<?php if ($FAQ['Answer']): ?>
								<p class="<?php echo esc_attr($base); ?>__faq__answer"><?php echo esc_html(
	$FAQ['Answer']
); ?> </p>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>

			</div>
		</div>
	</div>
</section>
