<?php
/**
 * Mosaic view template
 */

// Declare variables
$options 			= airkit_Compilator::$options; // Get options
$categories 		= airkit_PostMeta::categories( $post->ID, array( 'get-array' => 'y' ) ); // Get categories
$sizes              = airkit_PostMeta::mosaic_sizes( $options ); // Get sizes for mosaic
$article_classes 	= array();
$class_random		= array();

$layout_mosaic 		= (isset($options['layout'])) ? $options['layout'] : 'rectangles';
$img_rows 			= (isset($options['rows']) && $options['rows'] !== '' && (int)$options['rows'] !== 0) ? (int)$options['rows'] : '3';

$class_random[] 	= $sizes['class'];
$class_random[] 	= airkit_Compilator::parent_effect( $options );

$carousel 			= '';
$scroll 			= 'n';

$i = $options['i'];
$j = $options['j'];
$k = $options['k'];

if( 'scroll' === $options['behavior'] || 'carousel' === $options['behavior'] ) {
	$scroll = 'y';
}

// Carousel helper classes.
if( 'carousel' === $options['behavior'] ) {
	$carousel = ' col-lg-12 ';
}

if ( $layout_mosaic === 'rectangles' ) {	
	// This is how we open scroll container for rectangles.
	if( ( $scroll === 'y' && $k % 6 === 1 && $img_rows === 2 ) || ( $scroll === 'y' && $k % 9 === 1 && $img_rows === 3 ) ) {
		echo '<div class="scroll-container '. $carousel .' ">';
	}

} elseif ( $layout_mosaic === 'square' || $layout_mosaic === 'style-3' || $layout_mosaic === 'style-4' || $layout_mosaic === 'style-5' ) {
	//This is how we open scroll container for squares and for style 3.
	if( $k == 1  && $scroll == 'y' ) { 
		echo '<div class="scroll-container '. $carousel .'">';
	}
}

if ( $layout_mosaic === 'style-3' ) {
	$options['title-position'] = ' over-image ';
}

$article_atts['class'] = get_post_class( $article_classes );
?>

<div class="item <?php echo trim(implode(' ', $class_random)); ?>" data-filter-by="<?php echo esc_attr( $categories['ids'] ); ?>">
	
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>

		<?php
			airkit_featured_image( $options, array('post_is_featured', 'post_rating', 'post_sticky') );
			airkit_entry_content( $options );
		?>

	</article>
</div>

<?php 
if( $layout_mosaic === 'rectangles' ) {
	/*
     * If we have mosaic with rectangles.
     * > If we have 3 rows and we reach every 9 article.
     * > Else
     * > If we have 2 rows and we reach every 6 article.
     * Close the scroll-container div.
	 */
	if( ( $k % 9 === 0 && $img_rows === 3 && $scroll === 'y' ) || 
		( $k % 6 === 0 && $img_rows === 2 && $scroll === 'y' ) ) {
			echo '</div>'; //scroll-container end.			
		} 

} elseif ( $layout_mosaic == 'square' || $layout_mosaic == 'style-5' ) {
	//This is how we close scroll container for squares.
	if( ($k % 5 === 0 && $scroll === 'y') || ($k % 5 !== 0 && $scroll === 'y' && $i === $j) ){ 
		echo '</div>'; //scroll-container end.
	}

} elseif ( $layout_mosaic == 'style-3' || $layout_mosaic == 'style-4' ) {
	//This is how we close scroll container for style-3.
	if( ($k % 3 === 0 && $scroll === 'y') || ($k % 3 !== 0 && $scroll === 'y' && $i === $j) ){ 
		echo '</div>'; //scroll-container end.
	}

}

// Update loop variables.
airkit_Compilator::$options['k']++;

if( airkit_Compilator::$options['k'] === 7 && $layout_mosaic == 'rectangles' && $img_rows == 2  ){
	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;
}

if( airkit_Compilator::$options['k'] === 10 && $layout_mosaic == 'rectangles' && $img_rows == 3  ){
	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;
}

if( airkit_Compilator::$options['k'] === 6 && $layout_mosaic == 'square' || airkit_Compilator::$options['k'] === 6 && $layout_mosaic == 'style-5' ){
	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;
}

if( airkit_Compilator::$options['k'] === 4 && $layout_mosaic == 'style-3' ){
	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;
}

if( airkit_Compilator::$options['k'] === 4 && $layout_mosaic == 'style-4' ){
	airkit_Compilator::$options['k'] = 1;
	airkit_Compilator::$options['i']++;
}
