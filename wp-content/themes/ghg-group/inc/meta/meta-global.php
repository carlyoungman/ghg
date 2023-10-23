<?php
/*==================================
|	Global Meta
==================================*/


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
	));

}

if(function_exists('acf_add_local_field_group')){

	// get pages to select
	$query = new WP_Query(array('post_type' => 'page'));
	$allpages = array();
	foreach($query->posts as $thispage){
		$allpages[$thispage->ID] = $thispage->post_title;
	}
	// Add default to start
	$defaultPage = array(null => 'None');
	$allpages = $defaultPage + $allpages;


	// Global Page Meta
	acf_add_local_field_group(array (
		'key' => $prefix.'theme_global',
		'title' => 'Global Theme Meta',
		'message' => 'The following settings are optional and will not appear if no value has been specified',
		'fields' => array (
			array(
				'key' => $prefix."62ea5d0d1876",
				'label' => 'Contact Details',
				'name' => $prefix.'contact',
				'type' => 'group',
				'sub_fields' => array(
					array(
						'key' => $prefix."62ea5d0d1876a",
						'label' => 'Contact Phone Number',
						'instructions' => 'Enter a phone number to be used throughout the theme',
						'name' => 'phone',
						'type' => 'text',
					),
					array(
						'key' => $prefix."62ea5d0d1876b",
						'label' => 'Contact Mobile Number',
						'instructions' => 'Enter a mobile number to be used throughout the theme',
						'name' => 'mobile',
						'type' => 'text',
					),
					array(
						'key' => $prefix."62ea5d0d1876c",
						'label' => 'Contact Email',
						'instructions' => 'Enter an email address to be used throughout the theme',
						'name' => 'email',
						'type' => 'text',
					),
					array(
						'key' => $prefix."62ea5d0d1876d",
						'label' => 'Contact Address',
						'instructions' => 'Enter an address to appear throughout the theme',
						'name' => 'address',
						'type' => 'textarea',
					),
				),
				'wrapper' => array(
					'width'	=>	'50'
				)
			),
			array(
				'key' => $prefix."42eb5d0d1275",
				'label' => 'Additional Details',
				'name' => $prefix.'additional',
				'type' => 'group',
				'wrapper' => array(
					'width'	=>	'50'
				),
				'sub_fields' => array(
					array(
						'key' => $prefix."42eb5d0d1275a",
						'label' => 'Contact Thank You Page',
						'name' => 'thankyou_page',
						'type' => 'select',
						'choices' => $allpages,
					),
					array(
						'key' => $prefix."42eb5d0d1275b",
						'label' => 'Google Maps API Key',
						'name' => 'maps_key',
						'type' => 'text',
					),
					array(
						'key' => $prefix."42eb5d0d1275c",
						'label' => 'Social Profiles',
						'name' => 'socials',
						'type' => 'group',
						'sub_fields' => array(
							array(
								'key' => $prefix."42eb5d0d1275c4",
								'label' => 'Facebook Page URL',
								'name' => 'facebook',
								'type' => 'url',
							),
							array(
								'key' => $prefix."42eb5d0d1275c3",
								'label' => 'Twitter Page URL',
								'name' => 'twitter',
								'type' => 'url',
							),
							array(
								'key' => $prefix."42eb5d0d1275c2",
								'label' => 'Instagram Page URL',
								'name' => 'instagram',
								'type' => 'url',
							),
							array(
								'key' => $prefix."42eb5d0d1275c1",
								'label' => 'YouTube Page URL',
								'name' => 'youtube',
								'type' => 'url',
							),
						)
					)
				)
			),
	
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
		'readonly' => 0,
		'disabled' => 0,
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-options',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));

}