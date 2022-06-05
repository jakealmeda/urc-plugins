<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//global $gcounter;

class URCVideoMainFunctionExt {

	public function urc_vid_sort_relationships( $data ) {

		if( is_array( $data ) ) :

			$outs = '';

			foreach( $data as $pid ) {

				$outs .= '<div class="item-relationship-entry">';
					
					$outs .= '<a href="'.get_the_permalink( $pid ).'">'.get_the_title( $pid ).'</a>';

				$outs .= '</div>';

			}

			return $outs;

		else :

			return FALSE;

		endif;

	}


	/**
	 * Pull YOUTUBE & VIMEO Videos
	 *
	 */
	public function urc_vid_embed( $args ) {

		// set thumbnail
		if( array_key_exists( 'thumb', $args ) && !empty( $args[ 'thumb' ] ) ) {

			if( $args[ 'thumb_size' ] ) {
				
				// use specified size
				$use_this_thumb = wp_get_attachment_image_src( $args[ 'thumb' ], $args[ 'thumb_size' ] );

			} else {

				// default to full sized thumbnail
				$use_this_thumb = wp_get_attachment_image_src( $args[ 'thumb' ], 'full' );	
				
			}

			$use_this_thumb = $use_this_thumb[0];

		} else {
			$use_this_thumb = '';
		}

		// YOUTUBE
		if( $args[ 'type' ] == 'youtube' ) {

			$vid = explode( "/", $args[ 'vid' ] );
			$video_id = count( $vid ) - 1;

			// validate URL used
			// we want to catch the video id even if writer uses the link similar to this: https://www.youtube.com/watch?v=zDujFhvgUzI
			$exp_vid = explode( "?v=", $vid[ $video_id ] );
			if( count( $exp_vid ) > 1 ) {
				// not using the embed URL
				$youtubeid = $exp_vid[ count( $exp_vid ) - 1 ];
			} else {
				// using the embed URL
				$youtubeid = $vid[ $video_id ];
			}

			$atts = array(
				'type'					=> $args[ 'type' ],
				'video_id'				=> $youtubeid,
				'counter'				=> $args[ 'counter' ],
				'thumbs'				=> $use_this_thumb,
			);

			return $this->urc_video_output_fn( $atts );

		}

		// VIMEO
		if( $args[ 'type' ] == 'vimeo' ) {

			// filter the Vimeo ID
			$exp_vimeo_id = explode( '/', $args[ 'vid' ] );
			$id = $exp_vimeo_id[ count( $exp_vimeo_id ) - 1 ];

			// validate array content
			if( array_key_exists( 'vimeo_thumb_size', $args ) ) {
				$vts = $args[ 'vimeo_thumb_size' ];
			} else {
				$vts = NULL;
			}

			$atts = array(
				'type'					=> $args[ 'type' ],
				'video_id'				=> $id,
				'counter'				=> $args[ 'counter' ],
				//'thumbs'				=> $use_this_thumb[0],
				'thumbs'				=> $use_this_thumb,
				'vimeo_thumb_size'		=> $vts,
			);

			return $this->urc_video_output_fn( $atts );

		}

	}


	/**
	 * OUTPUT: YOUTUBE AND VIMEO VIDEOS
	 *
	 */
	public function urc_video_output_fn( $args ) {

		$id = $args[ 'video_id' ];
		$box_counter = $args[ 'counter' ];
		// validate array content
		if( array_key_exists( 'vimeo_thumb_size', $args ) ) {
			$t_size = $args[ 'vimeo_thumb_size' ];
		} else {
			$t_size = NULL;
		}//$t_size = $args[ 'vimeo_thumb_size' ];

		// validate thumbnail
		if( !empty( $args[ 'thumbs' ] ) ) {

			$thumbsup = $args[ 'thumbs' ];

		} else {
			
			// get youtube thumbnail
			if( $args[ 'type' ] == 'youtube' ) {

				$thumbsup = 'https://img.youtube.com/vi/'.$id.'/0.jpg';

			}

			// get vimeo thumbnail
			if( $args[ 'type' ] == 'vimeo' ) {

				$data = file_get_contents( "https://vimeo.com/api/v2/video/".$id.".json" );
				$data = json_decode($data);

				//$thumbsup = $data[0]->$args[ 'vimeo_thumb_size' ];
				$thumbsup = $data[0]->$t_size;

			}
			
		}
		
		// display
		return '<div class="module video video-block" id="videoblock__'.$args[ 'type' ].'___'.$id.'___'.$box_counter.'">
					<div class="video-image" id="video_image___'.$id.'___'.$box_counter.'" style="background-image: url('.$thumbsup.');background-size:cover;background-position:center;">
						<div class="video-button"></div>
					</div>
			</div>';
	}


    /**
     * WP Native Global Embed code
     */
    public function urc_oembed_sc( $vid ) {

        $main_class = new URCVideosMain();
        $mc = $main_class->urc_vid_oembed_dimensions();
        
        return $GLOBALS[ 'wp_embed' ]->run_shortcode( '[embed width="'.$mc[ "width" ].'" height="'.$mc[ "height" ].'"]'.$vid.'[/embed]' );

    }

}
