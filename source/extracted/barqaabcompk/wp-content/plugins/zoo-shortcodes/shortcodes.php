<?php

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/
if (!function_exists('column_full')) {
	function column_full( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'spacing' => '',
		), $atts ) );
	   return '<div class="c12 end ">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_full', 'column_full');
}

if (!function_exists('column_third')) {
	function column_third( $atts, $content = null ) {
	   return '<div class="c4">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_third', 'column_third');
}

if (!function_exists('column_third_last')) {
	function column_third_last( $atts, $content = null ) {
	   return '<div class="c4 end">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_third_last', 'column_third_last');
}

if (!function_exists('column_two_thirds')) {
	function column_two_thirds( $atts, $content = null ) {
	   return '<div class="c8">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_two_thirds', 'column_two_thirds');
}

if (!function_exists('column_two_thirds_last')) {
	function column_two_thirds_last( $atts, $content = null ) {
	   return '<div class="c8 end">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_two_thirds_last', 'column_two_thirds_last');
}

if (!function_exists('column_half')) {
	function column_half( $atts, $content = null ) {
	   return '<div class="c6">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_half', 'column_half');
}

if (!function_exists('column_half_last')) {
	function column_half_last( $atts, $content = null ) {
	   return '<div class="c6 end">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_half_last', 'column_half_last');
}

if (!function_exists('column_quarter')) {
	function column_quarter( $atts, $content = null ) {
	   return '<div class="c3">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_quarter', 'column_quarter');
}

if (!function_exists('column_quarter_last')) {
	function column_quarter_last( $atts, $content = null ) {
	   return '<div class="c3 end">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_quarter_last', 'column_quarter_last');
}

if (!function_exists('column_three_quarter')) {
	function column_three_quarter( $atts, $content = null ) {
	   return '<div class="c9">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_three_quarter', 'column_three_quarter');
}

if (!function_exists('column_three_quarter_last')) {
	function column_three_quarter_last( $atts, $content = null ) {
	   return '<div class="c9 end">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('column_three_quarter_last', 'column_three_quarter_last');
}
if (!function_exists('grid')) {
	function grid( $atts, $content = null ) {
	   return '<div class="grid">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('grid', 'grid');
}
/*-----------------------------------------------------------------------------------*/
/*	Button Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('button_func')) {
	function button_func($atts, $content = null) {
		extract( shortcode_atts( array(
			'link' => '',
			'transparent' => '',
		), $atts ) );
		if($atts['transparent'] == 'yes') {
			return '<a href="'.$link.'" class="button transparent">'. do_shortcode($content) .'</a>'; 
		}
		else{
			return '<a href="'.$link.'" class="button">'. do_shortcode($content) .'</a>'; 
		} 
	}
	add_shortcode( 'button', 'button_func' );
}

/*-----------------------------------------------------------------------------------*/
/*	Skill Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('skill_func')) {
	function skill_func($atts) {
		extract( shortcode_atts( array(
			'name' => '',
			'level' => '',
		), $atts ) );
		return '<p class="skilltitle">'.$name.'<span class="skilllevel">'.$level.'%</span></p><div class="barwrapper"><div class="bar"><div style="width:'.$level.'%"></div></div></div>';  
	}
	add_shortcode( 'skill', 'skill_func' );
}

/*-----------------------------------------------------------------------------------*/
/*	Scroll Animation Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('scroll_animation')) {
	function scroll_animation ($atts, $content = null) {
		$output = '';
		$atts = shortcode_atts(
			array(
				'start' => '',
				'end' => '',
				'from' => '',
				'to' => '',
				'relative' => '',
			), $atts);

		if($atts['relative'] == 'yes') {
			$output .= '<div class="scrollanimation" data-'.$atts['start'].'-bottom-top ="'.$atts['from'].'" data-'.$atts['end'].'-top ="'.$atts['to'].'" style="'.$atts['to'].'">'.do_shortcode($content).'</div>';
		}
		else {
			$output .= '<div class="scrollanimation" data-'.$atts['start'].' ="'.$atts['from'].'" data-'.$atts['end'].' ="'.$atts['to'].'" style="'.$atts['from'].'"><div>'.do_shortcode($content).'</div></div>';
		} 
		return $output;
	}
	add_shortcode( 'scroll_animation', 'scroll_animation' );
}

/*-----------------------------------------------------------------------------------*/
/*	Recent Posts Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('string_limit_words')) {	
	function string_limit_words($string, $word_limit){
	  $words = explode(' ', $string, ($word_limit + 1));
	  if(count($words) > $word_limit)
	  array_pop($words);
	  return implode(' ', $words);
	}
}	

if (!function_exists('get_special_excerpt')) {
	function get_special_excerpt($count){
		$excerpt = get_the_content();
		$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $count);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
		return $excerpt;
	}
}

if (!function_exists('recent_posts')) {
	function recent_posts($atts) {
		$output = '';
		global $post;
		if(!isset($atts['num_posts'])) {
			$atts['num_posts'] = 3;
		}
		if(!isset($atts['excerpt_words'])) {
			$atts['excerpt_words'] = 50;
		}
		$output .= '<div id="recent-posts" class="clearfix">';
		if(!empty($atts['cat_slug']) && $atts['cat_slug']){
			$recent_posts = new WP_Query('post_status=publish&showposts='.$atts['num_posts'].'&category_name='.$atts['cat_slug']);
		} else {
			$recent_posts = new WP_Query('post_status=publish&showposts='.$atts['num_posts']);
		}
		while($recent_posts->have_posts()): $recent_posts->the_post();
		$output .= '<div class="blog-recent-post-item">';
	    if('post' == get_post_type()){		
			if(has_post_thumbnail($post->ID)){
				$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
				if($featured_image_url){
					$output .= '<div class="c12 end">';	
								$output .= '<a class="recent-post-img" href="'.get_permalink(get_the_ID()).'" rel="">';
								$output .= '<img src="'.$featured_image_url[0].'"/>';
								$output .= '</a>';
								$output .= '<span class="date">'.get_the_date('\<\s\p\a\n \c\l\a\s\s\=\"\d\a\y\"\>j\<\/\s\p\a\n\> M Y').'</span>'; 	
					$output .= '</div>';	
				}
			}

			$output .= '<div class="c12 end">';
		
			
		
			$output .= '<h2 class="entry-title"><a href="'.get_permalink(get_the_ID()).'" rel="">'.get_the_title().'</a></h2>';

	
			if ( has_excerpt() ) 
			{
			    $the_excerpt = get_the_excerpt();
				$output .= "<p>$the_excerpt</p>";
			} 
			else 
			{
			    $the_excerpt = get_special_excerpt(3072);
				$the_excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $the_excerpt);
				$the_excerpt = string_limit_words($the_excerpt, $atts['excerpt_words']);
				$output .="<p>$the_excerpt</p>";
			}
			$output .= '</div>';				
			$output .= '<div class="entry-meta"><div class="row"><div class="c12 end">';	
			$output .= '<div class="blog-bottom-bar">';
			$categories_list = get_the_category_list( __( ', ', 'zoo-shortcodes' ) );
			$output .= '<span>'.__('By ', 'zoo-shortcodes').'<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ). '">'.get_the_author().'</a> <span class="sep"> | </span></span><span> <time class="entry-date" datetime="'.esc_attr( get_the_date( 'c' ) ).'">'.esc_html( get_the_date() ).'</time><span class="sep"> | </span></span><span> <span class="cat-links"> In '.$categories_list.' </span><span class="sep"> | </span></span>';
			if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
				$args = array(
					'post_id' => get_the_ID(),
					'count' => true
				);
				$comments = get_comments($args);
				if(isset($comments) && $comments == 0){
					$output .= '<a href="'.get_permalink().'#respond">'. __('Leave a comment', 'zoo-shortcodes') .'</a>';
				}else if($comments == 1){
					$output .= '<a href="'.get_permalink().'#comments">'.$comments.' '.__('Comment', 'zoo-shortcodes').'</a>';
				}else{
					$output .= '<a href="'.get_permalink().'#comments">'.$comments.' '.__('Comments', 'zoo-shortcodes').'</a>';
				}
			endif;
			$output .= '<a class="readmore" href="'.get_permalink(get_the_ID()).'">'.__('Read more', 'zoo-shortcodes').'</a>';
			$output .= '</div>';
		}	
		$output .= '</div></div></div>';
		$output .= '</div>';
		endwhile;
		$output .= '</div>';
		return $output;
	}

	add_shortcode('recent_posts', 'recent_posts');
}

/*-----------------------------------------------------------------------------------*/
/*	Social Networks Shortcode
/*-----------------------------------------------------------------------------------*/

if ( !function_exists('social_networks')) {
	function social_networks () {
		global $Zoo_Options;
		$output = '';
		if (isset($Zoo_Options)){
			$twitter_link = $Zoo_Options->get('25');
			$facebook_link = $Zoo_Options->get('26');
			$dribbble_link = $Zoo_Options->get('27');
			$youtube_link = $Zoo_Options->get('28');
			$instagram_link = $Zoo_Options->get('29');
			$vimeo_link = $Zoo_Options->get('30');
			$tumblr_link = $Zoo_Options->get('31');
			$wordpress_link = $Zoo_Options->get('32');
			$rss_link = $Zoo_Options->get('33');
			$google_link = $Zoo_Options->get('34');
			$flickr_link = $Zoo_Options->get('35');
			$linkedin_link = $Zoo_Options->get('36');
			$skype_link = $Zoo_Options->get('37');
			$dropbox_link = $Zoo_Options->get('38');
			$output .= '<ul class="social-networks">';
			if($twitter_link <> ''){
				$output .= '<li class="twitter">';
				$output .= '<a href="'.$twitter_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($facebook_link <> ''){
				$output .= '<li class="facebook">';
				$output .= '<a href="'.$facebook_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($dribbble_link <> ''){
				$output .= '<li class="dribbble">';
				$output .= '<a href="'.$dribbble_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($youtube_link <> ''){
				$output .= '<li class="youtube">';
				$output .= '<a href="'.$youtube_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($instagram_link <> ''){
				$output .= '<li class="instagram">';
				$output .= '<a href="'.$instagram_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($vimeo_link <> ''){
				$output .= '<li class="vimeo">';
				$output .= '<a href="'.$vimeo_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($tumblr_link <> ''){
				$output .= '<li class="tumblr">';
				$output .= '<a href="'.$tumblr_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($wordpress_link <> ''){
				$output .= '<li class="wordpress">';
				$output .= '<a href="'.$wordpress_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($rss_link <> ''){
				$output .= '<li class="rss">';
				$output .= '<a href="'.$rss_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($google_link <> ''){
				$output .= '<li class="google">';
				$output .= '<a href="'.$google_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($flickr_link <> ''){
				$output .= '<li class="flickr">';
				$output .= '<a href="'.$flickr_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($linkedin_link <> ''){
				$output .= '<li class="linkedin">';
				$output .= '<a href="'.$linkedin_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($skype_link <> ''){
				$output .= '<li class="skype">';
				$output .= '<a href="'.$skype_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			if($dropbox_link <> ''){
				$output .= '<li class="dropbox">';
				$output .= '<a href="'.$dropbox_link.'" target="_blank"></a>';
				$output .= '</li>';	
			}
			$output .= '</ul>'; 
		}
		else{
			$output .= '<em>'.__('Shortcode requires zoo theme options','zoo-shortcodes').'</em>';
		}
		return $output;
	}
	add_shortcode( 'social_networks', 'social_networks' );
}	

/*-----------------------------------------------------------------------------------*/
/*	Flex Slider Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('flex_slider')) {
	function flex_slider($atts) {
		$output = '';
		global $post;
		extract( shortcode_atts( array(
			'cat' => '',
		), $atts ) );
	  	$default = array(
		    'type'      => 'flex_slider',
		    'limit' => '100',
	  	);
	  	$r = shortcode_atts( $default, $atts );
	  	extract( $r );
	  	if( empty($post_type) ){
		    $post_type = $type;
			$post_type_ob = get_post_type_object( $post_type );
		}	
		if( !$post_type_ob ){
			return '<div class="warning"><p>'.__('No such post type found.', 'zoo-shortcodes').'</p></div>';
		}	
		$args = array(
			'post_type'   => $post_type,
		   	'flex_slider_category' => $cat,
		   	'numberposts' => $limit,
		   	'suppress_filters' => false
		);
		$posts = get_posts( $args );
		$category = get_the_category();
		if( count($posts) ):
			$output .= '<div class="flexslider" id="flexslider_'. $cat .'">';
			$output .= '<ul class="slides">';
		    foreach( $posts as $post ): setup_postdata( $post );
	    	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	        $output .= '<li>';
		    $output .=	get_the_post_thumbnail() ;
			$output .= '<div class="flexslide-caption">'.do_shortcode( get_the_content() ).'</div>';	
		    $output .= '</li>';
		    endforeach; wp_reset_postdata();
		    $output .= '</ul></div>';
		  else :
		    $output .= '<p>'.__('No posts found.','zoo-shortcodes').'</p>';
		  endif;
		return $output;
	}
	add_shortcode( 'flex_slider', 'flex_slider' );
}
/*-----------------------------------------------------------------------------------*/
/*	Superslides Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('super_slides')) {
	function super_slides ($atts) {
		$output = '';
		global $post;
		$default = array(
			'type'      => 'super_slider',
			'limit' => '100'
		  );
		
		$r = shortcode_atts( $default, $atts );
		extract( $r );
		if( empty($post_type) ){
			$post_type = $type;
			$post_type_ob = get_post_type_object( $post_type );
		}	
		if( !$post_type_ob ){
			return '<div class="warning"><p>'.__('No such post type found.', 'zoo-shortcodes').'</p></div>';
		}	
		$args = array(
			'post_type'   => $post_type,
			'numberposts' => $limit,
			'suppress_filters' => false
		);
		$posts = get_posts( $args );
		if( count($posts) ):
			$output .= '<div id="superslider_loading"></div>';
			$output .= '<div id="superslider_home">';
			$output .= '<nav class="slides-navigation">
		      			<a href="#" class="next">Next</a>
		      			<a href="#" class="prev">Previous</a>
		   			 </nav>';
			$output .= '<ul class="slides-container">';
		
		    foreach( $posts as $post ): setup_postdata( $post );
		    $animation = get_post_meta( $post->ID, '_cmb_caption_animation', true );
	    	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
			$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	      	$output .= '<li>';

		 	$output .= '<img src="'.$url.'" data-0="top:0px;" data-1500="top:650px;"/>';
		    $output .= '<div class="slide-caption" '.$animation.' >';

		    $output .= 	do_shortcode( get_the_content() );
		    $output .= '</div>';
		    $output .= '</li>';
		    endforeach; wp_reset_postdata();
		    $output .= '</ul></div>';
		  else :
		    $output .= '<p>'.__('No posts found.','zoo-shortcodes').'</p>';
		  endif;
	return $output;
	}
	add_shortcode( 'super_slides', 'super_slides' );
}
/*-----------------------------------------------------------------------------------*/
/*	Portfolio Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('portfolio')) {
	function portfolio($atts){
		global $post;
		$output = '';
	  	$default = array(
		    'type'      => 'portfolios',
		    'limit' => '100'

		);
	  	$r = shortcode_atts( $default, $atts );
	  	extract( $r );
	  	if( empty($post_type) ){
	    	$post_type = $type;
			$post_type_ob = get_post_type_object( $post_type );
		}	  
	  	if( !$post_type_ob ){
	    	return '<div class="warning"><p>'.__('No such post type found.', 'zoo-shortcodes').'</em> found.</p></div>';
	 	}
 	  	$args = array(
		    'post_type'   => $post_type,
	    	'numberposts' => $limit,
	    	'suppress_filters' => false

	  	);
		$posts = get_posts( $args );
	  	$category = get_the_category();
		if( count($posts) ):
			$output .= '<div class="c12 end"><ul class="portfolio-nav">';
			$output .= '<li class="filter" data-filter="all">All</li>';
			$categories = get_categories(array('taxonomy' => 'portfolio_item_category'));
			foreach ($categories as $category) {
				$output .= '<li class="filter" data-filter="'. preg_replace('/\s+/', '', $category->cat_name) .'">';
				$output .= $category->cat_name;
				$output .= '</li>';
			}

			$output .= '</ul></div><div class="c12 end">';
			$output .= '<ul id="portfolioinner">';
			foreach( $posts as $post ): setup_postdata( $post );
			$terms = get_the_terms( $post->ID, 'portfolio_item_category' );
			if ( $terms && ! is_wp_error( $terms ) ) : 
				$portfolio_links = array();
			foreach ( $terms as $term ) {
				$portfolio_links[] = preg_replace('/\s+/', '', $term->name);
			}
			$portfolio_item_category = join( " ", $portfolio_links );

			endif;
	    	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	 		$output .= '<li class="mix ' .$portfolio_item_category. '">';       
		    $output .= '<figure class="rift">' ; 
		    $output .= get_the_post_thumbnail($post->ID, 'portfolioThumbCropped') ;
		    $output .= '<figcaption class="caption"><a class="box" href="'.get_permalink(get_the_ID()).'" >'.get_the_title().'</a></figcaption>';
		    $output .= '</figure>' ; 
		    $output .= '</li>';   
		    endforeach; wp_reset_postdata();
		    $output .= '</ul></div>';
		else :
	    	$output .= '<p>'.__('No posts found.','zoo-shortcodes').'</p>';
	  	endif;
	 	return $output;
	}
	add_shortcode( 'portfolio', 'portfolio' );
}

/*-----------------------------------------------------------------------------------*/
/*	Parallax Section Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('parallax_section')) {
	function parallax_section ($atts, $content = null) {
		$output = '';
		$atts = shortcode_atts(
			array(
				'background' => '',
			), $atts);	
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="parallaxSection" style="background-image:url('.$atts['background'].');" data-bottom-top="background-position: 50% 300px" data-top-bottom="background-position: 50% -250px;" >';
		$output .= '<div>';
		$output .= do_shortcode($content);
		return $output;
	}
	add_shortcode( 'parallax_section', 'parallax_section' );
}

/*-----------------------------------------------------------------------------------*/
/*	Colored Parallax Section Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colored_parallax_section')) {
	function colored_parallax_section ($atts, $content = null) {
		$output = '';
		$atts = shortcode_atts(
			array(
				'background' => '',
				'start'  => '',
				'end'  => '',

			), $atts);	
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="color-parallax-container" data-bottom-top="background-color:'.$atts['start'].';" data-top-bottom="background-color:'.$atts['end'].'" style="background-color:'.$atts['start'].';">';
		$output .= '<div class="color-parallax-content">';
		$output .= do_shortcode($content);
		$output .= '</div>';
		$output .= '<div class="parallaxSection color-parallax-background" style="background-image:url('.$atts['background'].');" data-bottom-top="background-position: 50% -350px" data-top-bottom="background-position: 50% 200px;" >';

		return $output;
	}
	add_shortcode( 'colored_parallax_section', 'colored_parallax_section' );
}
/*-----------------------------------------------------------------------------------*/
/*	Parallax Background Shortcode
/*-----------------------------------------------------------------------------------*/
if (!function_exists('parallax_background')) {
function parallax_background ($atts, $content = null) {
	$output = '';
	$atts = shortcode_atts(
		array(
			'background' => ''
		), $atts);	
	$output .= '</div>';
	$output .= '<div class="parallaxBackground" style="background-image:url('.$atts['background'].');" >';
	$output .= '<div class ="grid">'.do_shortcode($content).'</div>';
	return $output;
}
add_shortcode( 'parallax_background', 'parallax_background' );
}

/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/
if (!function_exists('tabbed_page')) {
	function tabbed_page( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		STATIC $i = 0;
		$i++;
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
			$output .= '<div class="c12 end">';
			$output .= '<ul class="tabs">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= '</div>';
		    $output .= do_shortcode( $content );
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'tabbed_page', 'tabbed_page' );
}
if (!function_exists('tabbed_page_tab')) {
	function tabbed_page_tab( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		return '<div id="'. sanitize_title( $title ) .'" class="tabcontent">'. do_shortcode( $content ) .'<div class="clearfix"></div></div>';
	}
	add_shortcode( 'tabbed_page_tab', 'tabbed_page_tab' );
}

/*-----------------------------------------------------------------------------------*/
/*	Google Map Shortcode
/*-----------------------------------------------------------------------------------*/

if (! function_exists( 'google_map' ) ){
	function google_map($atts, $content = null) {
		global $Zoo_Options;
		extract(shortcode_atts(array(
				'title'		=> '',
				'location'	=> '',
				'height'	=> '350',
				'zoom'		=> 8,
				'class'		=> '',
		), $atts));
		$output = '<div id="map_canvas_'.rand(1, 100).'" class="googlemap '. $class .'" style="height:'.$height.'px;width:100%">';
			$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
			$output .= '<input class="location" type="hidden" value="'.$location.'" />';
			$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
			if (isset($Zoo_Options)){
				$output .= '<input class="hue" type="hidden" value="'.$Zoo_Options->get('39').'" />';
				$output .= '<input class="saturation" type="hidden" value="'.$Zoo_Options->get('40').'" />';
				$output .= '<input class="lightness" type="hidden" value="'.$Zoo_Options->get('42').'" />';
				$output .= '<input class="iconLink" type="hidden" value="'.$Zoo_Options->get('41').'" />';
			}	
			$output .= '<div class="map_canvas"></div>';
		$output .= '</div>';
		return $output;
	}
	add_shortcode("google_map", "google_map");
}

/*-----------------------------------------------------------------------------------*/
/*	Testimonials Shortcodes
/*-----------------------------------------------------------------------------------*/
if (! function_exists( 'testimonials_slider' ) ){
	function testimonials_slider( $atts, $content = null ) {
	    $output  =  '<div id="testimonials" class="flexslider">';
	    $output .=  '<ul class="slides">';
	    $output .=  do_shortcode($content);
	    $output .=  '</ul></div>';
	    return $output;
	}
	add_shortcode( 'testimonials_slider', 'testimonials_slider' ); 
}
if (! function_exists( 'testimonial' ) ){
	function testimonial( $atts, $content = null ) {
	    extract( shortcode_atts( array(
	    'image' => '',
	    'name' => '',
	    'company' => '',
	    ), $atts )
	    );
	    $output  = '<li>';
	    $output  .= '<div class="flex-caption">';
	    $output  .= '<blockquote>';
		if($atts['image']){
			$output  .= '<span class="testimonial-avatar" style="background:url('.$atts['image'].') no-repeat center center;"></span>';
		}
		$output  .= '<p>'.do_shortcode($content).'</p>';
		$output  .= '<cite>'.$atts['name'].'<span>'.$atts['company'].'</span></cite>';
	    $output  .= '</blockquote>';
	    $output  .= '</div>';
	    $output  .= '</li>';
	    return $output; 
	}
	add_shortcode( 'testimonial', 'testimonial' );
}

/*-----------------------------------------------------------------------------------*/
/*	Remove Auto <p> tags from shortcodes
/*-----------------------------------------------------------------------------------*/
function wpex_clean_shortcodes($content){   
$array = array (
    '<p>[' => '[', 
    ']</p>' => ']', 
    ']<br />' => ']'
);
$content = strtr($content, $array);
return $content;
}
add_filter('the_content', 'wpex_clean_shortcodes');





/*-----------------------------------------------------------------------------------*/
/*	Video Slide
/*-----------------------------------------------------------------------------------*/
if (! function_exists( 'video_slide' ) ){
	function video_slide( $atts, $content = null ) {
	    extract( shortcode_atts( array(
	    'type' => '',
	    'url' => '',
	    ), $atts )
	    );
	    $output  = '<div class="videobg" style="position:relative; z-index: -99; width: 100%; height: 100%" data-0="top:0px;" data-1500="top:650px;">';

		if($atts['type'] == 'local'){
			$output  .= '<video class="video" src="'.$atts['url'].'" loop ></video>';
		}
		if ($atts['type'] == 'youtube'){
			$output .= '<div class="youtubeplayer"></div>';
			$output .= '<input class="tubelink" type="hidden" value="'.$atts['url'].'" />';
		}
		if ($atts['type'] == 'vimeo'){
			$output  .= '<iframe class ="vimeoplayer" src="'.$atts['url'].'?player_id=vimeoplayer " width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}

	    $output  .= '</div>';
	    return $output; 
	}
	add_shortcode( 'video_slide', 'video_slide' );
}


