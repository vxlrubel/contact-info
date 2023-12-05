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

        // define frontend style source
        define( 'CI_FRONTEND_STYLE', plugins_url( 'lib/css/style.css', __FILE__) );
        
        // define frontend custom script
        define( 'CI_FRONTEND_SCRIPT', plugins_url( 'lib/js/custom.js', __FILE__) );

        // define admin style source
        define( 'CI_ADMIN_STYLE', plugins_url( 'lib/admin/css/style.css', __FILE__) );
        
        // define admin custom script
        define( 'CI_ADMIN_SCRIPT', plugins_url( 'lib/admin/js/custom.js', __FILE__) );
        
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