<?php
// Partial | Map Section Contents
global $prefix;
$key = get_field($prefix.'additional', 'option')['maps_key']
?>

<div class="container-fluid container--max-lg <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
        <div class="col-12">
            <div class="content__wrap mx-auto text-center">
                <?php if ($title) { ?>
                    <h2><?= $title ?></h2>
                <?php } ?>
                <?php if ($text) { ?>
                    <p><?= $text ?></p>
                <?php } ?>
                <a target="_blank" ref="https://www.google.com/maps/place/<?=urlencode( $location['address'] )?>"><img src="http://maps.googleapis.com/maps/api/staticmap?center=<?=urlencode( $location['lat'] . ',' . $location['lng'] )?>&zoom=10&size=1050x400&scale=2&maptype=roadmap&sensor=false&markers=size:medium%7Ccolor:black%7C<?=$location['lat']?>,<?=$location['lng'] ?>&key=<?=$key?>" /></a>
            </div>
        </div>
    </div>
</div>