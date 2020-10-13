<?php

$options = airkit_Compilator::$options;
$image = airkit_Compilator::get_attachment_field( $options['image'], 'url', 'gowatch_wide' );
$css = '';

if( !empty( $image ) ) {

	$image = '<img '. Airkit_Images::lazy_img( $image ) .' alt="'. $options['title'] .'">';

}

if( isset( $options['background'] ) ) {

	$css = 'background-color: '. $options['background']. '; border-color: '. $options['background'] . ';';
	
}

$text_color = 'color: ' . ( isset( $options['text-color'] ) ? $options['text-color'] : 'inherit' ) . ';';

$button = array(
	'button-align' 		=> @$options['button-align'],
	'mode-display' 		=> @$options['button-mode-display'],
	'border-color' 		=> @$options['button-border-color'],
	'border-hover-color'=> @$options['border-hover-color'],
	'bg-color'     		=> @$options['button-background-color'],
	'bg-hover-color'    => @$options['background-hover-color'],
	'text-color'   		=> @$options['button-text-color'],
	'text-hover-color'  => @$options['text-hover-color'],
	'icon'  	   		=> @$options['button-icon'],
	'icon-align'   		=> 'left-of-text',
	'url'		   		=> @$options['button-url'],
	'size'         		=> @$options['button-size'],
	'target'	   		=> @$options['target'],
	'text'		   		=> @$options['button-text'],
);

?>

<div class="col-md-12 col-lg-12">
	<div class="airkit_ribbon-banner">
		<div class="image-holder">
			<?php echo airkit_var_sanitize( $image, 'the_kses' ); ?>
		</div>
		<div style="<?php echo airkit_var_sanitize( $css, 'the_kses' ); ?>" class="airkit_ribbon <?php echo airkit_var_sanitize( $options['align'], 'the_kses' ); ?>">
			<div class="rb-content" style="<?php echo airkit_var_sanitize( $text_color, 'esc_attr' ); ?>">
				<div class="rb-separator">
					<span style="<?php echo airkit_var_sanitize( $text_color, 'esc_attr' ); ?>"><?php echo airkit_var_sanitize( $options['title'] , 'esc_attr' ); ?></span>
				</div>
				<div class="rb-description">
					<?php echo airkit_var_sanitize( $options['text'], 'the_kses' ); ?>
				</div>
				<?php echo airkit_Compilator::buttons_element( $button ); ?>
			</div>
		</div>
	</div>
</div>