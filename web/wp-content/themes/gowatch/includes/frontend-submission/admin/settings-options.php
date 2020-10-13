<?php

/**
 * Settings Sections
 *
 * @return array
 */
function tszf_settings_sections() {
    $sections = array(

        array(
            'id'    => 'tszf_general',
            'title' => __( 'General Options', 'gowatch' ),
        ),

        array(
            'id'    => 'tszf_dashboard',
            'title' => __( 'Dashboard', 'gowatch' )
        ),

        array(
            'id'    => 'tszf_profile',
            'title' => __( 'Login / Registration', 'gowatch' )
        ),

        array(
            'id'    => 'tszf_forms',
            'url'   => admin_url() . 'edit.php?post_type=tszf_forms',
            'title' => __( 'Frontend forms', 'gowatch' )
        ),        

        array(
            'id'    => 'tszf_profile',
            'url'   => admin_url() . 'edit.php?post_type=tszf_profile',
            'title' => __( 'Registration forms', 'gowatch' )
        ),         
    );

    return apply_filters( 'tszf_settings_sections', $sections );
}

function tszf_settings_fields() {
    $pages = tszf_get_pages();
    $users = tszf_list_users();

    $settings_fields = array(
        'tszf_general' => apply_filters( 'tszf_options_others', array(
            array(
                'name'    => 'fixed_form_element',
                'label'   => __( 'Fixed Form Elements ', 'gowatch' ),
                'desc'    => __( 'Show fixed form elements sidebar in form editor', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'on'
            ),

            array(
                'name'    => 'default_post_owner',
                'label'   => __( 'Default Post Owner', 'gowatch' ),
                'desc'    => __( 'If guest post is enabled and user details are OFF, the posts are assigned to this user', 'gowatch' ),
                'type'    => 'select',
                'options' => $users,
                'default' => '1'
            ),
            array(
                'name'    => 'admin_access',
                'label'   => __( 'Admin area access', 'gowatch' ),
                'desc'    => __( 'Allow you to block specific user role to WordPress admin area.', 'gowatch' ),
                'type'    => 'select',
                'default' => 'read',
                'options' => array(
                    'manage_options'    => __( 'Admin Only', 'gowatch' ),
                    'edit_others_posts' => __( 'Admins, Editors', 'gowatch' ),
                    'publish_posts'     => __( 'Admins, Editors, Authors', 'gowatch' ),
                    'edit_posts'        => __( 'Admins, Editors, Authors, Contributors', 'gowatch' ),
                    'read'              => __( 'Default', 'gowatch' )
                )
            ),
            array(
                'name'    => 'override_editlink',
                'label'   => __( 'Override the post edit link', 'gowatch' ),
                'desc'    => __( 'Users see the edit link in post if s/he is capable to edit the post/page. Selecting <strong>Yes</strong> will override the default WordPress edit post link in frontend', 'gowatch' ),
                'type'    => 'select',
                'default' => 'yes',
                'options' => array(
                    'yes' => __( 'Yes', 'gowatch' ),
                    'no'  => __( 'No', 'gowatch' )
                )
            ),
            array(
                'name'    => 'cf_show_front',
                'label'   => __( 'Custom Fields in post', 'gowatch' ),
                'desc'    => __( 'Show custom fields on post content area', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'off'
            ),
            array(
                'name'    => 'load_script',
                'label'   => __( 'Load Scripts', 'gowatch' ),
                'desc'    => __( 'Load scripts/styles in all pages', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'on'
            ),
            array(
                'name'    => 'insert_photo_size',
                'label'   => __( 'Insert Photo image size', 'gowatch' ),
                'desc'    => __( 'Default image size of "<strong>Insert Photo</strong>" button in post content area', 'gowatch' ),
                'type'    => 'select',
                'options' => tszf_get_image_sizes(),
                'default' => 'thumbnail'
            ),
            array(
                'name'  => 'insert_photo_type',
                'label' => __( 'Insert Photo image type', 'gowatch' ),
                'desc'  => __( 'Default image type of "<strong>Insert Photo</strong>" button in post content area', 'gowatch' ),
                'type'  => 'select',
                'options' => array(
                    'image' => __( 'Image only', 'gowatch' ),
                    'link'  => __( 'Image with link', 'gowatch' )
                ),
                'default' => 'link'
            ),
            array(
                'name'    => 'image_caption',
                'label'   => __( 'Enable Image Caption', 'gowatch' ),
                'desc'    => __( 'Allow users to update image/video title, caption and description', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'off'
            ),
        ) ),
        'tszf_dashboard' => apply_filters( 'tszf_options_dashboard', array(
            array(
                'name'    => 'enable_post_edit',
                'label'   => __( 'Users can edit post?', 'gowatch' ),
                'desc'    => __( 'Users will be able to edit their own posts', 'gowatch' ),
                'type'    => 'select',
                'default' => 'yes',
                'options' => array(
                    'yes' => __( 'Yes', 'gowatch' ),
                    'no'  => __( 'No', 'gowatch' )
                )
            ),
            array(
                'name'    => 'enable_post_del',
                'label'   => __( 'User can delete post?', 'gowatch' ),
                'desc'    => __( 'Users will be able to delete their own posts', 'gowatch' ),
                'type'    => 'select',
                'default' => 'yes',
                'options' => array(
                    'yes' => __( 'Yes', 'gowatch' ),
                    'no'  => __( 'No', 'gowatch' )
                )
            ),
            array(
                'name'    => 'disable_pending_edit',
                'label'   => __( 'Pending Post Edit', 'gowatch' ),
                'desc'    => __( 'Disable post editing while post in "pending" status', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'on'
            ),
            array(
                'name'    => 'per_page',
                'label'   => __( 'Posts per page', 'gowatch' ),
                'desc'    => __( 'How many posts will be listed in a page', 'gowatch' ),
                'type'    => 'text',
                'default' => '10'
            ),
            array(
                'name'    => 'show_user_bio',
                'label'   => __( 'Show user bio', 'gowatch' ),
                'desc'    => __( 'Users biographical info will be shown', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'on'
            ),
            array(
                'name'    => 'show_post_count',
                'label'   => __( 'Show post count', 'gowatch' ),
                'desc'    => __( 'Show how many posts are created by the user', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'on'
            ),
            array(
                'name'  => 'show_ft_image',
                'label' => __( 'Show Featured Image', 'gowatch' ),
                'desc'  => __( 'Show featured image of the post', 'gowatch' ),
                'type'  => 'checkbox'
            ),
            array(
                'name'    => 'ft_img_size',
                'label'   => __( 'Featured Image size', 'gowatch' ),
                'type'    => 'select',
                'options' => tszf_get_image_sizes()
            ),
             array(
                'name'  => 'un_auth_msg',
                'label' => __( 'Unauthorized Message', 'gowatch' ),
                'desc'  => __( 'Not logged in users will see this message', 'gowatch' ),
                'type'  => 'textarea'
            ),
        ) ),
        'tszf_profile' => array(
            array(
                'name'    => 'autologin_after_registration',
                'label'   => __( 'Auto Login After Registration', 'gowatch' ),
                'desc'    => __( 'If enabled, users after registration will be logged in to the system', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'off'
            ),
            array(
                'name'    => 'register_link_override',
                'label'   => __( 'Login/Registration override', 'gowatch' ),
                'desc'    => __( 'If enabled, default login and registration forms will be overridden by tszf with pages below', 'gowatch' ),
                'type'    => 'checkbox',
                'default' => 'off'
            ),
        ),

    );

    return apply_filters( 'tszf_settings_fields', $settings_fields );
}

function tszf_settings_field_profile( $form ) {
    $user_roles = tszf_get_user_roles();
    $forms = get_posts( array(
        'numberposts' => -1,
        'post_type'   => 'tszf_profile'
    ) );

    $val = get_option( 'tszf_profile', array() );
    ?>

    <p style="padding-left: 10px; font-style: italic; font-size: 13px;">
        <strong><?php _e( 'Select profile/registration forms for user roles. These forms will be used to populate extra edit profile fields in backend.', 'gowatch' ); ?></strong>
    </p>
    <table class="form-table">
        <?php
        foreach ($user_roles as $role => $name) {
            $current = isset( $val['roles'][$role] ) ? $val['roles'][$role] : '';
            ?>
            <tr valign="top">
                <th scrope="row"><?php echo airkit_var_sanitize( $name, 'the_kses' ); ?></th>
                <td>
                    <select name="tszf_profile[roles][<?php echo airkit_var_sanitize( $role, 'esc_attr' ); ?>]">
                        <option value=""><?php _e( ' - select - ', 'gowatch' ); ?></option>
                        <?php foreach ($forms as $form) { ?>
                            <option value="<?php echo airkit_var_sanitize( $form->ID, 'esc_attr' ); ?>"<?php selected( $current, $form->ID ); ?>>
                                <?php echo airkit_var_sanitize( $form->post_title, 'the_kses' ); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php
}

add_action( 'wsa_form_bottom_tszf_profile', 'tszf_settings_field_profile' );