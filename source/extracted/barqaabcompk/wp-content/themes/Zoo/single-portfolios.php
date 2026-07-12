
<noscript><?php get_header(); ?></noscript>
	
	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="grid">		
				<?php the_content(); ?>
			</div>        
		</article>
		
	<?php endwhile; ?>
		
<noscript><?php get_footer(); ?></noscript>

