<?php

/* Team view template below */
###########

// Get the options

$options 		= airkit_Compilator::$options;
$meta 			= get_post_meta( get_the_ID(), 'ts_member', true);
$lazyload 		= airkit_option_value( 'general', 'enable_imagesloaded' );
$position 		= (trim(@$meta['position']) !== '') ? esc_attr($meta['position']) : '';
$about_member 	= (isset($meta['about_member'])) ? esc_attr($meta['about_member']) : '';
$ignore_meta 	= array('about_member', 'position', 'team-user');


$socials = '<ul>';

foreach ($meta as $key => $item) {
	
	if ( !in_array( $key, $ignore_meta ) && !empty( $item ) ) {
		$item = trim((string)$item);
		
		if ( 'youtube' === $key ) {
			$socials .= '<li><a href="'. esc_url($item) .'"><i class="icon-video"></i></a></li>';
		} elseif ( 'email' === $key ) {
			$socials .= '<li><a href="'. esc_url($item) .'"><i class="icon-mail"></i></a></li>';
		} elseif ( 'dribble' === $key ) {
			$socials .= '<li><a href="'. esc_url($item) .'"><i class="icon-dribbble"></i></a></li>';
		} else {
			$socials .= '<li><a href="'. esc_url($item) .'"><i class="icon-'. $key .'"></i></a></li>';
		}
	}

}

$socials .= '</ul>';

$image_url = get_the_post_thumbnail_url( $post->ID, 'gowatch_small' ); // Get image url

// Get article columns by elements per row
$columns_class = airkit_Compilator::get_column_class( $options['per-row'] );
$columns_class .= airkit_Compilator::parent_effect( $options );
$article_class = airkit_Compilator::child_effect( $options );

?>
<div class="<?php echo airkit_var_sanitize( $columns_class, 'esc_attr' ); ?>">
	<article  <?php post_class( $article_class ); ?>>
		<a href="<?php echo get_the_permalink(); ?>"></a>

		<?php if ( has_post_thumbnail() ): ?>

			<?php if ( 'y' === $lazyload ): ?>
				<figure class="image-holder lazy" data-original="<?php echo esc_url($image_url); ?>">
			<?php else: ?>
				<figure class="image-holder" style="background-image: url(<?php echo esc_url($image_url); ?>)">
			<?php endif ?>

			<?php
				airkit_overlay_effect_type();
			?>
			</figure>
			
		<?php endif ?>

		<header>
			<?php echo airkit_PostMeta::title( $post->ID, array('url' => 'n') ); ?>

			<h5 class="position"><?php echo airkit_var_sanitize( $position, 'the_kses' ); ?></h5>
			<p class="article-excerpt">
				<?php echo airkit_var_sanitize( $about_member, 'the_kses' ); ?>
			</p>	
			<div class="airkit_social-icons background">
				<?php echo airkit_var_sanitize( $socials, 'the_kses' ); ?>
			</div>
		</header>
	</article>
</div>