<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
tszf will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login lost-password" id="tszf-lostpass-form">

	<?php TSZF_Login::init()->show_errors(); ?>
	<?php TSZF_Login::init()->show_messages(); ?>
    <div class="inside col-lg-12">
        <h4 class="form-title"><?php echo esc_html__( 'Lost Password', 'gowatch' ); ?></h4>
    </div>
	<form name="lostpasswordform" id="lostpasswordform" action="" method="post">
        <ul class="tszf-form">
            <li class="col-lg-12">
                <div class="tszf-label">
                    <label for="tszf-user_login"><?php _e( 'Username or E-mail:', 'gowatch' ); ?></label>
                </div>
                <div class="tszf-fields">
                    <input type="text" name="user_login" id="tszf-user_login" class="input" value="" size="20" />
                </div>
            </li>        

			<?php do_action( 'lostpassword_form' ); ?>

			<li class="submit col-lg-12">
				<input type="submit" name="wp-submit" id="wp-submit" value="<?php esc_attr_e( 'Get New Password', 'gowatch' ); ?>" />
				<input type="hidden" name="redirect_to" value="<?php echo TSZF_Login::get_posted_value( 'redirect_to' ); ?>" />
				<input type="hidden" name="tszf_reset_password" value="true" />
				<input type="hidden" name="action" value="lostpassword" />

				<?php wp_nonce_field( 'tszf_lost_pass' ); ?>
			</li>
		</ul>
	</form>

	<div class="col-lg-12"><?php echo TSZF_Login::init()->get_action_links( array( 'lostpassword' => false ) ); ?></div>
</div>
