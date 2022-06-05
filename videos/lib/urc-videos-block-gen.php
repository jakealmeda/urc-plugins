<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


class URCVidBlockGen {

    public function urc_vid_block_gen_details() {

        return array(

        // DO NOT GO BEFORE THIS LINE
        // ################################

            // COPY FROM THE LINE BELOW ----------------------
            's_videos' => array(
                
                'block' => array(
                    'name'                              => 'setup_video',
                    'title'                             => __('URC Video'),
                    'icon'                              => 'video-alt3', // https://developer.wordpress.org/resource/dashicons/
                    'keywords'                          => array( 'video', 'embed video' ),
                    'template'                          => 'urc-video-block.php',
                ),

                'fields' => array(
                    // change the following to you exact fields
                    'title'                             => 'video_title',
                    'thumb'                             => 'video_thumbnail',
                    'summary'                           => 'video_summary',
                    'youtube'                           => 'video_youtube',
                    'vimeo'                             => 'video_vimeo',
                    'rumble'                            => 'rumble_link',
                    'rumble_embed'                      => 'video_rumble',
                    'audio'                             => 'video_audio',
                    'connect'                           => 'video_connect',
                    'related'                           => 'video_related_post',
                    'video_toggle'                      => 'video_toggle',
                    'video_default'                     => 'video_default',
                    'wrap_sel'                          => 'video_section_class',
                    'wrap_sty'                          => 'video_section_style',
                    'template'                          => 'video_template',
                ),
                
            ),
            // COPY UNTIL THE LINE ABOVE ---------------------

            /*'info_block_media' => array(
                
                'block' => array(
                    'name'                              => 'info_block_media',
                    'title'                             => __('Info Block Media'),
                    'icon'                              => 'block-default', // https://developer.wordpress.org/resource/dashicons/
                    'keywords'                          => array( 'setup', 'information', 'info', 'media' ),
                    'template'                          => 'setup-blocks.php',
                ),

                'fields' => array(
                    // change the following to you exact fields
                    'title'                             => 'blocks-title',
                    'summary'                           => 'blocks-summary',
                    'blocks-show-fields'                => 'blocks-show-fields',
                    'blocks-hide-all-fields'            => 'blocks-hide-all-fields',
                    'image'                             => 'blocks-image',
                    'image_size'                        => 'blocks-image-size',
                    'video'                             => 'blocks-video',
                    'blocks-show-fields-media'          => 'blocks-show-fields-media',
                    'blocks-hide-all-fields-media'      => 'blocks-hide-all-fields-media',
                    'wrap_sel'                          => 'blocks-section-class',
                    'wrap_sty'                          => 'blocks-section-style',
                    'template'                          => 'blocks-template',
                ),
                
            ),*/

        // ################################
        // DO NOT GO AFTER THIS LINE

        );

    }

}