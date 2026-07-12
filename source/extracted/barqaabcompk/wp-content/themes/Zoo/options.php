<?php
/*
 *
 * Set the text domain for the theme or plugin.
 *
 */
define('Zoo_TEXT_DOMAIN', 'zoo');

/*
 *
 * Require the framework class before doing anything else, so we can use the defined URLs and directories.
 * If you are running on Windows you may have URL problems which can be fixed by defining the framework url first.
 *
 */
//define('Zoo_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('Zoo_Options')){
    require_once(dirname(__FILE__) . '/options/defaults.php');
}

/*
 *
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', Zoo_TEXT_DOMAIN),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', Zoo_TEXT_DOMAIN),
		'icon' => 'paper-clip',
		'icon_class' => 'icon-large',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
//add_filter('zoo-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
    //$args['dev_mode'] = false;
    
    return $args;
}
//add_filter('zoo-opts-args-twenty_eleven', 'change_framework_args');


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options(){
    $args = array();

    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['dev_mode_icon_class'] = 'icon-large';

    // If you want to use Google Webfonts, you MUST define the api key.
    $args['google_api_key'] = 'AIzaSyBC06MPjQ3ZfCuYAPEcW6y0XSWfEMK3wPs';

    // Define the starting tab for the option panel.
    // Default: '0';
    //$args['last_tab'] = '0';

    // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
    // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
    // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
    // Default: 'standard'
    //$args['admin_stylesheet'] = 'standard';

    // Add HTML before the form.
    //$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', Zoo_TEXT_DOMAIN);

    // Add content after the form.
   // $args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', Zoo_TEXT_DOMAIN);

    // Set footer/credit line.
    //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', Zoo_TEXT_DOMAIN);

    // Setup custom links in the footer for share icons
    /*$args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/ghost1227',
        'title' => 'Follow me on Twitter', 
        'img' => Zoo_OPTIONS_URL . 'img/social/Twitter.png'
    );
    $args['share_icons']['linked_in'] = array(
        'link' => 'http://www.linkedin.com/profile/view?id=52559281',
        'title' => 'Find me on LinkedIn', 
        'img' => Zoo_OPTIONS_URL . 'img/social/LinkedIn.png'
    );*/

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = 'twenty_eleven2';

    // Set a custom menu icon.
    //$args['menu_icon'] = '';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Theme Options', Zoo_TEXT_DOMAIN);

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Theme Options', Zoo_TEXT_DOMAIN);

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: zoo_options
    $args['page_slug'] = 'theme_options';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    //$args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options_general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    //$args['page_position'] = null;

    // Set a custom page icon class (used to override the page icon next to heading)
    //$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Zoo no longer ships with standard icons!
	// Default: iconfont
	$args['icon_type'] = 'iconfont';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
   /* $args['help_tabs'][] = array(
        'id' => 'zoo-opts-1',
        'title' => __('Theme Information 1', Zoo_TEXT_DOMAIN),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', Zoo_TEXT_DOMAIN)
    );
    $args['help_tabs'][] = array(
        'id' => 'zoo-opts-2',
        'title' => __('Theme Information 2', Zoo_TEXT_DOMAIN),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', Zoo_TEXT_DOMAIN)
    );*/

    // Set the help sidebar for the options page.                                        
   // $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', Zoo_TEXT_DOMAIN);

    $sections = array();

   /* $sections[] = array(
		// Zoo uses the Font Awesome iconfont to supply its default icons.
		// If $args['icon_type'] = 'iconfont', this should be the icon name minus 'icon-'.
		// If $args['icon_type'] = 'image', this should be the path to the icon.
		'icon' => 'paper-clip',
		// Set the class for this icon.
		// This field is ignored unless $args['icon_type'] = 'iconfont'
		'icon_class' => 'icon-large',
        'title' => __('Getting Started', Zoo_TEXT_DOMAIN),
		'desc' => __('<p class="description">This is the description field for this section. HTML is allowed</p>', Zoo_TEXT_DOMAIN),
        // Lets leave this as a blank section, no options just some intro text set above.
        //'fields' => array()
    );*/

    $sections[] = array(
		'icon' => 'wrench',
		'icon_class' => 'icon-large',
        'title' => __('General', Zoo_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => '1', // The item ID must be unique
                'type' => 'upload', // Built-in field types include:
                // text, textarea, editor, checkbox, multi_checkbox, radio, radio_img, button_set,
                // select, multi_select, color, date, divide, info, upload
                'title' => __('Logo', Zoo_TEXT_DOMAIN),
                'sub_desc' => __('Upload your logo', Zoo_TEXT_DOMAIN),
                'std' => get_template_directory_uri().'/images/logo.png'
                //'validate' => '', // Built-in validation includes: 
                //  email, html, html_custom, no_html, js, numeric, comma_numeric, url, str_replace, preg_replace
                //'msg' => 'custom error message', // Override the default validation error message for specific fields
                //'std' => '', // This is the default value and is used to set an option on theme activation.
                //'class' => '' // Set custom classes for elements if you want to do something a little different
                //'rows' => '6' // Set the number of rows shown for the textarea. Default: 6
			),
            array(
                'id' => 'zo_favicon', 
                'type' => 'upload', 
                'title' => __('Favicon', Zoo_TEXT_DOMAIN),
                'sub_desc' => __('Upload your favicon ( .ico format 16px 16px )', Zoo_TEXT_DOMAIN),
                'std' => get_template_directory_uri().'/images/favicon.ico'
            ),
            array(
                'id' => 'zo_blog_sidebar',
                'type' => 'radio_img',
                'title' => __('Blog Layout', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Select the layout for blog pages', Zoo_TEXT_DOMAIN),
                'options' => array(
                    '1' => array('title' => 'Full Width', 'img' => Zoo_OPTIONS_URL . 'img/1col.png'),
                    '2' => array('title' => 'Sidebar Left', 'img' => Zoo_OPTIONS_URL . 'img/2cl.png'),
                    '3' => array('title' => 'Sidebar Right', 'img' => Zoo_OPTIONS_URL . 'img/2cr.png')
                ), 
                'std' => '3'
            ),
            array(
                'id' => 'zo_footer_logo', 
                'type' => 'upload', 
                'title' => __('Footer Logo', Zoo_TEXT_DOMAIN),
                'sub_desc' => __('Upload logo to be displayed in the footer', Zoo_TEXT_DOMAIN),
                'std' => get_template_directory_uri().'/images/footer_logo.png'
            ),
            array(
                'id' => 'zo_copyright_text',
                'type' => 'text',
                'title' => __('Footer Copyright Text', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter the copright text to be displayed in the footer', Zoo_TEXT_DOMAIN),
                'std' => 'Copyright 2013, Example Corporation'
            ),
            array(
                'id' => 'zo_footer_social_icons',
                'type' => 'checkbox',
                'switch' => true,
                'title' => __('Social Network Icons In Footer', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('<p class="description">Turn the footer social network icons display on or off</p>', Zoo_TEXT_DOMAIN),
                'std' => '1',
            ),  
           
        )
    );
    
 

    $sections[] = array(
		'icon' => 'font',
		'icon_class' => 'icon-large',
        'title' => __('Typography', Zoo_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => 'zo_fonton',
                'type' => 'radio',
                'title' => __('Enable custom google fonts', Zoo_TEXT_DOMAIN), 
                'options' => array('yes' => 'Yes', 'no' => 'No'), // Must provide key => value pairs for select options
                'desc' => __('<p class="description">If google fonts are disabled the default font family "lato" will be used - this font is included in the theme files.<br /> Be sure to select YES if you wish to use a different font.</p>', Zoo_TEXT_DOMAIN),
                'std' => 'no'
            ),
            array(
                'id' => 'zo_body_font',
                'type' => 'google_webfonts',
                'title' => __('Body Font', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Select the main body font', Zoo_TEXT_DOMAIN),

            ),
            array(
                'id' => 'zo_heading1_font',
                'type' => 'google_webfonts',
                'title' => __('Heading 1 Font', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Select h1 font', Zoo_TEXT_DOMAIN),
           
            ),
            array(
                'id' => 'zo_heading226_font',
                'type' => 'google_webfonts',
                'title' => __('Heading 2 to heading 6 Font', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Select h2, h3, h4, h5, h6 font', Zoo_TEXT_DOMAIN),
         
            ),
            array(
                'id' => 'zo_pagedesc_font',
                'type' => 'google_webfonts',
                'title' => __('Page description font', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Select page description font, default is serif', Zoo_TEXT_DOMAIN),
         
            ),
            array(
                'id' => 'zo_accent_font',
                'type' => 'google_webfonts',
                'title' => __('Accent font', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Select accent font', Zoo_TEXT_DOMAIN),
                'desc' => __('<p class="description">This font will be assigned to the class "accent"</p> <p class="description"> 
                    <code> example use: <strong> &lth1&gt&ltspan class="accent"&gtThis is accent font&lt/span&gt This is heading 1 font&lt/h1&gt </strong></code></p>', Zoo_TEXT_DOMAIN),
            ),
            array(
                'id' => 'zo_accent_spacing',
                'type' => 'text',
                'title' => __('Accent font letter spacing (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter accent font letter spacing - Default is 4', Zoo_TEXT_DOMAIN),
                'std' => '4'
            ),
            array(
                'id' => 'zo_body_font_size',
                'type' => 'text',
                'title' => __('Body Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter body font size - Default is 14', Zoo_TEXT_DOMAIN),
                'std' => '14'
            ),
            array(
                'id' => 'zo_main_nav_font_size',
                'type' => 'text',
                'title' => __('Main Navigation Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter main navigation font size - Default is 11', Zoo_TEXT_DOMAIN),
                'std' => '11'
            ),
            array(
                'id' => 'zo_secodary_nav_font_size',
                'type' => 'text',
                'title' => __('Secondary Navigation Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter secondary navigation font size - Default is 11', Zoo_TEXT_DOMAIN),
                'desc' => __('<p class="description">Secondary navigation includes page tabs and portfolio filters</p>', Zoo_TEXT_DOMAIN),
                'std' => '11'
            ),
            array(
                'id' => 'zo_breadcrumbs_nav_font_size',
                'type' => 'text',
                'title' => __('Breadcrumbs and Post Navigation Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter breadcrumbs and post navigation font size - Default is 11', Zoo_TEXT_DOMAIN),
                'std' => '11'
            ),
            array(
                'id' => 'zo_h1_font_size',
                'type' => 'text',
                'title' => __('Heading H1 Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter heading one font size - Default is 55', Zoo_TEXT_DOMAIN),
                'std' => '55'
            ),
            array(
                'id' => 'zo_h2_font_size',
                'type' => 'text',
                'title' => __('Heading H2 Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter heading two font size - Default is 24', Zoo_TEXT_DOMAIN),
                'std' => '24'
            ),
            array(
                'id' => 'zo_h3_font_size',
                'type' => 'text',
                'title' => __('Heading H3 Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter heading three font size - Default is 20', Zoo_TEXT_DOMAIN),
                'std' => '20'
            ),
            array(
                'id' => 'zo_h4_font_size',
                'type' => 'text',
                'title' => __('Heading H4 Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter heading four font size - Default is 18', Zoo_TEXT_DOMAIN),
                'std' => '18'
            ),
            array(
                'id' => 'zo_h5_font_size',
                'type' => 'text',
                'title' => __('Heading H5 Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter heading five font size - Default is 16', Zoo_TEXT_DOMAIN),
                'std' => '16'
            ),
            array(
                'id' => 'zo_h6_font_size',
                'type' => 'text',
                'title' => __('Heading H6 Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Enter heading six font size - Default is 14', Zoo_TEXT_DOMAIN),
                'std' => '14'
            ),
            array(
                'id' => 'zo_mega_font_size',
                'type' => 'text',
                'title' => __('Mega Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Mega font size - Default is 72', Zoo_TEXT_DOMAIN),
                'desc' => __('<p class="description">This size will be assigned to the class "mega"</p> <p class="description"> 
                    <code> example use: <strong> &lth1 class="mega"&gt This is a big font &lt/h1&gt </strong></code></p>', Zoo_TEXT_DOMAIN),
                'std' => '72'
            ),
            array(
                'id' => 'zo_giga_font_size',
                'type' => 'text',
                'title' => __('Giga Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Giga font size - Default is 90', Zoo_TEXT_DOMAIN),
                'desc' => __('<p class="description">This size will be assigned to the class "giga"</p> <p class="description"> 
                    <code> example use: <strong> &lth1 class="giga"&gt This is a realy big font &lt/h1&gt </strong></code></p>', Zoo_TEXT_DOMAIN),
                'std' => '90'
            ),
            array(
                'id' => 'zo_tera_font_size',
                'type' => 'text',
                'title' => __('Tera Font Size (px)', Zoo_TEXT_DOMAIN), 
                'sub_desc' => __('Tera font size - Default is 117', Zoo_TEXT_DOMAIN),
                'desc' => __('<p class="description">This size will be assigned to the class "tera"</p> <p class="description"> 
                    <code> example use: <strong> &lth1 class="tera"&gt This is a huge font &lt/h1&gt </strong></code></p>', Zoo_TEXT_DOMAIN),
                'std' => '117'
            ),
            
        )
    );

   
        $sections[] = array(
            'icon' => 'magic',
            'icon_class' => 'icon-large',
            'title' => __('Styling Options', Zoo_TEXT_DOMAIN),
            'fields' => array(
               array(
                    'id' => '39',
                    'type' => 'color',
                    'title' => __('Google Map Hue', Zoo_TEXT_DOMAIN), 
                    'desc' => __('<p class="description">Indicates the basic map color.</p>', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Select Google map hue', Zoo_TEXT_DOMAIN),
                    'std' => '#f38630',
                ),
                array(
                    'id' => '40',
                    'type' => 'text',
                    'title' => __('Google Map Saturation', Zoo_TEXT_DOMAIN), 
                    'desc' => __('<p class="description"> (Value between -100 and 100) indicates the intensity of the basic color.</p>', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Enter Google map saturation', Zoo_TEXT_DOMAIN),
                    'std' => '-20',
                ),
                array(
                    'id' => '42',
                    'type' => 'text',
                    'title' => __('Google Map Brightness', Zoo_TEXT_DOMAIN), 
                    'desc' => __('<p class="description"> (Value between -100 and 100) ndicates the percentage change in brightness of the map.</p>', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Enter Google map saturation', Zoo_TEXT_DOMAIN),
                    'std' => '-10',
                ),
                 array(
                    'id' => '41',
                    'type' => 'upload',
                    'title' => __('Google Map Marker', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Upload a custom Google map marker', Zoo_TEXT_DOMAIN),
                    'std' => get_template_directory_uri().'/images/marker.png',
                ),
                array(
                    'id' => 'zo_main_color',
                    'type' => 'color',
                    'title' => __('Accent Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the main accent color', Zoo_TEXT_DOMAIN),
                    'std' => '#f38630',
                ),
                array(
                    'id' => 'zo_body_background_color',
                    'type' => 'color',
                    'title' => __('Body Background Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the body background color', Zoo_TEXT_DOMAIN),
                    'desc' => __('<p class="description">Site wide background color. To set background images or colors for individual sections/pages use the meta box options in the page editor screen.</p>', Zoo_TEXT_DOMAIN),
                    'std' => '#ffffff',
                ),
                array(
                    'id' => 'zo_nav_color',
                    'type' => 'color',
                    'title' => __('Navigation Bar Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the navigation bar color', Zoo_TEXT_DOMAIN),
                    'std' => '#2e2e2e',
                ),
                array(
                    'id' => 'zo_nav_border_color',
                    'type' => 'color',
                    'title' => __('Navigation Top Border Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the navigation top border color', Zoo_TEXT_DOMAIN),
                    'std' => '#000000',
                ),
                array(
                    'id' => 'zo_portfolio_hover_color',
                    'type' => 'color',
                    'title' => __('Portfolio Item Rollover Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the background color shown while hovering portfolio items', Zoo_TEXT_DOMAIN),
                    'std' => '#000000',
                ),
                array(
                    'id' => 'zo_portfolio_single_background_color',
                    'type' => 'color',
                    'title' => __('Portfolio Single Background Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the background color for the portfolio popup', Zoo_TEXT_DOMAIN),
                    'std' => '#efefef',
                ),
                array(
                    'id' => 'zo_portfolio_single_nav_color',
                    'type' => 'color',
                    'title' => __('Portfolio Single Navigation Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the color for the portfolio popup navigation bar', Zoo_TEXT_DOMAIN),
                    'std' => '#ffffff',
                ),
                array(
                    'id' => 'zo_footer_color',
                    'type' => 'color',
                    'title' => __('Footer Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the background color of the footer', Zoo_TEXT_DOMAIN),
                    'std' => '#000000',
                ),
                array(
                    'id' => 'zo_copyrighttext_color',
                    'type' => 'color',
                    'title' => __('Copyright Text Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the copyright text font color', Zoo_TEXT_DOMAIN),
                    'std' => '#747474',
                ),
                array(
                    'id' => 'zo_heading_font_color',
                    'type' => 'color',
                    'title' => __('Heading Font Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the font color for headings', Zoo_TEXT_DOMAIN),
                    'std' => '#2e2e2e',
                ),
                array(
                    'id' => 'zo_body_font_color',
                    'type' => 'color',
                    'title' => __('Body Font Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the main font color', Zoo_TEXT_DOMAIN),
                    'std' => '#2e2e2e',
                ),
                array(
                    'id' => 'zo_main_nav_font_color',
                    'type' => 'color',
                    'title' => __('Main Navigation Standard Font Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the main navigation standard font color', Zoo_TEXT_DOMAIN),
                    'std' => '#e0e0e0',
                ),
                array(
                    'id' => 'zo_main_nav_active_font_color',
                    'type' => 'color',
                    'title' => __('Main Navigation Active Font Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the main navigation active font color', Zoo_TEXT_DOMAIN),
                    'std' => '#ffffff',
                ),
                array(
                    'id' => 'zo_secondary_nav_font_color',
                    'type' => 'color',
                    'title' => __('Secondary Navigation Standard Font Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the secondary navigation standard font color', Zoo_TEXT_DOMAIN),
                    'desc' => __('<p class="description">Secondary navigation includes page tabs and portfolio filters</p>', Zoo_TEXT_DOMAIN),
                    'std' => '#2e2e2e',
                ),
                array(
                    'id' => 'zo_secondary_nav_active_font_color',
                    'type' => 'color',
                    'title' => __('Secondary Navigation Active Font Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select the secondary navigation active font color', Zoo_TEXT_DOMAIN),
                    'desc' => __('<p class="description">Secondary navigation includes page tabs and portfolio filters</p>', Zoo_TEXT_DOMAIN),
                    'std' => '#2e2e2e',
                ),
                array(
                    'id' => 'zo_link_color',
                    'type' => 'color',
                    'title' => __('Link Color', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select font color for links (Accent color is used on rollover) ', Zoo_TEXT_DOMAIN),
                    'std' => '#2e2e2e',
                ),
                array(
                    'id' => 'zo_custom_css',
                    'type' => 'textarea',
                    'title' => __('Custom CSS', Zoo_TEXT_DOMAIN), 
                ),

             
            )
        );

        $sections[] = array(
            'icon' => 'picture',
            'icon_class' => 'icon-large',
            'title' => __('Slider Options', Zoo_TEXT_DOMAIN),
            'fields' => array(
               array(
                    'id' => 'zo_super_play',
                    'type' => 'text',
                    'title' => __('SuperSlides Play', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('<p class="description">Home page slider auto play</p>', Zoo_TEXT_DOMAIN),
                    'desc' => __('<p class="description">Auto play speed in milliseconds. Leave empty to disable auto play.</p>', Zoo_TEXT_DOMAIN),
                    'std' => '',
                ),
                array(
                    'id' => 'zo_super_pagi',
                    'type' => 'checkbox',
                    'switch' => true,
                    'title' => __('SuperSlides Pagination', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('<p class="description">Turn home page slider pagination display on or off</p>', Zoo_TEXT_DOMAIN),
                    'std' => '0',
                ),
                array(
                    'id' => 'zo_super_animation',
                    'type' => 'radio',
                    'title' => __('SuperSlides Animation Type', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select homepage slider animation style', Zoo_TEXT_DOMAIN),
                    'options' => array('fade' => 'Fade', 'slide' => 'Slide'), // Must provide key => value pairs for select options
                    'std' => 'slide'
                ),
                array(
                    'id' => 'zo_flex_auto_play',
                    'type' => 'checkbox',
                    'switch' => true,
                    'title' => __('Flex Slider Auto Play', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('<p class="description">Turn flex slider auto play on or off</p>', Zoo_TEXT_DOMAIN),
                    'std' => '0',
                ),
                array(
                    'id' => 'zo_flex_play_speed',
                    'type' => 'text',
                    'title' => __('Flex Slider Auto Play Speed', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('<p class="description">Flex slider auto play speed</p>', Zoo_TEXT_DOMAIN),
                    'desc' => __('<p class="description">The speed of the slideshow cycling, in milliseconds </p>', Zoo_TEXT_DOMAIN),
                    'std' => '1500',
                ),
                array(
                    'id' => 'zo_flex_animation',
                    'type' => 'radio',
                    'title' => __('Flex Slider Animation Type', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select fade or slide animation types', Zoo_TEXT_DOMAIN),
                    'options' => array('fade' => 'Fade', 'slide' => 'Slide'), // Must provide key => value pairs for select options
                    'std' => 'slide'
                ),
                array(
                    'id' => 'zo_flex_direction',
                    'type' => 'radio',
                    'title' => __('Flex Slider Slide Direction', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Select direction for slide animation', Zoo_TEXT_DOMAIN),
                    'options' => array('horizontal' => 'Horizontal', 'vertical' => 'Vertical'), // Must provide key => value pairs for select options
                    'std' => 'horizontal'
                ),
                array(
                    'id' => 'zo_flex_controll',
                    'type' => 'checkbox',
                    'switch' => true,
                    'title' => __('Flex Slider Pagination', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('<p class="description">Turn pagination display on or off</p>', Zoo_TEXT_DOMAIN),
                    'std' => '0',
                ),
                array(
                    'id' => 'zo_testimonials_auto_play',
                    'type' => 'checkbox',
                    'switch' => true,
                    'title' => __('Testimonials Slider Auto Play', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('<p class="description">Turn the testimonials slider auto play on or off</p>', Zoo_TEXT_DOMAIN),
                    'std' => '0',
                ),

 
              
            )

        );
        $sections[] = array(
            'icon' => 'group',
            'icon_class' => 'icon-large',
            'title' => __('Social Networks', Zoo_TEXT_DOMAIN),
            'fields' => array(
                array(
                    'id' => '25',
                    'type' => 'text',
                    'title' => __('Twitter Link', Zoo_TEXT_DOMAIN), 
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN),
                    'std' => 'http://www.twitter.com'
                ),
                array(
                    'id' => '26',
                    'type' => 'text',
                    'title' => __('Facebook Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.facebook.com'
                ),
                array(
                    'id' => '27',
                    'type' => 'text',
                    'title' => __('Dribbble Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.dribbble.com'
                ),
                array(
                    'id' => '28',
                    'type' => 'text',
                    'title' => __('Youtube Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.youtube.com'
                ),
                array(
                    'id' => '29',
                    'type' => 'text',
                    'title' => __('Instagram Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.instagram.com'
                ),
                array(
                    'id' => '30',
                    'type' => 'text',
                    'title' => __('Vimeo Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.vimeo.com'
                ),
                array(
                    'id' => '31',
                    'type' => 'text',
                    'title' => __('Tumblr Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.tumblr.com'
                ),
                array(
                    'id' => '32',
                    'type' => 'text',
                    'title' => __('Wordpress Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.wordpress.com'
                ),
                array(
                    'id' => '33',
                    'type' => 'text',
                    'title' => __('RSS Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.rss.com'
                ),
                array(
                    'id' => '34',
                    'type' => 'text',
                    'title' => __('Google Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.google.com'
                ),
                array(
                    'id' => '35',
                    'type' => 'text',
                    'title' => __('Flickr Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.flickr.com'
                ),
                array(
                    'id' => '36',
                    'type' => 'text',
                    'title' => __('Linkedin Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.linkedin.com'
                ),
                array(
                    'id' => '37',
                    'type' => 'text',
                    'title' => __('Skype Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.skype.com'
                ),
                array(
                    'id' => '38',
                    'type' => 'text',
                    'title' => __('Dropbox Link', Zoo_TEXT_DOMAIN),
                    'sub_desc' => __('Leave field empty to remove icon', Zoo_TEXT_DOMAIN), 
                    'std' => 'http://www.dropbox.com'
                ),
              
            )
        );
                
    $tabs = array();

    if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $item_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $author_uri = $theme_data->get('AuthorURI');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    }else{
        $theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()) . 'style.css');
        $item_uri = $theme_data['URI'];
        $description = $theme_data['Description'];
        $author = $theme_data['Author'];
        $author_uri = $theme_data['AuthorURI'];
        $version = $theme_data['Version'];
        $tags = $theme_data['Tags'];
     }
    
    $item_info = '<div class="zoo-opts-section-desc">';
    $item_info .= '<p class="zoo-opts-item-data description item-uri">' . __('<strong>Theme URL:</strong> ', Zoo_TEXT_DOMAIN) . '<a href="' . $item_uri . '" target="_blank">' . $item_uri . '</a></p>';
    $item_info .= '<p class="zoo-opts-item-data description item-author">' . __('<strong>Author:</strong> ', Zoo_TEXT_DOMAIN) . ($author_uri ? '<a href="' . $author_uri . '" target="_blank">' . $author . '</a>' : $author) . '</p>';
    $item_info .= '<p class="zoo-opts-item-data description item-version">' . __('<strong>Version:</strong> ', Zoo_TEXT_DOMAIN) . $version . '</p>';
    $item_info .= '<p class="zoo-opts-item-data description item-description">' . $description . '</p>';
    $item_info .= '<p class="zoo-opts-item-data description item-tags">' . __('<strong>Tags:</strong> ', Zoo_TEXT_DOMAIN) . implode(', ', $tags) . '</p>';
    $item_info .= '</div>';

    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => 'icon-large',
        'title' => __('Theme Information', Zoo_TEXT_DOMAIN),
        'content' => $item_info
    );
    
    if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
        $tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
            'title' => __('Documentation', Zoo_TEXT_DOMAIN),
            'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
        );
    }

    global $Zoo_Options;
    $Zoo_Options = new Zoo_Options($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}
