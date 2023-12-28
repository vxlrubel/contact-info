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

        // create route for data insert & get
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
                    'permission_callback' => [ $this, '_check_insert_permission' ],
                ],
            ]
        );

        // register route for single item retrive
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)',
            [
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_single_item' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ]
            ]
        );

        // create route for data update & delete
        register_rest_route( 
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>\d+)',
            [
                [
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_item' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ],
                [
                    'methods'             => WP_REST_Server::DELETABLE,
                    'callback'            => [ $this, 'delete_item' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                ],
            ]
        );
        
    }

    /**
     * get single item
     *
     * @param [type] $request
     * @return void
     */
    public function get_single_item( $request ){
        global $wpdb;
        $table = $this->get_table();

        $params = $request->get_params();
        $id     = (int)$params['id'];

        $get_query = "SELECT * FROM $table WHERE id = $id";
        
        $result = $wpdb->get_results( $get_query );

        $result_count  = count( $result );

        if( $result_count === 0 ){
            return 'No result found';
        }

        return $result;

    }

    /**
     * insert item into database
     *
     * @param [type] $request
     * @return string
     */
    public function insert_item( $request ){
        global $wpdb;

        $table = $this->get_table();

        $params = $request->get_params();

        $data = $this->table_data( $params['name'], $params['email'], $params['phone'], $params['website'], $params['address'], $params['message'] );
        
        $insert_result = $wpdb->insert( $table, $data );

        if( $insert_result === false ){
            return new WP_Error( 'failed_insert', 'Failed to insert data', [ 'status' => 500 ] );
        }

        return 'Data inserted successfully';

    }
    
    /**
     * get all the contact list
     *
     * @param [type (array)] $request
     * @return $request
     */
    public function get_items( $request ){

        global $wpdb;

        $table = $this->get_table();
        
        $sql = "SELECT * FROM $table ORDER BY id DESC";

        $results = $wpdb->get_results( $sql );

        $request = $results;
        
        return $request;
        
    }

    /**
     * data update
     *
     * @param [type] $request
     * @return string
     */
    public function update_item( $request ){
        global $wpdb;
        $table  = $this->get_table();
        $params = $request->get_params();
        $id     = (int)$request['id'];

        $data = $this->table_data( $params['name'], $params['email'], $params['phone'], $params['website'], $params['address'], $params['message'] );

        $data_format = [ '%s', '%s', '%s', '%s', '%s', '%s' ];

        $where_id = [ 'id' => $id ];

        $where_clause_format = ['%d'];

        $update_result = $wpdb->update( $table, $data, $where_id, $data_format, $where_clause_format );

        if ( $update_result === false ){
            return new WP_Error('failed_update', 'Failed to update data', array('status' => 500));
        }

        return 'data update successfully';

    }

    /**
     * delete item
     *
     * @param [type] $request
     * @return string
     */
    public function delete_item( $request ){
        global $wpdb;
        $table  = $this->get_table();
        $id     = (int)$request['id'];

        $where_clause        = [ 'id' => $id ];
        $where_clause_format = ['%d'];
        
        $delete_result = $wpdb->delete( $table, $where_clause, $where_clause_format );

        if ( $delete_result === false ){
            return new WP_Error('failed_delete', 'Failed to delete data', array('status' => 500));
        }

        return 'delete data successfully';
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
     * check insert permission
     *
     * @return void
     */
    public function _check_insert_permission(){
        return true;
    }

    /**
     * get database table name
     *
     * @return void
     */
    private function get_table(){
        global $wpdb;
        $table = $wpdb->prefix . 'contact_info';
        return $table;
    }


    /**
     * diclare table data
     *
     * @param string $name
     * @param [type] $email
     * @param [type] $phone
     * @param string $website_url
     * @param string $address
     * @param string $message
     * 
     * @return array $data
     */
    protected function table_data( $name = '', $email, $phone, $website_url = '', $address = '', $message = '' ){
      
        $data = [
            'name'    => sanitize_text_field( $name ),
            'email'   => sanitize_email( $email ),
            'phone'   => sanitize_text_field( $phone ),
            'website' => esc_url( $website_url ),
            'address' => sanitize_text_field( $address ),
            'message' => sanitize_text_field( $message ),
        ];

        return $data;
    }
    
}