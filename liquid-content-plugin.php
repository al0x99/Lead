<?php
/**
* Plugin Name: Liquid Content Test
* Version: 0.0.1
* Author URI: https://wpaper.it
**/

function enqueue_liquid_content_script() {
    wp_enqueue_script( 'liquid-content-script', plugin_dir_url( __FILE__ ) . 'js/liquid-content.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_liquid_content_script' );

// enpoint per rest api
add_action('rest_api_init', function () {
    register_rest_route('liquid-content/v1', '/data', array(
        'methods' => 'GET',
        'callback' => 'get_liquid_data',
    ));
});

function get_liquid_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'liquid_content';
    $results = $wpdb->get_results("SELECT * FROM {$table_name}");
    return $results;
}

// crea tabella quando plugin viene attivato
register_activation_hook(__FILE__, 'create_liquid_table');
function create_liquid_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'liquid_content';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        data text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// salva nel db
add_action('wp_ajax_save_liquid_data', 'save_liquid_data');
add_action('wp_ajax_nopriv_save_liquid_data', 'save_liquid_data');
function save_liquid_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'liquid_content';

    $data = $_POST['data'];
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $data['user_ip'] = $user_ip;
    $data_encoded = json_encode($data);

    $wpdb->insert($table_name, array(
        'time' => current_time('mysql'),
        'data' => $data_encoded
    ));

    wp_die();
}

