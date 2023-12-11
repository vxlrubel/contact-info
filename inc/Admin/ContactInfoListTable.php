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
            $item['id']
        );
    }

    /**
     * prepare items
     *
     * @return void
     */
    public function prepare_items(){

        $order_by    = isset( $_GET['orderby'] ) ? trim( $_GET['orderby'] ) : 'name';
        $order       = isset( $_GET['order'] ) ? trim( $_GET['order'] ) : 'desc';
        $search_term = isset( $_POST['s'] ) ? trim( $_POST['s'] ) : '';
        
        // get columns
        $columns = $this->get_columns();
        // get data
        $data    = $this->get_contact_data( $order_by, $order, $search_term );

        $item_per_page = 3;
        $current_page  = $this->get_pagenum();
        $total_items   = count( $data );

        $this->set_pagination_args(
            [
				'total_items' => $total_items,
				'per_page'    => $item_per_page,
            ]
        );

        $slice_data = array_slice( $data, ( ( $current_page - 1 ) * $item_per_page ), $item_per_page );
        
        $hidden_columns = $this->get_hidden_columns();
        $sortable_columns = $this->get_sortable_columns();

        // $this->_column_headers = array($columns, array(), array());
        $this->_column_headers = [ $columns, $hidden_columns, $sortable_columns ];
        $this->items = $slice_data;
    }


    /**
     * hide table columns
     *
     * @return void
     */
    public function get_hidden_columns(){
        return [ 'id', 'website', 'message' ];
    }

    /**
     * get sortable value in list table
     *
     * @return void
     */
    public function get_sortable_columns(){

        $sortable_columns = [
            'name'    => [ 'name', false ],
            'email'   => [ 'email', true ],
            'phone'   => [ 'phone', true ],
            'website' => [ 'website', true ],
            'address' => [ 'address', true ],
            'message' => [ 'message', true ],
        ];

        return $sortable_columns;

    }

    /**
     * get the list data
     *
     * @return void
     */
    private function get_contact_data( $order_by = 'name', $order = 'DESC', $search_term = '' ){
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_info'; // Replace with your table name

        if( ! empty( $search_term ) ){
            $search_query  = "SELECT * FROM $table_name WHERE name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR phone LIKE '%$search_term%' OR address LIKE '%$search_term%'";
            $search_result = $wpdb->get_results( $search_query, ARRAY_A );
            return $search_result;
        }else{
            $data = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY $order_by $order", ARRAY_A );

            if ( $data > 0 ){
                return $data;
            }
    
            return 'no data available';
        }
        
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

    public function column_name( $item ){
        $action = [
            'edit'   => sprintf( '<a href="?page=%s&action=%s&contact_info_id=%s" class="contact_info_edit">Edit</a>', $_GET['page'], 'contact-info-edit', $item['id'] ),
            'delete' => sprintf( '<a href="?page=%s&action=%s&contact_info_id=%s" class="contact_info_delete">Delete</a>', $_GET['page'], 'contact-info-delete', $item['id'] ),
        ];

        $placeholder = sprintf(
            '%1$s %2$s',
            $item['name'],
            $this->row_actions( $action )
        );

        return $placeholder;
    }

    /**
     * add bulk action
     *
     * @return void
     */
    public function get_bulk_actions() {
        $actions = [
            'edit'   => 'Edit',
            'delete' => 'Delete',
        ];
        return $actions;
    } 
    
 }