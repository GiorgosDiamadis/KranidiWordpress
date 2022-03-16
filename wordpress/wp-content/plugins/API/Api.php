<?php
/*
 * Plugin Name: Api
 * Description: Essential Functionality for the Website
 * Version: 1.0
 * Author: Diamadis Giorgos
 */

class Api
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, "registerRestAPI"));

    }

    function registerRestAPI()
    {
        register_rest_route('kranidi/v1', '/sendMessage', [
            'methods' => WP_REST_Server::EDITABLE,
            'callback' => array($this, "api_sendMessage"),
        ]);
        register_rest_route('kranidi/v1', '/getMore', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, "api_getMore"),
        ]);
        register_rest_route('kranidi/v1', '/search', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, "api_search"),
        ]);

    }

    function api_search(WP_REST_Request $request): WP_REST_Response
    {
        $params = $request->get_params();
        $like = $params["like"];
        $cat = $params["cat"];

        $params = array(
            'post_type' => 'post',
            'category_name' => $cat,
            'search_prod_title' => $like,
            'orderby' => array(
                'date' => 'DESC',
                'menu_order' => 'ASC',
            )

        );
        $query = new WP_Query($params);
        $results = $query->posts;
        $output = "";

        foreach ($results as $result) {
            $title = $result->post_title;
            $id = $result->ID;
            $excerpt = get_the_excerpt($id);
            $date = get_the_date('', $id);
            $url = wp_get_attachment_image_url(get_post_thumbnail_id($id), "medium");
            $link = get_permalink($id);
            $output .= "<div class='post'>
                        <img class='post-thumbnail' src='$url' alt=''>
                       
                            <h1 class='title' style='margin-bottom: 0'>$title</h1>
                             <p class='date'>
                                <span><i class='fa-solid fa-calendar-day'></i>$date</span>
                            </p>
                            <h2 class='subtitle'>$excerpt</h2>
                            
                            <a href='$link'>
                                <button class='button is-primary'>
                                    <span>Περισσότερα</span>
                                    <span class='icon'>
                                            <i class='fa-solid fa-right-long'></i>
                                        </span>
                                </button>
                            </a>
                    </div>";
        }

        $response = new WP_REST_Response($output, 200);
        $response->set_headers(['Cache-Control' => 'must-revalidate, no-cache, no-store, private']);
        return $response;
    }

    function api_getMore(WP_REST_Request $request): WP_REST_Response
    {
        $params = $request->get_params();
        $lower = $params["lower"];
        $upper = $params["upper"];
        $cat = $params["cat"];

        $params = array(
            'post_type' => 'post',
            'category_name' => $cat,
            'orderby' => array(
                'date' => 'DESC',
                'menu_order' => 'ASC',
            ), 'posts_per_page' => $upper,

        );
        $query = new WP_Query($params);
        $results = array();

        for ($i = $lower; $i < $query->post_count; $i++) {
            array_push($results, $query->posts[$i]);
        }

        $output = "";

        foreach ($results as $result) {
            $title = $result->post_title;
            $id = $result->ID;
            $excerpt = get_the_excerpt($id);
            $date = get_the_date('', $id);
            $url = wp_get_attachment_image_url(get_post_thumbnail_id($id), "medium");
            $link = get_permalink($id);
            $output .= "<div class='post'>
                        <img class='post-thumbnail' src='$url' alt=''>
                       
                            <h1 class='title' style='margin-bottom: 0'>$title</h1>
                             <p class='date'>
                                <span><i class='fa-solid fa-calendar-day'></i>$date</span>
                            </p>
                            <h2 class='subtitle'>$excerpt</h2>
                            
                            <a href='$link'>
                                <button class='button is-primary'>
                                    <span>Περισσότερα</span>
                                    <span class='icon'>
                                            <i class='fa-solid fa-right-long'></i>
                                        </span>
                                </button>
                            </a>
                    </div>";
        }

        $response = new WP_REST_Response($output, 200);
        $response->set_headers(['Cache-Control' => 'must-revalidate, no-cache, no-store, private']);
        return $response;

    }

    function api_sendMessage(WP_REST_Request $request): WP_REST_Response
    {
        $param = $request->get_body_params();

        $res = $this->sendmailbymailgun("bestmegareelsites@gmail.com", $param["data"]["mail"], $param["data"]["body"]);

        $response = new WP_REST_Response($res, 200);
        $response->set_headers(['Cache-Control' => 'must-revalidate, no-cache, no-store, private']);
        return $response;
    }

    function sendmailbymailgun($to, $from, $text)
    {
        $array_data = array(
            'from' => $from,
            'to' => $to,
            'subject' => "Conact Support",
            'html' => "",
            'text' => $text,
            'o:tracking' => 'yes',
            'o:tracking-clicks' => 'yes',
            'o:tracking-opens' => 'yes',
            'o:tag' => "",
            'h:Reply-To' => ""
        );

        try {
            $session = curl_init(MAILGUN_URI . MAILGUN_DOMAIN . '/messages');
            curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($session, CURLOPT_USERPWD, 'api:' . MAILGUN_KEY);
            curl_setopt($session, CURLOPT_POST, true);
            curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($session);
            curl_close($session);
            return json_decode($response, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

}

new Api();