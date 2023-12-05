<?php
/*
Plugin Name: Contact Info
Description: An intuitive plugin for managing email subscriptions on WordPress.
Version: 1.0
Author: Rubel Mahmud ( Sujan )
*/

defined('ABSPATH') || exit;

final class ContactInfo{

    private static $instance;



    public function get_instance() {
        
        if( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
        
    }
    
}

if( ! function_exists( 'contact_info' )){
    function contact_info(){
        return ContactInfo::get_instance();
    }

    contact_info();
}