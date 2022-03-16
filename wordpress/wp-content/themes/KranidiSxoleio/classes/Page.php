<?php

class Page
{
    public function __construct()
    {
        add_filter('rwmb_meta_boxes', array($this, "AddFields"));

    }

    function AddFields($meta_boxes)
    {
        $prefix = 'kranidi';

        $meta_boxes[] = [
            'title' => esc_html__('Πεδία', 'online-generator'),
            'id' => 'kranidi',
            'pages' => 'page',
            'context' => 'normal',
            'fields' => [
                [
                    'type' => 'file_advanced',
                    'name' => esc_html__('Εικονες Αρχικης', 'online-generator'),
                    'id' => $prefix . 'frontpage_carousel',
                    'desc' => esc_html__('Μονο για την αρχικη σελιδα', 'online-generator'),
                    'multiple' => true,
                ],
            ],
        ];


        return $meta_boxes;
    }
}

new Page();