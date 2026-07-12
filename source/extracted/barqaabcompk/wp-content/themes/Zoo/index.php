<?php get_header(); ?>

<div id="primary" class="grid">
<?php if ( have_posts() ) : ?>
	<header class="page-header">
		<div class="row">
			<div class="c12 end">
				<h1 class="page-title"><?php _e('Latest Posts','zoo') ?></h1>
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
<main id="main" class="site-content" role="main">

<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content'); ?>

<?php endwhile; ?>


<?php else : ?>

	<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>

</main>

<?php 
	$sidebar_pos = $Zoo_Options->get('zo_blog_sidebar');
	if($sidebar_pos == 2 || $sidebar_pos == 3 ){
		get_sidebar();
	}
?>
</div>	
<?php get_footer(); ?>


