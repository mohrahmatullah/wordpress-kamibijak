<?php

$options = airkit_Compilator::$options;

$collapse_id = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
$i = $options['i'];
$accordion_id = $options['accordion_id'];
?>

<div class="panel panel-default" role="tab">
	<div class="panel-heading" role="tab" id="ts-<?php echo airkit_var_sanitize($collapse_id, 'esc_attr'); ?>">
		<article <?php echo post_class(); ?>>
			<?php if ( has_post_thumbnail( $post->ID ) ): ?>
				<figure>
					<?php 			
						echo get_the_post_thumbnail( $post->ID, 'gowatch_small' );
						airkit_overlay_effect_type();
					?>
				</figure>
			<?php endif ?>
			<header>
				<?php 
					echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h3', 'url' => 'n', 'postfix' => '<i class="icon-down"></i>') );
					echo '<ul class="entry-meta">'.  airkit_PostMeta::date( $post->ID ) . '</ul>';
				?>
			</header>
		</article>	
		<a href="#<?php echo esc_attr( $collapse_id ); ?>" 
		    data-toggle="collapse" 
			data-parent="#<?php echo esc_attr( $accordion_id ); ?>" 
			aria-expanded="true" 
			aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
		</a>
	</div>
	
	<div id="<?php echo airkit_var_sanitize( $collapse_id, 'esc_attr' ); ?>" class="panel-collapse collapse<?php if( $i == 1 ) echo ' in' ?>" role="tabpanel" aria-labelledby="ts-<?php echo airkit_var_sanitize($collapse_id, 'esc_attr'); ?>">
		<article <?php echo post_class(); ?>>
		
			<?php
				airkit_featured_image( $options, array('post_format', 'post_is_featured', 'post_rating', 'post_sticky') );
				airkit_entry_content( $options, array('meta') );
			?>

		</article>
	</div>
</div>


