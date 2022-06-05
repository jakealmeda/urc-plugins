<?php

global $urc_vars, $urc_counter;
$urc_counter++;

$mfunc = new URCVideoMainFunction();
$mfunc_ext = new URCVideoMainFunctionExt();

// class
$cs = array(
	'manual_class'		=> 'item-video',
	'item_class' 		=> $mfunc->urc_vid_array_validation( 'wrap_sel', $urc_vars ),
	'block_class'		=> $mfunc->urc_vid_array_validation( 'block_class', $urc_vars ),
);
$css = $mfunc->urc_vid_combine_classes( $cs );
$classes = !empty( $css ) ? ' class="'.$css.'"' : '';

// styles
$ss = array(
	'manual_style'		=> '',
	'item_style' 		=> $mfunc->urc_vid_array_validation( 'wrap_sty', $urc_vars ),
);
$stayls = $mfunc->urc_vid_combine_styles( $ss );
$inline_style = !empty( $stayls ) ? ' style="'.$stayls.'"' : '';

// info | title, summary
$bsf = $mfunc->urc_vid_array_validation( "video_toggle", $urc_vars );
$bhf = $mfunc->urc_vid_array_validation( "video_default", $urc_vars );

if( $bhf === 'enable' ) :

/**
 * CONTENT | START
 */

// WRAP | OPEN
echo '<div'.$classes.$inline_style.'>';

	// -------------
	// INFO
	// -------------

	// TITLE
	$video_title = $mfunc->urc_vid_array_validation( "title", $urc_vars );
	if( !empty( $video_title ) && is_array( $bsf ) && in_array( 'title', $bsf ) ) {
		echo '<h4 class="item-title">'.$video_title.'</h4>';
	}

	// THUMBNAIL
	$video_thumb = $mfunc->urc_vid_array_validation( "thumb", $urc_vars );
	if( !empty( $video_thumb ) && is_array( $bsf ) && in_array( 'thumb', $bsf ) ) {
		//echo '<h4 class="item-thumb">'.$video_thumb.'</h4>';
		$thumbs = wp_get_attachment_image_src( $video_thumb, 'full' );

		echo '<div class="item-thumb"><img src="'.$thumbs[ 0 ].'" border="0" /></div>';
	}

	// SUMMARY
	$video_summary = $mfunc->urc_vid_array_validation( "summary", $urc_vars );
	if( !empty( $video_summary ) && is_array( $bsf ) && in_array( 'summary', $bsf ) ) {
		echo '<div class="item-summary">'.$video_summary.'</div>';
	}

	// -------------
	// SOURCES
	// -------------

	// YOUTUBE
	$video_youtube = $mfunc->urc_vid_array_validation( "youtube", $urc_vars );
	if( !empty( $video_youtube ) && is_array( $bsf ) && in_array( 'youtube', $bsf ) ) {
		
		//echo '<div class="item-youtube">'.$video_youtube.'</div>';
		$args_yt = array(
			'type'			=> 'youtube',
			'thumb'			=> $video_thumb, // NOTE: this variable should always be found on top of this line
			'thumb_size'	=> 'full',
			'vid'			=> $video_youtube,
			'counter'		=> $urc_counter,
		);
		
		echo '<div class="item-youtube">'.$mfunc_ext->urc_vid_embed( $args_yt ).'</div>';

	}

	// VIMEO
	$video_vimeo = $mfunc->urc_vid_array_validation( "vimeo", $urc_vars );
	if( !empty( $video_vimeo ) && is_array( $bsf ) && in_array( 'vimeo', $bsf ) ) {

		// echo '<div class="item-vimeo">'.$video_vimeo.'</div>';
		$args_vi = array(
			'type'			=> 'vimeo',
			'thumb'			=> $video_thumb, // NOTE: this variable should always be found on top of this line
			'thumb_size'	=> 'full',
			'vid'			=> $video_vimeo,
			'counter'		=> $urc_counter,
		);
		
		echo '<div class="item-vimeo">'.$mfunc_ext->urc_vid_embed( $args_vi ).'</div>';

	}

	// RUMBLE LINK
	$video_rumble = $mfunc->urc_vid_array_validation( "rumble", $urc_vars );
	if( !empty( $video_rumble ) && is_array( $bsf ) && in_array( 'rumble', $bsf ) ) {

		// text
		if( $mfunc->urc_vid_array_validation( 'title', $video_rumble ) ) {
			$video_rumble_text = $video_rumble[ 'title' ];
		} else {
			$video_rumble_text = $video_rumble[ 'url' ];
		}

		// target
		if( $mfunc->urc_vid_array_validation( 'target', $video_rumble ) ) {
			$video_rumble_target = 'target="'.$video_rumble[ "target" ].'"';
		} else {
			$video_rumble_target = '';
		}

		echo '<div class="item-rumble"><a href="'.$video_rumble[ "url" ].'"'.$video_rumble_target.'>'.$video_rumble_text.'</a></div>';

	}

	// RUMBLE EMBED
	$video_rumble_e = $mfunc->urc_vid_array_validation( "rumble_embed", $urc_vars );
	if( !empty( $video_rumble_e ) && is_array( $bsf ) && in_array( 'rumble_embed', $bsf ) ) {

		echo '<div class="item-rumble-embed">'.$mfunc_ext->urc_oembed_sc( $video_rumble_e ).'</div>';

	}

	// AUDIO
	$video_audio = $mfunc->urc_vid_array_validation( "audio", $urc_vars );
	if( !empty( $video_audio ) && is_array( $bsf ) && in_array( 'audio', $bsf ) ) {

		$attr_vid = array(
			'src'      => $video_audio,
			'loop'     => '',
			'autoplay' => '',
			'preload' => 'none'
		);
		
		echo '<div class="item-video_audio">'.wp_audio_shortcode( $attr_vid ).'</div>';

	}

	// -------------
	// CONNECT
	// -------------

	// VIDEO CONNECT
	$video_connect = $mfunc->urc_vid_array_validation( "connect", $urc_vars );
	if( !empty( $video_connect ) && is_array( $bsf ) && in_array( 'connect', $bsf ) ) {
		echo '<div class="item-connect">'.$mfunc_ext->urc_vid_sort_relationships( $video_connect ).'</div>';
	}

	// VIDEO RELATED POSTS
	$video_related = $mfunc->urc_vid_array_validation( "related", $urc_vars );
	if( !empty( $video_related ) && is_array( $bsf ) && in_array( 'related', $bsf ) ) {
		echo '<div class="item-related">'.$mfunc_ext->urc_vid_sort_relationships( $video_related ).'</div>';
	}

	?><InnerBlocks /><?php
	
// WRAP | CLOSE
echo '</div>';

endif;
