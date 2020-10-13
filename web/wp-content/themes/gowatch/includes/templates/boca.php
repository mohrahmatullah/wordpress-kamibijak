<?php

global $post;

$options = airkit_Compilator::$options;
$taxonomy = airkit_Compilator::get_tax( $post->post_type );
$categories = wp_get_post_terms( $post->ID, $taxonomy );

?>
<article class="row">
	<header class="col-lg-5 col-md-5 col-sm-12">
		<a href="<?php the_permalink(); ?>">			
			<?php 
				echo get_the_post_thumbnail( $post->ID, 'gowatch_grid' );
				airkit_overlay_effect_type();
			?>			
		</a>
		<?php if ( get_post_type( $post->ID ) == 'video' ) : ?>
			<a href="<?php the_permalink(); ?>" class="entry-play-btn icon-play"></a>
		<?php endif; ?>
		<?php if ( !empty($categories) ) : ?>
			<ul class="entry-meta-category">
				<?php foreach ( $categories as $category ) : ?>
					<li>
						<a href="<?php echo get_term_link($category->slug, $taxonomy); ?>">
							<?php echo esc_attr($category->name) ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</header>
	<section class="col-lg-7 col-md-7 col-sm-12">
		<div class="entry-content-slider">
			<?php echo airkit_PostMeta::title( $post->ID ); ?>
			<span class="entry-meta-date"><i class="icon-calendar"></i><?php echo get_the_date(); ?></span>
			<div class="entry-excerpt">
				<?php airkit_excerpt(200, get_the_ID(), 'show-subtitle', true); ?>
			</div>
			<div class="slider-footer">
				<a href="<?php the_permalink(); ?>" class="ts-btn-slider"><?php esc_html_e('READ MORE', 'gowatch'); ?></a>
				<ul class="customNavigation">
					<li><span class="ar-left slick-arrow"><i class="icon-left"></i></span></li>
					<li><span class="ar-right slick-arrow"><i class="icon-right"></i></span></li>
				</ul>
			</div>
		</div>
	</section>
</article>