<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$options        = airkit_Compilator::$options;

$is_masonry     = false;
$article_classes = array('airkit_view-article');

if ( isset($options['element-type'], $options['per-row']) ) {
    $classes[] = airkit_Compilator::get_column_class( $options['per-row'] );
} else {
    $classes[] = airkit_Compilator::get_column_class( $woocommerce_loop['columns'] );
}

if ( isset( $options['behavior'] ) && $options['behavior'] == 'masonry' ) {
    $classes[] = 'masonry-element';
    $is_masonry = true;
}

// Get the effect classes
$classes[] = airkit_Compilator::parent_effect( $options );
$article_classes[] = airkit_Compilator::child_effect( $options );

$article_atts['class'] = get_post_class( $article_classes );
$container_atts['class'] = $classes;
$container_atts['data-post-id'] = esc_attr($post->ID);
?>

<div <?php airkit_element_attributes( $container_atts, $options, $post->ID ) ?>>
    <article <?php airkit_element_attributes( $article_atts, $options, $post->ID ) ?>>
        <figure class="image-holder">
            <?php
                if ( $product->is_on_sale() ) {
                    echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale', 'gowatch' ) . '</span><span class="onsale-after"></span>', $post, $product );
                }

                if ( has_post_thumbnail( $post->ID ) ) {

                    $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

                    if ( has_post_thumbnail() ) {

                        $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );

                        // Check if lazyloading is active
                        $airkit_lazyloading = airkit_option_value('general', 'enable_imagesloaded');
                        
                        $airkit_image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'shop_catalog');
                        $airkit_placeholder = wc_placeholder_img_src();
                        $alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                        $size = wc_get_image_size('shop_catalog');
                        $airkit_width = $size['width'];
                        $airkit_height = $size['height'];
                        
                        if ( $airkit_lazyloading == 'y' ) {
                            $featuredimage = '<img src="' . $airkit_placeholder . '" data-original="' . $airkit_image_src[0] . '" width="' . $airkit_width . '" height="' . $airkit_height . '" class="attachment-shop_catalog wp-post-image lazy" alt="' . $alt . '">';
                        } else{
                            $featuredimage = '<img src="' . $airkit_image_src[0] . '" width="' . $airkit_width . '" height="' . $airkit_height . '" class="attachment-shop_catalog wp-post-image" alt="' . $alt . '">';
                        }
                        
                    }

                    // Check if there are images in gallery and show second on hover
                    $attachment_ids = $product->get_gallery_image_ids();
                    if( isset($attachment_ids[1]) ) {
                        $right_image = wp_get_attachment_url( $attachment_ids[1], 'full' );

                        // New
                        $right_image_src = wp_get_attachment_image_src( $attachment_ids[1], 'shop_catalog');
                        $right_alt = get_post_meta($attachment_ids[1], '_wp_attachment_image_alt', true);
                        $right_size = wc_get_image_size('shop_catalog');
                        $right_width = $size['width'];
                        $right_height = $size['height'];
                        if ( $airkit_lazyloading == 'y' ) {
                            $second_image = '<img src="' . $airkit_placeholder . '" data-original="' . $right_image_src[0] . '" width="' . $right_width . '" height="' . $right_height . '" class="attachment-shop_catalog wp-post-image lazy product-hover-image" alt="' . $alt . '">';
                        } else{
                            $second_image = '<img src="' . $right_image_src[0] . '" width="' . $right_width . '" height="' . $right_height . '" class="attachment-shop_catalog wp-post-image product-hover-image" alt="' . $alt . '">';
                        }
                    }
                }

            ?>
            <a href="<?php echo get_permalink( $post->ID ); ?>">
                <?php
                    if ( isset($featuredimage) ) {
                        echo airkit_var_sanitize( $featuredimage, 'the_kses' );
                    }
                    // Show secondary (image from gallery) on hover
                    if ( isset($second_image) ) {
                        echo airkit_var_sanitize( $second_image, 'the_kses' );
                    }
                ?>
            </a>           
        </figure>
        <header>
            <div class="entry-content">
                <?php echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'entry-categories entry-categories-large' ) ); ?>
                <div class="ts-product-rating">
                    <?php do_action( 'woocommerce_after_shop_loop_item_rating' ); ?>
                </div>

                <?php echo airkit_PostMeta::title( $post->ID, array( 'url' => 'y' ) ); ?>

                <div class="grid-shop-options">
                    <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
                </div>
                <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
            </div>
        </header>
    </article>
</div>