(function ()
{
	// create zooShortcodes plugin
	tinymce.create("tinymce.plugins.zooShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("zooPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("Insert zoo Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "zoo_button" )
			{	
				var a = this;
				
				var btn = e.createSplitButton('zoo_button', {
                    title: "Insert zoo Shortcode",
					image: zooShortcodes.plugin_folder +"/tinymce/images/icon.png",
					icons: false
                });

                btn.onRenderMenu.add(function (c, b)
				{					
					a.addWithPopup( b, "Columns", "columns" );
					a.addWithPopup( b, "Button", "button" );
					a.addWithPopup( b, "Skill Rating Bar", "skill" );
					a.addWithPopup( b, "Scroll Animation", "scrollAnimation" );
					a.addWithPopup( b, "Recent Posts", "recentPosts" );
					a.addWithPopup( b, "Parallax Section", "parallaxSection" );
					a.addWithPopup( b, "Colored Parallax Section", "coloredParallaxSection" );
					a.addWithPopup( b, "Parallax Background", "parallaxBackground" );
					a.addWithPopup( b, "Tabbed Page", "tabbedPage" );
					a.addWithPopup( b, "Testimonials Slider", "testimonialsSlider" );
					a.addImmediate( b, "Social Networks", "[social_networks]" );
					a.addWithPopup( b, "Flex Slider", "flexSlider" );
					a.addImmediate( b, "SuperSlides", "[super_slides]" );
					a.addImmediate( b, "Portfolio", "[portfolio]" );
					a.addWithPopup( b, "Google Map", "googleMap" );
				});
                
                return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("zooPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'zoo Shortcodes',
				author: 'Web Dingo',
				authorurl: 'http://www.webdingo.net',
				infourl: 'http://www.webdingo.net',
				version: "1.0"
			}
		}
	});
	
	// add zooShortcodes plugin
	tinymce.PluginManager.add("zooShortcodes", tinymce.plugins.zooShortcodes);
})();

