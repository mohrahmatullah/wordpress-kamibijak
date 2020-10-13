<?php

$options 			= airkit_Compilator::$options;
$article_classes 	= array();

if ( 'y' == $options['tilt-hover-effect'] ) {
	$article_classes[] = 'airkit_tilter tilter';
}

$article_classes[] = $options['item']['post_class'];

$article_atts['class'] = get_post_class( $article_classes );

$article_atts['data-img-sm'] = esc_url( $options['item']['featimage_sm'] );
$article_atts['data-img-lg'] = esc_url( $options['item']['featimage_lg'] );
?>
<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $options['item']['id'] ); ?>>
	<?php
		echo airkit_PostMeta::post_is_featured( $options['item']['id'], array( 'element' => 'tilter-slider' ) );
	?>
	<figure class="tilter-slider-figure image-holder">
		<a href="<?php the_permalink($options['item']['id']); ?>">			
			<?php echo airkit_var_sanitize( $options['item']['featimage'], 'true' ); ?>
		</a>
	</figure>
	<header class="tilter-slider-header">
		<div class="container">	
			<div class="entry-content">
				<?php if ( 'y' == $options['tilt-hover-effect'] ): ?>
					<div class="tilter__deco--lines"></div>
					<div class="tilter__caption">
				<?php endif ?>

				<?php 
					echo airkit_PostMeta::categories( $options['item']['id'] );
	            	echo airkit_PostMeta::title( $options['item']['id'], array('wrap' => 'h3') );
	            	echo airkit_PostMeta::microdata();
				?>

				<?php if ( 'y' == $options['tilt-hover-effect'] ): ?>
					</div>
				<?php endif ?>
			</div>
			<div class="entry-meta">
				<ul class="tilter-slider-meta">
					<?php
						echo airkit_PostMeta::date( $options['item']['id'], array('enable_human_time' => 'y', 'element' => 'tilter-slider') );
						echo airkit_PostMeta::reading_time( $options['item']['id'], array('element' => 'tilter-slider') );
						echo airkit_PostMeta::views( $options['item']['id'], array('element' => 'tilter-slider') );
					?>	
				</ul>
			</div>
		</div>
	</header>
</article>

