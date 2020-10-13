<?php
get_header();

$custom_options = get_post_meta( $post->ID, 'airkit_header_and_footer', true );

if ( isset( $custom_options['breadcrumbs'] ) && $custom_options['breadcrumbs'] == 0 && !is_front_page() && airkit_option_value( 'single', 'page_breadcrumbs' ) == 'y' ) : ?>
	<div class="airkit_breadcrumbs breadcrumbs-single-post container">
		<?php echo airkit_breadcrumbs(); ?>
	</div>
<?php endif;

if ( isset( $custom_options['enable_preloader'] ) && $custom_options['enable_preloader'] == 1 && 'y' !== airkit_option_value( 'general', 'enable_preloader' ) && 'fp' !== airkit_option_value( 'general', 'enable_preloader' ) ) : ?>
	<div class="airkit_page-loading">
		<div class="airkit_ball" id="a">
			<div class="airkit_inner-ball"></div>
		</div>
		<div class="airkit_ball" id="b">
			<div class="airkit_inner-ball"></div>
		</div>
		<div class="airkit_ball" id="c">
			<div class="airkit_inner-ball"></div>
		</div>
	</div>
<?php endif;

if ( have_posts() ) :

	if ( airkit_Compilator::builder_is_enabled() ):

		airkit_Compilator::run();

	else:

		$airkit_sidebar = airkit_Compilator::build_sidebar( 'page', $post->ID ); 
	?>

		<div id="main" class="ts-single-post ts-single-page">
			<div class="container">
				<div class="row">
					<?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' ); ?>

					<div class="<?php echo esc_attr( $airkit_sidebar['content_class'] ); ?>">
						<div id="content" role="main">
							<?php while ( have_posts() ) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

									<?php airkit_featured_image( array('is-single' => true) ); ?>

									<header class="post-header">
										<?php
											echo airkit_PostMeta::post_format( $post->ID );
											echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'post-categories entry-categories' ) );
											echo airkit_PostMeta::title( $post->ID, array( 'wrap' => 'h2', 'class' => 'post-title', 'url' => 'n', 'single' => 'y' ) );
										?>
									</header>

									<aside class="post-meta">
										<?php
											if ( 'n' != airkit_option_value('single', 'meta') &&  'n' != airkit_single_option('meta') ) {
												echo airkit_PostMeta::single_meta( $post->ID, array(), array( 'author', 'comments', 'likes' ) );
											}
											echo airkit_PostMeta::microdata();
											airkit_single_sharing( array('label' => 'y', 'tooltip-popover' => 'n', 'style' => 'button-sharing') );
										?>
									</aside>

									<div class="post-content">
										<?php
											echo airkit_PostMeta::subtitle( $post->ID, array( 'single' => 'y' ) );

											do_action( 'airkit_above_single_content' );

											echo '<div class="the-content">';
												$content = apply_filters( 'the_content', get_the_content() );
												airkit_check_subscribers_only($content);
											echo '</div>';

											do_action( 'airkit_below_single_content' );
										?>
									</div>
									<div class="text-center post-footer">
									<?php 
										echo airkit_PostMeta::rating_single( $post->ID );

										if ( airkit_option_value( 'single', 'page_authorbox' ) == 'y' ) {
											airkit_author_box( $post );
										}

										wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:', 'gowatch' ) . '</span>', 'after' => '</div>' ) );

										comments_template( '', true );
									?>
									</div>

								</article><!-- #post-<?php the_ID(); ?> -->
								
							<?php endwhile; // end of the loop. ?>
						</div>
					</div>
					<?php echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' ); ?>
				</div>
			<?php
	endif;
endif;

if ( ! airkit_Compilator::builder_is_enabled() ) : ?>
		</div>
	</div>

<?php endif;

get_footer(); ?>
