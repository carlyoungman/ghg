<?php
/*==================================
|	Theme Security
==================================*/

// REMOVE ABILITY TO EDIT FILES FROM DASHBOARD
define('DISALLOW_FILE_EDIT', true);



// REMOVE WP VERSION FROM HEAD
remove_action('wp_head', 'wp_generator');



// REMOVE WP VERSION
function yr_remove_version() {
    return '';
}
add_filter('the_generator', 'yr_remove_version');



// CHANGE WORDPRESS LOGIN ERROR
function yr_wordpress_error() {
    return 'We have disabled Login Hints, This helps us keep unwanted visitors out, like you.';
}
add_filter('login_errors', 'yr_wordpress_error');



// BLOCK BAD QUERIES
function yr_block_queries ()   {
    global $user_ID;
    if ($user_ID) {
        if (!current_user_can('level_10')) {
            if (strlen($_SERVER['REQUEST_URI']) > 255 ||
                strpos($_SERVER['REQUEST_URI'], "eval(") ||
                strpos($_SERVER['REQUEST_URI'], "CONCAT") ||
                strpos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
                strpos($_SERVER['REQUEST_URI'], "base64")) {
                @header("HTTP/1.1 414 Request-URI Too Long");
                @header("Status: 414 Request-URI Too Long");
                @header("Connection: Close");
                @exit;
            }
        }
    }
}
yr_block_queries();



// REMOVE MENUS FOR NON-ADMINS
function yr_remove_menus()  {
    remove_menu_page('edit-comments.php'); 
    if(!current_user_can('administrator') ) {
        remove_menu_page( 'themes.php' );
        remove_menu_page( 'plugins.php' );
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'options-general.php' );
    }
}
add_action('admin_menu', 'yr_remove_menus');



// REMOVE COMMENT FUNCTIONALITY
function yr_disable_comments() {
    
    add_action('admin_init', function () {
        // Redirect any user trying to access comments page
        global $pagenow;
        
        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }

        // Remove comments metabox from dashboard
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

        // Disable support for comments and trackbacks in post types
        foreach (get_post_types() as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    });

    // Close comments on the front-end
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);

    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);

    // Remove comments page in menu
    add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
    });

    // Remove comments links from admin bar
    add_action('init', function () {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    });

}

yr_disable_comments();