<?php
/**
 * The template for displaying post Single Style 1
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */

global $airkit_is_ajax_loading;

$article_classes 		= array();
$section_classes 		= array();
$airkit_sidebar 		= airkit_Compilator::build_sidebar( 'single', $post->ID );
$airkit_content_width 	= airkit_Compilator::get_content_width( $airkit_sidebar['content_class'] );
$airkit_sidebar_position = airkit_has_sidebar( $post->ID );

$article_classes[] 		= $airkit_content_width;
$article_classes[]		= 'post-layout-single1';
$section_classes[] 		= 'sidebar-'.$airkit_sidebar_position;
$section_classes[] 		= $airkit_sidebar['content_class'];

if ( 'y' == airkit_option_value( 'single', 'article_progress' ) ) {
	$article_classes[] = 'article-progress-enabled';
}

$article_atts['class'] = get_post_class( $article_classes );
?>

<div <?php airkit_element_attributes( array(), array('element' => 'post-row'), $post->ID ); ?>>

	<div class="container">
	<?php
		if ( 'y' == airkit_single_option( 'breadcrumbs' ) ) {

			echo '<div class="airkit_breadcrumbs breadcrumbs-single-post">' . airkit_breadcrumbs() . '</div>';

		}
	?>

	<?php
		if ( isset($airkit_is_ajax_loading) && true === $airkit_is_ajax_loading ) {
			if( airkit_option_value('advertising', 'ad_area_next_loaded') != '' ) {
				echo '<div class="airkit_advertising-container">' . airkit_option_value('advertising', 'ad_area_next_loaded') . '</div>';
			}
		}
	?>

	<?php
		if ( $airkit_sidebar_position !== 'none' ) {
			echo '<div class="row">'. airkit_var_sanitize( $airkit_sidebar['left'], 'true' ) .'<div class="'. implode(' ', $section_classes) .'">';
		}
	?>

	<article <?php airkit_element_attributes( $article_atts, array('element' => 'article', 'text-align' => '', 'is-single' => true), $post->ID ) ?>>

		<?php airkit_progress_scroll(); ?>

		<?php airkit_featured_image( array('is-single' => true) ); ?>

		<header class="post-header">
			<?php
				echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'post-categories entry-categories' ) );
				echo airkit_PostMeta::title( $post->ID, array( 'wrap' => 'h2', 'class' => 'post-title', 'url' => 'n', 'single' => 'y' ) );
			?>
			<div class="entry-meta entry-meta-views">
				<span><?php esc_html_e('Views', 'gowatch') ?></span>
				<strong><?php airkit_get_views($post->ID) ?></strong>
			</div>
		</header>

		<aside class="post-meta">
			<div class="post-meta-author">
				<?php
					$date_published = airkit_PostMeta::date( $post->ID, array('wrap' => 'span', 'prefix' => esc_html__('Published', 'gowatch') ) );
					echo airkit_PostMeta::author( $post->ID, array('wrap' => 'div', 'prefix' => '<span class="post-author-avatar">' . airkit_get_avatar( get_the_author_meta('ID'), 50 ) . '</span>', 'postfix' => $date_published ) );
				?>
			</div>
			<div class="post-meta-actions">
				<?php
					echo airkit_PostMeta::add_to_favorite( $post->ID, array( 'label' => true, 'single' => 'y' ) );
					airkit_single_sharing( array('label' => 'y', 'tooltip-popover' => 'y') );
					echo airkit_PostMeta::rating( $post->ID, array( 'type' => 'form', 'wrap' => 'div' ) );
				?>
			</div>
		</aside>

		<aside class="post-container">
			
			<div class="post-content">
				<?php

					echo airkit_PostMeta::subtitle( $post->ID, array( 'single' => 'y' ) );

					do_action( 'airkit_above_single_content' );

					$content = apply_filters( 'the_content', get_the_content() );
					airkit_check_subscribers_only($content);

					do_action( 'airkit_below_single_content' );
				?>
			</div>

			<div class="post-footer">
			<?php 
				echo airkit_PostMeta::rating_single( $post->ID );

				if( !isset( $airkit_is_ajax_loading ) || false == $airkit_is_ajax_loading ) {
					airkit_PostMeta::single_pagination( $post->ID );
				}

				//  SOF Ad area 2 -->
				if( airkit_option_value('advertising','ad_area_2') != '' ) {
					echo '<div class="container airkit_advertising-container">' . airkit_option_value('advertising','ad_area_2') . '</div>';
				}
				// EOF Ad area 2 -->

				airkit_PostMeta::author_box( $post );

				// Add the comments on the page
				comments_template( '', true );

				// relates posts should not be displayed when ajax loading
				if( !isset( $airkit_is_ajax_loading ) || false == $airkit_is_ajax_loading ) {

					do_action( 'airkit_related_posts' );
					
				}
			?>
			</div>
			
		</aside>

	</article>

	<?php
		if ( $airkit_sidebar_position !== 'none' ) {
			echo '</div>'. airkit_var_sanitize( $airkit_sidebar['right'], 'true' ) .'</div><!-- end .row -->';
		}
	?>

	</div>
</div>
