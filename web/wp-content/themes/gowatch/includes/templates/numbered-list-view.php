<?php
/**
 * Numbered list view template
 */

// Declare variables
$options 			= airkit_Compilator::$options; // Get options
$article_classes 	= array();
$article_classes[] 	= 'numbered-list-article';
$article_classes[] 	= airkit_Compilator::child_effect( $options );

$columns_class[] = airkit_Compilator::get_column_class( $options['per-row'] );
$columns_class[] = airkit_Compilator::parent_effect( $options );

$article_atts['class'] = get_post_class( $article_classes );


$devide = round($options['j'] / $options['per-row']);

if ( $options['i'] % $devide == 1 ) {
	echo '<div class="item '. trim(implode(' ', $columns_class)) .'">';
}
?>
	<article <?php airkit_element_attributes( $article_atts, array_merge( $options, array('element' => 'article') ), $post->ID ); ?>>
		<header>
			<?php
				echo '<span class="count-item">'. $options['i'] .'</span>';
				echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h2') );
			?>
		</header>
		<aside>
			<?php
				airkit_PostMeta::microdata( $options, true );
			?>
		</aside>
	</article>
<?php

if ( $options['i'] % $devide == 0 ) {
	echo '</div>';
}

airkit_Compilator::$options['i']++;

?>