<?php

namespace Contact\Inc\Api;
use WP_REST_Server;
use WP_REST_Controller;
// directly access denied
defined('ABSPATH') || exit;


/**
 * Create api class to handle the requiest
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */

class Contacts extends WP_REST_Controller{

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
                ],
                [
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'insert_item' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ],
            ]
        );

        register_rest_route( 
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)',
            [
                [
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_item' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ]
            ]
        );
        
    }

    /**
     * data update
     *
     * @param [type] $request
     * @return void
     */
    public function update_item( $request ){
        global $wpdb;
        $table  = $wpdb->prefix . 'contact_info';
        $params = $request->get_params();
        $id     = (int)$request['id'];

        $name  = sanitize_text_field( $params['name'] );
        $email = sanitize_email( $params['email'] );
        $phone = sanitize_text_field( $params['phone'] );
        

        $data = [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ];

        $data_format = [ '%s', '%s', '%s' ];

        $where_id = [ 'id' => $id ];

        $where_clause_format = ['%d'];

        $update_result = $wpdb->update( $table, $data, $where_id, $data_format, $where_clause_format );

        if ( $update_result === false ){
            return new WP_Error('failed_update', 'Failed to update data', array('status' => 500));
        }

        return 'data update successfully';

        
    }

    public function insert_item( $request ){
        global $wpdb;

        $table = $wpdb->prefix . 'contact_info';

        $params = $request->get_params();

        $name  = sanitize_text_field( $params['name'] );
        $email = sanitize_email( $params['email'] );
        $phone = sanitize_text_field( $params['phone'] );
        
        $data = [
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
        ];
        
        $insert_result = $wpdb->insert( $table, $data );

        if( $insert_result === false ){
            return new WP_Error( 'failed_insert', 'Failed to insert data', [ 'status' => 500 ] );
        }

        return 'Data inserted successfully';

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
     * @param [type (array)] $request
     * @return $request
     */
    public function get_items( $request ){

        global $wpdb;

        $table = $wpdb->prefix . 'contact_info';
        
        $sql = "SELECT * FROM $table ORDER BY id DESC";

        $results = $wpdb->get_results( $sql );

        $request = $results;
        
        return $request;
        
    }
    
    
}