<?php

class TSZF_form_element extends TSZF_Admin_Template_Post {

    /**
     * add formbuilder's custom field button
     */
    public static function add_form_custom_buttons() {
        $title = esc_attr( __( 'Click to add to the editor', 'gowatch' ) );
        ?>
        <button class="button" data-name="custom_repeater" data-type="repeat" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Repeat Field', 'gowatch' ); ?></button>
        <button class="button" data-name="custom_date" data-type="date" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Date', 'gowatch' ); ?></button>
        <button class="button" data-name="custom_image" data-type="image" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Image Upload', 'gowatch' ); ?></button>
        <button class="button" data-name="custom_file" data-type="file" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'File Upload', 'gowatch' ); ?></button>
        <button class="button" data-name="custom_map" data-type="map" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Google Maps', 'gowatch' ); ?></button>
        <button class="button" data-name="country_select" data-type="select" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Country List', 'gowatch' ); ?></button>
        <button class="button" data-name="numeric_field" data-type="text" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Numeric Field', 'gowatch' ); ?></button>
        <button class="button" data-name="address_field" data-type="text" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Address Field', 'gowatch' ); ?></button>
        <button class="button" data-name="step_start" data-type="text" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Step Start', 'gowatch' ); ?></button>

        <button class="button" data-name="tab_content" data-type="text" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Tab Content', 'gowatch' ); ?></button>

    <?php
    }

    /**
     * add formbuilder's button in Others section
     */
    public static function add_form_other_buttons() {
        $title = esc_attr( __( 'Click to add to the editor', 'gowatch' ) );
        ?>
        <button class="button" data-name="really_simple_captcha" data-type="rscaptcha" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Really Simple Captcha', 'gowatch' ); ?></button>
        <button class="button" data-name="action_hook" data-type="action" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Action Hook', 'gowatch' ); ?></button>
        <button class="button" data-name="toc" data-type="action" title="<?php echo airkit_var_sanitize( $title, 'true' ); ?>"><?php _e( 'Term &amp; Conditions', 'gowatch' ); ?></button>
    <?php
    }

    /**
     * Render form expiration tab
     */
    public static function render_form_expiration_tab() {
        global $post;

        $form_settings                = tszf_get_form_settings( $post->ID );
        $is_post_exp_selected         = isset( $form_settings['expiration_settings']['enable_post_expiration'] )?'checked':'';
        $time_value                   = isset( $form_settings['expiration_settings']['expiration_time_value'] )?$form_settings['expiration_settings']['expiration_time_value']:1;
        $time_type                    = isset( $form_settings['expiration_settings']['expiration_time_type'] )?$form_settings['expiration_settings']['expiration_time_type']:'day';
        $expired_post_status          = isset( $form_settings['expiration_settings']['expired_post_status'] )?$form_settings['expiration_settings']['expired_post_status']:'draft';
        $is_enable_mail_after_expired = isset( $form_settings['expiration_settings']['enable_mail_after_expired'] )?'checked':'';
        $post_expiration_message      = isset( $form_settings['expiration_settings']['post_expiration_message'] )?$form_settings['expiration_settings']['post_expiration_message']:'';
        ?>
        <table class="form-table">
            <tr>
                <th><?php _e( 'Post Expiration', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="checkbox" id="tszf-enable_post_expiration" name="tszf_settings[expiration_settings][enable_post_expiration]" value="on" <?php echo airkit_var_sanitize( $is_post_exp_selected, 'true' );?> />
                        <?php _e( 'Enable Post Expiration', 'gowatch' ); ?>
                    </label>
                </td>
            </tr>
            <tr class="tszf_expiration_field">
                <th><?php _e( 'Post Expiration Time', 'gowatch' ); ?></th>
                <td>
                    <?php
                    $timeType_array = array(
                        'year' => 100,
                        'month' => 12,
                        'day' => 30
                    );

                    ?>
                    <select name="tszf_settings[expiration_settings][expiration_time_value]" id="tszf-expiration_time_value">
                        <?php
                        for( $i = 1; $i <= $timeType_array[$time_type]; $i++ ){
                            ?>
                            <option value="<?php echo airkit_var_sanitize( $i, 'true' ); ?>" <?php echo ( $i == $time_value ? 'selected' : '' ); ?> ><?php echo airkit_var_sanitize( $i, 'true' );?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <select name="tszf_settings[expiration_settings][expiration_time_type]" id="tszf-expiration_time_type">
                        <?php
                        foreach( $timeType_array as $each_time_type=>$each_time_type_val ){
                            ?>
                            <option value="<?php echo airkit_var_sanitize( $each_time_type );?>" <?php echo ( $each_time_type == $time_type ? 'selected' : '' ); ?> ><?php echo ucfirst( $each_time_type ); ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="tszf_expiration_field">
                <th>
                    Post Status :
                </th>
                <td>
                    <?php $post_statuses = get_post_statuses();
                    ?>
                    <select name="tszf_settings[expiration_settings][expired_post_status]" id="tszf-expired_post_status">
                        <?php
                        foreach( $post_statuses as $post_status => $text ){
                            ?>
                            <option value="<?php echo airkit_var_sanitize( $post_status, 'true' ); ?>" <?php echo ( $expired_post_status == $post_status )?'selected':''; ?> ><?php echo airkit_var_sanitize( $text, 'true' );?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <p class="description"><?php echo _( 'Status of post after post expiration time is over ' ); ?></p>

                </td>
            </tr>
            <tr class="tszf_expiration_field">
                <th>
                    Send Mail :
                </th>
                <td>
                    <label>
                        <input type="checkbox" name="tszf_settings[expiration_settings][enable_mail_after_expired]" value="on" <?php echo airkit_var_sanitize( $is_enable_mail_after_expired, 'true' );?> />
                        <?php echo _( 'Send Email to Author After Exceeding Post Expiration Time' );?>
                    </label>
                </td>
            </tr>
            <tr class="tszf_expiration_field">
                <th>Post Expiration Message</th>
                <td>
                    <textarea name="tszf_settings[expiration_settings][post_expiration_message]" id="tszf-post_expiration_message" cols="50" rows="5"><?php echo airkit_var_sanitize( $post_expiration_message, 'true' ); ?></textarea>
                </td>
            </tr>
        </table>
    <?php
    }

    /**
     * Add form settings content
     * @param $form_settings
     * @param $post
     */
    public static function add_form_settings_content( $form_settings, $post ) {

        $is_multistep_enabled    = isset( $form_settings['enable_multistep'] ) ? $form_settings['enable_multistep'] : '';
        $multistep_progress_type = isset( $form_settings['multistep_progressbar_type'] ) ? $form_settings['multistep_progressbar_type'] : 'step_by_step';
        
        ?>

        <tr class="tszf_enable_multistep_section">
            <th><?php _e( 'Enable Multistep', 'gowatch' ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="tszf_settings[enable_multistep]" value="yes" <?php checked( $is_multistep_enabled, 'yes' ); ?> />
                    <?php _e( 'Enable Multistep', 'gowatch' ); ?>
                </label>

                <p class="description"><?php echo __( 'If checked, form will be displayed in frontend in multiple steps', 'gowatch' ); ?></p>
            </td>
        </tr>
        <tr class="tszf_multistep_content">
            <td colspan="2" style="padding: 15px 0;">
                <h3><?php _e( 'Multistep Form Settings', 'gowatch' ); ?></h3>
            </td>
        </tr>
        <tr class="tszf_multistep_progress_type tszf_multistep_content">
            <th><?php _e( 'Multistep Progressbar Type', 'gowatch' ); ?></th>
            <td>
                <label>
                    <select name="tszf_settings[multistep_progressbar_type]">
                        <option value="progressive" <?php echo ( $multistep_progress_type == 'progressive' ? 'selected' : '' );?>><?php _e( 'Progressbar', 'gowatch' ); ?></option>
                        <option value="step_by_step" <?php echo ( $multistep_progress_type == 'step_by_step' ? 'selected' : '' );?>><?php _e( 'Step by Step', 'gowatch' ); ?></option>
                    </select>
                </label>


                <p class="description"><?php echo __( 'Choose how you want the progressbar', 'gowatch' ); ?></p>
            </td>
        </tr>
    <?php
    }

    /**
     * Add content to post notification section
     */
    public static function add_post_notification_content() {
        global $post;

        $new_mail_body  = "Hi Admin,\r\n";
        $new_mail_body  .= "A new post has been created in your site %sitename% (%siteurl%).\r\n\r\n";

        $edit_mail_body = "Hi Admin,\r\n";
        $edit_mail_body .= "The post \"%post_title%\" has been updated.\r\n\r\n";

        $mail_body      = "Here is the details:\r\n";
        $mail_body      .= "Post Title: %post_title%\r\n";
        $mail_body      .= "Content: %post_content%\r\n";
        $mail_body      .= "Author: %author%\r\n";
        $mail_body      .= "Post URL: %permalink%\r\n";
        $mail_body      .= "Edit URL: %editlink%";

        $form_settings    = tszf_get_form_settings( $post->ID );

        $new_notificaton  = isset( $form_settings['notification']['new'] ) ? $form_settings['notification']['new'] : 'on';
        $new_to           = isset( $form_settings['notification']['new_to'] ) ? $form_settings['notification']['new_to'] : get_option( 'admin_email' );
        $new_subject      = isset( $form_settings['notification']['new_subject'] ) ? $form_settings['notification']['new_subject'] : __( 'New post created', 'gowatch' );
        $new_body         = isset( $form_settings['notification']['new_body'] ) ? $form_settings['notification']['new_body'] : $new_mail_body . $mail_body;

        $edit_notificaton = isset( $form_settings['notification']['edit'] ) ? $form_settings['notification']['edit'] : 'off';
        $edit_to          = isset( $form_settings['notification']['edit_to'] ) ? $form_settings['notification']['edit_to'] : get_option( 'admin_email' );
        $edit_subject     = isset( $form_settings['notification']['edit_subject'] ) ? $form_settings['notification']['edit_subject'] : __( 'A post has been edited', 'gowatch' );
        $edit_body        = isset( $form_settings['notification']['edit_body'] ) ? $form_settings['notification']['edit_body'] : $edit_mail_body . $mail_body;
        ?>

        <h3><?php _e( 'New Post Notificatoin', 'gowatch' ); ?></h3>

        <table class="form-table">
            <tr>
                <th><?php _e( 'Notification', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="hidden" name="tszf_settings[notification][new]" value="off">
                        <input type="checkbox" name="tszf_settings[notification][new]" value="on"<?php checked( $new_notificaton, 'on' ); ?>>
                        <?php _e( 'Enable post notification', 'gowatch' ); ?>
                    </label>
                </td>
            </tr>

            <tr>
                <th><?php _e( 'To', 'gowatch' ); ?></th>
                <td>
                    <input type="text" name="tszf_settings[notification][new_to]" class="regular-text" value="<?php echo esc_attr( $new_to ) ?>">
                </td>
            </tr>

            <tr>
                <th><?php _e( 'Subject', 'gowatch' ); ?></th>
                <td><input type="text" name="tszf_settings[notification][new_subject]" class="regular-text" value="<?php echo esc_attr( $new_subject ) ?>"></td>
            </tr>

            <tr>
                <th><?php _e( 'Message', 'gowatch' ); ?></th>
                <td>
                    <textarea rows="6" cols="60" name="tszf_settings[notification][new_body]"><?php echo esc_textarea( $new_body ) ?></textarea>
                </td>
            </tr>
        </table>

        <h3><?php _e( 'Update Post Notificatoin', 'gowatch' ); ?></h3>

        <table class="form-table">
            <tr>
                <th><?php _e( 'Notification', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="hidden" name="tszf_settings[notification][edit]" value="off">
                        <input type="checkbox" name="tszf_settings[notification][edit]" value="on"<?php checked( $edit_notificaton, 'on' ); ?>>
                        <?php _e( 'Enable post notification', 'gowatch' ); ?>
                    </label>
                </td>
            </tr>

            <tr>
                <th><?php _e( 'To', 'gowatch' ); ?></th>
                <td><input type="text" name="tszf_settings[notification][edit_to]" class="regular-text" value="<?php echo esc_attr( $edit_to ) ?>"></td>
            </tr>

            <tr>
                <th><?php _e( 'Subject', 'gowatch' ); ?></th>
                <td><input type="text" name="tszf_settings[notification][edit_subject]" class="regular-text" value="<?php echo esc_attr( $edit_subject ) ?>"></td>
            </tr>

            <tr>
                <th><?php _e( 'Message', 'gowatch' ); ?></th>
                <td>
                    <textarea rows="6" cols="60" name="tszf_settings[notification][edit_body]"><?php echo esc_textarea( $edit_body ) ?></textarea>
                </td>
            </tr>
        </table>

        <h3><?php _e( 'You may use in message:', 'gowatch' ); ?></h3>
        <p>
            <code>%post_title%</code>, <code>%post_content%</code>, <code>%post_excerpt%</code>, <code>%tags%</code>, <code>%category%</code>,
            <code>%author%</code>, <code>%author_email%</code>, <code>%author_bio%</code>, <code>%sitename%</code>, <code>%siteurl%</code>, <code>%permalink%</code>, <code>%editlink%</code>
            <br><code>%custom_{NAME_OF_CUSTOM_FIELD}%</code> e.g: <code>%custom_website_url%</code> for <code>website_url</code> meta field
        </p>

    <?php
    }

    /**
     * Render registration form
     */
    public static function render_registration_form() {

        global $post, $pagenow, $form_inputs;
        $form_inputs = tszf_get_form_fields( $post->ID );
        ?>
        <div style="margin-bottom: 10px">
            <button class="button tszf-collapse"><?php _e( 'Toggle All', 'gowatch' ); ?></button>
        </div>

        <div class="tszf-updated">
            <p><?php _e( 'Click on a form element to add to the editor', 'gowatch' ); ?></p>
        </div>

        <ul id="tszf-form-editor" class="tszf-form-editor unstyled">

            <?php

            if ($form_inputs) {
                $count = 0;
                foreach ($form_inputs as $order => $input_field) {
                    $method = $input_field['template'];
                    $name = ucwords( str_replace( '_', ' ', $input_field['template'] ) );

                    if ( method_exists( 'TSZF_Admin_Template_Profile', $method ) ) {
                        TSZF_Admin_Template_Profile::$method( $count, $name, $input_field );
                    } else {
                        do_action( 'tszf_admin_template_post_' . $input_field['template'], $name, $count, $input_field, 'TSZF_Admin_Template_Post', '' );
                    }

                    $count++;
                }
            }
            ?>
        </ul>
    <?php

    }

    /**
     * Render registration settings
     */
    public static function render_registration_settings() {
        global $post;

        $form_settings = tszf_get_form_settings( $post->ID );

        $email_verification = isset( $form_settings['enable_email_verification'] ) ? $form_settings['enable_email_verification'] : 'no';
        $role_selected      = isset( $form_settings['role'] ) ? $form_settings['role'] : 'subscriber';
        $redirect_to        = isset( $form_settings['redirect_to'] ) ? $form_settings['redirect_to'] : 'post';
        $message            = isset( $form_settings['message'] ) ? $form_settings['message'] : __( 'Registration successful', 'gowatch' );
        $update_message     = isset( $form_settings['update_message'] ) ? $form_settings['update_message'] : __( 'Profile updated successfully', 'gowatch' );
        $page_id            = isset( $form_settings['page_id'] ) ? $form_settings['page_id'] : 0;
        $url                = isset( $form_settings['url'] ) ? $form_settings['url'] : '';
        $submit_text        = isset( $form_settings['submit_text'] ) ? $form_settings['submit_text'] : __( 'Register', 'gowatch' );
        $update_text        = isset( $form_settings['update_text'] ) ? $form_settings['update_text'] : __( 'Update Profile', 'gowatch' );
        ?>
        <tr class="tszf-post-type">
            <th><?php _e( 'Enable Email Verfication', 'gowatch' ); ?></th>
            <td>
                <input type="hidden" name="tszf_settings[enable_email_verification]" value="no">
                <input type="checkbox" id="tszf-enable_email_verification" name="tszf_settings[enable_email_verification]" value="yes" <?php checked( $email_verification, 'yes' ); ?> > <label for="tszf-enable_email_verification">Enable Email Verification</label>
            </td>
        </tr>

        <tr class="tszf-post-type">
            <th><?php _e( 'New User Role', 'gowatch' ); ?></th>
            <td>
                <select name="tszf_settings[role]">
                    <?php
                    $user_roles = tszf_get_user_roles();
                    foreach ( $user_roles as $role => $label ) {
                        printf('<option value="%s"%s>%s</option>', $role, selected( $role_selected, $role, false ), $label );
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr class="tszf-redirect-to">
            <th><?php _e( 'Redirect To', 'gowatch' ); ?></th>
            <td>
                <select name="tszf_settings[redirect_to]">
                    <?php
                    $redirect_options = array(
                        'same' => __( 'Same Page', 'gowatch' ),
                        'page' => __( 'To a page', 'gowatch' ),
                        'url' => __( 'To a custom URL', 'gowatch' )
                    );

                    foreach ( $redirect_options as $to => $label ) {
                        printf('<option value="%s"%s>%s</option>', $to, selected( $redirect_to, $to, false ), $label );
                    }
                    ?>
                </select>
                <div class="description">
                    <?php _e( 'After successfull submit, where the page will redirect to', 'gowatch' ) ?>
                </div>
            </td>
        </tr>

        <tr class="tszf-same-page">
            <th><?php _e( 'Registration success message', 'gowatch' ); ?></th>
            <td>
                <textarea rows="3" cols="40" name="tszf_settings[message]"><?php echo esc_textarea( $message ); ?></textarea>
            </td>
        </tr>

        <tr class="tszf-same-page">
            <th><?php _e( 'Update profile message', 'gowatch' ); ?></th>
            <td>
                <textarea rows="3" cols="40" name="tszf_settings[update_message]"><?php echo esc_textarea( $update_message ); ?></textarea>
            </td>
        </tr>

        <tr class="tszf-page-id">
            <th><?php _e( 'Page', 'gowatch' ); ?></th>
            <td>
                <select name="tszf_settings[page_id]">
                    <?php
                    $pages = get_posts(  array( 'numberposts' => -1, 'post_type' => 'page') );

                    foreach ($pages as $page) {
                        printf('<option value="%s"%s>%s</option>', $page->ID, selected( $page_id, $page->ID, false ), esc_attr( $page->post_title ) );
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr class="tszf-url">
            <th><?php _e( 'Custom URL', 'gowatch' ); ?></th>
            <td>
                <input type="url" name="tszf_settings[url]" value="<?php echo esc_attr( $url ); ?>">
            </td>
        </tr>

        <tr class="tszf-submit-text">
            <th><?php _e( 'Submit Button text', 'gowatch' ); ?></th>
            <td>
                <input type="text" name="tszf_settings[submit_text]" value="<?php echo esc_attr( $submit_text ); ?>">
            </td>
        </tr>

        <tr class="tszf-update-text">
            <th><?php _e( 'Update Button text', 'gowatch' ); ?></th>
            <td>
                <input type="text" name="tszf_settings[update_text]" value="<?php echo esc_attr( $update_text ); ?>">
            </td>
        </tr>
    <?php
        self::add_form_settings_content( $form_settings , $post );
    }

    /**
     * Checks what the post type is
     * @param $post
     * @param $update
     */
    public static function check_post_type( $post, $update ) {
        if( get_post_type( $post->ID ) == 'tszf_profile' ){
            return;
        }
    }

    /**
     * Render custom taxonomies
     */
    public static function render_custom_taxonomies_element() {

        //$custom_taxonomies = get_taxonomies(array('_builtin' => false ) );
        $custom_taxonomies = get_taxonomies(array('_builtin' => false ), 'objects' );

        if( function_exists( 'wc_get_attribute_taxonomies' ) ) :
            $product_attributes = wc_get_attribute_taxonomies();
        else :
            $product_attributes = array();
            endif;


        $attr_name = array();
        foreach( $product_attributes as $attr ) {
            $attr_name[] = $attr->attribute_name;
        }
        //pri($custom_taxonomies);
        $form_settings = tszf_get_form_settings( get_the_ID() );

        if ( $custom_taxonomies ) {
            ?>
            <div class="tszf-taxonomies-holder">
                <?php
                $product_attr_tax = '';

                foreach ($custom_taxonomies as $tax_name => $tax) {
                    if ( strstr( $tax_name, 'pa_' ) && strpos( $tax_name, 'pa_' ) == 0 && in_array( 'product' , $tax->object_type ) && in_array( substr( $tax_name, 3 ) , $attr_name ) ) {
                        $product_attr_tax .= '<button class="tszf-custom-tax-btn button '.  implode( ' ', $tax->object_type  ).'" style="'. ( isset( $form_settings['post_type'] ) && !in_array( $form_settings['post_type'], $tax->object_type )?'display:none' : '' ).'" data-name="taxonomy" data-type="'.$tax_name.'" title="'.__( 'Click to add to the editor', 'gowatch' ).'">'.$tax_name.'</button>';
                    } else {
                        ?>
                        <button class="tszf-custom-tax-btn button <?php echo implode( ' ', $tax->object_type  )?>" style="<?php echo isset( $form_settings['post_type'] ) && !in_array( $form_settings['post_type'], $tax->object_type )?'display:none' : ''; ?>" data-name="taxonomy" data-type="<?php echo airkit_var_sanitize( $tax_name, 'true' ); ?>" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php echo airkit_var_sanitize( $tax_name, 'true' ); ?></button>
                    <?php
                    }

                }
                ?>
                <div class="attributes_holder product" style="<?php echo isset( $form_settings['post_type'] ) && !in_array( $form_settings['post_type'], $tax->object_type )?'display:none' : ''; ?>">
                    <h2>Product Attributes</h2>
                    <?php echo airkit_var_sanitize( $product_attr_tax, 'true' ); ?>
                </div>
            </div>
            <?php
        } else {
            _e('No custom taxonomies found', 'gowatch');
        }
    }

    /**
     * Render conditional logic
     * @param $field_id
     * @param $con_fields
     * @param $obj
     */
    public static function render_conditional_field( $field_id, $con_fields, $obj ) {
        global $form_inputs;

        $cond_name = 'tszf_cond';

        $con_fields_value = isset( $con_fields['tszf_cond'] ) ? $con_fields['tszf_cond'] : array();
        $tpl              = '%s[%d][%s]';
        $enable_name      = sprintf( $tpl, $cond_name, $field_id, 'condition_status' );
        $field_name       = sprintf( '%s[%d][cond_field][]', $cond_name, $field_id );
        $operator_name    = sprintf( '%s[%d][cond_operator][]', $cond_name, $field_id );
        $option_name      = sprintf( '%s[%d][cond_option][]', $cond_name, $field_id );
        $logic_name       = sprintf( '%s[%d][cond_logic]', $cond_name, $field_id );

        // $enable_value = 'yes';
        $class = '';

        // var_dump($field_id, $con_fields);

        $enable_value = isset( $con_fields_value['condition_status'] ) ? $con_fields_value['condition_status'] : 'no';
        $logic_value  = isset( $con_fields_value['cond_logic'] ) ? $con_fields_value['cond_logic'] : 'all';
        $class        = ($enable_value == 'yes') ? '' : ' tszf-hide';
        ?>
        <div class="tszf-form-rows">
            <label><?php _e( 'Conditional Logic', 'gowatch' ); ?></label>

            <div class="tszf-form-sub-fields">
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $enable_name, 'true' ); ?>" class="tszf-conditional-enable" value="yes"<?php checked( $enable_value, 'yes' ); ?>> <?php _e( 'Yes', 'gowatch' ); ?></label>
                <label><input type="radio" name="<?php echo airkit_var_sanitize( $enable_name, 'true' ); ?>" class="tszf-conditional-enable" value="no"<?php checked( $enable_value, 'no' ); ?>> <?php _e( 'No', 'gowatch' ); ?></label>

                <div class="conditional-rules-wrap<?php echo airkit_var_sanitize( $class, 'true' ); ?>">
                    <table class="">
                        <?php
                        if ($enable_value == 'yes') {

                            //var_dump( $form_inputs );
                            //$form_fields = get_post_meta( $post->ID, 'tszf_form', true );

                            $cond_fields = TSZF_Admin_Form::get_conditional_fields( $form_inputs );

                            $field_dropdown = TSZF_Admin_Form::get_conditional_fields_dropdown( $cond_fields['fields'] );

                            foreach ($con_fields_value['cond_field'] as $key => $field) {
                                $cond_fields['options'][$field] = isset( $cond_fields['options'][$field] ) ? $cond_fields['options'][$field] : array();

                                $option_dropdown = TSZF_Admin_Form::get_conditional_option_dropdown( $cond_fields['options'][$field] );

                                ?>
                                <tr>
                                    <td>
                                        <select name="<?php echo airkit_var_sanitize( $field_name, 'true' ); ?>" class="tszf-conditional-fields">
                                            <?php echo tszf_dropdown_helper($field_dropdown, $con_fields_value['cond_field'][$key]); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="<?php echo airkit_var_sanitize( $operator_name, 'true' ); ?>" class="">
                                            <option value="=" <?php selected($con_fields_value['cond_operator'][$key], '=') ;?>>is equal to</option>
                                            <option value="!=" <?php selected($con_fields_value['cond_operator'][$key], '!=') ;?>>is not equal to</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="<?php echo airkit_var_sanitize( $option_name, 'true' ); ?>" class="tszf-conditional-fields-option">
                                            <?php
                                            if ( array_key_exists( $field, $cond_fields['options'] ) ) {
                                                echo tszf_dropdown_helper( $option_dropdown, $con_fields_value['cond_option'][$key] );
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <a class="button tszf-conditional-plus" href="#">+</a>
                                        <a class="button tszf-conditional-minus" href="#">-</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td>
                                    <select name="<?php echo airkit_var_sanitize( $field_name, 'true' ); ?>" class="tszf-conditional-fields">
                                        <option value="">- select -</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="<?php echo airkit_var_sanitize( $operator_name, 'true' ); ?>" class="">
                                        <option value="=">is equal to</option>
                                        <option value="!=">is not equal to</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="<?php echo airkit_var_sanitize( $option_name, 'true' ); ?>" class="tszf-conditional-fields-option">
                                        <option value="">- select -</option>
                                    </select>
                                </td>
                                <td>
                                    <a class="button tszf-conditional-plus" href="#">+</a>
                                    <a class="button tszf-conditional-minus" href="#">-</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>


                    <div class="">
                        Show this field when
                        <select name="<?php echo airkit_var_sanitize( $logic_name, 'true' ); ?>">
                            <option value="all"<?php selected( $logic_value, 'all') ;?>>all</option>
                            <option value="any"<?php selected( $logic_value, 'any') ;?>>any</option>
                        </select>
                        these rules are met
                    </div>
                </div>
            </div>
        </div> <!-- .tszf-form-rows -->
    <?php

    }


    /**
     * Render repeat field
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     *
     */
    public static function repeat_field( $field_id, $label, $classname , $values = array() ) {

        $tpl = '%s[%d][%s]';

        $placeholder_name   = sprintf( $tpl, self::$input_name, $field_id, 'placeholder' );
        $default_name       = sprintf( $tpl, self::$input_name, $field_id, 'default' );
        $size_name          = sprintf( $tpl, self::$input_name, $field_id, 'size' );

        $placeholder_value  = $values ? esc_attr( $values['placeholder'] ) : '';
        $default_value      = $values ? esc_attr( $values['default'] ) : '';
        $size_value         = $values ? esc_attr( $values['size'] ) : '40';
        ?>
        <li class="custom-field custom_repeater">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'repeat' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'repeat_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Placeholder text', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $placeholder_name, 'true' ); ?>" title="text for HTML5 placeholder attribute" value="<?php echo airkit_var_sanitize( $placeholder_value, 'true' ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Default value', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $default_name, 'true' ); ?>" title="the default value this field will have" value="<?php echo airkit_var_sanitize( $default_value, 'true' ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Size', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $size_name, 'true' ); ?>" title="Size of this input field" value="<?php echo airkit_var_sanitize( $size_value, 'true' ); ?>" />
                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }


    /**
     * Render date field
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     */
    public static function date_field( $field_id, $label, $classname, $values = array() ) {
        $format_name  = sprintf( '%s[%d][format]', self::$input_name, $field_id );
        $time_name    = sprintf( '%s[%d][time]', self::$input_name, $field_id );

        $format_value = $values ? $values['format'] : 'dd/mm/yy';
        $time_value   = $values ? $values['time'] : 'no';

        $publish_time_name = sprintf( '%s[%d][is_publish_time]', self::$input_name, $field_id );
        $publish_time_value = $values ? $values['is_publish_time'] : 'no';

        $enable_past_time = sprintf( '%s[%d][enable_past_time]', self::$input_name, $field_id );
        $enable_past_time_value = $values ? $values['enable_past_time'] : 'no';

        $help         = esc_attr( __( 'The date format', 'gowatch' ) );
        ?>
        <li class="custom-field custom_image">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'date' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'date_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Date Format', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $format_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $format_value, 'true' ); ?>" title="<?php echo airkit_var_sanitize( $help, 'true' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Time', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][time]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo airkit_var_sanitize( $time_name, 'esc_attr' ) ?>" value="yes"<?php checked( $time_value, 'yes' ); ?> />
                            <?php _e( 'Enable time input', 'gowatch' ); ?>
                        </label>
                    </div>

                </div> <!-- .tszf-form-rows -->
                <div class="tszf-form-rows">
                    <label><?php _e( 'Is Publish Time ? : ', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][is_publish_time]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo airkit_var_sanitize( $publish_time_name, 'true' ) ?>" value="yes"<?php checked( $publish_time_value, 'yes' ); ?> />
                            <?php _e( 'Set this as publish time input', 'gowatch' ); ?>
                        </label>
                    </div>

                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Enable past time selection ?', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][enable_past_time]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo airkit_var_sanitize( $enable_past_time, 'true' ) ?>" value="yes"<?php checked( $enable_past_time_value, 'yes' ); ?> />
                            <?php _e( 'If enabled, it will allow to select past times from the current dates', 'gowatch' ); ?>
                        </label>
                    </div>

                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }


    /**
     * Render file upload field
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     */
    public static function file_upload( $field_id, $label, $classname, $values = array() ) {
        $max_size_name    = sprintf( '%s[%d][max_size]', self::$input_name, $field_id );
        $max_files_name   = sprintf( '%s[%d][count]', self::$input_name, $field_id );
        $extensions_name  = sprintf( '%s[%d][extension][]', self::$input_name, $field_id );

        $max_size_value   = $values ? $values['max_size'] : '1024';
        $max_files_value  = $values ? $values['count'] : '1';
        $extensions_value = $values ? $values['extension'] : array('images', 'audio', 'video');

        $extesions        = tszf_allowed_extensions();

        // var_dump($extesions);

        $help  = esc_attr( __( 'Enter maximum upload size limit in KB', 'gowatch' ) );
        $count = esc_attr( __( 'Number of images can be uploaded', 'gowatch' ) );
        ?>
        <li class="custom-field custom_image">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'file_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'file_upload' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Max. file size', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo airkit_var_sanitize( $max_size_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $max_size_value, 'true' ); ?>" title="<?php echo airkit_var_sanitize( $help, 'true' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Max. files', 'gowatch' ); ?></label>
                    <input type="text"
                           class="smallipopInput"
                           name="<?php echo airkit_var_sanitize( $max_files_name, 'esc_attr' ); ?>"
                           value="<?php echo airkit_var_sanitize( $max_files_value, 'esc_attr' ); ?>"
                           title="<?php echo airkit_var_sanitize( $count, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Allowed Files', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <?php foreach ($extesions as $key => $value) {
                            ?>
                            <label>
                                <input type="checkbox"
                                       name="<?php echo airkit_var_sanitize( $extensions_name, 'true' ); ?>"
                                       value="<?php echo airkit_var_sanitize( $key, 'true' ); ?>"<?php echo in_array( $key, $extensions_value ) ? ' checked="checked"' : ''; ?>>
                                <?php printf( '%s (%s)', $value['label'], str_replace( ',', ', ', $value['ext'] ) ) ?>
                            </label> <br />
                        <?php } ?>
                    </div>
                </div> <!-- .tszf-form-rows -->
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }


    /**
     * Render google map
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     */
    public static function google_map( $field_id, $label, $classname, $values = array() ) {
        $zoom_name         = sprintf( '%s[%d][zoom]', self::$input_name, $field_id );
        $address_name      = sprintf( '%s[%d][address]', self::$input_name, $field_id );
        $default_pos_name  = sprintf( '%s[%d][default_pos]', self::$input_name, $field_id );
        $show_lat_name     = sprintf( '%s[%d][show_lat]', self::$input_name, $field_id );

        $zoom_value        = $values ? $values['zoom'] : '12';
        $address_value     = $values ? $values['address'] : 'yes';
        $show_lat_value    = $values ? $values['show_lat'] : 'no';
        $default_pos_value = $values ? $values['default_pos'] : '40.7143528,-74.0059731';

        $zoom_help         = esc_attr( __( 'Set the map zoom level', 'gowatch' ) );
        $pos_help          = esc_attr( __( 'Enter default latitude and longitude to center the map', 'gowatch' ) );
        ?>
        <li class="custom-field custom_image">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'map' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'google_map' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Zoom Level', 'gowatch' ); ?></label>
                    <input type="text"
                           class="smallipopInput"
                           name="<?php echo airkit_var_sanitize( $zoom_name, 'true' ); ?>"
                           value="<?php echo airkit_var_sanitize( $zoom_value, 'true' ); ?>"
                           title="<?php echo airkit_var_sanitize( $zoom_help, 'true' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Default Co-ordinate', 'gowatch' ); ?></label>
                    <input type="text"
                           class="smallipopInput"
                           name="<?php  echo airkit_var_sanitize( $default_pos_name, 'esc_attr' ); ?>"
                           value="<?php echo airkit_var_sanitize( $default_pos_value, 'esc_attr' ); ?>"
                           title="<?php echo airkit_var_sanitize( $pos_help, 'esc_attr' ); ?>">
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Address Button', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][address]", 'no' ); ?>
                            <input type="checkbox"
                                   name="<?php echo airkit_var_sanitize( $address_name, 'esc_attr' ) ?>"
                                   value="yes"<?php checked( $address_value, 'yes' ); ?> />
                            <?php _e( 'Show address find button', 'gowatch' ); ?>
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Show Latitude/Longitude', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][show_lat]", 'no' ); ?>
                            <input type="checkbox"
                                   name="<?php echo airkit_var_sanitize( $show_lat_name, 'esc_attr' ) ?>"
                                   value="yes"<?php checked( $show_lat_value, 'yes' ); ?> />
                            <?php _e( 'Show latitude and longitude input box value', 'gowatch' ); ?>
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }

    /**
     * [country_list_field description]
     *
     * @param  int  $field_id
     * @param  string  $label
     * @param  array   $values
     *
     * @return void
     */
    public static function country_list_field( $field_id, $label, $classname, $values = array() ) {
        $country_list_name       = sprintf( '%s[%d][country_list]', self::$input_name, $field_id );
        $country_list_value      = isset( $values['country_list'] )? $values['country_list'] : '';

        $first_name              = sprintf( '%s[%d][country_list][name]', self::$input_name, $field_id );
        $first_value             = isset($values['country_list']['name']) ? $values['country_list']['name'] : ' - select -';
        $help                    = esc_attr( __( 'The country to be selected by default.', 'gowatch' ) );
        $hide_country_list_name  = sprintf( '%s[%d][country_list][country_select_hide_list][]', self::$input_name, $field_id );
        $hide_country_list_value = isset( $values['country_list']['country_select_hide_list'] )? $values['country_list']['country_select_hide_list'] : '';
        $show_country_list_name  = sprintf( '%s[%d][country_list][country_select_show_list][]', self::$input_name, $field_id );
        $show_country_list_value = isset( $values['country_list']['country_select_show_list'] )? $values['country_list']['country_select_show_list'] : '';
        $country_list_visibility_opt_name  = sprintf( '%s[%d][country_list][country_list_visibility_opt_name]', self::$input_name, $field_id );
        $country_list_visibility_opt_value = isset( $values['country_list']['country_list_visibility_opt_name'] )? $values['country_list']['country_list_visibility_opt_name'] : '';
        ?>
        <li class="custom-field dropdown_field tszf-conditional">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'country_list' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'country_list_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Default Country', 'gowatch' ); ?></label>

                    <select class="smallipopInput"
                            name="<?php  echo airkit_var_sanitize( $first_name, 'esc_attr' ); ?>"
                            value="<?php echo airkit_var_sanitize( $first_value, 'esc_attr' ); ?>"
                            title="<?php echo airkit_var_sanitize( $help, 'esc_attr' ); ?>">

                    </select>

                    <script>
                        var field_name = '<?php echo airkit_var_sanitize( $first_name, 'true' );?>';
                        var sel_country = '<?php echo airkit_var_sanitize( $first_value, 'true' ); ?>';//'<?php echo !empty( $value ) ? $value : '' ; ?>';
                        var countries = window.tszf_countries_list;
                        var option_string = '<option value="">Select Country</option>';
                        for (country in countries) {
                            option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                        }
                        jQuery('select[name="'+ field_name +'"]').html(option_string);
                    </script>
                    <!---->

                </div> <!-- .tszf-form-rows -->

                <?php
                $param = array(
                    'names_to_hide' => array(
                        'name' => $hide_country_list_name,
                        'value' => $hide_country_list_value
                    ),
                    'names_to_show' => array(
                        'name' => $show_country_list_name,
                        'value' => $show_country_list_value
                    ),
                    'option_to_chose' => array(
                        'name' => $country_list_visibility_opt_name,
                        'value' => $country_list_visibility_opt_value
                    )
                );
                self::render_drop_down_portion($param);
                ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }

    /**
     * Render parameter fields for numeric text field
     *
     * @param $field_id
     * @param $label field label
     * @param $values
     */
    public static function numeric_text_field( $field_id, $label,$classname, $values = array() ) {
        $step_text_field_name  = sprintf( '%s[%d][step_text_field]', self::$input_name, $field_id );
        $step_text_field_value = isset( $values['step_text_field'] )? $values['step_text_field'] : 1;
        $min_value_field_name  = sprintf( '%s[%d][min_value_field]', self::$input_name, $field_id );
        $min_value_field_value = isset( $values['min_value_field'] )? $values['min_value_field'] : 0;
        $max_value_field_name  = sprintf( '%s[%d][max_value_field]', self::$input_name, $field_id );
        $max_value_field_value = isset( $values['max_value_field'] )? $values['max_value_field'] : 100;
        ?>
        <li class="custom-field text_field">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'numeric_text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'numeric_text_field' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Step', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <input type="text"
                                   name="<?php  echo airkit_var_sanitize( $step_text_field_name, 'true' ); ?>"
                                   value="<?php echo airkit_var_sanitize( $step_text_field_value, 'true' ); ?>" />
                        </label>
                    </div>
                </div>
                <div class="tszf-form-rows">
                    <label><?php _e( 'Min Value', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <input type="text"
                                   name="<?php  echo airkit_var_sanitize( $min_value_field_name, 'true' ); ?>"
                                   value="<?php echo airkit_var_sanitize( $min_value_field_value, 'true' ); ?>" />
                        </label>
                    </div>
                </div>
                <div class="tszf-form-rows">
                    <label><?php _e( 'Max Value', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <input type="text"
                                   name="<?php  echo airkit_var_sanitize( $max_value_field_name, 'true' ); ?>"
                                   value="<?php echo airkit_var_sanitize( $max_value_field_value, 'true' ); ?>" />
                        </label>
                    </div>
                </div>
            </div> <!-- .tszf-form-holder -->


        </li>
    <?php
    }

    /**
     * Render parameter fields for address field
     *
     * @param $field_id
     * @param $label
     * @param $values
     *
     */
    public static function address_field( $field_id, $label, $classname, $values = array() ) {
        $address_desc_name                 = sprintf( '%s[%d][address_desc]', self::$input_name, $field_id );
        $address_desc_value                = isset( $values['address_desc'] )? $values['address_desc'] : '';

        //street address
        $street_address_name               = sprintf( '%s[%d][address][street_address]', self::$input_name, $field_id );
        $street_address_checkbox_name      = sprintf( '%s[%d][address][street_address][checked]', self::$input_name, $field_id );
        $street_address_checkbox_value     = isset( $values['address']['street_address']['checked'] )? $values['address']['street_address']['checked'] : 'checked';
        $street_address_ischecked          = $street_address_checkbox_value ? esc_attr( $street_address_checkbox_value ) : '';
        $street_address_label              = sprintf( '%s[%d][address][street_address][label]', self::$input_name, $field_id );
        $street_address_label_value        = isset( $values['address']['street_address']['label'] )? $values['address']['street_address']['label'] : __( 'Address Line 1', 'gowatch' );
        $street_address_value_name         = sprintf( '%s[%d][address][street_address][value]', self::$input_name, $field_id );
        $street_address_value_default      = isset( $values['address']['street_address']['value'] )? $values['address']['street_address']['value'] : '';
        $street_address_placeholder_name   = sprintf( '%s[%d][address][street_address][placeholder]', self::$input_name, $field_id );
        $street_address_placeholder_value  = isset( $values['address']['street_address']['placeholder'] )? $values['address']['street_address']['placeholder'] : '';
        $street_address_field_type         = sprintf( '%s[%d][address][street_address][type]', self::$input_name, $field_id );
        $street_address_field_type_value   = 'text';
        $street_address_req                = sprintf( '%s[%d][address][street_address][required]', self::$input_name, $field_id );
        $street_address_req_value          = isset( $values['address']['street_address']['required'] )? $values['address']['street_address']['required'] : 'checked';

        //street address 2
        $street_address2_name              = sprintf( '%s[%d][address][street_address2]', self::$input_name, $field_id );
        $street_address2_checkbox_name     = sprintf( '%s[%d][address][street_address2][checked]', self::$input_name, $field_id );
        $street_address2_checkbox_value    = isset( $values['address']['street_address2']['checked'] )? $values['address']['street_address2']['checked'] : 'checked';
        $street_address2_ischecked         = $street_address2_checkbox_value ? esc_attr( $street_address2_checkbox_value ) : '';
        $street_address2_label             = sprintf( '%s[%d][address][street_address2][label]', self::$input_name, $field_id );
        $street_address2_label_value       = isset( $values['address']['street_address2']['label'] )? $values['address']['street_address2']['label'] : __( 'Address Line 2', 'gowatch' );
        $street_address2_value_name        = sprintf( '%s[%d][address][street_address2][value]', self::$input_name, $field_id );
        $street_address2_value_default     = isset( $values['address']['street_address2']['value'] )? $values['address']['street_address2']['value'] : '';
        $street_address2_placeholder_name  = sprintf( '%s[%d][address][street_address2][placeholder]', self::$input_name, $field_id );
        $street_address2_placeholder_value = isset( $values['address']['street_address2']['placeholder'] )? $values['address']['street_address2']['placeholder'] : '';
        $street_address2_field_type        = sprintf( '%s[%d][address][street_address2][type]', self::$input_name, $field_id );
        $street_address2_field_type_value  = 'text';
        $street_address2_req               = sprintf( '%s[%d][address][street_address2][required]', self::$input_name, $field_id );
        $street_address2_req_value         = isset( $values['address']['street_address2']['required'] )? $values['address']['street_address2']['required'] : '';
        //city name

        $city_name                         = sprintf( '%s[%d][address][city_name]', self::$input_name, $field_id );
        $city_checkbox_name                = sprintf( '%s[%d][address][city_name][checked]', self::$input_name, $field_id );
        $city_checkbox_value               = isset( $values['address']['city_name']['checked'] )? $values['address']['city_name']['checked'] : 'checked';
        $city_name_ischecked               = $city_checkbox_value ? esc_attr( $city_checkbox_value ) : '';
        $city_label                        = sprintf( '%s[%d][address][city_name][label]', self::$input_name, $field_id );
        $city_label_value                  = isset( $values['address']['city_name']['label'] )? $values['address']['city_name']['label'] : __( 'City', 'gowatch' );
        $city_value_name                   = sprintf( '%s[%d][address][city_name][value]', self::$input_name, $field_id );
        $city_value_default                = isset( $values['address']['city_name']['value'] )? $values['address']['city_name']['value'] : '';
        $city_placeholder_name             = sprintf( '%s[%d][address][city_name][placeholder]', self::$input_name, $field_id );
        $city_placeholder_value            = isset( $values['address']['city_name']['placeholder'] )? $values['address']['city_name']['placeholder'] : '';
        $city_field_type                   = sprintf( '%s[%d][address][city_name][type]', self::$input_name, $field_id );
        $city_field_type_value             = 'text';
        $city_req                          = sprintf( '%s[%d][address][city_name][required]', self::$input_name, $field_id );
        $city_req_value                    = isset( $values['address']['city_name']['required'] )? $values['address']['city_name']['required'] : 'checked';

        //state name
        $state_name                        = sprintf( '%s[%d][address][state]', self::$input_name, $field_id );
        $state_checkbox_name               = sprintf( '%s[%d][address][state][checked]', self::$input_name, $field_id );
        $state_checkbox_value              = isset( $values['address']['state']['checked'] )? $values['address']['state']['checked'] : 'checked';
        $state_ischecked                   = $state_checkbox_value ? esc_attr( $state_checkbox_value ) : '';
        $state_label                       = sprintf( '%s[%d][address][state][label]', self::$input_name, $field_id );
        $state_label_value                 = isset( $values['address']['state']['label'] )? $values['address']['state']['label'] : __( 'State', 'gowatch' );
        $state_value_name                  = sprintf( '%s[%d][address][state][value]', self::$input_name, $field_id );
        $state_value_default               = isset( $values['address']['state']['value'] )? $values['address']['state']['value'] : '';
        $state_placeholder_name            = sprintf( '%s[%d][address][state][placeholder]', self::$input_name, $field_id );
        $state_placeholder_value           = isset( $values['address']['state']['placeholder'] )? $values['address']['state']['placeholder'] : '';
        $state_field_type                  = sprintf( '%s[%d][address][state][type]', self::$input_name, $field_id );
        $state_field_type_value            = 'text';
        $state_req                         = sprintf( '%s[%d][address][state][required]', self::$input_name, $field_id );
        $state_req_value                   = isset( $values['address']['state']['required'] )? $values['address']['state']['required'] : 'checked';

        //zip name
        $zip_name                          = sprintf( '%s[%d][address][zip]', self::$input_name, $field_id );
        $zip_checkbox_name                 = sprintf( '%s[%d][address][zip][checked]', self::$input_name, $field_id );
        $zip_checkbox_value                = isset( $values['address']['zip']['checked'] )? $values['address']['zip']['checked'] : 'checked';
        $zip_ischecked                     = $zip_checkbox_value ? esc_attr( $zip_checkbox_value ) : '';
        $zip_label                         = sprintf( '%s[%d][address][zip][label]', self::$input_name, $field_id );
        $zip_label_value                   = isset( $values['address']['zip']['label'] )? $values['address']['zip']['label'] : __( 'Zip Code', 'gowatch' );
        $zip_value_name                    = sprintf( '%s[%d][address][zip][value]', self::$input_name, $field_id );
        $zip_value_default                 = isset( $values['address']['zip']['value'] )? $values['address']['zip']['value'] : '';
        $zip_placeholder_name              = sprintf( '%s[%d][address][zip][placeholder]', self::$input_name, $field_id );
        $zip_placeholder_value             = isset( $values['address']['zip']['placeholder'] )? $values['address']['zip']['placeholder'] : '';
        $zip_field_type                    = sprintf( '%s[%d][address][zip][type]', self::$input_name, $field_id );
        $zip_field_type_value              = 'text';
        $zip_req                           = sprintf( '%s[%d][address][zip][required]', self::$input_name, $field_id );
        $zip_req_value                     = isset( $values['address']['zip']['required'] )? $values['address']['zip']['required'] : 'checked';

        //country names
        $county_select_name                = sprintf( '%s[%d][address][country_select]', self::$input_name, $field_id );
        $county_select_checkbox_name       = sprintf( '%s[%d][address][country_select][checked]', self::$input_name, $field_id );
        $county_select_checkbox_value      = isset( $values['address']['country_select']['checked'] )? $values['address']['country_select']['checked'] : 'checked';
        $county_select_ischecked           = $county_select_checkbox_value ? esc_attr( $county_select_checkbox_value ) : '';
        $county_select_label               = sprintf( '%s[%d][address][country_select][label]', self::$input_name, $field_id );
        $county_select_label_value         = isset( $values['address']['country_select']['label'] )? $values['address']['country_select']['label'] : __( 'Country', 'gowatch' );
        $county_select_value_name          = sprintf( '%s[%d][address][country_select][value]', self::$input_name, $field_id );
        $county_select_value_default       = isset( $values['address']['country_select']['value'] )? $values['address']['country_select']['value'] : '';
        $county_select_placeholder_name    = sprintf( '%s[%d][address][country_select][placeholder]', self::$input_name, $field_id );
        $county_select_placeholder_value   = isset( $values['address']['country_select']['placeholder'] )? $values['address']['country_select']['placeholder'] : '';
        $county_select_field_type          = sprintf( '%s[%d][address][country_select][type]', self::$input_name, $field_id );
        $county_select_field_type_value    = 'select';
        $county_select_req                 = sprintf( '%s[%d][address][country_select][required]', self::$input_name, $field_id );
        $county_select_req_value           = isset( $values['address']['country_select']['required'] )? $values['address']['country_select']['required'] : 'checked';
        $hide_country_list_name            = sprintf( '%s[%d][address][country_select][country_select_hide_list][]', self::$input_name, $field_id );
        $hide_country_list_value           = isset( $values['address']['country_select']['country_select_hide_list'] )? $values['address']['country_select']['country_select_hide_list'] : '';
        $show_country_list_name            = sprintf( '%s[%d][address][country_select][country_select_show_list][]', self::$input_name, $field_id );
        $show_country_list_value           = isset( $values['address']['country_select']['country_select_show_list'] )? $values['address']['country_select']['country_select_show_list'] : '';
        $country_list_visibility_opt_name  = sprintf( '%s[%d][address][country_select][country_list_visibility_opt_name]', self::$input_name, $field_id );
        $country_list_visibility_opt_value = isset( $values['address']['country_select']['country_list_visibility_opt_name'] )? $values['address']['country_select']['country_list_visibility_opt_name'] : '';
        ?>
        <li class="custom-field text_field">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'address' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'address_field' ); ?>

            <div class="tszf-form-holder tszf-address">
                <?php self::common( $field_id, '', true, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Address Description', 'gowatch' ); ?></label>
                    <textarea name="<?php echo airkit_var_sanitize( $address_desc_name, 'true' ); ?>"><?php echo airkit_var_sanitize( $address_desc_value, 'true' ); ?></textarea>
                </div>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Address Field(s)', 'gowatch' ); ?></label>

                    <table class="address-table">
                        <thead>
                        <tr>
                            <th width="45%"><?php _e( 'Fields', 'gowatch' ); ?></th>
                            <th width="10%"><?php _e( 'Required?', 'gowatch' ); ?></th>
                            <th width="15%"><?php _e( 'Label', 'gowatch' ); ?></th>
                            <th width="15%"><?php _e( 'Default Value', 'gowatch' ); ?></th>
                            <th width="15%"><?php _e( 'Placeholder', 'gowatch' ); ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>
                                <label>
                                    <input type="hidden"   name="<?php echo airkit_var_sanitize( $street_address_checkbox_name, 'true' ); ?>" value="" />
                                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $street_address_checkbox_name, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $street_address_ischecked, 'true' ); ?> />
                                    <?php _e( 'Address Line 1', 'gowatch' ); ?>
                                    <input type="hidden"
                                           name="<?php echo airkit_var_sanitize( $street_address_field_type, 'true' ); ?>"
                                           value="<?php echo airkit_var_sanitize( $street_address_field_type_value, 'true' ); ?>"  />
                                </label>
                            </td>
                            <td>
                                <input type="hidden"   name="<?php echo airkit_var_sanitize( $street_address_req, 'true' ); ?>" value="" />
                                <input type="checkbox" name="<?php echo airkit_var_sanitize( $street_address_req, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $street_address_req_value, 'true' ); ?> />
                            </td>
                            <td>
                                <input type="text"
                                       name="<?php  echo airkit_var_sanitize( $street_address_label, 'esc_attr'); ?>"
                                       value="<?php echo airkit_var_sanitize( $street_address_label_value, 'esc_attr' ); ?>"  />
                            </td>
                            <td>
                                <input type="text" 
                                       name="<?php  echo airkit_var_sanitize( $street_address_value_name, 'esc_attr' ); ?>"
                                       value="<?php echo airkit_var_sanitize( $street_address_value_default, 'esc_attr' ); ?>"  />
                            </td>
                            <td>
                                <input type="text"
                                       name="<?php  echo airkit_var_sanitize( $street_address_placeholder_name, 'esc_attr' ); ?>"
                                       value="<?php echo airkit_var_sanitize( $street_address_placeholder_value, 'esc_attr' ); ?>"  />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="hidden"   name="<?php echo airkit_var_sanitize( $street_address2_checkbox_name, 'esc_attr' ); ?>" value="" />
                                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $street_address2_checkbox_name, 'esc_attr' ); ?>" value="checked" <?php echo airkit_var_sanitize( $street_address2_ischecked, 'esc_attr' ); ?> />
                                    <?php _e( 'Address Line 2', 'gowatch' ); ?>
                                    <input type="hidden"
                                           name="<?php echo airkit_var_sanitize( $street_address2_field_type, 'esc_attr' ); ?>"
                                           value="<?php echo airkit_var_sanitize( $street_address2_field_type_value, 'esc_attr' ); ?>"  />
                                </label>
                            </td>
                            <td>
                                <input type="hidden" name="<?php   echo airkit_var_sanitize( $street_address2_req, 'true' ); ?>" value="" />
                                <input type="checkbox" name="<?php echo airkit_var_sanitize( $street_address2_req, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $street_address2_req_value, 'true' ); ?> /></td>
                            <td>
                                <input type="text"
                                       name="<?php  echo airkit_var_sanitize( $street_address2_label, 'true' ); ?>"
                                       value="<?php echo airkit_var_sanitize( $street_address2_label_value, 'true' ); ?>"  />
                            </td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $street_address2_value_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $street_address2_value_default, 'true' ); ?>"  /></td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $street_address2_placeholder_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $street_address2_placeholder_value, 'true' ); ?>"  /></td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="hidden"   name="<?php echo airkit_var_sanitize( $city_checkbox_name, 'true' ); ?>" value="" />
                                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $city_checkbox_name, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $city_name_ischecked, 'true' ); ?> />
                                    <?php _e( 'City Name', 'gowatch' ); ?>
                                    <input type="hidden" name="<?php echo airkit_var_sanitize( $city_field_type, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $city_field_type_value, 'true' ); ?>"  />
                                </label>
                            </td>
                            <td>
                                <input type="hidden" name="<?php   echo airkit_var_sanitize( $city_req, 'true' ); ?>" value="" />
                                <input type="checkbox" name="<?php echo airkit_var_sanitize( $city_req, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $city_req_value, 'true' ); ?> /></td>
                            <td>
                                <input type="text" name="<?php echo airkit_var_sanitize( $city_label, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $city_label_value, 'true' ); ?>"  />
                            </td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $city_value_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $city_value_default, 'true' ); ?>"  /></td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $city_placeholder_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $city_placeholder_value, 'true' ); ?>"  /></td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="hidden"   name="<?php echo airkit_var_sanitize( $state_checkbox_name, 'true' ); ?>" value="" />
                                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $state_checkbox_name, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $state_ischecked, 'true' ); ?> />
                                    <?php _e( 'State/Region', 'gowatch' ); ?>
                                    <input type="hidden" name="<?php echo airkit_var_sanitize( $state_field_type, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $state_field_type_value, 'true' ); ?>"  />
                                </label>
                            </td>
                            <td>
                                <input type="hidden" name="<?php echo   airkit_var_sanitize( $state_req, 'true' ); ?>" value="" />
                                <input type="checkbox" name="<?php echo airkit_var_sanitize( $state_req, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $state_req_value, 'true' ); ?> /></td>
                            <td>
                                <input type="text" name="<?php echo airkit_var_sanitize( $state_label, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $state_label_value, 'true' ); ?>"  />
                            </td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $state_value_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $state_value_default, 'true' ); ?>"  /></td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $state_placeholder_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $state_placeholder_value, 'true' ); ?>"  /></td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="hidden"   name="<?php echo airkit_var_sanitize( $zip_checkbox_name, 'true' ); ?>" value="" />
                                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $zip_checkbox_name, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $zip_ischecked, 'true' ); ?> />
                                    <?php _e( 'Zip/Postal Code', 'gowatch' ); ?>
                                    <input type="hidden" name="<?php echo airkit_var_sanitize( $zip_field_type, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $zip_field_type_value, 'true' ); ?>"  />
                                </label>
                            </td>
                            <td>
                                <input type="hidden"   name="<?php echo airkit_var_sanitize( $zip_req, 'true' ); ?>" value="" />
                                <input type="checkbox" name="<?php echo airkit_var_sanitize( $zip_req, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $zip_req_value, 'true' ); ?> /></td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $zip_label, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $zip_label_value, 'true' ); ?>"  />
                            </td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $zip_value_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $zip_value_default, 'true' ); ?>"  /></td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $zip_placeholder_name, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $zip_placeholder_value, 'true' ); ?>"  /></td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="hidden"   name="<?php echo airkit_var_sanitize( $county_select_checkbox_name, 'true' ); ?>" value="" />
                                    <input type="checkbox" name="<?php echo airkit_var_sanitize( $county_select_checkbox_name, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $county_select_ischecked, 'true' ); ?> />
                                    <?php _e( 'Country', 'gowatch' ); ?>
                                    <input type="hidden" name="<?php echo airkit_var_sanitize( $county_select_field_type, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $county_select_field_type_value, 'true' ); ?>"  />
                                </label>
                            </td>
                            <td>
                                <input type="hidden"   name="<?php echo airkit_var_sanitize( $county_select_req, 'true' ); ?>" value="" />
                                <input type="checkbox" name="<?php echo airkit_var_sanitize( $county_select_req, 'true' ); ?>" value="checked" <?php echo airkit_var_sanitize( $county_select_req_value, 'true' ); ?> /></td>
                            <td><input type="text" name="<?php echo airkit_var_sanitize( $county_select_label, 'true' ); ?>" value="<?php echo airkit_var_sanitize( $county_select_label_value, 'true' ); ?>"  /></td>
                            <td>

                                <select name="<?php echo airkit_var_sanitize( $county_select_value_name, 'true' ); ?>" style="width: 170px;">

                                </select>
                                <script>
                                
                                    var countries = window.tszf_countries_list;
                                    var sel_country = '<?php echo airkit_var_sanitize( $county_select_value_default, 'true' ); ?>';
                                    var field_name = '<?php echo  airkit_var_sanitize( $county_select_value_name, 'true' ); ?>';
                                    var option_string = '<option value="">Select Country</option>';
                                    for (country in countries) {
                                        option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                                    }
                                    jQuery('select[name="'+ field_name +'"]').html(option_string);
                                </script>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php
                    $param = array(
                        'names_to_hide' => array(
                            'name'  => $hide_country_list_name,
                            'value' => $hide_country_list_value
                        ),
                        'names_to_show' => array(
                            'name'  => $show_country_list_name ,
                            'value' => $show_country_list_value
                        ),
                        'option_to_chose' => array(
                            'name' => $country_list_visibility_opt_name,
                            'value' => $country_list_visibility_opt_value
                        )
                    );
                    self::render_drop_down_portion($param);
                    ?>
                </div>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }

    /**
     * Render Section start in case of multistep form
     *
     * @param $field_id
     * @param $label
     * @param $values
     *
     */
    public static function step_start( $field_id, $label, $classname, $values = array() ) {
        $title_name  = sprintf( '%s[%d][label]', self::$input_name, $field_id );
        $title_value = $values ? esc_attr( $values['label'] ) : 'Section';

        $step_start_name               = sprintf( '%s[%d][step_start]', self::$input_name, $field_id );
        $step_start_prev_button_name      = sprintf( '%s[%d][step_start][prev_button_text]', self::$input_name, $field_id );
        $step_start_prev_button_value     = isset( $values['step_start']['prev_button_text'] )? $values['step_start']['prev_button_text'] : 'Previous';

        $step_start_next_button_name      = sprintf( '%s[%d][step_start][next_button_text]', self::$input_name, $field_id );
        $step_start_next_button_value     = isset( $values['step_start']['next_button_text'] )? $values['step_start']['next_button_text'] : 'Next';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'step_start' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'step_start' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <label><?php _e( 'Section Name', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <input type="text" class="smallipopInput" title="<?php _e( 'Title', 'gowatch' ); ?>" name="<?php echo airkit_var_sanitize( $title_name, 'true' ); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                    </div> <!-- .tszf-form-rows -->
                </div>
                <div class="tszf-form-rows">
                    <label><?php _e( 'Previous Button Text', 'gowatch' ); ?></label>
                    <div class="tszf-form-sub-fields">
                        <input type="text" class="smallipopInput" title="<?php _e( 'Previous Button Text', 'gowatch' ); ?>" name="<?php echo airkit_var_sanitize( $step_start_prev_button_name, 'true' ); ?>" value="<?php echo esc_attr( $step_start_prev_button_value ); ?>" />
                    </div> <!-- .tszf-form-rows -->
                </div>
                <div class="tszf-form-rows">
                    <label><?php _e( 'Next Button Text', 'gowatch' ); ?></label>
                    <div class="tszf-form-sub-fields">
                        <input type="text" class="smallipopInput" title="<?php _e( 'Next Button Text', 'gowatch' ); ?>" name="<?php echo airkit_var_sanitize( $step_start_next_button_name, 'true' ); ?>" value="<?php echo esc_attr( $step_start_next_button_value ); ?>" />
                    </div> <!-- .tszf-form-rows -->
                </div>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }

    /**
     * Render Backend Options for Tab content
     *
     * @param $field_id
     * @param $label
     * @param $values
     *
     */
    public static function tab_content( $field_id, $label, $classname, $values = array() ) {

        $action_name  = sprintf( '%s[%d][action]', self::$input_name, $field_id );
        $action_val   = isset( $values['action'] ) ? esc_attr( $values['action'] ) : 'start';

        $image_name  = sprintf( '%s[%d][image]', self::$input_name, $field_id );
        $image_val   = isset( $values['image'] ) ? esc_attr( $values['image'] ) : '';

        $help = esc_attr( __( 'First element of the select dropdown. Leave this empty if you don\'t want to show this field', 'gowatch' ) );

        ?>
        <li class="custom-field tab_content tszf-conditional">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'tab_content' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'tab_content' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, '', true, $values ); ?>
                <div class="tszf-form-rows">
                    <label><?php _e( 'Add image URL', 'gowatch' ); ?></label>
                    <input type="text" name="<?php echo airkit_var_sanitize( $image_name, 'esc_attr' ); ?>" value="<?php echo airkit_var_sanitize( $image_val, 'esc_attr' ); ?>" class="smallipopInput" title="<?php _e( 'Add an image URL that will be displayed as tab', 'gowatch' ); ?>">
                </div> <!-- .tszf-form-rows -->
                <div class="tszf-form-rows">
                    <label><?php _e( 'Select tab action', 'gowatch' ); ?></label>            
                    <select name="<?php echo esc_attr( $action_name ); ?>" data-select-tab-action="action">
                        <option value="start"  <?php selected( $action_val, 'start' ) ?>> <?php echo esc_html__( 'Start tab container', 'gowatch' ); ?> </option>
                        <option value="new"    <?php selected( $action_val, 'new' ) ?>> <?php echo esc_html__( 'Start new tab', 'gowatch' );  ?> </option>
                        <option value="end"    <?php selected( $action_val, 'end' ) ?>> <?php echo esc_html__( 'End tab Contianer', 'gowatch' ); ?> </option>
                    </select>            

                    <?php self::conditional_field( $field_id, $values ); ?>
                </div> <!-- .tszf-form-rows -->
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }    


    /**
     * Render really simple captcha
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     */
    public static function really_simple_captcha( $field_id, $label, $classname, $values = array() ) {
        $title_name  = sprintf( '%s[%d][label]', self::$input_name, $field_id );
        $html_name   = sprintf( '%s[%d][html]', self::$input_name, $field_id );

        $title_value = $values ? esc_attr( $values['label'] ) : '';
        $html_value  = isset( $values['html'] ) ? esc_attr( $values['html'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'really_simple_captcha' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'really_simple_captcha' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <label><?php _e( 'Title', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <input type="text" class="smallipopInput" title="Title of the section" name="<?php echo airkit_var_sanitize( $title_name, 'true' ); ?>" value="<?php echo esc_attr( $title_value ); ?>" />

                        <div class="description" style="margin-top: 8px;">
                            <?php printf( __( "Depends on <a href='http://wordpress.org/extend/plugins/really-simple-captcha/' target='_blank'>Really Simple Captcha</a> Plugin. Install it first.", "gowatch" ) ); ?>
                        </div>
                    </div> <!-- .tszf-form-rows -->
                </div>

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }


    /**
     * Action hook
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     */
    public static function action_hook( $field_id, $label, $classname, $values = array() ) {
        $title_name  = sprintf( '%s[%d][label]', self::$input_name, $field_id );
        $title_value = $values ? esc_attr( $values['label'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'action_hook' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'action_hook' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <label><?php _e( 'Hook Name', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <input type="text" class="smallipopInput" title="<?php _e( 'Name of the hook', 'gowatch' ); ?>" name="<?php echo airkit_var_sanitize( $title_name, 'true' ); ?>" value="<?php echo esc_attr( $title_value ); ?>" />

                        <div class="description" style="margin-top: 8px;">
                            <?php _e( "An option for developers to add dynamic elements they want. It provides the chance to add whatever input type you want to add in this form.", 'gowatch' ); ?>
                            <?php _e( 'This way, you can bind your own functions to render the form to this action hook. You\'ll be given 3 parameters to play with: $form_id, $post_id, $form_settings.', 'gowatch' ); ?>
                            <pre>
                                add_action('HOOK_NAME', 'your_function_name', 10, 3 );
                                function your_function_name( $form_id, $post_id, $form_settings ) {
                                    // do what ever you want
                                }
                            </pre>
                        </div>
                    </div> <!-- .tszf-form-rows -->
                </div>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }


    /**
     * Render toc
     * @param $field_id
     * @param $label
     * @param $classname
     * @param array $values
     */
    public static function toc( $field_id, $label, $classname, $values = array() ) {

        $title_name        = sprintf( '%s[%d][label]', self::$input_name, $field_id );
        $description_name  = sprintf( '%s[%d][description]', self::$input_name, $field_id );

        $title_value       = $values ? esc_attr( $values['label'] ) : '';
        $description_value = $values ? esc_attr( $values['description'] ) : '';
        ?>

        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'toc' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'toc' ); ?>

            <div class="tszf-form-holder">
                <div class="tszf-form-rows">
                    <?php self::common( $field_id, '', true, $values ); ?>
                    <!--<label><?php _e( 'Label', 'gowatch' ); ?></label>
                    <input type="text" name="<?php echo airkit_var_sanitize( $title_name, 'true' ); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                -->
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Terms & Conditions', 'gowatch' ); ?></label>
                    <textarea class="smallipopInput" title="<?php _e( 'Insert terms and condtions here.', 'gowatch' ); ?>" name="<?php echo airkit_var_sanitize( $description_name, 'true' ); ?>" rows="3"><?php echo esc_html( $description_value ); ?></textarea>
                </div> <!-- .tszf-form-rows -->
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
    <?php
    }

}

