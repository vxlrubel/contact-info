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
            'dashicons-email',              // icon
            25                              // position
        );
    }

    public function _cb_contact_info(){
        echo '<div class="wrap"><h1>Contact Info</h1>';

        $contact_info_list_table = new ContactInfoListTable;
        $contact_info_list_table->prepare_items();
        $contact_info_list_table->display();
        
        echo '</div>';
    }
}