<?php get_header(); ?>

		<div id="primary" class="grid">
   
			<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<div class="row">
						<div class="c12 end">
								<h1 class="page-title">
							<?php
							if ( is_category() ) :
							single_cat_title();

							elseif ( is_tag() ) :
							single_tag_title();

							elseif ( is_author() ) :

							the_post();
							printf( __( 'Author: %s', 'zoo' ), '<span class="vcard">' . get_the_author() . '</span>' );
			
							rewind_posts();

							elseif ( is_day() ) :
							printf( __( 'Day: %s', 'zoo' ), '<span>' . get_the_date() . '</span>' );

							elseif ( is_month() ) :
							printf( __( 'Month: %s', 'zoo' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

							elseif ( is_year() ) :
							printf( __( 'Year: %s', 'zoo' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

							elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'zoo' );

							elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'zoo');

							elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'zoo' );

							elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'zoo' );

							elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'zoo' );

							else :
							_e( 'Archives', 'zoo' );

							endif;
							?>
							</h1>
				
							<?php
							if ( is_category() ) {
								$category_description = category_description();
								if ( ! empty( $category_description ) )
									echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

							} elseif ( is_tag() ) {
								$tag_description = tag_description();
								if ( ! empty( $tag_description ) )
									echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
							}?>

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
					<?php
						get_template_part('content', get_post_format() );
					?>
				<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'no-results', 'archive' ); ?>
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