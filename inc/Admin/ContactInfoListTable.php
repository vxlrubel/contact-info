<?php

namespace Contact\Inc\Admin;
use WP_List_Table;

// directly access denied
defined('ABSPATH') || exit;

/**
 * Create Menu class to manage dashboard menu
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */

// requite WP_List_Table class if not exists
if ( ! class_exists('WP_List_Table') ){
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
 class ContactInfoListTable extends WP_List_Table {

    public function __construct(){
        parent::__construct(
            [
                'singular' => 'contact',  // Singular name of the item
                'plural'   => 'contacts', // Plural name of the items
                'ajax'     => false,      // If using AJAX, set to true
            ]
        );
    }

    /**
     * get columns
     *
     * @return void
     */
    public function get_columns(){
        $columns = [
            'cb'      => '<input type="checkbox" />',
            'id'      => 'ID',
            'name'    => 'Name',
            'email'   => 'Email',
            'phone'   => 'Phone',
            'website' => 'Website',
            'address' => 'Address',
            'message' => 'Message',
        ];

        return $columns;
    }

    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="contact[]" value="%s" />',
            $item['name']
        );
    }

    /**
     * prepare items
     *
     * @return void
     */
    public function prepare_items(){

        $order_by = isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'name';
        $order = isset( $_GET['order'] ) ? $_GET['order'] : 'desc';
        
        $columns = $this->get_columns();       // get the column
        $data    = $this->get_contact_data( $order_by, $order );  // get contact data

        $hidden_columns = $this->get_hidden_columns();
        $sortable_columns = $this->get_sortable_columns();

        // $this->_column_headers = array($columns, array(), array());
        $this->_column_headers = [ $columns, $hidden_columns, $sortable_columns ];
        $this->items = $data;
    }


    /**
     * hide table columns
     *
     * @return void
     */
    public function get_hidden_columns(){
        return [ 'id', 'address', 'message' ];
    }

    /**
     * get sortable value in list table
     *
     * @return void
     */
    public function get_sortable_columns(){

        $sortable_columns = [
            'name'    => [ 'name', false ],
            'email'   => [ 'email', false ],
            'phone'   => [ 'phone', false ],
            'website' => [ 'website', false ],
            'address' => [ 'address', false ],
            'message' => [ 'message', false ],
        ];

        return $sortable_columns;

    }

    /**
     * get the list data
     *
     * @return void
     */
    private function get_contact_data( $order_by = 'name', $order = 'DESC' ){
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_info'; // Replace with your table name

        $data = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY $order_by $order", ARRAY_A );

        if ( $data > 0 ){
            return $data;
        }

        return 'no data available';
    }

    /**
     * default columns
     *
     * @param [type] $item
     * @param [type] $column_name
     * @return void
     */
    public function column_default( $item, $column_name ) {
        
        switch ( $column_name ) {
            case 'id':
            case 'name':
            case 'email':
            case 'phone':
            case 'website':
            case 'address':
            case 'message':
            case 'created_at':
            case 'updated_at':

                return $item[ $column_name ];

            default:

                return 'No value';
        }
        
    }

    /**
     * add bulk action
     *
     * @return void
     */
    public function get_bulk_actions() {
        $actions = array(
            'delete' => 'Move to trash',
            // Add more bulk actions as needed
        );
        return $actions;
    } 
    
 }