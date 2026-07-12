<?php get_header(); ?>

	<div id="primary" class="grid">
			<header class="entry-header">
				<div class="row">
					<div class="c12 end">
						
						<h1 class="entry-title"><span class="accent"><?php _e("Page Not Found!.", 'zoo'); ?></span></h1>
					</div>
				</div>
				
			</header>


			<article id="post-0" class="post error404 not-found">
				<div class="row">
					<div class="c12 end">
						<?php get_search_form(); ?>
					</div>
				</div>
				<div class="row">
					<div class="c12 end">
						<p><?php _e( 'The page you are looking for may have moved to a new location. Try a search?', 'zoo' ); ?></p>
					</div>
				</div>	
			</article>

	</div>

<?php get_footer(); ?>