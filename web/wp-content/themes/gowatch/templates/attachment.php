<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */

$article_classes 		= array();
$section_classes 		= array();
$airkit_sidebar 		= airkit_Compilator::build_sidebar( 'single', $post->ID );
$airkit_content_width 	= airkit_Compilator::get_content_width( $airkit_sidebar['content_class'] );
$airkit_sidebar_position = airkit_has_sidebar( $post->ID );

$article_classes[] 		= $airkit_content_width;
$article_classes[]		= 'post-layout-single1';
$section_classes[] 		= 'sidebar-'.$airkit_sidebar_position;
$section_classes[] 		= $airkit_sidebar['content_class'];

$article_atts['class'] = get_post_class( $article_classes );

?>

<div <?php airkit_element_attributes( array(), array('element' => 'post-row'), $post->ID ); ?>>

	<div class="container">
	<?php
		if ( 'y' == airkit_single_option( 'breadcrumbs' ) ) {

			echo '<div class="airkit_breadcrumbs breadcrumbs-single-post">' . airkit_breadcrumbs() . '</div>';

		}
	
		if ( $airkit_sidebar_position !== 'none' ) {
			echo '<div class="row">'. airkit_var_sanitize( $airkit_sidebar['left'], 'true' ) .'<div class="'. implode(' ', $section_classes) .'">';
		}
	?>

	<article <?php airkit_element_attributes( $article_atts, array('element' => 'article', 'text-align' => ''), $post->ID ) ?>>

		<header class="text-center post-header">
			<?php
				echo airkit_PostMeta::title( $post->ID, array( 'wrap' => 'h1', 'class' => 'post-title', 'url' => 'n', 'single' => 'y' ) );
			?>
		</header>

		<aside class="text-center post-meta">
			<?php
				echo airkit_PostMeta::author( $post->ID, array('wrap' => 'div', 'prefix' => '<em>' . esc_html__('by', 'gowatch') . '</em>' ) );
				echo airkit_PostMeta::single_meta( $post->ID, array(), array('author', 'comments') );
				echo airkit_PostMeta::microdata();
				airkit_single_sharing( array('label' => 'y', 'tooltip-popover' => 'n', 'style' => 'button-sharing') );
			?>
		</aside>

		<div class="post-content text-center">
			<?php
				do_action( 'airkit_above_single_content' );

				echo wp_get_attachment_image( get_the_ID(), 'large' );

				do_action( 'airkit_below_single_content' );
			?>
		</div>

		<nav id="image-navigation" class="single-post-navigation">
			<ul class="navigation image-navigation nav-links">
				<li class="airkit_post-nav">
					<?php previous_image_link( false, sprintf( '<div class="page-prev"><i class="icon-left"></i><span>%s</span></div>', esc_html__( 'Previous Image', 'gowatch' ) ) ); ?>
				</li>
				<li class="airkit_post-nav">
					<?php next_image_link( false, sprintf( '<div class="page-next"><i class="icon-right"></i><span>%s</span></div>', esc_html__( 'Next Image', 'gowatch' ) ) ); ?>
				</li>
			</ul><!-- .nav-links -->
		</nav><!-- .image-navigation -->

		<div class="text-center post-footer">
		<?php
			//  SOF Ad area 2 -->
			if( airkit_option_value('advertising','ad_area_2') != '' ) {
				echo '<div class="container text-center airkit_advertising-container">' . airkit_option_value('advertising','ad_area_2') . '</div>';
			}
			// EOF Ad area 2 -->

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template( '', true );
			}
		?>
		</div>

	</article>

	<?php
		if ( $airkit_sidebar_position !== 'none' ) {
			echo '</div>'. airkit_var_sanitize( $airkit_sidebar['right'], 'true' ) .'</div><!-- end .row -->';
		}
	?>

	</div>
</div>
