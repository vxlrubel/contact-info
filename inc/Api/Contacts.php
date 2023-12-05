<?php

namespace Contact\Inc\Api;
use WP_REST_Server;

// directly access denied
defined('ABSPATH') || exit;


/**
 * Create api class to handle the requiest
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */

class Contacts{

    public function __construct(){

        // namespace
        $this->namespace = 'ci/v1';

        // restbase
        $this->rest_base = 'contactinfo';

    }

    /**
     * register routes
     *
     * @return void
     */
    public function register_routes(){

        register_rest_route( 
            $this->namespace,        // namespace
            '/' . $this->rest_base,  // route
            [
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_items' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ]
            ]
        );
        
    }

    /**
     * check permission if user role is admin then you can see the options
     *
     * @return void
     */
    public function get_items_permission_check(){
        $permission = current_user_can( 'manage_options' );
        return $permission;
    }

    /**
     * get all the contact list
     *
     * @param [type] $request
     * @return void
     */
    public function get_items( $request ){
        return $request;
    }
    
    
}