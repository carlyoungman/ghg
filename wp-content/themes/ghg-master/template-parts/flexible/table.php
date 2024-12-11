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

$base = 'table';
$content = get_sub_field('content');
$rows = get_sub_field('rows');
?>

<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__content-wrap">
			<?php get_template_part('template-parts/content-block', null, [
   	'data' => [
   		'base' => $base,
   		'content' => $content,
   	],
   ]); ?>
		</div>
		<?php if (!empty($rows)): ?>
			<ul class="<?php echo esc_attr($base); ?>__table">
				<?php foreach ($rows as $row): ?>
					<?php $columns = $row['columns']; ?>
					<li class="<?php echo esc_attr($base); ?>__table__row">
						<?php if (!empty($columns)): ?>
							<ul class="<?php echo esc_attr($base); ?>__table__columns">
								<?php foreach ($columns as $column): ?>
									<li class="<?php echo esc_attr($base); ?>__table__item"><?php echo esc_html(
	$column['value']
); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
