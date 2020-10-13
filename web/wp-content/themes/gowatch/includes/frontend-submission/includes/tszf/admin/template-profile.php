<?php

/**
 * Profile related form templates
 *
 * @package Touchsize Frontend Submission
 */
class TSZF_Admin_Template_Profile extends TSZF_Admin_Template {

    public static function user_login( $field_id, $label, $values = array() ) {
        ?>
        <li class="user_login">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'user_login' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'user_login', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function first_name( $field_id, $label, $values = array() ) {
        ?>
        <li class="first_name">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'first_name' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'first_name', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function last_name( $field_id, $label, $values = array() ) {
        ?>
        <li class="last_name">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'last_name' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'last_name', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function nickname( $field_id, $label, $values = array() ) {
        ?>
        <li class="nickname">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'nickname' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'nickname', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function user_email( $field_id, $label, $values = array() ) {
        ?>
        <li class="user_email">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'email' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'user_email' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'user_email', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function user_url( $field_id, $label, $values = array() ) {
        ?>
        <li class="user_url">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'url' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'user_url' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'user_url', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function description( $field_id, $label, $values = array() ) {
        $word_restriction_name = sprintf( '%s[%d][word_restriction]', self::$input_name, $field_id );
        $word_restriction_value = isset( $values['word_restriction'] ) && is_numeric( $values['word_restriction'] ) ? $values['word_restriction'] : '';
        ?>
        <li class="user_bio">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'description' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'description', false, $values ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Word Restriction', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $word_restriction_name, 'true' ) ?>" value="<?php echo airkit_var_sanitize( $word_restriction_value, 'true' ); ?>" title="<?php esc_attr_e( 'Numebr of words the author to be restricted in', 'gowatch' ); ?>" />
                        </label>
                    </div>
                </div>

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function password( $field_id, $label, $values = array() ) {
        $min_length_name     = sprintf( '%s[%d][min_length]', self::$input_name, $field_id );
        $pass_repeat_name    = sprintf( '%s[%d][repeat_pass]', self::$input_name, $field_id );
        $pass_strength_name  = sprintf( '%s[%d][pass_strength]', self::$input_name, $field_id );
        $re_pass_label       = sprintf( '%s[%d][re_pass_label]', self::$input_name, $field_id );

        $min_length_value    = isset( $values['min_length'] ) ? $values['min_length'] : '6';
        $pass_repeat_value   = isset( $values['repeat_pass'] ) ? $values['repeat_pass'] : 'yes';
        $pass_strength_value = isset( $values['pass_strength'] ) ? $values['pass_strength'] : 'no';
        $re_pass_label_value = isset( $values['re_pass_label'] ) ? $values['re_pass_label'] : __( 'Confirm Password', 'gowatch' );
        ?>
        <li class="password">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'password' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'password' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'password', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Minimum password length', 'gowatch' ); ?></label>

                    <input type="text" name="<?php echo airkit_var_sanitize( $min_length_name, 'true' ) ?>" value="<?php echo esc_attr( $min_length_value ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Password Re-type', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][repeat_pass]", 'no' ); ?>
                            <input class="retype-pass" type="checkbox" name="<?php echo airkit_var_sanitize( $pass_repeat_name, 'true' ) ?>" value="yes"<?php checked( $pass_repeat_value, 'yes' ); ?> />
                            <?php _e( 'Require Password repeat', 'gowatch' ); ?>
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows<?php echo ( $pass_repeat_value != 'yes' ? ' tszf-hide' : '' ); ?>">
                    <label><?php _e( 'Re-type password label', 'gowatch' ); ?></label>

                    <input type="text" name="<?php echo airkit_var_sanitize( $re_pass_label, 'esc_attr' ); ?>" value="<?php echo esc_attr( $re_pass_label_value ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows<?php echo ( $pass_repeat_value != 'yes' ? ' tszf-hide' : '' ); ?>">
                    <label><?php _e( 'Password Strength Meter', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][pass_strength]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo airkit_var_sanitize( $pass_strength_name, 'esc_attr' ) ?>" value="yes"<?php checked( $pass_strength_value, 'yes' ); ?> />
                            <?php _e( 'Show password strength meter', 'gowatch' ); ?>
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function avatar( $field_id, $label, $values = array() ) {
        $max_file_name  = sprintf( '%s[%d][max_size]', self::$input_name, $field_id );
        $max_file_value = $values ? $values['max_size'] : '1024';
        $help           = esc_attr( __( 'Enter maximum upload size limit in KB', 'gowatch' ) );
        ?>
        <li class="user_avatar">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'image_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'avatar' ); ?>
            <?php self::hidden_field( "[$field_id][count]", '1' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'avatar', false, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Max. file size', 'gowatch' ); ?></label>
                    <input type="text" 
                           class="smallipopInput" 
                           name="<?php echo airkit_var_sanitize( $max_file_name, 'esc_attr' ); ?>" 
                           value="<?php echo airkit_var_sanitize( $max_file_value, 'esc_attr' ); ?>" 
                           title="<?php echo airkit_var_sanitize( $help, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

}