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

    public function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="contact[]" value="%s" />',
            $item['name']
        );
    }

    public function prepare_items(){
        $columns = $this->get_columns();       // get the column
        $data    = $this->get_contact_data();  // get contact data

        $this->_column_headers = array($columns, array(), array());
        $this->items = $data;
    }

    private function get_contact_data(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_info'; // Replace with your table name

        $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        return $data;
    }

    public function column_default($item, $column_name) {
        return $item[$column_name];
    }

    // Add bulk actions
    public function get_bulk_actions() {
        $actions = array(
            'delete' => 'Move to trash',
            // Add more bulk actions as needed
        );
        return $actions;
    } 
    
 }