<?php
/*
  If you would like to edit this file, copy it to your current theme's directory and edit it there.
  tszf will always look in your theme's directory first, before using this default template.
 */
?>
<div class="login login-form-inner" id="tszf-login-form">

    <?php
    $message = apply_filters( 'login_message', '' );
    if ( ! empty( $message ) ) {
        echo airkit_var_sanitize( $message . "\n", 'true' );
    }

    if ( isset( $_GET['checkemail'] ) && $_GET['checkemail'] === 'confirm' ) {
        esc_html_e( 'A confirmation email has been sent to your email address. Please check your mail and access the link.', 'gowatch' );
    }

    ?>

    <?php TSZF_Login::init()->show_errors(); ?>
    <?php TSZF_Login::init()->show_messages(); ?>
    <div class="inside col-lg-12">
        <h4 class="form-title"><?php echo esc_html__( 'Log In', 'gowatch' ); ?></h4>
    </div>
    <form name="loginform" class="tszf-login-form" id="loginform" action="<?php echo airkit_var_sanitize( $action_url, 'true' ); ?>" method="post">
        <ul class="tszf-form">

            <li class="col-lg-12">
                <div class="tszf-label">
                    <label for="tszf-user_login"><?php _e( 'Username', 'gowatch' ); ?></label>
                </div>
                <div class="tszf-fields">
                    <input type="text" name="log" id="tszf-user_login" class="input" value="" size="20" />
                </div>
            </li>
            

            <li class="col-lg-12">
                <div class="tszf-label">
                    <label for="tszf-user_pass"><?php _e( 'Password', 'gowatch' ); ?></label>                    
                </div>
                <div class="tszf-fields">
                    <input type="password" name="pwd" id="tszf-user_pass" class="input" value="" size="20" />
                </div>
            </li>

            <?php do_action( 'login_form' ); ?>

            <li class="forgetmenot col-lg-6">
                <div class="tszf-label">
                    <input name="rememberme" type="checkbox" id="tszf-rememberme" value="forever" />
                    <label for="tszf-rememberme"><?php esc_attr_e( 'Remember Me', 'gowatch' ); ?></label>
                </div>
                <?php echo TSZF_Login::init()->get_action_links( array( 'login' => false ) ); ?>
            </li>

            <li class="submit col-lg-6 text-right">
                <div class="tszf-fields">
                    <input type="submit" name="wp-submit" id="wp-submit" value="<?php esc_attr_e( 'Log In', 'gowatch' ); ?>" />
                    <input type="hidden" name="redirect_to" value="<?php echo TSZF_Login::get_posted_value( 'redirect_to' ); ?>" />
                    <input type="hidden" name="tszf_login" value="true" />
                    <input type="hidden" name="action" value="login" />
                    <?php wp_nonce_field( 'tszf_login_action' ); ?>
                </div>
            </li>
        </ul>
    </form>
</div>
