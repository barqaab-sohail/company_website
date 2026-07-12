<?php

// load wordpress
require_once('get_wp.php');

class zoo_shortcodes
{
	var	$conf;
	var	$popup;
	var	$params;
	var	$shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;

	// --------------------------------------------------------------------------

	function __construct( $popup )
	{
		if( file_exists( dirname(__FILE__) . '/config.php' ) )
		{
			$this->conf = dirname(__FILE__) . '/config.php';
			$this->popup = $popup;
			
			$this->formate_shortcode();
		}
		else
		{
			$this->append_error('Config file does not exist');
		}
	}
	
	// --------------------------------------------------------------------------
	
	function formate_shortcode()
	{
		// get config file
		require_once( $this->conf );
		
		if( isset( $zoo_shortcodes[$this->popup]['child_shortcode'] ) )
			$this->has_child = true;
		
		if( isset( $zoo_shortcodes ) && is_array( $zoo_shortcodes ) )
		{
			// get shortcode config stuff
			$this->params = $zoo_shortcodes[$this->popup]['params'];
			$this->shortcode = $zoo_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $zoo_shortcodes[$this->popup]['popup_title'];
			
			// adds stuff for js use			
			$this->append_output( "\n" . '<div id="_zoo_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_zoo_popup" class="hidden">' . $this->popup . '</div>' );
			
			if( isset( $zoo_shortcodes[$this->popup]['no_preview'] ) && $zoo_shortcodes[$this->popup]['no_preview'] )
			{
				//$this->append_output( "\n" . '<div id="_zoo_preview" class="hidden">false</div>' );
				$this->no_preview = true;		
			}
			
			// filters and excutes params
			foreach( $this->params as $pkey => $param )
			{
				// prefix the fields names and ids with zoo_
				$pkey = 'zoo_' . $pkey;
				
		
				$row_start  = '<tbody>' . "\n";
				$row_start .= '<tr class="form-row">' . "\n";
				$row_start .= '<td class="label">' . $param['label'] . '</td>' . "\n";
				$row_start .= '<td class="field">' . "\n";
				
			
				$row_end	= '<span class="zoo-form-desc">' . $param['desc'] . '</span>' . "\n";
				$row_end   .= '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";					
				$row_end   .= '</tbody>' . "\n";

				
				switch( $param['type'] )
				{
					case 'text' :
						
						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="zoo-form-text zoo-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'textarea' :
						
						// prepare
						$output  = $row_start;
						$output .= '<textarea rows="10" cols="30" name="' . $pkey . '" id="' . $pkey . '" class="zoo-form-textarea zoo-input">' . $param['std'] . '</textarea>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'select' :
						
						// prepare
						$output  = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="zoo-form-select zoo-input">' . "\n";
						
						foreach( $param['options'] as $value => $option )
						{
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}
						
						$output .= '</select>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'checkbox' :
						
						// prepare
						$output  = $row_start;
						$output .= '<label for="' . $pkey . '" class="zoo-form-checkbox">' . "\n";
						$output .= '<input type="checkbox" class="zoo-input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
						$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
						$output .= $end;
						
						// append
						$this->append_output( $output );
						
						break;

					case 'range' :
							
							// prepare
						$output  = '<tbody>' . "\n";
						$output .= '<tr class="form-row small-row">' . "\n";
						$output .= '<td class="label">' . $param['label'] . '</td>' . "\n";
						$output .= '<td class="field">' . "\n";
						$output .= '<div id="slider_'. $pkey .'"></div>';
						$output	.= '<span class="zoo-form-desc">' . $param['desc'] . '</span>' . "\n";
						$output .= '</td>' . "\n";
						$output .= '</tr>' . "\n";					
						$output .= '</tbody>' . "\n";
					
						// append
						$this->append_output( $output );
						
						break;

					case 'rangetext' :
							
							// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="zoo-form-text zoo-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= '<div id="slider_'. $pkey .'"></div>';
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;

						case 'rangecolor' :
							
							// prepare
						$output  = '<tbody>' . "\n";
						$output .= '<tr class="form-row swatch-row">' . "\n";
						$output .= '<td class="label">' . $param['label'] . '</td>' . "\n";
						$output .= '<td class="field">' . "\n";
						$output .= '<div id="swatch_'. $pkey .'"></div>';
						$output .= '<input type="text" class="zoo-form-text zoo-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= '<div id="slider_'. $pkey .'"></div>';
						$output	.= '<span class="zoo-form-desc">' . $param['desc'] . '</span>' . "\n";
						$output .= '</td>' . "\n";
						$output .= '</tr>' . "\n";					
						$output .= '</tbody>' . "\n";
					
						
						// append
						$this->append_output( $output );
						
						break;

					case 'style' :
						

						$output  = '<tbody>' . "\n";
						$output .= '<tr class="form-row small-row-top">' . "\n";
						$output .= '<td class="label">' . $param['label'] . '</td>' . "\n";
						$output .= '<td class="field">' . "\n";
						$output .= '<input type="text" class="zoo-form-text zoo-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output	.= '<span class="zoo-form-desc">' . $param['desc'] . '</span>' . "\n";
						$output .= '</td>' . "\n";
						$output .= '</tr>' . "\n";					
						$output .= '</tbody>' . "\n";
						
						// append
						$this->append_output( $output );
						
						break;	
				}
			}
			
			// checks if has a child shortcode
			if( isset( $zoo_shortcodes[$this->popup]['child_shortcode'] ) )
			{
				// set child shortcode
				$this->cparams = $zoo_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $zoo_shortcodes[$this->popup]['child_shortcode']['shortcode'];
			
				// popup parent form row start
				$prow_start  = '<tbody>' . "\n";
				$prow_start .= '<tr class="form-row has-child">' . "\n";
				$prow_start .= '<td><a href="#" id="form-child-add" class="button-secondary">' . $zoo_shortcodes[$this->popup]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_start .= '<div class="child-clone-rows">' . "\n";
				
				// for js use
				$prow_start .= '<div id="_zoo_cshortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";
				
				// start the default row
				$prow_start .= '<div class="child-clone-row">' . "\n";
				$prow_start .= '<ul class="child-clone-row-form">' . "\n";
				
				// add $prow_start to output
				$this->append_output( $prow_start );
				
				foreach( $this->cparams as $cpkey => $cparam )
				{
				
					// prefix the fields names and ids with zoo_
					$cpkey = 'zoo_' . $cpkey;
					
					// popup form row start
					$crow_start  = '<li class="child-clone-row-form-row">' . "\n";
					$crow_start .= '<div class="child-clone-row-label">' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start .= '<div class="child-clone-row-field">' . "\n";
					
					// popup form row end
					$crow_end	  = '<span class="child-clone-row-desc">' . $cparam['desc'] . '</span>' . "\n";
					$crow_end   .= '</div>' . "\n";
					$crow_end   .= '</li>' . "\n";
					
					switch( $cparam['type'] )
					{
						case 'text' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="zoo-form-text zoo-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'textarea' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="zoo-form-textarea zoo-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'select' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="zoo-form-select zoo-cinput">' . "\n";
							
							foreach( $cparam['options'] as $value => $option )
							{
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}
							
							$coutput .= '</select>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'checkbox' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="zoo-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="zoo-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;



					}
				}
				

				// popup parent form row end
				$prow_end    = '</ul>' . "\n";		// end .child-clone-row-form
				$prow_end   .= '<a href="#" class="child-clone-row-remove">Remove</a>' . "\n";
				$prow_end   .= '</div>' . "\n";		// end .child-clone-row
				
				
				$prow_end   .= '</div>' . "\n";		// end .child-clone-rows
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";					
				$prow_end   .= '</tbody>' . "\n";
				
				// add $prow_end to output
				$this->append_output( $prow_end );
			}			
		}
	}
	
	// --------------------------------------------------------------------------
	
	function append_output( $output )
	{
		$this->output = $this->output . "\n" . $output;		
	}
	
	// --------------------------------------------------------------------------
	
	function reset_output( $output )
	{
		$this->output = '';
	}
	
	// --------------------------------------------------------------------------
	
	function append_error( $error )
	{
		$this->errors = $this->errors . "\n" . $error;
	}
}

?>