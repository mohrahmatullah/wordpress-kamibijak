<?php

/**
 * Login and forgot password handler class
 *
 * @author TouchSize
 */
class TSZF_Login {

    private $login_errors = array();
    private $messages = array();

    private static $_instance;

    function __construct() {

        add_action( 'init', array($this, 'process_login') );
        add_action( 'init', array($this, 'process_logout') );
        add_action( 'init', array($this, 'process_reset_password') );

        add_action( 'init', array($this, 'wp_login_page_redirect') );
        add_action( 'init', array($this, 'activation_user_registration') );

        // URL filters
        add_filter( 'login_url', array($this, 'filter_login_url'), 10, 2 );
        add_filter( 'logout_url', array($this, 'filter_logout_url'), 10, 2 );
        add_filter( 'lostpassword_url', array($this, 'filter_lostpassword_url'), 10, 2 );
        add_filter( 'register_url', array($this, 'get_registration_url') );

        add_filter( 'authenticate', array($this, 'successfully_authenticate'), 30, 3 );
    }

    /**
     * Singleton object
     *
     * @return self
     */
    public static function init() {
        if ( !self::$_instance ) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Is override enabled
     *
     * @return boolean
     */
    function is_override_enabled() {
        $override = tszf_get_option( 'register_link_override', 'tszf_profile', 'off' );

        if ( $override !== 'on' ) {
            return false;
        }

        return true;
    }

    /**
     * Get action url based on action type
     *
     * @param string $action
     * @param string $redirect_to url to redirect to
     * @return string
     */
    function get_action_url( $action = 'login', $redirect_to = '' ) {
        
        $root_url = $this->get_login_url();

        switch ($action) {
            case 'resetpass':
                return add_query_arg( array('action' => 'resetpass'), $root_url );
                break;

            case 'lostpassword':
                return add_query_arg( array('action' => 'lostpassword'), $root_url );
                break;

            case 'register':
                return $this->get_registration_url();
                break;

            case 'logout':
                return wp_nonce_url( add_query_arg( array('action' => 'logout'), $root_url ), 'log-out' );
                break;

            default:
                if ( empty( $redirect_to ) ) {
                    return $root_url;
                }

                return add_query_arg( array('redirect_to' => urlencode( $redirect_to )), $root_url );
                break;
        }
    }

    /**
     * Get login page url
     *
     * @return boolean|string
     */
    function get_login_url() {

        // $page_id = tszf_get_option( 'login_page', 'tszf_profile', false );

        $page_id = get_frontend_registration_active_id();

        if ( !$page_id ) {
            return false;
        }

        $url = get_frontend_registration_url();

        return apply_filters( 'tszf_login_url', $url, $page_id );
    }

    /**
     * Get registration page url
     *
     * @return boolean|string
     */
    function get_registration_url( $register_url = null ) {
        $register_link_override = tszf_get_option('register_link_override','tszf_profile',false);
        $page_id = tszf_get_option( 'reg_override_page', 'tszf_profile', false );

        if( $register_link_override == 'off' ) {
            return $register_url;
        }

        if ( !$page_id ) {
            return false;
        }

        $url = get_permalink( $page_id );

        return apply_filters( 'tszf_register_url', $url, $page_id );
    }


    /**
     * Filter the login url with ours
     *
     * @param string $url
     * @param string $redirect
     * @return string
     */
    function filter_login_url( $url, $redirect ) {

        if ( !$this->is_override_enabled() ) {
            return $url;
        }

        return $this->get_action_url( 'login', $redirect );
    }


    /**
     * Filter the logout url with ours
     *
     * @param string $url
     * @param string $redirect
     * @return string
     */
    function filter_logout_url( $url, $redirect ) {

        if ( !$this->is_override_enabled() ) {
            return $url;
        }

        return $this->get_action_url( 'logout', $redirect );
    }


    /**
     * Filter the lost password url with ours
     *
     * @param string $url
     * @param string $redirect
     * @return string
     */
    function filter_lostpassword_url( $url, $redirect ) {

        if ( !$this->is_override_enabled() ) {
            return $url;
        }

        return $this->get_action_url( 'lostpassword', $redirect );
    }


    /**
     * Get actions links for displaying in forms
     *
     * @param array $args
     * @return string
     */
    function get_action_links( $args = array() ) {
        $defaults = array(
            'login' => true,
            'register' => true,
            'lostpassword' => true
        );

        $args = wp_parse_args( $args, $defaults );
        $links = array();

        if ( $args['login'] ) {
            $links[] = sprintf( '<a href="%s" class="loginform-trigger">%s</a>', $this->get_action_url( 'login' ), __( 'Log In', 'gowatch' ) );
        }

        //unneeded as much as we're having login on the same page as register.

        /*if ( $args['register'] ) {
            $links[] = sprintf( '<a href="%s">%s</a>', $this->get_action_url( 'register' ), __( 'Register', 'gowatch' ) );
        }*/

        if ( $args['lostpassword'] ) {
            $links[] = sprintf( '<a href="%s" class="lostpassword-trigger">%s</a>', $this->get_action_url( 'lostpassword' ), __( 'Lost Password', 'gowatch' ) );
        }

        return implode( ' | ', $links );
    }

    /**
     * Shows the login form
     *
     * @return string
     */
    function login_form() {

        $login_page = $this->get_login_url();

        if ( false === $login_page ) {
            return;
        }

        ob_start();

        if ( is_user_logged_in() ) {

            tszf_load_template( 'logged-in.php', array(
                'user' => wp_get_current_user()
            ) );
        } else {

            $action = isset( $_GET['action'] ) ? $_GET['action'] : 'login';

            $args = array(
                'action_url' => $login_page,
            );

            switch ($action) {
                case 'lostpassword':

                    $this->messages[] = __( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'gowatch' );

                    tszf_load_template( 'lost-pass-form.php', $args );
                    break;

                case 'rp':
                case 'resetpass':

                    if ( isset( $_GET['reset'] ) && $_GET['reset'] == 'true' ) {

                        printf( '<div class="tszf-message">' . __( 'Your password has been reset. %s', 'gowatch' ) . '</div>', sprintf( '<a href="%s">%s</a>', $this->get_action_url( 'login' ), __( 'Log In', 'gowatch' ) ) );
                        return;
                    } else {

                        $this->messages[] = __( 'Enter your new password below..', 'gowatch' );

                        tszf_load_template( 'reset-pass-form.php', $args );
                    }

                    break;

                default:

                    if ( isset( $_GET['checkemail'] ) && $_GET['checkemail'] == 'confirm' ) {
                        $this->messages[] = __( 'Check your e-mail for the confirmation link.', 'gowatch' );
                    }

                    if ( isset( $_GET['loggedout'] ) && $_GET['loggedout'] == 'true' ) {
                        $this->messages[] = __( 'You are now logged out.', 'gowatch' );
                    }

                    tszf_load_template( 'login-form.php', $args );

                    break;
            }
        }

        return ob_get_clean();
    }

    /**
     * Process login form
     *
     * @return void
     */
    function process_login() {
        if ( !empty( $_POST['tszf_login'] ) && !empty( $_POST['_wpnonce'] ) ) {
            $creds = array();

            if ( isset( $_POST['_wpnonce'] ) ) {
                wp_verify_nonce( $_POST['_wpnonce'], 'tszf_login_action' );
            }

            $validation_error = new WP_Error();
            $validation_error = apply_filters( 'tszf_process_login_errors', $validation_error, $_POST['log'], $_POST['pwd'] );

            if ( $validation_error->get_error_code() ) {
                $this->login_errors[] = '<strong>' . __( 'Error', 'gowatch' ) . ':</strong> ' . $validation_error->get_error_message();
                return;
            }

            if ( empty( $_POST['log'] ) ) {
                $this->login_errors[] = '<strong>' . __( 'Error', 'gowatch' ) . ':</strong> ' . __( 'Username is required.', 'gowatch' );
                return;
            }

            if ( empty( $_POST['pwd'] ) ) {
                $this->login_errors[] = '<strong>' . __( 'Error', 'gowatch' ) . ':</strong> ' . __( 'Password is required.', 'gowatch' );
                return;
            }

            if ( is_email( $_POST['log'] ) && apply_filters( 'tszf_get_username_from_email', true ) ) {
                $user = get_user_by( 'email', $_POST['log'] );

                if ( isset( $user->user_login ) ) {
                    $creds['user_login'] = $user->user_login;
                } else {
                    $this->login_errors[] = '<strong>' . __( 'Error', 'gowatch' ) . ':</strong> ' . __( 'A user could not be found with this email address.', 'gowatch' );
                    return;
                }
            } else {
                $creds['user_login'] = $_POST['log'];
            }

            $creds['user_password'] = $_POST['pwd'];
            $creds['remember'] = isset( $_POST['rememberme'] );
            $secure_cookie = is_ssl() ? true : false;
            $user = wp_signon( apply_filters( 'tszf_login_credentials', $creds ), $secure_cookie );

            if ( is_wp_error( $user ) ) {
                $this->login_errors[] = $user->get_error_message();
                return;
            } else {

                if ( !empty( $_POST['redirect_to'] ) ) {
                    $redirect = esc_url( $_POST['redirect_to'] );
                } elseif ( wp_get_referer() ) {
                    $redirect = esc_url( wp_get_referer() );
                } else {
                    $redirect = home_url( '/' );
                }

                wp_redirect( apply_filters( 'tszf_login_redirect', $redirect, $user ) );
                exit;
            }
        }
    }

    /**
     * Logout the user
     *
     * @return void
     */
    function process_logout() {
        if ( isset( $_GET['action'] ) && $_GET['action'] == 'logout' ) {

            if ( !$this->is_override_enabled() ) {
                return;
            }
            check_admin_referer('log-out');
            wp_logout();

            $redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : add_query_arg( array( 'loggedout' => 'true' ), $this->get_login_url() ) ;
            wp_safe_redirect( $redirect_to );
            exit();
        }
    }


    /**
     * Handle reset password form
     *
     * @return void
     */
    public function process_reset_password() {

        if ( ! isset( $_POST['tszf_reset_password'] ) ) {
            return;
        }

        // process lost password form
        if ( isset( $_POST['user_login'] ) && isset( $_POST['_wpnonce'] ) ) {
            wp_verify_nonce( $_POST['_wpnonce'], 'tszf_lost_pass' );

            if ( $this->retrieve_password() ) {
                $url = add_query_arg( array( 'checkemail' => 'confirm' ), $this->get_login_url() );
                wp_redirect( $url );
                exit;
            }
        }

        // process reset password form
        if ( isset( $_POST['pass1'] ) && isset( $_POST['pass2'] ) && isset( $_POST['key'] ) && isset( $_POST['login'] ) && isset( $_POST['_wpnonce'] ) ) {

            // verify reset key again
            $user = $this->check_password_reset_key( $_POST['key'], $_POST['login'] );

            if ( is_object( $user ) ) {

                // save these values into the form again in case of errors
                $args['key']   = $_POST['key'];
                $args['login'] = $_POST['login'];

                wp_verify_nonce( $_POST['_wpnonce'], 'tszf_reset_pass' );

                if ( empty( $_POST['pass1'] ) || empty( $_POST['pass2'] ) ) {
                    $this->login_errors[] = __( 'Please enter your password.', 'gowatch' );
                    return;
                }

                if ( $_POST[ 'pass1' ] !== $_POST[ 'pass2' ] ) {
                    $this->login_errors[] = __( 'Passwords do not match.', 'gowatch' );
                    return;
                }

                $errors = new WP_Error();

                do_action( 'validate_password_reset', $errors, $user );

                if ( $errors->get_error_messages() ) {
                    foreach ( $errors->get_error_messages() as $error ) {
                        $this->login_errors[] = $error;
                    }

                    return;
                }

                if ( ! $this->login_errors ) {

                    $this->reset_password( $user, $_POST['pass1'] );

                    do_action( 'tszf_customer_reset_password', $user );

                    wp_redirect( add_query_arg( 'reset', 'true', remove_query_arg( array( 'key', 'login' ) ) ) );
                    exit;
                }
            }

        }
    }


    /**
     * Handles sending password retrieval email to customer.
     *
     * @access public
     * @uses $wpdb WordPress Database object
     * @return bool True: when finish. False: on error
     */
    function retrieve_password() {
        global $wpdb;

        if ( empty( $_POST['user_login'] ) ) {

            $this->login_errors[] = __( 'Enter a username or e-mail address.', 'gowatch' );
            return;

        } elseif ( strpos( $_POST['user_login'], '@' ) && apply_filters( 'tszf_get_username_from_email', true ) ) {

            $user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );

            if ( empty( $user_data ) ) {
                $this->login_errors[] = __( 'There is no user registered with that email address.', 'gowatch' );
                return;
            }

        } else {

            $login = trim( $_POST['user_login'] );

            $user_data = get_user_by( 'login', $login );
        }

        do_action('lostpassword_post');

        if ( $this->login_errors ) {
            return false;
        }

        if ( ! $user_data ) {
            $this->login_errors[] = __( 'Invalid username or e-mail.', 'gowatch' );
            return false;
        }

        // redefining user_login ensures we return the right case in the email
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

        do_action('retrieve_password', $user_login);

        $allow = apply_filters('allow_password_reset', true, $user_data->ID);

        if ( ! $allow ) {

            $this->login_errors[] = __( 'Password reset is not allowed for this user', 'gowatch' );
            return false;

        } elseif ( is_wp_error( $allow ) ) {

            $this->login_errors[] = $allow->get_error_message();
            return false;
        }

        $key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login ) );

        if ( empty( $key ) ) {

            // Generate something random for a key...
            $key = wp_generate_password( 8, false );

            do_action('retrieve_password_key', $user_login, $user_email, $key);

            // Now insert the new md5 key into the db
            $wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user_login ) );
        }

        // Send email notification
        $this->email_reset_pass( $user_login, $user_email, $key );

        return true;
    }

    /**
     * Retrieves a user row based on password reset key and login
     *
     * @uses $wpdb WordPress Database object
     *
     * @access public
     * @param string $key Hash to validate sending user's password
     * @param string $login The user login
     * @return object|bool User's database row on success, false for invalid keys
     */
    function check_password_reset_key( $key, $login ) {
        global $wpdb;

        $key = preg_replace( '/[^a-z0-9]/i', '', $key );

        if ( empty( $key ) || ! is_string( $key ) ) {
            $this->login_errors[] = __( 'Invalid key', 'gowatch' );
            return false;
        }

        if ( empty( $login ) || ! is_string( $login ) ) {
            $this->login_errors[] = __( 'Invalid key', 'gowatch' );
            return false;
        }

        $user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login ) );

        if ( empty( $user ) ) {
            $this->login_errors[] = __( 'Invalid key', 'gowatch' );
            return false;
        }

        return $user;
    }

    /**
     * Successfull authenticate when enable email verfication in registration
     *
     * @param  object $user
     * @param  string $username
     * @param  string $password
     * @return object
     */
    function successfully_authenticate( $user, $username, $password ) {

        if ( !is_wp_error( $user ) ) {

            if ( $user->ID ) {

                $error = new WP_Error();
                if ( get_user_meta( $user->ID, '_tszf_user_active', true ) == '0' ) {
                    $error->add( 'acitve_user', sprintf( __( '<strong>Your account is not active.</strong><br>Please check your email for activation link.', 'gowatch' ) ) );
                    return $error;
                }
            }
        }

        return $user;
    }

    /**
     * Check in activation of user registration
     *
     */
    function activation_user_registration() {

        if ( !isset( $_GET['tszf_registration_activation'] ) && empty( $_GET['tszf_registration_activation'] ) ) {
            return;
        }

        if ( !isset( $_GET['id'] ) && empty( $_GET['id'] ) ) {
            return;
        }

        $user_id = intval( $_GET['id'] );
        $activation_key = $_GET['tszf_registration_activation'];

        if ( get_user_meta( $user_id, '_tszf_activation_key', true ) != $activation_key ) {
            return;
        }

        delete_user_meta( $user_id, '_tszf_user_active' );
        delete_user_meta( $user_id, '_tszf_activation_key' );

        // show activation message
        add_filter( 'wp_login_errors', array($this, 'user_activation_message') );
        wp_send_new_user_notifications( $user_id );

        do_action( 'tszf_user_activated', $user_id );
    }

    /**
     * Shows activation message on success to wp-login.php
     *
     * @return \WP_Error
     */
    function user_activation_message() {
        return new WP_Error( 'user-activated', __( 'Your account has been activated', 'gowatch' ), 'message' );
    }

    function wp_login_page_redirect() {
        global $pagenow;

        if ( ! is_admin() && $pagenow == 'wp-login.php' && isset( $_GET['action'] ) && $_GET['action'] == 'register' ) {

            if ( tszf_get_option( 'register_link_override', 'tszf_profile' ) != 'on' ) {
                return;
            }

            $reg_page = get_permalink( tszf_get_option( 'reg_override_page', 'tszf_profile' ) );
            wp_redirect( $reg_page );
            exit;
        }
    }

    /**
     * Handles resetting the user's password.
     *
     * @access public
     * @param object $user The user
     * @param string $new_pass New password for the user in plaintext
     * @return void
     */
    public function reset_password( $user, $new_pass ) {
        do_action( 'password_reset', $user, $new_pass );

        wp_set_password( $new_pass, $user->ID );

        wp_password_change_notification( $user );
    }

    /**
     * Email reset password link
     *
     * @param string $user_login
     * @param string $user_email
     * @param string $key
     */
    function email_reset_pass( $user_login, $user_email, $key ) {
        $reset_url = add_query_arg( array( 'action' => 'rp', 'key' => $key, 'login' => $user_login ), $this->get_login_url() );

        $message = __( 'Someone requested that the password be reset for the following account:', 'gowatch' ) . "\r\n\r\n";
        $message .= network_home_url( '/' ) . "\r\n\r\n";
        $message .= sprintf( __( 'Username: %s', 'gowatch' ), $user_login) . "\r\n\r\n";
        $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.', 'gowatch' ) . "\r\n\r\n";
        $message .= __( 'To reset your password, visit the following address:', 'gowatch' ) . "\r\n\r\n";
        $message .= '<' . $reset_url . ">\r\n";

        if ( is_multisite() ) {
            $blogname = $GLOBALS['current_site']->site_name;
        } else {
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        }

        $title = sprintf( __('[%s] Password Reset', 'gowatch'), $blogname );

        $title = apply_filters( 'retrieve_password_title', $title );
        $message = apply_filters( 'retrieve_password_message', $message, $key );

        if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
            wp_die( __('The e-mail could not be sent.', 'gowatch' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'gowatch' ) );
        }
    }

    /**
     * Show erros on the form
     *
     * @return void
     */
    function show_errors() {
        if ( $this->login_errors ) {
            foreach ($this->login_errors as $error) {
                echo '<div class="tszf-error">' . airkit_var_sanitize( $error, 'the_kses' )  . '</div>' ;
            }
        }
    }

    /**
     * Show messages on the form
     *
     * @return void
     */
    function show_messages() {
        if ( $this->messages ) {
            foreach ($this->messages as $message) {
                printf( '<div class="tszf-message">%s</div>', $message );
            }
        }
    }

    /**
     * Get a posted value for showing in the form field
     *
     * @param string $key
     * @return string
     */
    public static function get_posted_value( $key ) {
        if ( isset( $_REQUEST[$key] ) ) {
            return esc_attr( $_REQUEST[$key] );
        }

        return '';
    }

}