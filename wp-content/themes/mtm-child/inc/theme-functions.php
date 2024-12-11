<?php
/*==================================
|	Theme Custom Functions
==================================*/


// GET THEME PREFIX
// Retrieves global theme prefix for naming conventions
function get_theme_prefix()
{
    global $prefix;
    return $prefix;
}


// RETURN SVG CONTENT
function svg($name)
{

    // Locate svg file
    $svg_file = file_get_contents(get_stylesheet_directory() . '/dist/assets/images/svg/' . $name . '.svg');

    // Return SVG code if available, or false if not
    if ($svg_file) {
        return $svg_file;
    } else {
        return false;
    }
}



// BUILD EMAIL TEMPLATE
function build_email_template($form)
{

    // Declare default empty string 
    $html = '';

    // Basic stylihg for readability.
    // Can be customised.
    $html .= '
    <style>
        * {
            font-family: Helvetica, sans-serif;
        }
    </style>
    <strong>You have a received an email</strong><br/><br/>
    ';

    // Add email fields conditionally
    $html .= isset($form['name']) ? '<strong>Name:</strong> ' . $form['name'] . '<br/>' : '';
    $html .= isset($form['email']) ? '<strong>Email:</strong> ' . $form['email'] . '<br/>' : '';
    $html .= isset($form['phone']) ? '<strong>Phone:</strong> ' . $form['phone'] . '<br/>' : '';
    $html .= isset($form['subject']) ? '<strong>Subject:</strong> ' . $form['subject'] . '<br/>' : '';
    $html .= isset($form['message']) ? '<strong>Message:</strong><br/><br/>' . $form['message'] : '';

    return $html;
}




// HANDLE FORM SUBMISSION
function contact_form_submit()
{

    global $prefix;

    // Get email contents
    $form = $_POST;
    $siteName = get_bloginfo();

    // Get thank you page
    $thankYou = get_field($prefix . 'additional_details', 'option')[$prefix . 'thankyou_page'];
    $thankYouPage = get_permalink(get_page($thankYou)) ? get_permalink(get_page($thankYou)) : $form['redirect'] . '?sent';

    // Get email address in theme settings, defaults to site admin email
    $to = isset(get_field($prefix . 'contact_details', 'option')['contact_email']) ? get_field($prefix . 'contact_details', 'option')['contact_email'] : get_option('admin_email');
    $subject = isset($form['subject']) ? $form['subject'] : 'New Message | ' . $siteName;
    $headers = array('Content-type: text/html');
    // $to = 'blah';

    // Include email template
    $content = buildEmailTemplate($form);
    $sent = wp_mail($to, $subject, $content, $headers);

    // If email submission was successful, redirect to thank you page
    // if not, go back to contact page and return the field data
    if ($sent) {
        wp_safe_redirect($thankYouPage);
        exit;
    } else {
        $string = http_build_query($_POST);
        $string = base64_encode($string);
        wp_safe_redirect($form['redirect'] . '?q=' . $string . '#contact-form');
        exit;
    }
}
add_action('admin_post_contact_form', 'contact_form_submit');
add_action('admin_post_nopriv_contact_form', 'contact_form_submit');



// HIDE CONTENT EDITOR 
function remove_editor()
{
    if (isset($_GET['post'])) {

        $id = $_GET['post'];
        $home = get_option('page_on_front');

        // If the current page template matches those below, remove editor
        $template = get_post_meta($id, '_wp_page_template', true);
        $postType = get_post_type($id);

        if ($postType == 'page') {
            remove_post_type_support('page', 'editor');
        }

        if ($id == $home) {
            remove_post_type_support('page', 'editor');
        }

        switch ($template) {
            case 'templates/template-faqs.php':
                remove_post_type_support('page', 'editor');
                break;
            default:
                // Don't remove any other template.
                break;
        }
    }
}
add_action('init', 'remove_editor');


function yr_socials($svg = false, $class = "")
{

    global $prefix;

    // Get socials from backend
    $socials = get_field($prefix . 'additional', 'option')['socials'];

    $class .= ($svg) ? 'socials--icons' : '';

    // Open list tag
    $html = '<ul class="socials ' . $class . '">';

    // Build list items
    foreach ($socials as $key => $val) {

        // Format for name
        $name = str_replace('yr_social_', '', $key);

        if ($val != '' && $name !== '') {
            // Open item
            $html .= '<li class="socials--' . $name . '"><a href="' . $val . '" title="Follow us on ' . ucfirst($name) . '">';

            // Print name (hidden if SVG is true)
            $html .= ucfirst($name);

            // Close item
            $html .= '</a>
            </li>';
        }
    }

    // Close list tag
    $html .= '</ul>';

    return $html;
}




// IMAGE MARKUP BUILDER
function yr_image($imgId = false, $sizes = '100vw', $lazyLoad = true)
{
    $html = '';
    if ($imgId) {

        // build image array
        $imgObj = array(
            'sizes' => array(
                'large' => (wp_get_attachment_image_url($imgId, 'large') ? wp_get_attachment_image_url($imgId, 'large') : ''),
                'medium' => (wp_get_attachment_image_url($imgId, 'medium') ? wp_get_attachment_image_url($imgId, 'medium') : ''),
                'thumb' => (wp_get_attachment_image_url($imgId, 'thumbnail') ? wp_get_attachment_image_url($imgId, 'thumbnail') : ''),
            ),
            'alt' => (isset(get_post_meta($imgId, '_wp_attachment_image_alt')[0])) ? get_post_meta($imgId, '_wp_attachment_image_alt')[0] : get_the_title($imgId)
        );


        // BUILD SRCSET
        $srcset = 'srcset="';

        // Set default src
        $default = (isset($imgObj['sizes']['thumb'])) ? $imgObj['sizes']['thumb'] : $imgObj['url'];

        // Add thumb size
        if (isset($imgObj['sizes']['thumb'])) {
            $srcset .= $imgObj['sizes']['thumb'] . ' 300w,';
        }

        // Add small size
        if (isset($imgObj['sizes']['thumb'])) {
            $srcset .= $imgObj['sizes']['thumb'] . ' 500w,';
        }

        // Add medium size
        if (isset($imgObj['sizes']['medium'])) {
            $srcset .= $imgObj['sizes']['medium'] . ' 800w,';
        }
        // Add large size
        if (isset($imgObj['sizes']['large'])) {
            $srcset .= $imgObj['sizes']['large'] . ' 1200w';
        }
        $srcset .= '"';
        // CLOSE SRCSET

        // Option to disable browser-native lazy loading (limited compatibility at time of writing)
        $lazy = ($lazyLoad) ? 'loading="lazy"' : '';

        // Get title (used as alt fallback)
        $title = (isset($imgObj['title'])) ? $imgObj['title'] : '';

        // Set alt if one is available (if not fallback to title)
        $alt = ($imgObj['alt']) ? 'alt="' . $imgObj['alt'] . '"' : 'alt="' . $title . '"';

        $classes = (isset($imgObj['classes'])) ? ' class="' . $imgObj['classes'] . '"' : '';
        $html .= '<img src="' . $default . '" ' . $srcset . ' ' . $alt . $classes . ' ' . $lazy . ' sizes="' . $sizes . '" />';

        // Return markup
        return $html;
    } else {
        return false;
    }
}




// Calculates approximare reading time of passed string (assumes a default average speed of 250 words per minute)
function yr_reading_time($string = false, $speed = 250)
{

    if ($string) {

        $html = '';

        // Determine value
        $words = explode(' ', $string);
        $wordCount = count($words);
        $time = $wordCount / $speed;

        // Determine text
        $text = 'minute read';

        if ($time < 1) {
            $time = 1;
        }

        $html .= round($time) . ' ' . $text;

        return $html;
    }
}



// STYLED BUTTON BUILDER
function yr_button($props, $link = true)
{

    $html;

    if (!is_array($props)) {
        return false;
    }

    if (!$link) {
        $tagOpen = '<button ';
        $tagClose = '</button>';
    } else {
        $tagOpen = '<a ';
        $tagClose = '</a>';
    }

    // Destructure passed properties
    $url = isset($props['url']) ? $props['url'] : '';
    $target = (isset($props['target']) && $props['target'] !== '') ? $props['target'] : '_self';
    $title = isset($props['title']) ? $props['title'] : '';
    $class = isset($props['class']) ? $props['class'] : '';
    $href = ($link) ? 'rel="noreferrer noopener" href="' . $url . '" target="' . $target . '"' : '';

    // Final construction
    $html = $tagOpen . ' class="btn ' . $class . '"' . $href . '><span>' . $title . '</span>' . $tagClose;

    return $html;
}


// AMEND THIS AS NEEDED FOR LOOPING PARTIALS
function yr_get_content_section($content = false, $count = false)
{
    if ($content) {
        include(locate_template('/partials/content-default.php'));
    }
}




function yr_breadcrumbs($sep = '<span>|</span>')
{

    if (!is_front_page()) {

        // Start the breadcrumb with a link to your homepage
        echo '<div class="breadcrumbs">';
        echo '<a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a>' . $sep;

        // Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        if (is_category() || is_single()) {
            the_category('title_li=');
        } elseif (is_archive() || is_single()) {
            if (is_day()) {
                printf(__('%s', 'text_domain'), get_the_date());
            } elseif (is_month()) {
                printf(__('%s', 'text_domain'), get_the_date(_x('F Y', 'monthly archives date format', 'text_domain')));
            } elseif (is_year()) {
                printf(__('%s', 'text_domain'), get_the_date(_x('Y', 'yearly archives date format', 'text_domain')));
            } else {
                _e('Blog Archives', 'text_domain');
            }
        }

        // If the current page is a single post, show its title with the separator
        if (is_single()) {
            echo $sep;
            the_title();
        }

        // If the current page is a static page, show its title.
        if (is_page()) {
            echo the_title();
        }

        // if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        if (is_home()) {
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ($page_for_posts_id) {
                $post = get_page($page_for_posts_id);
                setup_postdata($post);
                the_title();
                rewind_posts();
            }
        }

        echo '</div>';
    }
}


// Tool to help generate unique IDs (mainly for ACF fields)
function yr_gen_id()
{
    global $prefix;

    if (isset($_GET['yrid']) && current_user_can('administrator')) {

        $key = '$prefix."' . uniqid() . '"';
        $html = "<section class='content content--key'>
            <div class='container-fluid container--max'>
                <div class='row vh vh--100 align-items-center'>
                    <div class='col-10 mx-auto col-md-6 col-lg-4 text-center'>
                    <h4 style='font-size:2rem;font-weight: bold' class='mb-5'>Copy and paste this unique field key</h4>
                        <pre read-only style='padding: 1rem 4rem; display:inline-block; background: #f6f6f6; color:darkred'>$key</pre>
                    </div>
                </div>
            </div>
        </section>";

        // Ouput page
        get_header();
        echo $html;
        get_footer();

        exit;
    }
    return false;
}

add_action('init', 'yr_gen_id');






// Helper to output data attribute markup based on array data
function yr_build_data($data = array())
{
    // Output data attributes
    if ($data && is_array($data)) {
        $dataAttrs = '';
        foreach ($data as $key => $val) {
            $dataAttrs .= 'data-' . $key . '="' . $val . '" ';
        }
        return $dataAttrs;
    }
}




function get_flexible_content()
{

    global $prefix, $post;

    // Check flex content exists
    if (have_rows($prefix . 'flexible', $post->ID)) {

        // Loop through layouts/rows
        while (have_rows($prefix . 'flexible', $post->ID)) {

            the_row();
            $layout = get_row_layout();
            $data = [];

            // Get tempate for layout
            if ($layout == 'hero') {

                // Get data
                $section = [
                    'layout' => get_sub_field('layout'),
                    'title' => get_sub_field('title'),
                    'size' => get_sub_field('size'),
                    'text' => get_sub_field('text'),
                    'media' => get_sub_field('media'),
                    'media_mobile' => get_sub_field('media_mobile'),
                    'link' => get_sub_field('link'),
                    'ticker' => get_sub_field('ticker'),
                ];

                $data = array_merge($data, $section);


                get_template_part('partials/section', false, [
                    'type' => 'hero',
                    'data' => $data
                ]);
            } else if ($layout == 'inline_text') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'link' => get_sub_field('link'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'inline-text',
                    'data' => $data
                ]);
            } else if ($layout == 'center_text') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'link' => get_sub_field('link'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'center-text',
                    'data' => $data
                ]);
            } else if ($layout == 'inline_media') {

                $type = get_sub_field('layout');

                // Get data
                $section = [
                    'layout' => get_sub_field('layout'),
                    'media' => get_sub_field('media'),
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'link' => get_sub_field('link'),
                    'colour' => get_sub_field('colour'),
                    'order' => get_sub_field('order'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'inline-media',
                    'data' => $data,
                    'class' => 'inline--' . $type
                ]);
            } else if ($layout == 'inline_form') {

                // Get data
                $section = [
                    'form' => get_sub_field('form'),
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'link' => get_sub_field('link'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'inline-form',
                    'data' => $data,
                ]);
            } else if ($layout == 'blocks') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'entries' => get_sub_field('entries'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'blocks',
                    'data' => $data,
                    'class' => 'section--mid'
                ]);
            } else if ($layout == 'checklist') {

                $entries = get_sub_field('entries');
                $count = count($entries);

                $class = ($count && $count < 4) ? 'checklist--three' : 'checklist--two';

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'entries' => $entries,
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'checklist',
                    'data' => $data,
                    'class' => $class
                ]);
            } else if ($layout == 'grid') {

                $title = get_sub_field('title');
                $text = get_sub_field('text');

                $class = ($title !== '' && $text !== '') ? 'section--mid' : '';

                // Get data
                $section = [
                    'title' => $title,
                    'text' => $text,
                    'entries' => get_sub_field('entries'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'grid',
                    'data' => $data,
                    'class' => $class
                ]);
            } else if ($layout == 'cards') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'entries' => get_sub_field('entries'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'cards',
                    'data' => $data,
                ]);
            } else if ($layout == 'featured') {

                $class = (get_sub_field('colour') == 'light') ? 'section--mid' : 'section--dark';

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'media' => get_sub_field('media'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'featured',
                    'data' => $data,
                    'class' => $class
                ]);
            } else if ($layout == 'testimonial') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'image' => get_sub_field('image'),
                    'text' => get_sub_field('text'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'testimonial',
                    'data' => $data,
                ]);
            } else if ($layout == 'map') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'text' => get_sub_field('text'),
                    'location' => get_sub_field('location'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'map',
                    'data' => $data,
                ]);

            } else if ($layout == 'slider') {

                // Get data
                $section = [
                    'title' => get_sub_field('title'),
                    'entries' => get_sub_field('entries'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'slider',
                    'data' => $data,
                ]);


            } else if ($layout == 'wysiwyg') {

                // Get data
                $section = [
                    'content' => get_sub_field('content'),
                ];

                $data = array_merge($data, $section);

                get_template_part('partials/section', false, [
                    'type' => 'content',
                    'data' => $data,
                ]);
            
            } else if ($layout == 'snippet') {

                // Get selected snippet & layout type
                $snippet = get_sub_field('content');
                $type = get_field('layout', $snippet);
                $icon = get_field('icon', $snippet);

                // Get data
                $section = [
                    'title' => get_field('title', $snippet),
                    'colour' => get_field('colour', $snippet),
                    'text' => get_field('text', $snippet),
                    'link' => get_field('link', $snippet),
                ];

                $data = array_merge($data, $section);

                $class = ($icon) ? 'snippet section--snippet snippet--icon' : 'section--snippet';
                $class .= ' snippet--' . $snippet->post_name;

                get_template_part('partials/section', false, [
                    'type' => $type,
                    'data' => $data,
                    'snippet' =>  true,
                    'class' => $class
                ]);
            }
        }
    }
}
