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
        // create admin menu
        add_action( 'admin_menu', [ $this, 'admin_menu_contact_info' ], 15 );
    }

    /**
     * create admin menu
     *
     * @return void
     */
    public function admin_menu_contact_info(){
        // main menu
        add_menu_page( 
            'Contact Info',                 // page title
            'Contact Info',                 // menu title
            'manage_options',               // capability
            $this->slug_parent,             // menu slug
            [ $this, '_cb_contact_info' ],  // callback
            'dashicons-phone',              // icon
            25                              // position
        );

        // submenu
        add_submenu_page(
            $this->slug_parent,           // parent slug
            'contact-list',               // page title
            'Contact List',               // menu title
            'manage_options',             // capability
            $this->slug_parent,           // menu slug
            [ $this, '_cb_contact_info' ] // callback
        );

        // submenu
        add_submenu_page(
            $this->slug_parent,           // parent slug
            'add-new-contact',            // page title
            'Add New',                    // menu title
            'manage_options',             // capability
            $this->slug_add_new,          // menu slug
            [ $this, 'add_new_contact' ]  // callback
        );
    }

    /**
     * add new contact form which is allow to create a new contact
     *
     * @return void
     */
    public function add_new_contact(){
        $form = new ContactForm;
        
        echo '<div class="wrap">';
        printf( '<h2>%s</h2>', 'Add New Contact' );
        
        $form->add_new_form();
        
        echo '</div>';
    }

    /**
     * show the contact list
     *
     * @return void
     */
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