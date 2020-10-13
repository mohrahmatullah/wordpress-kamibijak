<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$post_id = get_the_ID();

get_header();
?>

	<?php
		do_action('woocommerce_before_main_content');

		$airkit_sidebar = airkit_Compilator::build_sidebar( 'shop', $post_id );
	?>
	<?php do_action('woocommerce_main_breadcrumb'); ?>
	<div class="container">
		<div class="row">
			<?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' ); ?>
			<div id="primary" class="<?php echo airkit_var_sanitize( $airkit_sidebar['content_class'], 'esc_attr' ); ?>">
		        <div id="content" role="main">
		        	<div class="row">
		        		<div class="col-md-12 col-lg-12 product-view">
							<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

								<h1 class="post-title shop-archive-title"><?php woocommerce_page_title(); ?></h1>

							<?php endif; ?>

							<?php do_action( 'woocommerce_archive_description' ); ?>

							<?php if ( have_posts() ) : ?>

								<?php
									/**
									 * woocommerce_before_shop_loop hook
									 *
									 * @hooked woocommerce_result_count - 20
									 * @hooked woocommerce_catalog_ordering - 30
									 */
									do_action( 'woocommerce_before_shop_loop' );
								?>

								<?php woocommerce_product_loop_start(); ?>

									<?php woocommerce_product_subcategories(); ?>

									<?php while ( have_posts() ) : the_post(); ?>

										<?php wc_get_template_part( 'content', 'product' ); ?>

									<?php endwhile; // end of the loop. ?>

								<?php woocommerce_product_loop_end(); ?>

								<?php

									do_action( 'woocommerce_after_shop_loop' );
								?>

							<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

								<?php wc_get_template( 'loop/no-products-found.php' ); ?>

							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' ); ?>
		</div>
	</div>
	<?php

		do_action('woocommerce_after_main_content');
	?>

<?php get_footer(); ?>