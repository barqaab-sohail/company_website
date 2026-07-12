<?php get_header(); ?>

<div id="primary" class="grid">         
	<?php while ( have_posts() ) : the_post(); ?>
	<header class="page-header">
		<div class="row">
			<div class="c12 end">
					<h1><?php the_title(); ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="c12 end">
				<nav id="nav-above">
					<?php dimox_breadcrumbs(); ?>
					<?php _s_content_nav(); ?>
				</nav>
			</div>
		</div>
	</header>
	<main class="site-content" role="main">
		<?php get_template_part('content'); ?>
		<?php
			if ( comments_open() || '0' != get_comments_number() )
			comments_template( '', true );
		?>
		<?php endwhile; ?>
	</main>
	<?php 
	$sidebar_pos = $Zoo_Options->get('zo_blog_sidebar');
	if($sidebar_pos == 2 || $sidebar_pos == 3 ){
		get_sidebar();
	}
	?>
</div>

<?php get_footer(); ?>



