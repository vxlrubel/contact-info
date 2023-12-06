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
            'cb' => '<input type="checkbox" />',
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


    // Handle bulk action submission
    public function process_bulk_action() {
        if ('delete' === $this->current_action()) {
            $contact_ids = isset($_REQUEST['contact']) ? $_REQUEST['contact'] : array();

            if (!empty($contact_ids)) {
                foreach ($contact_ids as $contact_id) {
                    $this->delete_contact($contact_id);
                }
            }
        }
    }

    private function delete_contact($contact_id) {
        // Your logic to delete a contact

        print_r( $contact_id );
        
    }

    public function column_name($item) {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&contact=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&contact=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
            // Add more row actions as needed
        );

        return sprintf('%1$s <span style="display:none;">%2$s</span>%3$s',
            $item['name'],
            $this->row_actions($actions),
            $this->handle_row_actions($item, 'name', $actions)
        );
    }
    



    
    
 }