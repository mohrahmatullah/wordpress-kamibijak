<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;
$single_sizes = get_option('shop_single_image_size');
$attachment_ids = method_exists( $product, 'get_gallery_attachment_ids' ) ? $product->get_gallery_attachment_ids() : $product->get_gallery_image_ids();
?>
<div class="product-images images">
	<?php
		if ( has_post_thumbnail() ) {

			if( $attachment_ids ) {

				$main_thumbnail = '<div class="product-slider slider-single">';

				foreach ( $attachment_ids as $attachment_id ) {

					$image_url = wp_get_attachment_url( $attachment_id );
					$image = '<img '. Airkit_Images::lazy_img( $image_url, array('resize' => 'y', 'w' => $single_sizes['width'], 'h' => $single_sizes['height'], 'c' => $single_sizes['crop']) ) .' alt="'. esc_html__('Product main image', 'gowatch') .'" />';

					$main_thumbnail .= '<figure>';
					$main_thumbnail .= sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" data-fancybox="group-%s">%s</a>', $image_url, $post->ID, $image );
					$main_thumbnail .= '</figure>';

				}

				$main_thumbnail .= '</div>';

			} else {

				$main_thumbnail = '<figure>';
				$main_thumbnail .= sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" data-fancybox>%s</a>', get_the_post_thumbnail_url( $post->ID, 'full' ), get_the_post_thumbnail( $post->ID, 'shop_single' ) );
				$main_thumbnail .= '</figure>';
			}

		} else {
			$main_thumbnail  = '<figure class="woocommerce-product-gallery__image--placeholder">';
			$main_thumbnail .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'gowatch' ) );
			$main_thumbnail .= '</figure>';
		}

		echo apply_filters( 'woocommerce_single_product_image_html', $main_thumbnail, $post->ID );

		do_action( 'woocommerce_product_thumbnails' );
	?>
</div>