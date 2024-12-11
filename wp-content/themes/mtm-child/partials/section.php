<?php
// Partial | Base Section

$type = (isset($args['type'])) ?  $args['type'] :  'content'; // Section type
$snippet = (isset($args['snippet'])) ?  $args['snippet'] :  false; // Section snippet?

// Content data
$layout = (isset($args['data']['layout'])) ?  $args['data']['layout'] :  'default'; // Section layout
$title = (isset($args['data']['title'])) ?  $args['data']['title'] :  false; // Section title text
$content = (isset($args['data']['content'])) ?  $args['data']['content'] :  false; // Section title text
$size = (isset($args['data']['size'])) ?  $args['data']['size'] :  'default'; // Section title text
$text = (isset($args['data']['text'])) ?  $args['data']['text'] :  false; // Section body/intro text
$form = (isset($args['data']['form'])) ?  $args['data']['form'] :  false; // Section form id
$colour = (isset($args['data']['colour'])) ?  $args['data']['colour'] :  false; // Section colour scheme
$order = (isset($args['data']['order'])) ?  $args['data']['order'] :  false; // Section body/intro text
$shortcode = (isset($args['data']['shortcode'])) ?  $args['data']['shortcode'] :  false; // Plugin Shortcode
$location = (isset($args['data']['location'])) ?  $args['data']['location'] :  false; // Location
$link = (isset($args['data']['link'])) ?  $args['data']['link'] :  false; // Section link
$icon = (isset($args['data']['icon'])) ?  $args['data']['icon'] :  false; // Section icon
$ticker = (isset($args['data']['ticker']) && $args['data']['ticker'] !== '') ?  $args['data']['ticker'] :  false; // Ticker text
$media = (isset($args['data']['media'])) ?  $args['data']['media'] :  false; // Section media
$media_mobile = (isset($args['data']['media_mobile']) && $args['data']['media_mobile']) ?  $args['data']['media_mobile'] :  (isset($args['data']['media']) ? $args['data']['media'] : false); // Section media for mobile
$image = (isset($args['data']['image'])) ?  $args['data']['image'] :  false; // Section image
$entries = (isset($args['data']['entries'])) ?  $args['data']['entries'] :  false; // Content to be looped

$title = (!$title && $type == 'hero') ? get_the_title() : $title;

// Section element ID
$id = (isset($args['id'])) ? $args['id'] :  '';

// Build class string
$class = $type; // Class must start with section type
$class .= isset($args['class']) ?  ' '.$args['class'] :  '';
$class .= $media && $layout == 'full' ? ' section--media-full' : '';
$class .= $media && $layout == 'default' ? ' section--has-media' : ''; 
$class .= $colour ? ' section--'.$colour : '';
$class .= $order && $order == 'text' ? ' '.$type.'--reverse' : '';
?>

<?php if($title || $content || $text || $link || $media || $entries || $type == 'featured') { ?>
<section <?=($id) ? 'id="'.$id.'"' : ''?> class="<?=$class?>" data-anim>
    <?php 
    $templatePart = locate_template('partials/section-'.$type.'.php');
    include($templatePart);
    ?>
</section>
<?php } ?>