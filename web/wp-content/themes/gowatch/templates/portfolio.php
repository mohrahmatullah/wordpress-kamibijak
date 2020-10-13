<?php 
/**
 * The template for displaying portfolio
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */

global $airkit_is_ajax_loading;

$airkit_sidebar = airkit_Compilator::build_sidebar( 'single', $post->ID );

$airkit_items = get_post_meta( get_the_ID(), 'ts_portfolio', true );
$airkit_details = get_post_meta( get_the_ID(), 'ts_portfolio_details', true );

?>
<div class="row">
	<?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' ); ?>
	<div id="primary" class="<?php echo airkit_var_sanitize( $airkit_sidebar['content_class'], 'esc_attr' ) ?>">
		<div id="content" role="main">
			<div class="row">
				<div class="col-lg-12">
					<article <?php airkit_element_attributes( array('class' => get_post_class('airkit_singular') ), array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>
						<div class="row">
							<div class="col-md-5 col-lg-5 portfolio-meta">
								<?php 
									echo airkit_PostMeta::categories( $post->ID );
									echo airkit_PostMeta::title( $post->ID, array( 'wrap' => 'h1', 'class' => 'post-title', 'url' => 'n', 'single' => 'y' ) );
									// Show meta, exclude date, as it is displayed in portfolio-custom meta.
									echo airkit_PostMeta::single_meta( $post->ID );
								?>

								<?php if( !empty($airkit_details['client']) && !empty($airkit_details['services']) && !empty($airkit_details['project_url']) ) : ?>
									<ul class="post-meta clearfix">
										<li class="client">
											<span><?php esc_html_e('Client','gowatch') ?></span>
											<div itemprop="sponsor"><?php echo esc_attr( $airkit_details['client'] ); ?></div>
										</li>
										<li class="category">
											<span><?php esc_html_e('Services','gowatch') ?></span>
											<div><?php echo esc_attr( $airkit_details['services'] ); ?></div>
										</li>
										<li class="url">
											<span><?php esc_html_e('URL','gowatch') ?></span>
											<div>
												<a href="<?php echo esc_url( $airkit_details['project_url'] ); ?>" target="_blank">
													<?php echo esc_attr( $airkit_details['project_url'] ); ?>
												</a>
											</div>
										</li>
										<li class="date">
											<span><?php esc_html_e('Share','gowatch') ?></span>
											<?php
												airkit_single_sharing();
											?>
										</li>									
									</ul>
								<?php endif; ?>
								<div class="post-content">
									<?php the_content(); ?>
									<?php edit_post_link( esc_html__( 'Edit', 'gowatch' ), '<span class="edit-link">', '</span>' ); ?>
									<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:', 'gowatch' ) . '</span>', 'after' => '</div>' ) ); ?>
								</div><!-- .entry-content -->
							</div>
							<div class="col-md-7 col-lg-7">

								<div class="featured-image portfolio-featured animatedParent" data-animation="fade" data-sequence="500">
									<ul>
									<?php
										$airkit_i = 0;
										foreach ( $airkit_items as $airkit_item ) {

											$airkit_i++;

											if ( $airkit_item['item_type'] == 'i' ) {

												$airkit_src = $airkit_item['item_url'];

												echo '<li class="animated fadeInUp" data-id="' . $airkit_i . '" itemprop="workExample">
												<img '. Airkit_Images::lazy_img( $airkit_src ) .' alt="' . esc_attr( $airkit_item['description'] ) . '" />';

												if ( airkit_option_value( 'general', 'enable_lightbox' ) === 'y' ) {

													echo '<a class="zoom-in-icon" href="' . esc_url( $airkit_item['item_url'] ) . '" data-fancybox="' . get_the_ID() . '"><i class="icon-search"></i></a>';

												}

												airkit_overlay_effect_type();

												echo '</li>';

											} elseif ( $airkit_item['item_type'] === 'v' ) {

												echo '<li class="animated fadeInUp" data-id="' . $airkit_i . '">
														<div class="embedded_videos">' . 
															apply_filters( 'the_content', $airkit_item['embed'] ) 
														. '
														</div>
													  </li>';

											}
										}
									?>
									</ul>
								</div> <!-- portfolio content -->
							</div>
						</div>
						<?php airkit_author_box( $post ); ?>

						<?php 

						if( !isset( $airkit_is_ajax_loading ) || false == $airkit_is_ajax_loading ) {
							airkit_get_pagination_next_previous();
						}
						
						 ?>
					</article><!-- #post-<?php the_ID(); ?> -->
				</div>
			</div>
		</div>
	</div>
<?php
	echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' );
 ?>	
</div>