<?php
// MEDIA BLOCK
// Determines media type (image or video) based on passed object and outputs appropriate markup
$media = (isset($args)) ? $args : false;
$size = (isset($args['size'])) ?  $args['size'] :  '20vw';
$lazy = (isset($args['lazy'])) ?  $args['lazy'] :  true;
$wrap = (isset($args['wrap'])) ?  $args['wrap'] :  true;
$class = (isset($args['class'])) ?  $args['class'] :  '';
?>

<?php if ($media) {
    if ($wrap) { ?>
        <div class="media__wrap <?=$class?>">
        <?php } ?>
        <?php
        if (isset($media['type'])) {
            if ($media['type'] == 'image') {
                echo yr_image($media['id'], $size, $lazy);
            } else { ?>
                <video defaultmuted="" muted="" loop="" autoplay="" playsinline="" webkit-playsinline="" src="<?= $media['url'] ?>"></video>
        <?php }
        } ?>
        <?php if ($wrap) { ?>
        </div>
    <?php } ?>
    <?php ?>
<?php } else if(!$media && defined('WP_DEBUG') && true === WP_DEBUG) { ?>
    <p>Unable to load: bad or malformed media object</p>
<?php } ?>