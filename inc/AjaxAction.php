<?php

namespace Contact\Inc;

// directly access denied
defined('ABSPATH') || exit;

class AjaxAction {

    public $delete_action = 'contact_info_delete_single_item';
    
    public function __constaruct(){
        
        add_action( 'wp_ajax_'. $this->delete_action, [ $this, 'contact_info_delete_single_item' ] );
        add_action( 'wp_ajax_nopriv_'. $this->delete_action, [ $this, 'contact_info_delete_single_item' ] );
    }

    public function contact_info_delete_single_item(){
        wp_send_json_success( 'success' );
    }

}
new AjaxAction;