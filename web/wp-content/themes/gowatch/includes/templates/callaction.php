<?php

/* Call to action template below */
###########

// Get the options

$options = airkit_Compilator::$options;

$text = ( trim($options['text'] ) !== '') ? $options['text'] : false;
$button_text = ( trim($options['button-text'] ) !== '') ? $options['button-text'] : esc_html__( 'Read more', 'gowatch' );
$link = ( trim($options['link']) !== '' ) ? $options['link'] : false;

if ( ! $text ) {

	return '';

} else {

	$button = '';

	if ( $link ) {
		$button = '<div class="the-button">
						<a href="' . esc_url( $link ) . '" class="continue">'.stripslashes( $button_text ).'</a>
					</div>';
	}

}

?>
<div class="col-lg-12 col-md-12 col-sm-12">
	<div class="ts-callaction clearfix">
		<div class="the-quote">
			<?php echo stripslashes( $text ); ?>					
		</div>
		<?php echo stripslashes( $button ); ?>
	</div>
</div>