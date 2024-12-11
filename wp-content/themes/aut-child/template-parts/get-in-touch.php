<?php
/**
 * Template part get in touch
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if (!defined('ABSPATH')):
	exit();
endif;

$base = 'get-in-touch';
$content = get_field('get_in_touch_content', 'options') ?? [];
$headline = get_field('get_in_touch_content', 'options')['headline'] ?? '';
$formID = get_field('form', 'options')['value'] ?? 0;
$phone_number = get_field('phone_number', 'option');
$email = get_field('email_address', 'option');
$content['headline'] = '';
?>
<section class="<?php echo $base; ?> has-background">
	<div class="<?php echo $base; ?>__inner">
		<div class="<?php echo $base; ?>__grid">
			<div>
				<?php if (!empty($headline)): ?>
					<h2>
						<?php echo esc_html($headline); ?>
					</h2>
				<?php endif; ?>
				<?php get_template_part('template-parts/content-block', null, [
    	'data' => [
    		'base' => $base,
    		'content' => $content,
    	],
    ]); ?>
				<div class="<?php echo $base; ?>__button-gird">
					<?php
     Template::generateContactLink($phone_number, 'tel', $base);
     Template::generateContactLink($email, 'email', $base);
     ?>
				</div>
			</div>
		</div>
	</div>
</section>
