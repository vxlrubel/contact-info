<?php

namespace Contact\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

/**
 * Create Menu class to manage dashboard menu
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */

 class ContactSettings{

    public function __construct(){
        // register settings
        add_action( 'admin_init', [ $this, 'register_settings_fields' ] );
    }

    /**
     * register settings fields
     *
     * @return void
     */
    public function register_settings_fields(){

        add_settings_section( 
            'contact_info_group', // id
            'Contact Info Settings',  // title
            null,  // callback
            'contact-info_page'  // page
        );

        // email field
        add_settings_field(
            'contact_info_field_email_enable',   // id
            '',                                  // Title
            [ $this, '_cb_email_visible' ],      // callback
            'contact-info_page',                 // page
            'contact_info_group'                 // section
        );

        // email field
        add_settings_field(
            'contact_info_field_email',   // id
            '',                           // Title
            [ $this, '_cb_email_field' ], // callback
            'contact-info_page',          // page
            'contact_info_group'          // section
        );


        register_setting( 'contact_info_group', 'contact_info_field_email_enable' );

        register_setting( 'contact_info_group', 'contact_info_field_email' );

    }

    
    public function _cb_email_visible(){
        $get_result = get_option( 'contact_info_field_email_enable' );
        
        ?>
            <div class="items">
                <label for="visibility">Enable/Disable</label>
                <select name="contact_info_field_email_enable" class="regular-text">
                    <option value="">---select options---</option>
                    <option value="1" <?php selected( $get_result, '1', true );?>>Enable</option>
                    <option value="0" <?php selected( $get_result, '0', true );?>>Disable</option>
                </select>
            </div>
        <?php
        
    }
    
    public function _cb_email_field(){

        $get_email = get_option('contact_info_field_email');
        ?>
        <div class="items">
            <label for="email">Email Address</label>
            <input type="email" id="email" class="regular-text" name="contact_info_field_email" value="<?php echo $get_email; ?>">
        </div>
        <?php
    }

 }