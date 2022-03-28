<?php
SetPostViews(get_the_ID());
get_header(); ?>

<section class="blog-post section-header-offset">
    <div class="blog-post-container container">
        <div class="blog-post-data">
            <h3 class="title blog-post-title"><?= get_the_title() ?></h3>
            <div class="article-data" style="margin-top: 1rem">
                <span ><?= get_the_date() ?></span>
            </div>
        </div>

        <div class="container">
            <?php the_content();?>
        </div>
</section>


<?php


get_footer()
?>
