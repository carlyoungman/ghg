<?php
/*======================================
|	Theme Register (Post types etc)
======================================*/

add_action('admin_head', function() { ?>

    <style>
        .dashicons-snippet:before {
            content:'';
            mask-position: center;
            -webkit-mask-position: center;
            mask-size: contain;
            -webkit-mask-size: contain;
            mask-image: url("data:image/svg+xml,%3Csvg height='16' viewBox='0 0 16 16' width='16' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m11.168.94540563c.3063-.459528.9272-.583702 1.3867-.27735.4595.306353.5837.927221.2774 1.386751l-3.45503 5.18249 1.93363 2.67732c.0338.04685.063.09568997.0877.14578997.1943-.0395.3955-.0603.6016-.0603 1.6569 0 3 1.3431 3 3s-1.3431 3-3 3c-1.65685 0-3-1.3431-3-3 0-.7275.25896-1.3945.68974-1.9139l-1.49686-2.07261997-.36081.54122c-.30636.45949997-.92723.58369997-1.38675.27735-.45953-.30635-.58371-.92722-.27735-1.38675l.77499-1.16249-3.75363-5.19732c-.32335-.44772-.22253-1.07281.22519-1.396168.44773-.323358 1.07281-.222538 1.39617.225188l3.31646 4.59202zm-.168 12.05470097c0 .5523.4477 1 1 1s1-.4477 1-1-.4477-1-1-1-1 .4477-1 1zm-7-3c1.65685 0 3 1.3431 3 3s-1.34315 3-3 3-3-1.3431-3-3 1.34315-3 3-3zm-1 3c0 .5523.44772 1 1 1s1-.4477 1-1-.44772-1-1-1-1 .4477-1 1z' fill-rule='evenodd'/%3E%3C/svg%3E");
            -webkit-mask-image: url("data:image/svg+xml,%3Csvg height='16' viewBox='0 0 16 16' width='16' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m11.168.94540563c.3063-.459528.9272-.583702 1.3867-.27735.4595.306353.5837.927221.2774 1.386751l-3.45503 5.18249 1.93363 2.67732c.0338.04685.063.09568997.0877.14578997.1943-.0395.3955-.0603.6016-.0603 1.6569 0 3 1.3431 3 3s-1.3431 3-3 3c-1.65685 0-3-1.3431-3-3 0-.7275.25896-1.3945.68974-1.9139l-1.49686-2.07261997-.36081.54122c-.30636.45949997-.92723.58369997-1.38675.27735-.45953-.30635-.58371-.92722-.27735-1.38675l.77499-1.16249-3.75363-5.19732c-.32335-.44772-.22253-1.07281.22519-1.396168.44773-.323358 1.07281-.222538 1.39617.225188l3.31646 4.59202zm-.168 12.05470097c0 .5523.4477 1 1 1s1-.4477 1-1-.4477-1-1-1-1 .4477-1 1zm-7-3c1.65685 0 3 1.3431 3 3s-1.34315 3-3 3-3-1.3431-3-3 1.34315-3 3-3zm-1 3c0 .5523.44772 1 1 1s1-.4477 1-1-.44772-1-1-1-1 .4477-1 1z' fill-rule='evenodd'/%3E%3C/svg%3E");
            mask-repeat: no-repeat;
            -webkit-mask-repeat: no-repeat;
            background-color: rgba(240,246,252,.6);
        }
        .menu-icon-snippet:hover .dashicons-snippet:before {
            background-color: #72aee6;
        }
    </style>

<?php });

function snippet_meta_box($post) {

    add_meta_box('snippet_intro_meta', 'Snippets Help', function() {
        
        $html = '<h3 style="margin-bottom: 0; display: flex; align-items: center"><span style="margin-right: 5px;" class="dashicons dashicons-editor-help" aria-hidden="true"></span> What are Snippets?</h3><br/>';
        $html .= 'Snippets are independant blocks of content which can be reused throughout the website, avoiding the need to duplicate content.';
        $html .= '<br/><br/>Here you can create a new snippet or edit an existing one.';
        $html .= '<br/><br/>Once you have created a snippet, you can assign it to a <a href="/wp-admin/edit.php?post_type=page">page</a> by using the "Snippet" flexible content module in the page editor.';
        
        echo $html;
    }, null, 'side', 'high');

}

// Custom post type loop 
add_action('init', function () {

    // Add post types to main array (use singular terms)
    // postTypeName => $args
    $postTypes = array(
        'snippet' => array(
            'menu_icon' => 'dashicons-snippet',
            'supports' => ['title'],
            'public' => false,
            'register_meta_box_cb' => 'snippet_meta_box',
        ),
    );

    // Begin loop
    foreach ($postTypes as $postTypeName => $postTypeArgs) {

        // Format labels
        $ucName = ucwords($postTypeName);
        
        // Format plural appropriately
        $plural = (substr($postTypeName, -1) == 'y') ? rtrim($postTypeName, 'y') .'ies' : $postTypeName.'s';
        // Update plural val if set to false
        $plural = (isset($postTypeArgs['plural']) && !$postTypeArgs['plural']) ? $postTypeName : $plural;
        $ucPlural = ucwords($plural);


        $labels = array(
            'name'                  => _x($ucPlural, 'Post type general name', 'yeahright'),
            'singular_name'         => _x($ucName, 'Post type singular name', 'yeahright'),
            'menu_name'             => _x($ucPlural, 'Admin Menu text', 'yeahright'),
            'name_admin_bar'        => _x($ucName, 'Add New on Toolbar', 'yeahright'),
            'add_new'               => __('Add New', 'yeahright'),
            'add_new_item'          => __('Add New ' . $ucName, 'yeahright'),
            'new_item'              => __('New ' . $ucName, 'yeahright'),
            'edit_item'             => __('Edit ' . $ucName, 'yeahright'),
            'view_item'             => __('View ' . $ucName, 'yeahright'),
            'all_items'             => __('All ' . $ucPlural, 'yeahright'),
            'search_items'          => __('Search ' . $plural, 'yeahright'),
            'parent_item_colon'     => __('Parent ' . $plural . ':', 'yeahright'),
            'not_found'             => __('No ' . $plural . ' found.', 'yeahright'),
            'not_found_in_trash'    => __('No ' . $plural . ' found in Trash.', 'yeahright')
        );

        // Add labels to args
        $postTypeArgs['labels'] = $labels;

        // Default args
        $args = array(
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'thumbnail','editor'),
            'menu_icon'          => 'dashicons-admin-post'
        );

        // Set default args for those not passed
        foreach($args as $argKey => $argVal) {
            $postTypeArgs[$argKey] = (isset($postTypeArgs[$argKey])) ? $postTypeArgs[$argKey] : $argVal;
        }

        // Add additional args based on posttype name (if none passed)
        $postTypeArgs['rewrite'] = (isset($postTypeArgs['rewrite'])) ? $postTypeArgs['rewrite'] : array('slug' => $postTypeName);

        // Register with wordpress
        register_post_type($postTypeName, $postTypeArgs);
    }
});




// REGISTER TAXONOMIES

function yr_register_taxonomies() {

    $labels = array(
        'name'              => _x( 'Products', 'taxonomy general name', 'yeahright' ),
        'singular_name'     => _x( 'Product', 'taxonomy singular name', 'yeahright' ),
        'search_items'      => __( 'Search Products', 'yeahright' ),
        'all_items'         => __( 'All Products', 'yeahright' ),
        'view_item'         => __( 'View Product', 'yeahright' ),
        'parent_item'       => __( 'Parent Product', 'yeahright' ),
        'parent_item_colon' => __( 'Parent Product:', 'yeahright' ),
        'edit_item'         => __( 'Edit Product', 'yeahright' ),
        'update_item'       => __( 'Update Product', 'yeahright' ),
        'add_new_item'      => __( 'Add New Product', 'yeahright' ),
        'new_item_name'     => __( 'New Product Name', 'yeahright' ),
        'not_found'         => __( 'No Products Found', 'yeahright' ),
        'back_to_items'     => __( 'Back to Products', 'yeahright' ),
        'menu_name'         => __( 'Product', 'yeahright' ),
    );
 
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'product' ),
        'show_in_rest'      => true,
    );
 
 
    register_taxonomy( 'product', 'work', $args );

}

add_action('init', 'yr_register_taxonomies');



// REGISTER SIDEBARS

// function yr_register_sidebars() {

//     $footer = array(
//         'id' => 'footer-widgets',
//         'before_widget' => '<div class="widget %2$s">',
//         'after_widget' => '</div>',
//         'before_title' => '<h5 class="widgettitle">',
//         'after_title' => '</h5>',        
//         'name'=>__( 'Footer Widgets', 'yeah-right' ),  
//     ); 

//     register_sidebar($footer);

// }

// add_action('init', 'yr_register_sidebars');