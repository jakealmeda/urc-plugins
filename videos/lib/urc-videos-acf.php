<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Add a block category for "Setup" if it doesn't exist already.
 *
 * @ param array $categories Array of block categories.
 *
 * @ return array
 */
add_filter( 'block_categories_all', 'urc_videos_block_categories' );
function urc_videos_block_categories( $categories ) {

    $category_slugs = wp_list_pluck( $categories, 'slug' );

    return in_array( 'setup', $category_slugs, TRUE ) ? $categories : array_merge(
        array(
            array(
                'slug'  => 'setup',
                'title' => __( 'Setup', 'mydomain' ),
                'icon'  => null,
            ),
        ),
        $categories
    );

}


/**
 * VIDEO (Custom Blocks)
 * 
 */
add_action( 'acf/init', 'urc_video_acf_block_init' );
function urc_video_acf_block_init() {

    $z = new URCPluginsMain();
    $fields_func = new URCVidBlockGen();

    foreach( $fields_func->urc_vid_block_gen_details() as $key => $value ) {
        
        $blocks[ $key ] = array(
            'name'                  => $value[ 'block' ][ 'name' ],
            'title'                 => $value[ 'block' ][ 'title' ],
            'render_template'       => $z->urc_plugin_dir_path().'videos/templates/blocks/'.$value[ 'block' ][ 'template' ],
            'category'              => 'setup',
            'icon'                  => $value[ 'block' ][ 'icon' ],
            'mode'                  => 'edit',
            'keywords'              => $value[ 'block' ][ 'keywords' ],
            'supports'              => [
                'align'             => false,
                'anchor'            => true,
                'customClassName'   => true,
                'jsx'               => true,
            ],            
        );

    }

    /*$blocks = array(
        
        's_videos' => array(
            'name'                  => 'setup_video',
            'title'                 => __('URC Video'),
            'render_template'       => $z->urc_plugin_dir_path().'videos/templates/blocks/urc-video-block.php',
            'category'              => 'setup',
            'icon'                  => 'video-alt3',
            'mode'                  => 'edit',
            'keywords'              => array( 'video', 'embed video' ),
            'supports'              => [
                'align'             => false,
                'anchor'            => true,
                'customClassName'   => true,
                'jsx'               => true,
            ],
        ),

    );*/

    // Bail out if function doesn’t exist or no blocks available to register.
    if ( !function_exists( 'acf_register_block_type' ) && !$blocks ) {
        return;
    }

    foreach( $blocks as $block ) {
        acf_register_block_type( $block );
    }
  
}


/**
 * Auto fill Select options | VIDEO TEMPLATES
 *
 */
add_filter( 'acf/load_field/name=video_template', 'urc_video_load_templates' ); // REMOTE
function urc_video_load_templates( $field ) {
    
    $z = new URCPluginsMain();

    $file_extn = 'php';

    // get all files found in VIEWS folder
    $view_dir = $z->urc_plugin_dir_path().'videos/templates/views/';

    $data_from_dir = setup_pulls_view_files( $view_dir, $file_extn );

    $field['choices'] = array();

    //Loop through whatever data you are using, and assign a key/value
    if( is_array( $data_from_dir ) ) {

        foreach( $data_from_dir as $field_key => $field_value ) {
            $field['choices'][$field_key] = $field_value;
        }

        return $field;

    }
    
}


/**
 * Auto select Checkbox options | Fields to Show | INFO TAB
 *
 */
add_filter('acf/load_field/name=video_template', 'urc_video_load_templates_def' );
function urc_video_load_templates_def( $field ) {

    $field['default_value'] = 'default.php';

    return $field;

}


/**
 * Pull all files found in $directory but get rid of the dots that scandir() picks up in Linux environments
 *
 */
if( !function_exists( 'setup_pulls_view_files' ) ) {

    function setup_pulls_view_files( $directory, $file_extn ) {

        $out = array();
        
        // get all files inside the directory but remove unnecessary directories
        $ss_plug_dir = array_diff( scandir( $directory ), array( '..', '.' ) );

        foreach( $ss_plug_dir as $filename ) {
            
            if( pathinfo( $filename, PATHINFO_EXTENSION ) == $file_extn ) {
                $out[ $filename ] = pathinfo( $filename, PATHINFO_FILENAME );
            }

        }

        /*foreach ($ss_plug_dir as $value) {
            
            // combine directory and filename
            $file = basename( $directory.$value, $file_extn );
            
            // filter files to include
            if( $file ) {
                $out[ $value ] = $file;
            }

        }*/

        // Return an array of files (without the directory)
        return $out;

    }
    
}