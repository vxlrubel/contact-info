<?php
/*
Plugin Name: Contact Info
Description: An intuitive plugin for managing email subscriptions on WordPress.
Version: 1.0
Author: Rubel Mahmud ( Sujan )
*/

defined('ABSPATH') || exit;

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

use Contact\Inc\Assets;

final class ContactInfo{

    private static $instance;

    // define plugin version
    public $version = '1.0';

    public function __construct(){
        // define constant
        $this->define_constant();

        // load scripts file for frontend and dashboard
        new Assets;
    }

    /**
     * define constant
     *
     * @return void
     */
    public function define_constant(){

        // define plugin version
        define( 'CI_VERSION', $this->version );

        define( 'CI_LIB', plugins_url( 'lib/', __FILE__ ) );

        define( 'CI_ADMIN_LIB', plugins_url( 'lib/admin/', __FILE__ ) );
        
    }
    
    public static function get_instance() {
        
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