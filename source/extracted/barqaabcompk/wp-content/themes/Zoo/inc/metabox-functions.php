<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	$meta_boxes[] = array(
		'id'         => 'page_metabox',
		'title'      => __('Page Options', 'zoo'),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
						array(
			'name' => __( 'Heading Style', 'zoo'),
				'desc' => __( 'Select Page Heading Style', 'zoo'),
				'id'   => $prefix . 'heading_style',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('Standard', 'zoo'), 'value' => 'standard', ),
					array( 'name' => __('Dropcap', 'zoo'), 'value' => 'dropcap', ),
					array( 'name' => __('No Heading', 'zoo'), 'value' => 'noheading', ),
				),
			),	

			array(
	            'name' => __('Background Color', 'zoo'),
	            'desc' => __('Select page background color', 'zoo'),
	            'id'   => $prefix . 'background_colorpicker',
	            'type' => 'colorpicker',
				'std'  => '#ffffff'
	        ),
			array(
				'name' => __('Background Image', 'zoo'),
				'desc' => __('Upload a background image or enter an URL.', 'zoo'),
				'id'   => $prefix . 'background_image',
				'type' => 'file',
			),
			array(
				'name' => __('Page Description', 'zoo'),
				'id'   => $prefix . 'description_text',
				'type' => 'wysiwyg',
			),

		
		),
	);

	$meta_boxes[] = array(
		'id'         => 'super_slider_metabox',
		'title'      => __('Slide Caption Scoll Animation Presets', 'zoo'),
		'pages'      => array( 'super_slider', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		//'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(
			array(
				'name' => __( 'Animtion Style', 'zoo'),
				'id'   => $prefix . 'caption_animation',
				'type' => 'select',
				'options' => array(
					array( 'name' => __('None', 'zoo'), 'value' => '', ),
					array( 'name' => __('Shrink', 'zoo'), 'value' => "data-0='transform:scale(1); top:0px;' data-1400='transform:scale(0.5); top:200px;' ", ),
					array( 'name' => __('Grow', 'zoo'), 'value' => "data-0='transform:scale(1); top:0px;' data-1400='transform:scale(2); top:-200px;' ", ),
					array( 'name' => __('Spin', 'zoo'), 'value' => "data-0='transform:rotate(0deg);' data-1400='transform:rotate(360deg);' ", ),
				),
			),
		)
	);


	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
