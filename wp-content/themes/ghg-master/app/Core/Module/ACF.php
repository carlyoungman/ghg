<?php

/**
 * Class ACF
 *
 * A class to register and build ACF blocks
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Class Ajax
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class ACF {
	/**
	 * Retrieves the flexible components for a specific site.
	 *
	 * @return void
	 */
	public static function flexible_components(): void {
		global $wpdb;
		// Get the current site ID in a Multisite environment
		$site_id = get_current_blog_id();
		// Use the correct prefix for the current site
		$table_name = $wpdb->prefix . 'frm_forms';

		// Query the database for the forms of the current site
		$forms = $wpdb->get_results( "SELECT * FROM $table_name" );

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$formOpts[] = [
					$form->id => $form->name,
				];
			}
		}

		$flexible = new FieldsBuilder( 'flexible_components' );

		$flexible
			->addFlexibleContent( 'flexible' )
			// Card grid
			->addLayout( 'cards_grid' )
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addTab( 'cards' )
			->addRepeater( 'Cards', [
				'min'    => 1,
				'max'    => 10,
				'layout' => 'block',
			] )
			->addImage( 'image', [
				'preview_size' => 'small',
				'instructions' => 'Upload a suitable image or icon',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addGroup( 'Details', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'headline', [
				'instructions' => 'Enter a headline for the card',
			] )
			->addText( 'Supporting_content', [
				'instructions' =>
					'Enter some supporting content for the card. This text will be highlighted',
			] )
			->addTextarea( 'additional_content', [
				'instructions' => 'Enter some additional  content',
			] )
			->addLink( 'link', [
				'instructions' => 'Link the card to a webpage',
			] )
			->endGroup()
			->endRepeater()
			// Case Studies
			->addLayout( 'case_studies' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_case_studies', [
				'instructions' =>
					'Select the number of case studies you want to display.',
				'choices'      => [
					3   => '3',
					6   => '6',
					9   => '9',
					12  => '12',
					- 1 => 'All',
				],
			] )
			->addTrueFalse( 'select_case_studies', [
				'instructions' => 'Enable to select individual case studies.',
				'ui'           => 1,
			] )
			->addPostObject( 'filter_by_sector', [
				'instructions'      => 'Select which sector to filter by.',
				'post_type'         => [ 'sectors' ],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_case_studies',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addPostObject( 'individual_case_studies', [
				'instructions'      =>
					'Select which individual case studies you want to display.',
				'post_type'         => [
					0 => 'case_studies',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_case_studies',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->endGroup()
			// Content block
			->addLayout( 'content_block' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [ 'wrapper' => [ 'width' => '50' ] ] )
			->addTrueFalse( 'max_width', [
				'instructions' =>
					'Enable if you want to apply a max width to the content',
				'ui'           => 1,
			] )
			->addTrueFalse( 'center_align', [
				'instructions' =>
					'Enable if you want to center align the content',
				'ui'           => 1,
			] )
			->endGroup()
			// Listing block
			->addLayout( 'listing_block' )
			->addGroup( 'options' )
			->addTrueFalse( 'background', [
				'instructions' => 'Select the background colour of the block',
				'ui'           => 1,
				'ui_on_text'   => 'Primary',
				'ui_off_text'  => 'Secondary',
			] )
			->endGroup()
			->addTab( 'list' )
			->addRepeater( 'list', [
				'min'          => 0,
				'layout'       => 'block',
				'instructions' =>
					'List items will automatically be arranged into blocks of three',
			] )
			->addText( 'list_item' )
			->endRepeater()
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Specify list item text',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			// Current Vacancies
			->addLayout( 'current_vacancies' )
			->addGroup( 'options' )
			->addTrueFalse( 'background', [
				'instructions' => 'Select the background colour of the block',
				'ui'           => 1,
				'ui_on_text'   => 'Primary',
				'ui_off_text'  => 'Secondary',
			] )
			->endGroup()
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addTab( 'cards' )
			->addRepeater( 'Cards', [
				'min'    => 1,
				'max'    => 10,
				'layout' => 'block',
			] )
			->addGroup( 'Details', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'job_title', [
				'instructions' => 'Enter the job title',
			] )
			->addTextarea( 'job_description', [
				'instructions' => 'Enter a job description',
			] )
			->addText( 'posted_date' )
			->addLink( 'link', [
				'instructions' => 'Link the card to a webpage',
			] )
			->endGroup()
			->endRepeater()
			// Group listing
			->addLayout( 'group_listing' )
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addTab( 'Group' )
			->addRepeater( 'group', [
				'min'    => 1,
				'max'    => 10,
				'layout' => 'block',
			] )
			->addImage( 'image', [
				'preview_size' => 'small',
				'instructions' => 'Upload a suitable image or icon',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addGroup( 'Details', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'headline', [
				'instructions' => 'Enter a headline for the card',
			] )
			->addTextarea( 'Supporting_content', [
				'instructions' => 'Enter some supporting content for the card',
			] )
			->addText( 'Telephone' )
			->addEmail( 'Email' )
			->addLink( 'link', [
				'instructions' => 'Link the card to a webpage',
			] )
			->endGroup()
			->endRepeater()
			//Headline with content
			->addLayout( 'headline_with_content' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->endGroup()
			->addText( 'headline', [
				'instructions' =>
					'Enter the headline text that will be displayed on the left of the component',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter the supporting content that will be displayed on the right of the component',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			//Image with content
			->addLayout( 'image_with_content' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->addSelect( 'image_effect', [
				'instructions' => 'Select a cut out effect for the imagek',
				'choices'      => [
					'top_left_bottom_right' => 'Top left, Bottom right',
					'top_right_bottom_left' => 'Top right, Bottom left',
					'bottom_left'           => 'Bottom left',
					'bottom_right '         => 'Bottom right',
				],
				'ui'           => 1,
				'allow_null'   => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->addSelect( 'layout', [
				'instructions' => 'Select an alternative layout for the block',
				'choices'      => [
					'image_offset'       => 'Image offset left',
					'image_offset_right' => 'Image offset right',
					'simple-image-right' => 'Simple, image right',
					'Simple_image_left'  => 'Simple, image left',
					'product'            => 'Product',
				],
				'ui'           => 1,
				'allow_null'   => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->endGroup()
			->addImage( 'image', [
				'preview_size' => 'small',
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Upload a suitable image. The cut off effect will be applied automatically',
			] )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter the supporting content that will be displayed on the right of the component',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			//Hero component
			->addLayout( 'hero' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->addTrueFalse( 'super_size', [
				'instructions' =>
					'Enable to super size the text. Only applies to h1 tags',
				'ui'           => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->addTrueFalse( 'half_height', [
				'instructions'      =>
					'Force the component to be half height. Only available for the default layout',
				'ui'                => 1,
				'wrapper'           => [ 'width' => '33' ],
				'conditional_logic' => [
					[
						[
							'field'    => 'layout',
							'operator' => '!=',
							'value'    => 'inline_image_left',
						],
						[
							'field'    => 'layout',
							'operator' => '!=',
							'value'    => 'inline_image_right',
						],
						[
							'field'    => 'layout',
							'operator' => '!=',
							'value'    => 'diagonal_cutoff',
						],
					],
				],
			] )
			->addSelect( 'layout', [
				'instructions' => 'Select an alternative layout for the block',
				'choices'      => [
					'diagonal_cutoff'    => 'Diagonal cutoff',
					'inline_image_left'  => 'Inline, image left',
					'inline_image_right' => 'Inline, image right',
				],
				'ui'           => 1,
				'allow_null'   => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->addTrueFalse( 'display_breadcrumbs', [
				'instructions' => 'Enable to display a Yoast breadcrumbs. ',
				'ui'           => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->addTrueFalse( 'display_ticker', [
				'instructions'      =>
					'Enable to display a text ticker along the bottom of the component',
				'ui'                => 1,
				'wrapper'           => [ 'width' => '33' ],
				'conditional_logic' => [
					[
						[
							'field'    => 'layout',
							'operator' => '!=',
							'value'    => 'inline_image_left',
						],
						[
							'field'    => 'layout',
							'operator' => '!=',
							'value'    => 'inline_image_right',
						],
					],
				],
			] )
			->addText( 'ticker-text', [
				'instructions'      => 'Enter the text you want to display',
				'conditional_logic' => [
					[
						[
							'field'    => 'display_ticker',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->endGroup()
			->addTab( 'Media' )
			->addSelect( 'media_type', [
				'instructions' =>
					'Select which kind of media you want to use for the background',
				'choices'      => [
					'image' => 'Image',
					'video' => 'Video',
				],
				'ui'           => 1,
				'allow_null'   => 0,
				'wrapper'      => [ 'width' => '51' ],
			] )
			->addImage( 'desktop_image', [
				'preview_size'      => 'medium',
				'wrapper'           => [ 'width' => '50' ],
				'instructions'      =>
					'Please provide a suitable image for desktop users to be displayed.',
				'conditional_logic' => [
					[
						[
							'field'    => 'media_type',
							'operator' => '==',
							'value'    => 'image',
						],
					],
				],
			] )
			->addImage( 'mobile_image', [
				'preview_size'      => 'medium',
				'wrapper'           => [ 'width' => '50' ],
				'instructions'      =>
					'Please provide a suitable image for mobile users to be displayed.',
				'conditional_logic' => [
					[
						[
							'field'    => 'media_type',
							'operator' => '==',
							'value'    => 'image',
						],
					],
				],
			] )
			->addGallery( 'video', [
				'preview_size'      => 'medium',
				'wrapper'           => [ 'width' => '50' ],
				'instructions'      =>
					'Please select a suitable video. Try yo keep the file size as small as possible and under 50mb',
				'mime_types'        => 'MP4, MOV, AVI, WMV, WebM',
				'conditional_logic' => [
					[
						[
							'field'    => 'media_type',
							'operator' => '==',
							'value'    => 'video',
						],
					],
				],
			] )
			->addTab( 'Content' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			// Image with content slider
			->addLayout( 'image_with_content_slider' )
			->addRepeater( 'sliders', [
				'min'    => 0,
				'max'    => 5,
				'layout' => 'block',
			] )
			->addImage( 'Image', [
				'preview_size' => 'large',
				'instructions' =>
					'Upload a suitable image that is related to the content',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->endRepeater()
			->addLayout( 'key_figure_block' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addText( 'key_figure', [
				'instructions' => 'Figure you wish to highlight',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addText( 'Headline', [
				'instructions' => 'Enter a suitable headline for the content',
				'wrapper'      => [ 'width' => '70' ],
			] )
			->addWysiwyg( 'content', [
				'instructions' => 'Enter supporting content',
			] )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'You can add upto two buttons',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addImage( 'Image', [
				'preview_size' => 'large',
				'instructions' =>
					'Upload a suitable image that is related to the content',
				'wrapper'      => [ 'width' => '50' ],
			] )

			// Key Points
			->addLayout( 'key_points' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100%' ],
			] )
			->addTrueFalse( 'secondary_layout', [
				'instructions' =>
					'Enable if you want to display the content in an alternate layout',
				'ui'           => 1,
				'width'        => '100',
			] )
			->endGroup()
			->addTab( 'Content' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addTab( 'Key Points' )
			->addRepeater( 'key_points', [
				'min'    => 1,
				'max'    => 6,
				'layout' => 'block',
			] )
			->addImage( 'icon', [
				'preview_size' => 'small',
				'instructions' => 'Upload a suitable SVG icon.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'headline', [
				'instructions' => 'Enter the headline of the point',
			] )
			->addTextarea( 'supporting_content', [
				'instructions' => 'Enter some supporting content',
			] )
			->endGroup()
			->endRepeater()
			->addLayout( 'news_&_media' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_posts', [
				'instructions' =>
					'Select the number of posts to display. Select All if you want to enable load more functionality',
				'choices'      => [
					3    => '3',
					6    => '6',
					9    => '9',
					12   => '12',
					1000 => 'All',
				],
			] )
			->addTrueFalse( 'select_posts', [
				'instructions' =>
					'Enable if you want to select individual posts to display',
				'ui'           => 1,
			] )
			->addPostObject( 'filter_by_category', [
				'instructions'      =>
					'Select which category to filter by. Leave empty to use all categories.',
				'type'              => 'taxonomy',
				'taxonomy'          => 'category',
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_posts',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addPostObject( 'individual_posts', [
				'instructions'      => 'Select which posts you want to display',
				'post_type'         => [
					0 => 'post',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_posts',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->endGroup()
			// Product innovation
			->addLayout( 'product_innovation' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_posts', [
				'instructions' =>
					'Select the number of innovations to display. Select All if you want to enable load more functionality',
				'choices'      => [
					3   => '3',
					6   => '6',
					9   => '9',
					12  => '12',
					- 1 => 'All',
				],
			] )
			->addTrueFalse( 'select_posts', [
				'instructions' =>
					'Enable if you want to select individual innovation to display',
				'ui'           => 1,
			] )
			->addPostObject( 'filter_by_category', [
				'instructions'      =>
					'Select which category to filter by. Leave empty to use all categories.',
				'type'              => 'taxonomy',
				'taxonomy'          => 'categories',
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_posts',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addPostObject( 'individual_posts', [
				'instructions'      => 'Select which innovation you want to display',
				'post_type'         => [
					0 => 'product_innovation',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_posts',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->endGroup()

			// Slider Section
			->addLayout( 'slider_section' )
			->addTab( 'Content' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addTab( 'Slider' )
			->addRepeater( 'Entries', [
				'min'    => 1,
				'max'    => 10,
				'layout' => 'block',
			] )
			->addImage( 'image', [
				'preview_size' => 'small',
				'instructions' =>
					'Upload a suitable image or icon. SVG icon recommended',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addTextarea( 'Text', [
				'instructions' => 'Specify short text',
				'wrapper'      => [ 'width' => '70' ],
			] )
			->addLink( 'link', [
				'instructions' => 'Add an optional link',
			] )
			->endRepeater()
			// Slider Section
			->addLayout( 'testimonials' )
			->addGroup( 'testimonial', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addImage( 'icon', [
				'preview_size' => 'thumbnail',
				'instructions' => 'Upload a suitable logo. SVG  recommended',
			] )
			->addText( 'title', [
				'instructions' => 'Specify a title',
			] )
			->endGroup()
			->addGroup( 'quote', [
				'instructions' => 'Specify quote text',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()

			// Inline Forms
			->addLayout( 'inline_forms' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addSelect( 'form', [
				'instructions'  =>
					'Select which form you want to display. Forms can be managed from the Formable tab',
				'choices'       => $formOpts,
				'ui'            => 1,
				'allow_null'    => 0,
				'wrapper'       => [ 'width' => '50' ],
				'return_format' => 'array',
			] )
			// Maps
			->addLayout( 'location_map' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGoogleMap( 'location_map', [
				'instructions' => 'Search for a location',
				'center_lat'   => '53.5110736',
				'center_lng'   => '-2.0421617',
				'wrapper'      => [ 'width' => '50' ],
			] )

			// Product categories grid
			->addLayout( 'product_categories' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Select which categories you want to display. Categories will be displayed within a 3 grid layout',
			] )
			->addTaxonomy( 'product_categories', [
				'taxonomy'   => 'product_cat',
				'field_type' => 'multi_select',
			] )
			->endGroup()
			// * AUT Products
			->addLayout( 'AUT_products' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addTab( 'Options' )
			->addTrueFalse( 'display_filters', [
				'instructions'  =>
					'Enable if you want to display the filters sidebar,  page header and enable load more functionality.',
				'ui'            => 1,
				'default_value' => 0,
			] )
			->addSelect( 'product_number', [
				'instructions'      =>
					'Select how many products you want to display. Select all if you want to use pagination and display a load more button.',
				'choices'           => [
					3     => '3',
					6     => '6',
					9     => '9',
					12    => '12',
					15    => '15',
					'all' => 'All',
				],
				'conditional_logic' => [
					[
						[
							'field'    => 'display_filters',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
				'ui'                => 1,
				'allow_null'        => 0,
			] )
			->addTrueFalse( 'select_products', [
				'instructions'      =>
					'Enable if you want to select individual products',
				'ui'                => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'display_filters',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addPostObject( 'individual_products', [
				'instructions'      => 'Select which products you want to display',
				'post_type'         => [
					0 => 'product',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->addTab( 'Filters' )
			->addTaxonomy( 'categories', [
				'instructions'      =>
					'Select which series categories you want to filter by.',
				'taxonomy'          => 'categories',
				'field_type'        => 'multi_select',
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addTaxonomy( 'industry', [
				'instructions'      =>
					'Select which series industry you want to filter by.',
				'taxonomy'          => 'industry',
				'field_type'        => 'multi_select',
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->endGroup()
			->addLayout( 'series' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addTab( 'Options' )
			->addSelect( 'series_number', [
				'instructions'      =>
					'Select how many series you want to display. Select all if you want to use pagination and display a load more button.',
				'choices'           => [
					3     => '3',
					6     => '6',
					9     => '9',
					12    => '12',
					15    => '15',
					'all' => 'All',
				],
				'conditional_logic' => [
					[
						[
							'field'    => 'show_load_more',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
				'ui'                => 1,
				'allow_null'        => 0,
			] )
			->addTrueFalse( 'select_series', [
				'instructions'      =>
					'Enable if you want to select individual series',
				'ui'                => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'display_filters',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addPostObject( 'individual_series', [
				'instructions'      => 'Select which series you want to display',
				'post_type'         => [
					0 => 'series',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_series',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->addTab( 'Filters' )
			->addTaxonomy( 'categories', [
				'instructions'      =>
					'Select which series categories you want to filter by.',
				'taxonomy'          => 'categories',
				'field_type'        => 'multi_select',
				'conditional_logic' => [
					[
						[
							'field'    => 'select_series',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addTaxonomy( 'industry', [
				'instructions'      =>
					'Select which series industry you want to filter by.',
				'taxonomy'          => 'industry',
				'field_type'        => 'multi_select',
				'conditional_logic' => [
					[
						[
							'field'    => 'select_series',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->endGroup()
			// Series categories
			->addLayout( 'series_categories' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Select which categories or industries you want to display. Cards will be displayed within a 3 grid layout',
			] )
			->addTaxonomy( 'series_categories', [
				'taxonomy'   => 'categories',
				'field_type' => 'multi_select',
			] )
			->addTaxonomy( 'series_industry', [
				'taxonomy'   => 'industry',
				'field_type' => 'multi_select',
			] )
			->endGroup()
			// Products
			->addLayout( 'products' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addTab( 'Options' )
			->addTrueFalse( 'Detailed', [
				'instructions'  => 'Show a detailed or simple product card',
				'ui'            => 1,
				'default_value' => 1,
			] )
			->addTrueFalse( 'show_load_more', [
				'instructions'      =>
					'Enable if you want to use pagination and display a load more button.',
				'ui'                => 1,
				'default_value'     => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addSelect( 'product_number', [
				'instructions'      =>
					'Select how many products you want to display.',
				'choices'           => [
					3  => '3',
					6  => '6',
					9  => '9',
					12 => '12',
					15 => '15',
					12 => 'All',
				],
				'conditional_logic' => [
					[
						[
							'field'    => 'show_load_more',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
				'ui'                => 1,
				'allow_null'        => 0,
			] )
			->addTrueFalse( 'select_products', [
				'instructions' =>
					'Enable if you want to select individual products',
				'ui'           => 1,
			] )
			->addPostObject( 'individual_products', [
				'instructions'      => 'Select which products you want to display',
				'post_type'         => [
					0 => 'product',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->addTab( 'Filters' )
			->addTaxonomy( 'categories', [
				'instructions'      =>
					'Select which product categories you want to filter by.',
				'taxonomy'          => 'product_cat',
				'field_type'        => 'multi_select',
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addPostObject( 'series', [
				'instructions'      =>
					'Select which product series you want to filter by.',
				'post_type'         => [
					0 => 'series',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->addSelect( 'woocommerce_filter', [
				'instructions'      => 'Filter products using a Woocommerce filter.',
				'choices'           => [
					'on_sale'      => 'On sale',
					'best_selling' => 'Best Selling',
					'top_rated'    => 'Top rated',
				],
				'ui'                => 1,
				'allow_null'        => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_products',
							'operator' => '==',
							'value'    => '0',
						],
					],
				],
			] )
			->endGroup()
			// Section anchor
			->addLayout( 'section_anchor' )
			->addText( 'section_anchor', [
				'instructions' =>
					'Enter a section ID that you can link to via a button',
			] )

			// Sectors
			->addLayout( 'sectors' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_sectors', [
				'instructions' =>
					'Select the number of sectors to display. Select All if you want to enable load more functionality',
				'choices'      => [
					3   => '3',
					6   => '6',
					9   => '9',
					12  => '12',
					- 1 => 'All',
				],
			] )
			->addTrueFalse( 'select_sectors', [
				'instructions' =>
					'Enable if you want to select individual sectors to display',
				'ui'           => 1,
			] )
			->addPostObject( 'individual_sectors', [
				'instructions'      => 'Select which sectors you want to display',
				'post_type'         => [
					0 => 'sector',
				],
				'return_format'     => 'id',
				'field_type'        => 'multi_select',
				'allow_null'        => 1,
				'multiple'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'select_sectors',
							'operator' => '==',
							'value'    => '1',
						],
					],
				],
			] )
			->endGroup()
			// Sectors
			->addLayout( 'FAQs' )
			->addGroup( 'options' )
			->addTrueFalse( 'background', [
				'instructions' => 'Select the background colour of the block',
				'ui'           => 1,
				'ui_on_text'   => 'Off white',
				'ui_off_text'  => 'White',
			] )
			->endGroup()
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addRepeater( 'FAQs', [
				'layout'  => 'block',
				'wrapper' => [ 'width' => '50' ],
			] )
			->addText( 'Question' )
			->addTextarea( 'Answer' )
			->endRepeater()
			// Table
			->addLayout( 'series_table' )
			->addTab( 'Table' )
			->addRepeater( 'rows', [
				'min'    => 1,
				'layout' => 'block',
			] )
			->addRepeater( 'columns', [
				'min'          => 1,
				'layout'       => 'block',
				'instructions' =>
					'Please ensure each row has the same number of columns. Even if they are empty',
			] )
			->addPostObject( 'series', [
				'label'         => 'Select a series to link to',
				'post_type'     => [ 'series' ],
				'field_type'    => 'multi_select',
				'multiple'      => 0,
				'return_format' => 'id',
				'ui'            => 1,
			] )
			->endRepeater()
			->endRepeater()
			->addTab( 'Content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' =>
					'Enter a headline and supporting content for the block',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'The buttons for this block will display underneath the grid',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->setLocation( 'post_type', '==', 'page' )
			->or( 'post_type', '==', 'sectors' )
			->or( 'post_type', '==', 'case_studies' )
			->or( 'post_type', '==', 'product_innovation' )
			->or( 'post_type', '==', 'series' )
			->or( 'post_type', '==', 'product' )
			->or( 'post_type', '==', 'post' )
			->or( 'taxonomy', '==', 'product_cat' )
			->or( 'taxonomy', '==', 'categories' )
			->or( 'taxonomy', '==', 'industry' );

		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $flexible->build() );
		}
	}

	public static function theme_settings(): void {
		global $wpdb;
		// Get the current site ID in a Multisite environment
		$site_id = get_current_blog_id();
		// Use the correct prefix for the current site
		$table_name = $wpdb->prefix . 'frm_forms';

		// Query the database for the forms of the current site
		$forms = $wpdb->get_results( "SELECT * FROM $table_name" );

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$formOpts[] = [
					$form->id => $form->name,
				];
			}
		}

		$settings = new FieldsBuilder( 'theme_settings', [] );
		$settings
			->addTab( 'Get in touch' )
			->addGroup( 'get_in_touch_content', [
				'wrapper' => [ 'width' => '50%' ],
			] )
			->addText( 'headline' )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addSelect( 'form', [
				'instructions'  =>
					'Select which form you want to display. Forms can be managed from the Formable tab',
				'choices'       => $formOpts,
				'ui'            => 1,
				'allow_null'    => 0,
				'wrapper'       => [ 'width' => '50' ],
				'return_format' => 'array',
			] )
			->addTab( 'Socials' )
			->addUrl( 'facebook' )
			->addUrl( 'X' )
			->addUrl( 'Instagram' )
			->addUrl( 'YouTube' )
			->addUrl( 'LinkedIn' )
			->addUrl( 'TikTok' )
			->addTab( 'Google maps' )
			->addText( 'google_maps_API_key' )
			->addTab( 'selling_points' )
			->addRepeater( 'selling_points', [
				'min'          => 0,
				'max'          => 4,
				'layout'       => 'block',
				'instructions' =>
					'Add a selling point that will be displayed underneath the header',
			] )
			->addImage( 'icon', [
				'preview_size' => 'small',
				'instructions' => 'Upload a suitable SVG icon',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addText( 'Text', [
				'instructions' => 'Short and to the point',
				'wrapper'      => [ 'width' => '70' ],
			] )
			->endRepeater()
			->addTab( 'Copyright' )
			->addText( 'copyright', [
				'instructions' => 'Update load a suitable copyright notice',
			] )
			->addTab( 'Media' )
			->addImage( 'fallback_image', [
				'preview_size' => 'small',
				'instructions' =>
					'Upload a suitable fallback image that will be displayed when an image isnt found',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addTab( 'contact_information' )
			->addText( 'phone_number', [
				'instructions' =>
					'Enter a phone number to be used throughout the theme',
			] )
			->addText( 'mobile_number', [
				'instructions' =>
					'Enter a mobile number to be used throughout the theme',
			] )
			->addText( 'email_address', [
				'instructions' =>
					'Enter an email address to be used throughout the theme',
			] )
			->addTextarea( 'address', [
				'instructions' =>
					'Enter an address to appear throughout the theme',
			] )
			->addTab( 'Series Promos' )
			->addGroup( 'categories', [
				'instructions' => 'Series categories promo information',
			] )
			->addImage( 'categories_image', [
				'preview_size' => 'large',
				'instructions' =>
					'Upload a suitable image for the categories promos',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addTextarea( 'categories_content', [
				'instructions' => 'Categories supporting content',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->endGroup()
			->addGroup( 'Industry', [
				'instructions' => 'Series industry promo information',
			] )
			->addImage( 'industry_image', [
				'preview_size' => 'large',
				'instructions' =>
					'Upload a suitable image for the industry promos',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addTextarea( 'industry_content', [
				'instructions' => 'Industry supporting content',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->endGroup()
			->setLocation( 'options_page', '==', 'theme-general-settings' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	public static function product_settings(): void {
		$settings = new FieldsBuilder( 'product_details', [] );
		$settings
			->addTab( 'Product information' )
			->addWysiwyg( 'product_information', [
				'instructions' => 'Write a brief description of the product',
			] )
			->addTab( 'Dimensions' )
			->addWysiwyg( 'dimensions', [
				'instructions' =>
					'List information regarding the products dimensions',
			] )
			->addTab( 'Key features' )
			->addWysiwyg( 'key_features', [
				'instructions' =>
					'List all the key information for the product',
			] )
			->addTab( 'Testimonials' )
			->addRepeater( 'testimonials' )
			->addGroup( 'testimonial', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addImage( 'icon', [
				'preview_size' => 'thumbnail',
				'instructions' => 'Upload a suitable logo. SVG  recommended',
			] )
			->addText( 'title', [
				'instructions' => 'Specify a title',
			] )
			->endGroup()
			->addGroup( 'quote', [
				'instructions' => 'Specify quote text',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'    => 0,
				'max'    => 2,
				'layout' => 'block',
			] )
			->addLink( 'button' )
			->endRepeater()
			->setLocation( 'post_type', '==', 'product' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Creates a field group for the "case_studie" taxonomy and adds fields to it.
	 *
	 * @return void
	 */
	public static function case_studies(): void {
		$settings = new FieldsBuilder( 'assigned_sector', [] );
		$settings
			->addPostObject( 'assigned_sector', [
				'label'         =>
					'Select which section(s) this case study is related to',
				'post_type'     => [ 'sectors' ],
				'field_type'    => 'multi_select',
				'multiple'      => 1,
				'return_format' => 'id',
				'ui'            => 1,
			] )
			->setLocation( 'post_type', '==', 'case_studies' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	public static function products(): void {
		$settings = new FieldsBuilder( 'assign_series', [
			'position' => 'side',
		] );
		$settings
			->addPostObject( 'series', [
				'label'         => 'Select which series(s) this product is related to',
				'post_type'     => [ 'series' ],
				'field_type'    => 'multi_select',
				'multiple'      => 1,
				'return_format' => 'id',
				'ui'            => 1,
			] )
			->setLocation( 'post_type', '==', 'product' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Creates a field group for the "categories" and "industry" taxonomy and adds an "image" field to it.
	 *
	 * The field allows users to upload an image and provides a preview in "small" size.
	 *
	 * @return void
	 */
	public static function taxonomy_image(): void {
		$settings = new FieldsBuilder( 'details', [] );
		$settings
			->addImage( 'image', [
				'preview_size'  => 'small',
				'return_format' => 'array',
				'instructions'  => 'Upload a suitable image',
			] )
			->addTextarea( 'summary', [
				'instructions' => 'A brief description of the term',
			] )
			->setLocation( 'taxonomy', '==', 'categories' )
			->or( 'taxonomy', '==', 'industry' );

		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	public static function series(): void {
		$settings = new FieldsBuilder( 'series', [] );

		$settings
			->addGroup( 'content' )
			->addText( 'tag_line', [
				'instructions' =>
					'This content will be displayed under the series title',
			] )
			->addTextarea( 'summery', [
				'instructions' => 'A brief description of the series',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addTextarea( 'card_content', [
				'instructions' =>
					'This content will be displayed on the series card',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->endGroup()
			->addGroup( 'properties' )
			->addText( 'wheel_diameter' )
			->addText( 'wheel_hardness' )
			->addText( 'load_capacity' )
			->addText( 'rolling_resistance' )
			->addText( 'temperature_range' )
			->endGroup()
			->setLocation( 'post_type', '==', 'series' );

		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Generates an additional information field group using Advanced Custom Fields (ACF).
	 *
	 * @return void
	 */
	public static function additional_information(): void {
		$settings = new FieldsBuilder( 'additional_information', [] );
		$settings
			->addText( 'tag_line' )
			->addImage( 'image', [
				'preview_size' => 'small',
			] )
			->addGroup( 'properties' )
			->addText( 'wheel_diameter' )
			->addText( 'wheel_hardness' )
			->addText( 'load_capacity' )
			->addText( 'rolling_resistance' )
			->addText( 'temperature_range' )
			->endGroup()
			->addGroup( 'tags' )
			->addCheckbox( 'tags', [
				'return_format'             => 'value',
				'allow_custom'              => 1,
				'save_custom'               => 1,
				'layout'                    => 'horizontal',
				'toggle'                    => 1,
				'custom_choice_button_text' => 'Add new tag',
				'choices'                   => [
					'Food'        => 'Food',
					'Medical'     => 'Medical',
					'Furniture'   => 'Furniture',
					'Clean Rooms' => 'Clean Rooms',
					'Indoor'      => 'Indoor',
					'Outdoor'     => 'Outdoor',
				],
			] )
			->endGroup()
			->setLocation( 'taxonomy', '==', 'series' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Generates a product media field group using Advanced Custom Fields (ACF).
	 *
	 * @return void
	 */
	public static function products_media(): void {
		$settings = new FieldsBuilder( 'product_media', [
			'position' => 'side',
		] );
		$settings
			->addFile( 'data_sheet', [
				'instructions'  => 'Upload a data sheet',
				'return_format' => 'array',
			] )
			->addLink( '3d_cad_model', [
				'label'        => 'Link Field',
				'instructions' => 'Enter a link to a 3D CAD model',
			] )
			->setLocation( 'post_type', '==', 'product' )
			->or( 'post_type', '==', 'series' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Generates a product specification field group using Advanced Custom Fields (ACF).
	 *
	 * @return void
	 */
	public static function product_specification(): void {
		$settings = new FieldsBuilder( 'product_specification' );
		$settings
			->addRepeater( 'product_specification', [
				'instructions' => 'Add detailed product information',
			] )
			->addText( 'part_number' )
			->addText( 'wheel_diameter' )
			->addText( 'wheel_width' )
			->addText( 'overall_height' )
			->addText( '4km_carry_capacity' )
			->addText( 'weight' )
			->addText( 'temperature' )
			->addText( 'hardness' )
			->addText( 'bolt_hole_race' )
			->addText( 'bolt_hole_diameter' )
			->addText( 'offset' )
			->endRepeater()
			->setLocation( 'post_type', '==', 'product' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Generates a product call-to-actions field group using Advanced Custom Fields (ACF).
	 *
	 * @return void
	 */
	public static function product_call_to_actions(): void {
		$settings = new FieldsBuilder( 'product_call_to_actions', [
			'position' => 'side',
		] );
		$settings
			->addRepeater( 'product_call_to_actions', [
				'label'        => 'Buttons',
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' =>
					'Generate a maximum of 2 call-to-action buttons and incorporate them into the header',
			] )
			->addLink( 'button' )
			->endRepeater()
			->setLocation( 'post_type', '==', 'product' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}

	/**
	 * Generates and adds fields to the local ACF field group for page settings.
	 * This method creates a field group named 'display_page_header' with a position
	 * of 'side'. It adds a True/False field with the key 'display_page_header' and
	 * the specified instructions and UI settings. The field group is then assigned
	 * to be displayed only for the 'page' post type.
	 *
	 * @return void
	 */
	public static function page_settings(): void {
		$settings = new FieldsBuilder( 'display_page_header', [
			'position'       => 'side',
			'hide_on_screen' => [ 'the_content' ],
		] );
		$settings
			->addTrueFalse( 'display_page_header', [
				'instructions' =>
					'Enable to display a basic page header block with breadcrumbs and page title.',
				'ui'           => 1,
			] )
			->setLocation( 'post_type', '==', 'page' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}


	public static function header_settings(): void {
		$settings = new FieldsBuilder( 'header_settings', [
			'position'       => 'side',
			'hide_on_screen' => [ 'the_content' ],
		] );
		$settings
			->addTrueFalse( 'overlay', [
				'instructions' =>
					'Enable if you want to display the header as an overlay',
				'ui'           => 1,
			] )
			->addTrueFalse( 'background', [
				'instructions' =>
					'Enable if you want to change the header background to steal',
				'ui'           => 1,
			] )
			->setLocation( 'post_type', '==', 'page' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}


	public static function mega_menu(): void {
		$settings = new FieldsBuilder( 'menu_icon' );
		$settings
			->addImage( 'menu_icon', [
				'preview_size' => 'small',
				'instructions' => 'Upload a suitable menu icon',
			] )
			->setLocation( 'nav_menu_item', '==', '17' );
		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $settings->build() );
		}
	}


	public static function product_categories(): void {
		$categorySettings = new FieldsBuilder( 'product_category_description', [
			'position' => 'side',
		] );

		$categorySettings
			->addTextarea( 'short_description', [
				'label'        => 'Short Description',
				'instructions' => 'Add a short description for this product category',
				'required'     => 0,
				'maxlength'    => '',
				'placeholder'  => '',
				'rows'         => 4,
			] )
			->setLocation( 'taxonomy', '==', 'product_cat' );

		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $categorySettings->build() );
		}
	}

	public static function hide_editor(): void {


		$editor = new FieldsBuilder( 'editor', [
			'hide_on_screen' => [ 'the_content' ],
		] );

		$editor
			->setLocation( 'post_type', '==', 'page' )
			->or( 'post_type', '==', 'sectors' )
			->or( 'post_type', '==', 'case_studies' )
			->or( 'post_type', '==', 'product_innovation' )
			->or( 'post_type', '==', 'series' )
			->or( 'post_type', '==', 'product' )
			->or( 'post_type', '==', 'post' )
			->or( 'taxonomy', '==', 'product_cat' )
			->or( 'taxonomy', '==', 'categories' )
			->or( 'taxonomy', '==', 'industry' );

		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $editor->build() );
		}
	}


	public static function hide_editor_benchmaster(): void {


		$editor = new FieldsBuilder( 'editor', [
			'hide_on_screen' => [ 'the_content' ],
			'position'       => 'side',
		] );

		$editor
			->setLocation( 'post_type', '==', 'page' )
			->or( 'post_type', '==', 'sectors' )
			->or( 'post_type', '==', 'case_studies' )
			->or( 'post_type', '==', 'product_innovation' )
			->or( 'post_type', '==', 'series' )
			->or( 'taxonomy', '==', 'product_cat' )
			->or( 'taxonomy', '==', 'categories' )
			->or( 'taxonomy', '==', 'industry' );

		if ( class_exists( 'ACF' ) ) {
			acf_add_local_field_group( $editor->build() );
		}
	}

}
