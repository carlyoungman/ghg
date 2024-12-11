<?php
// Partial | Map Section Contents
global $prefix;
$key = get_field($prefix . 'additional', 'option')['maps_key'];
?>

<div class="container-fluid container--max-lg <?= $type ?>__container">
    <div class="row <?= $type ?>__inner section__inner">
        <div class="col-12">
            <div class="content__wrap mx-auto text-center">
                <?php if ($title) { ?>
                    <h2><?= $title ?></h2>
                <?php } ?>
                <?php if ($text) { ?>
                    <?= $text ?>
                <?php } ?>
                <div class="map__wrap" data-lat="<?= $location['lat'] ?>" data-lng="<?= $location['lng'] ?>">
                    <div class="marker" data-lat="<?= $location['lat'] ?>" data-lng="<?= $location['lng'] ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.gmNoop = function() {
        return;
    }
</script>