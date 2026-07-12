<?php


/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ',
	'popup_title' => 'Insert Columns Shortcode',
	'no_preview' => true,
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => 'Column Type',
				'desc' => 'Select the type, ie width of the column.',
				'options' => array(
					'column_full' => 'Full Width',
					'column_third' => 'One Third',
					'column_third_last' => 'One Third Last',
					'column_two_thirds' => 'Two Thirds',
					'column_two_thirds_last' => 'Two Thirds Last',
					'column_half' => 'One Half',
					'column_half_last' => 'One Half Last',
					'column_quarter' => 'One Quarter',
					'column_quarter_last' => 'One Quarter Last',
					'column_three_quarter' => 'Three Quarters',
					'column_three_quarter_last' => 'Three Quarters Last',
				
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => 'Column Content',
				'desc' => 'Add the column content.',
			)
		),
		'shortcode' => '[{{column}}] {{content}} [/{{column}}] ',
		'clone_button' => 'Add Column',
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'link' => array(
			'type' => 'text',
			'label' => 'Link',
			'desc' => 'Enter the buttons URL. For in page links use #PageTitle eg - #About (Case Sensitive)',
			'std' => '#About',
		),
		'transparent' => array(
			'type' => 'select',
			'label' => 'Button Style',
			'desc' => 'Transparent button or solid color?',
			'options' => array(
					'yes' => 'Transparent',
					'no' => 'Solid Color',
				),
		),
		'label' => array(
			'type' => 'text',
			'label' => 'Button Label',
			'desc' => 'Enter the button label',
			'std' => '',
		),
	),
	'shortcode' => '[button link="{{link}}" transparent="{{transparent}}"]{{label}}[/button]',
	'popup_title' => 'Insert Button Shortcode',
);

/*-----------------------------------------------------------------------------------*/
/*	Skill Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['skill'] = array(
	'no_preview' => true,
	'params' => array(
		'name' => array(
			'type' => 'text',
			'label' => 'Skill',
			'desc' => 'Add a title to go above the skill rating bar',
			'std' => 'Skill',
		),
		'level' => array(
			'type' => 'text',
			'label' => 'Skill Level',
			'desc' => 'Add the level of skill between 0% and 100%',
			'std' => '100',
		),
	),
	'shortcode' => '[skill name="{{name}}" level="{{level}}"]',
	'popup_title' => 'Insert Skill Rating Bar Shortcode',
);

/*-----------------------------------------------------------------------------------*/
/*	Scroll Animation Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['scrollAnimation'] = array(
	'no_preview' => true,
	'params' => array(
		'start' => array(
			'type' => 'rangetext',
			'label' => 'Start',
			'desc' => 'Enter the scroll position where the animation will begin',
			'std' => '',
		),
		'end' => array(
			'type' => 'rangetext',
			'label' => 'End',
			'desc' => 'Enter the scroll position where the animation will end',
			'std' => '',
		),
		'relative' => array(
			'type' => 'select',
			'label' => 'Mode',
			'desc' => 'Are the start and end values based on document height or relative to the browser view port - Recommended',
			'options' => array(
					'yes' => 'Relative to view port',
					'no' => 'Based on document height',
				),
		),
		'fromStyle' => array(
			'type' => 'style',
			'label' => 'Animate From',
			'desc' => 'Use the sliders below to set the property and value that the animation will tween from. Will also accept custom CSS.',
			'std' => '',
		),
		'fromOpacity' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Opacity',
			'std' => '',
		),
		'fromTop' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Top',
			'std' => '',
		),
		'fromLeft' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Left',
			'std' => '',
		),
		'toStyle' => array(
			'type' => 'style',
			'label' => 'Animate To',
			'desc' => 'Enter the values the animation will tween to. Properites must match the animating from properties', 
			'std' => '',
		),
		'toOpacity' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Opacity',
			'std' => '',
		),
		'toTop' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Top',
			'std' => '',
		),
		'toLeft' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Left',
			'std' => '',
		),
	),
	'shortcode' => '[scroll_animation relative="{{relative}}" start="{{start}}" end="{{end}}" from="{{fromStyle}}" to="{{toStyle}}"][/scroll_animation]',
	'popup_title' => 'Insert Scroll Animation Shortcode <a class="help" href ="http://www.webdingo.net/zoo-doc/#animation" target="_blank">Help</a>',
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Posts Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['recentPosts'] = array(
	'no_preview' => true,
	'params' => array(
		'numPosts' => array(
			'type' => 'text',
			'label' => 'Number of posts',
			'desc' => 'Add the number of posts to show',
			'std' => '3'
		),
		'excerptWords' => array(
			'type' => 'text',
			'label' => 'Excerpt Words',
			'desc' => 'Add the amount of words for auto generated excerpts',
			'std' => '75',
		),
	),
	'shortcode' => '[recent_posts num_posts="{{numPosts}}" excerpt_words="{{excerptWords}}"]',
	'popup_title' => 'Insert Recent Posts Shortcode',
);

/*-----------------------------------------------------------------------------------*/
/*	Flex Slider Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['flexSlider'] = array(
	'no_preview' => true,
	'params' => array(
		'cat' => array(
			'type' => 'text',
			'label' => 'Flex Slider Category',
			'desc' => 'Enter the flex slider post category to show',
			'std' => '',
		),
	),
	'shortcode' => '[flex_slider cat="{{cat}}"]',
	'popup_title' => 'Insert Recent Posts Shortcode',
);

/*-----------------------------------------------------------------------------------*/
/*	Parallax Section Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['parallaxSection'] = array(
	'no_preview' => true,
	'params' => array(
		'background' => array(
			'type' => 'text',
			'label' => 'Background Image',
			'desc' => 'Enter the background image URL',
			'std' => '',
		),
	),
	'shortcode' => '[parallax_section background="{{background}}"][/parallax_section]',
	'popup_title' => 'Insert Parallax Section Shortcode',
);


/*-----------------------------------------------------------------------------------*/
/*	Colored Parallax Section Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['coloredParallaxSection'] = array(
	'no_preview' => true,
	'params' => array(
		'background' => array(
			'type' => 'text',
			'label' => 'Background Image',
			'desc' => 'Enter the background image URL',
			'std' => '',
		),

		'fromColor' => array(
			'type' => 'rangecolor',
			'label' => 'Starting Color',
			'desc' => 'Use the sliders below to select a starting color',
			'std' => 'rgb(255,255,255)',
		),
		'fromRed' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Red',
			'std' => '',
		),
		'fromGreen' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Green',
			'std' => '',
		),
		'fromBlue' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Blue',
			'std' => '',
		),
		'toColor' => array(
			'type' => 'rangecolor',
			'label' => 'End Color',
			'desc' => 'Use the sliders below to select a ending color',
			'std' => 'rgb(0,0,0)',
		),
		'toRed' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Red',
			'std' => '',
		),
		'toGreen' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Green',
			'std' => '',
		),
		'toBlue' => array(
			'type' => 'range',
			'desc' => '',
			'label' => 'Blue',
			'std' => '',
		),


	),
	'shortcode' => '[colored_parallax_section background="" start="{{fromColor}}" end="{{toColor}}"][/colored_parallax_section]',
	'popup_title' => 'Insert Colred Parallax Section Shortcode <a class="help" href ="http://www.webdingo.net/zoo-doc/#animation" target="_blank">Help</a>', 
);




/*-----------------------------------------------------------------------------------*/
/*	Parallax Background Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['parallaxBackground'] = array(
	'no_preview' => true,
	'params' => array(
		'background' => array(
			'type' => 'text',
			'label' => 'Background Image',
			'desc' => 'Enter the background image URL',
			'std' => '',
		),
	),
	'shortcode' => '[parallax_background background="{{background}}"][/parallax_section]',
	'popup_title' => 'Insert Parallax Background Shortcode',
);

/*-----------------------------------------------------------------------------------*/
/*	Tabbed Page Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['tabbedPage'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[tabbed_page] {{child_shortcode}}  [/tabbed_page]',
    'popup_title' => __('Insert Tab Shortcode', 'zoo-shortcodes'),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => 'Tab Title', 
                'desc' => 'Title of the tab',
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => 'Tab Content',
                'desc' => 'Add the tab content',
            )
        ),
        'shortcode' => '[tabbed_page_tab title="{{title}}"] {{content}} [/tabbed_page_tab]',
        'clone_button' => 'Add Tab',
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Google Map Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['googleMap'] = array(
	'no_preview' => true,
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => 'Map Title',
			'desc' => 'Enter the map title',
			'std' => 'Envato Office',
		),
		'location' => array(
			'type' => 'text',
			'label' => 'Location',
			'desc' => 'Enter Map Address',
			'std' => '2 Elizabeth St, Melbourne Victoria 3000 Australia',
		),
		'zoom' => array(
			'type' => 'text',
			'label' => 'Zoom',
			'desc' => 'Enter the defaut zoom level',
			'std' => '10',
		),
		'height' => array(
			'type' => 'text',
			'label' => 'Height',
			'desc' => 'Enter the map height in pixels',
			'std' => '350',
		),
	),
	'shortcode' => '[google_map title="{{title}}" location="{{location}}" zoom="{{zoom}}" height={{height}}]',
	'popup_title' => 'Insert Google Map shortcode',
);

/*-----------------------------------------------------------------------------------*/
/*	Tabbed Page Config
/*-----------------------------------------------------------------------------------*/
$zoo_shortcodes['testimonialsSlider'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[testimonials_slider] {{child_shortcode}}  [/testimonials_slider]',
    'popup_title' => 'Testimonials Slider Shortcode', 
    
    'child_shortcode' => array(
        'params' => array(
            'image' => array(
                'std' => '',
                'type' => 'text',
                'label' => 'Testimonial Image',
                'desc' => 'Enter the URL for testimonial avatar', 
            ),
            'name' => array(
                'std' => '',
                'type' => 'text',
                'label' => 'Name',
                'desc' => 'Enter the name of the testimonial author', 
            ),
            'company' => array(
                'std' => '',
                'type' => 'text',
                'label' => 'Company',
                'desc' => 'Enter the company of the testimonial author',
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => 'Quote',
                'desc' => 'Add the quote content',
            )
        ),
        'shortcode' => '[testimonial image="{{image}}" name="{{name}}" company="{{company}}"] {{content}} [/testimonial]',
        'clone_button' => 'Add Testimonial', 
    )
);


?>

