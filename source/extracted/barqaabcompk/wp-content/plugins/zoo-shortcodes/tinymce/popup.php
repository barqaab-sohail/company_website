<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new zoo_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="zoo-popup">

	<div id="zoo-shortcode-wrap">
		
		<div id="zoo-sc-form-wrap">
		
			<div id="zoo-sc-form-head">
			
				<?php echo $shortcode->popup_title; ?>
			
			</div>
			<!-- /#zoo-sc-form-head -->
			
			<form method="post" id="zoo-sc-form">
			
				<table id="zoo-sc-form-table">
				
					<?php echo $shortcode->output; ?>
					
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary zoo-insert">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#zoo-sc-form-table -->
				
			</form>
			<!-- /#zoo-sc-form -->
		
		</div>
		<!-- /#zoo-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#zoo-shortcode-wrap -->

</div>
<!-- /#zoo-popup -->

</body>
</html>