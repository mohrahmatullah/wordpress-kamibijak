<?php
/*
 * Grease articles template.
 */

// Get the options
$options = airkit_Compilator::$options;
?>

<article <?php post_class(); ?>>

	<?php
		airkit_featured_image( $options, array('post_format', 'post_is_featured', 'post_rating', 'overlay_effect', 'post_link', 'hover_style', 'post_sticky') );
		airkit_entry_content( $options, array('excerpt') );
	?>
	
</article>