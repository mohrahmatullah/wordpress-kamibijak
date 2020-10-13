<?php
/**
 * Playlist template
 */

// Declare variables
$options 			= airkit_Compilator::$options; // Get options
$categories 		= airkit_PostMeta::categories( $post->ID, array( 'get-array' => 'y' ) ); //Get categories
$article_classes 	= array();
$columns_class		= array();
$i 					= isset( $options['i'] ) ? $options['i'] : '';
$scroll 			= isset($options['behavior']) && $options['behavior'] == 'scroll' ? 'scroll' : '';

// Get article columns by elements per row
$columns_class[] = airkit_Compilator::get_column_class( $options['per-row'], $scroll );
$columns_class[] = airkit_Compilator::parent_effect( $options );

$article_atts['class'] = get_post_class( $article_classes );

?>

<div class="item <?php echo trim(implode( ' ', $columns_class )); ?>" data-filter-by="<?php echo esc_attr( $categories['ids'] ); ?>">

	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article', 'text-align' => 'center') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options );
			airkit_entry_content( $options );
		?>

	</article>	
</div>