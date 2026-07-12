
// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var zoos = {
    	loadVals: function()
    	{
    		var shortcode = $('#_zoo_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.zoo-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('zoo_', ''),		// gets rid of the zoo_ prefix
    				re = new RegExp("{{"+id+"}}","g");
    				
    			uShortcode = uShortcode.replace(re, input.val());
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_zoo_ushortcode').remove();
    		$('#zoo-sc-form-table').prepend('<div id="_zoo_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_zoo_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';
    		
    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
    			$('.zoo-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('zoo_', '')		// gets rid of the zoo_ prefix
    					re = new RegExp("{{"+id+"}}","g");
    					
    				rShortcode = rShortcode.replace(re, input.val());
    			});
    	
    			shortcodes = shortcodes + rShortcode + "\n";
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_zoo_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_zoo_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_zoo_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
    		
    		// add updated parent shortcode
    		$('#_zoo_ushortcode').remove();
    		$('#zoo-sc-form-table').prepend('<div id="_zoo_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'
				
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				zooPopup = $('#zoo-popup');

            tbWindow.css({
                height: zooPopup.outerHeight() + 50,
                width: zooPopup.outerWidth(),
                marginLeft: -(zooPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: zooPopup.outerWidth()
			});
			
			$('#zoo-popup').addClass('no_preview');
    	},
    	load: function()
    	{
    		var	zoos = this,
    			popup = $('#zoo-popup'),
    			form = $('#zoo-sc-form', popup),
    			shortcode = $('#_zoo_shortcode', form).text(),
    			popupType = $('#_zoo_popup', form).text(),
    			uShortcode = '';
    		
    		// resize TB
    		zoos.resizeTB();
    		$(window).resize(function() { zoos.resizeTB() });
    		
    		// initialise
    		zoos.loadVals();
    		zoos.children();
    		zoos.cLoadVals();
    		
    		// update on children value change
    		$('.zoo-cinput', form).live('change', function() {
    			zoos.cLoadVals();
    		});
    		
    		// update on value change
    		$('.zoo-input', form).change(function() {
    			zoos.loadVals();
    		});
    		
    		// when insert is clicked
    		$('.zoo-insert', form).click(function() {    		 			
    			if(window.tinyMCE)
				{
					window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, $('#_zoo_ushortcode', form).html());
					tb_remove();
				}
    		});

            // Sliders
            // --------------------------------------------------------------------------
            
            $( "#slider_zoo_start" ).slider({
            step: 1,
            min: -1000,
            max: 1000,
            range:'min',
                slide: function( event, ui ) { 
                    $( "#zoo_start" ).val(ui.value);
                    zoos.loadVals();
                }
            });
            $( "#slider_zoo_end" ).slider({
            step: 1,
            min: -1000,
            max: 1000,
            range:'min',
                slide: function( event, ui ) { 
                    $( "#zoo_end" ).val(ui.value);
                    zoos.loadVals();

                }
            });

            $( "#slider_zoo_fromTop, #slider_zoo_fromLeft" ).slider({
                step: 1,
                min: -1000,
                max: 1000,
                range:'min',
                slide: refreshFromStyle,
                change: refreshFromStyle
            });

            $( "#slider_zoo_fromOpacity" ).slider({
                step: 0.1,
                min: 0,
                max: 1,
                range:'min',
                slide: refreshFromStyle,
                change: refreshFromStyle
            });

            $( "#slider_zoo_toTop, #slider_zoo_toLeft" ).slider({
                step: 1,
                min: -1000,
                max: 1000,
                range:'min',
                slide: refreshtoStyle,
                change: refreshtoStyle
            });
                      
            $( "#slider_zoo_toOpacity" ).slider({
                step: 0.1,
                min: 0,
                max: 1,
                range:'min',
                slide: refreshtoStyle,
                change: refreshtoStyle
            });

            $( "#slider_zoo_fromRed, #slider_zoo_fromGreen, #slider_zoo_fromBlue" ).slider({
                step: 1,
                min: 0,
                max: 255,
                value:0,
                range:'min',
                slide: refreshfromColor,
                change: refreshfromColor
            });
            $( "#slider_zoo_toRed, #slider_zoo_toGreen, #slider_zoo_toBlue" ).slider({
                step: 1,
                min: 0,
                max: 255,
                value:255,
                range:'min',
                slide: refreshtoColor,
                change: refreshtoColor
            });
    

            function refreshFromStyle() {
                var fromOpacity = '', fromTop = '', fromLeft = '';
                
                if($( "#slider_zoo_fromOpacity" ).slider( "value" ) != '' ) {
                  fromOpacity = 'opacity: ' + $( "#slider_zoo_fromOpacity" ).slider( "value" ) + ' ; ';
                }
                if($( "#slider_zoo_fromTop" ).slider( "value" ) != '') {
                  fromTop = 'top: ' + $( "#slider_zoo_fromTop" ).slider( "value" ) + 'px; ';
                }
                if($( "#slider_zoo_fromLeft" ).slider( "value" ) != '') {
                  fromLeft = 'left: ' + $( "#slider_zoo_fromLeft" ).slider( "value" ) + 'px; ';
                }
                
                $( "#zoo_fromStyle" ).val(fromOpacity + fromTop + fromLeft);
                
                zoos.loadVals();
            }

            function refreshtoStyle() {
                var toOpacity = '', toTop = '', toLeft = '';
                
                if($( "#slider_zoo_toOpacity" ).slider( "value" ) != '' ) {
                  toOpacity = 'opacity: ' + $( "#slider_zoo_toOpacity" ).slider( "value" ) + ' ; ';
                }
                if($( "#slider_zoo_toTop" ).slider( "value" ) != '') {
                  toTop = 'top: ' + $( "#slider_zoo_toTop" ).slider( "value" ) + 'px; ';
                }
                if($( "#slider_zoo_toLeft" ).slider( "value" ) != '') {
                  toLeft = 'left: ' + $( "#slider_zoo_toLeft" ).slider( "value" ) + 'px; ';
                }
           
                $( "#zoo_toStyle" ).val(toOpacity + toTop + toLeft);
                
                zoos.loadVals();
            }

            function refreshfromColor() {
                //var toOpacity = '', toTop = '', toLeft = '';
                var fromRed = $( "#slider_zoo_fromRed" ).slider( "value" ),
                fromGreen = $( "#slider_zoo_fromGreen" ).slider( "value" ),
                fromBlue = $( "#slider_zoo_fromBlue" ).slider( "value" );

           
                $( "#zoo_fromColor" ).val('rgb('+ fromRed + ',' + fromGreen + ',' + fromBlue + ')');
                $( "#swatch_zoo_fromColor" ).css('background-color', $( "#zoo_fromColor" ).val()) ;
              
                zoos.loadVals();
            } 
             function refreshtoColor() {

                var toRed = $( "#slider_zoo_toRed" ).slider( "value" ),
                toGreen = $( "#slider_zoo_toGreen" ).slider( "value" ),
                toBlue = $( "#slider_zoo_toBlue" ).slider( "value" );

           
                $( "#zoo_toColor" ).val('rgb('+ toRed + ',' + toGreen + ',' + toBlue + ')');
                $( "#swatch_zoo_toColor" ).css('background-color', $( "#zoo_toColor" ).val()) ;
              
                zoos.loadVals();
            }                 

    	    
            // --------------------------------------------------------------------------
        }
	}
    
    // run
    $('#zoo-popup').livequery( function() { zoos.load(); } );

});