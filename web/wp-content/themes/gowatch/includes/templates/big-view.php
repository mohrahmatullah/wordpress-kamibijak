<?php
/**
 * Big posts view template
 */

// Declare variables
$options 			= airkit_Compilator::$options; // Get options
$options['size'] 	= 'bigpost';
$options['content-split'] = isset( $options['content-split'] ) ? $options['content-split'] : '1-2';
$article_classes 	= array();
$parent_class		= array();

$parent_class[]		= 'col-lg-12 col-md-12';
$parent_class[] 	= isset( $options['image-position']  ) ? 'image-' . $options['image-position'] : 'image-left';
$parent_class[] 	= isset( $options['content-split']  ) ? 'article-split-' . $options['content-split'] : 'no-split';
$parent_class[] 	= airkit_Compilator::parent_effect( $options );

$article_atts['class'] = get_post_class( $article_classes );


/*  
 * If small articles are disabled, display all posts as grid.
 * If small articles are enablerd, display first post as grid, all the following will be displayed as small posts. See 
 * @airkit_Compilator::get_small_posts() call below.
 */
if( 'n' === $options['small-posts']  || ( 'y' === $options['small-posts'] && $options['i'] == 1  ) ): ?>

<div class="big-posts-entry <?php echo trim(implode(' ', $parent_class)); ?>">

	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options );
			airkit_entry_content( $options );
		?>

	</article>
</div>

<?php endif; 
/* 
 * Display all posts after first as small articles 
 */
$options['custom-columns'] = 'col-lg-4 col-md-4 col-sm-12';

airkit_Compilator::get_small_posts( $options );
airkit_Compilator::$options['i']++;

if( isset( $options['enable-ads'] ) && 'y' == $options['enable-ads'] ) {
	// set advertising type for this element
	airkit_Compilator::$options['ad-type'] = 'list';
	// Show advertising
	airkit_advertising_loop( airkit_Compilator::$options );
}

