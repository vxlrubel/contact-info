<?php

namespace Contact\Inc;

// directly access denied
defined('ABSPATH') || exit;

class AjaxAction {

    private $delete_action = 'contact_info_delete_single_item';
    
    public function __construct(){
        // initiate delete action
        add_action( 'wp_ajax_'. $this->delete_action, [ $this, $this->delete_action ] );
        add_action( 'wp_ajax_nopriv_'. $this->delete_action, [ $this, $this->delete_action ] );
    }

    public function contact_info_delete_single_item(){

        global $wpdb;
        $table = $wpdb->prefix . 'contact_info';

        if ( ! defined('DOING_AJAX') || ! DOING_AJAX ){
            wp_send_json_error( 'something went wrong.' );
        }

        if ( ! isset( $_POST['action'] ) && $_POST['action'] !== $this->delete_action ){
            wp_send_json_error( 'something went wrong.' );
        }
        
        if ( empty( $_POST['id'] ) ) {
            wp_send_json_error( 'something went wrong.' );
        }
        
        $id = (int)$_POST['id'];

        $wpdb->delete( $table, [ 'id' => $id ], ['%d'] );
        
        wp_send_json_success( 'Data delete successfully' );
    }

}