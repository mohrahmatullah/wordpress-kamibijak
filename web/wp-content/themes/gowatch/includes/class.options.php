<?php

/**
*  Create global options.
*/
class airkit_Options
{
	function __construct()
	{
		add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
		add_action( 'admin_menu', array( $this, 'create_menu' ) );
		add_action( 'admin_init', array( $this, 'save' ) );
		add_action( 'wp_ajax_ts_get_patterns', array( $this, 'airkit_get_patterns' ) );
		add_action( 'wp_ajax_ts_add_sidebar', array( $this, 'add_sidebar' ) );
		add_action( 'wp_ajax_ts_remove_sidebar', array( $this, 'remove_sidebar' ) );
		add_action( 'wp_ajax_ts_remove_font', array( $this, 'remove_font' ) );
		add_action( 'wp_ajax_airkit_reset_settings', array( $this, 'reset_settings' ) );
		add_action( 'wp_ajax_airkit_flush_fonts_transient', array( $this, 'flush_fonts_transient' ) );

	}

	// Add sub menu page to the Appearance menu.
	static function create_menu()
	{
		add_theme_page(
			'goWatch Options Panel',
			'Theme Options',
			'edit_theme_options',
			'gowatch',
			array( __CLASS__, 'display_menu_page' )
		);

		add_theme_page(
			'Header',
			esc_html__('Header', 'gowatch'),
			'edit_theme_options',
			'gowatch_header',
			array( __CLASS__, 'gowatch_header' )
		);

		add_theme_page(
			'Footer',
			esc_html__('Footer', 'gowatch'),
			'edit_theme_options',
			'gowatch_footer',
			array( __CLASS__, 'gowatch_footer' )
		);
	}

	// We can extract 'all' this means extract all settings fields, we can still extract array of tabs or any key of fields.
	static function get_options( $extract, $tab = 'general' )
	{
		$enable = array(
			'y' => esc_html__( 'Yes', 'gowatch' ),
			'n' => esc_html__( 'No', 'gowatch' )
		);

		// Get all sidebars and create array by structure array( 'id sidebar' => 'name sidebar' ) to send in options select.
		$saved_sidebars = get_option( 'gowatch_sidebars', array() );

		$sidebars = array( 'main' => esc_html__( 'Main Sidebar', 'gowatch' ), 'footer1' => esc_html__( 'Footer 1', 'gowatch' ), 'footer2' => esc_html__( 'Footer 2', 'gowatch' ), 'footer3' => esc_html__( 'Footer 3', 'gowatch' ), 'footer4' => esc_html__( 'Footer 4', 'gowatch' ) );

		foreach ( $saved_sidebars as $id => $sidebar ) {
			$sidebars[ $id ] = $sidebar;
		}

		$frontend_submission_forms   = self::get_frontend_forms( 'submit' );
		$frontend_registration_forms = self::get_frontend_forms( 'register' );

		$fields = array(

			'general' => array(

				array(
					'name'    => esc_html__( 'Enable preloader', 'gowatch' ),
					'desc'    => esc_html__( 'This option can add to your website a fancy preloader that will wait till all the page will be loaded and then will display it. You can use it only for homepage, or for the entire website.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'n' => esc_html__( 'No', 'gowatch' ),
						'y' => esc_html__( 'Yes', 'gowatch' ),
						'fp' => esc_html__( 'First page only', 'gowatch' ),
					),
					'id'      => 'enable_preloader',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Convert time to human time', 'gowatch' ),
					'desc'    => esc_html__( 'This option will convert all date time on the site to human readable format.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'n' => esc_html__( 'No', 'gowatch' ),
						'y' => esc_html__( 'Yes', 'gowatch' ),
					),
					'id'      => 'enable_human_time',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Enable show lightbox', 'gowatch' ),
					'desc'    => esc_html__( 'Enable this if you want your featured images on single pages to have lightbox (open full size images when you click on the button in a modal window) available.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'enable_lightbox',
					'std'     => 'y'
				),

				array(
					'name'    => esc_html__( 'Enable Image Lazy Loading', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, it will load images only when you scroll to the image position making the website load faster.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'enable_imagesloaded',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Comment system', 'gowatch' ),
					'desc'    => esc_html__( 'Choose what commenting system you want to use, WordPress default comments or Facebook comments. If you use a plugin to replace the comments, set this option to Default WordPress.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'default'  => esc_html__( 'Default', 'gowatch' ),
						'facebook' => 'Facebook'
					),
					'id'           => 'comment_system',
					'std'          => 'default',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'  => esc_html__( 'Set a Facebook App ID', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'facebook_id',
					'std'   => '',
					'class' => 'airkit_comment_system-facebook'
				),


				array(
					'name'    => esc_html__( 'Enable sticky menu option', 'gowatch' ),
					'desc'    => esc_html__( 'In case you need only the menu to be sticky when you scroll below it, enable this option. Keep in mind that this will not make other elements to be included, only the menu will become like this. Please make sure you do not use other sticky elements/rows on page, conflicts might happen.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'enable_sticky_menu',
					'std'     => 'n',
					'class_select' => 'airkit_trigger-options',
				),
				
				// Sticky menu custom colors
				array(
					'name'  => esc_html__( 'Sticky menu background color', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'sticky_menu_bg_color',
					'std'   => '#FFFFFF',
					'class' => 'airkit_enable_sticky_menu-y',

				),		

				array(
					'name'  => esc_html__( 'Sticky menu text color', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'sticky_menu_text_color',
					'std'   => '#111111',
					'class' => 'airkit_enable_sticky_menu-y',

				),

				array(
					'name'  => esc_html__( 'Sticky menu background color on hover', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'sticky_menu_bg_color_hover',
					'std'   => '#fcfcfc',
					'class' => 'airkit_enable_sticky_menu-y',

				),		

				array(
					'name'  => esc_html__( 'Sticky menu text color on hover', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'sticky_menu_text_color_hover',
					'std'   => '#444444',
					'class' => 'airkit_enable_sticky_menu-y',

				),

				array(
					'name'         => esc_html__( 'Lock content if AdBlock is enabled', 'gowatch' ),
					'desc'         => esc_html__( 'If set to Yes, this option will not allow viewing content if user has AdBlock enabled.', 'gowatch' ),
					'field'        => 'select',
					'options'      => $enable,
					'id'           => 'prevent_adblock',
					'std'          => 'n',
				),

				array(
					'name'         => esc_html__( 'Enable likes system', 'gowatch' ),
					'desc'         => esc_html__( 'If enabled, it will show likes counter and icon in different parts of the website. If you click on the icon, +1 will be added to it. This system uses cookies, not 100% accurate.', 'gowatch' ),
					'field'        => 'select',
					'options'      => $enable,
					'id'           => 'like',
					'std'          => 'y',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'    => esc_html__( 'Disable right click', 'gowatch' ),
					'desc'    => esc_html__( 'Enable this option if you wish to disable the option to right click on your website. Note: Not very user friendly, so proceed with caution.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'right_click',
					'std'     => 'n',
				),

				array(
					'name'    => esc_html__( 'Choose an icon for your likes', 'gowatch' ),
					'field'   => 'list_select',
					'options' => array(
						'icon-big-heart',
						'icon-thumb',
						'icon-star',
					),
					'defined-icons' => 'y',
					'id'    => 'like_icon',
					'std'   => 'icon-thumb',
					'class' => 'airkit_like-y'
				),

				array(
					'name'  => esc_html__( 'Generate random likes', 'gowatch' ),
					'desc'  => esc_html__( 'CAUTION! This is an irreversible process, all your previous likes and views data will be removed and replaced. Proceed with caution.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'button',
					'id'    => 'generate-likes',
					'std'   => esc_html__( 'Generate likes', 'gowatch' )
				),

				array(
					'name'  => esc_html__( 'Reset likes to zero', 'gowatch' ),
					'desc'  => esc_html__( 'CAUTION! This is an irreversible process, all your previous likes and views data will be set to 0. Proceed with caution.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'button',
					'id'    => 'reset-likes',
					'std'   => esc_html__( 'Reset likes to zero', 'gowatch' )
				),

				array(
					'name'  => esc_html__( 'Enable facebook like modal', 'gowatch' ),
					'desc'  => esc_html__( 'If enabled, this will show a modal window on page load asking the user to like your Facebook page.', 'gowatch' ),
					'field' => 'select',
					'id'    => 'enable_facebook_box',
					'std'   => 'n',
					'options' => array(
						'y' => esc_html__( 'Yes', 'gowatch' ),
						'n' => esc_html__( 'No', 'gowatch' ),
					),
					'class_select' => 'airkit_trigger-options',

				),

				array(
					'name'  => esc_html__( 'Facebook page name', 'gowatch' ),
					'desc'  => esc_html__( 'Name of the page that will appear in like modal.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'facebook_name',
					'std'   => '',
					'class' => 'airkit_enable_facebook_box-y',
				),

				array(
					'name'  => esc_html__( 'Copyright', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your copyright text. NOTE: You can use %year to show current year, %site_title to show Site title and HTML tags is available (p, a, b, strong, u, i, em, sub, sup)', 'gowatch' ),
					'field' => 'textarea',
					'id'    => 'copyright',
					'std'   => sprintf( esc_html__( '&copy; %s. All rights reserved. %s', 'gowatch' ), date('Y'), get_bloginfo('name') ),
				),

				array(
					'name'  => esc_html__( 'Custom JavaScript code', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your custom JavaScript code you have, including the script tag. Eg: Google Analytics', 'gowatch' ),
					'field' => 'textarea',
					'id'    => 'custom_javascript',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Grid view excerpt size', 'gowatch' ),
					'desc'  => esc_html__( 'Change the number of characters (text) shown in grid view post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'number',
					'id'    => 'grid_excerpt',
					'std'   => 180
				),

				array(
					'name'  => esc_html__( 'List view excerpt size', 'gowatch' ),
					'desc'  => esc_html__( 'Change the number of characters (text) shown in list view post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'number',
					'id'    => 'list_excerpt',
					'std'   => 300
				),

				array(
					'name'  => esc_html__( 'Bigpost view excerpt size', 'gowatch' ),
					'desc'  => esc_html__( 'Change the number of characters (text) shown in big posts view post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'number',
					'id'    => 'bigpost_excerpt',
					'std'   => 180
				),

				array(
					'name'  => esc_html__( 'Timeline view excerpt size', 'gowatch' ),
					'desc'  => esc_html__( 'Change the number of characters (text) shown in timeline view post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'number',
					'id'    => 'timeline_excerpt',
					'std'   => 260
				),

				array(
					'name'  => esc_html__( 'Feature area view excerpt size', 'gowatch' ),
					'desc'  => esc_html__( 'Change the number of characters (text) shown in featured area element.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'number',
					'id'    => 'featured_area_excerpt',
					'std'   => 160
				),

				/*
				 * Frontend submission settings.
				 */
				array(
					'field' => 'option_block',
					'id'   	=> 'frontend-submission-block',
					'title' => esc_html__( 'Frontend submission Forms', 'gowatch' ),
					'subtitle' => esc_html__( 'In this section you can change Frontend Submission Forms.', 'gowatch' ),
					'std'   => ''
				),

				array(
					'name'    => esc_html__( 'Frontend submission active form', 'gowatch' ),
					'desc'    => esc_html__( 'Choose a form that will be displayed in Frontend submission page.', 'gowatch' ),
					'field'   => 'select',
					'options' => $frontend_submission_forms,
					'id'      => 'frontend_submission_form',
					'std'     => 'default',
				),		

				array(
					'name'    => esc_html__( 'Frontend registration active form', 'gowatch' ),
					'desc'    => esc_html__( 'Choose a form that will be displayed in Frontend user registration page.', 'gowatch' ),
					'field'   => 'select',
					'options' => $frontend_registration_forms,
					'id'      => 'frontend_registration_form',
					'std'     => 'default',
				),

				array(
					'name'    => esc_html__( 'Re-install Default Forms', 'gowatch' ),
					'desc'    => esc_html__( 'If you have edited or deleted default forms, this button allows you to reinstall them in one click.', 'gowatch' ),
					'field'   => array( __CLASS__, 'reinstall_forms' ),
					'id'      => 'reinstall_forms',
				),

				/*
				 * Custom post slugs settings.
				 */
				array(
					'field' => 'option_block',
					'id'   	=> 'custom-post-block',
					'title' => esc_html__( 'Custom posts settings', 'gowatch' ),
					'subtitle' => esc_html__( 'In this section you can change slugs for TouchSize Custom Post Types.', 'gowatch' ),
					'std'   => ''
				),		
			),

			'styles' => array(

				array(
					'name'    => esc_html__( 'Logo type', 'gowatch' ),
					'desc'    => esc_html__( 'Choose type of logo you want to use. If you choose image, you have to upload under Site Identity tab in WordPress Built-in Customizer. (Appearance -> Customize).', 'gowatch' ),			
					'field'   => 'select',
					'options' => array(
						'image'  => esc_html__('Logo image', 'gowatch'),
		    			'google' => esc_html__('Logo text', 'gowatch')
					),
					'id'      => 'logo[type]',
					'std'     => 'n',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'    => esc_html__( 'Logo font styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'logo[font]',
					'std'     => array(
						'family'    => 'Open Sans',
						'weight'    => 'normal',
						'class_css' => '.logo',
						'size'      => 54,
						'style'     => 'normal',
						'letter'    => 0,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					),
					'class' => 'airkit_logo-type-google'
				),

				array(
					'name'    => esc_html__( 'Enable retina logo', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled this will make the image logo you upload 2 times smaller on the website so that it looks good on high DPI devices. If logo is added in smaller container that it\'s size, it will be contained in it.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'logo[retina]',
					'std'     => 'n',
					'class' => 'airkit_logo-type-image'
				),

				array(
					'name'    => esc_html__( 'Boxed Layout', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will add white background to content and limit the boundaries of the site that is set in general settings. Expanded rows and content will work only inside the white box.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'boxed_layout',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Enable hover effect', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, it will add overlay effect in post listing views when you mouseover the featured image.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'hover_style',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Choose play button style for views', 'gowatch' ),
					'desc'    => esc_html__( 'You can choose where you want to have the play button in views. If you select center it will align it middle, if right the play button will be aligned right/bottom depending on the views you use.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'right'   => esc_html__( 'Right', 'gowatch' ),
						'center'  => esc_html__( 'Center', 'gowatch' ),
						'disable' => esc_html__( 'Disabled', 'gowatch' ),
					),
					'id'      => 'play_button_position',
					'std'     => 'right',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'    => esc_html__( 'Choose play button style', 'gowatch' ),
					'desc'    => esc_html__( 'You can choose from 2 different styles, one with white background and primary color border, the simple version uses a simple white border and a play button.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'background'   => esc_html__( 'Background style', 'gowatch' ),
						'simple'  => esc_html__( 'Simple style', 'gowatch' ),
					),
					'id'      => 'play_button_style',
					'std'     => 'background',
					'class' => 'airkit_play_button_position-center',
				),

				array(
					'name'    => esc_html__( 'Header position', 'gowatch' ),
					'desc'    => esc_html__( 'Choose theme header position.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'top'   => esc_html__( 'Top', 'gowatch' ),
						'left'  => esc_html__( 'Left', 'gowatch' ),
						'right' => esc_html__( 'Right', 'gowatch' ),
					),
					'id'      => 'header_position',
					'std'     => 'top'
				),		

				array(
					'name'    => esc_html__( 'Theme background', 'gowatch' ),
					'desc'    => esc_html__( 'Choose your colors, background image or patterns available or none.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'pattern' => esc_html__( 'Pattern', 'gowatch' ),
						'color'   => esc_html__( 'Color', 'gowatch' ),
						'image'   => esc_html__( 'Image', 'gowatch' ),
						'n'       => esc_html__( 'No', 'gowatch' ),
					),
					'id'      => 'theme_custom_bg',
					'std'     => 'color'
				),

				array(
					'field' => array( __CLASS__, 'choose_bg' ),
					'id'    => 'theme_bg_pattern',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Website Background color', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'theme_bg_color',
					'std'   => '#FFFFFF'
				),

				array(
					'name'  => esc_html__( 'Upload background image', 'gowatch' ),
					'field' => 'upload',
					'id'    => 'bg_image',
					'std'   => ''
				),

				array(
                    'name'       => esc_html__( 'Social media sharing image', 'gowatch' ),
                    'desc'       => esc_html__( 'When your website is shared on social media (Eg: Facebook), the base URL of your website will have the image you set here. Anyway, we strongly recommend using a SEO plugin instead. (Eg: Yoast SEO)', 'gowatch' ),
                    'field'      => 'upload',
                    'media-type' => 'image',
                    'multiple'   => 'false',
                    'id'         => 'facebook_image',
                    'std'        => ''
				),

				array(
                    'name'       => esc_html__( 'Lazy images placeholder', 'gowatch' ),
                    'desc'       => esc_html__( 'When lazy loading is enabled, you can use this option to add an image that will be used as placeholder, while actual image is being loaded.', 'gowatch' ),
                    'field'      => 'upload',
                    'media-type' => 'image',
                    'multiple'   => 'false',
                    'id'         => 'lazy_placeholder',
                    'std'        => ''
				),

				array(
					'name'    => esc_html__( 'Shorten title for views', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, it will crop the titles to a certain amount of charaters and will add three dots at the end.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'n'       => esc_html__( 'No', 'gowatch' ),
						30 		  => esc_html__( '30 characters', 'gowatch' ),
						55        => esc_html__( '55 characters', 'gowatch' ),
						80        => esc_html__( '80 characters', 'gowatch' ),
						120       => esc_html__( '120 characters', 'gowatch' ),
					),
					'id'      => 'title_char_size',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Enable overlay subtle overlay effect for images', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, it will add subtle effect over images in archive pages and single featured images.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'n'       => esc_html__( 'No', 'gowatch' ),
						'stripes' => esc_html__( 'Stripes', 'gowatch' ),
						'dots'    => esc_html__( 'Dots', 'gowatch' )
					),
					'id'      => 'overlay_effect',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Grayscale images in views', 'gowatch' ),
					'desc'    => esc_html__( 'If this option is set to Yes, images in views will be converted to grayscale mode.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'grayscale_img_view',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Enable scroll to top button', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, it will add a button in the bottom right corner of your website. When users click on it, they are automatically sent to the top of your website.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'scroll_to_top',
					'std'     => 'y'
				),

				array(
					'name'    => esc_html__( 'Choose a website default width', 'gowatch' ),
					'desc'    => esc_html__( 'This option affects only big screens. Choose any base content width of your website, depending on your content style. You can make your website wider or more narrow using this option.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						1380 => 1380,
						1240 => 1240,
						1170 => 1170,
						960  => 960
					),
					'id'      => 'site_width',
					'std'     => 1380
				),

				/*
	 			 * Styling for words
				 */
				array(
					'field' => 'option_block',
					'id'   	=> 'meta-word-styling-block',
					'title' => esc_html__( 'Words styling', 'gowatch' ),
					'subtitle' => esc_html__( 'In this section you can add custom styles for individual words, that will be applied for post titles.', 'gowatch' ),
					'std'   => ''
				),		


                array(
                    'name'     => esc_html__( 'Add new word', 'gowatch' ),
                    'field'    => 'words_tmpl',
                    'id'       => 'word_items',
                    'sortable' => 'true',
                    'std'      => array(),
                    'options'  => array(

                        array(
                            'name'  => esc_html__( 'Word', 'gowatch' ),
                            'field' => 'input',
                            'type'  => 'text',
                            'id'    => 'word',
                            'std'   => ''
                        ),

	                    array(
	                        'name'    => esc_html__( 'Select word style', 'gowatch' ),
	                        'field'   => 'select',
	                        'options' => array(
	                            'b'     => esc_html__( 'Bold', 'gowatch' ),
	                            'i'     => esc_html__( 'Italic', 'gowatch' ),
	                            'bi'    => esc_html__( 'Bold Italic', 'gowatch' ),
	                            'u'     => esc_html__( 'Underline', 'gowatch' ),
	                        ),
	                        'id'      => 'word-decoration',
	                        'std'     => 'n',
	                    ),

                    )
                ),

			),

			'colors' => array(

				array(
					'name'  => esc_html__( 'General color for the text on the website', 'gowatch' ),
					'desc'  => esc_html__( 'Change this to any color you want and that fits the background of the website.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'general_text_color',
					'std'   => '#111111'
				),

				array(
					'name'  => esc_html__( 'Links color', 'gowatch' ),
					'desc'  => esc_html__( 'Change this color if you want the links on your website to have a different color.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'link_color',
					'std'   => 'rgba(254,42,92,1)'
				),

				array(
					'name'  => esc_html__( 'Links color on hover', 'gowatch' ),
					'desc'  => esc_html__( 'Change this color if you want the links on hover to have a different color.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'link_color_hover',
					'std'   => 'rgba(204,19,89,1)'
				),

				array(
					'name'  => esc_html__( 'Color for titles of articles in views', 'gowatch' ),
					'desc'  => esc_html__( 'Change this color if you want article titles inside views to have a different color.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'title_color',
					'std'   => '#000000'
				),

				array(
					'name'  => esc_html__( 'Color for titles of articles in views on hover', 'gowatch' ),
					'desc'  => esc_html__( 'Change this color if you want article titles inside views on hover to have a different color on hover.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'title_color_hover',
					'std'   => 'rgba(168,68,206,1)'
				),		

				array(
					'name'  => esc_html__( 'Meta text color', 'gowatch' ),
					'desc'  => esc_html__( 'This affects dates, author information, different stats on the website.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'meta_color',
					'std'   => '#7c7c7c'
				),		

				array(
					'name'  => esc_html__( 'Primary color', 'gowatch' ),
					'desc'  => esc_html__( 'Main color of the website. It is used for backgrounds, borders of elements, etc. This defines your main brand/website color.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'primary_color',
					'std'   => 'rgba(254,42,92,1)'
				),

				array(
					'name'  => esc_html__( 'Primary color on hover', 'gowatch' ),
					'desc'  => esc_html__( 'Main color of the website. It is used for backgrounds, borders of elements, etc. This defines your main brand/website color on hover.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'primary_color_hover',
					'std'   => 'rgba(204,19,89,1)'
				),

				array(
					'name'  => esc_html__( 'Primary text color', 'gowatch' ),
					'desc'  => esc_html__( 'The color of the text that has a primary color background. Primary color reffers to the color setting above.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'primary_text_color',
					'std'   => '#FFFFFF'
				),

				array(
					'name'  => esc_html__( 'Primary text color on hover', 'gowatch' ),
					'desc'  => esc_html__( 'The color of the text that has a primary color background on hover. Primary color reffers to the color setting above.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'primary_text_color_hover',
					'std'   => '#f5f6f7'
				),

				array(
					'name'  => esc_html__( 'Secondary color', 'gowatch' ),
					'desc'  => esc_html__( 'Secondary color of the website. It is used for backgrounds, borders of elements, etc. This defines your secondary or contrast brand/website color.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'secondary_color',
					'std'   => 'rgba(107,98,255,1)'
				),

				array(
					'name'  => esc_html__( 'Secondary text color', 'gowatch' ),
					'desc'  => esc_html__( 'The color of the text that has a secondary color background.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'secondary_text_color',
					'std'   => '#FFFFFF'
				),

				array(
					'name'  => esc_html__( 'Secondary color on hover', 'gowatch' ),
					'desc'  => esc_html__( 'Secondary color of the website. It is used for backgrounds, borders of elements, etc. This defines your secondary or contrast brand/website color on hover.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'secondary_color_hover',
					'std'   => 'rgba(92,83,236,1)'
				),

				array(
					'name'  => esc_html__( 'Secondary text color on hover', 'gowatch' ),
					'desc'  => esc_html__( 'The color of the text that has a secondary color background on hover. Secondary color reffers to the color setting above.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'secondary_text_color_hover',
					'std'   => '#FFFFFF'
				),

				array(
					'name'  => esc_html__( 'Excerpt color', 'gowatch' ),
					'desc'  => esc_html__( 'The colors of the text in the menus and submenus on hover.', 'gowatch' ),
					'field' => 'input_color',
					'id'    => 'excerpt_color',
					'std'   => '#474747'
				),
			),

			'sizes'  => array(

				array(
					'name'    => esc_html__( 'Small Sizes', 'gowatch' ),
					'desc'    => esc_html__( 'Set image sizes you want to use for elements displaying small images. Note that this is not the actual size that will be shown on the website as images are stretched/condensed to fit their containers but the crop/resize size that will be used for this.', 'gowatch' ),
					'field'   => array( __CLASS__, 'img_size' ),
					'id'      => 'gowatch_small',
					'std'     => array(
						'width'  => '160',
						'height' => '120',
						'mode'   => 'crop'
					)
				),

				array(
					'name'    => esc_html__( 'Grid Sizes', 'gowatch' ),
					'desc'    => esc_html__( 'Set image sizes you want to use for elements of type grid. Note that this is not the actual size that will be shown on the website as images are stretched/condensed to fit their containers but the crop/resize size that will be used for this.', 'gowatch' ),
					'field'   => array( __CLASS__, 'img_size' ),
					'id'      => 'gowatch_grid',
					'std'     => array(
						'width'  => '640',
						'height' => '360',
						'mode'   => 'crop'
					)
				),

				array(
					'name'    => esc_html__( 'Wide Sizes', 'gowatch' ),
					'desc'    => esc_html__( 'Set image sizes you want to use for elements displaying wide images. Note that this is not the actual size that will be shown on the website as images are stretched/condensed to fit their containers but the crop/resize size that will be used for this.', 'gowatch' ),
					'field'   => array( __CLASS__, 'img_size' ),
					'id'      => 'gowatch_wide',
					'std'     => array(
						'width'  => '700',
						'height' => '394',
						'mode'   => 'crop'
					)
				),

				array(
					'name'    => esc_html__( 'Single Sizes', 'gowatch' ),
					'desc'    => esc_html__( 'Set image sizes you want to use for single post thumbnail. Note that this is not the actual size that will be shown on the website as images are stretched/condensed to fit their containers but the crop/resize size that will be used for this.', 'gowatch' ),
					'field'   => array( __CLASS__, 'img_size' ),
					'id'      => 'gowatch_single',
					'std'     => array(
						'width'  => '1280',
						'height' => '720',
						'mode'   => 'crop'
					)
				),  

			),

			'layout' => self::layout( $sidebars ),

			'typography' => array(

				array(
					'name'  => esc_html__( 'Insert a valid Google API key', 'gowatch' ),
					'desc'  => esc_html__( 'To ensure the font lists are always available please make sure you have your own key set. If no fonts are shown in the lists - there must be an issue with the Google Fonts Key you are using. To create one, please go to:', 'gowatch' ) . ' <a target="_blank href="' .esc_url( 'https://console.developers.google.com/' ) . '">https://console.developers.google.com</a>' ,
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[google_fonts_key]',
					'std'   => 'AIzaSyDeHWMNvn__nAwzrnUDJCeUrviMxNBu5R8'
				),

				array(
					'name'    => esc_html__( 'General body typography', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'body',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'body',
						'weight'    => 'normal',
						'size'      => 15,
						'style'     => 'normal',
						'letter'    => 0,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),

				array(
					'name'    => esc_html__( 'H1 styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'h1',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'h1',
						'weight'    => 'bold',
						'size'      => 52,
						'style'     => 'normal',
						'letter'    => -0.02,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),

				array(
					'name'    => esc_html__( 'H2 styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'h2',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'h2',
						'weight'    => 'bold',
						'size'      => 44,
						'style'     => 'normal',
						'letter'    => -0.02,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),

				array(
					'name'    => esc_html__( 'H3 styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'h3',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'h3',
						'weight'    => 'bold',
						'size'      => 38,
						'style'     => 'normal',
						'letter'    => -0.02,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),

				array(
					'name'    => esc_html__( 'H4 styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'h4',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'h4',
						'weight'    => 'bold',
						'size'      => 24,
						'style'     => 'normal',
						'letter'    => -0.04,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),	

				array(
					'name'    => esc_html__( 'H5 styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'h5',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'h5',
						'weight'    => 'normal',
						'size'      => 22,
						'style'     => 'bold',
						'letter'    => -0.02,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),

				array(
					'name'    => esc_html__( 'H6 styles', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'h6',
					'std'     => array(
						'family'    => 'Roboto',
						'class_css' => 'h6',
						'weight'    => 'bold',
						'size'      => 16,
						'style'     => 'normal',
						'letter'    => -0.02,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'none'
					)
				),	

				array(
					'name'    => esc_html__( 'Menu default typography ', 'gowatch' ),
					'field'   => 'typography',
					'id'      => 'airkit_menu',
					'std'     => array(
						'family'    => 'Montserrat',
						'class_css' => '.airkit_menu .navbar-nav > li, .airkit_menu li[class*=menu-item-]',
						'weight'    => 'bold',
						'size'      => 13,
						'style'     => 'normal',
						'letter'    => -0.01,
						'line'      => 'inherit',
						'decor'     => 'none',
						'transform' => 'uppercase'
					)
				),

				array(
					'name'  => esc_html__( 'Choose font subset you need', 'gowatch' ),
					'field' => 'subsets',
					'id'    => 'extra[subsets]',
					'std'   => array( 'latin' )
				),

                array(
                    'name'  => esc_html__( 'Flush Fonts transient', 'gowatch' ),
                    'desc'  => esc_html__( 'We are storing cached data about Google Fonts, sometimes you may want to manually flush this data, click this button to start flushing fonts cache.', 'gowatch' ),
                    'field' => array( __CLASS__, 'flush_transient'),
                    'id'    => 'fonts_transient',
                    'std'   => ''
                ),



				array(
					'field' => 'option_block',
					'id'   	=> 'font-sizes-block',
					'title' => esc_html__( 'Customize font sizes', 'gowatch' ),
					'subtitle' => esc_html__( 'Change font sizes for some specific places in the theme', 'gowatch' ),
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Single post title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for title of single posts.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[single_title_size]',
					'std'   => 42
				),

				array(
					'name'  => esc_html__( 'Single page title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for title of single pages.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[page_title_size]',
					'std'   => 42
				),

				array(
					'name'  => esc_html__( 'Single gallery title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for title of single gallery.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[gallery_title_size]',
					'std'   => 42
				),

				array(
					'name'  => esc_html__( 'Single video title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for title of single video.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[video_title_size]',
					'std'   => 42
				),

				array(
					'name'  => esc_html__( 'Grid view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[grid_title_size]',
					'std'   => 20
				),

				array(
					'name'  => esc_html__( 'Thumbnail view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[thumbnail_title_size]',
					'std'   => 18
				),

				array(
					'name'  => esc_html__( 'Big posts view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[bigpost_title_size]',
					'std'   => 24
				),

				array(
					'name'  => esc_html__( 'List view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[list_title_size]',
					'std'   => 28
				),

				array(
					'name'  => esc_html__( 'Super posts view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[super_title_size]',
					'std'   => 28
				),

				array(
					'name'  => esc_html__( 'Timeline view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[timeline_title_size]',
					'std'   => 36
				),

				array(
					'name'  => esc_html__( 'Mosaic view title font size', 'gowatch' ),
					'desc'  => esc_html__( 'Set a value, in pixels that will be used for titles of this post view.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[mosaic_title_size]',
					'std'   => 22
				),

				array(
					'field' => 'option_block',
					'id'   	=> 'font-upload-block',
					'title' => esc_html__( 'Upload custom icon font', 'gowatch' ),
					'subtitle' => esc_html__( 'Follow the instruction about custom icon fonts on our knowledgebase on the support desk to upload new icons. This might create big conflicts so please be cautious.', 'gowatch' ),
					'std'   => ''
				),

				array(
					'field' => array( __CLASS__, 'custom_font' ),
					'id'    => 'extra[custom]',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Upload file ".eot"', 'gowatch' ),
					'desc'  => esc_html__( 'When font icon was generated by fontello, you are given some files with the fonts. Upload the necessary format.', 'gowatch' ),
					'field' => 'upload',
					'id'    => 'extra[eot]',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Upload file ".svg"', 'gowatch' ),
					'desc'  => esc_html__( 'When font icon was generated by fontello, you are given some files with the fonts. Upload the necessary format.', 'gowatch' ),
					'field' => 'upload',
					'id'    => 'extra[svg]',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Upload file ".ttf"', 'gowatch' ),
					'desc'  => esc_html__( 'When font icon was generated by fontello, you are given some files with the fonts. Upload the necessary format.', 'gowatch' ),
					'field' => 'upload',
					'id'    => 'extra[ttf]',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Upload file ".woff"', 'gowatch' ),
					'desc'  => esc_html__( 'When font icon was generated by fontello, you are given some files with the fonts. Upload the necessary format.', 'gowatch' ),
					'field' => 'upload',
					'id'    => 'extra[woff]',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Enter font-family ( from file stylesheet.css )', 'gowatch' ),
					'desc'  => esc_html__( 'Please, only write the name of the font family that is written in the stylesheet.css file, do not copy anything else.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'extra[custom_family]',
					'std'   => ''
				),
			),

			'single' => array(

				array(
					'name'    => esc_html__( 'Enable featured posts inside post content', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, it will add a box with 3 latest featured articles after the third paragraph of your content. If the post does not have 3 paragraphs, it will not adding anything.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'featured_box',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Autoload next post', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, when user scrolls down to article\'s end, next article will be autoloaded.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'autoload_next',
					'std'     => 'n',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'field' => 'option_block',
					'id'   	=> 'single-related-posts-block',
					'title' => esc_html__( 'Related posts', 'gowatch' ),
					'subtitle' => esc_html__( 'These are the default settings for the posts on your website.', 'gowatch' ),
					'std'   => ''
				),

				array(
					'name'         => esc_html__( 'Enable related posts', 'gowatch' ),
					'desc'         => esc_html__( 'If enabled, it will add a section of posts that are related to the that is opened. Other options will appear if you enable them.', 'gowatch' ),
					'field'        => 'select',
					'options'      => $enable,
					'id'           => 'related',
					'std'          => 'n',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'  => esc_html__( 'Number of posts to show', 'gowatch' ),
					'field' => 'select',
					'id'    => 'number_of_related_posts',
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4,
						6 => 6,
						9 => 9
					),
					'std'   => 3,
					'class' => 'airkit_related-y'
				),

				array(
					'name'  => esc_html__( 'Posts view style', 'gowatch' ),
					'field' => 'select',
					'id'    => 'related_posts_type',
					'options' => array(
						'grid'           => esc_html__( 'Grid', 'gowatch' ),
						'thumbnail'      => esc_html__( 'Thumbnails', 'gowatch' ),
						'small-articles' => esc_html__( 'Small articles', 'gowatch' ),
						'big'            => esc_html__( 'Big posts', 'gowatch' ),
					),
					'std'   => 'grid',
					'class' => 'airkit_related-y',
					'class_select' => 'airkit_trigger-options',
				),

				array(
					'name'  => esc_html__( 'Number of columns for related posts', 'gowatch' ),
					'field' => 'select',
					'id'    => 'related_posts_nr_of_columns',
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4
					),
					'std'   => 3,
					'class' => 'airkit_related_posts_type-big airkit_revert-trigger'
				),

				array(
					'name'         	=> esc_html__( 'Posts behavior', 'gowatch' ),
					'desc'         	=> esc_html__( 'Select how you want to show the related posts on single post (Normal or Carousel).', 'gowatch' ),
					'field'        	=> 'select',
					'options'      	=> array(
						'normal'	=> esc_html__('Normal', 'gowatch'),
						'carousel'	=> esc_html__('Carousel', 'gowatch'),
					),
					'id'           	=> 'related_posts_behavior',
					'std'          	=> 'normal',
					'class' 		=> 'airkit_related-y'
				),

                array(
                    'name'    => esc_html__( 'Choose split layout', 'gowatch' ),
                    'desc'    => esc_html__( 'You can select the split size for your big posts layout. You can have the image smaller with more attention to the title and excerpt or go the other way and have a bigger space for images.', 'gowatch' ),
                    'field'   => 'img_selector',
                    'options' => array(
                        '1-3' => '1/3',
                        '1-2' => '1/2',
                        '3-4' => '3/4'
                    ),
                    'img' => array(
                        '1-3' => 'big_posts_13.png',
                        '1-2' => 'big_posts_12.png',
                        '3-4' => 'big_posts_34.png'
                    ),
                    'id'      => 'airkit_related_content_split',
                    'std'     => 'normal',
                    'class'   => 'airkit_related_posts_type-big',
                ),

                array(
                    'name'    => esc_html__( 'Choose image position', 'gowatch' ),
                    'desc'    => esc_html__( 'You can select the positioning of the image for this element. You can align the image on left and content on the right or the other way. The mosaic option will show one post with image left and the next one with image right', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'left'   => esc_html__( 'Image left, content right', 'gowatch' ),
                        'right'  => esc_html__( 'Image right, content left', 'gowatch' ),
                        'mosaic' => esc_html__( 'Mosaic - alternate other options', 'gowatch' )
                    ),
                    'id'      => 'airkit_related_image_position',
                    'std'     => 'left',
                    'class'   => 'airkit_related-y airkit_related_posts_type-big',
                ),		

                array(
                    'name'    => esc_html__( 'Title position', 'gowatch' ),
                    'desc'    => esc_html__( 'Select your title position for related posts. Title can be displayed above the image, over the image, or above the excerpt. Note that sometimes title may change the position of the meta: date, categories, author as well.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'over-image'  => esc_html__( 'Over image', 'gowatch' ),
                        'below-image' => esc_html__( 'Below image', 'gowatch' )
                    ),
                    'id'       => 'thumbnail-title-position',
                    'std'      => 'below-image',
                    'class'    => 'airkit_related-y airkit_related_posts_type-thumbnail'
                ),

				array(
					'name'  => esc_html__( 'Related posts query criteria', 'gowatch' ),
					'field' => 'select',
					'id'    => 'related_posts_selection_criteria',
					'options' => array(
						'by_tags'   => esc_html__( 'By tags', 'gowatch' ),
						'by_categs' => esc_html__( 'By categories', 'gowatch' )
					),
					'std'   => 'by_tags',
					'class' => 'airkit_related-y'
				),

				array(
					'field' => 'option_block',
					'id'   	=> 'single-featured-posts-block',
					'title' => esc_html__( 'Featured posts', 'gowatch' ),
					'subtitle' => esc_html__( 'These are the default settings for the posts on your website.', 'gowatch' ),
					'std'   => ''
				),

				array(
					'name'         => esc_html__( 'Enable featured posts', 'gowatch' ),
					'desc'         => esc_html__( 'If enabled, it will add a section of posts that are featured.', 'gowatch' ),
					'field'        => 'select',
					'options'      => $enable,
					'id'           => 'featured',
					'std'          => 'n',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'  => esc_html__( 'Number of posts to show', 'gowatch' ),
					'field' => 'select',
					'id'    => 'number_of_featured_posts',
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4,
						6 => 6,
						9 => 9,
					),
					'std'   => 3,
					'class' => 'airkit_featured-y'
				),

				array(
					'name'  => esc_html__( 'Posts view style', 'gowatch' ),
					'field' => 'select',
					'id'    => 'featured_posts_type',
					'options' => array(
						'grid'           => esc_html__( 'Grid', 'gowatch' ),
						'thumbnail'      => esc_html__( 'Thumbnails', 'gowatch' ),
						'small-articles' => esc_html__( 'Small articles', 'gowatch' ),
					),
					'std'   => 'grid',
					'class' => 'airkit_featured-y',
					'class_select' => 'airkit_trigger-options',
				),

				array(
					'name'  => esc_html__( 'Number of columns', 'gowatch' ),
					'field' => 'select',
					'id'    => 'featured_posts_nr_of_columns',
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4
					),
					'std' 	=> 3,
					'class' => 'airkit_featured-y'
				),

				array(
					'name'         	=> esc_html__( 'Posts behavior', 'gowatch' ),
					'desc'         	=> esc_html__( 'Select how you want to show the featured posts on single post (Normal or Carousel).', 'gowatch' ),
					'field'        	=> 'select',
					'options'      	=> array(
						'normal'	=> esc_html__('Normal', 'gowatch'),
						'carousel'	=> esc_html__('Carousel', 'gowatch'),
					),
					'id'           	=> 'featured_posts_behavior',
					'std'          	=> 'normal',
					'class' 		=> 'airkit_featured-y'
				),	

                array(
                    'name'    => esc_html__( 'Title position', 'gowatch' ),
                    'desc'    => esc_html__( 'Select title position for featured posts. Title can be displayed above the image, over the image, or above the excerpt. Note that sometimes title may change the position of the meta: date, categories, author as well.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'over-image'  => esc_html__( 'Over image', 'gowatch' ),
                        'below-image' => esc_html__( 'Below image', 'gowatch' )
                    ),
                    'id'       => 'featured_thumbnail-title-position',
                    'std'      => 'below-image',
                    'class'    => 'airkit_featured-y airkit_featured_posts_type-thumbnail'
                ),

				array(
					'field' => 'option_block',
					'id'   	=> 'single-same-category-posts-block',
					'title' => esc_html__( 'Posts from same category', 'gowatch' ),
					'subtitle' => esc_html__( 'These are the default settings for the posts on your website.', 'gowatch' ),
					'std'   => ''
				),

				array(
					'name'         => esc_html__( 'Enable posts from same category', 'gowatch' ),
					'desc'         => esc_html__( 'If enabled, it will add a section of posts that are from selected primary category. If you don\'t have selected primary category then will extract all posts from first category in terms list.', 'gowatch' ),
					'field'        => 'select',
					'options'      => $enable,
					'id'           => 'same_category',
					'std'          => 'n',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'  => esc_html__( 'Number of posts to show', 'gowatch' ),
					'field' => 'select',
					'id'    => 'number_of_same_category_posts',
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4,
						6 => 6,
						9 => 9
					),
					'std'   => 3,
					'class' => 'airkit_same_category-y'
				),

				array(
					'name'  => esc_html__( 'Posts view style', 'gowatch' ),
					'field' => 'select',
					'id'    => 'same_category_posts_type',
					'options' => array(
						'grid'           => esc_html__( 'Grid', 'gowatch' ),
						'thumbnail'      => esc_html__( 'Thumbnails', 'gowatch' ),
						'small-articles' => esc_html__( 'Small articles', 'gowatch' ),
						'big'            => esc_html__( 'Big posts', 'gowatch' ),
					),
					'std'   => 'grid',
					'class' => 'airkit_same_category-y',
					'class_select' => 'airkit_trigger-options',
				),

				array(
					'name'  => esc_html__( 'Number of columns', 'gowatch' ),
					'field' => 'select',
					'id'    => 'same_category_posts_nr_of_columns',
					'options' => array(
						2 => 2,
						3 => 3,
						4 => 4
					),
					'std'   => 3,
					'class' => 'airkit_same_category_posts_type-big airkit_revert-trigger'
				),

				array(
					'name'         	=> esc_html__( 'Posts behavior', 'gowatch' ),
					'desc'         	=> esc_html__( 'Select how you want to show the posts on single post (Normal or Carousel).', 'gowatch' ),
					'field'        	=> 'select',
					'options'      	=> array(
						'normal'	=> esc_html__('Normal', 'gowatch'),
						'carousel'	=> esc_html__('Carousel', 'gowatch'),
					),
					'id'           	=> 'same_category_posts_behavior',
					'std'          	=> 'normal',
					'class' 		=> 'airkit_same_category-y'
				),

                array(
                    'name'    => esc_html__( 'Choose split layout', 'gowatch' ),
                    'desc'    => esc_html__( 'You can select the split size for your big posts layout. You can have the image smaller with more attention to the title and excerpt or go the other way and have a bigger space for images.', 'gowatch' ),
                    'field'   => 'img_selector',
                    'options' => array(
                        '1-3' => '1/3',
                        '1-2' => '1/2',
                        '3-4' => '3/4'
                    ),
                    'img' => array(
                        '1-3' => 'big_posts_13.png',
                        '1-2' => 'big_posts_12.png',
                        '3-4' => 'big_posts_34.png'
                    ),
                    'id'      => 'airkit_same_category_content_split',
                    'std'     => 'normal',
                    'class'   => 'airkit_same_category_posts_type-big',
                ),

                array(
                    'name'    => esc_html__( 'Choose image position', 'gowatch' ),
                    'desc'    => esc_html__( 'You can select the positioning of the image for this element. You can align the image on left and content on the right or the other way. The mosaic option will show one post with image left and the next one with image right', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'left'   => esc_html__( 'Image left, content right', 'gowatch' ),
                        'right'  => esc_html__( 'Image right, content left', 'gowatch' ),
                        'mosaic' => esc_html__( 'Mosaic - alternate other options', 'gowatch' )
                    ),
                    'id'      => 'airkit_same_category_image_position',
                    'std'     => 'left',
                    'class'   => 'airkit_same_category_posts_type-big',
                ),		

                array(
                    'name'    => esc_html__( 'Title position', 'gowatch' ),
                    'desc'    => esc_html__( 'Select your title position for related posts. Title can be displayed above the image, over the image, or above the excerpt. Note that sometimes title may change the position of the meta: date, categories, author as well.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'over-image'  => esc_html__( 'Over image', 'gowatch' ),
                        'below-image' => esc_html__( 'Below image', 'gowatch' )
                    ),
                    'id'       => 'same_category_thumbnail-title-position',
                    'std'      => 'below-image',
                    'class'    => 'airkit_same_category-y airkit_same_category_posts_type-thumbnail'
                ),

				array(
					'field' => 'option_block',
					'id'   	=> 'single-deatils-block',
					'title' => esc_html__( 'Single boxes and pagination', 'gowatch' ),
					'subtitle' => esc_html__( 'These are the default settings for the posts on your website.', 'gowatch' ),
					'std'   => ''
				),
				
				array(
					'name'    => esc_html__( 'Display pagination in single post', 'gowatch' ),
					'desc'    => esc_html__( 'Show or hide pagination in single posts.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'pagination',
					'std'     => 'y',
					'class_select' => 'airkit_trigger-options'
				),

				array(
					'name'    => esc_html__( 'Display author box', 'gowatch' ),
					'desc'    => esc_html__( 'You can globally hide author box on your single posts.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'author-box',
					'std'     => 'y'
				),

				array(
					'name'    => esc_html__( 'Display breadcrumbs', 'gowatch' ),
					'desc'    => esc_html__( 'Activate or disable breadcrumbs on your website.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'breadcrumbs',
					'std'     => 'y'
				),

				array(
					'name'    => esc_html__( 'Sticky sidebar', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'sticky_sidebar',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Show progress bar', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'article_progress',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Display comments as toggle', 'gowatch' ),
					'desc'    => esc_html__( 'If set to yes, comments on posts will be displayed as a toggle and visible only if user clicks on corresponding button, otherwise they will be always visible.', 'gowatch'  ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'comments_toggle',
					'std'     => 'n'
				),

				array(
					'name'  => esc_html__( 'Limit content width', 'gowatch' ),
					'desc'  => esc_html__( 'This option allows you to limit content width on no-sidebar single pages .', 'gowatch' ),
					'field' => 'select',
					'id'    => 'content_width',
					'options' => array(
						'site-width'     => esc_html__( 'Site width', 'gowatch' ),
						'content-w-680'  => esc_html__( '680px', 'gowatch' ),
						'content-w-800'  => esc_html__( '800px', 'gowatch' ),
						'content-w-1000' => esc_html__( '1000px', 'gowatch' ),
					),
					'std'   => 'site-width',
				),

				array(
					'field' => 'option_block',
					'id'   	=> 'meta-single-block',
					'title' => esc_html__( 'Meta option', 'gowatch' ),
					'subtitle' => esc_html__( 'These are the default meta settings for the posts on your website.', 'gowatch' ),
					'std'   => ''
				),

				array(
					'name'    => esc_html__( 'Show title on single page', 'gowatch' ),
					'desc'    => esc_html__( 'If set to yes, this option will show the title of the posts.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'title',
					'std'     => 'y'
				),

				array(
					'name'    => esc_html__( 'Show featured image in post', 'gowatch' ),
					'desc'    => esc_html__( 'Use this to hide or show the featured image in posts.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'img',
					'std'     => 'y'
				),


				array(
					'name'    => esc_html__( 'Display post tags', 'gowatch' ),
					'desc'    => esc_html__( 'Show or hide tags in single posts.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'post-tags',
					'std'     => 'y'
				),

				array(
					'name'    => esc_html__( 'Show social sharing.', 'gowatch' ),
					'desc'    => esc_html__( 'If set to yes, this option will show the social sharing buttons.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'sharing',
					'std'     => 'n',
					'class_select' => 'airkit_trigger-options',
				),

				array(
					'name'    => esc_html__( 'Dropcap', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled, this option will make first character big.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'n' => esc_html__( 'Disabled', 'gowatch' ),
						'subtitle' => esc_html__( 'Enable for subtitle', 'gowatch' ),
						'content'  => esc_html__( 'Enable for content', 'gowatch' ),
					),
					'id'      => 'dropcap',
					'std'     => 'y',
					'class_select' => 'airkit_trigger-options',
				),


				/*
				 * Separate Video settings
				 */

				array(
					'field' => 'option_block',
					'id'   	=> 'page-options-block',
					'title' => 'Video boxes and meta options',
					'subtitle' => 'These are the default settings for the pages on your website.',
					'std'   => ''
				),

				array(
					'name'    => esc_html__( 'Video meta details', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will show meta data of the page, including the author, date, likes, etc.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'video_meta',
					'std'     => 'y',
				),

				array(
					'name'    => esc_html__( 'Video description size limit', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will limit the amount of description shown below the description and add a show more button.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'video_content_limit',
					'std'     => 'y',
				),
				array(
					'name'    => esc_html__( 'Enable sticky video on scroll', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will make the video stick at the top left corner of the page when you scroll below it.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'video_sticky',
					'std'     => 'y',
				),

				array(
					'name'    => esc_html__( 'Select default single video style', 'gowatch' ),
					'desc'    => esc_html__( 'If left to default, the video posts will look like the option you have set here.', 'gowatch' ),
					'field'   => 'select',
					'options' => array(
						'style1' => 'Single style 1',
						'style2' => 'Single style 2',
					),
					'id'      => 'single_style',
					'std'     => 'style1'
				),


				array(
					'name'    => esc_html__( 'Enable automatic video thumbnail grabber for video embedded from oEmbed websites', 'gowatch' ),
					'desc'    => esc_html__( 'Works with YouTube, vimeo and Dailymotion providers.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'auto_thumbnails',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Get first video from content instead of embeds', 'gowatch' ),
					'desc'    => esc_html__( 'If activated, it will search through the video post content and show the first embed video in the text editor area. Note that video player ads will not work for this case.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'video_from_content',
					'std'     => 'n'
				),

				array(
					'name'    => esc_html__( 'Custom video URL meta key for your videos', 'gowatch' ),
					'desc'    => esc_html__( 'Used for video import plugins, if you want to use an additional meta key to read video embeds (URLs) from.', 'gowatch' ),
					'field'   => 'input',
					'type'    => 'text',
					'id'      => 'video_custom_key',
					'std'     => ''
				),

				array(
					'name'    => esc_html__( 'Show video post content to logged in users only', 'gowatch' ),
					'desc'    => esc_html__( 'If activated, show a login form instead of the content of the video post.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'video_subscribers_only',
					'std'     => 'y'
				),



				/*
				 * Separate page settings
				 */

				array(
					'field' => 'option_block',
					'id'   	=> 'page-options-block',
					'title' => 'Page boxes and meta options',
					'subtitle' => 'These are the default settings for the pages on your website.',
					'std'   => ''
				),


				array(
					'name'    => esc_html__( 'Page meta details', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will show meta data of the page, including the author, date, likes, etc.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'page_meta',
					'std'     => 'y',
				),

				array(
					'name'    => esc_html__( 'Page breadcrumbs', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will add breadcrumbs on top of the pages that you don\'t use the layout builder on.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'page_breadcrumbs',
					'std'     => 'n',
				),

				array(
					'name'    => esc_html__( 'Page author box', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will show the author box below content on the pages that you don\'t use the layout builder on.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'page_authorbox',
					'std'     => 'n',
				),

				array(
					'name'    => esc_html__( 'Page sharing options', 'gowatch' ),
					'desc'    => esc_html__( 'If enabled it will show the social sharing buttons on your pages.', 'gowatch' ),
					'field'   => 'select',
					'options' => $enable,
					'id'      => 'page_sharing',
					'std'     => 'n',
				),


			),

			'social' => array(

				array(
					'name'  => esc_html__( 'Email', 'gowatch' ),
					'desc'  => esc_html__( 'This email is used to receive emails from contact form.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'email',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Skype', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Skype here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'skype',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Github', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your github page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'github',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Google+', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Google+ page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'gplus',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Dribbble', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Dribbble page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'dribbble',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'last.fm', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your last.fm page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'lastfm',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Tumblr', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Tumblr page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'tumblr',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Twitter', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Twitter page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'twitter',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Vimeo', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Vimeo page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'vimeo',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'WordPress', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your WordPress page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'wordpress',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Yahoo', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Yahoo page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'yahoo',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Youtube', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Youtube page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'youtube',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Facebook', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Facebook page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'facebook',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Flickr', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Flickr page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'flickr',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Pinterest', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Pinterest page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'pinterest',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Instagram', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Instagram page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'instagram',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Snapchat', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Snapchat page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'snapchat',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Reddit', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Reddit page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'reddit',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Vkontakte', 'gowatch' ),
					'desc'  => esc_html__( 'Insert your Vkontakte page here.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'vk',
					'std'   => ''
				),

				/*
				 * Sortable meta fields for views.
				 */
				array(
					'field' => 'option_block',
					'id'   	=> 'sharing-single-block',
					'title' => esc_html__( 'Social sharing buttons', 'gowatch' ),
					'subtitle' => esc_html__( 'In this section you can change order of social sharing buttons. You can also choose to hide or show social sharing buttons.', 'gowatch' ),
					'std'   => ''
				),

                array(
                    'name'     => esc_html__( 'Sharing buttons', 'gowatch' ),
                    'field'    => 'simple_tmpl',
                    'id'       => 'social_sharing_items',
                    'sortable' => 'true',
                    'std'      => array( 
                    					'sharing_facebook'  => array( 'show' => 'y'),
                    					'sharing_twitter'   => array( 'show' => 'y' ),
                    					'sharing_linkedin'  => array( 'show' => 'n' ),
                    					'sharing_tumblr'    => array( 'show' => 'n' ),
                    					'sharing_pinterest' => array( 'show' => 'y' )
                    				),
                    'options'  => array(

						'sharing_facebook' => array(
							'title' => esc_html__( 'Facebook', 'gowatch' ),
							'items' => array(
								array(
									'name'    => esc_html__( 'Show', 'gowatch' ),
									'field'   => 'select',
									'options' => $enable,
									'id'      => 'social_sharing_items[sharing_facebook][show]',
									'std'     => 'y',
								)
							)
						),

						'sharing_twitter' => array(
							'title' => esc_html__( 'Twitter', 'gowatch' ),
							'items' => array(
								array(
									'name'    => esc_html__( 'Show', 'gowatch' ),
									'field'   => 'select',
									'options' => $enable,
									'id'      => 'social_sharing_items[sharing_twitter][show]',
									'std'     => 'y',
								)
							)
						),					

						'sharing_linkedin' => array(
							'title' => esc_html__( 'LinkedIn', 'gowatch' ),
							'items' => array(
								array(
									'name'    => esc_html__( 'Show', 'gowatch' ),
									'field'   => 'select',
									'options' => $enable,
									'id'      => 'social_sharing_items[sharing_linkedin][show]',
									'std'     => 'y',
								)
							)
						),

						'sharing_tumblr' => array(
							'title' => esc_html__( 'Tumblr', 'gowatch' ),
							'items' => array(
								array(
									'name'    => esc_html__( 'Show', 'gowatch' ),
									'field'   => 'select',
									'options' => $enable,
									'id'      => 'social_sharing_items[sharing_tumblr][show]',
									'std'     => 'y',
								)
							)
						),	

						'sharing_pinterest' => array(
							'title' => esc_html__( 'Pinterest', 'gowatch' ),
							'items' => array(
								array(
									'name'    => esc_html__( 'Show', 'gowatch' ),
									'field'   => 'select',
									'options' => $enable,
									'id'      => 'social_sharing_items[sharing_pinterest][show]',
									'std'     => 'y',
								)
							)
						),

						'sharing_mail' => array(
							'title' => esc_html__( 'Email', 'gowatch' ),
							'items' => array(
								array(
									'name'    => esc_html__( 'Show', 'gowatch' ),
									'field'   => 'select',
									'options' => $enable,
									'id'      => 'social_sharing_items[sharing_mail][show]',
									'std'     => 'y',
								)
							)
						),													
                    ),
                ),		
			),

			'sidebar' => array(
				array(
					'field' => array( __CLASS__, 'sidebars' ),
					'id'    => 'sidebar'
				)
			),

			'import' => array(

				array(
					'field' => array( __CLASS__, 'import' ),
					'id'    => 'import'
				),

				array(
					'field' => array( __CLASS__, 'import_demo' ),
					'id'    => 'import_demo'
				)
			),

			'advertising' => array(

				array(
					'name'  => esc_html__( 'Area 1', 'gowatch' ),
					'desc'  => sprintf( esc_html__( 'This advertising will be shown %sat top%s on the single post page.', 'gowatch' ), '<b>', '</b>' ),
					'field' => 'textarea',
					'id'    => 'ad_area_1',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Area 2', 'gowatch' ),
					'desc'  => sprintf( esc_html__( 'This advertising will be shown %sabove the author box or below the content%s on the single post page.', 'gowatch' ), '<b>', '</b>' ),
					'field' => 'textarea',
					'id'    => 'ad_area_2',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Next loaded post', 'gowatch' ),
					'desc'  => sprintf( esc_html__( 'This advertising will be shown %sabove the next loaded post%s on the single page. You need to have enabled option for Autoload next post.', 'gowatch' ), '<b>', '</b>' ),
					'field' => 'textarea',
					'id'    => 'ad_area_next_loaded',
					'std'   => ''
				),

				array(
					'name'  => esc_html__( 'Area for grids', 'gowatch' ),
					'desc'  => esc_html__( 'This advertising will be shown in grid-type post listings, if you enable Show Advertising option from element settings.', 'gowatch' ),
					'field' => 'textarea',
					'id'    => 'ad_area_grid',
					'std'   => ''
				),	

				array(
					'name'  => esc_html__( 'Area for lists', 'gowatch' ),
					'desc'  => esc_html__( 'This advertising will be shown in list-type post listings, if you enable Show Advertising option from element settings.', 'gowatch' ),
					'field' => 'textarea',
					'id'    => 'ad_area_list',
					'std'   => ''
				),

			),

			'header_settings' => array(

				array(
					'name'  => esc_html__( 'Predefined style', 'gowatch' ),
					'desc'  => sprintf( esc_html__( 'The predefined style for the header', 'gowatch' ), '<b>', '</b>' ),
					'field' => 'select',
					'id'    => 'predefined-style',
					'std'   => 'style4'
				),
				
			),
			'footer_settings' => array(

				array(
					'name'  => esc_html__( 'Predefined style', 'gowatch' ),
					'desc'  => sprintf( esc_html__( 'The predefined style for the footer', 'gowatch' ), '<b>', '</b>' ),
					'field' => 'select',
					'id'    => 'predefined-style',
					'std'   => 'style4'
				),

			),

			'update' => array(

				array(
					'field' => array( __CLASS__, 'update' ),
					'id'    => 'update'
				),

				array(
					'name'  => esc_html__( 'Your Envato Market Token', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'envato_token',
					'std'   => '',
				)
			),

			'support' => array(

				array(
					'field' => array( __CLASS__, 'support' ),
					'id'    => 'support'
				)
			),

			'frontend' => array(
				array(
					'id'    => 'frontend_settings_page',
					'field' => array( __CLASS__, 'frontend_settings_page' ),
					'call'  => array( 'TSZF_Admin_Settings', 'plugin_page' ),
				),
			),

			'system_status' => array(
				array(
					'id'    => 'system_status_page',
					'field' => array( __CLASS__, 'system_status' ),
				),
			)

		);

		// Define all tabs for global options.
		$tabs = array(
			'general' => array(
				'title' => esc_html__( 'General', 'gowatch' ),
				'desc'  => esc_html__( 'Below are the general options that this theme offers. You can enable/disable options and sections of your website.', 'gowatch' ),
				'class' => 'settings',
			),
			'styles' => array(
				'title' => esc_html__( 'Styles', 'gowatch' ),
				'desc'  => esc_html__( 'Settings for your website styling. Here you can change colors, effects, logo type, custom favicon, background.', 'gowatch' ),
				'class' => 'code',
			),
			'colors' => array(
				'title' => esc_html__( 'Colors', 'gowatch' ),
				'desc'  => esc_html__( 'Settings for your website color settings. Here you can change colors that are shown on your website.', 'gowatch' ),
				'class' => 'palette',
			),
			'sizes' => array(
				'title' => esc_html__( 'Image sizes', 'gowatch' ),
				'desc'  => esc_html__( 'In this tab you can choose the dimensions for the images that are used on your website. Caution - these are not the sizes that will be shown on the website as the website is adaptive, but it is the size of the images that will be used. We strongly recommend to use given settings and not to fiddle with any as long as you are not sure what you are doing. You will also need to use a plugin like Regenerate Thumbnails to apply new image sizes to all images once you change default settings.', 'gowatch' ),
				'class' => 'image-size',
			),
			'layout' => array(
				'title' => esc_html__( 'Archive pages', 'gowatch' ),
				'desc'  => esc_html__( 'This is the default layouts settings area. Here you can set the defaults for your website. Default sidebar settings and the way articles are going to be shown on archive pages.', 'gowatch' ),
				'class' => 'layout',
			),
			'typography' => array(
				'title' => esc_html__( 'Typography', 'gowatch' ),
				'desc'  => esc_html__( 'Use settings below to change typography for your website.', 'gowatch' ),
				'class' => 'edit',
			),
			'single' => array(
				'title' => esc_html__( 'Single post', 'gowatch' ),
				'desc'  => esc_html__( 'Single posts settings options. In this section you can enable/disable related posts, social sharing, tags.', 'gowatch' ),
				'class' => 'post',
			),
			'social' => array(
				'title' => esc_html__( 'Social', 'gowatch' ),
				'desc'  => esc_html__( 'Insert your link to the social pages below. These are used for social icons. The email set here is going to be used for contact forms.', 'gowatch' ),
				'class' => 'social'
			),
			'sidebar' => array(
				'title' => esc_html__( 'Sidebars', 'gowatch' ),
				'desc'  => esc_html__( 'Manage your theme sidebars from here', 'gowatch' ),
				'class' => 'columns'
			),
			'import' => array(
				'title' => esc_html__( 'Import options', 'gowatch' ),
				'desc'  => '',
				'class' => 'import'
			),
			'advertising' => array(
				'title' => esc_html__( 'Advertising', 'gowatch' ),
				'desc'  => '',
				'class' => 'dollar',
			),
			'update' => array(
				'title' => esc_html__( 'Theme update', 'gowatch' ),
				'desc'  => '',
				'class' => 'update',
			),
			'support' => array(
				'title' => esc_html__( 'Support', 'gowatch' ),
				'desc'  => '',
				'class' => 'support',
			),
			'frontend' => array(
				'title' => esc_html__( 'User Frontend', 'gowatch' ),
				'desc'  => esc_html__( 'WARNING ! This section is desired for advanced users only. In this section you can edit global options for Frontend Submissions. You can also access frontend submission and registration forms.', 'gowatch' ),
				'class' => 'upload',
			),
			'header_settings' => array(
				'title' => esc_html__( 'Header settings', 'gowatch' ),
				'desc'  => esc_html__( 'Change the layout and settings of the header.', 'gowatch' ),
				'class' => 'layout',
			),	
			'footer_settings' => array(
				'title' => esc_html__( 'Footer settings', 'gowatch' ),
				'desc'  => esc_html__( 'Change the layout and settings of the footer.', 'gowatch' ),
				'class' => 'layout',
			),		
			'system_status' => array(
				'title' => esc_html__( 'System Status', 'gowatch' ),
				'desc'  => esc_html__( 'Check the system requirements for the theme to run smoothly.', 'gowatch' ),
				'class' => 'help',
			),	
		);

		// Add options depend on plugin custom posts touchsize.
		if ( class_exists( 'Ts_Custom_Post' ) ) {

			$plugin_options = array(

				array(
					'name'  => esc_html__( 'Change custom post video slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for video custom post.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_video',
					'std'   => 'video'
				),

				array(
					'name'  => esc_html__( 'Change archive video slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for video texonomy.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_video_taxonomy',
					'std'   => 'video-category'
				),

				array(
					'name'  => esc_html__( 'Change custom post portfolio slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for portfolio custom post.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_portfolio',
					'std'   => 'portfolio'
				),

				array(
					'name'  => esc_html__( 'Change archive portfolio slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for portfolio taxonomy.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_portfolio_taxonomy',
					'std'   => 'portfolio-category'
				),

				array(
					'name'  => esc_html__( 'Change custom post event slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for event custom post.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_event',
					'std'   => 'event'
				),

				array(
					'name'  => esc_html__( 'Change archive event slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for event taxonomy.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_event_taxonomy',
					'std'   => 'event-category'
				),

				array(
					'name'  => esc_html__( 'Change custom post gallery slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for gallery custom post.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_gallery',
					'std'   => 'gallery'
				),

				array(
					'name'  => esc_html__( 'Change archive gallery slug', 'gowatch' ),
					'desc'  => esc_html__( 'Slug for gallery taxonomy.', 'gowatch' ),
					'field' => 'input',
					'type'  => 'text',
					'id'    => 'slug_gallery_taxonomy',
					'std'   => 'gallery-category'
				),
			);

			$fields['general'] = array_merge( $fields['general'], $plugin_options );
		}

		if ( $extract == 'tabs' ) {

			// This filter overwrite returned values from plugin custom posts && shortcodes.
			return apply_filters( 'ts_get_options', $tabs, $extract, $tab );

		} else {

			// If isset this key in array of fields when we extract it else it maybe declared in plugin custom posts && shortcodes.
			$fields = $tab == 'all' ? $fields : ( isset( $fields[ $tab ] ) ? $fields[ $tab ] : array() );

			// This filter overwrite returned values from plugin custom posts && shortcodes.
			return apply_filters( 'ts_get_options', $fields, $extract, $tab );

		}
	}

	static function layout( $sidebars )
	{
		$enable = array(
			'y' => esc_html__( 'Yes', 'gowatch' ),
			'n' => esc_html__( 'No', 'gowatch' )
		);

		$pages = array(
			'single'   => esc_html__( 'Single', 'gowatch' ),
			'page'     => esc_html__( 'Page', 'gowatch' ),
			'blog'     => esc_html__( 'Blog page', 'gowatch' ),
			'product'  => esc_html__( 'Product single', 'gowatch' ),
			'shop'     => esc_html__( 'Shop page', 'gowatch' ),
			'category' => esc_html__( 'Category', 'gowatch' ),
			'author'   => esc_html__( 'Author', 'gowatch' ),
			'search'   => esc_html__( 'Search', 'gowatch' ),
			'archive'  => esc_html__( 'Archive', 'gowatch' ),
			'tags'     => esc_html__( 'Tags', 'gowatch' ),
		);

		$out = array();

		$out[] = array(
			'name' 		=> esc_html__('Page header style', 'gowatch'),
			'field' 	=> 'select',
			'id'		=> 'pht_style',
			'options'	=> array(
				'default'	=> esc_html__('Default','gowatch'),
				'bg'	=> esc_html__('With background image','gowatch'),
			),
			'std'		=> 'default',
			'class_select' => 'airkit_trigger-options',
		);

		$out[] = array(
			'name' 		=> esc_html__('Page header background image', 'gowatch'),
			'field' 	=> 'upload',
			'id'		=> 'pht_bg',
			'std'		=> '',
			'class'     => 'airkit_pht_style-bg',
		);
		$out[] = array(
			'name' 		=> esc_html__('Enable sticky sidebars', 'gowatch'),
			'desc' 		=> esc_html__('If enabled, it will activate the sticky sidebar option for archive pages that have a sidebar enabled. Your sidebars will remain sticky within the containers.', 'gowatch'),
			'field' 	=> 'select',
			'options'	=> array(
								'y' => 'Yes',
								'n' => 'No',
							),
			'id'		=> 'sticky_sidebar',
			'std'		=> 'n',
			'class'     => '',
		);

		foreach ( $pages as $id => $title ) {

			$out[ $id ] = array(
				'name'    => $title,
				'field'   => 'block_fields',
				'id'      => '',
				'fields'  => array(

					array(
						'name'    => esc_html__( 'Choose position sidebar', 'gowatch' ),
						'field'   => 'select',
						'options' => array(
							'none'  => esc_html__( 'None', 'gowatch' ),
							'left'  => esc_html__( 'Left', 'gowatch' ),
							'right' => esc_html__( 'Right', 'gowatch' ),
						),
						'id'           => $id . '[position]',
						'std'          => 'right',
						'class_select' => 'ts-sidebar-display',
					),

					array(
						'name'    => esc_html__( 'Size', 'gowatch' ),
						'field'   => 'select',
						'options' => array(
							'1-3'  => '1/3',
							'1-4'  => '1/4'
						),
						'id'    => $id . '[size]',
						'std'   => '1-3',
						'class' => 'ts-sidebar-option',
					),

					array(
						'name'    => esc_html__( 'Choose sidebar', 'gowatch' ),
						'field'   => 'select',
						'options' => $sidebars,
						'id'      => $id . '[id]',
						'std'     => 'main',
						'class'   => 'ts-sidebar-option',
					)
				)
			);
		}

		$pages = array(
			'blog',
			'category',
			'author',
			'search',
			'archive',
			'tags'
		);

		foreach ( $pages as $id ) {

			$out[ $id ]['fields'] = array_merge( $out[ $id ]['fields'], array(

					array(
						'name'    => esc_html__( 'How to display', 'gowatch' ),
						'field'   => 'select',
						'options' => array(
							'grid'       => esc_html__( 'Grid', 'gowatch' ),
							'list_view'  => esc_html__( 'List', 'gowatch' ),
							'thumbnail'  => esc_html__( 'Thumbnail', 'gowatch' ),
							'big'        => esc_html__( 'Big', 'gowatch' ),
							'super'      => esc_html__( 'Super', 'gowatch' )
						),
						'id'           => $id . '[element-type]',
						'std'          => 'big',
						'class_select' => 'airkit_trigger-options',
					),

					array(
						'name'    => esc_html__( 'Show featured image', 'gowatch' ),
						'field'   => 'select',
						'options' => $enable,
						'id'      => $id . '[featimg]',
						'std'     => 'y',
						'class'   => 'airkit_' . $id . '-element-type-grid'
					),

					array(
						'name'    => esc_html__( 'Show excerpt', 'gowatch' ),
						'field'   => 'select',
						'options' => $enable,
						'id'      => $id . '[excerpt]',
						'std'     => 'y',
						'class'   => 'airkit_' . $id . '-element-type-grid airkit_' . $id . '-element-type-list_view airkit_' . $id . '-element-type-big'
					),

					array(
						'name'    => esc_html__( 'Show meta', 'gowatch' ),
						'field'   => 'select',
						'options' => $enable,
						'id'      => $id . '[meta]',
						'std'     => 'y',
						'class'   => 'airkit_' . $id . '-element-type-grid airkit_' . $id . '-element-type-list_view airkit_' . $id . '-element-type-thumbnail airkit_' . $id . '-element-type-big airkit_' . $id . '-element-type-super'
					),

					array(
						'name'    => esc_html__( 'Elements per row', 'gowatch' ),
						'field'   => 'select',
						'options' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							6 => 6,
						),
						'id'    => $id . '[per-row]',
						'std'   => 3,
						'class' => 'airkit_' . $id . '-element-type-grid airkit_' . $id . '-element-type-thumbnail airkit_' . $id . '-element-type-super'
					),

					array(
						'name'    => esc_html__( 'Image position', 'gowatch' ),
						'field'   => 'select',
						'options' => array(
							'left'   => esc_html__( 'Left', 'gowatch' ),
							'right'  => esc_html__( 'Right', 'gowatch' ),
							'mosaic' => esc_html__( 'Mosaic', 'gowatch' ),
						),
						'id'      => $id . '[image-position]',
						'std'     => 'left',
						'class'   => 'airkit_' . $id . '-element-type-big'
					),			

					array(
						'name'    => esc_html__( 'Content split', 'gowatch' ),
						'field'   => 'select',
						'options' => array(
							'1-3' => esc_html__( '1-3', 'gowatch' ),
							'1-2' => esc_html__( '1-2', 'gowatch' ),
							'3-4' => esc_html__( '3-4', 'gowatch' ),
						),
						'id'      => $id . '[content-split]',
						'std'     => '1-2',
						'class'   => 'airkit_' . $id . '-element-type-big'
					),
				)
			);
		}

		return $out;
	}

	static function system_status( $input, $values )
	{
		$result = get_template_part('/includes/status');

		return $result;
	}

	static function support( $input, $values )
	{
		echo '<strong>Dear customers</strong>,<br><br>

		<p>
			To make sure you recieve fast and quality support - please make sure you use <a href="http://support.touchsize.com" target="_blank" class="go-help-desk"><strong>our help desk</strong></a> for any questions regarding theme theme settings and questions about how it works. <strong style="color: red;">We offer support exclusively on the help desk</strong>, and emailing or contacting us via any other forms will result in lost time and longer waits. We try to respond to your questions as soon as possible, but please, be patient, calm and friendly. It it a huge amount of work to respond to everyone and being rude to our support guys will just not make it easier for any of us.
		</p>

		<p>

			By using this theme and buying it, you agree to the support and <a href="https://touchsize.com/refunds/" target="_blank" style="color: red; text-decoration: underline;"><strong>refund policy</strong></a> for our products. Check our website for more details on this.

		</p>

		<p>If you found any bugs and issues while using our theme, please report them to <a href="http://support.touchsize.com/" target="_blank" class="go-help-desk"><strong>our support</strong></a> guys.</p>

		<h5>Note: Before submitting a ticket, try to disable ALL your plugins and make sure you are using the latest version of the theme. If you are not sure which is the latest one, you can check it on our website - www.touchsize.com. We cannot guarantee that the theme will work perfectly with all the plugins out there, since there might be conflicts or errors in your plugins. If you do find such conflicts, also - report them to our support team.</h5>

		<p>Thank you very much for your understanding and we hope you are having a nice experience with the theme.</p>

		<a href="http://support.touchsize.com" target="_blank" class="go-help-desk">Go to help desk</a>';
	}


	static function update( $input, $values )
	{
		echo '<p>' . esc_html__( 'Update your Theme from the WordPress Dashboard', 'gowatch' ) . '</p>';

		$html = '<p>As you can see, there is a new Envato Token option. Please check the documentation for more details:<br><br><a href="https://help.touchsize.com/knowledgebase/how-to-get-and-set-your-envato-token/" class="button button-secondary" target="_blank">Click for Token Tutorial</a><br><br></p>';

		$updates = get_site_transient( 'update_themes' );

		if ( ! empty( $updates ) && ! empty( $updates->response ) )
		{
			$theme = wp_get_theme();

			if ( $key = array_key_exists( $theme->get_template(), $updates->response ) )
			{
				echo '<p>' . esc_html__( 'You have update for your theme.', 'gowatch' ) . '</p>';
			}
		}

		echo airkit_var_sanitize( $html, 'the_kses' );
	}

	static function import( $input, $values )
	{
		$file_data = '';

		$file_headers = @get_headers( get_template_directory_uri() . '/import/demo-files/settings.txt' );

		if ( $file_headers[0] !== 'HTTP/1.1 404 Not Found' ) {
			$file_data = wp_remote_fopen( get_template_directory_uri() . '/import/demo-files/settings.txt' );
		}

		echo sprintf( '<p>' . esc_html__( 'Proceed with caution. Warning! You %s WILL lose all your current settings FOREVER %s if you paste the import data and click "Save changes". Double check everything!', 'gowatch' ) . '</p>', '<b style="color: #D92223">', '</b>' );

		if ( isset( $_GET['updated'] ) ) {

			if ( $_GET['updated'] === 'true' ) {

				echo '<div class="sucess">' . esc_html__( 'Options are successfully imported', 'gowatch' ) . '</div>';

			} else {

				echo '<div class="error">' . esc_html__( 'Options can\'t be imported. Inserted data can\'t be decoded properly', 'gowatch' ) . '</div>';
			}
		}
		?>
		<form action="<?php echo esc_url( admin_url( 'admin.php?page=gowatch&tab=save_options' ) ); ?>" method="POST">
			<textarea name="encoded_options" id="ts_encoded_options" ><?php echo esc_attr( self::export_options() ); ?></textarea>
			<input type="hidden" name="ts-save-options" value="import" />
			<input type="hidden" name="airkit_save-options" value="<?php echo wp_create_nonce('airkit_save-options'); ?>" />
			<input type="submit" name="ts_submit_button" class="button" value="<?php esc_html_e( 'Save changes', 'gowatch' ); ?>">
	
			<script>
				jQuery(document).ready(function($) {

					$(document).on('click', '#ts_encoded_options', function(event) {
						event.preventDefault();
						$('#ts_encoded_options').select();
					});
				});
			</script>
		</form>
		<?php
	}

	static function export_options()
	{
		$export = array();

		$expots_options = array(
			'gowatch_options',
			'gowatch_sidebars',
			'gowatch_header_templates',
			'gowatch_header_template_id',
			'gowatch_header',
			'gowatch_footer',
			'gowatch_footer_templates',
			'gowatch_footer_template_id',
			'gowatch_page_template_id',
			'advertising',
			'gowatch_theme_update'
		);

		foreach ( $expots_options as $option ) {

			$export[$option] = get_option( $option, array() );

		}

		return ts_enc_string( serialize( $export ) );
	}

	static function import_demo( $input, $values )
	{
		if ( class_exists('Ts_Importer') ) {
			$import = new Ts_Importer();
			$import->demo_installer();
		}
	}

	static function reset_settings( $input, $values )
	{
		check_ajax_referer( 'extern_request_die', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) return die();

		delete_option( 'gowatch_options' );
		delete_option( 'gowatch_sidebars' );
		delete_option( 'gowatch_footer' );
		delete_option( 'gowatch_header' );

		do_action('after_switch_theme', 'gowatch');

		echo '<div class="ts-succes-reset">' . esc_html__( 'Done !', 'gowatch' ) . '</div>';

		die();
	}

    public static function flush_fonts_transient()
    {

        check_ajax_referer( 'extern_request_die', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) return die();

        $response = [];

        try{ 

            delete_transient( 'ts-fonts' );

            if( is_multisite() ) {

                delete_site_transient( 'ts-fonts' );

            }

            // success
            $response['status'] = 'success';

        }catch( Exception $exc ){

            // throw exception message
            $response['status'] = 'exception';
            $response['exception'] = $exc;

        }finally{
            // end ajax request.
            echo json_encode( $response );
            die();
        }
    }

    static function flush_transient( $input, $values )
    {
        ?>
            <div class="ts-option-line airkit_flush-transient">
                <div class="col-lg-5 col-md-5">        
                    <?php esc_html_e( 'Flush Fonts Transient', 'gowatch' ); ?>                    
                </div>
                <div class="col-lg-7 col-md-7">
                    <?php  echo '<input type="button" name="fonts_transient" class="button" value="'. esc_html__( 'Flush Transient', 'gowatch' ) .'">'; ?>
                    <span class="description">
                        <?php echo esc_attr( $input['desc'] ); ?>
                        <div class="ts-succes-reset"><?php esc_html_e( 'Done !', 'gowatch' ) ?> </div>
                    </span>
                </div>
            </div>
        <?php
    }

    static function reinstall_forms( $input, $values )
    {
    	?>
        <div class="ts-option-line airkit_flush-transient">
            <div class="col-lg-5 col-md-5">        
                <?php esc_html_e( 'Flush Fonts Transient', 'gowatch' ); ?>                    
            </div>
            <div class="col-lg-7 col-md-7">
                <?php  echo '<input type="button" name="fonts_transient" class="button" value="'. esc_html__( 'Flush Transient', 'gowatch' ) .'">'; ?>
                <span class="description">
                    <?php echo esc_attr( $input['desc'] ); ?>
                    <div class="ts-succes-reset"><?php esc_html_e( 'Done !', 'gowatch' ) ?> </div>
                </span>
            </div>
        </div> 

    <?php   	
    }

    // Get frontend submission forms.

    static function get_frontend_forms( $type = 'submit' ) 
    {	
    	// Args for get posts. We need to extract post type 'tszf_forms'.
    	$forms_args = array(
    			'post_type'   => 'tszf_forms',
    			'post_status' => 'publish',
    		);

    	// If we're getting registration form, change post type to 'tszf_profile'.
    	if( 'register' === $type ) {

    		$forms_args[ 'post_type' ] = 'tszf_profile';

    	}

    	// Get all forms for provided type. [array]
    	$forms_post = get_posts( $forms_args );

    	$forms = array();

    	// Loop trough forms, and build array for select options. Pairs [id] => [title].
    	foreach ( $forms_post as $form ) {

    		$forms[ $form->ID ] = $form->post_title;

    	}

    	return $forms;

    }

	// Extract sidbars and create html for tab sidebars.
	static function sidebars( $input, $values )
	{
		$sidebars = get_option( 'gowatch_sidebars' );
		$html = '';
		$html .= '<div id="ts-sidebars">';

		if ( ! empty( $sidebars ) ) {

			foreach ( $sidebars as $id => $sidebar ) {

				$html .= '
					<div>
						<span class="dynamic-sidebar">' . $sidebar . '</span>
						<span>
							<a href="#" id="' . $id . '" class="ts-remove-sidebar">' .
								esc_html__( 'Delete', 'gowatch' ) .
							'</a>
						</span>
					</div>';
			}
		}

		$html .= '</div>';
		
		$html .= '
			<input type="text" name="sidebar_name" id="airkit_sidebar_name" />
			<input type="submit" name="add_sidebar" id="ts_add_sidebar" class="button-primary" value="' . esc_html__( 'Add sidebar', 'gowatch' ) . '" />';

		echo airkit_var_sanitize( $html, 'the_kses' );
	}

	// Ajax function to add sidebar to storage.
	static function add_sidebar()
	{
		$response = array(
			'success' => 0,
			'message' => 'Error',
			'sidebar' =>
				array(
					'id' => 0,
					'name' => ''
				)
		);

		$sidebars = ( $sidebars = get_option('gowatch_sidebars') ) && is_array( $sidebars ) ? $sidebars : array();
		$name     = trim( str_replace( array( "\n","\r","\t" ), '', $_POST['airkit_sidebar_name'] ) );
		$name     = preg_replace( "/\s+/", " ", $name );

		if ( $sidebars ) {
			foreach ( $sidebars as $id => $sidebar ) {
				if ( strcmp( $sidebar, $name ) == 0 ) {
					$response['message'] = 'Sidebar already exists, please use a different name.';
					die( json_encode( $response ) );
				}
			}
		}

		$id              = 'ts-sidebar-' . uniqid();
		$sidebars[ $id ] = $name;

		update_option( 'gowatch_sidebars', $sidebars );

		$response['success']         = 1;
		$response['sidebar']['id']   = $id;
		$response['sidebar']['name'] = $name;

		die( json_encode( $response ) );
	}

	// Ajax function to remove sidebar from storage.
	static function remove_sidebar()
	{
		$sidebar_id = $_POST['airkit_sidebar_id'];

		// 0 - error, 1 - removed, 2 - sidebar does not exist
		$response = array(
			'result' => 0,
			'element_id' => ''
		);

		$sidebars = ( $sidebars = get_option('gowatch_sidebars') ) && is_array( $sidebars ) ? $sidebars : array();

		if ( array_key_exists( $sidebar_id, $sidebars ) ) {

			unset( $sidebars[ $sidebar_id ] );

			update_option( 'gowatch_sidebars', $sidebars );

			$response['result']     = 1;
			$response['element_id'] = $sidebar_id;

		} else {

			$response['result'] = 2;

		}

		die( json_encode( $response ) );
	}

	// Ajax function to remove font.
	static function remove_font()
	{
		if( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'extern_request_die' ) || ! isset( $_POST['id'] ) || ! is_numeric( $_POST['id'] ) ) die();

		// Storage for all global options.
		$storage = get_option( 'gowatch_options', array() );
		$key_to_remove = absint( $_POST['id'] );

		if ( ! isset( $storage['typography']['custom'][ $key_to_remove ] ) ) die();

		// First get font family to delete it later from storage of font familys.
		$family = $storage['typography']['custom'][ $key_to_remove ]['family'];

		// Remove from global options typography.
		unset( $storage['typography']['custom'][ $key_to_remove ] );

		$fonts = get_transient( 'ts-fonts' );

		// Remove custom font from transient, after update old transient.
		if ( isset( $fonts[ $family ] ) ) {

			unset( $fonts[ $family ] );

			set_transient( 'ts-fonts', $fonts, 48 * HOUR_IN_SECONDS );
		}

		wp_send_json( array( 'family' => $family ) );
	}


	static function img_size( $input, $values )
	{
		$default = isset( $values[ $input['id'] ] ) ? $values[ $input['id'] ] : $input['std'];
		?>
		<div class="ts-option-line">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">
				<span><?php esc_html_e( 'Width (px)', 'gowatch' ); ?></span>
				<input type="number" name="<?php echo esc_attr( $input['id'] ) ?>[width]" value="<?php echo absint( $default['width'] ); ?>">

				<span><?php esc_html_e( 'Height (px)', 'gowatch' ); ?></span>
				<input type="number" name="<?php echo esc_attr( $input['id'] ) ?>[height]" value="<?php echo absint( $default['height'] ); ?>">

				<span><?php esc_html_e( 'Resize mode', 'gowatch' ); ?></span>
				<select name="<?php echo esc_attr( $input['id'] ) ?>[mode]">
					<option<?php selected( $default['mode'], 'crop' ); ?> value="crop"><?php esc_html_e( 'Crop', 'gowatch' ); ?></option>
					<option<?php selected( $default['mode'], 'resize' ); ?> value="resize"><?php esc_html_e( 'Resize', 'gowatch' ); ?></option>
				</select>
			</div>
		</div>
		<?php
	}

	static function choose_bg( $input, $values )
	{
		$default = isset( $values[ $input['id'] ] ) ? $values[ $input['id'] ] : $input['std'];
		?>
		<div class="ts-option-line">
			<div class="col-lg-5 col-md-5">
				<?php esc_html_e( 'Choose patern', 'gowatch' ); ?>
			</div>
			<div class="col-lg-7 col-md-7">
				<input type="button" class="button-primary" value="<?php esc_html_e( 'Choose template', 'gowatch' ); ?>" id="ts-get-patterns"/>
				<?php if ( ! empty( $default ) ) : ?>
					<div>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/patterns/' . $default ); ?>" class="ts-preview-pattern">
					</div>
				<?php endif; ?>
				<input type="hidden" name="theme_bg_pattern" value="<?php echo airkit_var_sanitize( $default, 'esc_attr' ); ?>"/>
			</div>
		</div>
		<?php
	}

	static function airkit_get_patterns()
	{
		if( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'extern_request_die' ) ) return;

		$patterns = array(
			'45degree_fabric',
			'arches',
			'assault',
			'az_subtle',
			'back_pattern',
			'bedge_grunge',
			'beige_paper',
			'bgnoise_lg',
			'billie_holiday',
			'black-Linen',
			'black_denim',
			'black_linen_v2',
			'black_mamba',
			'black_paper',
			'black_scales',
			'blackmamba',
			'blizzard',
			'bright_squares',
			'brillant',
			'broken_noise',
			'carbon_fibre',
			'cardboard_flat',
			'chruch',
			'circles',
			'classy_fabric',
			'clean_textile',
			'concrete_wall',
			'cracks_1',
			'crossed_stripes',
			'crosses',
			'cubes',
			'dark_mosaic',
			'dark_stripes',
			'dark_wall',
			'dark_wood',
			'debut_light',
			'diagmonds',
			'diamond_upholstery',
			'double_lined',
			'fake_brick',
			'first_aid_kit',
			'green_fibers',
			'irongrip',
			'lghtmesh',
			'light_wool',
			'little_triangles',
			'pinstripe',
			'retina_wood',
			'rubber_grip',
			'shattered',
			'striped_lens',
			'subtle_carbon',
			'subtle_dots',
			'subtlenet2',
			'tileable_wood_texture',
			'tiny_grid',
			'wild_oliva',
			'wood_1',
			'worn_dots',
			'zigzag',
		);

		$imgs = array();

		foreach ( $patterns as $pattern ) {
			$imgs[] = '<img src="' . get_template_directory_uri() . '/images/patterns/' . $pattern . '.png" data-option="' . $pattern . '.png">';
		}

		echo
			'<ul class="imageRadioMetaUl perRow-3 ts-select-pattern" data-selector="#ts-theme_bg_pattern">
				<li>' .
					implode( '</li><li>' , $imgs ) .
		    	'</li>
		    </ul>';

		die();
	}

	static function frontend_settings_page() {
		//Get existing TSZF_Admin_Settings instance and show plugin settings page.
		$frontend_settings = TSZF_Admin_Settings::init();
		$frontend_settings->plugin_page();

	}

	static function custom_font( $input, $values )
	{
		$customs = isset( $values['custom'] ) && ! empty( $values['custom'] ) ? $values['custom'] : '';

		if ( ! empty( $customs ) ) {

			foreach ( $customs as $key => $value ) {
				echo
					'<div class="ts-item-font">
						<p>' . $value['family'] . '</p>
						<input type="button" data-id="' . $key . '" value="' . esc_html__( 'Remove', 'gowatch' ) . '" class="ts-remove-font">
					</div>';
			}
		}
	}

	static function display_menu_page()
	{
		$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';

		if ( ! array_key_exists( $active_tab , self::get_options( 'fields', 'all' ) ) ) $active_tab = 'general';

		// Get all tabs settings.
		$tabs = self::get_options( 'tabs' );

		unset( $tabs['header_settings'] );
		unset( $tabs['footer_settings'] );

		// Exclude submit button form.
		$excludes = array( 'sidebar', 'red_area', 'import', 'support', 'frontend', 'system_status' );

		// Get current theme version
		$theme_details = wp_get_theme();

		?>

		<h2>Theme options panel</h2>
		<div class="wrap">
			<div class="wrap-red">
				<div id="red-wprapper">
					<div id="red-menu">
						<ul id="theme-setting">

							<?php foreach ( $tabs as $key => $tab ) : ?>

								<li class="<?php echo ( $active_tab == $key ? 'selected-tab' : '' ); ?>">
									<a href="?page=gowatch&tab=<?php echo airkit_var_sanitize( $key, 'esc_attr' ); ?>">
										<i class="icon-<?php echo airkit_var_sanitize( $tab['class'], 'esc_attr' ); ?>"></i>
										<span><?php echo airkit_var_sanitize( $tab['title'], 'esc_attr' ); ?></span>
									</a>
								</li>

							<?php endforeach; ?>

						</ul>
					</div>
					<div id="red-options">
						<div class="theme-name">
							<h3>gowatch <?php echo airkit_var_sanitize( $theme_details['Version'], 'esc_attr' ); ?></h3>
							<h3>TouchSize</h3>
						</div>
						<h3 class="tab-title"><?php echo esc_html( $tabs[ $active_tab ]['title'] ); ?></h3>
						<p class="tab-description"><?php echo esc_html( $tabs[ $active_tab ]['desc'] ); ?></p>

						<?php if( 'frontend' == $active_tab ): 

							self::build_settings( $active_tab );

						else: ?>
							<form method="post" data-table="<?php echo airkit_var_sanitize( $active_tab, 'the_kses' ); ?>" action="" enctype="multipart/form-data">

								<?php
									// Building html options depending on active tab.
									self::build_settings( $active_tab );

									// Exlude submit button from specifics tabs.
									if ( ! in_array( $active_tab, $excludes ) && !airkit_verify_ls_activation() ) {

										submit_button( esc_html__( 'Save options', 'gowatch' ), 'button', 'ts-save-options' );

										wp_nonce_field( 'airkit_save-options', 'airkit_save-options' );
									}

								?>

							</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

	static function build_settings( $tab )
	{
		if( airkit_verify_ls_activation() ) {echo 'Options disabled because you did not activate the license.'; return;}
		// Storage for all global options.
		$storage = get_option( 'gowatch_options', array() );

		// Get saved options by activeted tab.
		$tab_values = isset( $storage[ $tab ] ) ? $storage[ $tab ] : array();

		// Get arrays of fields options by activeted tab.
		$fields = self::get_options( 'fields', $tab );

		foreach ( $fields as $field ) {

			if ( is_array( $field['field'] ) ) {
				// Add custom function from this class or another.
				call_user_func( $field['field'], $field, $tab_values );

			} else {

				call_user_func( array( 'airkit_Fields', $field['field'] ), $field, $tab_values );
			}
		}
	}

	static function save()
	{

		if ( ! isset( $_GET['page'] ) || $_GET['page'] != 'gowatch' || ! isset( $_POST['ts-save-options'] ) ) return;

		if ( ! isset( $_POST['airkit_save-options'] ) || ! wp_verify_nonce( $_POST['airkit_save-options'], 'airkit_save-options' ) ) return;

		// Storage of all global options.
		$storage = get_option( 'gowatch_options', array() );

		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';

		// If import tab, unpack data and insert it in DB and return sto

		if ( $tab == esc_attr( 'import' ) && isset( $_POST['encoded_options'] ) && $_POST['encoded_options'] != '' ) {

			$storage = $_POST['encoded_options'];

			airkit_Options::gowatch_impots_decoded_options( $storage );
			return;

		}

		// Get all options to extract needed keys to insert in db.
		$defaults = self::get_options( 'fields', $tab );

		foreach ( $defaults as $values ) {

			$storage = self::save_item( $tab, $storage, $values );

			// If is typography page options when we need to extract custom fonts and save its.
			if ( $tab == 'typography' ) {

				$storage['typography'] = self::save_custom_font( $storage['typography'] );

			}
		}

		update_option( 'gowatch_options', $storage );
	}

	public static function save_item( $tab_id, $storage, $value )
	{
		if ( $value['field'] == 'block_fields' ) {

			foreach ( $value['fields'] as $field ) {
				$storage = self::save_item( $tab_id, $storage, $field );
			}

			return $storage;

		}

		if ( isset( $value['id'] ) && strpos( $value['id'], '[' ) !== false ) {

			$ex = explode( '[', $value['id'] );

			$value['id'] = $ex[0];

		}

		// if ( ! isset( $value['id'] ) || ! array_key_exists( $value['id'], $_POST ) ) return $storage;

		if ( ! isset( $storage[ $tab_id ] ) || ! is_array( $storage[ $tab_id ] ) ) {

			$storage[ $tab_id ] = array();

		}

		if ( $value['field'] == 'textarea' ) {
			$storage[ $tab_id ][ $value['id'] ] = stripcslashes($_POST[ $value['id'] ]);
		} else {
			$storage[ $tab_id ][ $value['id'] ] = isset( $_POST[ $value['id'] ] ) ? $_POST[ $value['id'] ] : '';
		}

		return $storage;
	}

	// Save custom fonts.
	public static function save_custom_font( $values )
	{
		if 	(
				! isset( $_POST['extra']['eot'], $_POST['extra']['svg'], $_POST['extra']['ttf'], $_POST['extra']['woff'], $_POST['extra']['custom_family'] ) ||
			  	empty( $_POST['extra']['eot'] ) || empty( $_POST['extra']['svg'] ) || empty( $_POST['extra']['ttf'] ) || empty( $_POST['extra']['woff'] ) || empty( $_POST['extra']['custom_family'] )
			) return $values;

		$family = sanitize_text_field( $_POST['extra']['custom_family'] );

		// Settings to create font-face in css.
		$custom = array(
			'family' => $family,
			'files'  => array(
				'eot'  => esc_url_raw( $_POST['extra']['eot'] ),
				'svg'  => esc_url_raw( $_POST['extra']['svg'] ),
				'ttf'  => esc_url_raw( $_POST['extra']['ttf'] ),
				'woff' => esc_url_raw( $_POST['extra']['woff'] )
			)
		);

		if ( ! isset( $values['custom'] ) || ! is_array( $values['custom'] ) ) $values['custom'] = array();

		// Inset to array of custom fonts to save in data base.
		$values['custom'][ $family ] = $custom;

		// All fonts from google and custom.
		$fonts = get_transient( 'ts-fonts' );

		$insert = array( $family => $family );

		if ( is_array( $fonts ) ) {

			$fonts = $insert + $fonts;

		} else {

			$fonts = $insert;
		}

		set_transient( 'ts-fonts', $fonts, 48 * HOUR_IN_SECONDS );

		// Set empty the inputs to be ready for new files.
		$values['extra']['eot'] = '';
		$values['extra']['svg'] = '';
		$values['extra']['ttf'] = '';
		$values['extra']['woff'] = '';
		$values['extra']['custom_family'] = '';

		return $values;
	}

	// Insert all defaults options to database.
	static function after_switch_theme()
	{
		// Get all options to extract needed keys to insert in db.
		$defaults = self::get_options( 'fields', 'all' );

		$collector = array();

		foreach ( $defaults as $tab_id => $values ) {

			$collector[ $tab_id ] = array();

			foreach ( $values as $value ) {

				if ( ! isset( $value['id'] ) ) continue;

				if ( $value['field'] == 'block_fields' ) {

					foreach ( $value['fields'] as $field ) {

						$collector = self::collector( $tab_id, $collector, $field );
					}

				} else {

					$collector = self::collector( $tab_id, $collector, $value );
				}
			}
		}

		$old_options = get_option( 'gowatch_options' );

		if ( empty( $old_options ) ) {

			update_option( 'gowatch_options', $collector );
		}

		$icons = 'icon-noicon,icon-smartphone,icon-upload,icon-home,icon-rss,icon-direction,icon-down,icon-up,icon-sidebar,icon-desktop,icon-table,icon-shield,icon-heart,icon-empty,icon-layers,icon-money,icon-reddit,icon-comment-full,icon-save,icon-video,icon-close,icon-update,icon-download,icon-quote,icon-pencil,icon-page,icon-play,icon-filter,icon-equalizer,icon-left,icon-right,icon-add,icon-clock-1,icon-list-add,icon-vimeo,icon-lastfm,icon-logo,icon-like,icon-audio,icon-dollar,icon-menu,icon-delimiter,icon-image-size-1,icon-timer,icon-vk,icon-resize-vertical,icon-text,icon-movie,icon-dribbble,icon-yahoo,icon-user-full,icon-twitter,icon-grid-full,icon-apple-1,icon-skype,icon-linkedin,icon-aubergine,icon-login,icon-font,icon-megaphone,icon-button,icon-wordpress,icon-music,icon-mail,icon-lock,icon-search,icon-github,icon-columns,icon-star-full,icon-link-ext,icon-book,icon-signal,icon-target,icon-attach,icon-remove,icon-delivery,icon-mic,icon-basket,icon-settings,icon-headphones-1,icon-headphones,icon-credit-card,icon-share,icon-drag,icon-key-1,icon-euro,icon-pound,icon-odnoklassniki-logo,icon-rupee,icon-yen,icon-rouble,icon-try,icon-won,icon-bitcoin,icon-anchor,icon-tablet,icon-block,icon-blocks,icon-graduate,icon-layout,icon-window,icon-coverflow,icon-flight,icon-brush,icon-resize-full,icon-news,icon-support,icon-params,icon-beaker,icon-category,icon-bell,icon-help,icon-photo,icon-palette,icon-mobile,icon-thumb,icon-briefcase,icon-pin,icon-ticket,icon-chart,icon-book-1,icon-print,icon-on,icon-off,icon-featured-area,icon-team,icon-delete,icon-clients,icon-image-size,icon-whatsapp,icon-gauge,icon-bag,icon-key,icon-glasses,icon-ok-full,icon-restart,icon-recursive,icon-shuffle,icon-books,icon-list,icon-flash,icon-leaf,icon-chart-pie-outline,icon-puzzle,icon-fullscreen,icon-downscreen,icon-zoom-in,icon-zoom-out,icon-pencil-alt,icon-down-dir,icon-left-dir,icon-right-dir,icon-up-dir,icon-gallery,icon-parallel,icon-circle-outline,icon-circle-full,icon-dot-circled,icon-threedots,icon-colon,icon-down-micro,icon-cancel,icon-medal,icon-square-outline,icon-rhomb,icon-rhomb-outline,icon-pause,icon-book-closed,icon-cd,icon-clipboard,icon-view-mode,icon-right-arrow,icon-left-arrow,icon-bacon,icon-featured-article,icon-tags,icon-event-date,icon-chronometers,icon-weights,icon-calligraphy,icon-fast-delivery,icon-education,icon-notes,icon-announce,icon-toggler,icon-home-care,icon-website-star,icon-coconut,icon-christmas-present,icon-supermarket,icon-curved-arrows,icon-telescope,icon-analysis-timer,icon-login12,icon-laptop,icon-search-field,icon-leaves,icon-semicircular,icon-eyeglasses,icon-diagrams,icon-chair,icon-online,icon-writing,icon-mappointer,icon-ribbon,icon-laboratory,icon-heart-hands,icon-presentation,icon-diploma,icon-protected,icon-analysis,icon-goal,icon-login9,icon-plate,icon-analytics,icon-passport,icon-sandwich,icon-website-code,icon-target-hit,icon-network-people,icon-search-engine-optimization,icon-notebook-checked,icon-website-checked,icon-firewall,icon-space-ship,icon-map-pointer,icon-web-programming,icon-road16,icon-fast-forward-button,icon-phone-1,icon-shopping63,icon-newspapers2,icon-business-up,icon-graphic-man,icon-work-graphic,icon-angle-double-left,icon-badge-new,icon-christmas-present-1,icon-video-cineva,icon-film-round,icon-images-gallery,icon-photo-tripod,icon-photo-stativ,icon-illumination,icon-photography-umbrella,icon-photo-more,icon-photography-camera,icon-device-camera,icon-music-item,icon-video-surveillance,icon-desk-lamp,icon-usb,icon-mouse-scroll,icon-angle-double-right,icon-language,icon-wheelchair,icon-extinguisher,icon-puzzle-1,icon-cc-visa,icon-tree,icon-server,icon-subway,icon-chart-line,icon-water,icon-rocket,icon-target-1,icon-squares,icon-signal-1,icon-videocam-alt,icon-user-pair,icon-home-1,icon-heart-broken,icon-religious-jewish,icon-fuel,icon-garden,icon-basketball,icon-terminal,icon-t-shirt,icon-wallet,icon-shop,icon-food,icon-money-1,icon-sound,icon-clock,icon-left-arrow-thin,icon-right-arrow-thin,icon-snapchat,icon-file-audio,icon-compass,icon-venus-mars,icon-soccer-ball,icon-tty,icon-newspaper,icon-bank,icon-coffee,icon-thumbs-down,icon-tabs,icon-toggle-off,icon-tint,icon-gift,icon-medkit,icon-h-sigh,icon-codeopen,icon-flag-1,icon-bookmarks,icon-thermometer,icon-flow-tree,icon-air,icon-tape,icon-spinner2,icon-duplicate,icon-split,icon-exchange,icon-undo,icon-comment-alt2,icon-code-outline,icon-diamond,icon-spinner,icon-hammer,icon-building-filled,icon-dislike,icon-marquee,icon-doc,icon-expand,icon-collapse,icon-expand-right,icon-collapse-left,icon-link,icon-scissors,icon-crop,icon-paste,icon-certificate,icon-bug,icon-rocket-1,icon-recycle,icon-chart-area,icon-chart-pie,icon-chart-line-1,icon-list-alt,icon-qrcode,icon-barcode,icon-folder-open,icon-logout,icon-award,icon-code,icon-comments,icon-time,icon-edit,icon-flag,icon-import,icon-lamp,icon-phone,icon-post,icon-image,icon-reading,icon-star,icon-users,icon-user,icon-views,icon-social,icon-attention,icon-windows,icon-instagram,icon-gplus,icon-export,icon-tick,icon-plus,icon-minus,icon-banana,icon-apple,icon-can-1,icon-cabbage,icon-can-2,icon-butcher,icon-candy-1,icon-coffee-maker,icon-cheese-1,icon-cookies,icon-coffee-4,icon-coffee-3,icon-corn,icon-doughnut,icon-glass-5,icon-glass-2,icon-fish,icon-grater,icon-glass-4,icon-glass-6,icon-hazelnut,icon-hamburguer,icon-honey,icon-ice-cream-13,icon-ice-cream-3,icon-ice-cream-5,icon-honey-1,icon-lime,icon-kebab,icon-kebab-2,icon-knife-1,icon-lemon,icon-meat-2,icon-octopus,icon-peach,icon-onion-1,icon-pepper-1,icon-pie,icon-pizza-3,icon-pie-1,icon-pistachio,icon-pizza,icon-popsicle,icon-salad-1,icon-risotto,icon-raspberry,icon-potatoes-1,icon-sandwich-1,icon-spatula,icon-seeds,icon-steak,icon-spices,icon-sushi-2,icon-sushi,icon-watermelon,icon-tomato,icon-whisk,icon-hamburger,icon-jam,icon-lemon-1,icon-milk,icon-orange,icon-ham,icon-teapot,icon-sausage,icon-salami,icon-pint,icon-cake,icon-cookie,icon-cracker,icon-croisant,icon-cupcake,icon-donut,icon-noodles,icon-jam-1,icon-ice-cream-12,icon-ice-cream-2,icon-hamburguer-1,icon-ice-cream-9,icon-ladle,icon-oil,icon-pie-4,icon-rice,icon-sandwich-2,icon-teapot-1,icon-garlic,icon-bun,icon-pie-3,icon-pie-2,icon-piece-of-baguette,icon-piece-of-bread,icon-pizza-1,icon-pretzel,icon-pastry-spatula,icon-frappe,icon-eggs,icon-dishes,icon-food-1,icon-fries,icon-glass-3,icon-flour-1,icon-fork,icon-glass-1,icon-gingerbread,icon-fig,icon-flour,icon-wheat,icon-wind-mill,icon-garlic-1,icon-ice-cream-1,icon-grinder,icon-ham-1,icon-glass,icon-hot-dog,icon-groceries,icon-hot-dog-1,icon-grain,icon-grapes,icon-ice-cream-4,icon-ice-cream-11,icon-ice-cream-10,icon-ice-cream-8,icon-ice-cream-7,icon-ice-cream,icon-ice-cream-6,icon-ice-cream-14,icon-jam-2,icon-knife-2,icon-knife,icon-jawbreaker,icon-knife-3,icon-jelly,icon-knives,icon-lemon-2,icon-kebab-1,icon-kitchen,icon-meat,icon-mustard-2,icon-mug,icon-mustard,icon-milk-1,icon-oat,icon-mustard-1,icon-mushrooms,icon-milk-2,icon-mushroom,icon-mixer,icon-meat-1,icon-olives,icon-pan,icon-peas,icon-ornating,icon-pancakes-1,icon-pasta-1,icon-pepper,icon-pancakes,icon-onion,icon-pickles,icon-orange-1,icon-pasta,icon-pear,icon-pot-1,icon-pizza-2,icon-pomegranate,icon-pizza-4,icon-pizza-5,icon-pot,icon-pizza-6,icon-pot-2,icon-pineapple,icon-potatoes-2,icon-pudding,icon-pretzel-1,icon-radish,icon-potatoes,icon-salad,icon-rolling-pin,icon-pumpkin,icon-salmon,icon-sorbet,icon-slotted-spoon,icon-shrimp,icon-salt,icon-spoon,icon-scale,icon-spaguetti,icon-stew-1,icon-spatula-1,icon-stew,icon-toast,icon-toaster,icon-tenderizer,icon-taco,icon-sushi-1,icon-teaspoon,icon-strainer,icon-tea,icon-strawberry,icon-tea-1,icon-thermos,icon-toffee,icon-turkey,icon-water-1,icon-water-2,icon-wrap,icon-apple-2,icon-aubergine-1,icon-avocado,icon-bread,icon-canned-food,icon-carrot,icon-cheese,icon-fried-egg,icon-pear-1,icon-pepper-2,icon-tea-2,icon-tomato-1,icon-whiskey,icon-baguette-1,icon-baguette,icon-balance,icon-basketwave,icon-beater,icon-belgian-waffle,icon-birthday-cake,icon-biscuit,icon-electric-mixer,icon-electric-mixter,icon-flour-2,icon-gingerbread-man,icon-hamburger-1,icon-kaak,icon-kifli,icon-loaf-of-bread-1,icon-loaf-of-bread,icon-macaron,icon-measuring-cup,icon-modern-oven,icon-pastry-spatula-1,icon-roll,icon-roller,icon-sandwich-3,icon-shovel,icon-silicone-brush,icon-silicone-spatula,icon-small-oven,icon-sourdough,icon-spoon-1,icon-stand-for-cake,icon-stone-oven,icon-turnover,icon-wedding-cake,icon-asparagus,icon-blueberries,icon-baguette-2,icon-boiled,icon-bowl-1,icon-biscuit-1,icon-avocado-1,icon-beans,icon-bowl,icon-bread-1,icon-cake-1,icon-cereals,icon-bread-2,icon-broccoli,icon-carrot-1,icon-bread-3,icon-candy,icon-cauliflower,icon-butter,icon-can,icon-chips,icon-cheese-2,icon-coconut-1,icon-chocolate,icon-chives,icon-chef,icon-chili,icon-coffee-2,icon-coffee-1,icon-coffee-5,icon-cherries,icon-croissant,icon-corckscrew,icon-doughnut-1,icon-doughnut-2,icon-corndog,icon-cupcake-1,icon-cutlery,icon-dairy,icon-cupcake-2,icon-cupcake-3,icon-egg,icon-cucumber,icon-dish,icon-cup,icon-views-1,icon-calendar,icon-big-heart,icon-knife-4,icon-play-full,icon-plus-bold,icon-flickr,icon-tumblr,icon-facebook,icon-download-full,icon-upload-full,icon-pinterest,icon-calendar-1,icon-arrow-slim-down,icon-arrow-slim-left,icon-arrow-slim-up,icon-arrow-slim-right,icon-arrow-slimmer-right,icon-arrow-slimmer-left,icon-arrow-stroke-left,icon-arrow-stroke-right';

		update_option( 'gowatch_icons', $icons, false );

	}

	static function collector( $tab_id, $collector, $field )
	{
		// Check if we have array in array.
		if ( strpos( $field['id'], '[' ) !== false ) {

			// Explode by '[';
			$ex = explode( '[', $field['id'] );

			// Remove occurences of ']'
			array_walk( $ex, function( &$value ) {

				$value = str_replace( ']', '', $value );

			});

			/* Build the scheme of array - $arr['x']['y']...['n'] */

			if ( count( $ex ) == 2 ) {

				$collector[ $tab_id ][ $ex[0] ][ $ex[1] ] = $field['std'];

			} elseif ( count( $ex ) == 3 ) {

				$collector[ $tab_id ][ $ex[0] ][ $ex[1] ][ $ex[2] ] = $field['std'];

			} elseif ( count( $ex ) == 4 ) {

				$collector[ $tab_id ][ $ex[0] ][ $ex[1] ][ $ex[2] ][ $ex[3] ] = $field['std'];

			} elseif ( count( $ex ) == 5 ) {

				$collector[ $tab_id ][ $ex[0] ][ $ex[1] ][ $ex[2] ][ $ex[3] ][ $ex[4] ] = $field['std'];

			}

		} else {

			$collector[ $tab_id ][ $field['id'] ] = isset( $field['std'] ) ? $field['std'] : '';

		}

		return $collector;
	}

	static function gowatch_impots_decoded_options( $encoded )
	{

		if ( ! function_exists( 'ts_enc_string' ) ) {
		    echo ('The plugin "Touchsize Custom Posts" is required.');
		    return;
		}

		$options = unserialize( ts_enc_string( $encoded, 'decode' ) );

		if ( $options === null ) {

			return false;

		} else {

			if ( $options ) {

				foreach ( $options as $option_name => $params ) {
					delete_option( $option_name );
					add_option( $option_name, $params );
				}
			}

			return true;
		}
	}

	static function gowatch_template_modals($location = 'header', $template_id = 'default', $template_name = 'Default') {
		ob_start();
	    ob_clean();
	    	wp_editor('', 'ts_editor_id', array(
	    			'textarea_name' => 'ts_name_textarea',
	    			'wpautop' => false,
	    			'tinymce' => array(
	    				'wpautop' => false,
	    				'elements' => 'ts_editor_id',
	    				'apply_source_formatting' => false,
	    			)
	    		)
	    	);

	    $editor_code = ob_get_clean();

	    $effects = airkit_all_animations( 'effect' );
	    $delaies = airkit_all_animations( 'delay' );
	    $effect_options = '';
	    $delay_options = '';


	    foreach ( $effects as $value => $name ) {

	    	$effect_options .= '<option value="' . $value . '">' . $name . '</option>';
	    }

	    foreach ( $delaies as $value => $name ) {

	    	$delay_options .= '<option value="' . $value . '">' . $name . '</option>';
	    }

		return '<table>
			<tr>
				<td style="width: 500px">
					<p>
						<input id="ts-save-as-template" data-location="' . esc_attr( $location ) . '" data-toggle="modal" data-target="ts-save-template-modal" type="button" name="submit" class="button-primary" value="' . esc_html__( 'Save as...', 'gowatch' ) . '" />

						<input id="ts-load-template-button" data-location="' . esc_attr( $location ) . '" type="button" name="submit" class="button-primary" value="' . esc_html__('Load template', 'gowatch') . '" />
					</p>

					<div class="ts-is-hidden airkit_modal" id="ts-blank-template-modal">
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-close"></i></button>
					        <h4 class="modal-title">' . esc_html__( 'Blank template', 'gowatch' ) . '</h4>
					    </div>
					    <div class="builder">
					    	<h5>' . esc_html__('Template name', 'gowatch') . '</h5>
					    	<input type="text" name="template_name" value="" id="ts-blank-template-name"/>

					    	<button type="button" class="button-primary" data-dismiss="modal">' . esc_html__( 'Close', 'gowatch' ) . ' </button>
					    	<button type="button" class="button-primary" data-location="' . esc_attr( $location ) . '" id="ts-save-blank-template-action">' . esc_html__( 'Save', 'gowatch' ) . '</button>
					    </div>
					</div>

					<div class="ts-is-hidden airkit_modal" id="ts-save-template-modal">
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-close"></i></button>
					        <h4 class="modal-title">' . esc_html__( 'Save template', 'gowatch' ) . '</h4>
					    </div>
					    <div class="builder">
					    	<h5>' . esc_html__( 'Template name', 'gowatch' ) . ':</h5>
					    	<input type="text" name="template_name" value="" id="ts-save-template-name"/>

					    	<button type="button" class="button-primary airkit_button-close">' . esc_html__( 'Cancel', 'gowatch' ) . '</button>
                        	<button type="button" class="button-primary" data-location="' . esc_attr( $location ) . '" id="ts-save-as-template-action">' . esc_html__( 'Save', 'gowatch' ) . '</button>
					    </div>
					</div>

					<div class="ts-is-hidden airkit_modal" id="ts-load-template">
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-close"></i></button>
					        <h4 class="modal-title">' . esc_html__( 'Load template', 'gowatch' ) . '</h4>
					    </div>
					    <div class="builder">
					    	<h5>' . esc_html__('Select template', 'gowatch') . ':</h5>
	                        <table id="ts-layout-list">

	                        </table>

	                        <button type="button" class="button-primary airkit_button-close">' . esc_html__( 'Cancel', 'gowatch' ) . '</button>
	                        <button type="button" class="button-primary" data-location="' . esc_attr( $location ) . '" id="ts-load-template-action">' . esc_html__('Load', 'gowatch') . '</button>
					    </div>
					</div>
				</td>
			</tr>
		</table>
		<div id="ts-builder-elements-modal-preloader"></div>
		<div id="airkit_builder-settings" style="display:none;">
			<div class="modal-dialog">
			    <div class="airkit_modal-body"></div>
			</div>
		</div>
		<div class="ts-is-hidden airkit_modal airkit_editor-modal">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-close"></i></button>
		        <h4 class="modal-title" id="ts-builder-elements-modal-label" data-elements-title="Builder elements" data-element-title="Builder element">Text element</h4>
		    </div>
		    <div class="builder airkit_element-settings">
			    <div class="ts-option-line">
	    			<div class="col-lg-5 col-md-5">' .
	    				esc_html__( 'Admin label', 'gowatch' ) .
	    			'</div>
	    			<div class="col-lg-7 col-md-7">
	    				<input type="text" name="admin-label" value="' . esc_html__( 'Text', 'gowatch' ) . '"/>
	    			</div>
	    		</div>
				<div class="ts-option-line">
	    			<div class="col-lg-5 col-md-5">' .
	    				esc_html__( 'Special effect', 'gowatch' ) .
	    			'</div>
	    			<div class="col-lg-7 col-md-7">
	    				<select name="reveal-effect" class="airkit_trigger-options">' .
	    					$effect_options .
	    				'</select>
	    			</div>
	    		</div>
	    		<div class="ts-option-line airkit_reveal-effect-none airkit_revert-trigger">
	    			<div class="col-lg-5 col-md-5">' .
	    				esc_html__( 'Delay', 'gowatch' ) .
	    			'</div>
	    			<div class="col-lg-7 col-md-7">
	    				<select name="reveal-delay">' .
	    					$delay_options .
	    				'</select>
	    			</div>
	    		</div>' .
		    	$editor_code .
		    	'<button type="button" class="airkit_change-el">' . esc_html__( 'Change element', 'gowatch' ) . '</button>
		    	<input type="button" class="button-primary airkit_save-el" value="' . esc_html__( 'Apply changes', 'gowatch' ) . '"/>
		    	<input type="button" class="button-primary airkit_cancel-el" value="' . esc_html__( 'Cancel', 'gowatch' ) . '"/>
		    	<input type="hidden" name="element-type" value="text"/>
		    	<input type="hidden" name="element-icon" value="icon-text"/>
		    </div>
		</div>
		<div class="airkit_export-modal" style="display:none;">
			<textarea name="export-element" class="airkit_export-options"></textarea>
		</div>';
	}

	/**
	 * Edit header
	 */
	static function gowatch_header()
	{
		?>
		<div class="wrap wrap-red">
			<div class="wrap-red-templates">
				<h2 class="main-headline"><?php esc_html_e('Header', 'gowatch') ?></h2>
				<p class="headline-description">
					<?php esc_html_e('On this page you can edit your header settings and layouts. You can select from the predefined styles or click the custom build option to use the drag and drop builder to create your own.', 'gowatch'); ?>
				</p>
				<div class="header-options">
					<div class="header-options__predefined">
						<?php
							$header_settings = airkit_option_value('header_settings', 'predefined-style');
							$header_options = airkit_option_value('header_settings', 'options');
							$airkit_header_styles = array(
								'name' => 'Choose your header style',
								'desc' => 'Click to select the wanted header style',
								'id' => 'predefined-style',
								'options' => array(
								    'style1' => esc_html__('Style 1', 'gowatch'),
								    'style2' => esc_html__('Style 2', 'gowatch'),
								    'style3' => esc_html__('Style 3', 'gowatch'),
								    'style4' => esc_html__('Style 4', 'gowatch'),
								    'style5' => esc_html__('Style 5', 'gowatch'),
								    'custom' => esc_html__('Custom designed', 'gowatch'),
								),
								'img' => array(
								    'style1' => 'header_style1.png',
								    'style2' => 'header_style2.png',
								    'style3' => 'header_style3.png',
								    'style4' => 'header_style4.png',
								    'style5' => 'header_style5.png',
								    'custom' => 'header_custom.png',
								),
								'std' => 'style1',
							);

							echo airkit_Fields::img_selector( $airkit_header_styles, array( 'predefined-style' => $header_settings ) );
						?>
					</div>
					<div class="header-options__list">
						<?php

							// Header 1 options
							$total_options = array(
								'style1' => array( 
									'name' 	  => 'Header 1',
									'desc' 	  => esc_html__('This header option includes social icons on the left, logo centered and a search icon on the right. Just below there is a menu option centered. The header is without any background options making it a light one.', 'gowatch'),
									'options' => array(
									)
								),
								'style2' => array(
									'name' 	  => 'Header 2',
									'desc' 	  => esc_html__('This header option includes logo on the left, menu and a search icon on the right. This menu option is sticky which means it will be stick when you scroll down to the top of the screen.', 'gowatch'),
									'options' => array(
									)
								),
								'style3' => array(
									'name' 	  => 'Header 3',
									'desc' 	  => esc_html__('This header option includes logo on the left, and a advertising banner option on the right. It has a dark background menu option below with a search icon on the right.', 'gowatch'),
									'options' => array(
										array(
											'name' 	=> 'Advertising banner',
											'desc'  => esc_html__( 'Insert your advertising code.', 'gowatch' ),
											'field'	=> 'textarea',
											'id' 	=> 'header3_banner',
											'std'	=> ''
										)
									)
								),
								'style4' => array(
									'name' 	  => 'Header 4',
									'desc' 	  => esc_html__('This header option includes logo on the left, menu and a search icon on the right.', 'gowatch'),
									'options' => array(
										array(
											'name' 	=> esc_html__( 'Enable sticky header', 'gowatch' ),
											'field'	=> 'select',
											'id' 	=> 'header4_sticky',
											'options' => array(
												'n' => esc_html__( 'No', 'gowatch' ),
												'y' => esc_html__( 'Yes', 'gowatch' ),
											),
											'std'	=> 'n'
										)
									)
								),
								'style5' => array(
									'name' 	  => 'Header 5',
									'desc' 	  => esc_html__('This header option includes sidebar menu and logo on the left, user options on the right. In middle have search input.', 'gowatch'),
									'options' => array(
										array(
											'name' 	=> esc_html__( 'Enable sticky header', 'gowatch' ),
											'field'	=> 'select',
											'id' 	=> 'header5_sticky',
											'options' => array(
												'n' => esc_html__( 'No', 'gowatch' ),
												'y' => esc_html__( 'Yes', 'gowatch' ),
											),
											'std'	=> 'n'
										)
									)
								),
							);
						?>

						<?php 
							foreach ( $total_options as $key => $header ) {
								?>
								<div class="header-options__<?php echo esc_attr( $key ); ?> <?php if ( $header_settings != $key ) echo 'hidden'; ?>">
								<h3><?php echo esc_html__('You selected ', 'gowatch') . esc_html( $header['name'] ) ; ?></h3>
								<span class="description"><?php echo esc_html( $header['desc'] ); ?></span>
								<?php
								foreach ( $header['options'] as $field ) {
									$field_value = isset($header_options[ $field['id'] ]) ? $header_options[ $field['id'] ] : '';
									call_user_func( array( 'airkit_Fields', $field['field'] ), $field, array( $field['id'] => $field_value ) );
								}
								?>
								</div>
								<?php
							}
						?>
						<div class="header-options__custom <?php if ( $header_settings != 'custom' ) echo 'hidden'; ?>">
							<?php
								$template_id = airkit_Template::get_template_info('header', 'id');
								$template_name = airkit_Template::get_template_info('header', 'name');
							 	echo self::gowatch_template_modals( 'header', $template_id, $template_name );
							?>
							<br/><br/>
							<?php airkit_layout_wrapper(airkit_Template::edit('header')); ?>
						</div>
					</div>
				</div>
				<input id="save-header-footer" data-location="header" type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_html_e('Save Changes', 'gowatch') ?>"/>
			</div>
		</div>
		<?php
	}

	/**
	 * Edit footer
	 */
	static function gowatch_footer()
	{
		?>
		<div class="wrap wrap-red">
			<div class="wrap-red-templates">
				<h2 class="main-headline"><?php esc_html_e('Footer', 'gowatch') ?></h2>
				<p class="headline-description">
					<?php esc_html_e('On this page you can edit your header settings and layouts. You can select from the predefined styles or click the custom build option to use the drag and drop builder to create your own.', 'gowatch'); ?>
				</p>
				<div class="footer-options">
					<div class="footer-options__predefined">
						<?php
							$footer_settings = airkit_option_value('footer_settings', 'predefined-style');
							$footer_options = airkit_option_value('footer_settings', 'options');
							$airkit_footer_styles = array(
								'name' => 'Choose your footer style',
								'desc' => 'Click to select the wanted footer style',
								'id' => 'predefined-style',
								'options' => array(
								    'style1' => 'Style 1',
								    'style2' => 'Style 2',
								    'style3' => 'Style 3',
								    'style4' => 'Style 4',
								    'style5' => 'Style 5',
								    'custom' => 'Custom designed',
								),
								'img' => array(
								    'style1' => 'footer_style1.png',
								    'style2' => 'footer_style2.png',
								    'style3' => 'footer_style3.png',
								    'style4' => 'footer_style4.png',
								    'style5' => 'footer_style5.png',
								    'custom' => 'header_custom.png',
								),
								'std' => 'style1',
							);

							echo airkit_Fields::img_selector( $airkit_footer_styles, array( 'predefined-style' => $footer_settings ) );
						?>
					</div>
					<div class="footer-options__list">
							<?php

								// footer 1 options
								$total_footers = array(
									'style1' => array( 
										'name' 	  => 'Footer 1',
										'desc' 	  => esc_html__('This footer option includes 3 sidebars (Footer 1, Footer 2 and Footer 3) with a dark background, a copyright text and social icons on the right.', 'gowatch'),
										'options' => array(
										)
									),
									'style2' => array(
										'name' 	  => 'Footer 2',
										'desc' 	  => esc_html__('This footer option includes 4 sidebars (Footer 1, Footer 2, Footer 3 and Footer 4) with a dark background, a copyright text and social icons on the right.', 'gowatch'),
										'options' => array(
										)
									),
									'style3' => array(
										'name' 		=> 'Footer 3',
										'desc' 		=> esc_html__('This footer option includes 2 sidebars (Footer 1 and Footer 2) with a dark background, a copyright text and social icons on the right.', 'gowatch'),
										'options' 	=> array(

										)
									),
									'style4' => array(
										'name' 		=> 'Footer 4',
										'desc' 		=> esc_html__('The minimalistic footer with Menu and copyright text aligned at center.', 'gowatch'),
										'options' 	=> array(

										)
									),
									'style5' => array(
										'name' 		=> 'Footer 5',
										'desc' 		=> esc_html__('The minimalistic footer with Menu and copyright text aligned at center.', 'gowatch'),
										'options' 	=> array(

										)
									)
								);
							?>

							<?php 
								foreach ( $total_footers as $key => $footer ) {
									?>
									<div class="footer-options__<?php echo esc_html( $key ); ?> <?php if ( $footer_settings != $key ) echo 'hidden'; ?>">
									<h3><?php echo esc_html__('You selected ', 'gowatch') . esc_html( $footer['name'] ) ; ?></h3>
									<span class="description"><?php echo esc_html( $footer['desc'] ); ?></span>
										<?php
											foreach ( $footer['options'] as $field ) {
												$field_value = isset( $footer_options[ $field['id'] ] ) ? $footer_options[ $field['id'] ] : '';
												call_user_func( array( 'airkit_Fields', $field['field'] ), $field, array( $field['id'] => $field_value ) );
											}
										?>
									</div>
									<?php
								}
							?>
							<div class="footer-options__custom <?php if ( $footer_settings != 'custom' ) echo 'hidden'; ?>">
								<?php
									$template_id = airkit_Template::get_template_info('footer', 'id');
									$template_name = airkit_Template::get_template_info('footer', 'name');
								 	echo self::gowatch_template_modals( 'footer', $template_id, $template_name );
								?>
								<br/><br/>
								<?php airkit_layout_wrapper(airkit_Template::edit('footer')); ?>
							</div>
					</div>
				</div>
				
				<input id="save-header-footer" data-location="footer" type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_html_e('Save Changes', 'gowatch') ?>"/>
			</div>
		</div>
		<?php
	}
}

new airkit_Options();

// End.