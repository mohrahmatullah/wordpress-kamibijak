<?php

$options 			= airkit_Compilator::$options;
$article_classes 	= array('below-image');
$figure_attributes 	= array();

$posts_to_show 		= ( isset($options['posts-limit']) && !empty($options['posts-limit']) ? intval($options['posts-limit']) : 4 );
$count 				= airkit_Compilator::$options['count'];
$parent_class 		= airkit_Compilator::parent_effect( $options );

/*
 * Get categories ['list', 'slugs', 'ids' ]
 */
$categories = airkit_PostMeta::categories( $post->ID, array( 'get-array' => 'y' ) );

$article_atts['class'] = get_post_class( $article_classes );

?>
<?php  if( 0 === $count ):  ?>
	<div class="col-lg-8 col-md-8 col-sm-12 grid-view <?php echo airkit_var_sanitize( $parent_class, 'esc_attr' ); ?>">
		
		<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

			<?php
				$options['element-type'] = 'grid';
				$options['excerpt']      = 'y';

				airkit_featured_image( $options );
				airkit_entry_content( $options );
			?>

		</article>
	</div>
	<div class="thumbnail-view col-lg-4 col-md-4 col-sm-12 <?php echo airkit_var_sanitize( $parent_class, 'esc_attr' ); ?>">
<?php else: ?>
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ); ?>>

		<?php
			$options['element-type'] = 'thumbnail';

			airkit_featured_image( $options, array('hover_style') );
			airkit_entry_content( $options, array('excerpt') );
		?>

	</article>
<?php endif; ?>		

<?php if( $posts_to_show-1 === $count ): ?></div><!-- /.thumbnail-view --><?php endif; ?>