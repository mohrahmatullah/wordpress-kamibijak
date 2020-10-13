<?php
/**
 * Plugin Name: TouchCodes
 * Plugin URI: http://touchsize.com/
 * Description: This plugin adds custom posts types and shortcodes.
 * Version: 1.1.0
 * Author: TouchSize
 * Author URI: http://touchsize.com/
 * Text Domain: touchcodes
 * Domain Path: /languages
 * License: GPL2
 */

if ( !defined('TSS_THEMENAME') ) {
    define( 'TSS_THEMENAME', strtolower( wp_get_theme()->Name ) );
}

if ( !defined('TSS_URL') ) {
    define( 'TSS_URL', plugin_dir_url( __FILE__ ) );
}

if ( !function_exists( 'tsz_autoloader' ) ) {
    function tsz_autoloader( $class )
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . strtolower( str_replace( '_', '-', $class ) ) . '.php';

        if ( file_exists( $path ) ) {

            include( $path );
        }
    }
    spl_autoload_register( 'tsz_autoloader' );
}


new Ts_Custom_Post();

new Ts_Add_Shortcode();

new Ts_Layout_Compilator();

new Ts_Ajax_Shortcode();

add_action( 'admin_init', 'Ts_Init_Admin::init' );

if ( !function_exists( 'ts_enc_string' ) ) {
    function ts_enc_string( $string, $action = 'on' )
    {
        if ( $action == 'on' ) {

            return base64_encode( $string );

        } else {

            return base64_decode( $string );
        }
    }
}

/**
 * Contact form mail sending function that is called via ajax
 */
if ( !function_exists( 'airkit_contact_me' ) ) {
    // Contact form function that can be customized
    function airkit_contact_me() {

        check_ajax_referer( 'submit-contact-form', 'token' );

        header('Content-Type: application/json');

        $data = array(
            'status'  => 'ok',
            'message' => ''
        );

        $email = airkit_option_value( 'social', 'email' );

        $email = !empty( $email ) ? $email : get_option( 'admin_email' );

        $from         = !empty( $_POST['from'] ) ? $_POST['from'] : get_option( 'admin_email' );
        $subject      = @$_POST['subject'];
        $message      = @$_POST['message'];
        $name         = @$_POST['name'];
        $custom_field = (isset($_POST['custom_field']) && is_array($_POST['custom_field']) && !empty($_POST['custom_field'])) ? $_POST['custom_field'] : NULL;

        if ( $subject === '' ) {

            $subject = get_bloginfo('name') . esc_html__('Message from ', 'touchcodes') . wp_kses( $name, array());

        }

        if( class_exists( 'ReallySimpleCaptcha' ) ) {
            $isCapcha = true;
            $captcha_instance = new ReallySimpleCaptcha();

            $capchaCheck = $captcha_instance->check( $_POST['prefix'] , $_POST['airkit-captcha'] );

            $captcha_instance->remove( $_POST['prefix'] );

            if( !$capchaCheck ) {
                wp_send_json( array( 'status' => 'error', 'message' => esc_html__( 'Invalid capcha. Try again.' , 'touchcodes' ) ) );
            }
        }

        if ( is_email($email) && is_email($from) ) {

            if( isset( $custom_field ) ){

                foreach( $custom_field as $value ){

                    $message .= $value['title'] . ':' . $value['value'] . "\r\n";
                    if( $value['required'] == 'y' && $value['value'] == '' ){

                        $error_require = 'Mail not sent. This field "' . $value['title'] . '" is required';
                        $data = array(
                            'status'  => 'error',
                            'message' => $error_require,
                            'token' => wp_create_nonce("submit-contact-form")
                        );

                        echo json_encode($data);
                        die();
                    }
                }
            }

            $headers = 'From: '.esc_attr($name) . ' <'.$from.'>' . "\r\n";
            $sent = wp_mail($email, $subject, wp_kses($message, array()) ,$headers);

            if ( $sent ) {

                $data = array(
                    'status'  => 'ok',
                    'message' => esc_html__('Mail sent.', 'touchcodes'),
                    'token' => wp_create_nonce("submit-contact-form")
                );

            } else {

                $data = array(
                    'status'  => 'error',
                    'message' => esc_html__('Error. Mail not sent.', 'touchcodes'),
                    'token' => wp_create_nonce("submit-contact-form")
                );
            }

        } else {

            $data = array(
                'status'  => 'error',
                'message' => esc_html__('Invalid email adress', 'touchcodes'),
                'token' => wp_create_nonce("submit-contact-form")
            );
        }

        echo json_encode($data);
        die();
    }

    add_action('wp_ajax_airkit_contact_me', 'airkit_contact_me');
    add_action( 'wp_ajax_nopriv_airkit_contact_me', 'airkit_contact_me' );
}

/**
 * Function for checking captcha validation with ReallySimpleCaptcha Plugin
 */
if ( !function_exists( 'airkit_captcha' ) ) {
    function airkit_captcha( $return = 'all' ){

        if( class_exists( 'ReallySimpleCaptcha' ) ){
            $captcha_instance = new ReallySimpleCaptcha();
            $word = $captcha_instance->generate_random_word();
            $prefix = mt_rand();
            if( $return == 'img' ){
                echo '<img class="airkit-img-captcha" data-prefix="'. $prefix .'" src="'. esc_url( plugins_url( 'really-simple-captcha/tmp/'. $captcha_instance->generate_image( $prefix, $word ) ) ) .'">';
            }else{
            echo '<div class="airkit-captcha-container">';
                echo
                    '<span class="airkit-container-img-captcha">
                        <img class="airkit-img-captcha" data-prefix="'. $prefix .'" src="'. esc_url( plugins_url( 'really-simple-captcha/tmp/'. $captcha_instance->generate_image( $prefix, $word ) ) ) .'">
                    </span>
                    <span class="airkit-regenerate-captcha icon-restart"></span>
                    <input type="text" name="airkit-captcha" value="" class="airkit-captcha">';
            }
            echo '</div>';

        }else{
            return;
        }
    }
}


add_action( 'plugins_loaded', 'touchcodes_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.3
 */
function touchcodes_load_textdomain() {
    load_plugin_textdomain( 'touchcodes', false, basename( dirname( __FILE__ ) ) . '/languages/' ); 
}


if ( !function_exists( 'touchcodes_add_bar_menu' ) ) {

    add_action( 'admin_bar_menu', 'touchcodes_add_bar_menu', 999 );

    function touchcodes_add_bar_menu( $wp_admin_bar ) {

        $theme = get_option( 'airkit_last_active_theme', true );

        if ( 
             empty($theme)
             || ! is_super_admin()
             || ! is_object( $wp_admin_bar ) 
             || ! function_exists( 'is_admin_bar_showing' ) 
             || ! function_exists('ts_enc_string')
             || ! is_admin_bar_showing() ) {
            return;
        }
        /* Add Seaford Options menu to admin menu. */
        $wp_admin_bar->add_node( 
            array(
                'id'    => $theme . '_options',
                'title' => esc_html__( 'Theme Options', 'touchcodes' ),
                'href'  => home_url() . '/wp-admin/themes.php?page=' . $theme
            )
        );
        /* Add header and Footer submenus. */
        $wp_admin_bar->add_node( 
            array(
                'parent' => $theme . '_options',
                'id'     => $theme . '_header',
                'title'  => esc_html__( 'Header', 'touchcodes' ),
                'href'   => home_url() . '/wp-admin/themes.php?page=' . $theme . '_header'
            )
        );

        $wp_admin_bar->add_node( 
            array(
                'parent' => $theme . '_options',
                'id'     => $theme . '_footer',
                'title'  => esc_html__( 'Footer', 'touchcodes' ),
                'href'   => home_url() . '/wp-admin/themes.php?page=' . $theme . '_footer'
            )
        );    
     

        $wp_admin_bar->add_node( 
            array(
                'parent' => $theme . '_options',
                'id'     => $theme . '_separator',
                'title'  => esc_html__( '---------------', 'touchcodes' ),
                'href'   => '#'
            )
        );

        /* Add theme options Tabs */

        $tabs = array(
            'general'    => esc_html__( 'General', 'touchcodes' ),
            'styles'     => esc_html__( 'Styles', 'touchcodes' ),
            'colors'     => esc_html__( 'Colors', 'touchcodes' ),
            'sizes'      => esc_html__( 'Image sizes', 'touchcodes' ),
            'layout'     => esc_html__( 'Archive layouts', 'touchcodes' ),
            'typography' => esc_html__( 'Typography', 'touchcodes' ),
            'single'     => esc_html__( 'Single post', 'touchcodes' ),
            'social'     => esc_html__( 'Social', 'touchcodes' ),
            'sidebar'    => esc_html__( 'Add sidebars', 'touchcodes' ),
            'import'     => esc_html__( 'Import/Export', 'touchcodes' ),
            'advertising'=> esc_html__( 'Advertising', 'touchcodes' ),
            'update'     => esc_html__( 'Theme Update', 'touchcodes' ),
            'support'    => esc_html__( 'Support', 'touchcodes' ),
        );

        if ( class_exists('Ts_Custom_Post') ) {

            $tabs = array_merge( $tabs, array( 'css' => esc_html__( 'Custom CSS', 'touchcodes' ) ) );

        }

        foreach ( $tabs as $key => $value ) {
            $wp_admin_bar->add_node( 
                array(
                    'parent' => $theme . '_options',
                    'id'     => $theme . '_' . $key,
                    'title'  => $value,
                    'href'   => home_url() . '/wp-admin/themes.php?page=' . $theme . '&tab='. $key 
                )
            );         
        }
    }
}


/**
 * Description
 * @param type !function_exists('airkit_placeholder_lazy') 
 * @return type
 */
if( !function_exists('airkit_placeholder_lazy') ) {

    function airkit_placeholder_lazy( $width, $height, $placeholder_url, $placeholder_metadata )
    {
        return wp_calculate_image_srcset( array( $width, $height), $placeholder_url, $placeholder_metadata );
    }
}

// End.