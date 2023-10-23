<?php
/*==================================
|	Snippet Meta
==================================*/
if (function_exists('acf_add_local_field_group')) { {
	}

	acf_add_local_field_group([
		'key' => $prefix . 'theme_snippet',
		'title' => 'Snippet Settings',
		'menu_order' => 1,
		'fields' => [
			[
				'key' => $prefix . '3f47a7ebc',
				'name' => 'layout',
				'label' => 'Layout',
				'type' => 'radio',
				'default_value' => 'inline-text',
                'layout' => 'horizontal',
                'instructions' => 'Select a layout',
                'choices' => [
                    // 'center' => 'Centered',
                    'inline-text' => 'Inline'
				],
				'wrapper' => [
					'width' => 33
				]
			],
			[
				'key' => $prefix . '3f47a7ead',
				'name' => 'colour',
				'label' => 'Colour',
				'type' => 'radio',
				'default_value' => 'light',
                'layout' => 'horizontal',
                'instructions' => 'Select a colour scheme',
                'choices' => [
                    'light' => 'Light',
                    'dark' => 'Dark'
				],
				'wrapper' => [
					'width' => 33
				]
			],
			[
				'key' => $prefix . '3f47a7d1d',
				'name' => 'icon',
				'label' => 'Title Icon',
				'type' => 'true_false',
				'default_value' => 1,
                'instructions' => 'Toggle title icon (requires custom CSS)',
				'ui' => 1,
				'ui_on_text' => 'Show',
				'ui_off_text' => 'Hide',
				'wrapper' => [
					'width' => 33
				]
			],
			[
				'key' => $prefix . '3f47a7ebd',
				'name' => 'title',
				'label' => 'Title',
				'type' => 'text',
                'instructions' => 'Specify a snippet title',
			],
			[
				'key' => $prefix . '3f47a7eca',
				'name' => 'text',
				'label' => 'Text',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'br',
                'instructions' => 'Specify body text',
			],
			[
				'key' => $prefix . '3f47a7ecb',
				'name' => 'link',
				'label' => 'Link',
				'type' => 'link',
                'instructions' => 'Configure an optional link',
			],
		],

		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'snippet',
				],
			],
		],
	]);
}
