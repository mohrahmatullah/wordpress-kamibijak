<?php

$options 			= airkit_Compilator::$options;
$article_classes	= array();
$figure_attributes	= array();

$posts_to_show 		=  ( isset($options['posts-limit']) && !empty($options['posts-limit']) ? intval($options['posts-limit']) : 4 );
$count 				= airkit_Compilator::$options['count'];
$total_posts 		= airkit_Compilator::$options['total_posts'];
$parent_class 		= airkit_Compilator::parent_effect( $options );

?>
<?php if( 0 === $count ):  ?>
	<div class="grid-view <?php echo airkit_var_sanitize( $parent_class, 'esc_attr' ); ?>">
		<?php
			$article_classes[] = 'below-image';
			$article_atts['class'] = get_post_class( $article_classes );
		?>
		
		<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

			<?php
				airkit_featured_image( $options );
				airkit_entry_content( $options, array('categories') );
			?>

		</article>
	</div>
	<div class="small-articles-container <?php echo airkit_var_sanitize( $parent_class, 'esc_attr' ); ?>">
<?php else: ?>
	<?php
		$article_classes[] = 'small-article';
		$article_atts['class'] = get_post_class( $article_classes );
		$options['element-type'] = 'small-articles';
	?>
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options, array('post_format', 'post_is_featured', 'post_rating', 'hover_style', 'post_sticky') );
			airkit_entry_content( $options, array('categories', 'excerpt') );
		?>

	</article>
<?php endif; ?>		

<?php 
	// Close small articles container if count gets to posts_to show
	// Or if there aren't enough posts to display.
	if( $posts_to_show - 1 === $count || ( ( $posts_to_show > $total_posts ) && $total_posts == $count + 1 ) ) {
	echo "</div>"; //small-articles-container
	} ?>
