<?php

if ( ! function_exists( '_s_setup' ) ) :

if ( ! isset( $content_width ) ) $content_width = 1170;

function _s_setup() {


    load_theme_textdomain( 'zoo', get_template_directory() . '/languages' );

    require( get_template_directory() . '/inc/template-tags.php' );

    require_once (get_template_directory() . '/inc/dimox-breadcrumbs.php');

    require_once(get_template_directory() .'/options.php');

    require_once (get_template_directory() . '/inc/class-tgm-plugin-activation.php');

    require_once (get_template_directory() . '/inc/metabox-functions.php');

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-thumbnails' );

    add_image_size('portfolioThumbCropped', 300, 300, true);

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'zoo' ),
    ) );
    
}

endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );



function _s_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Sidebar', 'zoo' ),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h6 class="widget-title">',
        'after_title' => '</h6>',
    ) );
}
add_action( 'widgets_init', '_s_widgets_init' );

function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');

function _s_style() { 
    wp_enqueue_style( 'style', get_stylesheet_uri(), array( 'normalize' ) );
    wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );      
    
    global $Zoo_Options;
    
    $font_on = $Zoo_Options->get('zo_fonton');
    $body_font = $Zoo_Options->get('zo_body_font');
    $body_font  = str_replace("+", " ", $body_font);
    $body_font  = explode(":", $body_font);
    $body_font  = $body_font[0];

    $heading_1 = $Zoo_Options->get('zo_heading1_font');
    $heading_1  = str_replace("+", " ", $heading_1);
    $heading_1  = explode(":", $heading_1);
    $heading_1  = $heading_1[0];

    $heading_226 = $Zoo_Options->get('zo_heading226_font');
    $heading_226  = str_replace("+", " ", $heading_226);
    $heading_226  = explode(":", $heading_226);
    $heading_226  = $heading_226[0];

    $pagedesc_font = $Zoo_Options->get('zo_pagedesc_font');
    $pagedesc_font  = str_replace("+", " ", $pagedesc_font);
    $pagedesc_font  = explode(":", $pagedesc_font);
    $pagedesc_font  = $pagedesc_font[0];

    $accent_font = $Zoo_Options->get('zo_accent_font');
    $accent_font  = str_replace("+", " ", $accent_font);
    $accent_font  = explode(":", $accent_font);
    $accent_font  = $accent_font[0];    
    ob_start();
    ?>

    #active-bar, .slides-navigation a.prev:hover, .flex-direction-nav .flex-prev:hover, .slides-navigation a.next:hover,  .flex-direction-nav .flex-next:hover, .mfp-close:hover, .mfp-arrow-left:hover, .mfp-arrow-right:hover, button, input[type=submit], .button, .recent-post-img, span.date {
        background-color:<?php $Zoo_Options->show('zo_main_color'); ?>;
    }
    .tabs li a:hover, .portfolio-nav li:hover, .mainnav a:hover, .colored, a:hover, #secondary aside a:hover, input[type=submit]:hover{
        color:<?php $Zoo_Options->show('zo_main_color'); ?>;
    }    
    input[type=submit]:hover, button, input[type=submit], blockquote, .bypostauthor > article .avatar, .button{
        border-color:<?php $Zoo_Options->show('zo_main_color'); ?>;
    }
    .mainnav, .mainnav ul > li > ul > li{ background-color:<?php $Zoo_Options->show('zo_nav_color'); ?>;}
    #topbar{ background-color:<?php $Zoo_Options->show('zo_nav_border_color'); ?>;}
    .rift .caption a{ background-color:<?php $Zoo_Options->show('zo_portfolio_hover_color'); ?>;}
    .footer{ background-color:<?php $Zoo_Options->show('zo_footer_color'); ?>;}
    .loadernav{background-color:<?php $Zoo_Options->show('zo_portfolio_single_nav_color'); ?>;}
    .mfp-container{background-color:<?php $Zoo_Options->show('zo_portfolio_single_background_color'); ?>;}

    <?php 
    
    if($font_on == 'yes'){?>
        body{ font-family:<?php echo $body_font ;?>;}
        h1,.zoo-page-title{ font-family:<?php echo $heading_1 ; ?>;}
        h2,h3,h4,h5,h6{ font-family:<?php echo $heading_226 ; ?>;}
        .accent{font-family:<?php echo $accent_font ?>;}
        .zoo-page-title{font-family:<?php echo $pagedesc_font ?>;}
    <?php }
    else{ ?>
        h1,.zoo-page-title{font-family: latoBlack, sans-serif; font-weight: normal;}
        h2,h3,h4,h5,h6, body{font-family: latoRegular, sans-serif; font-weight: normal;}
        .accent{ font-family: LatoLight, sans-serif;}
        .zoo-page-title span{font-family:serif; font-style: italic;}
    <?php    
    }
    ?>
    
    body{background-color:<?php $Zoo_Options->show('zo_body_background_color'); ?>;font-size: <?php $Zoo_Options->show('zo_body_font_size'); ?>px; color:<?php $Zoo_Options->show('zo_body_font_color'); ?>;}
    .mainnav ul > li > a{ font-size: <?php $Zoo_Options->show('zo_main_nav_font_size'); ?>px; }
    .tabs li a, .portfolio-nav li{ font-size: <?php $Zoo_Options->show('zo_secodary_nav_font_size'); ?>px; }
    #nav-above a, #crumbs a, #crumbs .current{ font-size: <?php $Zoo_Options->show('zo_breadcrumbs_nav_font_size'); ?>px; }
    h1, .alpha { font-size: <?php $Zoo_Options->show('zo_h1_font_size'); ?>px; }
    h2, .beta { font-size: <?php $Zoo_Options->show('zo_h2_font_size'); ?>px; }
    h3, .gamma { font-size: <?php $Zoo_Options->show('zo_h3_font_size'); ?>px; }
    h4, .delta { font-size: <?php $Zoo_Options->show('zo_h4_font_size'); ?>px; }
    h5, .epsilon { font-size: <?php $Zoo_Options->show('zo_h5_font_size'); ?>px; }
    h6, .zeta { font-size: <?php $Zoo_Options->show('zo_h6_font_size'); ?>px; }
    .mega { font-size: <?php $Zoo_Options->show('zo_mega_font_size'); ?>px; }
    .giga { font-size: <?php $Zoo_Options->show('zo_giga_font_size'); ?>px; }
    .tera { font-size: <?php $Zoo_Options->show('zo_tera_font_size'); ?>px; }
    .accent{ letter-spacing: <?php $Zoo_Options->show('zo_accent_spacing'); ?>px; }

    h1,h2,h3,h4,h5,h6{color:<?php $Zoo_Options->show('zo_heading_font_color'); ?>;}
    a{color:<?php $Zoo_Options->show('zo_link_color'); ?>;}
    .mainnav a{color:<?php $Zoo_Options->show('zo_main_nav_font_color'); ?>;}
    .nav-active > a{color: <?php $Zoo_Options->show('zo_main_nav_active_font_color'); ?> !important;}
    .tabs li a, .portfolio-nav li{color:<?php $Zoo_Options->show('zo_secondary_nav_font_color'); ?>;}
    .active{background-color: <?php $Zoo_Options->show('zo_secondary_nav_active_font_color'); ?> !important;}
    .footer small{color:<?php $Zoo_Options->show('zo_copyrighttext_color'); ?>;}
    <?php 
    $sidebar_pos = $Zoo_Options->get('zo_blog_sidebar');
    if($sidebar_pos == 1){ ?>
        .site-content{ width: 100%;float: left;}
        <?php
    }
    else if($sidebar_pos == 2){ ?>
        .site-content{ width: 75%;float: right;}
        <?php
    }
    else{ ?>
        .site-content{ width: 75%;float: left;}
        <?php
    }
    ?>
    <?php $Zoo_Options->show('zo_custom_css'); ?>
    @media handheld, only screen and (max-width: 768px), only screen and (max-device-width: 768px){
        .tera, .mega, .giga { font-size: <?php $Zoo_Options->show('zo_h1_font_size'); ?>px; }
    }
    @media handheld, only screen and (max-width: 568px), only screen and (max-device-width: 568px){
        h1{ font-size: <?php $Zoo_Options->show('zo_h2_font_size'); ?>px; }
        h2{ font-size: <?php $Zoo_Options->show('zo_h3_font_size'); ?>px; }
        
    }
        
    <?php
    $custom_css = ob_get_contents();
    ob_end_clean();
    
    wp_add_inline_style( 'style', $custom_css );     
}

function _s_scripts() {
    wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js');
    wp_enqueue_script( 'plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), 'version', true );
    wp_enqueue_script( 'script', get_template_directory_uri() . '/js/script.js', array( 'jquery' , 'plugins' ), 'version', true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply',array( 'jquery' , 'plugins' ), 'version', true);
    }
     
}
function html5_scripts() {
      if (preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])){
        wp_enqueue_script( 'html5shim', get_template_directory_uri() . '/js/html5.js"' );
    }      
}

add_action( 'wp_enqueue_scripts', '_s_style' );
add_action( 'wp_enqueue_scripts', '_s_scripts' );
add_action( 'wp_enqueue_scripts', 'html5_scripts', 0 );


function zoo_fonts() {
    global $Zoo_Options;
    $font_on = $Zoo_Options->get('zo_fonton');
    $protocol = is_ssl() ? 'https' : 'http';
    
    $body_font = $Zoo_Options->get('zo_body_font');
    $body_font  = str_replace("+", " ", $body_font);
    $body_font  = explode(":", $body_font);
    $body_font  = $body_font[0];

    $heading_1 = $Zoo_Options->get('zo_heading1_font');
    $heading_1  = str_replace("+", " ", $heading_1);
    $heading_1  = explode(":", $heading_1);
    $heading_1  = $heading_1[0];

    $heading_226 = $Zoo_Options->get('zo_heading226_font');
    $heading_226  = str_replace("+", " ", $heading_226);
    $heading_226  = explode(":", $heading_226);
    $heading_226  = $heading_226[0];

    $pagedesc_font = $Zoo_Options->get('zo_pagedesc_font');
    $pagedesc_font  = str_replace("+", " ", $pagedesc_font);
    $pagedesc_font  = explode(":", $pagedesc_font);
    $pagedesc_font  = $pagedesc_font[0];

    $accent_font = $Zoo_Options->get('zo_accent_font');
    $accent_font  = str_replace("+", " ", $accent_font);
    $accent_font  = explode(":", $accent_font);
    $accent_font  = $accent_font[0];

    

    if(!empty($body_font) && $font_on == 'yes'){
        wp_enqueue_style( 'zoo-bodyfont', "$protocol://fonts.googleapis.com/css?family=$body_font" );
    } 
    if(!empty($heading_1) && $font_on == 'yes' && $heading_1 != $body_font){
        wp_enqueue_style( 'zoo-headingonefont', "$protocol://fonts.googleapis.com/css?family=$heading_1" ); 
    } 
    if(!empty($heading_226) && $font_on == 'yes' && $heading_226 != $body_font && $heading_226 != $heading_1){ 
        wp_enqueue_style( 'zoo-headingfont', "$protocol://fonts.googleapis.com/css?family=$heading_226" );
    }
    if(!empty($accent_font) && $font_on == 'yes' && $accent_font != $body_font && $accent_font != $heading_1 && $accent_font != $heading_226){ 
        wp_enqueue_style( 'zoo-accentfont', "$protocol://fonts.googleapis.com/css?family=$accent_font" );
    }
    if(!empty($pagedesc_font) && $font_on == 'yes' && $pagedesc_font != $body_font && $pagedesc_font != $heading_1 && $pagedesc_font != $heading_226 && $pagedesc_font != $accent_font){ 
        wp_enqueue_style( 'zoo-descfont', "$protocol://fonts.googleapis.com/css?family=$pagedesc_font" );
    }
    
}
add_action( 'wp_enqueue_scripts', 'zoo_fonts' );




function get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}

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


if(! class_exists( 'single_page_walker' )):
    class single_page_walker extends Walker_Nav_Menu{      
     
        function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0){
            global $wp_query;     

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $class_names = $value = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            
            if( in_array('current-menu-item', $classes) ){
                $class_names .= ' nav-active ';
                $_SESSION['get_current_object_id'] = $item->object_id;

            }   
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        
            
            $ancestor = get_post_ancestors( $item->object_id );
            
            $do_page_section = false;
            $root_parent_id = $item->object_id;
            if(count($ancestor) > 0) {
                $root_parent_id = end($ancestor);
                reset($ancestor);            
            }

            if("single-page.php" == get_page_template_slug($root_parent_id)) $do_page_section = true;
            
            if( $do_page_section && count($ancestor) > 0 ) {
                if( isset($_SESSION['get_current_object_id']) && $_SESSION['get_current_object_id'] == $ancestor[0]) 
                    $class_names .= ' active-children';
                     
                $class_names .= ' page-section'; 
                $link = get_permalink($ancestor[0]);
                                         
                $varpost = get_post($item->object_id);
                $trailing_slash = preg_match('/\/$/', $link ) ? '' : '/' ;  
                $link_id = $trailing_slash . '#'.preg_replace('/\s+/', '', $varpost->post_title );                  
                $attributes .= ' href="'. $link . $link_id . ' "';      
            
            }        
            if( $do_page_section && !$item->menu_item_parent)
            {
                $class_names = ' class="'. esc_attr( $class_names ) . '"';
                $output .=  '<li'. $class_names .'>';
                $varpost = get_post($item->object_id);
                
                $trailing_slash = preg_match('/\/$/', $item->url ) ? '' : '/' ;  
                $link_id = $trailing_slash . '#'.preg_replace('/\s+/', '', $varpost->post_title );
                $attributes .= ' href="'. esc_attr( $item->url) .$link_id. '" ';
             
            }
            else{
                $class_names = ' class="'. esc_attr( $class_names ) . '"';
                $output .=  '<li'. $class_names .'>';
                $attributes .= ! empty( $item->url ) ? ' href="'. esc_attr( $item->url ) .'"' : ''; 
                
            }
                        
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
endif;

if(! class_exists( 'Custom_Walker_Page' )): 
    class Custom_Walker_Page extends Walker_Page {
        function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
            if ( $depth )
                $indent = str_repeat("\t", $depth);
            else
                $indent = '';

            extract($args, EXTR_SKIP);
            $css_class = array('page_item', 'page-item-'.$page->ID);

            if( isset( $args['pages_with_children'][ $page->ID ] ) )
                $css_class[] = 'page_item_has_children';

            if ( !empty($current_page) ) {
                $_current_page = get_post( $current_page );
                if ( in_array( $page->ID, $_current_page->ancestors ) )
                    $css_class[] = 'current_page_ancestor';
                if ( $page->ID == $current_page ){
                    $css_class[] = 'current_page_item';
                    $_SESSION['get_current_page_id'] = $page->ID;
                }                    
                elseif ( $_current_page && $page->ID == $_current_page->post_parent )
                    $css_class[] = 'current_page_parent';
            } elseif ( $page->ID == get_option('page_for_posts') ) {
                $css_class[] = 'current_page_parent';
            }

            
            $permalink = get_permalink($page->ID);
            $do_page_section = false;
            $link_id = '';
            
            $ancestor = get_post_ancestors( $page->ID );
            $root_parent_id =  $page->ID;
            if(count($ancestor) > 0) {
                $root_parent_id = end($ancestor);
                reset($ancestor);            
            }        

            if("single-page.php" == get_page_template_slug($root_parent_id)) {
                if(!empty($page->post_parent)) {
                    if(isset($_SESSION['get_current_page_id']) && $_SESSION['get_current_page_id'] == $root_parent_id)
                        $css_class[] = ' active-children';    
                    
                    $css_class[] = ' page-section';    
                    $page_id = $page->post_parent;
                }
                else{
                  $page_id = $page->ID; 
                }
                                
                $permalink = get_permalink( $page_id );         
                $trailing_slash = preg_match('/\/$/', $permalink ) ? '' : '/' ;            
                $link_id = $trailing_slash . '#'.preg_replace('/\s+/', '', $page->post_title );                                                             
            }
                        
            $css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

            if ( '' === $page->post_title )
                $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );

            /** This filter is documented in wp-includes/post-template.php */
            $output .= $indent . '<li class="' . $css_class . '"><a href="' . $permalink . $link_id . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

            if ( !empty($show_date) ) {
                if ( 'modified' == $show_date )
                    $time = $page->post_modified;
                else
                    $time = $page->post_date;

                $output .= " " . mysql2date($date_format, $time);
            }
        }    
    }
endif;

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {
    $plugins = array(
        array(
            'name'                     => 'Zoo Shortcodes', // The plugin name
            'slug'                     => 'zoo-shortcodes', // The plugin slug (typically the folder name)
            'source'                   => get_template_directory() . '/inc/zoo-shortcodes.zip', // The plugin source
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
            'version'                 => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'is_automatic'            => true,            
            'force_activation'         => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'     => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'             => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'                     => 'Zoo Custom Posts', // The plugin name
            'slug'                     => 'zoo-custom-posts', // The plugin slug (typically the folder name)
            'source'                   => get_template_directory() . '/inc/zoo-custom-posts.zip', // The plugin source
            'required'                 => true, // If false, the plugin is only 'recommended' instead of required
            'version'                 => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'is_automatic'            => true,        
            'force_activation'         => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'     => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'             => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'         => 'Contact Form 7',
            'slug'         => 'contact-form-7',
            'required'     => false,
        ),
        array(
            'name'         => 'Simple Page Ordering',
            'slug'         => 'simple-page-ordering',
            'required'     => false,
        ),

    );
    $theme_text_domain = 'zoo';
    $config = array(
        'domain'               => $theme_text_domain,             // Text domain - likely want to be the same as your theme.
        'default_path'         => '',                             // Default absolute path to pre-packaged plugins
        'parent_menu_slug'     => 'themes.php',                 // Default parent menu slug
        'parent_url_slug'     => 'themes.php',                 // Default parent URL slug
        'menu'                 => 'install-required-plugins',     // Menu slug
        'has_notices'          => true,                           // Show admin notices or not
        'is_automatic'        => false,                           // Automatically activate plugins after installation or not
        'message'             => '',                            // Message to output right before the plugins table
        'strings'              => array(
            'page_title'                                   => __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'                                   => __( 'Install Plugins', $theme_text_domain ),
            'installing'                                   => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'                                         => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'                 => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                      => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'                => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'            => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                     => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                         => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                         => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                                   => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                               => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                       => __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'                             => __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete'                                     => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
            'nag_type'                                    => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );
    tgmpa( $plugins, $config );
}


// Default menu callback when no menu selected to the theme location
function default_menu_cb(){
    echo '<ul class="nav-links">';
    echo wp_list_pages(
        array(
            'title_li' => '',   
            'walker' => new Custom_Walker_Page
        )
    );
    echo '</ul>';
}