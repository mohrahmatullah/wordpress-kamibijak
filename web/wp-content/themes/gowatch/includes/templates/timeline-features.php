<?php

$options = airkit_Compilator::$options;

$items = !empty( $options['items'] ) ? $options['items'] : '';

if( is_array( $items ) && !empty( $items ) ) : ?>

	<div class="timeline-features-view">

	<?php foreach( $items as $item ) :
		
		$image = '';

		if( !empty( $item['image'] ) ) {
			$image = '<img '. Airkit_Images::lazy_img( airkit_Compilator::get_attachment_field( $item['image'], 'url', 'gowatch_grid' ) ) .' alt="'. $item['title'] .'">';
		}	

		$parent_effect = airkit_Compilator::parent_effect( $item );
		$child_effect = airkit_Compilator::child_effect( $item );

		?>

		<?php if ( '' !== $parent_effect ): ?>
			<div class="<?php echo esc_attr( $parent_effect ); ?>">
		<?php endif ?>

			<article class="<?php echo airkit_var_sanitize( $item['align'], 'esc_attr' ); echo airkit_var_sanitize( $child_effect, 'esc_attr' ); ?>">
				<figure>
					<div class="timeline-image">
						<?php echo airkit_var_sanitize( $image, 'the_kses' ); ?>
					</div>
				</figure>
				<header>
					<h3 class="entry-title"><?php echo airkit_var_sanitize( $item['title'], 'the_kses' ); ?></h3>
					<div class="entry-description">
						<?php echo apply_filters( 'the_content', $item['text'] ); ?>
					</div>
				</header>
			</article>

		<?php if ( '' !== $parent_effect ): ?>	
			</div>
		<?php endif; ?>
	<?php endforeach; ?>

	</div>

<?php endif; ?>