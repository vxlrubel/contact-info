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
            'ci-front-style',           // handle
            CI_LIB . 'css/style.css',   // source
            [],                         // dependencies
            CI_VERSION,                 // version
        );

        // load scripts
        wp_enqueue_script( 
            'ci-front-script',          // handle
            CI_LIB . 'js/custom.js',    // source
            ['jquery'],                 // dependencies
            CI_VERSION,                 // version
            true                        // in_footer
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
            'ci-admin-style',                // handle
            CI_ADMIN_LIB . 'css/style.css',  // source
            [],                              // dependencies
            CI_VERSION,                      // version
        );

        // load scripts
        wp_enqueue_script( 
            'ci-admin-script',              // handle
            CI_ADMIN_LIB . 'js/custom.js',  // source
            ['jquery'],                     // dependencies
            CI_VERSION,                     // version
            true                            // in_footer
        );

    }
    
}