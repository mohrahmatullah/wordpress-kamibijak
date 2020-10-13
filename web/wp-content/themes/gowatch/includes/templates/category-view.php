<?php

$options 			= airkit_Compilator::$options;
$count 				= airkit_Compilator::$options['count'];
$posts_to_show 		= ( isset($options['posts-limit']) && !empty($options['posts-limit']) ? intval($options['posts-limit']) : 4 );
$article_classes 	= array();

$parent_class 		= airkit_Compilator::parent_effect( $options );

if( isset( $options['style'] ) && 'style-2' == $options['style'] ) {
	get_template_part( 'includes/templates/category-view-2' );
	return;
} elseif ( isset($options['style']) && 'style-3' == $options['style'] ) {
	get_template_part( 'includes/templates/category-view-3' );
	return;
}

?>
<?php  if( 0 === $count ):  ?>
	<div class="col-lg-6 col-md-6 col-sm-12 grid-view <?php echo airkit_var_sanitize( $parent_class, 'true' ); ?>">
		<?php
			$article_classes[] = 'below-image';
			$article_atts['class'] = get_post_class( $article_classes );
		?>
		<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article')), $post->ID ) ?>>

			<?php
				$options['element-type'] = 'grid';

				airkit_featured_image( $options );
				airkit_entry_content( $options );
			?>

		</article>
	</div>
	<div class="small-articles-container col-lg-6 col-md-6 col-sm-12 <?php echo airkit_var_sanitize( $parent_class, 'true' ); ?>">
<?php else: ?>
		<?php
			$article_classes[] = 'small-article';
			$article_atts['class'] = get_post_class( $article_classes );
		?>

		<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article')), $post->ID ) ?>>

			<?php
				$options['element-type'] = 'small-articles';

				airkit_featured_image( $options, array('post_format', 'post_is_featured', 'post_rating', 'hover_style', 'post_sticky') );
				airkit_entry_content( $options, array('categories', 'excerpt') );
			?>

		</article>

<?php endif; ?>		

<?php if( $posts_to_show-1 === $count ): ?></div><!-- /.small-articles-container --><?php endif; ?>