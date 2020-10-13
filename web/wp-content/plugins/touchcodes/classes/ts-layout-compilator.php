<?php
/**
* This class is used for build a layout created in admin panel
*/
class Ts_Layout_Compilator
{

	static function touchcodes_send_form ( $user_email, $mail_subject = 'Sent from website' , $mail_body = '' )
	{
		// Just sent the email with the given data
		wp_mail( $user_email, $mail_subject, $mail_body );
	}
	
	static function touchcodes_contact_form ( $options )
	{
		?>
		<div class="col-lg-12">
			<form method="post" class="contact-form">
				<div class="row">
					<?php if ( $options['hide-icon'] == 'n' ): ?>
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="contact-form-icon">
							<i class="icon-mail"></i>
						</div>
					</div>
					<?php endif ?>
					<?php if ( $options['hide-name'] == 'n' ): ?>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<label><?php esc_html_e( 'Name', 'touchcodes' ); ?></label>
							<input type="text" name="contact-form-name" class="contact-form-name contact-form-require">
						</div>
					<?php endif; ?>

					<?php if ( $options['hide-email'] == 'n' ): ?>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<label><?php esc_html_e( 'Email', 'touchcodes' ); ?></label>
							<input type="text" name="contact-form-email" class="contact-form-email contact-form-require">
						</div>
					<?php endif; ?>
					<?php if ( $options['hide-subject'] == 'n' ): ?>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<label><?php esc_html_e( 'Subject', 'touchcodes' ); ?></label>
							<input type="text" name="contact-form-subject" class="contact-form-subject">
						</div>
					<?php endif ?>
					<?php if ( $options['hide-text'] == 'n' ): ?>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<label><?php esc_html_e( 'Text', 'touchcodes' ); ?></label>
							<textarea name="contact-form-text" class="contact-form-text"></textarea>
						</div>
					<?php endif; ?>

					<?php 	if( isset($options['items']) && is_array($options['items']) && ! empty($options['items']) ) :

						 		foreach( $options['items'] as $field ) :

							 		if( $field['type'] == 'select' ) :
							 			if( isset($field['options']) && !empty($field['options']) ) :
							 				$options_select = array_filter( explode( '/', $field['options'] ) );

							 				$html_option = '';
							 				foreach($options_select as $option){
							 					$html_option .= '<option value="'. $option .'">'. $option . '</option>';
							 				}?>
							 				<div class="col-lg-6 col-md-12 col-sm-12">
							 					<label><?php echo airkit_var_sanitize($field['title']); ?></label>
							 					<select class="ts_contact_custom_field form-control <?php if( $field['required'] == 'y' ) echo 'contact-form-require' ?>" name="custom_fields[select]" style="margin-bottom:20px">
							 						<?php echo airkit_var_sanitize($html_option); ?>
							 					</select>
							 					<input value="<?php echo airkit_var_sanitize($field['title']); ?>" type="hidden" name="custom_fields[title_select]">
							 					<input value="<?php echo airkit_var_sanitize($field['required']); ?>" type="hidden" name="custom_fields[require]">
							 				</div>
				<?php                   endif;
									endif;
									if( $field['type'] == 'input' ) : ?>
										<div class="col-lg-6 col-md-12 col-sm-12">
											<label><?php echo airkit_var_sanitize($field['title']); ?></label>
											<input type="text" name="custom_fields[content]"  class="ts_contact_custom_field <?php if( $field['required'] == 'y' ) echo 'contact-form-require'; ?>">
											<input value="<?php echo airkit_var_sanitize($field['title']); ?>" type="hidden" name="custom_fields[title_input]">
											<input value="<?php echo airkit_var_sanitize($field['required']); ?>" type="hidden" name="custom_fields[require]">
										</div>
				<?php				endif;
									if( $field['type'] == 'textarea' ) : ?>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<label><?php echo airkit_var_sanitize($field['title']); ?></label>
											<textarea name="custom_fields[<?php echo airkit_var_sanitize($field['title']); ?>]" class="ts_contact_custom_field <?php if( $field['required'] == 'y' ) echo 'contact-form-require' ?>"></textarea>
											<input value="<?php echo airkit_var_sanitize($field['title']); ?>" type="hidden" name="custom_fields[title_textarea]">
											<input value="<?php echo airkit_var_sanitize($field['required']); ?>" type="hidden" name="custom_fields[require]">
										</div>
				<?php				endif;
								endforeach;
							endif; ?>
					<div class="col-lg-12">
						<!-- <input type="button" value="<?php esc_html_e( 'Send', 'touchcodes' ); ?>" class="contact-form-submit"> -->
						<button type="button" class="contact-form-submit">
							<span class="send-text"> <?php esc_html_e( 'Send', 'touchcodes' ); ?> </span>
						</button>
					</div>
				</div>
				<div class="contact-form-messages"></div>
			</form>
		</div>
		<?php
	}

}

?>