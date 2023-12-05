<?php

namespace Contact\Inc;

defined('ABSPATH') || exit;

class Assets{

    public function __construct(){

        // register frontend scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend_scripts' ], 15 );

        // register admin scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_scripts' ], 15 );
    }

    /**
     * register frontend scripts
     *
     * @return void
     */
    public function register_frontend_scripts(){
        // load style
        wp_enqueue_style(
            'ci-style',                                    // handle
            plugins_url( 'lib/css/style.css', __FILE__ ),  // source
            [''],                                          // dependencies
            CI_VERSION,                                    // version
            'all'                                          // media
        );

        // load scripts
        wp_enqueue_script( 
            'ci-script',                                   // handle
            plugins_url( 'lib/js/custom.js', __FILE__ ),   // source
            ['jquery'],                                    // dependencies
            CI_VERSION,                                    // version
            true                                           // in_footer
        );
    }

    /**
     * register admin scripts
     *
     * @return void
     */
    public function register_admin_scripts(){
        // load style
        wp_enqueue_style(
            'ci-style',                                          // handle
            plugins_url( 'lib/admin/css/style.css', __FILE__ ),  // source
            [''],                                                // dependencies
            CI_VERSION,                                          // version
            'all'                                                // media
        );

        // load scripts
        wp_enqueue_script( 
            'ci-script',                                         // handle
            plugins_url( 'lib/admin/js/custom.js', __FILE__ ),   // source
            ['jquery'],                                          // dependencies
            CI_VERSION,                                          // version
            true                                                 // in_footer
        );
    }
    
}