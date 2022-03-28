<?php
function dg_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}

function menus()
{
    $locations = array(
        'header' => 'Header Menu',
        'footer' => 'Footer Menu',
    );

    register_nav_menus($locations);
}

function dg_registerStyles()
{

    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('swiper_css', "https://unpkg.com/swiper@8/swiper-bundle.min.css", array(), $version, 'all');
    wp_enqueue_style('_css', get_template_directory_uri() . "/style.css", array(), $version, 'all');
    wp_enqueue_style('_fonts', "https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css", array(), "1.0", 'all');
    wp_enqueue_style(
        'font-awesome-6',
        get_template_directory_uri() . "/fontawesome6/css/all.css",
        array(),
        '5.3.0', 'all'
    );
}

function dg_registerScripts()
{
    wp_enqueue_script('dg-js', get_template_directory_uri() . "/main.js", array(), "", 'all', true);
    wp_enqueue_script("_jq", "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js", "", 'all', true);
    wp_enqueue_script("swiper_js", "https://unpkg.com/swiper@8/swiper-bundle.min.js", "", 'all', true);

}

add_action('after_setup_theme', 'dg_theme_support', 30);
add_action('wp_enqueue_scripts', 'dg_registerStyles', 30);
add_action('wp_enqueue_scripts', "dg_registerScripts", 30);
add_action('init', 'menus');
function title_filter($where, $wp_query)
{
    global $wpdb;
    if ($search_term = $wp_query->get('search_prod_title')) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql(like_escape($search_term)) . '%\'';
    }
    return $where;
}

add_filter('posts_where', 'title_filter', 10, 2);


function SetPostViews($postID)
{
    $countKey = 'post_views_count';
    $count = get_post_meta($postID, $countKey, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $countKey);
        add_post_meta($postID, $countKey, '1');
    } else {
        $count++;
        update_post_meta($postID, $countKey, $count);
    }

}


//$posts = new WP_Query(array('posts_per_page' => 1000,'post_type'=>'post'));
//foreach ($posts->posts as $post){
//    if (rand(0,10) < 5){
//        wp_set_post_categories($post->ID,3);
//
//    }else if (rand(0,10) > 5){
//        wp_set_post_categories($post->ID,4);
//
//    }else{
//        wp_set_post_categories($post->ID,5);
//
//    }
//}
require_once __DIR__ . "/classes/Page.php";
