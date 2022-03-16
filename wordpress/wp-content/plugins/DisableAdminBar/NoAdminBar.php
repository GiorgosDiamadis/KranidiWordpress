<?php
/**
 * Plugin Name: Disable Admin Bar
 *
 * Description: For Development Only.
 * Version: 1.0
 * Author: Diamadis Giorgos
 */

class  NoAdminBar
{
    public function __construct()
    {
        show_admin_bar(false);
    }

}


new noAdminBar();