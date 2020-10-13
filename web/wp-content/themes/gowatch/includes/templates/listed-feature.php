<?php

/* Thumbnail view template below */
###########

// Get the options

$options = airkit_Compilator::$options;
$attributes = array();

$attributes['class'][] = 'airkit_style-' . $options['color-style'];
$attributes['class'][] = 'icon-box-card';

foreach ( $options['items'] as $feature ) :

	if ( 'border' == $options['color-style'] ) {

		$attributes['style'] = 'border-color: ' . $feature['border-color'] . ';color: ' . $feature['font-color'] . ';';

	} elseif ( 'background' == $options['color-style'] ) {

		$attributes['style'] = 'background-color: ' . $feature['bg-color'] . ';color: ' . $feature['font-color'] . ';border-color: transparent;';

	} else {

		$attributes['style'] = 'color: ' . $feature['font-color'] . ';';
	}
	
	$parent_effect = airkit_Compilator::parent_effect( $feature );
	$attributes['class'][] = airkit_Compilator::child_effect( $feature );
	$attributes['class'][] = $options['align'];
?>
	<div class="col-lg-12 col-md-12 col-sm-12<?php echo esc_attr( $parent_effect ); ?>">

		<div <?php airkit_element_attributes(array('class' => $attributes['class'])); ?>>

			<div class="icon-box-cont" <?php airkit_element_attributes(array('style' => $attributes['style'])); ?>>
				<i class="<?php echo esc_attr( $feature['icon'] ); ?>"></i>
			</div>

			<div class="icon-box-content">
				<?php if ( ! empty( $feature['url'] ) ) : ?>
					<h3 class="title">
						<a href="<?php echo esc_url( $feature['url'] ); ?>">
							<?php echo esc_attr( $feature['title'] ); ?>
						</a>
					</h3>
				<?php else : ?>
					<h3 class="title">
						<?php echo esc_attr( $feature['title'] ); ?>
					</h3>
				<?php endif; ?>
				<?php echo apply_filters( 'the_content', $feature['text'] ); ?>
			</div>

		</div>

	</div>
<?php endforeach; ?>