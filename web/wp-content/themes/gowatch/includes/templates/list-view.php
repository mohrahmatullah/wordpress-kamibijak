<?php
/**
 * List view template
 */

// Declare variables
$options 			= airkit_Compilator::$options; // Get options
$article_classes 	= array();

$article_atts['class'] = get_post_class( $article_classes );
?>

<div class="col-lg-12 <?php echo airkit_Compilator::parent_effect( $options ); ?>">
	
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options );
			airkit_entry_content( $options );
		?>

	</article>
</div>
<?php

airkit_Compilator::$options['i']++;

if( isset( $options['enable-ads'] ) && 'y' == $options['enable-ads'] ) {
	// set advertising type for this element
	airkit_Compilator::$options['ad-type'] = 'list';
	// Show advertising
	airkit_advertising_loop( airkit_Compilator::$options );
}
