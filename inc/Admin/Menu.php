<?php

namespace Contact\Inc\Admin;

defined('ABSPATH') || exit;


/**
 * Create Menu class to manage dashboard menu
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */


class Menu{

    // main slug
    protected $slug_parent = 'contact-info';

    // add new slug
    protected $slug_add_new = 'add-contact-info';
    
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu_contact_info' ], 15 );
    }

    public function admin_menu_contact_info(){
        add_menu_page( 
            'Contact Info',                 // page title
            'Contact Info',                 // menu title
            'manage_options',               // capability
            $this->slug_parent,             // menu slug
            [ $this, '_cb_contact_info' ],  // callback
            'dashicons-phone',              // icon
            25                              // position
        );

        add_submenu_page(
            $this->slug_parent,           // parent slug
            'add-new-contact',            // page title
            'Add New',                    // menu title
            'manage_options',             // capability
            $this->slug_add_new,          // menu slug
            [ $this, 'add_new_contact' ]  // callback
        );
    }

    public function _cb_contact_info(){

        $action = isset( $_GET['action'] ) ? trim( $_GET['action'] ) : '';

        echo '<div class="wrap contact-info-parent">';

        if( $action == 'contact-info-edit' ){
            $edit_id = isset( $_GET['contact_info_id'] ) ? (int)$_GET['contact_info_id'] : '';

            echo '<h1>Edit Contact Information</h1>';
            $contact_info_form = new ContactForm;
            $contact_info_form->edit_form( $edit_id );
            
        }else{
            echo '<h1>Contact Info</h1>';
            $contact_info_list_table = new ContactInfoListTable;
            $contact_info_list_table->prepare_items();
    
            echo "<form method=\"POST\" name=\"contact_info_search_form\" action=\"{$_SERVER['PHP_SELF']}?page=contact-info\">";
            $contact_info_list_table->search_box( 'Search', 'search_contact_info' );
            echo '</form>';
    
            $contact_info_list_table->display();
        }

        echo '</div>';

    }
}