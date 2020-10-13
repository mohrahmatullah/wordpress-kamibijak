<?php
/*
 * Small articles view template.
 */


$options 			= airkit_Compilator::$options;
$article_classes 	= array('item small-article');
$column_classes		= array();
$figure_attributes 	= array();

$column_classes[]	= airkit_Compilator::parent_effect( $options );

$options['per-row'] = isset($options['per-row']) ? $options['per-row'] : 1;
$options['meta'] 	= isset($options['meta']) ? $options['meta'] : 'y';

if ( isset( $options['custom-columns'] ) ) {
	$column_classes[] = $options['custom-columns'];
} else {
	$column_classes[] = airkit_Compilator::get_column_class( $options['per-row'] );
}

$article_atts['class'] = get_post_class( $article_classes );

?>
<div class="<?php echo implode(' ', $column_classes); ?>" <?php echo airkit_PostMeta::filter_attrs( $post->ID, $options ); ?> >
	
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options, array('post_format', 'post_is_featured', 'post_rating', 'hover_style', 'post_sticky') );
			airkit_entry_content( $options, array('excerpt') );
		?>

	</article>
</div>
