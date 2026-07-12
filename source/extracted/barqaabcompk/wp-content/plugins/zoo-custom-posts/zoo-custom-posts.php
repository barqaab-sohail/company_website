<?php
/*
Plugin Name: Zoo Custom Posts
Plugin URI: http://www.webdingo.net/zoo/
Description: Custom post types for Zoo
Version: 1.0.1
Author: WebDingo
Author URI: http://www.webdingo.net
*/
function load_custom_post_textdomain() {
	$plugin_dir = basename(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR ;
	load_plugin_textdomain( 'zoo-custom-posts', false, $plugin_dir );
}
add_action('plugins_loaded', 'load_custom_post_textdomain');

/*-----------------------------------------------------------------------------------*/
/*	Flex Slider
/*-----------------------------------------------------------------------------------*/
if (!function_exists('zoo_custom_post_flex_slider')) {
	function zoo_custom_post_flex_slider() {
		$labels = array(
			'name'               => __( 'Flex Sliders', 'zoo-custom-posts' ),
			'singular_name'      => __( 'Flex Slider', 'zoo-custom-posts' ),
			'add_new'            => __( 'Add New', 'zoo-custom-posts' ),
			'add_new_item'       => __( 'Add New Slide', 'zoo-custom-posts' ),
			'edit_item'          => __( 'Edit Slide', 'zoo-custom-posts' ),
			'new_item'           => __( 'New Slide' , 'zoo-custom-posts'),
			'all_items'          => __( 'All Slides', 'zoo-custom-posts' ),
			'view_item'          => __( 'View Slide', 'zoo-custom-posts' ),
			'search_items'       => __( 'Search Sliders', 'zoo-custom-posts' ),
			'not_found'          => __( 'No sliders found', 'zoo-custom-posts' ),
			'not_found_in_trash' => __( 'No sliders found in the Trash', 'zoo-custom-posts' ), 
			'menu_name'          => __( 'Flex Slider' , 'zoo-custom-posts' )
		);
		$args = array(
			'labels'        => $labels,
			'description'   => __('Flex Slider Slides', 'zoo-custom-posts'),
			'public'        => true,
			'menu_position' => null,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'exclude_from_search' => true,
		);
		register_post_type( 'flex_slider', $args );	
	}
	add_action( 'init', 'zoo_custom_post_flex_slider' );
}
/*-----------------------------------------------------------------------------------*/
/*	Super Slider
/*-----------------------------------------------------------------------------------*/

if (!function_exists('zoo_custom_post_super_slider')) {
	function zoo_custom_post_super_slider() {
		$labels = array(
			'name'               => __( 'SuperSlides', 'zoo-custom-posts' ),
			'singular_name'      => __( 'SuperSlides Slide', 'zoo-custom-posts' ),
			'add_new'            => __( 'Add New', 'zoo-custom-posts' ),
			'add_new_item'       => __( 'Add New Slide', 'zoo-custom-posts' ),
			'edit_item'          => __( 'Edit Slide', 'zoo-custom-posts' ),
			'new_item'           => __( 'New Slide', 'zoo-custom-posts' ),
			'all_items'          => __( 'All Slides', 'zoo-custom-posts' ),
			'view_item'          => __( 'View Slide', 'zoo-custom-posts' ),
			'search_items'       => __( 'Search Slide', 'zoo-custom-posts' ),
			'not_found'          => __( 'No sliders found', 'zoo-custom-posts' ),
			'not_found_in_trash' => __( 'No sliders found in the Trash', 'zoo-custom-posts' ), 
			'menu_name'          => __( 'SuperSlides', 'zoo-custom-posts')
		);
		$args = array(
			'labels'        => $labels,
			'description'   => __('Super Slider / Home Page Slider Slides', 'zoo-custom-posts'),
			'public'        => true,
			'menu_position' => null,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'exclude_from_search' => true,
		);
		register_post_type( 'super_slider', $args );	
	}
	add_action( 'init', 'zoo_custom_post_super_slider' );
}
/*-----------------------------------------------------------------------------------*/
/*	Portfolio
/*-----------------------------------------------------------------------------------*/

if (!function_exists('zoo_custom_post_portfolio')) {
	function zoo_custom_post_portfolio() {
		$labels = array(
			'name'               => __( 'Portfolio Items', 'zoo-custom-posts' ),
			'singular_name'      => __( 'Portfolio Item', 'zoo-custom-posts' ),
			'add_new'            => __( 'Add New', 'zoo-custom-posts' ),
			'add_new_item'       => __( 'Add New Item', 'zoo-custom-posts' ),
			'edit_item'          => __( 'Edit Portfolio Item', 'zoo-custom-posts' ),
			'new_item'           => __( 'New Portfolio Item', 'zoo-custom-posts' ),
			'all_items'          => __( 'All Items', 'zoo-custom-posts' ),
			'view_item'          => __( 'View Item', 'zoo-custom-posts' ),
			'search_items'       => __( 'Search Portfolios', 'zoo-custom-posts' ),
			'not_found'          => __( 'No items found', 'zoo-custom-posts' ),
			'not_found_in_trash' => __( 'No items found in the Trash', 'zoo-custom-posts' ), 
			'menu_name'          => __( 'Portfolio', 'zoo-custom-posts')
		);
		$args = array(
			'labels'        => $labels,
			'description'   => __( 'Portfolio Items', 'zoo-custom-posts'),
			'public'        => true,
			'menu_position' => null,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'exclude_from_search' => true,
		);
		register_post_type( 'portfolios', $args );	
	}
	add_action( 'init', 'zoo_custom_post_portfolio' );
}
/*-----------------------------------------------------------------------------------*/
/*	Taxonomies
/*-----------------------------------------------------------------------------------*/

if (!function_exists('create_zoo_taxonomies')) {
	function create_zoo_taxonomies() {
	    register_taxonomy(
	        'flex_slider_category',
	        'flex_slider',
	        array(
	            'labels' => array(
	                'name' => __('Flex Slider Categories', 'zoo-custom-posts'),
	                'add_new_item' => __( 'Add New Flex Slider Category', 'zoo-custom-posts'),
	                'new_item_name' => __( 'New Flex Slider Category', 'zoo-custom-posts'),
	            ),
	            'show_ui' => true,
	            'show_tagcloud' => false,
	            'hierarchical' => true,
	        )
	    );
	    register_taxonomy(
	        'portfolio_item_category',
	        'portfolios',
	        array(
	            'labels' => array(
	                'name' => __( 'Portfolio Categories', 'zoo-custom-posts'),
	                'add_new_item' => __( 'Add New Portfolio Category', 'zoo-custom-posts'),
	                'new_item_name' => __( 'New Portfolio Category', 'zoo-custom-posts'),
	            ),
	            'show_ui' => true,
	            'show_tagcloud' => false,
	            'hierarchical' => true
	        )
	    );
	}
	add_action( 'init', 'create_zoo_taxonomies', 0 );
}

?>