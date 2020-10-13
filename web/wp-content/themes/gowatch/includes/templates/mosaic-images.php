<?php

$options = airkit_Compilator::$options;

if ( !isset( $options['items'] ) || !is_array( $options['items'] ) ) {
	return;
}

$layout_mosaic = (isset($options['layout'])) ? $options['layout'] : 'rectangles';
$gutter = (isset($options['gutter']) && $options['gutter'] == 'n') ? 'no-gutter' : '';

// Hover style class
$options['hover-style'] = isset( $options['hover-style'] ) ? $options['hover-style'] : 'always';
$hover_style = ' effect-' . $options['hover-style'];

// Add link style class
if( isset( $options['link-style'] ) && 'button' === $options['link-style'] ) {

	$hover_style .= ' button-link';

}

// Start Items Loop.
foreach ( $options['items'] as $item ):

	$url = airkit_Compilator::get_attachment_field( $item['image'] );
	$sizes = airkit_PostMeta::mosaic_sizes( airkit_Compilator::$options );

	$url_link = isset( $item['url'] ) ? $item['url'] : '';
	$title = isset( $item['title'] ) ? $item['title'] : '';

	$image_url = airkit_Compilator::get_attachment_field( $item['image'], 'url', $sizes['image_size'] );

?>

<div class="item <?php echo airkit_var_sanitize( $sizes['class'], 'esc_attr' ); ?>">
	<article <?php post_class( $hover_style ); ?> >
		<figure class="image-holder has-background-img lazy" data-original="<?php echo esc_url($image_url); ?>" >
			<?php 
				airkit_overlay_effect_type();					
			?>
			<a href="<?php the_permalink(); ?>" class="post-link"></a>
		</figure>
		
		<?php if( !empty( $url_link ) ): ?>
			<header>
				<div class="entry-content">
					<a href="<?php echo esc_url( $url_link) ?>" class="entry-title" target="<?php echo esc_attr( $item['target'] ); ?>" rel="nofollow">
						<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>				
					</a>
				</div>
			</header>
		<?php endif; ?>
	</article>
</div>

<?php

// Update loop variables.
airkit_Compilator::$options['k']++;

if( airkit_Compilator::$options['k'] === 7 && $layout_mosaic == 'rectangles' ){

	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;

}

if( airkit_Compilator::$options['k'] === 6 && $layout_mosaic == 'square' ){

	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;

}

if( airkit_Compilator::$options['k'] === 4 && $layout_mosaic == 'style-3' ){
	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;
}

endforeach;

?>