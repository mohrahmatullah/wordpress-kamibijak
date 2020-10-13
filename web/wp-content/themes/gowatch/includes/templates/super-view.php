<?php

/* Super posts view template below */
###########

// Get the options
$options 			= airkit_Compilator::$options;
$article_classes 	= array('super-article');

$options['small-posts'] = isset( $options['small-posts'] ) ? $options['small-posts'] : 'n';

// Get article columns by elements per row
$parent_class = airkit_Compilator::get_column_class( $options['per-row'] );
$parent_class .= airkit_Compilator::parent_effect( $options );

$article_atts['class'] = get_post_class( $article_classes );


/*  
 * If small articles are disabled, display all posts as grid.
 * If small articles are enablerd, display first post as grid, all the following will be displayed as small posts. See 
 * @airkit_Compilator::get_small_posts() call below.
 */

if( 'n' === $options['small-posts'] || ( 'y' === $options['small-posts'] && $options['i'] == 1  ) ): 

?>
<div class="item <?php echo airkit_var_sanitize( $parent_class, 'esc_attr' ); ?>" <?php echo airkit_PostMeta::filter_attrs( $post->ID, $options ); ?>>
	
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options, array('post_format', 'post_is_featured', 'post_rating', 'post_sticky', 'hover_style') );
			airkit_entry_content( $options, array('excerpt') );

			echo airkit_PostMeta::post_is_sticky( $post->ID );
		?>

	</article>
</div>

<?php endif;

/* 
 * Display all posts after first as small articles 
 */
	airkit_Compilator::get_small_posts( $options );
	airkit_Compilator::$options['i']++;
?>

