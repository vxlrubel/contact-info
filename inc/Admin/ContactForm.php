<?php

namespace Contact\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

class ContactForm{
    public function edit_form( $edit_id ){

        global $wpdb;

        $table = $wpdb->prefix . 'contact_info';
        
        $sql = "SELECT * FROM $table WHERE id = $edit_id";
        
        $get_result = $wpdb->get_results( $sql, ARRAY_A );

        foreach ( $get_result as $result  ):  ?>

            <form action="javascript:void(0)" class="contact-info-form">

                <div class="item-row">
                    <label for="name">Name:</label>
                    <input type="text" value="<?php echo $result['name']; ?>" id="name" name="name">
                </div>

                <div class="item-row">
                    <label for="email">Email:</label>
                    <input type="email" value="<?php echo $result['email']; ?>" id="email" name="email">
                </div>

                <div class="item-row">
                    <label for="phone">Phone:</label>
                    <input type="number" value="<?php echo $result['phone']; ?>" id="phone" min="1" name="phone">
                </div>

                <div class="item-row">
                    <label for="website">Website:</label>
                    <input type="url" value="<?php echo $result['website']; ?>" id="website" name="website">
                </div>

                <div class="item-row">
                    <label for="address">Address:</label>
                    <textarea id="address"rows="2" name="address"><?php echo $result['address']; ?></textarea>
                </div>

                <div class="item-row">
                    <label for="message">Message:</label>
                    <textarea id="message"rows="5" name="message"><?php echo $result['message']; ?></textarea>
                </div>

                <div class="item-row">
                    <input type="submit" value="Save Changes" class="button button-primary" id="update-contact-item" data-edit="<?php echo $result['id'];?>">
                </div>

            </form>

        <?php endforeach;
    }

    public function add_new_form(){
        ?>

            <form action="javascript:void(0)" class="contact-info-form" id="add_new-contact">

                <div class="item-row">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                </div>

                <div class="item-row">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="item-row">
                    <label for="phone">Phone:</label>
                    <input type="number" id="phone" min="1" name="phone">
                </div>

                <div class="item-row">
                    <label for="website">Website:</label>
                    <input type="url" id="website" name="website">
                </div>

                <div class="item-row">
                    <label for="address">Address:</label>
                    <textarea id="address"rows="2" name="address"></textarea>
                </div>

                <div class="item-row">
                    <label for="message">Message:</label>
                    <textarea id="message"rows="5" name="message"></textarea>
                </div>

                <div class="item-row">
                    <input type="hidden" name="action" value="add_new_contact">
                    <?php wp_nonce_field( 'contact_info' ); ?>
                    <input type="submit" value="Save Changes" class="button button-primary" id="add-contact-item" data-edit="<?php echo $result['id'];?>">
                </div>

            </form>

        <?php
    }
}