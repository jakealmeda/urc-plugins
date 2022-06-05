<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


$v = new URCVideosMain();
class URCVideosMain {

    /**
     * WP oEmbed video dimensions
     */
    public function urc_vid_oembed_dimensions() {

        return $sizes = array(
            'width'     =>  '640',
            'height'    =>  '360',
        );

    }

    /**
     * Proper way to enqueue scripts and styles
     */
    public function urc_vid_enqueue_scripts() {

        $w = new URCPluginsMain();

        // CSS
        wp_enqueue_style( 'urc-video', $w->urc_plugin_url_add( 'videos/css/styles.css' ) );

        // JavaScript
        wp_enqueue_script( 'urc-video', $w->urc_plugin_url_add( 'videos/js/asset.js' ), array(), '1.0.0', true );

    }

    // CONSTRUCT OUTPUT
    public function __construct() {

        //add_action( 'wp_footer', array( $this, 'urc_vid_enqueue_scripts' ), 5 );
        add_action( 'wp_enqueue_scripts', array( $this, 'urc_vid_enqueue_scripts' ) );

    }

}


include_once( 'lib/urc-videos-block-gen.php' );
include_once( 'lib/urc-videos-acf.php' );
include_once( 'lib/urc-videos-functions-template.php' );
include_once( 'lib/urc-videos-functions.php' );