<?php
add_action( 'admin_enqueue_scripts', 'airkit_admin_enqueue_scripts' );

function airkit_admin_enqueue_scripts( $hook ) {

	if ( 'upload.php' === $hook ) {
	    return;
	}

	global $wp_scripts, $pagenow;

	$page_get = '';

	if ( function_exists('get_current_screen') ) {
		$screen = get_current_screen();
	}

	if ( isset($_GET['page']) ) {
		$page_get = $_GET['page'];
	}

	$page_post = '';

	if ( isset($_POST['page']) ) {
		$page_post = $_POST['page'];
	}
	$page_tab = '';

	if ( isset($_GET['tab']) ) {
		$page_tab = $_GET['tab'];
	}

	// News from TouchSize
	if ( function_exists('airkit_update_redarea') && airkit_update_redarea() === true ) {
		wp_enqueue_script(
			'red-area',
			get_template_directory_uri() . '/admin/js/red.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			true
		);

		$data = array('token' => wp_create_nonce("airkit_save_touchsize_news"));
		wp_localize_script( 'red-area', 'RedArea', $data );
	}

	if ( isset($screen) && $screen->id == 'page' || $page_get == 'gowatch_header' || $page_get == 'gowatch_footer' ) {

		$api_data = airkit_option_value('typography', 'extra');
		// Load maps API only if on page or header & footer
		wp_enqueue_script(
			'googlemap_api-js',
			'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($api_data['google_fonts_key']),
			array('jquery'),
			AIRKIT_THEME_VERSION,
			false
		);
	}

	// JS for theme settings
	$data = array(
		'LikeGenerate'     => wp_create_nonce('like-generate'),
		'Nonce'            => wp_create_nonce('extern_request_die')
	);

	wp_enqueue_script(
		'gowatch-custom',
		get_template_directory_uri() . '/admin/js/touchsize.js',
		array('jquery', 'farbtastic'),
		AIRKIT_THEME_VERSION,
		true
	);

	wp_localize_script( 'gowatch-custom', 'gowatchAdmin', $data );

	wp_enqueue_media();

	if ( @$page_get == 'gowatch' || @$page_get == 'templates' ) {

		// color picker
		wp_enqueue_style( 'farbtastic' );
	}

	if ( (@$page_get === 'gowatch' && ( @$page_tab === 'typography' || @$page_tab === 'styles' )) || get_post_type() == 'page' || $page_get == 'gowatch_header' || $page_get == 'gowatch_footer' ) {

		wp_enqueue_script(
			'gowatch-google-fonts',
			get_template_directory_uri() . '/admin/js/google-fonts.js',
			array(),
			AIRKIT_THEME_VERSION,
			false
		);

		$google_fonts_key = ( $typography = get_option( 'gowatch_options' ) ) && !empty( $typography['typography']['extra']['google_fonts_key'] ) ? $typography['typography']['extra']['google_fonts_key'] : 'AIzaSyBHh7VPOKMPw1oy6wsEs8FNtR5E8zjb-7A';

		$data = array(
			'google_fonts_key' => $google_fonts_key
		);

		wp_localize_script( 'gowatch-google-fonts', 'gowatch', $data );
	}

	if( @$page_tab == 'css' ) {
		wp_enqueue_script(
			'codemirror-js',
			get_template_directory_uri() . '/admin/js/codemirror.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			false
		);
	}
	
	// Check WooCommerce version is older than 3.0.0
	// Check current screen to include select2 for Category selector from Builder elements
	if ( airkit_woocommerce_version_check( '2.6', '<=' ) || ( isset($screen) && 'product' != $screen->post_type ) ) {
		$enqueue_select2 = true;
	}

	if ( isset($enqueue_select2) && $enqueue_select2 === true ) {

		wp_enqueue_script(
			'select2-js',
			get_template_directory_uri() . '/admin/js/select2.min.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			false
		);

		wp_enqueue_style(
			'select2-css',
			get_template_directory_uri() . '/admin/css/select2.css',
			array(),
			AIRKIT_THEME_VERSION
		);

	}

	// Theme settings
	wp_enqueue_style(
		'gowatch-admin-css',
		get_template_directory_uri().  '/admin/css/touchsize-admin.css'
	);

	// Tickbox
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_style( 'thickbox' );

	//Edit taxonomy

	if( isset( $_GET['taxonomy'] ) ) {

		wp_enqueue_style(
			'gowatch-colorpicker',
			get_template_directory_uri() . '/admin/css/bootstrap-colorpicker.min.css',
			array(),
			AIRKIT_THEME_VERSION
		);

		wp_enqueue_script(
			'gowatch-colorpicker',
			get_template_directory_uri() . '/admin/js/bootstrap-colorpicker.min.js',
			array( 'jquery' ),
			AIRKIT_THEME_VERSION,
			true
		);

	}

	// Layout builder
	$builder_pages =@$page_get === 'gowatch_header' ||
					@$page_post === 'gowatch_header' ||
					@$page_post === 'gowatch' ||
					@$page_get === 'gowatch' ||
					@$page_get === 'gowatch_footer' ||
					@$page_post === 'gowatch_footer' ||
					get_post_type() == 'page' ||
					airkit_is_edit_page();


	if ( $pagenow == 'post.php' || $builder_pages ) {
		
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		
		// Layout builder styles
		wp_enqueue_style(
			'jquery-ui-custom',
			get_template_directory_uri() . '/admin/css/layout-builder.css',
			array(),
			AIRKIT_THEME_VERSION
		);

		wp_enqueue_style(
			'gowatch-colorpicker',
			get_template_directory_uri() . '/admin/css/bootstrap-colorpicker.min.css',
			array(),
			AIRKIT_THEME_VERSION
		);

		wp_enqueue_script(
			'gowatch-colorpicker',
			get_template_directory_uri() . '/admin/js/bootstrap-colorpicker.min.js',
			array( 'jquery' ),
			AIRKIT_THEME_VERSION,
			true
		);

		// Layout builder
		wp_enqueue_script(
			'handlebars',
			get_template_directory_uri() . '/admin/js/handlebars.js',
			array('jquery','jquery-ui-core', 'jquery-ui-sortable'),
			AIRKIT_THEME_VERSION,
			true
		);

		wp_enqueue_script(
			'gowatch-cookie',
			get_template_directory_uri() . '/js/jquery.cookie.js',
			false,
			AIRKIT_THEME_VERSION,
			true
		);

		wp_enqueue_script(
			'builder',
			get_template_directory_uri() . '/admin/js/builder.js',
			array( 'handlebars' ),
			AIRKIT_THEME_VERSION,
			true
		);

		$data = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'builder-nonce' ),
		);

		wp_localize_script( 'builder', 'gowatch', $data );

		wp_enqueue_script( 'jquery-ui-slider' );

		// Noty
		wp_enqueue_script(
			'noty',
			get_template_directory_uri() . '/admin/js/noty/jquery.noty.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			true
		);

		wp_enqueue_script('farbtastic');
		// color picker
		wp_enqueue_style( 'farbtastic' );

		// Noty layouts
		wp_enqueue_script(
			'noty-top',
			get_template_directory_uri() . '/admin/js/noty/layouts/bottomCenter.js',
			array('jquery', 'noty'),
			AIRKIT_THEME_VERSION,
			true
		);

		// Noty theme
		wp_enqueue_script(
			'noty-theme',
			get_template_directory_uri() . '/admin/js/noty/themes/default.js',
			array('jquery', 'noty', 'noty-top'),
			AIRKIT_THEME_VERSION,
			true
		);

	}
}

add_action( 'wp_enqueue_scripts', 'airkit_enqueue_scripts' );

// Add the custom generated styles to the theme
add_action( 'wp_enqueue_scripts', 'airkit_theme_styles_rewrite' );

function airkit_enqueue_scripts() {
	global $post;

	wp_enqueue_script(
		'gowatch-bootstrap',
		get_template_directory_uri() . '/js/bootstrap.js',
		array( 'jquery' ),
		AIRKIT_THEME_VERSION,
		true
	);

	$lazyload = airkit_option_value( 'general', 'enable_imagesloaded' );
	$onePageWebsite = airkit_option_value( 'general', 'onepage_website' );
	$enablePreloader = airkit_option_value( 'general', 'enable_preloader' );
	$prevent_adblock = airkit_option_value( 'general', 'prevent_adblock' );
	$prevent_adblock = !empty( $prevent_adblock ) ? $prevent_adblock : 'n';

	$adblock_html = '';

	if( $prevent_adblock == 'y' ) {
		$adblock_html = '<i class="icon-attention"></i>';
		$adblock_html .= esc_html__( 'You are using Ad blocking software, please disable it, or add this site as an exception in order to view the content.', 'gowatch' );
	}

	wp_enqueue_script(
		'gowatch-html5',
		get_template_directory_uri() . '/js/html5.js',
		array('jquery'),
		AIRKIT_THEME_VERSION,
		true
	);

	if ( 'y' == $lazyload ) {

		wp_enqueue_script(
			'gowatch-lazyload',
			get_template_directory_uri() . '/js/jquery.lazyload.min.js',
			false,
			AIRKIT_THEME_VERSION,
			true
		);
	}

	wp_enqueue_script(
		'gowatch-cookie',
		get_template_directory_uri() . '/js/jquery.cookie.js',
		false,
		AIRKIT_THEME_VERSION,
		true
	);

    if ( $onePageWebsite == 'y' ) {
    	wp_enqueue_script(
	        'gowatch-scrollTo',
	        get_template_directory_uri() . '/js/jquery.scrollTo-min.js',
	        false,
	        AIRKIT_THEME_VERSION,
	        true
	    );
    }

    if ( $enablePreloader == 'y' || $enablePreloader == 'fp' ) {

		wp_enqueue_script(
			'gowatch-nprogress',
			get_template_directory_uri() . '/js/nprogress.js',
			false,
			AIRKIT_THEME_VERSION,
			true
		);
	}

	if ( isset($_GET['playlist_ID']) ) {
		wp_enqueue_script(
			'gowatch-slick',
			get_template_directory_uri() . '/js/slick.js',
			array( 'jquery' ),
			AIRKIT_THEME_VERSION,
			true
		);
	}

	// if is singular & related posts behavior is carousel, enqueue slick.js

	if ( is_object($post) && is_singular() ) {

		if( ( airkit_option_value( 'single', 'related_posts_behavior' ) == 'carousel' ) || ( class_exists('WooCommerce') && is_product( get_the_ID() ) ) || ( 'gallery' == get_post_format($post->ID) ) ) {

			wp_enqueue_script(
				'gowatch-slick',
				get_template_directory_uri() . '/js/slick.js',
				array( 'jquery' ),
				AIRKIT_THEME_VERSION,
				true
			);
		}

		// Include the player JS
		if ( get_post_type() == 'video' || get_post_format() == 'video' ) {
				
			wp_enqueue_script(
				'gowatch-videojs',
				get_template_directory_uri() . '/js/video.js',
				array( 'jquery' ),
				AIRKIT_THEME_VERSION,
				true
			);
				
			wp_enqueue_script(
				'gowatch-videojs-extend',
				get_template_directory_uri() . '/js/video-extend.js',
				array( 'jquery' ),
				AIRKIT_THEME_VERSION,
				true
			);

		}

	}

	// Core registered script #underscore.min.js
	wp_enqueue_script( 'underscore' );

	wp_enqueue_script(
		'gowatch-scripting',
		get_template_directory_uri() . '/js/scripting.js',
		array( 'jquery' ),
		AIRKIT_THEME_VERSION,
		true
	);

	wp_enqueue_script(
		'hoverIntent',
		'',
		array( 'gowatch-scripting' ),
		AIRKIT_THEME_VERSION,
		true
	);

	wp_enqueue_script(
		'gowatch-megamenu',
		get_template_directory_uri() . '/js/megamenu.js',
		array( 'gowatch-bootstrap' ),
		AIRKIT_THEME_VERSION,
		true
	);	

	// Javascript localization
	$contact_form_gen_token = wp_create_nonce("submit-contact-form");
	$right_click = airkit_option_value( 'general', 'right_click' ) == 'y' ? 'y' : 'n';

	$airkit_logo_content =  airkit_get_logo();

	$localize_data = array(
		'contact_form_token'     => $contact_form_gen_token,
		'contact_form_success'   => esc_html__('Sent successfully', 'gowatch'),
		'contact_form_error'     => esc_html__('Error!' , 'gowatch'),
		'ajaxurl'                => admin_url('admin-ajax.php'),
		'main_color'             => airkit_option_value('gowatch_colors', 'primary_color'),
		'ts_enable_imagesloaded' => airkit_option_value('general', 'enable_imagesloaded'),
		'airkit_site_width'      => (int)airkit_option_value('styles', 'site_width'),
		'airkit_logo_content'    => $airkit_logo_content,
		'video_nonce'            => wp_create_nonce("video_nonce"),
		'ts_security'            => wp_create_nonce( 'security' ),
		'rightClick'             => $right_click,
		'airkit_facebook_id'     => airkit_option_value( 'general', 'facebook_id', false ),
		'prevent_adblock'        => $prevent_adblock,
		'airkit_blocker_html'    => $adblock_html,
		'nothing_msg'            => esc_html__('Hmmm, we have nothing to show!','gowatch'),
		'back_text'            	 => esc_html__('Back','gowatch'),
		'close_results_text'     => esc_html__('Close results','gowatch'),
		'show_less'     		 => esc_html__('Show less','gowatch'),
		'show_more'     		 => esc_html__('Show more','gowatch'),
		'please_wait'     		 => esc_html__('Please wait...','gowatch'),
		'confirm_remove'     	 => esc_html__('Are you sure want to remove?','gowatch'),
	);

	// Add the ID of the current post to the data array
	if ( is_singular() ) {
		$localize_data['post_ID'] = get_the_ID();
	}

	wp_localize_script( 'gowatch-scripting', 'gowatch', $localize_data );

    if( is_singular() || is_archive() && airkit_option_value( 'layout', 'sticky_sidebar' ) == 'y' ) {

    	wp_enqueue_script(
			'gowatch-jquery.fancybox.min',
			get_template_directory_uri() . '/js/jquery.fancybox.min.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			true
    	);

    	wp_enqueue_script(
			'gowatch-affix',
			get_template_directory_uri() . '/js/affix.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			true
    	);    	
    }

    if ( is_singular() && get_post_type( get_the_ID() ) == 'portfolio' ) {

    	wp_enqueue_script(
			'gowatch-css3-animations',
			get_template_directory_uri() . '/js/css3-animations.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			true
		);

	    wp_enqueue_style(
			'gowatch-css3-animations',
			get_template_directory_uri() . '/css/css3-animations.css',
			array(),
			AIRKIT_THEME_VERSION
		);
    }

    if ( is_singular() && get_post_type( get_the_ID() ) == 'ts-gallery' ) {	

    	wp_enqueue_script(
			'gowatch-jquery.fancybox.min',
			get_template_directory_uri() . '/js/jquery.fancybox.min.js',
			array('jquery'),
			AIRKIT_THEME_VERSION,
			true
		);
		
    	if( 'horizontal' == airkit_single_option( 'style' ) ){

		    wp_enqueue_script(
				'gowatch-scroll',
				get_template_directory_uri() . '/js/scroll.js',
				array('jquery'),
				AIRKIT_THEME_VERSION
			);

    	}

	    wp_enqueue_script(
			'gowatch-isotope',
			get_template_directory_uri() . '/js/isotope.js',
			array(),
			AIRKIT_THEME_VERSION,
			true
		);
    }

    $content = is_object($post) ? $post->post_content : '';
    $galleries = is_object($post) ? get_post_galleries( $post->ID, false ) : array();

    // Check if has WordPress gallery shortcode
    if ( is_single() && has_shortcode( $content, 'gallery' ) ) {

        foreach ($galleries as $key => $gallery) {
            
        	if ( !isset($gallery['gallery_style']) ) {
        		break;
        	}

            if ( 'grid' == $gallery['gallery_style'] ) {
                wp_enqueue_script(
                    'gowatch-isotope',
                    get_template_directory_uri() . '/js/isotope.js',
                    array(),
                    AIRKIT_THEME_VERSION,
                    true
                );
            } elseif ( 'carousel' == $gallery['gallery_style'] ) {
                wp_enqueue_script(
	                'gowatch-slick',
	                get_template_directory_uri() . '/js/slick.js',
	                array(),
	                AIRKIT_THEME_VERSION,
	                true
	            );
            }

        }
    }

    /*
	 * Load scroll.js on login / register page.
     */
    if( get_the_ID() == get_frontend_registration_url( 'id' ) ) {

	    wp_enqueue_script(
			'gowatch-scroll',
			get_template_directory_uri() . '/js/scroll.js',
			array('jquery'),
			AIRKIT_THEME_VERSION
		);    	

    }

	// Enqueue styles:

	wp_enqueue_style(
		'gowatch-webfont',
		get_template_directory_uri() . '/css/redfont.css',
		array(),
		AIRKIT_THEME_VERSION
	);

	wp_enqueue_style(
		'gowatch-widgets',
		get_template_directory_uri() . '/css/widgets.css',
		array(),
		AIRKIT_THEME_VERSION
	);

	wp_enqueue_style(
		'gowatch-bootstrap',
		get_template_directory_uri() . '/css/bootstrap.css',
		array(),
		AIRKIT_THEME_VERSION
	);

	if( class_exists('WooCommerce') ) {
		wp_enqueue_style(
			'gowatch-woocommerce',
			get_template_directory_uri() . '/css/woocommerce-theme.css',
			array(),
			AIRKIT_THEME_VERSION
		);
	}

	$files = array( 'css' => array(), 'js' => array(), 'fonts' => array() );

	////// Builder scripts. \\\\\\\

	// $files = array( 'css' => array(), 'js' => array(), 'fonts' => array() );

	$header = airkit_Compilator::get_head( 'header' );
	$footer = airkit_Compilator::get_head( 'footer' );
	$layouts = array();

	if ( airkit_Compilator::builder_is_enabled() ) {

		$layouts = ( $layouts = get_post_meta( $post->ID, 'ts_template', true ) ) && is_array( $layouts ) ? $layouts : array();
	}

	$layouts = array_merge( $header, $footer, $layouts );

	foreach ( $layouts as $row ) {

		if ( isset($row['settings']) ) {

			$files = airkit_get_scripts( $files, $row['settings'] );
			
		}

		if ( isset($row['columns']) ) {

			if ( empty( $row['columns'] ) ) continue;

			foreach ( $row['columns'] as $column ) {

				$files = airkit_get_scripts( $files, $column['settings'] );

				if ( empty( $column['elements'] ) ) continue;

				foreach ( $column['elements'] as $element ) {

					$files = airkit_get_scripts( $files, $element );

				}
			}

		}

	}
	
	airkit_assets_loop( $files );

	wp_enqueue_style(
		'gowatch-style',
		get_template_directory_uri() . '/css/style.css',
		array( 'gowatch-bootstrap' ),
		AIRKIT_THEME_VERSION
	);
	wp_enqueue_style(
		'gowatch-videojs-style',
		get_template_directory_uri() . '/css/videoplayer.css',
		array( 'gowatch-bootstrap' ),
		AIRKIT_THEME_VERSION
	);
}


add_action( 'wp_enqueue_scripts', 'airkit_dequeue_woocommerce_cart_fragments', 11); 

function airkit_dequeue_woocommerce_cart_fragments() {

	if ( is_front_page() ) wp_dequeue_script( 'wc-cart-fragments' );

}


function airkit_assets_loop( $files ) {


	foreach( $files['css'] as $key => $val ) {

	    wp_enqueue_style(
			'gowatch-' . $key,
			get_template_directory_uri() . '/css/' . $key . '.css',
			array(),
			AIRKIT_THEME_VERSION
		);
	}

	foreach( $files['js'] as $key => $val ) {

	    wp_enqueue_script(
			'gowatch-' . $key,
			get_template_directory_uri() . '/js/' . $key . '.js',
			array( 'jquery' ),
			AIRKIT_THEME_VERSION,
			true
		);
	}

}

add_filter( 'the_content', 'airkit_content_scripts' );

function airkit_content_scripts( $content, $async = true ){

	$extension = array( 'css' => array(), 'js' => array(), 'fonts' => array() );
	$files = airkit_get_files_shortcodes( $content, $extension );

	if( $async ) {

		airkit_load_async_scripts( $files );

	} else {

		airkit_assets_loop( $files );

	}

	return $content;
}


function airkit_ajax_content_scripts( $post_ID ) {

	$post = get_post($post_ID);
	$extension = array( 'css' => array(), 'js' => array(), 'fonts' => array() );
	$files = airkit_get_files_shortcodes( $post->post_content, $extension, 'gallery' );

	airkit_load_async_scripts( $files );

}


function airkit_get_scripts( $files, $options ) {
	global $post;

	if ( isset( $options['reveal-effect'] ) && 'none' !== $options['reveal-effect'] ) {

		$files['js']['css3-animations'] = '';
		$files['css']['css3-animations'] = '';
	}
	
	if ( isset( $options['ids'] ) ) {

		$options['style'] = isset($options['gallery_style']) ? $options['gallery_style'] : 'list';	
		$options['element-type'] = 'gallery';

	}

	switch ( $options['element-type'] ) {

		case 'row':

			if( 'y' == $options['sticky'] ) {

				$files['js']['affix'] = '';
			}

			if( 'y' == $options['carousel'] ) {

				$files['js']['slick'] = '';
			}

			if( isset( $options['slider-bg'] ) && 'y' == $options['slider-bg'] ) {

				$files['js']['slick'] = '';

			}
			if( isset( $options['parallax-images'] ) && 'y' == $options['parallax-images'] ) {

				$files['js']['jquery.enllax.min'] = '';

			}

		break;

		// case 'row':
		case 'column':

			if ( 'y' !== $options['parallax'] ) {

				$files['js']['parallax-img'] = '';
			}

		break;

		case 'accordion':

			$files['js']['bootstrap'] = '';

		break;

		case 'featured-area':

			if ( $options['style'] == 'style-1' ) {
				$files['js']['scroll'] = '';
			} elseif ( $options['style'] == 'style-3' ) {
				$files['js']['slick'] = '';
			}
			
		break;

		case 'image-carousel':
		case 'image_carousel':

			$files['js']['slick'] = '';

		break;

		case 'map':
			$api_data = airkit_option_value('typography', 'extra');
			wp_enqueue_script(
				'map',
				'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($api_data['google_fonts_key']) . '&sensor=false&amp;libraries=&libraries=geometry,drawing,places',
				false,
				AIRKIT_THEME_VERSION,
				true
			);

		break;

		case 'boca':
		case 'nona':
		case 'grease':

			$files['js']['slick'] = '';

		break;

		case 'filters':

			$files['js']['isotope'] = '';

		break;

		case 'video':

			if ( 'y' == $options['lightbox'] ) {

				$files['js']['jquery.fancybox.min'] = '';
			}

		break;

		case 'grid':
		case 'thumbnail':
		case 'super':
		case 'small-articles':
		case 'big':
		case 'list-products':

			if ( 'masonry' == $options['behavior'] || 'filters' == $options['behavior'] ) {

				$files['js']['isotope'] = '';

			} elseif ( 'scroll' == $options['behavior'] ) {

				$files['js']['scroll'] = '';

			} elseif ( 'carousel' == $options['behavior'] ) {

				$files['js']['slick'] = '';
			}

		break;	

		case 'list_view':

			$files = airkit_get_files_shortcodes( $options, $files );

		break;

		case 'features-block':
		case 'listed-features':
		case 'pricing-tables':
		case 'pricelist':

			$files['js']['css3-animations'] = '';
			$files['css']['css3-animations'] = '';

		break;

		case 'mosaic':

			if ( 'scroll' == $options['behavior'] ) {

				$files['js']['scroll'] = '';

			} elseif ( 'filters' === $options['behavior'] ) {

				$files['js']['isotope'] = '';
				
			} elseif ( 'carousel' === $options['behavior'] ) {

				$files['js']['slick'] = '';
				
			}


		break;

		case 'gallery':

			if( 'masonry' == $options['style'] || 'grid' == $options['style'] ) {

				$files['js']['isotope'] = '';

			} elseif ( 'horizontal' == $options['style'] ) {

				$files['js']['scroll'] = '';

			} elseif ( 'carousel' == $options['style'] ) {
				
				$files['js']['slick'] = '';

			} elseif ( 'list' == $options['style'] ) {
				
				$files['js']['slick'] = '';

			}

		break;

		case 'menu':

			if ( 'google' == $options['font-type'] ) {

				$family = $options['font']['family'];

				$font = array(
					'weight'  => array( $options['font']['weight'] => $options['font']['weight'] )
				);

				if ( isset( $files['fonts'][ $family ] ) ) {

					$files['fonts'][ $family ] = array_merge( $files['fonts'][ $family ], $font );

				} else {

					$files['fonts'][ $family ] = $font;
				}
			}

		break;

		case 'counter':

			$files['js']['counters'] = '';

		break;

		case 'chart-pie':
		case 'chart-line':

			$files['js']['chart'] = '';

		break;

		case 'slider':

			if( 'corena' === $options['type'] ) {

				$files['js']['stream'] = '';

			} elseif ( 'klein' === $options['type'] || 'mambo' === $options['type'] ) {

				$files['js']['slick'] = '';

			} elseif ( 'tilter-slider' === $options['type'] ) {

				$files['js']['slick'] = '';

				if ( 'y' == $options['tilt-hover-effect'] ) {
					
					$files['js']['anime.min'] = '';
					$files['js']['tilt-effects.min'] = '';
				}
			} else {
			 
				$files['js'][ $options['type'] ] = '';
			}

		break;

		case 'sidebar':

			if( 'y' === $options['sidebar-sticky'] ) {

				$files['js']['affix'] = '';
				
			}

		break;

		case 'text':

			$files = airkit_get_files_shortcodes( $options['text'], $files );

		break;

		case 'testimonials':
		case 'teams':
		case 'clients':

			if( 'y' === $options['carousel'] ) {

				$files['js']['slick'] = '';

			}

			$files['js']['css3-animations'] = '';
			$files['css']['css3-animations'] = '';

		break;
	}

	return $files;
}

function airkit_get_files_shortcodes( $content, $files, $shortcode = null ) {
	$shortcodes = get_option( 'gowatch_shortcodes' );
	$shortcodes['gallery'] = 'Gallery';

	if( empty( $shortcodes ) ) {

		return array();

	}

	$atts = array();

	if( is_string( $content ) ) {

		foreach ( $shortcodes as $key => $shortcode_name ) {

			$shortcode_key = has_shortcode( $content, 'ts_' . $key ) ? 'ts_' . $key : $shortcode;

			if ( has_shortcode( $content, $shortcode_key ) ) {

				preg_match_all( '/\[(\[?)(' . $shortcode_key . ')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s', $content, $matches );

				if ( ! empty( $matches[3] ) ) {

					if ( is_array( $matches[3] ) ) {

						foreach ( $matches[3] as $atts_str ) {

							$atts[] = shortcode_parse_atts( $atts_str );
						}

					} else {

						$atts[] = shortcode_parse_atts( $matches[3] );
					}
				}

			}

		}
		
	}

	if( !empty( $atts ) ) {

		foreach ( $atts as $att ) {
			$files = airkit_get_scripts( $files, $att );
		}

	}

	return $files;
}

function airkit_is_edit_page( $new_edit = null ) {
	global $pagenow;
	//make sure we are on the backend
	if (!is_admin()) return false;


	if($new_edit == "edit")
		return in_array( $pagenow, array( 'post.php', ) );
	elseif($new_edit == "new") //check for new post page
		return in_array( $pagenow, array( 'post-new.php' ) );
	else //check for either new or edit
		return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

/*
 * Async include scripts. Used to include shortcode scripts for ajax loaded posts
 */
if( !function_exists('airkit_load_async_scripts') ) {

	function airkit_load_async_scripts( $scripts = array() ){

		foreach ( $scripts['js'] as $script => $val ): ?>
			<script type="text/javascript">
			var slug = "<?php echo airkit_var_sanitize($script, true); ?>";
			if( jQuery('[data-unique-script="'+slug+'"]').length == 0 ) {
				var script = document.createElement('script');
				script.src = "<?php echo esc_url(get_template_directory_uri().'/js/'. $script .'.js'); ?>"
				script.setAttribute('data-unique-script', slug);

				jQuery('body').append(script);
			}				
			</script>		
		<?php endforeach;
	}

}