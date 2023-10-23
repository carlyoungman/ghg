<?php

/**
 * Class ACF
 *
 * A class to register and build ACF blocks
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;


use DateTime;
use Exception;
use JsonException as JsonExceptionAlias;
use StoutLogic\AcfBuilder\FieldsBuilder;


/**
 * Class Ajax
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class ACF {


	public static function flexible_components(): void {

		global $wpdb;

		$forms = $wpdb->get_results( 'SELECT * FROM wp_frm_forms' );
		if ( $forms ) {
			foreach ( $forms as $form ) {
				$formOpts[] = array(
					$form->id => $form->name
				);
			}
		}

		$flexible = new FieldsBuilder( 'flexible_components', [
			'hide_on_screen' => [
				'the_content',
			]
		] );


		$flexible->addFlexibleContent( 'flexible' )
			//Hero component
			     ->addLayout( 'hero' )
		         ->addGroup( 'options', [
			         'wrapper' => [ 'width' => '100' ]
		         ] )
		         ->addTrueFalse( 'super_size', [
			         'instructions' => 'Enable to super size the text. Only applies to h1 tags',
			         'ui'           => 1,
			         'wrapper'      => [ 'width' => '33' ]
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
			         'wrapper'      => [ 'width' => '33' ]
		         ] )
		         ->addTrueFalse( 'display_ticker', [
			         'instructions'      => 'Enable to display a text ticker along the bottom of the component',
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
			         ]
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
			         ]
		         ] )
		         ->endGroup()
		         ->addTab( 'Media' )
		         ->addImage( 'desktop_image', [
			         'preview_size' => 'medium',
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Please provide a suitable image for desktop users to be displayed.',
		         ] )
		         ->addImage( 'mobile_image', [
			         'preview_size' => 'medium',
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Please provide a suitable image for mobile users to be displayed.',
		         ] )
		         ->addTab( 'Content' )
		         ->addGroup( 'content', [
			         'wrapper' => [ 'width' => '100' ]
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
			//Headline with content
			     ->addLayout( 'headline_with_content' )
		         ->addGroup( 'options', [
			         'wrapper' => [ 'width' => '100' ]
		         ] )
		         ->endGroup()
		         ->addText( 'headline', [
			         'instructions' => 'Enter the headline text that will be displayed on the left of the component',
			         'wrapper'      => [ 'width' => '50' ]
		         ] )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter the supporting content that will be displayed on the right of the component',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
			//Image with content
			     ->addLayout( 'image_with_content' )
		         ->addGroup( 'options', [
			         'wrapper' => [ 'width' => '100' ]
		         ] )
		         ->addSelect( 'layout', [
			         'instructions' => 'Select an alternative layout for the block',
			         'choices'      => [
				         'image_offset'       => 'Image offset',
				         'simple-image-right' => 'Simple, image right',
				         'Simple_image_left'  => 'Simple, image left',
			         ],
			         'ui'           => 1,
			         'allow_null'   => 1,
			         'wrapper'      => [ 'width' => '33' ]
		         ] )
		         ->endGroup()
		         ->addImage( 'image', [
			         'preview_size' => 'small',
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Upload a suitable image. The cut off effect will be applied automatically',
		         ] )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter the supporting content that will be displayed on the right of the component',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
			// Key Points
			     ->addLayout( 'key_points' )
		         ->addGroup( 'options', [
			         'wrapper' => [ 'width' => '100%' ]
		         ] )
		         ->addTrueFalse( 'secondary_layout', [
			         'instructions' => 'Enable if you want to display the content in an alternate layout',
			         'ui'           => 1,
			         'width'        => '100',
		         ] )
		         ->endGroup()
		         ->addTab( 'Content' )
		         ->addGroup( 'content', [
			         'wrapper' => [ 'width' => '100' ]
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addTab( 'Key Points' )
		         ->addRepeater( 'key_points', [ 'min' => 1, 'max' => 6, 'layout' => 'block' ] )
		         ->addImage( 'icon', [
			         'preview_size' => 'small',
			         'instructions' => 'Upload a suitable SVG icon.',
			         'wrapper'      => [ 'width' => '30' ]
		         ] )
		         ->addGroup( 'content', [
			         'wrapper' => [ 'width' => '70' ]
		         ] )
		         ->addText( 'headline', [
			         'instructions' => 'Enter the headline of the point'
		         ] )
		         ->addTextarea( 'supporting_content', [
			         'instructions' => 'Enter some supporting content'
		         ] )
		         ->endGroup()
		         ->endRepeater()
			// News and Media
			     ->addLayout( 'news_&_media' )
		         ->addGroup( 'content', [
			         'wrapper' => [ 'width' => '50' ]
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addGroup( 'options', [
			         'wrapper' => [ 'width' => '50' ],
		         ] )
		         ->addSelect( 'number_of_posts', [
			         'instructions' => 'Select the number of posts to display. Select All if you want to enable load more functionality',
			         'choices'      => array(
				         3   => '3',
				         6   => '6',
				         9   => '9',
				         12  => '12',
				         - 1 => 'All',
			         ),
		         ] )
		         ->addPostObject( 'filter_by_category', [
			         'instructions'      => 'Select which category to filter by. Leave empty to use all categories.',
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
		         ->addTrueFalse( 'select_posts', [
			         'instructions' => 'Enable if you want to select individual posts to display',
			         'ui'           => 1,
		         ] )
		         ->addPostObject( 'individual_posts', [
			         'instructions'      => 'Select which posts you want to display',
			         'post_type'         => [
				         0 => 'post'
			         ],
			         'return_format'     => 'id',
			         'field_type'        => 'multi_select',
			         'allow_null'        => 1,
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
			         'wrapper' => [ 'width' => '50' ]
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addTab( 'Slider' )
		         ->addRepeater( 'Entries', [ 'min' => 1, 'max' => 10, 'layout' => 'block' ] )
		         ->addImage( 'image', [
			         'preview_size' => 'small',
			         'instructions' => 'Upload a suitable image or icon. SVG icon recommended',
			         'wrapper'      => [ 'width' => '30' ]
		         ] )
		         ->addTextarea( 'Text', [
			         'instructions' => 'Specify short text',
			         'wrapper'      => [ 'width' => '70' ]
		         ] )
		         ->endRepeater()
			// Slider Section
			     ->addLayout( 'testimonials' )
		         ->addGroup( 'testimonial', [
			         'wrapper' => [ 'width' => '50' ]
		         ] )
		         ->addImage( 'icon', [
			         'preview_size' => 'thumbnail',
			         'instructions' => 'Upload a suitable logo. SVG  recommended'
		         ] )
		         ->addText( 'title', [
			         'instructions' => 'Specify a title'
		         ] )
		         ->endGroup()
		         ->addGroup( 'quote', [
			         'instructions' => 'Specify quote text',
			         'wrapper'      => [ 'width' => '50' ]
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
			// Card grid
			     ->addLayout( 'cards_grid' )
		         ->addTab( 'content' )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter a headline and supporting content for the block',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [
			         'min'          => 0,
			         'max'          => 2,
			         'layout'       => 'block',
			         'instructions' => 'The buttons for this block will display underneath the grid',
		         ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addTab( 'cards' )
		         ->addRepeater( 'Cards', [ 'min' => 1, 'max' => 10, 'layout' => 'block' ] )
		         ->addImage( 'image', [
			         'preview_size' => 'small',
			         'instructions' => 'Upload a suitable image or icon',
			         'wrapper'      => [ 'width' => '30' ]
		         ] )
		         ->addGroup( 'Details', [
			         'wrapper' => [ 'width' => '70' ]
		         ] )
		         ->addText( 'headline', [
			         'instructions' => 'Enter a headline for the card',
		         ] )
		         ->addTextarea( 'Supporting_content', [
			         'instructions' => 'Enter some supporting content for the card',
		         ] )
		         ->addLink( 'link', [
			         'instructions' => 'Link the card to a webpage',
		         ] )
		         ->endGroup()
		         ->endRepeater()
			// Content block
			     ->addLayout( 'content_block' )
		         ->addGroup( 'content', [
			         'wrapper' => [ 'width' => '50' ]
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [
			         'min'    => 0,
			         'max'    => 2,
			         'layout' => 'block'
		         ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addGroup( 'options', [ 'wrapper' => [ 'width' => '50' ] ] )
		         ->addTrueFalse( 'max_width', [
			         'instructions' => 'Enable if you want to apply a max width to the content',
			         'ui'           => 1
		         ] )
		         ->addTrueFalse( 'center_align', [
			         'instructions' => 'Enable if you want to center align the content',
			         'ui'           => 1
		         ] )
		         ->endGroup()
			// Listing block
			     ->addLayout( 'listing_block' )
		         ->addGroup( 'options' )
		         ->addTrueFalse( 'background', [
			         'instructions' => 'Select the background colour of the block',
			         'ui'           => 1,
			         'ui_on_text'   => 'Steal',
			         'ui_off_text'  => 'Pearl'
		         ] )
		         ->endGroup()
		         ->addTab( 'list' )
		         ->addRepeater( 'list', [
			         'min'          => 0,
			         'layout'       => 'block',
			         'instructions' => 'List items will automatically be arranged into blocks of three',
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
			         'instructions' => 'The buttons for this block will display underneath the grid',
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
			         'ui_on_text'   => 'Steal',
			         'ui_off_text'  => 'Pearl'
		         ] )
		         ->endGroup()
		         ->addTab( 'content' )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter a headline and supporting content for the block',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [
			         'min'          => 0,
			         'max'          => 2,
			         'layout'       => 'block',
			         'instructions' => 'The buttons for this block will display underneath the grid',
		         ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addTab( 'cards' )
		         ->addRepeater( 'Cards', [ 'min' => 1, 'max' => 10, 'layout' => 'block' ] )
		         ->addGroup( 'Details', [
			         'wrapper' => [ 'width' => '70' ]
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
			// Inline Forms
			     ->addLayout( 'inline_forms' )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter a headline and supporting content for the block',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [
			         'min'          => 0,
			         'max'          => 2,
			         'layout'       => 'block',
			         'instructions' => 'The buttons for this block will display underneath the grid',
		         ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addSelect( 'form', [
			         'instructions'  => 'Select which form you want to display. Forms can be managed from the Formable tab',
			         'choices'       => $formOpts,
			         'ui'            => 1,
			         'allow_null'    => 0,
			         'wrapper'       => [ 'width' => '50' ],
			         'return_format' => 'array'
		         ] )
			// Maps
			     ->addLayout( 'location_map' )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter a headline and supporting content for the block',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [
			         'min'          => 0,
			         'max'          => 2,
			         'layout'       => 'block',
			         'instructions' => 'The buttons for this block will display underneath the grid',
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
			// Group listing
			     ->addLayout( 'group_listing' )
		         ->addTab( 'content' )
		         ->addGroup( 'content', [
			         'wrapper'      => [ 'width' => '50' ],
			         'instructions' => 'Enter a headline and supporting content for the block',
		         ] )
		         ->addWysiwyg( 'content' )
		         ->addRepeater( 'buttons', [
			         'min'          => 0,
			         'max'          => 2,
			         'layout'       => 'block',
			         'instructions' => 'The buttons for this block will display underneath the grid',
		         ] )
		         ->addLink( 'button' )
		         ->endRepeater()
		         ->endGroup()
		         ->addTab( 'Group' )
		         ->addRepeater( 'group', [ 'min' => 1, 'max' => 10, 'layout' => 'block' ] )
		         ->addImage( 'image', [
			         'preview_size' => 'small',
			         'instructions' => 'Upload a suitable image or icon',
			         'wrapper'      => [ 'width' => '30' ]
		         ] )
		         ->addGroup( 'Details', [
			         'wrapper' => [ 'width' => '70' ]
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
		         ->setLocation( 'post_type', '==', 'page' );
		acf_add_local_field_group( $flexible->build() );
	}

	public static function theme_settings(): void {
		$theme_settings = new FieldsBuilder( 'theme_settings', [
		] );
		$theme_settings->addTab( 'Get in touch' )
		               ->addGroup( 'get_in_touch_content', [
			               'wrapper' => [ 'width' => '50%' ]
		               ] )
		               ->addWysiwyg( 'content' )
		               ->addRepeater( 'buttons', [ 'min' => 0, 'max' => 2, 'layout' => 'block' ] )
		               ->addLink( 'button' )
		               ->endRepeater()
		               ->endGroup()
		               ->addTab( 'Socials' )
		               ->addUrl( 'facebook' )
		               ->addUrl( 'X' )
		               ->addUrl( 'Instagram' )
		               ->addUrl( 'YouTube' )
		               ->addTab( 'Google maps' )
		               ->addText( 'google_maps_API_key' )
		               ->setLocation( 'options_page', '==', 'theme-general-settings' );
		acf_add_local_field_group( $theme_settings->build() );
	}

	public static function header_settings(): void {
		$theme_settings = new FieldsBuilder( 'header_settings', [
		] );
		$theme_settings->addTrueFalse( 'overlay', [
			'instructions' => 'Enable if you want the header to overlay the first block on the page',
			'ui'           => 1,
		] )->addTrueFalse( 'background', [
			'instructions' => 'Select the background colour of the header',
			'ui'           => 1,
			'ui_on_text'   => 'Steal',
			'ui_off_text'  => 'Pearl',
		] )->setLocation( 'post_type', '==', 'page' );

		acf_add_local_field_group( $theme_settings->build() );
	}
}
