<?php
/*==================================
|	Theme Initialisation
==================================*/

// SET GLOBAL PREFIX
// This is used for naming convetions in ACF (defaults to 'yr_')
function yr_global_prefix() {
	global $prefix;
	$prefix = 'yr_';
}

add_action('init', 'yr_global_prefix');



// Add Thumbnail Support
add_theme_support( 'post-thumbnails' );



// Add Title Tag Support
add_theme_support( 'title-tag' );



// Change Title Tag Seperator

function yr_title_seperator( $sep ) {

    $sep = '|';

    return $sep;

}
add_filter( 'document_title_separator', 'yr_title_seperator' );



// Allow SVG Uploads
function yr_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'yr_mime_types');



// Changing excerpt more
function yr_excerpt_more($more) {
  global $post;
  remove_filter('excerpt_more', 'yr_excerpt_more'); 
 return '...';
}
add_filter('excerpt_more','yr_excerpt_more');



// Change excerpt length
function yr_excerpt_length( $length ) {
	return 10;
}
add_filter( 'excerpt_length', 'yr_excerpt_length', 999 );



// Add image size(s)
add_image_size( 'acf_thumb', 120, 120, false );



// Register Menus
function yr_register_menus() {

	$locs = array(
			'header_menu' => __( 'Header Menu' ),
			'footer_menu' => __( 'Footer Menu' ),
			'mobile_menu' => __( 'Mobile Menu' )
	);
	register_nav_menus($locs);
}
add_action( 'init', 'yr_register_menus' );



// Sets API key based on ACF option input after theme setup
function yr_set_maps_key() {
	global $prefix;

	$key = (isset(get_field($prefix.'additional_details', 'option')[$prefix.'maps_key'])) ? get_field($prefix.'additional_details', 'option')[$prefix.'maps_key'] : false;
	
	if($key) {
		acf_update_setting('google_api_key', $key);
	}
}

add_action('acf/init', 'yr_set_maps_key');





// Remove wordpress global styles
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );




// Add post type field to ACF

function yr_load_post_type_field( $field ) {
    
    // reset choices
    $field['choices'] = array();
    
    
    // get the textarea value from options page without any formatting
    $choices = get_post_types(array(), 'objects');


    
    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        
        foreach( $choices as $choice ) {

            $field['choices'][ $choice->name ] = $choice->label;
            
        }
        
    }
    

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=yr_post_type', 'yr_load_post_type_field');