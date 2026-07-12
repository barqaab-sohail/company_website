
<section id="secondary" class="widget-area c3 end" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

	<aside id="search" class="widget widget_search">
		<?php get_search_form(); ?>
	</aside>

	<aside id="archives" class="widget">
		<h6 class="widget-title"><?php _e( 'Archives', 'zoo' ); ?></h6>
		<ul>
		<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
		</ul>
	</aside>

	<aside id="meta" class="widget">
		<h6 class="widget-title"><?php _e( 'Meta', 'zoo' ); ?></h6>
		<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<?php wp_meta(); ?>
		</ul>
	</aside>

	<?php endif; ?>
</section>
