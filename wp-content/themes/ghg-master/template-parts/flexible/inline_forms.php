<?php
/**
 * Template file for displaying inline forms
 *
 * @package ED_BOILERPLATE_THEME
 */
if (!defined('ABSPATH')):
	exit();
endif;
$base = 'inline-forms';
$content = get_sub_field('content');
$form = get_sub_field('form');
?>


<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div>
				<?php get_template_part('template-parts/content-block', null, [
    	'data' => [
    		'base' => $base,
    		'content' => $content,
    	],
    ]); ?>
			</div>
			<div>
				<?php echo do_shortcode('[formidable id="' . $form['value'] . '"]'); ?>
			</div>
		</div>
	</div>
</section>

<script>
	// Function to get URL parameter by name
	function getUrlParameter(name) {
		name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
		const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
		const results = regex.exec(location.search);
		return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
	}

	// Function to set subject
	function setSubject(partNumber) {
		const subject = "CAD drawing request for part number: " + partNumber;
		const subjectInput = document.getElementById('field_e6lis6');
		if (subjectInput) {
			subjectInput.value = subject;
			console.log('Subject set successfully:', subject);
		} else {
			console.log('Subject input field not found.');
		}
	}

	// Function to set message
	function setMessage(partNumber) {
		const message = "I would like to request a CAD drawing for part number " + partNumber;
		const messageInput = document.getElementById('field_9jv0r1');
		if (messageInput) {
			messageInput.value = message;
			console.log('Message set successfully:', message);
		} else {
			console.log('Message input field not found.');
		}
	}

	// Usage
	const partNumber = getUrlParameter('part-number');
	if (partNumber) {
		console.log('Part number found:', partNumber);
		setSubject(partNumber);
		setMessage(partNumber);
	} else {
		console.log('Part number not found in the URL.');
	}
</script>
