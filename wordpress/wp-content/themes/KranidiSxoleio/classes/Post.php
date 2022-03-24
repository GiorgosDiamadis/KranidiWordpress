<?php

class Post
{
    public WP_Post $post;

    public function __construct($id)
    {
        $this->post = get_post($id);
    }

    public function Feed()
    {
        $date = get_the_date('', $this->post->ID);
        $title = $this->post->post_title;
        $link = get_permalink($this->post->ID);
        $imgId = wp_get_attachment_url(get_post_thumbnail_id($this->post->ID));
        echo '' ?>
        <a href="<?=$link?>" class="article d-grid">
            <div class="older-posts-article-image-wrapper">
                <img src="<?= $imgId ?>" alt="" class="article-image">
            </div>

            <div class="article-data-container">

                <div class="article-data">
                    <span><?= $date ?></span>
                </div>

                <h3 class="title article-title"><?= $title ?></h3>
                <p class="article-description">
                    <?= get_the_excerpt($this->post->ID) ?>
                </p>

            </div>
        </a>

        <?php
    }

    public function Trending()
    {
        $date = get_the_date('', $this->post->ID);
        $title = $this->post->post_title;

        $imgId = wp_get_attachment_url(get_post_thumbnail_id($this->post->ID));
        $link = get_permalink($this->post->ID);

        echo '' ?>
        <a href="<?=$link?>" class="trending-news-box">
            <div class="trending-news-img-box">
                <img src="<?= $imgId ?>" alt="" class="article-image">
            </div>

            <div class="trending-news-data">

                <div class="article-data">
                    <span><?= $date ?></span>
                </div>

                <h3 class="title article-title"><?= $title ?></h3>

            </div>
        </a>
        <?php
    }

    public function Featured($iteration_count)
    {
        $categoryId = $this->post->post_category;
        $categoryName = get_category($categoryId)->name;
        $date = get_the_date('', $this->post->ID);
        $title = $this->post->post_title;
        $link = get_permalink($this->post->ID);

        $imgId = wp_get_attachment_url(get_post_thumbnail_id($this->post->ID));
        echo '' ?>
        <a href='<?=$link?>' class='article featured-article featured-article-<?= $iteration_count ?>'>
            <img src='<?= $imgId ?>' alt='' class='article-image'>
            <span class='article-category'><?= $categoryName ?></span>

            <div class='article-data-container'>

                <div class='article-data'>
                    <span> <?= $date ?></span>
                </div>

                <h3 class='title article-title'> <?= $title ?></h3>

            </div>
        </a>
        <?php
    }
}