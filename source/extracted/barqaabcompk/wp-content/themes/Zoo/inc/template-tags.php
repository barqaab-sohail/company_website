<?php


if ( ! function_exists( '_s_content_nav' ) ) :

function _s_content_nav() {
	global $wp_query, $post;

	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	if ( is_single() ) :  ?>

		<?php next_post_link( '<div class="nav-next">%link</div>', 'Next Post' ); ?>
		<?php previous_post_link( '<div class="nav-previous">%link</div>', 'Previous Post' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-next"><?php next_posts_link( __( 'Older posts', 'zoo' ) ); ?></div>
		<?php endif; ?>
		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-previous"><?php previous_posts_link( __( 'Newer posts', 'zoo' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav>
	
	<?php
}
endif;

if ( ! function_exists( '_s_comment' ) ) :

function _s_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'zoo' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'zoo' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
       
        	<div class="row">
            	
            	<div class="c12 end">
                	<span class="comment-avartar" style="background:url(<?php echo get_avatar_url(get_avatar( $comment, 44 )); ?>) no-repeat center center;"></span>
                	<?php //echo get_avatar( $comment, 60 ); ?>
                
            	
            		<div class="comment-holder">
	                	<div class="comment-header">
	                	<?php printf( sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
						<time datetime="<?php comment_time( 'c' ); ?>">
						<?php
							/* translators: 1: date, 2: time */
							printf( __( '%1$s at %2$s - ', 'zoo' ), get_comment_date(), get_comment_time() ); ?>
						</time>
						<?php edit_comment_link( __( '(Edit)', 'zoo' ), ' ' ); ?>
	                 
	                    </div>
						<div class="comment-text"><?php comment_text(); ?></div>
						   <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	                		<?php if ( $comment->comment_approved == '0' ) : ?>
								<br/><em><?php _e( 'Your comment is awaiting moderation.', 'zoo' ); ?></em>
							<?php endif; ?>
	                	</div>

	                </div>	

            </div>

       
		</article>

	<?php
			break;
	endswitch;
}
endif; 

if ( ! function_exists( '_s_posted_on' ) ) :

function _s_posted_on() {
	$categories_list = get_the_category_list( __( ', ', 'zoo' ) );
	echo '<div class="row">';
	echo '<div class="c12 end">';
	echo '<div class="blog-bottom-bar">';
	printf( __( '<span>By <a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ). '">'.get_the_author().'</a><span class="sep"> | </span></span><span>
		 <time class="entry-date" datetime="%3$s">%4$s</time><span class="sep"> | </span></span><span> <span class="cat-links"> In %5$s </span><span class="sep"> | </span></span>', 'zoo' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
        $categories_list
	);
	if ( is_search() || is_archive() || is_home() ){
		echo '<a class="readmore" href="' .get_permalink(get_the_ID()).'">Read more</a>';
	}
	if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
		comments_popup_link( __( 'Leave a comment', 'zoo' ), __( '1 Comment', 'zoo' ), __( '% Comments', 'zoo' ) );
	endif;
	echo '</div>';
	echo '</div>';
	echo '</div>';

}
endif;


function _s_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}

function _s_category_transient_flusher() {

	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', '_s_category_transient_flusher' );
add_action( 'save_post', '_s_category_transient_flusher' );