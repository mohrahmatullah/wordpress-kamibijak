<?php
	$atts = array();
	$comments_count = get_comments_number();

	$atts['id'] 	= 'comments';
	$atts['class'][] = 'post-comments';

	if ( '0' == $comments_count ) {
		$atts['class'][] = 'no-comments';
	}
?>

	<section <?php echo airkit_Compilator::render_atts($atts); ?>>

	<?php if ( airkit_option_value( 'general', 'comment_system' ) === 'facebook' ) : ?>

		<h3 class="comments-title" id="comments-title"><?php esc_html_e('Recent comments', 'gowatch'); ?><i class="icon-down"></i></h3>
		<div class="fb-comments" data-href="<?php echo get_permalink( get_the_ID() ); ?>" data-numposts="5"></div>

	<?php else : ?>

	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', 'gowatch' ); ?></p>
	</section><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;

		if( comments_open() ):
	?>	
	<h2 id="comments-title" class="comments-title">
		<?php esc_html_e( 'Join the discussion', 'gowatch' ); ?>
		<i class="comments-toggle icon-right-arrow-thin"></i>
	</h2>

	<?php 
		else:
			if( get_post_type( get_the_ID() ) !== 'page' ):
	 ?>
				<h2 id="comments-title" class="comments-title comments-closed">
					<i class="icon-comments"></i>
					<?php
						esc_html_e( 'Comments are closed', 'gowatch' );
					?>
				</h2>
	<?php 
			endif;
		endif;
	 ?>

	<?php if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php esc_html_e( 'Comment navigation', 'gowatch' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'gowatch' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'gowatch' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use airkit_touchsize_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define airkit_touchsize_comment() and that will be used instead.
				 * See airkit_touchsize_comment() in gowatch/includes/functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'airkit_touchsize_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php esc_html_e( 'Comment navigation', 'gowatch' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'gowatch' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'gowatch' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<?php endif; ?>

	<?php
		$args = array(
			'comment_field' => '<p class="comment-form-comment">
									<label for="comment">' . _x( 'Comment', 'noun', 'gowatch' ) .'<span class="required">*</span></label>
									<textarea id="comment" name="comment" cols="45" rows="7" aria-required="true"></textarea>
								</p>',
		);

		comment_form($args);

	?>
	<?php endif ?>
</section><!-- #comments -->

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>