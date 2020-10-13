<?php

/**
 * Handles form generaton and posting for add/edit post in frontend
 *
 * @package Touchsize Frontend Submission
 */
class TSZF_Frontend_Form_Profile extends TSZF_Render_Form {

    private $before_form;
    private $before_form_inside;


    function __construct() {

        $this->before_form = '';
        $this->before_form_inside = '';

        // ajax requests
        add_action( 'wp_ajax_nopriv_tszf_submit_register', array($this, 'user_register') );
        add_action( 'wp_ajax_tszf_update_profile', array($this, 'update_profile') );
    }

    /**
     * Add post form handler
     *
     * @param array $atts
     * @return string
     */
    function form_handler( $atts ) {
        
        $id = 0;
        $type = 'registration';
        extract( $atts );

        ob_start();

        $form_vars = tszf_get_form_fields( $id );//get_post_meta( $id, self::$meta_key, true );

        $form_settings = tszf_get_form_settings( $id );

        if ( !$form_vars ) {
            return;
        }

        if ( $type == 'profile' ) {

            if ( is_user_logged_in() ) {

                if ( isset( $_GET['msg'] ) && $_GET['msg'] == 'profile_update' ) {
                    echo '<div class="tszf-success airkit_alert alert-success">';
                    echo airkit_var_sanitize( $form_settings['update_message'], 'true' );
                    echo '</div>';
                }

                $this->profile_edit( $id, $form_vars, $form_settings );

            } else {
                echo '<div class="tszf-info">' . __( 'Please login to update your profile!', 'gowatch' ) . '</div>';
            }
        } elseif ( $type == 'registration' ) {

            if ( is_user_logged_in() ) {

                echo '<div class="tszf-info">' . __( 'You are already logged in!', 'gowatch' ) . '</div>';

            } else {

                if ( get_option( 'users_can_register' ) != '1' ) {
                    echo '<div class="tszf-info">';
                    _e( 'User registration is currently not allowed.', 'gowatch' );
                    echo '</div>';
                    return;
                }
                // Render content before form outside.
                echo airkit_var_sanitize( $this->before_form, 'the_kses' );
                // Render the form.
                $this->profile_edit( $id, $form_vars, $form_settings );
            }
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Adds HTML before rendered form.
     * @param string $string Text that should be added before rendered form.
     * @param bool $inside Render content outsite or inside form.
     */
    function before_form( $string = '', $inside = false ) {

        if( $inside ){
            
            return $this->before_form_inside = '<div class="inside col-lg-12">' . $string . '</div>';

        }

        return $this->before_form = $string;

    }

    function profile_edit( $form_id, $form_vars, $form_settings ) {
        echo '<form class="tszf-form-add" action="" method="post">';
        echo airkit_var_sanitize( $this->before_form_inside, 'the_kses' );
        echo '<ul class="tszf-form">';

        do_action( 'tszf_add_profile_form_top', $form_id, $form_settings );

        $this->render_items( $form_vars, get_current_user_id(), 'user', $form_id, $form_settings );
        $this->submit_button( $form_id, $form_settings );
        echo '</ul>';
        echo '</form>';
    }

    function submit_button( $form_id, $form_settings, $post_id = 0 ) {

        // lets guess its a registration form
        // give the chance to fire action for default register form
        if ( !is_user_logged_in() ) {
            do_action('register_form');
        }

        ?>
        <li class="tszf-submit">
            <div class="tszf-label">
                &nbsp;
            </div>

            <?php wp_nonce_field( 'tszf_form_add' ); ?>
            <input type="hidden" name="form_id" value="<?php echo airkit_var_sanitize( $form_id, 'esc_attr' ); ?>">
            <input type="hidden" name="page_id" value="<?php echo get_the_ID(); ?>">

            <?php if ( is_user_logged_in() ) { ?>
                <input type="hidden" name="action" value="tszf_update_profile">
                <input type="submit" name="submit" value="<?php echo airkit_var_sanitize( $form_settings['update_text'], 'true' ); ?>" />
            <?php } else { ?>
                <input type="hidden" name="action" value="tszf_submit_register">
                <input type="submit" name="submit" value="<?php echo airkit_var_sanitize( $form_settings['submit_text'], 'true' ); ?>" />
            <?php } ?>
        </li>
        <?php
    }

    function user_register() {
        check_ajax_referer( 'tszf_form_add' );

        @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

        $form_id = isset( $_POST['form_id'] ) ? intval( $_POST['form_id'] ) : 0;
        $form_vars = $this->get_input_fields( $form_id );
        $form_settings = tszf_get_form_settings( $form_id );

        list( $user_vars, $taxonomy_vars, $meta_vars ) = $form_vars;

        // search if rs captcha is there
        if ( $this->search( $user_vars, 'input_type', 'really_simple_captcha' ) ) {
            $this->validate_rs_captcha();
        }


        $has_username_field = false;
        $username = '';
        $user_email = '';
        $firstname = '';
        $lastname = '';

        // don't let to be registered if no email address given
        if ( !isset( $_POST['user_email']) ) {
            $this->send_error( __( 'An Email address is required', 'gowatch' ) );
        }

        // if any username given, check if it exists
        if ( $this->search( $user_vars, 'name', 'user_login' )) {
            $has_username_field = true;
            $username = sanitize_user( trim( $_POST['user_login'] ) );

            if ( username_exists( $username ) ) {
                $this->send_error( __( 'Username already exists.', 'gowatch' ) );
            }
        }

        // if any email address given, check if it exists
        if ( $this->search( $user_vars, 'name', 'user_email' )) {
            $user_email = trim( $_POST['user_email'] );

            if ( email_exists( $user_email ) ) {
                $this->send_error( __( 'E-mail address already exists.', 'gowatch' ) );
            }
        }

        // if there isn't any username field in the form, lets guess a username
        if (!$has_username_field) {
            $username = $this->guess_username( $user_email );
        }

        if ( !validate_username( $username ) ) {
            $this->send_error( __( 'Username is not valid', 'gowatch' ) );
        }

        // verify password
        if ( $pass_element = $this->search($user_vars, 'name', 'password') ) {
            $pass_element = current( $pass_element );
            $password = $_POST['pass1'];
            $password_repeat = isset( $_POST['pass2'] ) ? $_POST['pass2'] : false;

            // min length check
            if ( strlen( $password ) < intval( $pass_element['min_length'] ) ) {
                $this->send_error( sprintf( __( 'Password must be %s character long', 'gowatch' ), $pass_element['min_length'] ) );
            }

            // repeat password check
            if ( ( $password != $password_repeat ) && $password_repeat !== false ) {
                $this->send_error( __( 'Password didn\'t match', 'gowatch' ) );
            }
        } else {
            $password = wp_generate_password();
        }

        // default WP registration hook
        $errors = new WP_Error();
        do_action( 'register_post', $username, $user_email, $errors );

        $errors = apply_filters( 'registration_errors', $errors, $username, $user_email );

        if ( $errors->get_error_code() ) {
            $this->send_error( $errors->get_error_message() );
        }

        // seems like we don't have any error. Lets register the user
        $user_id = wp_create_user( $username, $password, $user_email );

        if ( is_wp_error( $user_id ) ) {
            $this->send_error( $user_id->get_error_message() );

        } else {

            $userdata = array(
                'ID'          => $user_id,
                'first_name'  => $this->search( $user_vars, 'name', 'first_name' ) ? $_POST['first_name'] : '',
                'last_name'   => $this->search( $user_vars, 'name', 'last_name' ) ? $_POST['last_name'] : '',
                'nickname'    => $this->search( $user_vars, 'name', 'nickname' ) ? $_POST['nickname'] : '',
                'user_url'    => $this->search( $user_vars, 'name', 'user_url' ) ? $_POST['user_url'] : '',
                'description' => $this->search( $user_vars, 'name', 'description' ) ? $_POST['description'] : '',
                'role'        => $form_settings['role']
            );

            $user_id = wp_update_user( apply_filters( 'tszf_register_user_args', $userdata ) );

            if ( $user_id ) {

                // update meta fields
                $this->update_user_meta( $meta_vars, $user_id );

                // send user notification or email verification
                if ( isset( $form_settings['enable_email_verification'] ) && $form_settings['enable_email_verification'] != 'yes' ) {
                    wp_send_new_user_notifications( $user_id );
                } else {
                    $this->send_verification_mail( $user_id, $user_email );
                }

                do_action( 'tszf_after_register', $user_id, $userdata, $form_id, $form_settings );

                //redirect URL
                $show_message = false;
                $redirect_to = '';

                if ( $form_settings['redirect_to'] == 'page' ) {
                    $redirect_to = get_permalink( $form_settings['page_id'] );
                } elseif ( $form_settings['redirect_to'] == 'url' ) {
                    $redirect_to = $form_settings['url'];
                } elseif ( $form_settings['redirect_to'] == 'same' ) {
                    $show_message = true;
                } else {
                    $redirect_to = get_permalink( $post_id );
                }

                // send the response
                $response = array(
                    'success'      => true,
                    'post_id'      => $user_id,
                    'redirect_to'  => $redirect_to,
                    'show_message' => $show_message,
                    'message'      => ( isset( $form_settings['enable_email_verification'] ) && $form_settings['enable_email_verification'] == 'yes' )? __( 'Please check your email for activation link', 'gowatch' ) : $form_settings['message']
                );

                $autologin_after_registration = tszf_get_option( 'autologin_after_registration', 'tszf_profile' );

                if ( $autologin_after_registration == 'on' ) {
                    wp_set_current_user( $user_id );
                    wp_set_auth_cookie( $user_id );
                }

                $response = apply_filters( 'tszf_user_register_redirect', $response, $user_id, $userdata, $form_id, $form_settings );

                tszf_clear_buffer();
                echo json_encode( $response );
                exit;

            } // endif

        }

        tszf_clear_buffer();

        echo json_encode( array(
            'success' => false,
            'error' => __( 'Something went wrong', 'gowatch' )
        ) );

        exit;
    }

    /**
     * Send email verification link
     *
     * @param int|WP_Error $user_id
     * @param string $user_email
     */
    function send_verification_mail( $user_id, $user_email ) {

        $code = sha1( $user_id . $user_email . time() );
        $activation_link = add_query_arg( array('tszf_registration_activation' => $code, 'id' => $user_id), wp_login_url() );
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $message = sprintf( __( 'Congrats! You are Successfully registered to %s:', 'gowatch' ), $blogname ) . "\r\n\r\n";
        $message .= __( 'To activate your account, please click the link below', 'gowatch' ) . "\r\n\r\n";
        $message .= sprintf( __( '%s', 'gowatch' ), $activation_link ) . "\r\n";

        // update user meta
        add_user_meta( $user_id, '_tszf_activation_key', $code, true );
        add_user_meta( $user_id, '_tszf_user_active', 0, true);

        wp_mail( $user_email, sprintf(__('[%s] Account Activation', 'gowatch' ), $blogname), $message);
    }

    /**
     * Update user meta based on form inputs
     *
     * @param array $meta_vars
     * @param int $user_id
     */
    public static function update_user_meta( $meta_vars, $user_id ) {
        // prepare meta fields
        list( $meta_key_value, $multi_repeated, $files ) = self::prepare_meta_fields( $meta_vars );

        // set featured image if there's any
        if ( isset( $_POST['tszf_files']['avatar'] ) ) {
            $attachment_id = $_POST['tszf_files']['avatar'][0];

            tszf_update_avatar( $user_id, $attachment_id );
        }

        // save all custom fields
        foreach ($meta_key_value as $meta_key => $meta_value) {
            update_user_meta( $user_id, $meta_key, $meta_value );
        }

        // save any multicolumn repeatable fields
        foreach ($multi_repeated as $repeat_key => $repeat_value) {
            // first, delete any previous repeatable fields
            delete_user_meta( $user_id, $repeat_key );

            // now add them
            foreach ($repeat_value as $repeat_field) {
                add_user_meta( $user_id, $repeat_key, $repeat_field );
            }
        } //foreach

        // save any files attached
        foreach ($files as $file_input) {
            // delete any previous value
            delete_user_meta( $user_id, $file_input['name'] );

            //to track how many files are being uploaded
            $file_numbers = 0;

            foreach ($file_input['value'] as $attachment_id) {

                //if file numbers are greated than allowed number, prevent it from being uploaded
                if( $file_numbers >= $file_input['count'] ){
                    wp_delete_attachment( $attachment_id );
                    continue;
                }

                add_user_meta( $user_id, $file_input['name'], $attachment_id );

                $file_numbers++;
            }
        }
    }

    function update_profile() {
        check_ajax_referer( 'tszf_form_add' );

        @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

        $form_id = isset( $_POST['form_id'] ) ? intval( $_POST['form_id'] ) : 0;
        $form_vars = $this->get_input_fields( $form_id );
        $form_settings = tszf_get_form_settings( $form_id );

        list( $user_vars, $taxonomy_vars, $meta_vars ) = $form_vars;


        $user_id = get_current_user_id();
        $userdata = array('ID' => $user_id);
        $userinfo = get_userdata( $user_id );

        if ( $this->search( $user_vars, 'name', 'first_name' ) ) {
            $userdata['first_name'] = $_POST['first_name'];
        }

        if ( $this->search( $user_vars, 'name', 'last_name' ) ) {
            $userdata['last_name'] = $_POST['last_name'];
        }

        if ( $this->search( $user_vars, 'name', 'nickname' ) ) {
            $userdata['nickname'] = $_POST['nickname'];
        }

        if ( $this->search( $user_vars, 'name', 'user_url' ) ) {
            $userdata['user_url'] = $_POST['user_url'];
        }

        if ( $this->search( $user_vars, 'name', 'user_email' ) ) {
            $userdata['user_email'] = $_POST['user_email'];
        }

        if ( $this->search( $user_vars, 'name', 'description' ) ) {
            $userdata['description'] = $_POST['description'];
        }

        // check if Email filled out
        // verify Email
        if ( $userinfo->user_email != trim( $_POST['user_email'] ) ) {
            if( email_exists( trim( $_POST['user_email'] ) ) ) {
                $this->send_error( __( 'That E-mail already exists', 'gowatch' ) );
            }
        }
    
        // check if password filled out
        // verify password
        if ( $pass_element = $this->search($user_vars, 'name', 'password') ) {
            $pass_element = current( $pass_element );
            $password = $_POST['pass1'];
            $password_repeat = $_POST['pass2'];

            // check only if it's filled
            if ( $pass_length = strlen( $password) ) {

                // min length check
                if ( $pass_length < intval( $pass_element['min_length'] ) ) {
                    $this->send_error( sprintf( __( 'Password must be %s character long', 'gowatch' ), $pass_element['min_length'] ) );
                }

                // repeat password check
                if ( $password != $password_repeat ) {
                    $this->send_error( __( 'Password didn\'t match', 'gowatch' ) );
                }

                // seems like he want to change the password
                $userdata['user_pass'] = $password;
            }
        }

        $userdata = apply_filters( 'tszf_update_profile_vars', $userdata, $form_id, $form_settings );
        
        $user_id = wp_update_user( $userdata );

        if ( $user_id ) {
            // update meta fields
            $this->update_user_meta( $meta_vars, $user_id );

            do_action( 'tszf_update_profile', $user_id, $form_id, $form_settings );
        }

        //redirect URL
        $show_message = false;
        if ( $form_settings['redirect_to'] == 'page' ) {
            $redirect_to = get_permalink( $form_settings['page_id'] );
        } elseif ( $form_settings['redirect_to'] == 'url' ) {
            $redirect_to = $form_settings['url'];
        } elseif ( $form_settings['redirect_to'] == 'same' ) {
            $redirect_to = get_permalink( $_POST['page_id'] );
            $redirect_to = add_query_arg( array( 'msg' => 'profile_update' ), $redirect_to );
        }

        // send the response
        $response = array(
            'success' => true,
            'redirect_to' => $redirect_to,
            'show_message' => $show_message,
            'message' => $form_settings['update_message'],
        );

        $response = apply_filters( 'tszf_update_profile_resp', $response, $user_id, $form_id, $form_settings );

        tszf_clear_buffer();

        echo json_encode( $response );
        exit;
    }

}