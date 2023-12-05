<?php

namespace Contact\Inc\Api;

defined('ABSPATH') || exit;


/**
 * Create api class to handle the requiest
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */

class Api{
    
    public function __construct(){
        add_action( 'rest_api_init', [ $this, 'register_api' ], 15 );
    }

    /**
     * regoster api
     *
     * @return void
     */
    public function register_api(){
        $contacts = new Contacts;
        $contacts->register_routes();
    }
}