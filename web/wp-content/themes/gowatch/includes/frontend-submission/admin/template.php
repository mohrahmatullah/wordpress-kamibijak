<?php

/**
 * tszf Form builder template
 *
 * @package Touchsize Frontend Submission
 * @author TouchSize
 */
class TSZF_Admin_Template {

    static $input_name = 'tszf_input';
    static $cond_name = 'tszf_cond';

    /**
     * Legend of a form item
     *
     * @param string $title
     * @param array $values
     */
    public static function legend( $title = 'Field Name', $values = array(), $field_id = 0 ) {

        $field_label = $values ? ': <strong>' . $values['label'] . '</strong>' : '';
        $id          = isset( $values['id'] ) ? $values['id'] : '';
        ?>
        <div class="tszf-legend" title="<?php _e( 'Click and Drag to rearrange', 'gowatch' ); ?>">
            <input type="hidden" value="<?php echo airkit_var_sanitize( $id, 'esc_attr' ); ?>" name="tszf_input[<?php echo airkit_var_sanitize( $field_id, 'esc_attr' ); ?>][id]">
            <div class="tszf-label"><?php echo airkit_var_sanitize( $title . $field_label, 'the_kses' ); ?></div>
            <div class="tszf-actions">
                <a href="#" class="tszf-remove"><i class="icon-close"></i></a>
                <a href="#" class="tszf-toggle"><i class="icon-right"></i></a>
            </div>
        </div> <!-- .tszf-legend -->
        <?php
    }

    /**
     * Common Fields for a input field
     *
     * Contains required, label, meta_key, help text, css class name
     *
     * @param int $id field order
     * @param mixed $field_name_value
     * @param bool $custom_field if it a custom field or not
     * @param array $values saved value
     */
    public static function common( $id, $field_name_value = '', $custom_field = true, $values = array() ) {

        $tpl                 = '%s[%d][%s]';

        /** 
         * Set names for common inputs.
         * For each common input, generate a name with following template:
         * tszf_input[ $id ][ input_name ].
         * 
         */

        $required_name       = sprintf( $tpl, self::$input_name, $id, 'required' );
        $field_name          = sprintf( $tpl, self::$input_name, $id, 'name' );
        $label_name          = sprintf( $tpl, self::$input_name, $id, 'label' );
        $is_meta_name        = sprintf( $tpl, self::$input_name, $id, 'is_meta' );
        $help_name           = sprintf( $tpl, self::$input_name, $id, 'help' );
        $css_name            = sprintf( $tpl, self::$input_name, $id, 'css' );
        $cols_name           = sprintf( $tpl, self::$input_name, $id, 'columns' );
        $show_edit_name      = sprintf( $tpl, self::$input_name, $id, 'show_edit' );

        // Set values for common inputs.
        $required            = $values ? esc_attr( $values['required'] ) : 'yes';
        $label_value         = $values ? esc_attr( $values['label'] ) : '';
        $help_value          = $values ? stripslashes( $values['help'] ) : '';
        $css_value           = $values ? esc_attr( $values['css'] ) : '';
        $cols_value          = isset( $values['columns'] ) ? esc_attr( $values['columns'] ) : '12';
        $show_edit           = isset( $values['show_edit'] ) ? esc_attr( $values['show_edit'] ) : 'yes';


        /**
         * Hide field when editing post:
         *
         * Frontend:
         * If set to yes => is_admin || isset ( $_GET['pid'] ) => hide field.
         *
         * For Tabs:
         * If start tab was hidden for edit form, hide all fields inside tabs container
         * If new tab was hidden for edit form, hide fields inside this tab.
         * 
         * When saving post => If editing post, check if field was hidden in edit form, skip updating value for this field.
         *
         */


        if ( $custom_field && $values ) {

            $field_name_value = $values['name'];

        }
        ?>
        <div class="tszf-form-rows required-field">
            <label><?php _e( 'Required', 'gowatch' ); ?></label>

            <div class="tszf-form-sub-fields">
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $required_name, 'esc_attr' ); ?>" value="yes"<?php checked( $required, 'yes' ); ?>> <?php _e( 'Yes', 'gowatch' ); ?> </label>
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $required_name, 'esc_attr' ); ?>" value="no"<?php checked( $required, 'no' ); ?>> <?php _e( 'No', 'gowatch' ); ?> </label>
            </div>
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Field Label', 'gowatch' ); ?></label>
            <input type="text" data-type="label" name="<?php echo airkit_var_sanitize( $label_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $label_value, 'esc_attr' ); ?>" class="smallipopInput" title="<?php _e( 'Enter a title of this field', 'gowatch' ); ?>">
        </div> <!-- .tszf-form-rows -->

        <?php if ( $custom_field ) { ?>
            <div class="tszf-form-rows">
                <label><?php _e( 'Meta Key', 'gowatch' ); ?></label>
                <input type="text" data-type="name" name="<?php echo airkit_var_sanitize( $field_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $field_name_value, 'esc_attr' ); ?>" class="smallipopInput" title="<?php _e( 'Name of the meta key this field will save to', 'gowatch' ); ?>">
                <input type="hidden" name="<?php echo airkit_var_sanitize( $is_meta_name, 'esc_attr' ); ?>" value="yes">
            </div> <!-- .tszf-form-rows -->
        <?php } else { ?>

            <input type="hidden" data-type="name" name="<?php echo airkit_var_sanitize( $field_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $field_name_value, 'esc_attr' ); ?>">
            <input type="hidden" name="<?php echo airkit_var_sanitize( $is_meta_name, 'esc_attr' ); ?>" value="no">

        <?php } ?>

        <div class="tszf-form-rows">
            <label><?php _e( 'Help text', 'gowatch' ); ?></label>
            <textarea name="<?php echo airkit_var_sanitize( $help_name, 'esc_attr' ); ?>" class="smallipopInput" title="<?php _e( 'Give the user some information about this field', 'gowatch' ); ?>"><?php echo airkit_var_sanitize( $help_value, 'esc_attr' ); ?></textarea>
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'CSS Class Name', 'gowatch' ); ?></label>
            <input type="text" name="<?php echo airkit_var_sanitize( $css_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $css_value, 'esc_attr' ); ?>" class="smallipopInput" title="<?php _e( 'Add a CSS class name for this field', 'gowatch' ); ?>">
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows show-edit">
            <label><?php _e( 'Show this field when editing post', 'gowatch' ); ?></label>

            <div class="tszf-form-sub-fields">
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $show_edit_name, 'esc_attr' ); ?>" value="yes"<?php checked( $show_edit, 'yes' ); ?>> <?php _e( 'Yes', 'gowatch' ); ?> </label>
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $show_edit_name, 'esc_attr' ); ?>" value="no"<?php checked( $show_edit, 'no' ); ?>> <?php _e( 'No', 'gowatch' ); ?> </label>
            </div>
        </div> <!-- .tszf-form-rows -->

        <?php if( $values['input_type'] !== 'tab_content' ):  ?>
        <div class="tszf-form-rows">
            <label><?php _e( 'Select number of columns', 'gowatch' ); ?></label>            
            <select name="<?php echo esc_attr( $cols_name ); ?>">
                <option value="1"  <?php selected( $cols_value, '1' ) ?>> <?php echo esc_html__( 'Fullwidth', 'gowatch' ); ?> </option>
                <option value="2"  <?php selected( $cols_value, '2' ) ?>> <?php echo esc_html__( 'One half', 'gowatch' );  ?> </option>
                <option value="3"  <?php selected( $cols_value, '3' ) ?>> <?php echo esc_html__( 'One third', 'gowatch' ); ?> </option>
                <option value="4"  <?php selected( $cols_value, '4' ) ?>> <?php echo esc_html__( 'One forth', 'gowatch' ); ?> </option>
            </select>            
        </div> <!-- .tszf-form-rows -->
        <?php endif; ?>

        <?php
    }

    /**
     * Common fields for a text area
     *
     * @param int $id
     * @param array $values
     */
    public static function common_text( $id, $values = array() ) {
        $tpl               = '%s[%d][%s]';
        $placeholder_name  = sprintf( $tpl, self::$input_name, $id, 'placeholder' );
        $default_name      = sprintf( $tpl, self::$input_name, $id, 'default' );
        $size_name         = sprintf( $tpl, self::$input_name, $id, 'size' );

        $placeholder_value = $values ? esc_attr( $values['placeholder'] ) : '';
        $default_value     = $values ? esc_attr( $values['default'] ) : '';
        $size_value        = $values ? esc_attr( $values['size'] ) : '40';

        ?>
        <div class="tszf-form-rows">
            <label><?php _e( 'Placeholder text', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $placeholder_name, 'esc_attr' ); ?>" title="<?php esc_attr_e( 'Text for HTML5 placeholder attribute', 'gowatch' ); ?>" value="<?php echo airkit_var_sanitize( $placeholder_value, 'esc_attr' ); ?>" />
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Default value', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $default_name, 'esc_attr' ); ?>" title="<?php esc_attr_e( 'The default value this field will have', 'gowatch' ); ?>" value="<?php echo airkit_var_sanitize( $default_value, 'esc_attr' ); ?>" />
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Size', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $size_name, 'esc_attr' ); ?>" title="<?php esc_attr_e( 'Size of this input field', 'gowatch' ); ?>" value="<?php echo airkit_var_sanitize( $size_value, 'esc_attr' ); ?>" /> 
        </div> <!-- .tszf-form-rows -->
        <?php
    }

    /**
     * Common fields for a textarea
     *
     * @param int $id
     * @param array $values
     */
    public static function common_textarea( $id, $values = array() ) {
        $tpl = '%s[%d][%s]';
        $rows_name         = sprintf( $tpl, self::$input_name, $id, 'rows' );
        $cols_name         = sprintf( $tpl, self::$input_name, $id, 'cols' );
        $rich_name         = sprintf( $tpl, self::$input_name, $id, 'rich' );
        $placeholder_name  = sprintf( $tpl, self::$input_name, $id, 'placeholder' );
        $default_name      = sprintf( $tpl, self::$input_name, $id, 'default' );

        $rows_value        = $values ? esc_attr( $values['rows'] ) : '5';
        $cols_value        = $values ? esc_attr( $values['cols'] ) : '25';
        $rich_value        = $values ? esc_attr( $values['rich'] ) : 'no';
        $placeholder_value = $values ? esc_attr( $values['placeholder'] ) : '';
        $default_value     = $values ? esc_attr( $values['default'] ) : '';

        ?>
        <div class="tszf-form-rows">
            <label><?php _e( 'Rows', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $rows_name, 'esc_attr' ); ?>" title="Number of rows in textarea" value="<?php echo airkit_var_sanitize( $rows_value, 'esc_attr' ); ?>" />
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Columns', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $cols_name, 'esc_attr' ); ?>" title="Number of columns in textarea" value="<?php echo airkit_var_sanitize( $cols_value, 'esc_attr' ); ?>" />
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Placeholder text', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $placeholder_name, 'esc_attr' ); ?>" title="text for HTML5 placeholder attribute" value="<?php echo airkit_var_sanitize( $placeholder_value, 'esc_attr' ); ?>" />
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Default value', 'gowatch' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $default_name, 'esc_attr' ); ?>" title="the default value this field will have" value="<?php echo airkit_var_sanitize( $default_value, 'esc_attr' ); ?>" />
        </div> <!-- .tszf-form-rows -->

        <div class="tszf-form-rows">
            <label><?php _e( 'Textarea', 'gowatch' ); ?></label>

            <div class="tszf-form-sub-fields">
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $rich_name, 'esc_attr' ); ?>" value="no"<?php checked( $rich_value, 'no' ); ?>> <?php _e( 'Normal', 'gowatch' ); ?></label>
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $rich_name, 'esc_attr' ); ?>" value="yes"<?php checked( $rich_value, 'yes' ); ?>> <?php _e( 'Rich textarea', 'gowatch' ); ?></label>
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $rich_name, 'esc_attr' ); ?>" value="teeny"<?php checked( $rich_value, 'teeny' ); ?>> <?php _e( 'Teeny Rich textarea', 'gowatch' ); ?></label>
            </div>
        </div> <!-- .tszf-form-rows -->
        <?php
    }

    /**
     * Hidden field helper function
     *
     * @param string $name
     * @param string $value
     */
    public static function hidden_field( $name, $value = '' ) {
        printf( '<input type="hidden" name="%s" value="%s" />', self::$input_name . $name, $value );
    }

    /**
     * Displays a radio custom field
     *
     * @param int $field_id
     * @param string $name
     * @param array $values
     */
    public static function radio_fields( $field_id, $name, $values = array() ) {

        $selected_name    = sprintf( '%s[%d][selected]', self::$input_name, $field_id );
        $input_name       = sprintf( '%s[%d][%s]', self::$input_name, $field_id, $name );
        $input_value_name = sprintf( '%s[%d][%s]', self::$input_name, $field_id, $name.'_values' );

        $selected_value   = ( $values && isset( $values['selected'] ) ) ? $values['selected'] : '';
        ?>

        <label for="tszf-<?php echo airkit_var_sanitize( $name.'_'.$field_id, 'esc_attr' ); ?>" class="tszf-show-field-value">
            <input type="checkbox" class="tszf-value-handelar" id="tszf-<?php echo airkit_var_sanitize( $name . '_' . $field_id ); ?>"><?php _e( 'Show values', 'gowatch' ); ?>
        </label>

        <div class="tszf-option-label-value"><span><?php _e( 'Label', 'gowatch' ); ?></span><span class="tszf-option-value" style="display: none;"><?php _e( 'Value', 'gowatch' ); ?></span></div>
        <?php
        if ( $values && $values['options'] > 0 ) {
            foreach ($values['options'] as $key => $value) {
                ?>
                <div class="tszf-clone-field">
                    <input type="radio" name="<?php echo airkit_var_sanitize( $selected_name, 'esc_attr' ) ?>" value="<?php echo airkit_var_sanitize( $value, 'esc_attr' ); ?>" <?php checked( $selected_value, $value ); ?>>
                    <input type="text" data-type="option" name="<?php echo airkit_var_sanitize( $input_name, 'esc_attr' ); ?>[]" value="<?php echo airkit_var_sanitize( $value, 'esc_attr' ); ?>">
                    <input type="text" data-type="option_value" name="<?php echo airkit_var_sanitize( $input_value_name, 'esc_attr' ); ?>[]" value="<?php echo airkit_var_sanitize( $key, 'esc_attr' ); ?>" style="display:none;">

                    <?php self::remove_button(); ?>
                </div>
                <?php
            }

        } else {
            ?>
            <div class="tszf-clone-field">
                <input type="radio" name="<?php echo airkit_var_sanitize( $selected_name, 'esc_attr' ); ?>">
                <input type="text" data-type="option" name="<?php echo airkit_var_sanitize( $input_name, 'esc_attr' ); ?>[]" value="">
                <input type="text" data-type="option_value" name="<?php echo airkit_var_sanitize( $input_value_name, 'esc_attr' ); ?>[]" value="" style="display:none;">

                <?php self::remove_button(); ?>
            </div>
            <?php
        }
    }

    public static function conditional_field( $field_id, $con_fields = array() ) {

        do_action( 'tszf_conditional_field_render_hook', $field_id, $con_fields, 'TSZF_Admin_Template' );

    }


    /**
     * Displays a checkbox custom field
     *
     * @param int $field_id
     * @param string $name
     * @param array $values
     */
    public static function common_checkbox( $field_id, $name, $values = array() ) {

        $selected_name    = sprintf( '%s[%d][selected]', self::$input_name, $field_id );
        $input_name       = sprintf( '%s[%d][%s]', self::$input_name, $field_id, $name );
        $input_value_name = sprintf( '%s[%d][%s]', self::$input_name, $field_id, $name.'_values' );

        $selected_value   = ( $values && isset( $values['selected'] ) ) ? $values['selected'] : array();

        ?>
        <input type="checkbox" class="tszf-value-handelar" id="<?php echo airkit_var_sanitize( $name.'_'.$field_id, 'esc_attr' ); ?>">
            <label for="<?php echo airkit_var_sanitize( $name.'_'.$field_id, 'esc_attr' ); ?>"><?php _e('show values', 'gowatch'); ?></label>
        <div class="tszf-option-label-value"><span><?php _e( 'Label', 'gowatch' ); ?></span><span class="tszf-option-value" style="display: none;"><?php _e( 'Value', 'gowatch' ); ?></span></div>
        <?php
        if ( $values && $values['options'] > 0 ) {
            foreach ($values['options'] as $key => $value) {
                ?>
                <div class="tszf-clone-field">

                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $selected_name, 'esc_attr' ) ?>[]" value="<?php echo airkit_var_sanitize( $value, 'esc_attr' ); ?>"<?php echo in_array( $value, $selected_value ) ? ' checked="checked"' : ''; ?> />
                    <input type="text" data-type="option" name="<?php echo airkit_var_sanitize( $input_name, 'esc_attr' ); ?>[]" value="<?php echo airkit_var_sanitize( $value, 'esc_attr' ); ?>">
                    <input type="text" data-type="option_value" name="<?php echo airkit_var_sanitize( $input_value_name, 'esc_attr' ); ?>[]" value="<?php echo airkit_var_sanitize( $key, 'esc_attr' ); ?>" style="display:none;">
                    <?php self::remove_button(); ?>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="tszf-clone-field">
                <input type="checkbox" name="<?php echo airkit_var_sanitize( $selected_name, 'esc_attr' ); ?>[]">
                <input type="text" data-type="option" name="<?php echo airkit_var_sanitize( $input_name, 'esc_attr' ); ?>[]" value="">
                <input type="text" data-type="option_value" name="<?php echo airkit_var_sanitize( $input_value_name, 'esc_attr' ); ?>[]" value="" style="display:none;">

                <?php self::remove_button(); ?>
            </div>
            <?php
        }
    }

    /**
     * Add/remove buttons for repeatable fields
     *
     * @return void
     */
    public static function remove_button() {
        $add = TSZF_ASSET_URI .  '/images/add.png';
        $remove = TSZF_ASSET_URI .  '/images/remove.png';
        ?>
        <img style="cursor:pointer; margin:0 3px;" alt="add another choice" title="add another choice" class="tszf-clone-field" src="<?php echo airkit_var_sanitize( $add, 'esc_url' ); ?>">
        <img style="cursor:pointer;" class="tszf-remove-field" alt="remove this choice" title="remove this choice" src="<?php echo airkit_var_sanitize( $remove, 'esc_url' ); ?>">
        <?php
    }

    public static function get_buffered( $func, $field_id, $label ) {
        ob_start();

        self::$func( $field_id, $label );

        return ob_get_clean();
    }

    public static function text_field( $field_id, $label, $values = array() ) {

        ?>
        <li class="custom-field text_field">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'text_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function textarea_field( $field_id, $label, $values = array() ) {
        $word_restriction_name = sprintf( '%s[%d][word_restriction]', self::$input_name, $field_id );
        $word_restriction_value = isset( $values['word_restriction'] ) && is_numeric( $values['word_restriction'] ) ? $values['word_restriction'] : '';
        ?>
        <li class="custom-field textarea_field">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'textarea_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>
                <div class="tszf-form-rows">
                    <label><?php _e( 'Word Restriction', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $word_restriction_name, 'esc_attr' ) ?>" value="<?php echo airkit_var_sanitize( $word_restriction_value, 'esc_attr' ); ?>" title="<?php esc_attr_e( 'Numebr of words the author to be restricted in', 'gowatch' ); ?>" />
                        </label>
                    </div>
                </div>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function radio_field( $field_id, $label, $values = array() ) {
        ?>
        <li class="custom-field radio_field tszf-conditional">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'radio' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'radio_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Options', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields tszf-options">
                    <?php self::radio_fields( $field_id, 'options', $values ); ?>

                    </div> <!-- .tszf-form-sub-fields -->
                    <?php self::conditional_field( $field_id, $values ); ?>
                </div> <!-- .tszf-form-rows -->
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function checkbox_field( $field_id, $label, $values = array() ) {
        ?>
        <li class="custom-field checkbox_field tszf-conditional">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'checkbox' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'checkbox_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Options', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields tszf-options">
                    <?php self::common_checkbox( $field_id, 'options', $values ); ?>

                    </div> <!-- .tszf-form-sub-fields -->
                    <?php self::conditional_field( $field_id, $values ); ?>
                </div> <!-- .tszf-form-rows -->
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function dropdown_field( $field_id, $label, $values = array() ) {
        $first_name = sprintf( '%s[%d][first]', self::$input_name, $field_id );
        $first_value = $values ? $values['first'] : ' - select -';
        $help = esc_attr( __( 'First element of the select dropdown. Leave this empty if you don\'t want to show this field', 'gowatch' ) );
        ?>
        <li class="custom-field dropdown_field tszf-conditional">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'select' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'dropdown_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Select Text', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $first_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $first_value, 'esc_attr' ); ?>" title="<?php echo airkit_var_sanitize( $help, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Options', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields tszf-options">
                        <?php self::radio_fields( $field_id, 'options', $values ); ?>
                    </div> <!-- .tszf-form-sub-fields -->

                    <?php self::conditional_field( $field_id, $values ); ?>
                </div> <!-- .tszf-form-rows -->
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function multiple_select( $field_id, $label, $values = array() ) {
        $first_name = sprintf( '%s[%d][first]', self::$input_name, $field_id );
        $first_value = $values ? $values['first'] : ' - select -';
        $help = esc_attr( __( 'First element of the select dropdown. Leave this empty if you don\'t want to show this field', 'gowatch' ) );
        ?>
        <li class="custom-field multiple_select">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'multiselect' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'multiple_select' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Select Text', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $first_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $first_value, 'esc_attr' ); ?>" title="<?php echo airkit_var_sanitize( $help, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Options', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields tszf-options">
                        <?php self::radio_fields( $field_id, 'options', $values ); ?>
                    </div> <!-- .tszf-form-sub-fields -->

                    <?php self::conditional_field( $field_id, $values ); ?>
                </div> <!-- .tszf-form-rows -->
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function website_url( $field_id, $label, $values = array() ) {
        ?>
        <li class="custom-field website_url">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'url' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'website_url' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function email_address( $field_id, $label, $values = array() ) {
        ?>
        <li class="custom-field eamil_address">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'email' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'email_address' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function custom_html( $field_id, $label, $values = array() ) {
        $title_name  = sprintf( '%s[%d][label]', self::$input_name, $field_id );
        $html_name   = sprintf( '%s[%d][html]', self::$input_name, $field_id );
        $title_value = $values ? esc_attr( $values['label'] ) : '';
        $html_value  = $values ? esc_attr( $values['html'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'html' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'custom_html' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <label><?php _e( 'Title', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" title="Title of the section" name="<?php echo airkit_var_sanitize( $title_name, 'esc_attr' ); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'HTML Codes', 'gowatch' ); ?></label>
                    <textarea class="smallipopInput" title="Paste your HTML codes, WordPress shortcodes will also work here" name="<?php echo airkit_var_sanitize( $html_name, 'esc_attr' ); ?>" rows="10"><?php echo esc_html( $html_value ); ?></textarea>
                </div>

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function custom_hidden_field( $field_id, $label, $values = array() ) {
        $meta_name    = sprintf( '%s[%d][name]', self::$input_name, $field_id );
        $value_name   = sprintf( '%s[%d][meta_value]', self::$input_name, $field_id );
        $is_meta_name = sprintf( '%s[%d][is_meta]', self::$input_name, $field_id );
        $label_name   = sprintf( '%s[%d][label]', self::$input_name, $field_id );

        $meta_value   = $values ? esc_attr( $values['name'] ) : '';
        $value_value  = $values ? esc_attr( $values['meta_value'] ) : '';
        ?>
        <li class="custom-field custom_hidden_field">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'hidden' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'custom_hidden_field' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <label><?php _e( 'Meta Key', 'gowatch' ); ?></label>
                    <input type="text" name="<?php echo airkit_var_sanitize( $meta_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $meta_value, 'esc_attr' ); ?>" class="smallipopInput" title="<?php _e( 'Name of the meta key this field will save to', 'gowatch' ); ?>">
                    <input type="hidden" name="<?php echo airkit_var_sanitize( $is_meta_name, 'esc_attr' ); ?>" value="yes">
                    <input type="hidden" name="<?php echo airkit_var_sanitize( $label_name, 'esc_attr' ); ?>" value="">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Meta Value', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" title="<?php esc_attr_e( 'Enter the meta value', 'gowatch' ); ?>" name="<?php echo airkit_var_sanitize( $value_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $value_value, 'esc_attr' ); ?>">
                </div>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function section_break( $field_id, $label, $values = array() ) {
        $title_name        = sprintf( '%s[%d][label]', self::$input_name, $field_id );
        $description_name  = sprintf( '%s[%d][description]', self::$input_name, $field_id );

        $title_value       = $values ? esc_attr( $values['label'] ) : '';
        $description_value = $values ? esc_attr( $values['description'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'section_break' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'section_break' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <label><?php _e( 'Title', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" title="Title of the section" name="<?php echo airkit_var_sanitize( $title_name, 'esc_attr' ); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Description', 'gowatch' ); ?></label>
                    <textarea class="smallipopInput" title="Some details text about the section" name="<?php echo airkit_var_sanitize( $description_name, 'esc_attr' ); ?>" rows="3"><?php echo esc_html( $description_value ); ?></textarea>
                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    /**
     * Render image upload
     *
     * @param $field_id
     * @param $label
     * @param self
     * @param array $values
     */
    public static function image_upload( $field_id, $label, $values = array() ) {
        $max_size_name   = sprintf( '%s[%d][max_size]', self::$input_name, $field_id );
        $max_files_name  = sprintf( '%s[%d][count]', self::$input_name, $field_id );

        $max_size_value  = $values ? $values['max_size'] : '1024';
        $max_files_value = $values ? $values['count'] : '1';

        $help            = esc_attr( __( 'Enter maximum upload size limit in KB', 'gowatch' ) );
        $count           = esc_attr( __( 'Number of images can be uploaded', 'gowatch' ) );
        ?>
        <li class="custom-field image_upload">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'image_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'image_upload' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Max. file size', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $max_size_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $max_size_value, 'esc_attr' ); ?>" title="<?php echo airkit_var_sanitize( $help, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Max. files', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $max_files_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $max_files_value, 'esc_attr' ); ?>" title="<?php echo airkit_var_sanitize( $count, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }

}