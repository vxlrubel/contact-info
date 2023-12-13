<?php

namespace Contact\Inc;

// directly access denied
defined('ABSPATH') || exit;

class AjaxAction {

    private $delete_action = 'contact_info_delete_single_item';

    private $add_new_action = 'add_new_contact';
    
    public function __construct(){
        // initiate delete action
        add_action( 'wp_ajax_'. $this->delete_action, [ $this, $this->delete_action ] );
        add_action( 'wp_ajax_nopriv_'. $this->delete_action, [ $this, $this->delete_action ] );

        // add new contact
        add_action( 'wp_ajax_'. $this->add_new_action, [ $this, $this->add_new_action ] );
        add_action( 'wp_ajax_nopriv_'. $this->add_new_action, [ $this, $this->add_new_action ] );

    }

    public function add_new_contact(){

        global $wpdb;
        $table = $wpdb->prefix . 'contact_info';

        if ( ! defined('DOING_AJAX') || ! DOING_AJAX ){
            wp_send_json_error( 'something went wrong.' );
        }

        if ( ! isset( $_POST['action'] ) && $_POST['action'] !== $this->add_new_action ){
            wp_send_json_error( 'something went wrong.' );
        }

        if( ! isset( $_POST['_wpnonce'] ) ){
            wp_send_json_error( 'You have no permission.' );
        }

        $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : 'John Doe';
        $email   = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
        $phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
        $website = isset( $_POST['website'] ) ? esc_url( $_POST['website'] ) : '';
        $address = isset( $_POST['address'] ) ? sanitize_text_field( $_POST['address'] ) : '';
        $message = isset( $_POST['message'] ) ? sanitize_text_field( $_POST['message'] ) : '';

        $data = [
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'website' => $website,
            'address' => $address,
            'message' => $message,
        ];
        
        $insert = $wpdb->insert( $table, $data );

        if ( $insert === false ){
            wp_send_json_error( 'something went wrong.' );
        }

        wp_send_json_success( 'Insert successfully.' );
        
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