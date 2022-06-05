<?php
/**
 * Plugin Name: URC Plugins
 * Description: Contains all plugins developed for UnderstandingRelationships.com
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// MAIN CLASS
class URCPluginsMain {

    // simply return this plugin's main directory
    public function urc_plugin_dir_path() {

        return plugin_dir_path( __FILE__ );

    }

    // simply return this plugin's url
    public function urc_plugin_url_add( $file ) {

        return plugins_url( $file , __FILE__ );

    }

}
/*

markcorpuz
ClientURC@2022
*/
include_once( 'videos/urc-videos.php' );