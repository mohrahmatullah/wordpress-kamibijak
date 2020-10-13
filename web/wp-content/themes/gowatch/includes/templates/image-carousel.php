<?php

/* Blockquote template below */
###########

// Get the options

$options = airkit_Compilator::$options;

$images = $options['bg-image'];
$images = explode(',', $images);

$slides = $additional_classes = '';

if( ! isset($options["carousel-height"]) ){
	$options["carousel-height"] = 400;
}

if( (int)$options["carousel-height"] == 0 ){
	$options["carousel-height"] = 400;
}

$i = 0;

foreach ( $images as $k => $image ) {

	$i++;

	$image_id = explode('|', $image, 2);
	$img_src = airkit_Compilator::get_attachment_field( $image_id[0], 'url', 'gowatch_grid' );

	if( ! empty( $img_src ) ) {

		if ( $additional_classes != '' ) {
			$additional_classes = 'class="'. $additional_classes .'"';
		}
		
		$slides .= '<div ' . $additional_classes . '><img alt="Carousel Image" '. Airkit_Images::lazy_img( $img_src, [ 'size' => 'gowatch_grid' ] ) .' /></div>';

	}
}
$slider_id = 'image-carousel-id-' . airkit_rand_string(8, '0-9');
?>
<div class="col-lg-12">
	<div class="image-carousel" id="<?php echo airkit_var_sanitize( $slider_id, 'esc_attr' );?>" >
		<div class="image-carousel-items">
			<?php echo airkit_var_sanitize( $slides, 'the_kses' ); ?>
		</div>
		<ul class="carousel-nav">
			<li class="carousel-nav-left icon-left"></li>
			<li class="carousel-nav-right icon-right"></li>
		</ul>
	</div>
</div>