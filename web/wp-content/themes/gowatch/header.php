<!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!-- Viewports for mobile -->
	<meta name="viewport" content="width=device-width,minimum-scale=1">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php
	if ( ! is_singular() || is_front_page() || is_home() ) {

		if ( airkit_option_value( 'styles', 'facebook_image' ) !== '' ) {

			$airkit_fb_img_url = airkit_option_value('styles', 'facebook_image');
			echo '<meta property="og:image" content="'. airkit_var_sanitize( $airkit_fb_img_url, 'esc_url' ) .'"/>';
		}

	} else {

		airkit_single_opengraph( get_the_ID() );
		
	}
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	wp_head();

	?>
</head>
<body <?php body_class(); ?>>

	<?php if ( airkit_option_value( 'general', 'comment_system' ) == 'facebook' ) : ?>

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=181724551944218';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

	<?php endif; ?>

	<?php if ( airkit_option_value( 'general', 'enable_preloader' ) == 'y' || airkit_option_value( 'general', 'enable_preloader' ) == 'fp' && is_front_page() ) : ?>
		<div class="airkit_page-loading">
			<div class="airkit_ball" id="a">
				<div class="airkit_inner-ball"></div>
			</div>
			<div class="airkit_ball" id="b">
				<div class="airkit_inner-ball"></div>
			</div>
			<div class="airkit_ball" id="c">
				<div class="airkit_inner-ball"></div>
			</div>
		</div>
	<?php endif; ?>
	<div id="airkit_loading-preload">
		<div class="preloader-center"></div>
		<span><?php esc_html_e('Loading...','gowatch'); ?></span>
	</div>
	<?php

		// Set the header to show elements for all pages
		$airkit_header_display = true;

		$airkit_shown = get_post_meta( get_the_ID(), 'airkit_header_and_footer', true);

		// Checks for the shop page
		if ( class_exists( 'WooCommerce' ) && function_exists('is_shop') && is_shop() ) {
			$woo_shop_page_id = get_option( 'woocommerce_shop_page_id' );
			$airkit_shown = get_post_meta( $woo_shop_page_id, 'airkit_header_and_footer', true);
		}
		// Check if we disable the header of not
		$airkit_disable_header = (isset($airkit_shown['disable_header'])) ? $airkit_shown['disable_header'] : 0;

		if (is_singular() && is_page() && $airkit_disable_header === 1 || ( class_exists( 'WooCommerce' ) && function_exists('is_shop') && is_shop() ) && $airkit_disable_header === 1 ) {
			
			$airkit_header_display = false;
		}

		$airkit_header_position = airkit_option_value('styles', 'header_position');
		$airkit_header_position = isset($airkit_header_position) ? $airkit_header_position : 'top';
	?>
	<div id="wrapper"<?php echo ( airkit_option_value('styles', 'boxed_layout') == 'y' ? ' class="container"' : '' ) ?> data-header-align="<?php echo esc_attr( $airkit_header_position ); ?>">
		<?php if ( $airkit_header_display === true ) : ?>
			<header id="header">
				<?php do_action('airkit_before_header'); ?>
				<?php echo airkit_Compilator::build_content( airkit_Compilator::get_head( 'header' ) ); ?>
				<?php do_action('airkit_after_header'); ?>
			</header>
		<?php endif; ?>