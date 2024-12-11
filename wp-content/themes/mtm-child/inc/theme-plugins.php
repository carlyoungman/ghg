<?php
/*==================================
|	Theme Plugins
==================================*/

// Customize ACF Dir
function yr_acf_settings_dir( $dir ) {

    // update path
    $dir = get_template_directory_uri() . '/inc/admin/acf/';

    // return
    return $dir;

}
add_filter('acf/settings/dir', 'yr_acf_settings_dir');



// Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');



// Init Advanced Custom Fields
include_once(get_template_directory().'/inc/admin/acf/acf.php');




// Google maps
function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyCEroemGXmF_psMrWHYdZGJeQDMskT7K1o');
}
add_action('acf/init', 'my_acf_init');

