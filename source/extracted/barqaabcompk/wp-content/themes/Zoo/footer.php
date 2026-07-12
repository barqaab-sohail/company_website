

<?php global $Zoo_Options; ?>
	<footer class="footer row">
		<div class="grid">
	 		<div class="c12 end" >
	 			<a class="footerLogo" href="<?php echo get_home_url(); ?>"><img class="pulse" src="<?php $Zoo_Options->show('zo_footer_logo'); ?>"/></a>
	 			<?php 
	 			 $icons_display = $Zoo_Options->get('zo_footer_social_icons'); 
	 			 if($icons_display == 1){
	 			 	echo do_shortcode( '[social_networks]' );
	 			}
		 		?> 
		 		<small>© <?php $Zoo_Options->show('zo_copyright_text'); ?></small>
		 	</div>
		</div>		
	</footer>
	<script>
		var flex_slider_animation = "<?php $Zoo_Options->show('zo_flex_animation'); ?>",
			flex_slider_direction = "<?php $Zoo_Options->show('zo_flex_direction'); ?>",
			flex_slider_auto_play = "<?php $Zoo_Options->show('zo_flex_auto_play'); ?>",
			flex_slider_slideshowspeed = "<?php $Zoo_Options->show('zo_flex_play_speed'); ?>",
			flex_slider_controlnav = "<?php $Zoo_Options->show('zo_flex_controll'); ?>",
			testimonials_auto_play = "<?php $Zoo_Options->show('zo_testimonials_auto_play'); ?>",
			superslider_play = "<?php $Zoo_Options->show('zo_super_play'); ?>",
			superslider_pagination = "<?php $Zoo_Options->show('zo_super_pagi'); ?>",
			superslider_animation = "<?php $Zoo_Options->show('zo_super_animation'); ?>";
	</script>



	<?php if (is_front_page()) {?>
		<script>
			jQuery(document).ready(function($) {  
				$(".nav-links li a:contains('Home') , .nav-links li a:contains('home')").parent().addClass('nav-active');
				$(window).load(function () {
					if (Modernizr.history){
						history.replaceState('', document.title, window.location.pathname); 
					}
				});
			});
		</script>
	<?php }
	else { ?>
		<script>
			jQuery(document).ready(function($) {  
				if($('body').hasClass('single') || $('body').hasClass('archive') || $('body').hasClass('search') || $('body').hasClass('error404')){
					$(".nav-links li a:contains('Blog') , .nav-links li a:contains('blog')").parent().addClass('nav-active');
				}
			});
		</script>
	<?php } ?>      


<?php wp_footer(); ?>
</body>
</html>

