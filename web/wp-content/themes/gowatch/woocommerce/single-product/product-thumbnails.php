<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;
$thumb_sizes = get_option('shop_thumbnail_image_size');
$attachment_ids = method_exists( $product, 'get_gallery_attachment_ids' ) ? $product->get_gallery_attachment_ids() : $product->get_gallery_image_ids();

if ( $attachment_ids ) {

	echo '<div class="product-slider slider-thumbs">';

	foreach ( $attachment_ids as $attachment_id ) {

		$image_url 		  = wp_get_attachment_url( $attachment_id );
		$thumbnail        = '<img '. Airkit_Images::lazy_img( $image_url, array('resize' => 'y', 'w' => $thumb_sizes['width'], 'h' => $thumb_sizes['height'], 'c' => $thumb_sizes['crop']) ) .' alt="'. esc_html__('Product thumbnail', 'gowatch') .'" />';

		$html  = '<figure class="woocommerce-thumb-image">';
		$html .= $thumbnail;
 		$html .= '</figure>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo '</div>';

	echo '<div class="slider-nav">
			<span class="slider-nav-left"><i class="icon-left"></i></span>
			<span class="slider-nav-right"><i class="icon-right"></i></span>
		</div>';

}