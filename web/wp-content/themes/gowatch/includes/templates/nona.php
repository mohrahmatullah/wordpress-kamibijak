<?php

$options = airkit_Compilator::$options;
$width = isset( $options['width'] ) ? $options['width'] : 800;
$height = isset( $options['height'] ) ? $options['height'] : 450;


$featimage = get_the_post_thumbnail( $post->ID, 'gowatch_wide' );

?>
<article <?php post_class( 'nona-article' ); ?>>
	<figure class="image-holder">
		<a href="<?php the_permalink(); ?>">			
			<?php 
				echo airkit_var_sanitize( $featimage, 'true' );
				airkit_overlay_effect_type();
			?>			
		</a>
	</figure>
	<header>
		<div class="entry-content container">		
			<div class="nona-meta">
				<?php 
	            	echo airkit_PostMeta::categories( $post->ID );
	            	echo airkit_PostMeta::the_meta( $post->ID );
				 ?>
			</div>					
			<?php 
            	echo airkit_PostMeta::title( $post->ID );
			?>
			<div class="entry-excerpt">
				<?php airkit_excerpt(300, get_the_ID(), 'show-subtitle'); ?>
			</div>		
			<?php echo airkit_PostMeta::read_more( $post->ID ); ?>
		</div>
	</header>
</article>
<?php

$thumbnail = get_the_post_thumbnail( $post->ID, 'gowatch_small' );

airkit_Compilator::$options['nona-nav'] .=

'<article class="nona-nav">
	<figure class="image-holder">
		'. airkit_var_sanitize( $thumbnail, 'true' ) .'
	</figure>
	<header>
	    <span title="'. get_the_title() .'" class="post-link"></span>
		<h4 class="entry-title">' . esc_attr( get_the_title() ) . '</h4>
		<ul class="entry-meta">
		    '. airkit_PostMeta::date( $post->ID ) .'
		</ul>
	</header>
</article>';

