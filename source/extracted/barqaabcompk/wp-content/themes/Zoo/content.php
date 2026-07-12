
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_search() || is_archive() || is_home() ) : ?>
			<div class="entry-summary">
				
				
					<?php $featured_image_url = get_the_post_thumbnail($post->ID);
					if($featured_image_url){
						echo '<div class="c12 end">';	
									echo '<a class="recent-post-img" href="'.get_permalink(get_the_ID()).'" >';
									echo get_the_post_thumbnail($post->ID);
									echo '</a>';
									echo '<span class="date">'.get_the_date('\<\s\p\a\n \c\l\a\s\s\=\"\d\a\y\"\>j\<\/\s\p\a\n\> M Y').'</span>'; 	
						echo'</div>';	
					}
					?>


					<div class="c12 end">
						<h2 class="entry-title"><a href="<?php echo get_permalink(get_the_ID()) ?>"><?php the_title(); ?></a></h2>
				
						<?php if ( has_excerpt() ) 
							{
							    $the_excerpt = get_the_excerpt();
							    echo "<p>$the_excerpt</p>";
							} 
							else 
							{
							    $the_excerpt = get_special_excerpt(3072);
								$the_excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $the_excerpt);
								$the_excerpt = string_limit_words($the_excerpt, 75);
								echo "<p>$the_excerpt</p>";
							}
						?>
					</div>
			</div>

		
		<?php else : ?>
				<div class="row">
					<div class="c12 end">
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'zoo' ) ); ?>
						<?php
						wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'zoo' ),
						'after' => '</div>',
						) );
						?>
					</div>
				</div>
					
		<?php endif; ?>
		     
				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						
						<?php if ( is_search() || is_archive() || is_home() ) {
							_s_posted_on();

						} 
						
						else{
								$tags_list = get_the_tag_list( '', __( ', ', 'zoo' ) );
								if ( $tags_list ) :?>
									<div class="row">
										<div class="c12 end">
											<span class="tags-links">
											<?php printf( __( 'Tagged %1$s', 'zoo' ), $tags_list ); ?>
											</span>
										</div>	
									</div>	
								<?php endif; 
								_s_posted_on();?>
				<?php 
				} ?> 
				</div>
				<?php
				
				 endif; ?>

</article>


