<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header();
	
	/**
	 * woocommerce_before_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action('woocommerce_before_main_content');

	$airkit_sidebar = airkit_Compilator::build_sidebar( 'product', $post->ID );

?>
	<?php do_action('woocommerce_main_breadcrumb'); ?>
	<div class="container">
		<div class="row">
			<?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' ); ?>
			<div id="primary" class="<?php echo esc_attr( $airkit_sidebar['content_class'] ); ?>">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>
			<?php

				echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' );

			?>
		</div>
	</div>
<?php
	
	do_action('woocommerce_after_main_content');

	get_footer();

?>