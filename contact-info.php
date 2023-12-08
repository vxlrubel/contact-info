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
use Contact\Inc\Api\Api as Contact_Api;
use Contact\Inc\Admin\Menu as Admin_Menu;
/**
 * create ContactInfo class
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 */

final class ContactInfo{

    private static $instance;

    // define plugin version
    public $version = '1.0';

    // table name
    private $table = 'contact_info';

    public function __construct(){

        $access_token = md5(uniqid(rand(), true));

        // define constant
        $this->define_constant();

        // load scripts file for frontend and dashboard
        new Assets;

        // initiate contact api
        new Contact_Api;

        // create table called contact_info
        register_activation_hook( __FILE__, [ $this, 'create_table_contact_info' ] );

        // initiate admin menu
        new Admin_Menu;

        // generate access tocken
        update_option( 'contact_info_access_token', 'contact_info_access_token' );
    }

    /**
     * create database table
     *
     * @return void
     */
    public function create_table_contact_info(){
        
        global $wpdb;

        $table = $this->get_table();

        $charset_collate = $wpdb->get_charset_collate();

        $query = "CREATE TABLE IF NOT EXISTS $table(
            id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(30) NOT NULL DEFAULT 'John Doe',
            email VARCHAR(55) NOT NULL UNIQUE,
            phone BIGINT(12) NOT NULL UNIQUE,
            website VARCHAR(100),
            address VARCHAR(255),
            message TEXT(255) DEFAULT 'Default text message',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta( $query );

    }

    /**
     * get table name
     *
     * @return void
     */
    protected function get_table(){
        
        global $wpdb;
        $table = $wpdb->prefix . $this->table;

        return $table;
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
    
    /**
     * create instance
     *
     * @return void
     */
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