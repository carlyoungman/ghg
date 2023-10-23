<?php
/*==================================
|	Single Template
==================================*/
?>

<?php get_header(); ?>

<section class="content">
    <div class="container-fluid container--max">
        <div class="row">
            <div class="col-10 col-xl-9">
                <?php if(have_posts()) {
                    while(have_posts()) {
                        the_post();
                        the_content();
                    }
                }?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
