<?php

namespace Contact\Inc\Admin;
use WP_List_Table;

// directly access denied
defined('ABSPATH') || exit;

/**
 * Create Menu class to manage dashboard menu
 * 
 * @version 1.0
 * @author Rubel Mahmud (Sujan)
 * @link https://github.com/vxlrubel
 */

// requite WP_List_Table class if not exists
if ( ! class_exists('WP_List_Table') ){
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
 class ContactInfoListTable extends WP_List_Table {

 }