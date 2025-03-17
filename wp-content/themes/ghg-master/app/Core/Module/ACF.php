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
		// Get the current site ID in a Multisite environment.
		$site_id = get_current_blog_id();
		// Use the correct prefix for the current site.
		$table_name = $wpdb->prefix . 'frm_forms';

		// Query the database for the forms of the current site.
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
			// Begin blocks (alphabetically ordered):
			// 1. AUT_products
			->addLayout( 'AUT_products' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide the headline and supporting content for this block.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below this block.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addTab( 'Options' )
			->addTrueFalse( 'display_filters', [
				'instructions'  => 'Enable this option to display the filters sidebar, page header, and load more functionality.',
				'ui'            => 1,
				'default_value' => 0,
			] )
			->addSelect( 'product_number', [
				'instructions'      => 'Choose the number of products to display. Select "All" to enable pagination with a load more button.',
				'choices'           => [
					3     => '3',
					6     => '6',
					9     => '9',
					12    => '12',
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
				'instructions' => 'Enable this option to manually select individual products.',
				'ui'           => 1,
			] )
			->addPostObject( 'individual_products', [
				'instructions'      => 'Manually select the specific products to display when enabled.',
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
				'instructions'      => 'Choose the product categories to filter the displayed products.',
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
				'instructions'      => 'Select the product series to filter the displayed products.',
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
				'instructions'      => 'Choose a Woocommerce filter to apply (e.g. On sale, Best Selling, Top rated).',
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
			// 2. cards_grid
			->addLayout( 'cards_grid' )
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for this block.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will be displayed below the grid.',
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
				'instructions' => 'Upload an image or icon to represent this card.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addGroup( 'Details', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'headline', [
				'instructions' => 'Enter a headline for this card.',
			] )
			->addText( 'Supporting_content', [
				'instructions' => 'Enter supporting content for this card. This text will be emphasized.',
			] )
			->addTextarea( 'additional_content', [
				'instructions' => 'Provide any additional content for this card.',
			] )
			->addLink( 'link', [
				'instructions' => 'Provide a URL to link this card to a webpage.',
			] )
			->endGroup()
			->endRepeater()
			// 3. case_studies
			->addLayout( 'case_studies' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Enter the content for this case study section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons to appear below the content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_case_studies', [
				'instructions' => 'Choose the number of case studies to display.',
				'choices'      => [
					3   => '3',
					6   => '6',
					9   => '9',
					12  => '12',
					- 1 => 'All',
				],
			] )
			->addTrueFalse( 'select_case_studies', [
				'instructions' => 'Enable this option to manually select individual case studies.',
				'ui'           => 1,
			] )
			->addPostObject( 'filter_by_sector', [
				'instructions'      => 'Choose a sector to filter the case studies.',
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
				'instructions'      => 'Manually select the specific case studies to display when enabled.',
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
			// 4. content_block
			->addLayout( 'content_block' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for this content block.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will be displayed beneath the content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ]
			] )
			->addTrueFalse( 'max_width', [
				'instructions' => 'Enable this option to restrict the content width.',
				'ui'           => 1,
			] )
			->addTrueFalse( 'center_align', [
				'instructions' => 'Enable this option to center-align the content.',
				'ui'           => 1,
			] )
			->endGroup()
			// 5. current_vacancies
			->addLayout( 'current_vacancies' )
			->addGroup( 'options' )
			->addTrueFalse( 'background', [
				'instructions' => 'Choose the background color for the vacancies block (Primary or Secondary).',
				'ui'           => 1,
				'ui_on_text'   => 'Primary',
				'ui_off_text'  => 'Secondary',
			] )
			->endGroup()
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the vacancies section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons to appear below the vacancies content.',
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
				'instructions' => 'Enter the job title for the vacancy.',
			] )
			->addTextarea( 'job_description', [
				'instructions' => 'Provide a detailed job description.',
			] )
			->addText( 'posted_date' )
			->addLink( 'link', [
				'instructions' => 'Provide a URL to link this vacancy card to a webpage.',
			] )
			->endGroup()
			->endRepeater()
			// 6. FAQs
			->addLayout( 'FAQs' )
			->addGroup( 'options' )
			->addTrueFalse( 'background', [
				'instructions' => 'Choose the background color for the FAQs block (Off white or White).',
				'ui'           => 1,
				'ui_on_text'   => 'Off white',
				'ui_off_text'  => 'White',
			] )
			->endGroup()
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the FAQs section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will be displayed below the FAQs content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addRepeater( 'FAQs', [
				'layout'  => 'block',
				'wrapper' => [ 'width' => '50' ],
			] )
			->addText( 'Question', [
				'instructions' => 'Enter the FAQ question.',
			] )
			->addTextarea( 'Answer', [
				'instructions' => 'Enter the answer for this FAQ.',
			] )
			->endRepeater()
			// 7. group_listing
			->addLayout( 'group_listing' )
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for this group listing block.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the group listing content.',
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
				'instructions' => 'Upload an image or icon to represent this group item.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addGroup( 'Details', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'headline', [
				'instructions' => 'Enter a headline for this group card.',
			] )
			->addTextarea( 'Supporting_content', [
				'instructions' => 'Provide additional supporting content for this group card.',
			] )
			->addText( 'Telephone' )
			->addEmail( 'Email' )
			->addLink( 'link', [
				'instructions' => 'Provide a URL to link this group card to a webpage.',
			] )
			->endGroup()
			->endRepeater()
			// 8. headline_with_content
			->addLayout( 'headline_with_content' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->endGroup()
			->addText( 'headline', [
				'instructions' => 'Enter the headline text to be displayed on the left side of the component.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide the supporting content to be displayed on the right side of the component.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the component content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			// 9. hero
			->addLayout( 'hero' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100' ],
			] )
			->addTrueFalse( 'super_size', [
				'instructions' => 'Enable this option to enlarge the text (applies only to H1 elements).',
				'ui'           => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->addTrueFalse( 'half_height', [
				'instructions'      => 'Enable to set the component to half height (available only with the default layout).',
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
				'instructions' => 'Choose an alternative layout for the hero component.',
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
				'instructions' => 'Enable this option to display Yoast breadcrumbs.',
				'ui'           => 1,
				'wrapper'      => [ 'width' => '33' ],
			] )
			->addTrueFalse( 'display_ticker', [
				'instructions'      => 'Enable to show a text ticker at the bottom of the hero section.',
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
				'instructions'      => 'Enter the ticker text to display (only visible if enabled).',
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
				'instructions' => 'Choose the type of background media: Image or Video.',
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
				'instructions'      => 'Upload the desktop version of the background image.',
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
				'instructions'      => 'Upload the mobile version of the background image.',
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
				'instructions'      => 'Select a video for the background (recommended file size under 50MB).',
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
				'wrapper'      => [ 'width' => '100' ],
				'instructions' => 'Provide a headline and supporting content for the hero section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the hero content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			// 10. image_with_content_slider
			->addLayout( 'image_with_content_slider' )
			->addRepeater( 'sliders', [
				'min'    => 0,
				'max'    => 5,
				'layout' => 'block',
			] )
			->addImage( 'Image', [
				'preview_size' => 'large',
				'instructions' => 'Upload an image related to this slider item.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for this slider item.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the slider content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->endRepeater()
			// 11. key_figure_block
			->addLayout( 'key_figure_block' )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addText( 'key_figure', [
				'instructions' => 'Enter the key figure you wish to emphasize.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addText( 'Headline', [
				'instructions' => 'Enter a headline for the key figure block.',
				'wrapper'      => [ 'width' => '70' ],
			] )
			->addWysiwyg( 'content', [
				'instructions' => 'Provide additional supporting content for the key figure.',
			] )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 call-to-action buttons (optional).',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addImage( 'Image', [
				'preview_size' => 'large',
				'instructions' => 'Upload an image associated with the key figure block.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			// 12. key_points
			->addLayout( 'key_points' )
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '100%' ],
			] )
			->addTrueFalse( 'secondary_layout', [
				'instructions' => 'Enable an alternate layout for the key points section.',
				'ui'           => 1,
				'width'        => '100',
			] )
			->endGroup()
			->addTab( 'Content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '100' ],
				'instructions' => 'Provide a headline and supporting content for the key points section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons to appear below the key points content.',
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
				'instructions' => 'Upload an SVG icon for this key point.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addGroup( 'content', [
				'wrapper' => [ 'width' => '70' ],
			] )
			->addText( 'headline', [
				'instructions' => 'Enter the headline for this key point.',
			] )
			->addTextarea( 'supporting_content', [
				'instructions' => 'Provide supporting content for this key point.',
			] )
			->endGroup()
			->endRepeater()
			// 13. listing_block
			->addLayout( 'listing_block' )
			->addGroup( 'options' )
			->addTrueFalse( 'background', [
				'instructions' => 'Choose the background color for the listing block (Primary or Secondary).',
				'ui'           => 1,
				'ui_on_text'   => 'Primary',
				'ui_off_text'  => 'Secondary',
			] )
			->endGroup()
			->addTab( 'list' )
			->addRepeater( 'list', [
				'min'          => 0,
				'layout'       => 'block',
				'instructions' => 'Enter list items; they will be arranged in rows of three automatically.',
			] )
			->addText( 'list_item' )
			->endRepeater()
			->addTab( 'content' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide the text for the list items.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the list content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			// 14. location_map
			->addLayout( 'location_map' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the location map.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the location map content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGoogleMap( 'location_map', [
				'instructions' => 'Search for a location using the map interface.',
				'center_lat'   => '53.5110736',
				'center_lng'   => '-2.0421617',
				'wrapper'      => [ 'width' => '50' ],
			] )
			// 15. news_&_media
			->addLayout( 'news_and_media' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the News & Media section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the News & Media content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_posts', [
				'instructions'      => 'Choose the number of posts to display. Select "All" to enable load more functionality.',
				'choices'           => [
					3    => '3',
					6    => '6',
					9    => '9',
					12   => '12',
					1000 => 'All',
				],
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
			->addTrueFalse( 'select_posts', [
				'instructions' => 'Enable this option to manually select individual posts.',
				'ui'           => 1,
			] )
			->addPostObject( 'filter_by_category', [
				'instructions'      => 'Choose a category to filter posts (leave empty to display all).',
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
				'instructions'      => 'Manually select the specific posts to display when enabled.',
				'post_type'         => [
					0 => 'product',
				],
				'return_format'     => 'id',
				'ui'                => 1,
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
			// 16. product_categories
			->addLayout( 'product_categories' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the product categories grid.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons to be displayed below the product categories content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Choose the product categories to display in a three-column grid layout.',
			] )
			->addTaxonomy( 'product_categories', [
				'taxonomy'   => 'product_cat',
				'field_type' => 'multi_select',
			] )
			->endGroup()
			// 17. products
			->addLayout( 'products' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the products block.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the products content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addTab( 'Options' )
			->addTrueFalse( 'Detailed', [
				'instructions'  => 'Choose whether to display a detailed or simplified product card.',
				'ui'            => 1,
				'default_value' => 1,
			] )
			->addTrueFalse( 'show_load_more', [
				'instructions'      => 'Enable pagination to display a load more button for products.',
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
				'instructions'      => 'Choose the number of products to display.',
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
				'instructions' => 'Enable this option to manually select individual products.',
				'ui'           => 1,
			] )
			->addPostObject( 'individual_products', [
				'instructions'      => 'Manually select the specific products to display when enabled.',
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
				'instructions'      => 'Choose the product categories to filter the products.',
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
				'instructions'      => 'Select the product series to filter the products.',
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
				'instructions'      => 'Choose a Woocommerce filter (On sale, Best Selling, or Top rated) to apply.',
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
			// 18. section_anchor
			->addLayout( 'section_anchor' )
			->addText( 'section_anchor', [
				'instructions' => 'Enter a unique section ID to enable linking via a button.',
			] )
			// 19. sectors
			->addLayout( 'sectors' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the sectors section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the sectors content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addSelect( 'number_of_sectors', [
				'instructions' => 'Choose the number of sectors to display. Select "All" to enable load more functionality.',
				'choices'      => [
					3   => '3',
					6   => '6',
					9   => '9',
					12  => '12',
					- 1 => 'All',
				],
			] )
			->addTrueFalse( 'select_sectors', [
				'instructions' => 'Enable this option to manually select specific sectors.',
				'ui'           => 1,
			] )
			->addPostObject( 'individual_sectors', [
				'instructions'      => 'Manually select the specific sectors to display when enabled.',
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
			// 20. series
			->addLayout( 'series' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the series section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the series content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper' => [ 'width' => '50' ],
			] )
			->addTab( 'Options' )
			->addSelect( 'series_number', [
				'instructions'      => 'Choose the number of series to display. Select "All" to enable pagination with a load more button.',
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
				'instructions'      => 'Enable this option to manually select specific series.',
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
				'instructions'      => 'Manually select the specific series to display when enabled.',
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
				'instructions'      => 'Choose the series categories to filter the series.',
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
				'instructions'      => 'Select the series industry to filter the series.',
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
			// 21. series_categories
			->addLayout( 'series_categories' )
			->addGroup( 'content', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Provide a headline and supporting content for the series categories section.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the series categories content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addGroup( 'options', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Choose the categories or industries to display in a three-column card grid layout.',
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
			// 22. series_table
			->addLayout( 'series_table' )
			->addTab( 'Table' )
			->addRepeater( 'rows', [
				'min'    => 1,
				'layout' => 'block',
			] )
			->addRepeater( 'columns', [
				'min'          => 1,
				'layout'       => 'block',
				'instructions' => 'Ensure each row has the same number of columns, even if some are left empty.',
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
				'instructions' => 'Provide a headline and supporting content for the table.',
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the table content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			// End blocks.
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
		// Get the current site ID in a Multisite environment.
		$site_id = get_current_blog_id();
		// Use the correct prefix for the current site.
		$table_name = $wpdb->prefix . 'frm_forms';

		// Query the database for the forms of the current site.
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
				'wrapper'      => [ 'width' => '50%' ],
				'instructions' => 'Provide a headline and supporting content for the "Get in Touch" section.',
			] )
			->addText( 'headline' )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons that will appear below the contact content.',
			] )
			->addLink( 'button' )
			->endRepeater()
			->endGroup()
			->addSelect( 'form', [
				'instructions'  => 'Choose the form to display (manage forms from the Formable tab).',
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
				'instructions' => 'Add a selling point to be displayed beneath the header.',
			] )
			->addImage( 'icon', [
				'preview_size' => 'small',
				'instructions' => 'Upload an appropriate SVG icon.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addText( 'Text', [
				'instructions' => 'Enter concise promotional text.',
				'wrapper'      => [ 'width' => '70' ],
			] )
			->endRepeater()
			->addTab( 'Copyright' )
			->addText( 'copyright', [
				'instructions' => 'Enter the appropriate copyright notice.',
			] )
			->addTab( 'Media' )
			->addImage( 'fallback_image', [
				'preview_size' => 'small',
				'instructions' => 'Upload a fallback image to use if the primary image is missing.',
				'wrapper'      => [ 'width' => '30' ],
			] )
			->addTab( 'contact_information' )
			->addText( 'phone_number', [
				'instructions' => 'Provide the phone number to be used throughout the theme.',
			] )
			->addText( 'mobile_number', [
				'instructions' => 'Provide the mobile number to be used throughout the theme.',
			] )
			->addText( 'email_address', [
				'instructions' => 'Provide the email address to be used throughout the theme.',
			] )
			->addTextarea( 'address', [
				'instructions' => 'Enter the address to appear across the theme.',
			] )
			->addTab( 'Series Promos' )
			->addGroup( 'categories', [
				'instructions' => 'Enter promo details for the series categories.',
			] )
			->addImage( 'categories_image', [
				'preview_size' => 'large',
				'instructions' => 'Upload an image for the series categories promo.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addTextarea( 'categories_content', [
				'instructions' => 'Enter supporting content for the series categories promo.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->endGroup()
			->addGroup( 'Industry', [
				'instructions' => 'Enter promo details for the series industry.',
			] )
			->addImage( 'industry_image', [
				'preview_size' => 'large',
				'instructions' => 'Upload an image for the series industry promo.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addTextarea( 'industry_content', [
				'instructions' => 'Enter supporting content for the series industry promo.',
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
				'instructions' => 'Enter a brief description of the product.',
			] )
			->addTab( 'Dimensions' )
			->addWysiwyg( 'dimensions', [
				'instructions' => 'Provide detailed information about the product’s dimensions.',
			] )
			->addTab( 'Key features' )
			->addWysiwyg( 'key_features', [
				'instructions' => 'List all the key features and specifications of the product.',
			] )
			->addTab( 'Testimonials' )
			->addRepeater( 'testimonials' )
			->addGroup( 'testimonial', [
				'wrapper'      => [ 'width' => '50' ],
				'instructions' => 'Upload a testimonial logo (SVG recommended).',
			] )
			->addImage( 'icon', [
				'preview_size' => 'thumbnail',
				'instructions' => 'Upload a logo for the testimonial (SVG recommended).',
			] )
			->addText( 'title', [
				'instructions' => 'Enter a title for the testimonial.',
			] )
			->endGroup()
			->addGroup( 'quote', [
				'instructions' => 'Enter the testimonial quote text.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addWysiwyg( 'content' )
			->addRepeater( 'buttons', [
				'min'          => 0,
				'max'          => 2,
				'layout'       => 'block',
				'instructions' => 'Add up to 2 buttons for the testimonial (optional).',
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
				'label'         => 'Select which section(s) this case study is related to',
				'instructions'  => 'Select the section(s) that relate to this case study.',
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
				'instructions'  => 'Select the series that relate to this product.',
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
				'instructions'  => 'Upload an appropriate image.',
			] )
			->addTextarea( 'summary', [
				'instructions' => 'Enter a brief description for this term.',
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
				'instructions' => 'Enter content to be displayed under the series title.',
			] )
			->addTextarea( 'summery', [
				'instructions' => 'Provide a brief description of the series.',
				'wrapper'      => [ 'width' => '50' ],
			] )
			->addTextarea( 'card_content', [
				'instructions' => 'Enter content to be displayed on the series card.',
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
				'instructions'  => 'Upload the product data sheet.',
				'return_format' => 'array',
			] )
			->addLink( '3d_cad_model', [
				'label'        => 'Link Field',
				'instructions' => 'Provide a URL to the 3D CAD model.',
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
				'instructions' => 'Enter detailed product specifications.',
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
				'instructions' => 'Add up to 2 call-to-action buttons to include in the header.',
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
				'instructions' => 'Enable this option to display a page header block with breadcrumbs and the page title.',
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
				'instructions' => 'Enable this option to display the header as an overlay.',
				'ui'           => 1,
			] )
			->addTrueFalse( 'background', [
				'instructions' => 'Enable this option to modify the header background style.',
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
				'instructions' => 'Upload an appropriate menu icon.',
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
				'instructions' => 'Enter a short description for this product category.',
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
