<?php
/*==================================
|	Flexible Meta
==================================*/
global $wpdb;
if (function_exists('acf_add_local_field_group')) {
	$forms = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'frm_forms');

	if ($forms) {
		$formOpts[null] = 'None';
		foreach ($forms as $form) {
			$formOpts[$form->id] = $form->name;
		}
	} else {
		$formOpts[null] = 'No Forms';
	}

	acf_add_local_field_group([
		'key' => $prefix . 'theme_flexible',
		'title' => 'Page Content Builder',
		'menu_order' => 1,
		'fields' => [
			[
				'key' => $prefix . '5f64795047ebc',
				'name' => $prefix . 'flexible',
				'label' => 'Flexible Content Sections',
				'type' => 'flexible_content',
				'button_label' => 'Add Section',
				'layouts' => [
					// HERO
					'Hero' => [
						'key' => $prefix . '62ea8518bfb9',
						'name' => 'hero',
						'label' => 'Hero Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '62ea8518bfc1',
								'name' => 'layout',
								'label' => 'Layout',
								'type' => 'radio',
								'instructions' => 'Select a layout mode',
								'layout' => 'horizontal',
								'wrapper' => [
									'width' => 50,
								],
								'choices' => [
									'full' => 'Full-width',
									'inline' => 'Inline',
								],
								'default_value' => 'default',
							],
							[
								'key' => $prefix . '62ea8518bfc2',
								'name' => '',
								'label' => '',
								'type' => '',
								'wrapper' => [
									'width' => 50,
								],
								'conditional_logic' => [
									'field' => $prefix . '62ea8518bfc1',
									'operator' => '==',
									'value' => 'full',
								],
							],
							[
								'key' => $prefix . '62ea8518bfc1a',
								'name' => 'order',
								'label' => 'Order',
								'type' => 'radio',
								'instructions' => 'Select an inline order',
								'layout' => 'horizontal',
								'conditional_logic' => [
									[
										'field' => $prefix . '62ea8518bfc1',
										'operator' => '==',
										'value' => 'inline',
									],
								],
								'wrapper' => [
									'width' => 50,
								],
								'choices' => [
									'image' => 'Image First',
									'text' => 'Text First',
								],
								'default_value' => 'image',
							],
							[
								'key' => $prefix . '62ea8518bfb9a',
								'name' => 'media',
								'label' => 'Media',
								'type' => 'file',
								'instructions' =>
									'Select a valid image or video',
								'mime_types' => 'jpg, jpeg, mp4, m4v, png',
								'wrapper' => [
									'width' => 50,
								],
							],
							[
								'key' => $prefix . '62ea8518bfc1b',
								'name' => 'media_mobile',
								'label' => 'Media (Mobile)',
								'type' => 'file',
								'instructions' =>
									'Select a valid image or video for mobile devices (defaults to desktop)',
								'mime_types' => 'jpg, jpeg, mp4, m4v, png',
								'wrapper' => [
									'width' => 50,
								],
							],
							[
								'key' => $prefix . '62ea8518bfb9b',
								'name' => 'title',
								'label' => 'Title ',
								'type' => 'text',
								'instructions' =>
									'Specify a section title (defaults to page title)',
								'wrapper' => [
									'width' => 50,
								],
							],
							[
								'key' => $prefix . '62ea8518bfb0a',
								'name' => 'size',
								'label' => 'Title Size ',
								'type' => 'radio',
								'layout' => 'horizontal',
								'default_value' => 'default',
								'choices' => [
									'default' => 'Default',
									'small' => 'Small',
								],
								'instructions' => 'Select a title size',
								'wrapper' => [
									'width' => 50,
								],
							],
							[
								'key' => $prefix . '62ea8518bfb9c',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'rows' => 3,
								'new_lines' => 'br',
								'instructions' => 'Specify optional body text',
							],
							[
								'key' => $prefix . '62ea8518bfb9d',
								'name' => 'link',
								'label' => 'Link',
								'type' => 'link',
								'instructions' => 'Configure an optional link',
							],
							[
								'key' => $prefix . '62ea8518bfb9e',
								'name' => 'ticker',
								'label' => 'Ticker Text',
								'type' => 'text',
								'instructions' =>
									'Specify scrolling ticker text (leave blank to hide feature)',
							],
						],
					],

					// CENTER
					'Center' => [
						'key' => $prefix . '5a2be3b9',
						'name' => 'center_text',
						'label' => 'Center Text Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '5a2be3b9a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '5a2be3b9b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify body text',
							],
							[
								'key' => $prefix . '5a2be3b9c',
								'name' => 'link',
								'label' => 'Link',
								'type' => 'link',
								'instructions' => 'Configure an optional link',
							],
						],
					],

					// MAP
					'Map' => [
						'key' => $prefix . '5b1ae8b9',
						'name' => 'map',
						'label' => 'Map Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '5b1ae8b9a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '5b1ae8b9b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify body text',
							],
							[
								'key' => $prefix . '5b1ae8b9c',
								'name' => 'location',
								'label' => 'Location',
								'type' => 'google_map',
								'instructions' => 'Select a location address',
							],
						],
					],

					// INLINE TEXT
					'Inline Text' => [
						'key' => $prefix . '4b1ad3b9',
						'name' => 'inline_text',
						'label' => 'Inline Text Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '4b1ad3b9a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '4b1ad3b9b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify body text',
							],
							[
								'key' => $prefix . '4b1ad3b9c',
								'name' => 'link',
								'label' => 'Link',
								'type' => 'link',
								'instructions' => 'Configure an optional link',
							],
						],
					],

					// INLINE MEDIA
					'Inline Media' => [
						'key' => $prefix . '3a1ab8b9',
						'name' => 'inline_media',
						'label' => 'Inline Media Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '3a1ab8b9a',
								'name' => 'layout',
								'label' => 'Layout',
								'type' => 'radio',
								'instructions' => 'Select a layout',
								'default_value' => 'default',
								'layout' => 'horizontal',
								'wrapper' => [
									'width' => 33,
								],
								'choices' => [
									'default' => 'Default',
									'contained' => 'Contained',
									'blocks' => 'Blocks',
								],
							],
							[
								'key' => $prefix . '3a1ab8c1a',
								'name' => 'order',
								'label' => 'Order',
								'type' => 'radio',
								'instructions' => 'Select an order',
								'default_value' => 'media',
								'layout' => 'horizontal',
								'wrapper' => [
									'width' => 33,
								],
								'choices' => [
									'media' => 'Media First',
									'text' => 'Text First',
								],
							],
							[
								'key' => $prefix . '3a1ab8c1c',
								'name' => 'colour',
								'label' => 'Colour',
								'type' => 'radio',
								'instructions' => 'Select a colour scheme',
								'default_value' => 'light',
								'layout' => 'horizontal',
								'wrapper' => [
									'width' => 33,
								],
								'choices' => [
									'light' => 'Light',
									'dark' => 'Dark',
								],
								'conditional_logic' => [
									'field' => $prefix . '3a1ab8b9a',
									'operator' => '==',
									'value' => 'contained',
								],
							],
							[
								'key' => $prefix . '3a1ab8b1b',
								'name' => 'media',
								'label' => 'Media',
								'type' => 'file',
								'instructions' => 'Select an image/video file',
							],
							[
								'key' => $prefix . '3a1ab8b9d',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify section title',
							],
							[
								'key' => $prefix . '3a1ab8b9b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify body text',
							],
							[
								'key' => $prefix . '3a1ab8b9c',
								'name' => 'link',
								'label' => 'Link',
								'type' => 'link',
								'instructions' => 'Configure an optional link',
							],
						],
					],

					// INLINE FORM
					'Inline Form' => [
						'key' => $prefix . '3b2bc9c0',
						'name' => 'inline_form',
						'label' => 'Inline Form Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							// [
							// 	'key' => $prefix . '3a1ab8c1a',
							// 	'name' => 'order',
							// 	'label' => 'Order',
							// 	'type' => 'radio',
							// 	'instructions' => 'Select an order',
							// 	'default_value' => 'media',
							// 	'layout' => 'horizontal',
							// 	'wrapper' => [
							// 		'width' => 33,
							// 	],
							// 	'choices' => [
							// 		'media' => 'Media First',
							// 		'text' => 'Text First',
							// 	]
							// ],
							[
								'key' => $prefix . '3b2bc9c0a',
								'name' => 'form',
								'label' => 'Form',
								'type' => 'select',
								'choices' => $formOpts,
								'instructions' => 'Select form to display',
							],
							[
								'key' => $prefix . '3b2bc9c0b',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify section title',
							],
							[
								'key' => $prefix . '3b2bc9c0c',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify body text',
							],
							[
								'key' => $prefix . '3b2bc9c0d',
								'name' => 'link',
								'label' => 'Link',
								'type' => 'link',
								'instructions' => 'Configure an optional link',
							],
						],
					],

					// CHECKLIST
					'Checklist' => [
						'key' => $prefix . '9b2ca419',
						'name' => 'checklist',
						'label' => 'Checklist Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '9b2ca419a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '9b2ca419b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify intro text',
							],
							[
								'key' => $prefix . '9b2ca419c',
								'name' => 'entries',
								'label' => 'Entries',
								'type' => 'repeater',
								'max' => 8,
								'button_label' => 'Add Entry',
								'instructions' =>
									'Configure up to 8 list entries',
								'sub_fields' => [
									[
										'key' => $prefix . '9b2ca410a',
										'name' => 'text',
										'label' => 'Text',
										'type' => 'text',
										'instructions' =>
											'Specify list entry text',
									],
								],
							],
						],
					],

					// BLOCKS
					'Blocks' => [
						'key' => $prefix . '9a1cd4b9',
						'name' => 'blocks',
						'label' => 'Blocks Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '9a1cd4b9a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '9a1cd4b9b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify intro text',
							],
							[
								'key' => $prefix . '9a1cd4b9c',
								'name' => 'entries',
								'label' => 'Entries',
								'type' => 'repeater',
								'max' => 4,
								'button_label' => 'Add Entry',
								'instructions' =>
									'Configure up to 4 blocks of content',
								'sub_fields' => [
									[
										'key' => $prefix . '9a1cd4b9d',
										'name' => 'icon',
										'label' => 'Icon',
										'type' => 'image',
										'instructions' => 'SVG recommended',
										'preview_size' => 'acf_thumb',
										'wrapper' => [
											'width' => 33,
										],
									],
									[
										'key' => $prefix . '9a1cd4b0a',
										'name' => 'label',
										'label' => 'Label',
										'type' => 'text',
										'instructions' => 'Specify short text',
										'wrapper' => [
											'width' => 66,
										],
									],
								],
							],
						],
					],

					// GRID
					'Grid' => [
						'key' => $prefix . '8b2db7b9',
						'name' => 'grid',
						'label' => 'Grid Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '8b2db7b9a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '8b2db7b9b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify intro text',
							],
							[
								'key' => $prefix . '8b2db7b9c',
								'name' => 'entries',
								'label' => 'Entries',
								'type' => 'repeater',
								'max' => 9,
								'button_label' => 'Add Entry',
								'instructions' =>
									'Configure up to 9 grid entries',
								'sub_fields' => [
									[
										'key' => $prefix . '8b2db7b9d',
										'name' => 'icon',
										'label' => 'Icon',
										'type' => 'image',
										'instructions' => 'SVG recommended',
										'preview_size' => 'acf_thumb',
										'wrapper' => [
											'width' => 33,
										],
									],
									[
										'key' => $prefix . '8b2db7b0a',
										'name' => 'label',
										'label' => 'Label',
										'type' => 'text',
										'instructions' => 'Specify short text',
										'wrapper' => [
											'width' => 66,
										],
									],
								],
							],
						],
					],

					// CARDS
					'Cards' => [
						'key' => $prefix . '9a2dc739',
						'name' => 'cards',
						'label' => 'Cards Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '9a2dc739a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '9a2dc739b',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify intro text',
							],
							[
								'key' => $prefix . '9a2dc739c',
								'name' => 'entries',
								'label' => 'Entries',
								'type' => 'repeater',
								'button_label' => 'Add Entry',
								'instructions' => 'Configure multiple cards',
								'sub_fields' => [
									[
										'key' => $prefix . '9a2dc739d',
										'name' => 'media',
										'label' => 'Media',
										'type' => 'file',
										'instructions' => 'JPG/MP4 recommended',
										'wrapper' => [
											'width' => 33,
										],
									],
									[
										'key' => $prefix . '9a2dc730b',
										'name' => 'title',
										'label' => 'Title',
										'type' => 'text',
										'instructions' =>
											'Specify a card title',
										'wrapper' => [
											'width' => 23,
										],
									],
									[
										'key' => $prefix . '9a2dc730a',
										'name' => 'text',
										'label' => 'Text',
										'type' => 'wysiwyg',
										'new_lines' => 'br',
										'rows' => 3,
										'instructions' => 'Specify card text',
										'wrapper' => [
											'width' => 43,
										],
									],
								],
							],
						],
					],

					// FEATURED
					'Featured' => [
						'key' => $prefix . '4b2ab6d9',
						'name' => 'featured',
						'label' => 'Featured Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '4b2ab6d9a',
								'name' => 'colour',
								'label' => 'Colour',
								'type' => 'radio',
								'instructions' => 'Select a colour scheme',
								'default_value' => 'light',
								'layout' => 'horizontal',
								'choices' => [
									'light' => 'Light',
									'dark' => 'Dark',
								],
							],
							[
								'key' => $prefix . '4b2ab6d9b',
								'name' => 'media',
								'label' => 'Media',
								'type' => 'file',
								'instructions' => 'Select an image/video file',
							],
							[
								'key' => $prefix . '4b2ab6d9d',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify section title',
							],
							[
								'key' => $prefix . '4b2ab6d9e',
								'name' => 'text',
								'label' => 'Text',
								'type' => 'wysiwyg',
								'new_lines' => 'br',
								'rows' => 3,
								'instructions' => 'Specify body text',
							],
							[
								'key' => $prefix . '4b2ab6d9c',
								'name' => 'link',
								'label' => 'Link',
								'type' => 'link',
								'instructions' => 'Configure an optional link',
							],
						],
					],

					// SLIDER
					'Slider' => [
						'key' => $prefix . '8a2c48b9',
						'name' => 'slider',
						'label' => 'Slider Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '8a2c48b9a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
							],
							[
								'key' => $prefix . '8a2c48b9c',
								'name' => 'entries',
								'label' => 'Entries',
								'type' => 'repeater',
								'max' => 4,
								'button_label' => 'Add Entry',
								'instructions' =>
									'Configure up to 4 blocks of content',
								'sub_fields' => [
									[
										'key' => $prefix . '8a2c48b9d',
										'name' => 'image',
										'label' => 'Image',
										'type' => 'image',
										'instructions' =>
											'Select an image or icon',
										'preview_size' => 'acf_thumb',
										'wrapper' => [
											'width' => 30,
										],
									],
									[
										'key' => $prefix . '8a2c48asd',
										'name' => 'link',
										'label' => 'Link',
										'type' => 'link',
										'instructions' =>
											'Add an optional link',
										'wrapper' => [
											'width' => 30,
										],
									],
									[
										'key' => $prefix . '8a2c48b0a',
										'name' => 'text',
										'label' => 'Text',
										'type' => 'text',
										'instructions' => 'Specify short text',
										'wrapper' => [
											'width' => 60,
										],
									],
								],
							],
						],
					],

					// TESTIMONIAL
					'Testimonial' => [
						'key' => $prefix . '3c5b8b61',
						'name' => 'testimonial',
						'label' => 'Testimonial Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '3c5b8b61a',
								'name' => 'title',
								'label' => 'Title',
								'type' => 'text',
								'instructions' => 'Specify a title',
								'placeholder' => 'What our clients say',
								'default_value' => 'What our clients say',
							],
							[
								'key' => $prefix . '3c5b8b61b',
								'name' => 'image',
								'label' => 'Logo',
								'type' => 'image',
								'preview_size' => 'acf_thumb',
								'instructions' => 'Select an optional logo',
							],
							[
								'key' => $prefix . '3c5b8b61d',
								'name' => 'text',
								'label' => 'Quote',
								'type' => 'wysiwyg',
								'rows' => 3,
								'instructions' => 'Specify quote text',
							],
						],
					],

					// WYSIWYG
					'WYSIWYG' => [
						'key' => $prefix . '1ba35b91',
						'name' => 'wysiwyg',
						'label' => 'WYSIWYG Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '1ba35b91a',
								'name' => 'content',
								'label' => 'Content',
								'type' => 'wysiwyg',
								'instructions' =>
									'Specify content (HTML allowed)',
							],
						],
					],

					// SNIPPET
					'Snippet' => [
						'key' => $prefix . '4b6b7b61',
						'name' => 'snippet',
						'label' => 'Snippet Section',
						'type' => 'group',
						'layout' => 'row',
						'sub_fields' => [
							[
								'key' => $prefix . '4b6b7b61a',
								'name' => 'content',
								'label' => 'Content',
								'type' => 'post_object',
								'instructions' =>
									'Select which snippet content to display',
								'post_type' => 'snippet',
							],
						],
					],
				],
			],
		],

		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				],
			],
		],
	]);
}
