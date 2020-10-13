<?php
$options 			= airkit_Compilator::$options;
$article_classes 	= array();

$article_classes[] 	= airkit_Compilator::child_effect( $options );
$parent_classes 	= airkit_Compilator::parent_effect( $options );

/*
 * Get categories ['list', 'slugs', 'ids' ]
 */
$categories = airkit_PostMeta::categories( $post->ID, array( 'get-array' => 'y' ) );

// If Post meta is set to No then add article class with name hide-post-meta
if ( $options['meta'] == 'n' ) {
	$article_classes[] = 'hide-post-meta';
}

$article_atts['class'] = get_post_class( $article_classes );

?>

<?php if ( '' !== $parent_classes ): ?>
	<div class="<?php echo airkit_var_sanitize( $parent_classes, 'esc_attr' ); ?>">
<?php endif ?>

	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options );
			airkit_entry_content( $options );
		?>

	</article>

<?php if ( '' !== $parent_classes ): ?>
	</div>
<?php endif; ?>
