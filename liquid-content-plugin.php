<?php
/**
* Plugin Name: Liquid Content Test
* Plugin URI: http://indirizzodeltuo-sito.com
* Version: 0.0.1
* Author URI: https://wpaper.it
**/

function enqueue_liquid_content_script() {
    wp_enqueue_script( 'liquid-content-script', plugin_dir_url( __FILE__ ) . 'js/liquid-content.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_liquid_content_script' );
