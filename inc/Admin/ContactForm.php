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

            <form action="" class="contact-info-form">

                <div class="item-row">
                    <label for="name">Name:</label>
                    <input type="text" value="<?php echo $result['name']; ?>" id="name">
                </div>

                <div class="item-row">
                    <label for="email">Email:</label>
                    <input type="email" value="<?php echo $result['email']; ?>" id="email">
                </div>

                <div class="item-row">
                    <label for="phone">Phone:</label>
                    <input type="number" value="<?php echo $result['phone']; ?>" id="phone" min="100000000">
                </div>

                <div class="item-row">
                    <label for="website">Website:</label>
                    <input type="url" value="<?php echo $result['website']; ?>" id="website">
                </div>

                <div class="item-row">
                    <label for="address">Address:</label>
                    <textarea id="address"rows="2"><?php echo $result['address']; ?></textarea>
                </div>

                <div class="item-row">
                    <label for="message">Message:</label>
                    <textarea id="message"rows="5"><?php echo $result['message']; ?></textarea>
                </div>

                <div class="item-row">
                    <input type="submit" value="Save Changes" class="button button-primary">
                </div>

            </form>

        <?php endforeach;
    }
}