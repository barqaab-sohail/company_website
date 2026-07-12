	<header class="page-header">
		<div class="row">
			<div class="c12 end">
				<h1 class="page-title"><?php _e( 'Nothing Found', 'zoo' ); ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="c12 end">
				<nav id="nav-above">
					<?php dimox_breadcrumbs(); ?>
				</nav>
			</div>
		</div>	
	</header>

	<main id="main" class="site-content" role="main">
		<div class="row">
			<div class="c12 end">
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
					<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'zoo' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
				<?php elseif ( is_search() ) : ?>
					<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'zoo' ); ?></p>
				<?php else : ?>
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'zoo' ); ?></p>
			</div>
		</div>
				<?php endif; ?>
	</main>

