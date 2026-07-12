<?php

	if ( post_password_required() )
		return;
?>

	<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'zoo' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'zoo' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'zoo' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
		<div class="row">
			<div class="c12 end">
				<h4 class="total-comment"><?php comments_number( 'no comments', '1 comment', '% comments' ); ?></h2>
			</div>
		</div>	
		<ul class="commentlist">
			<?php
				wp_list_comments( array( 'callback' => '_s_comment' ) );
			?>
		</ul><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h4 class="assistive-text"><?php _e( 'Comment navigation', 'zoo' ); ?></h4>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'zoo' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'zoo' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
	
	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	
	<p class="nocomments c12 end"><?php _e( 'Comments are closed.', 'zoo' ); ?></p>
	

	<?php endif; 
	
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' ); ?>

	<?php comment_form( 

	array( 
		'id_submit' => __('comment_submit', 'zoo'),
		'title_reply' => '<span class="c12 end"><span>'. __('Leave a comment', 'zoo'), 
		'title_reply_to' => __('Leave a comment %s', 'zoo'), 
		'cancel_reply_link' => __('Cancel comment', 'zoo').'</span></span>',
		'label_submit' => __('Post comment', 'zoo'),
		'comment_field' => '<div class="c12 end"><textarea id="comment" name="comment" placeholder="' . __('Comment', 'zoo') . '" cols="45" rows="8" aria-required="true"></textarea>',	
		'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' => '<div class="c4"><input id="author" name="author" type="text" placeholder="'. __('Name(Required)', 'zoo') . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
		'email' => '<div class="c4"><input id="email" name="email" type="text" placeholder="' . __('Email(Required)', 'zoo') . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
		'url' => '<div class="c4 end"><input id="url" name="url" type="text" placeholder="Website" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'	
		)),
		'comment_notes_before' => '',
		'comment_notes_after' => '</div>'
		)
	);
	?>



	
</div>