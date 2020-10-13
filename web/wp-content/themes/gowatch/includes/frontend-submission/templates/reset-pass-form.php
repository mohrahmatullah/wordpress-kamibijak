<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
tszf will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login" id="tszf-login-form">

    <?php TSZF_Login::init()->show_errors(); ?>
    <?php TSZF_Login::init()->show_messages(); ?>

	<form name="resetpasswordform" id="resetpasswordform" action="" method="post">
		<p>
			<label for="tszf-pass1"><?php _e( 'New password', 'gowatch' ); ?></label>
			<input autocomplete="off" name="pass1" id="tszf-pass1" class="input" size="20" value="" type="password" autocomplete="off" />
		</p>

		<p>
			<label for="tszf-pass2"><?php _e( 'Confirm new password', 'gowatch' ); ?></label>
			<input autocomplete="off" name="pass2" id="tszf-pass2" class="input" size="20" value="" type="password" autocomplete="off" />
		</p>

		<?php do_action( 'resetpassword_form' ); ?>

		<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit" value="<?php esc_attr_e( 'Reset Password', 'gowatch' ); ?>" />
			<input type="hidden" name="key" value="<?php echo TSZF_Login::get_posted_value( 'key' ); ?>" />
			<input type="hidden" name="login" id="user_login" value="<?php echo TSZF_Login::get_posted_value( 'login' ); ?>" />
			<input type="hidden" name="tszf_reset_password" value="true" />
		</p>

		<?php wp_nonce_field( 'tszf_reset_pass' ); ?>
	</form>
</div>
