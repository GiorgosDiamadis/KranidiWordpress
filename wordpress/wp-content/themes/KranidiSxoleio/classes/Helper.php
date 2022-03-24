<?php
require_once __DIR__ . "/Post.php";

class Helper
{
    private static $helper;

    public static function GetConnect(): Helper
    {
        if (!isset(self::$helper)) {
            self::$helper = new Helper();
        }

        return self::$helper;
    }


    public static function Fetch($maxDate)
    {
        $params = array(
            'post_type' => 'post',
            'orderby' => array
            (
                'date' => 'DESC',
                'menu_order' => 'ASC',
            ),
            'posts_per_page' => 6,
            'data_query' => array(
                array(
                    'before' => $maxDate,
                    'inclusive' => true,
                )
            ),
            'category__not_in' => 5

        );
        $posts = [];
        $query = new WP_Query($params);

        foreach ($query->posts as $post) {
            $posts[] = new Post($post->ID);
        }

        return $posts;
    }

    public static function GetPopular(): array
    {
        $params = array(
            'post_type' => 'post',
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'posts_per_page' => 8,
            'category__not_in' => 5

        );
        $posts = [];
        $query = new WP_Query($params);

        foreach ($query->posts as $post) {
            $posts[] = new Post($post->ID);
        }

        return $posts;
    }
}