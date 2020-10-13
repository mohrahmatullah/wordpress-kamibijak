<?php

$options 			= airkit_Compilator::$options;
$article_classes 	= array('over-image');

$posts_to_show 		= ( isset($options['posts-limit']) && !empty($options['posts-limit']) ? intval($options['posts-limit']) : 4 );
$count 				= airkit_Compilator::$options['count'];
$parent_class 		= airkit_Compilator::parent_effect( $options );

$article_atts['class'] = get_post_class( $article_classes );

?>
<?php  if( 0 === $count ):  ?>
	<div class="col-lg-8 col-md-8 col-sm-12 thumbnail-view <?php echo airkit_var_sanitize( $parent_class, 'esc_attr' ); ?>">
		
		<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article')), $post->ID ) ?>>

			<?php
				$options['element-type'] = 'thumbnail';

				airkit_featured_image( $options );
				airkit_entry_content( $options, array('excerpt') );
			?>

		</article>
	</div>
	<div class="small-articles-container col-lg-4 col-md-4 col-sm-12 <?php echo airkit_var_sanitize( $parent_class, 'true' ); ?>">
<?php else: ?>
	<?php $article_classes[] = 'small-article'; ?>
	<article <?php echo post_class( $article_classes ); ?> >

		<?php

			$options['element-type'] = 'small-articles';

			airkit_entry_content( $options, array('categories', 'excerpt') );

		?>

	</article>
<?php endif; ?>		

<?php if( $posts_to_show-1 === $count ): ?></div><!-- /.small-articles-container --><?php endif; ?>