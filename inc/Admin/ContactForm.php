<?php

namespace Contact\Inc\Admin;

// directly access denied
defined('ABSPATH') || exit;

class ContactForm{
    public function edit_form(){
        ?>

            <form action="" class="contact-info-form">

                <div class="item-row">
                    <label for="name">Name:</label>
                    <input type="text" value="name" id="name">
                </div>

                <div class="item-row">
                    <label for="email">Email:</label>
                    <input type="email" value="email" id="email">
                </div>

                <div class="item-row">
                    <label for="phone">Phone:</label>
                    <input type="number" value="phone" id="phone" min="100000000">
                </div>

                <div class="item-row">
                    <label for="website">Website:</label>
                    <input type="url" value="website" id="website">
                </div>

                <div class="item-row">
                    <label for="address">Address:</label>
                    <textarea id="address"rows="2"></textarea>
                </div>

                <div class="item-row">
                    <label for="message">Message:</label>
                    <textarea id="message"rows="5"></textarea>
                </div>

                <div class="item-row">
                    <input type="submit" value="Save Changes" class="button button-primary">
                </div>

            </form>

        <?php
    }
}