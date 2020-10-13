<?php
/**
 * Gallery template
 */

$options 			= airkit_Compilator::$options;
$gallery_classes	= array();
$article_classes	= array('item');
$prefix             = 'gallery-';
$style 				= isset($options['style']) ? $options['style'] : 'masonry';

$gallery_classes[] 	= $prefix . $style;

if( empty( $options['images'] ) ) {
	return;	
}

$attachments = explode( ',', $options['images'] );

if( 'horizontal' == $style ) {

	$gallery_classes[] = 'scroll-view';

} elseif( 'masonry' == $style ) {

	$cols = isset( $options['per-row'] ) ? $options['per-row'] : 3; //get from @options['per-row'];
	$article_classes['column'] = airkit_Compilator::get_column_class( $cols );

}

/*Get animation classes. If there will be more gallery styles, edit from every gallery templates .*/
$gallery_classes[] 	= airkit_Compilator::parent_effect( $options );
$article_classes[]	= isset( $options['classes'] ) ? $options['classes'] : '';
$article_classes[] 	= airkit_Compilator::child_effect( $options );

?>
<div class="col-md-12">
	<div class="airkit_gallery-content <?php echo implode(' ', $gallery_classes); ?>">

		<?php if ( 'carousel' === $style ): ?>
			<div class="gallery-content-items">
		<?php endif ?>

		<?php 
		foreach ( $attachments as $attachment ):

			$full_img_url = airkit_Compilator::get_attachment_field( $attachment, 'url', 'full' );
			$image = airkit_Compilator::get_attachment_field( $attachment, 'query' );
			$url_image = get_post_meta( $image->ID, 'ts-image-url', true );

			$title = $image->post_title;
			$desc = $image->post_content;
		?>

		<article class="<?php echo implode(' ', $article_classes) ?>">
			<?php if ( 'carousel' !== $style ): ?>
				<header>
					<h2 class="image-title"><?php echo airkit_var_sanitize( $title, 'the_kses' ); ?></h2>
					<div class="description"><?php echo airkit_var_sanitize( $desc, 'the_kses' ); ?></div>
					<ul class="image-controls">
						<li class="box">
							<a class="zoom-in" href="<?php echo esc_url( $full_img_url ); ?>" data-fancybox><i class="icon-search"></i></a>
						</li>
						<li>
							<a href="<?php echo esc_url( $url_image ); ?>" target="_blank"><i class="icon-link-ext"></i></a>	
						</li>
						<li class="share-box">
							<a href="#" class="share-link">
								<i class="icon-share"></i>
							</a>
							<ul class="social-sharing share-menu">
								<li class="share-item">
									<a class="facebook" title="<?php esc_html_e('Share on facebook','gowatch'); ?>" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($full_img_url); ?>"><i class="icon-facebook"></i></a>
								</li>
								<li class="share-item">
									<a class="icon-twitter" title="<?php esc_html_e('Share on twitter','gowatch'); ?>" target="_blank" href="http://twitter.com/home?status=<?php echo urlencode( $title ); ?>+<?php echo esc_url($full_img_url); ?>"></a>
								</li>
								<li class="share-item">
									<a class="icon-pinterest" title="<?php esc_html_e('Share on pinterest','gowatch'); ?>" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php esc_url( $url_image ); ?>&amp;media=<?php echo esc_url($full_img_url) ?>&amp;description=<?php echo esc_attr($desc) ?>" ></a>
								</li>
							</ul>						
						</li>
					</ul>
					<a href="<?php echo esc_url( $full_img_url ) ?>" data-fancybox="group"></a>
				</header>
			<?php endif ?>

			<figure>
				<?php
					if ( 'carousel' === $style ) {

						echo '<a href="' . esc_url( $full_img_url ) .'" data-fancybox="group" data-caption="<h4>' . esc_html($title) . '</h4><p>'. esc_html($desc) .'</p>">' . 
								wp_get_attachment_image( $image->ID, 'gowatch_wide' ) .
								airkit_overlay_effect_type(false) . 
							'</a>';
					} elseif ( 'carousel' === $style ) {
						echo wp_get_attachment_image( $image->ID, 'gowatch_grid_masonry' );
						airkit_overlay_effect_type();
					} else {

						echo wp_get_attachment_image( $image->ID, 'gowatch_wide' );
						airkit_overlay_effect_type();
					}
				?>

				<?php if ( 'carousel' === $style ): ?>
					<figcaption>
						<h3 class="image-title"><?php echo airkit_var_sanitize( $title, 'the_kses' ); ?></h3>
					</figcaption>
				<?php endif ?>
			</figure>
		</article>

		<?php

		endforeach;

		if ( 'carousel' === $style ): ?>
			</div>
			<ul class="carousel-nav">
				<li class="carousel-nav-left icon-left-arrow"><span><?php echo esc_html__('Prev', 'gowatch') ?></span></li>
				<li class="carousel-nav-right icon-right-arrow"><span><?php echo esc_html__('Next', 'gowatch') ?></span></li>
			</ul>
		<?php endif ?>

	</div><!-- end gallery element -->
</div>