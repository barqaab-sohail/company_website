<?php get_header(); ?>
<main id="main" role="main">
<?php while ( have_posts() ) : the_post(); ?>
	<?php
		global $post;
		$bgcolor = get_post_meta( $post->ID, '_cmb_background_colorpicker', true );
		$bgimage = get_post_meta( $post->ID, '_cmb_background_image', true );
		$descriptiontext = get_post_meta( $post->ID, '_cmb_description_text', true );
		$headingstyle = get_post_meta( $post->ID, '_cmb_heading_style', true );
	?>
	<div class="page" style='background-color:<?php echo $bgcolor ?>;<?php  if (!empty($bgimage)) { echo "background-image:url($bgimage);"; } ?>'>
		<div class="grid">
				<div class="c12 end">
					<?php if($headingstyle == "dropcap"){
						echo "<p class='drop-cap zoo-page-title'>" . get_the_title()."  - <span>$descriptiontext</span></p>";
						}
					elseif ($headingstyle == "standard") {
						echo "<h1>" . get_the_title() . "</h1>";
						echo "<p class='zoo-page-title'><span>$descriptiontext</span></p>";
					}
					elseif ($headingstyle == "noheading") {
						echo "<p class='zoo-page-title'><span>$descriptiontext</span></p>";
					}
					?>
				</div>
				<?php the_content(); ?>
		</div>
	</div>

<?php endwhile;  ?>
</main>	

<?php get_footer(); ?>

