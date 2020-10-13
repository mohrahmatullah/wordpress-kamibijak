<?php
/**
 * Admin Form UI Builder
 *
 * @package TouchSize Frontend Submission
 */


class TSZF_Admin_Form {

    private $form_data_key = 'tszf_form';
    private $form_settings_key = 'tszf_form_settings';

    /**
     * Add neccessary actions and filters
     *
     * @return void
     */
    function __construct() {
        add_action( 'init', array($this, 'add_post_type') );
        add_filter( 'post_updated_messages', array($this, 'form_updated_message') );

        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );
        add_action( 'admin_footer-edit.php', array($this, 'add_form_button_style') );
        add_action( 'admin_footer-post.php', array($this, 'add_form_button_style') );

        add_action( 'admin_head', array( $this, 'menu_icon' ) );

        // form duplication
        add_filter( 'post_row_actions', array( $this, 'row_action_duplicate' ), 10, 2 );
        add_filter( 'admin_action_tszf_duplicate', array( $this, 'duplicate_form' ) );

        // meta boxes
        add_action( 'add_meta_boxes_tszf_forms', array($this, 'add_meta_box_post') );
        add_action( 'add_meta_boxes_tszf_profile', array($this, 'add_meta_box_profile') );

        // custom columns
        add_filter( 'manage_edit-tszf_forms_columns', array( $this, 'admin_column' ) );
        add_filter( 'manage_edit-tszf_profile_columns', array( $this, 'admin_column_profile' ) );
        add_action( 'manage_tszf_forms_posts_custom_column', array( $this, 'admin_column_value' ), 10, 2 );
        add_action( 'manage_tszf_profile_posts_custom_column', array( $this, 'admin_column_value_profile' ), 10, 2 );
        add_filter( 'post_row_actions', array( $this, 'remove_quick_edit' ) );

        // ajax actions for post forms
        add_action( 'wp_ajax_tszf_form_dump', array( $this, 'form_dump' ) );
        add_action( 'wp_ajax_tszf_form_add_el', array( $this, 'ajax_post_add_element' ) );

        add_action( 'save_post', array( $this, 'save_form_meta' ), 1, 3 ); // save the custom fields


    }

    function remove_quick_edit( $actions ) {
        global $current_screen;

        if ( ! $current_screen ) {
            return $actions;
        }

        if ( $current_screen->post_type == 'tszf_forms' || $current_screen->post_type == 'tszf_profile' ) {
            unset( $actions['inline hide-if-no-js'] );
        }

        return $actions;
    }

    public static function insert_form_field( $form_id, $fields = array(), $field_id = null, $order = 0 ) {

        $args = array(
            'post_type'    => 'tszf_input',
            'post_parent'  => $form_id,
            'post_status'  => 'publish',
            'post_content' => maybe_serialize( wp_unslash( $fields ) ),
            'menu_order'   => $order
        );

        if ( $field_id ) {
            $args['ID'] = $field_id;
        }

        if ( $field_id ) {
            wp_update_post( $args );
        } else {
            wp_insert_post( $args );
        }
    }

    /**
     * Enqueue scripts and styles for form builder
     *
     * @global string $pagenow
     * @return void
     */
    function enqueue_scripts() {
        global $pagenow, $post;

        if ( !in_array( $pagenow, array( 'post.php', 'post-new.php') ) ) {
            return;
        }

        wp_enqueue_script( 'jquery-ui-autocomplete' );

        if ( !in_array( $post->post_type, array( 'tszf_forms', 'tszf_profile' ) ) ) {
            return;
        }

        // scripts
        wp_enqueue_script( 'jquery-smallipop', TSZF_ASSET_URI . '/js/jquery.smallipop-0.4.0.min.js', array('jquery') );
        wp_enqueue_script( 'tszf-formbuilder-script', TSZF_ASSET_URI . '/js/formbuilder.js', array('jquery', 'jquery-ui-sortable') );
        wp_enqueue_script( 'tszf-conditional-script', TSZF_ASSET_URI . '/js/conditional.js' );

        // styles
        wp_enqueue_style( 'jquery-smallipop', TSZF_ASSET_URI . '/css/jquery.smallipop.css' );
        wp_enqueue_style( 'tszf-formbuilder', TSZF_ASSET_URI . '/css/formbuilder.css' );
        wp_enqueue_style( 'jquery-ui-core', TSZF_ASSET_URI . '/css/jquery-ui-1.9.1.custom.css' );
    }

    function add_form_button_style() {
        global $pagenow, $post_type;

        if ( !in_array( $post_type, array( 'tszf_forms', 'tszf_profile') ) ) {
            return;
        }

        $fixed_sidebar = tszf_get_option( 'fixed_form_element', 'tszf_general' );
        ?>
        <style type="text/css">
            .wrap .add-new-h2, .wrap .add-new-h2:active {
                background: #21759b;
                color: #fff;
                text-shadow: 0 1px 1px #446E81;
            }

            <?php if ( $fixed_sidebar == 'on' ) { ?>
            #tszf-metabox-fields{
                position: fixed;
                bottom: 10px;
            }
            <?php } ?>
        </style>
        <?php
    }

    /**
     * Register form post types
     *
     * @return void
     */
    function add_post_type() {

        $capability = tszf_admin_role();

        if( class_exists( 'Ts_Custom_Post' ) ) {

            Ts_Custom_Post::add_custom_post_type( 'tszf_forms', array(
                'label'           => __( 'Forms', 'gowatch' ),
                'public'          => false,
                'show_ui'         => true,
                'show_in_menu'    => false, //false,
                'capability_type' => 'post',
                'hierarchical'    => false,
                'query_var'       => false,
                'supports'        => array('title'),
                'capabilities' => array(
                    'publish_posts'       => $capability,
                    'edit_posts'          => $capability,
                    'edit_others_posts'   => $capability,
                    'delete_posts'        => $capability,
                    'delete_others_posts' => $capability,
                    'read_private_posts'  => $capability,
                    'edit_post'           => $capability,
                    'delete_post'         => $capability,
                    'read_post'           => $capability,
                ),
                'labels' => array(
                    'name'               => __( 'Forms', 'gowatch' ),
                    'singular_name'      => __( 'Form', 'gowatch' ),
                    'menu_name'          => __( 'Forms', 'gowatch' ),
                    'add_new'            => __( 'Add Form', 'gowatch' ),
                    'add_new_item'       => __( 'Add New Form', 'gowatch' ),
                    'edit'               => __( 'Edit', 'gowatch' ),
                    'edit_item'          => __( 'Edit Form', 'gowatch' ),
                    'new_item'           => __( 'New Form', 'gowatch' ),
                    'view'               => __( 'View Form', 'gowatch' ),
                    'view_item'          => __( 'View Form', 'gowatch' ),
                    'search_items'       => __( 'Search Form', 'gowatch' ),
                    'not_found'          => __( 'No Form Found', 'gowatch' ),
                    'not_found_in_trash' => __( 'No Form Found in Trash', 'gowatch' ),
                    'parent'             => __( 'Parent Form', 'gowatch' ),
                ),
            ) );

            Ts_Custom_Post::add_custom_post_type( 'tszf_profile', array(
                'label'           => __( 'Registraton Forms', 'gowatch' ),
                'public'          => false,
                'show_ui'         => true,
                'show_in_menu'    => false,
                'capability_type' => 'post',
                'hierarchical'    => false,
                'query_var'       => false,
                'supports'        => array('title'),
                'capabilities' => array(
                    'publish_posts'       => $capability,
                    'edit_posts'          => $capability,
                    'edit_others_posts'   => $capability,
                    'delete_posts'        => $capability,
                    'delete_others_posts' => $capability,
                    'read_private_posts'  => $capability,
                    'edit_post'           => $capability,
                    'delete_post'         => $capability,
                    'read_post'           => $capability,
                ),
                'labels' => array(
                    'name'               => __( 'Forms', 'gowatch' ),
                    'singular_name'      => __( 'Form', 'gowatch' ),
                    'menu_name'          => __( 'Registration Forms', 'gowatch' ),
                    'add_new'            => __( 'Add Form', 'gowatch' ),
                    'add_new_item'       => __( 'Add New Form', 'gowatch' ),
                    'edit'               => __( 'Edit', 'gowatch' ),
                    'edit_item'          => __( 'Edit Form', 'gowatch' ),
                    'new_item'           => __( 'New Form', 'gowatch' ),
                    'view'               => __( 'View Form', 'gowatch' ),
                    'view_item'          => __( 'View Form', 'gowatch' ),
                    'search_items'       => __( 'Search Form', 'gowatch' ),
                    'not_found'          => __( 'No Form Found', 'gowatch' ),
                    'not_found_in_trash' => __( 'No Form Found in Trash', 'gowatch' ),
                    'parent'             => __( 'Parent Form', 'gowatch' ),
                ),
            ) );

            Ts_Custom_Post::add_custom_post_type( 'tszf_input', array(
                'public'          => false,
                'show_ui'         => false,
                'show_in_menu'    => false,
            ) );


        }

    }

    /**
     * Custom post update message
     *
     * @param  array $messages
     * @return array
     */
    function form_updated_message( $messages ) {
        $message = array(
             0 => '',
             1 => __( 'Form updated.', 'gowatch'),
             2 => __( 'Custom field updated.', 'gowatch' ),
             3 => __( 'Custom field deleted.', 'gowatch' ),
             4 => __( 'Form updated.', 'gowatch' ),
             5 => isset($_GET['revision']) ? sprintf( __('Form restored to revision from %s', 'gowatch'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
             6 => __('Form published.', 'gowatch'),
             7 => __('Form saved.', 'gowatch'),
             8 => __('Form submitted.', 'gowatch' ),
             9 => '',
            10 => __('Form draft updated.', 'gowatch'),
        );

        $messages['tszf_forms'] = $message;
        $messages['tszf_profile'] = $message;

        return $messages;
    }

    function menu_icon() {
        ?>
        <style type="text/css">
            .icon32-posts-tszf_forms,
            .icon32-posts-tszf_profile {
                background: url('<?php echo admin_url( "images/icons32.png" ); ?>') no-repeat 2% 35%;
            }
        </style>
        <?php
    }

    /**
     * Columns form builder list table
     *
     * @param type $columns
     * @return string
     */
    function admin_column( $columns ) {
        $columns = array(
            'cb'          => '<input type="checkbox" />',
            'title'       => __( 'Form Name', 'gowatch' ),
            'post_type'   => __( 'Post Type', 'gowatch' ),
            'post_status' => __( 'Post Status', 'gowatch' ),
            'is_active'   => __( 'Active', 'gowatch' )

        );

        return $columns;
    }

    /**
     * Columns form builder list table
     *
     * @param type $columns
     * @return string
     */
    function admin_column_profile( $columns ) {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'title'     => __( 'Form Name', 'gowatch' ),
            'role'      => __( 'User Role', 'gowatch' ),
            'is_active' => __( 'Active', 'gowatch' ),
        );

        return $columns;
    }

    /**
     * Custom Column value for post form builder
     *
     * @param string $column_name
     * @param int $post_id
     */
    function admin_column_value( $column_name, $post_id ) {
        switch ($column_name) {


            case 'is_active':
                echo self::is_active_form( $post_id, 'submit' );
                break;

            case 'post_type':
                $settings = tszf_get_form_settings( $post_id );
                echo isset( $settings['post_type'] ) ? $settings['post_type'] : 'post';
                break;

            case 'post_status':
                $settings = tszf_get_form_settings( $post_id );
                $status   = isset( $settings['post_status'] ) ? $settings['post_status'] : 'publish';
                echo tszf_admin_post_status( $status );
                break;

            default:
                # code...
                break;
        }
    }

    function is_active_form( $form_id, $form_type = 'submit' ) {

        $image = '<a href="#" data-form-id="%s" class="form-active-toggle %s" data-type=%s><i class="%s"></i></a>';

        if( is_this_form_active( $form_id, $form_type ) ) {

            return sprintf( $image, $form_id, 'active', esc_attr( $form_type ), 'icon-tick' );

        }

        return sprintf( $image, $form_id, '', esc_attr( $form_type ), 'icon-close' );

    }

    /**
     * Custom Column value for profile form builder
     *
     * @param string $column_name
     * @param int $post_id
     */
    function admin_column_value_profile( $column_name, $post_id ) {

        switch ( $column_name ) {
            case 'is_active':
                echo self::is_active_form( $post_id, 'register' );
                break;

            case 'role':
                $settings = tszf_get_form_settings( $post_id );
                $role = isset( $settings['role'] ) ? $settings['role'] : 'subscriber';
                echo ucfirst( $role );
                break;
        }
    }

    /**
     * Duplicate form row action link
     *
     * @param array $actions
     * @param object $post
     * @return array
     */
    function row_action_duplicate($actions, $post) {
        if ( !current_user_can( 'activate_plugins' ) ) {
            return $actions;
        }

        if ( !in_array( $post->post_type, array( 'tszf_forms', 'tszf_profile') ) ) {
            return $actions;
        }

        $actions['duplicate'] = '<a href="' . esc_url( add_query_arg( array( 'action' => 'tszf_duplicate', 'id' => $post->ID, '_wpnonce' => wp_create_nonce( 'tszf_duplicate' ) ), admin_url( 'admin.php' ) ) ) . '" title="' . esc_attr( __( 'Duplicate form', 'gowatch' ) ) . '">' . __( 'Duplicate', 'gowatch' ) . '</a>';
        return $actions;
    }

    /**
     * Form Duplication handler
     *
     * @return type
     */
    function duplicate_form() {
        check_admin_referer( 'tszf_duplicate' );

        if ( !current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $post_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
        $post = get_post( $post_id );

        if ( !$post ) {
            return;
        }

        $contents = self::get_form_fields( $post_id );

        $new_form = array(
            'post_title'  => $post->post_title,
            'post_type'   => $post->post_type,
            'post_status' => 'draft'
        );


        $form_id = wp_insert_post( $new_form );

        foreach ( $contents as $content ) {
            $post_content = maybe_unserialize( $content->post_content );
            self::insert_form_field( $form_id, $post_content, null, $order );
        }

        if ( $form_id ) {
            $form_settings = tszf_get_form_settings( $post_id );
            update_post_meta( $form_id, $this->form_settings_key, $form_settings );
            $location = admin_url( 'edit.php?post_type=' . $post->post_type );
            wp_redirect( $location );
        }
    }

    /**
     * Add meta boxes to post form builder
     *
     * @return void
     */
    function add_meta_box_post() {
        add_meta_box( 'tszf-metabox-editor', __( 'Form Editor', 'gowatch' ), array($this, 'metabox_post_form'), 'tszf_forms', 'normal', 'high' );
        add_meta_box( 'tszf-metabox-fields', __( 'Form Elements', 'gowatch' ), array($this, 'form_elements_post'), 'tszf_forms', 'side', 'core' );
    }

    /**
     * Adds meta boxes to profile form builder
     *
     * @return void
     */
    function add_meta_box_profile() {
        add_meta_box( 'tszf-metabox-editor', __( 'Form Editor', 'gowatch' ), array($this, 'metabox_profile_form'), 'tszf_profile', 'normal', 'high' );
        add_meta_box( 'tszf-metabox-fields', __( 'Form Elements', 'gowatch' ), array($this, 'form_elements_profile'), 'tszf_profile', 'side', 'core' );
    }


    /**
     * Replaces the core publish button with ours
     *
     * @global object $post
     * @global string $pagenow
     */
    function publish_button() {
        global $post, $pagenow;

        $post_type        = $post->post_type;
        $post_type_object = get_post_type_object($post_type);
        $can_publish      = current_user_can($post_type_object->cap->publish_posts);
        ?>
        <div class="submitbox" id="submitpost">
            <div id="major-publishing-actions">
                <div id="publishing-action">
                    <span class="spinner"></span>
                        <?php
                        if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) {
                            if ( $can_publish ) :
                                if ( !empty( $post->post_date_gmt ) && time() < strtotime( $post->post_date_gmt . ' +0000' ) ) :
                                    ?>
                                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Schedule', 'gowatch' ) ?>" />
                            <?php submit_button( __( 'Schedule', 'gowatch' ), 'primary button-large', 'publish', false, array('accesskey' => 'p') ); ?>
                        <?php else : ?>
                                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Publish', 'gowatch' ) ?>" />
                            <?php submit_button( __( 'Publish', 'gowatch' ), 'primary button-large', 'publish', false, array('accesskey' => 'p') ); ?>
                        <?php endif;
                    else :
                        ?>
                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Submit for Review', 'gowatch' ) ?>" />
                        <?php submit_button( __( 'Submit for Review', 'gowatch' ), 'primary button-large', 'publish', false, array('accesskey' => 'p') ); ?>
                    <?php
                    endif;
                    } else {
                        ?>
                        <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Update', 'gowatch' ) ?>" />
                        <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php esc_attr_e( 'Update', 'gowatch' ) ?>" />
                    <?php }
                ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php
    }


    /**
     * Displays settings on post form builder
     *
     * @global object $post
     */
    function form_settings_posts() {
        global $post;



        $form_settings = tszf_get_form_settings( $post->ID );

        $post_status_selected  = isset( $form_settings['post_status'] ) ? $form_settings['post_status'] : 'publish';
        $restrict_message      = __( "This page is restricted. Please Log in / Register to view this page.", 'gowatch' );

        $post_type_selected    = isset( $form_settings['post_type'] ) ? $form_settings['post_type'] : 'post';

        $post_format_selected  = isset( $form_settings['post_format'] ) ? $form_settings['post_format'] : 0;
        $default_cat           = isset( $form_settings['default_cat'] ) ? $form_settings['default_cat'] : -1;

        $guest_post            = isset( $form_settings['guest_post'] ) ? $form_settings['guest_post'] : 'false';
        $guest_details         = isset( $form_settings['guest_details'] ) ? $form_settings['guest_details'] : 'true';
        $name_label            = isset( $form_settings['name_label'] ) ? $form_settings['name_label'] : __( 'Name', 'gowatch' );
        $email_label           = isset( $form_settings['email_label'] ) ? $form_settings['email_label'] : __( 'Email', 'gowatch' );
        $message_restrict      = isset( $form_settings['message_restrict'] ) ? $form_settings['message_restrict'] : $restrict_message;

        $redirect_to           = isset( $form_settings['redirect_to'] ) ? $form_settings['redirect_to'] : 'post';
        $message               = isset( $form_settings['message'] ) ? $form_settings['message'] : __( 'Post saved', 'gowatch' );
        $update_message        = isset( $form_settings['update_message'] ) ? $form_settings['update_message'] : __( 'Post updated successfully', 'gowatch' );
        $page_id               = isset( $form_settings['page_id'] ) ? $form_settings['page_id'] : 0;
        $url                   = isset( $form_settings['url'] ) ? $form_settings['url'] : '';
        $comment_status        = isset( $form_settings['comment_status'] ) ? $form_settings['comment_status'] : 'open';

        $submit_text           = isset( $form_settings['submit_text'] ) ? $form_settings['submit_text'] : __( 'Submit', 'gowatch' );
        $draft_text            = isset( $form_settings['draft_text'] ) ? $form_settings['draft_text'] : __( 'Save Draft', 'gowatch' );
        $preview_text          = isset( $form_settings['preview_text'] ) ? $form_settings['preview_text'] : __( 'Preview', 'gowatch' );
        $draft_post            = isset( $form_settings['draft_post'] ) ? $form_settings['draft_post'] : 'false';
        // $subscription_disabled = isset( $form_settings['subscription_disabled'] ) ? $form_settings['subscription_disabled'] : '';

        ?>
        <table class="form-table">
            <tr class="tszf-post-type">
                <th><?php _e( 'Post Type', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[post_type]">
                        <?php
                        $post_types = get_post_types();
                        unset( $post_types['attachment'] );
                        unset( $post_types['revision'] );
                        unset( $post_types['nav_menu_item'] );
                        unset( $post_types['tszf_forms'] );
                        unset( $post_types['tszf_profile'] );

                        foreach ($post_types as $post_type) {
                            printf('<option value="%s"%s>%s</option>', $post_type, selected( $post_type_selected, $post_type, false ), $post_type );
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr class="tszf-post-status">
                <th><?php _e( 'Post Status', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[post_status]">
                        <?php
                        $statuses = get_post_statuses();
                        foreach ($statuses as $status => $label) {
                            printf('<option value="%s"%s>%s</option>', $status, selected( $post_status_selected, $status, false ), $label );
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr class="tszf-post-fromat">
                <th><?php _e( 'Post Format', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[post_format]">
                        <option value="0"><?php _e( '- None -', 'gowatch' ); ?></option>
                        <?php
                        $post_formats = get_theme_support( 'post-formats' );

                        if ( isset($post_formats[0]) && is_array( $post_formats[0] ) ) {
                            foreach ($post_formats[0] as $format) {
                                printf('<option value="%s"%s>%s</option>', $format, selected( $post_format_selected, $format, false ), $format );
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            </tr>

            <tr class="tszf-default-cat">
                <th><?php _e( 'Default Post Category', 'gowatch' ); ?></th>
                <td>
                    <?php
                    wp_dropdown_categories( array(
                        'hide_empty'       => false,
                        'hierarchical'     => true,
                        'selected'         => $default_cat,
                        'name'             => 'tszf_settings[default_cat]',
                        'show_option_none' => __( '- None -', 'gowatch' )
                    ) );
                    ?>
                    <p class="description"><?php echo __( 'If users are not allowed to choose any category, this category will be used instead (if post type supports)', 'gowatch' ); ?></p>
                </td>
            </tr>

            <tr>
                <th><?php _e( 'Guest Post', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="hidden" name="tszf_settings[guest_post]" value="false">
                        <input type="checkbox" name="tszf_settings[guest_post]" value="true"<?php checked( $guest_post, 'true' ); ?> />
                        <?php _e( 'Enable Guest Post', 'gowatch' ) ?>
                    </label>
                    <p class="description"><?php _e( 'Unregistered users will be able to submit posts', 'gowatch' ); ?></p>
                </td>
            </tr>

            <tr class="show-if-guest">
                <th><?php _e( 'User Details', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="hidden" name="tszf_settings[guest_details]" value="false">
                        <input type="checkbox" name="tszf_settings[guest_details]" value="true"<?php checked( $guest_details, 'true' ); ?> />
                        <?php _e( 'Require Name and Email address', 'gowatch' ) ?>
                    </label>
                    <p class="description"><?php _e( 'If requires, users will be automatically registered to the site using the name and email address', 'gowatch' ); ?></p>
                </td>
            </tr>

            <tr class="show-if-guest show-if-details">
                <th><?php _e( 'Name Label', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="text" name="tszf_settings[name_label]" value="<?php echo esc_attr( $name_label ); ?>" />
                    </label>
                    <p class="description"><?php _e( 'Label text for name field', 'gowatch' ); ?></p>
                </td>
            </tr>

            <tr class="show-if-guest show-if-details">
                <th><?php _e( 'E-Mail Label', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="text" name="tszf_settings[email_label]" value="<?php echo esc_attr( $email_label ); ?>" />
                    </label>
                    <p class="description"><?php _e( 'Label text for email field', 'gowatch' ); ?></p>
                </td>
            </tr>

            <tr class="show-if-not-guest">
                <th><?php _e( 'Unauthorized Message', 'gowatch' ); ?></th>
                <td>
                    <textarea rows="3" cols="40" name="tszf_settings[message_restrict]"><?php echo esc_textarea( $message_restrict ); ?></textarea>
                    <p class="description"><?php _e( 'Not logged in users will see this message', 'gowatch' ); ?></p>
                </td>
            </tr>

            <tr class="tszf-redirect-to">
                <th><?php _e( 'Redirect To', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[redirect_to]">
                        <?php
                        $redirect_options = array(
                            'post' => __( 'Newly created post', 'gowatch' ),
                            'same' => __( 'Same Page', 'gowatch' ),
                            'page' => __( 'To a page', 'gowatch' ),
                            'url' => __( 'To a custom URL', 'gowatch' )
                        );

                        foreach ($redirect_options as $to => $label) {
                            printf('<option value="%s"%s>%s</option>', $to, selected( $redirect_to, $to, false ), $label );
                        }
                        ?>
                    </select>
                    <p class="description">
                        <?php _e( 'After successfull submit, where the page will redirect to', 'gowatch' ) ?>
                    </p>
                </td>
            </tr>

            <tr class="tszf-same-page">
                <th><?php _e( 'Message to show', 'gowatch' ); ?></th>
                <td>
                    <textarea rows="3" cols="40" name="tszf_settings[message]"><?php echo esc_textarea( $message ); ?></textarea>
                </td>
            </tr>
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

            <tr class="tszf-comment">
                <th><?php _e( 'Comment Status', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[comment_status]">
                        <option value="open" <?php selected( $comment_status, 'open'); ?>><?php _e('Open', 'gowatch'); ?></option>
                        <option value="closed" <?php selected( $comment_status, 'closed'); ?>><?php _e('Closed', 'gowatch'); ?></option>
                    </select>
                </td>
            </tr>

            <tr class="tszf-submit-text">
                <th><?php _e( 'Submit Post Button text', 'gowatch' ); ?></th>
                <td>
                    <input type="text" name="tszf_settings[submit_text]" value="<?php echo esc_attr( $submit_text ); ?>">
                </td>
            </tr>

            <tr>
                <th><?php _e( 'Post Draft', 'gowatch' ); ?></th>
                <td>
                    <label>
                        <input type="hidden" name="tszf_settings[draft_post]" value="false">
                        <input type="checkbox" name="tszf_settings[draft_post]" value="true"<?php checked( $draft_post, 'true' ); ?> />
                        <?php _e( 'Enable Saving as draft', 'gowatch' ) ?>
                    </label>
                    <p class="description"><?php _e( 'It will show a button to save as draft', 'gowatch' ); ?></p>
                </td>
            </tr>

            <?php do_action( 'tszf_form_setting', $form_settings, $post ); ?>
        </table>
    <?php
    }

    /**
     * Displays settings on post form builder
     *
     * @global object $post
     */
    function form_settings_posts_edit() {
        global $post;

        $form_settings        = tszf_get_form_settings( $post->ID );

        $post_status_selected = isset( $form_settings['edit_post_status'] ) ? $form_settings['edit_post_status'] : 'publish';
        $redirect_to          = isset( $form_settings['edit_redirect_to'] ) ? $form_settings['edit_redirect_to'] : 'same';
        $update_message       = isset( $form_settings['update_message'] ) ? $form_settings['update_message'] : __( 'Post updated successfully', 'gowatch' );
        $page_id              = isset( $form_settings['edit_page_id'] ) ? $form_settings['edit_page_id'] : 0;
        $url                  = isset( $form_settings['edit_url'] ) ? $form_settings['edit_url'] : '';
        $update_text          = isset( $form_settings['update_text'] ) ? $form_settings['update_text'] : __( 'Update', 'gowatch' );
        // $subscription         = isset( $form_settings['subscription'] ) ? $form_settings['subscription'] : null;
        ?>
        <table class="form-table">

            <tr class="tszf-post-status">
                <th><?php _e( 'Set Post Status to', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[edit_post_status]">
                        <?php
                        $statuses = get_post_statuses();

                        foreach ($statuses as $status => $label) {
                            printf('<option value="%s"%s>%s</option>', $status, selected( $post_status_selected, $status, false ), $label );
                        }

                        printf( '<option value="_nochange"%s>%s</option>', selected( $post_status_selected, '_nochange', false ), __( 'No Change', 'gowatch' ) );
                        ?>
                    </select>
                </td>
            </tr>

            <tr class="tszf-redirect-to">
                <th><?php _e( 'Redirect To', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[edit_redirect_to]">
                        <?php
                        $redirect_options = array(
                            'post' => __( 'Newly created post', 'gowatch' ),
                            'same' => __( 'Same Page', 'gowatch' ),
                            'page' => __( 'To a page', 'gowatch' ),
                            'url' => __( 'To a custom URL', 'gowatch' )
                        );

                        foreach ($redirect_options as $to => $label) {
                            printf('<option value="%s"%s>%s</option>', $to, selected( $redirect_to, $to, false ), $label );
                        }
                        ?>
                    </select>
                    <p class="description">
                        <?php _e( 'After successfull submit, where the page will redirect to', 'gowatch' ) ?>
                    </p>
                </td>
            </tr>

            <tr class="tszf-same-page">
                <th><?php _e( 'Post Update Message', 'gowatch' ); ?></th>
                <td>
                    <textarea rows="3" cols="40" name="tszf_settings[update_message]"><?php echo esc_textarea( $update_message ); ?></textarea>
                </td>
            </tr>

            <tr class="tszf-page-id">
                <th><?php _e( 'Page', 'gowatch' ); ?></th>
                <td>
                    <select name="tszf_settings[edit_page_id]">
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
                    <input type="url" name="tszf_settings[edit_url]" value="<?php echo esc_attr( $url ); ?>">
                </td>
            </tr>
            <?php 

            ?>

            <tr class="tszf-update-text">
                <th><?php _e( 'Update Post Button text', 'gowatch' ); ?></th>
                <td>
                    <input type="text" name="tszf_settings[update_text]" value="<?php echo esc_attr( $update_text ); ?>">
                </td>
            </tr>
        </table>
    <?php
    }

    /**
     * Displays settings on post form builder
     *
     * @global object $post
     */
    function form_settings_posts_notification() {
        do_action('tszf_form_settings_post_notification');
    }

    /**
     * Settings for post expiration
     *
     * @global $post
     */
    function form_post_expiration(){
        do_action('tszf_form_post_expiration');
    }

    /**
     * Display settings for user profile builder
     *
     * @return void
     */
    function form_settings_profile() {

        ?>
        <table class="form-table">
            <?php do_action( 'registration_setting' ); ?>
        </table>
        <?php
    }

    function metabox_post_form( $post ) {
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="#tszf-metabox" class="nav-tab" id="tszf-editor-tab"><?php _e( 'Form Editor', 'gowatch' ); ?></a>
            <a href="#tszf-metabox-settings" class="nav-tab" id="tszf-post-settings-tab"><?php _e( 'Post Settings', 'gowatch' ); ?></a>
            <a href="#tszf-metabox-settings-update" class="nav-tab" id="tszf-edit-settings-tab"><?php _e( 'Edit Settings', 'gowatch' ); ?></a>
            <a href="#tszf-metabox-notification" class="nav-tab" id="tszf-notification-tab"><?php _e( 'Notification', 'gowatch' ); ?></a>
            <a href="#tszf-metabox-post_expiration" class="nav-tab" id="tszf-notification-tab"><?php _e( 'Post Expiration', 'gowatch' ); ?></a>

            <?php do_action( 'tszf_post_form_tab' ); ?>
        </h2>

        <div class="tab-content">
            <div id="tszf-metabox" class="group">
                <?php $this->edit_form_area(); ?>
            </div>

            <div id="tszf-metabox-settings" class="group">
                <?php $this->form_settings_posts(); ?>
            </div>

            <div id="tszf-metabox-settings-update" class="group">
                <?php $this->form_settings_posts_edit(); ?>
            </div>

            <div id="tszf-metabox-notification" class="group">
                <?php $this->form_settings_posts_notification(); ?>
            </div>

            <div id="tszf-metabox-post_expiration" class="group tszf-metabox-post_expiration">
                <?php $this->form_post_expiration(); ?>
            </div>

            <?php do_action( 'tszf_post_form_tab_content' ); ?>
        </div>
        <?php
    }

    function metabox_profile_form( $post ) {

        ?>

        <h2 class="nav-tab-wrapper">
            <a href="#tszf-metabox" class="nav-tab" id="tszf_general-tab"><?php _e( 'Form Editor', 'gowatch' ); ?></a>
            <a href="#tszf-metabox-settings" class="nav-tab" id="tszf_dashboard-tab"><?php _e( 'Settings', 'gowatch' ); ?></a>

            <?php do_action( 'tszf_profile_form_tab' ); ?>
        </h2>

        <div class="tab-content">
            <div id="tszf-metabox" class="group">
                <?php $this->edit_form_area_profile(); ?>
            </div>

            <div id="tszf-metabox-settings" class="group">
                <?php $this->form_settings_profile(); ?>
            </div>

            <?php do_action( 'tszf_profile_form_tab_content' ); ?>
        </div>
        <?php
    }

    function form_elements_common() {
        $title = esc_attr( __( 'Click to add to the editor', 'gowatch' ) );
        ?>
        <h2><?php _e( 'Custom Fields', 'gowatch' ); ?></h2>
        <div class="tszf-form-buttons">
            <button class="button" data-name="custom_text" data-type="text" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Text', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_textarea" data-type="textarea" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Textarea', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_select" data-type="select" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Dropdown', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_multiselect" data-type="multiselect" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Multi Select', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_radio" data-type="radio" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Radio', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_checkbox" data-type="checkbox" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Checkbox', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_url" data-type="url" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'URL', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_email" data-type="email" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Email', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_hidden" data-type="hidden" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Hidden Field', 'gowatch' ); ?></button>

            <?php do_action( 'tszf_form_buttons_custom' ); ?>
        </div>

        <h2><?php _e( 'Others', 'gowatch' ); ?></h2>
        <div class="tszf-form-buttons">
            <button class="button" data-name="section_break" data-type="break" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'Section Break', 'gowatch' ); ?></button>
            <button class="button" data-name="custom_html" data-type="html" title="<?php echo airkit_var_sanitize( $title, 'esc_attr' ); ?>"><?php _e( 'HTML', 'gowatch' ); ?></button></button>

            <?php do_action( 'tszf_form_buttons_other' ); ?>
        </div>

        <?php
    }

    /**
     * Form elements for post form builder
     *
     * @return void
     */
    function form_elements_post() {
        ?>
        <div class="tszf-loading hide"></div>

        <h2><?php _e( 'Post Fields', 'gowatch' ); ?></h2>
        <div class="tszf-form-buttons">
            <button class="button" data-name="post_title" data-type="text" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php _e( 'Post Title', 'gowatch' ); ?></button>
            <button class="button" data-name="post_content" data-type="textarea" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php _e( 'Post Body', 'gowatch' ); ?></button>
            <button class="button" data-name="post_excerpt" data-type="textarea" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php _e( 'Excerpt', 'gowatch' ); ?></button>
            <button class="button" data-name="tags" data-type="text" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php _e( 'Tags', 'gowatch' ); ?></button>
            <button class="button" data-name="category" data-type="category" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php _e( 'Category', 'gowatch' ); ?></button>
            <button class="button" data-name="featured_image" data-type="image" title="<?php _e( 'Click to add to the editor', 'gowatch' ); ?>"><?php _e( 'Featured Image', 'gowatch' ); ?></button>

            <?php do_action( 'tszf_form_buttons_post' ); ?>
        </div>


        <h2><?php _e( 'Custom Taxonomies', 'gowatch' ); ?></h2>
        <div class="tszf-form-buttons tszf-custom-taxonomies">

            <?php do_action( 'tszf_form_custom_taxonomies' ); ?>

        </div>


        <?php

        $this->form_elements_common();
        $this->publish_button();
    }

    /**
     * Form elements for Profile Builder
     *
     * @return void
     */
    function form_elements_profile() {
        ?>

        <div class="tszf-loading hide"></div>

        <h2><?php _e( 'Profile Fields', 'gowatch' ); ?></h2>
        <div class="tszf-form-buttons">
            <button class="button" data-name="user_login" data-type="text"><?php _e( 'Username', 'gowatch' ); ?></button>
            <button class="button" data-name="first_name" data-type="textarea"><?php _e( 'First Name', 'gowatch' ); ?></button>
            <button class="button" data-name="last_name" data-type="textarea"><?php _e( 'Last Name', 'gowatch' ); ?></button>
            <button class="button" data-name="nickname" data-type="text"><?php _e( 'Nickname', 'gowatch' ); ?></button>
            <button class="button" data-name="user_email" data-type="category"><?php _e( 'E-mail', 'gowatch' ); ?></button>
            <button class="button" data-name="user_url" data-type="text"><?php _e( 'Website', 'gowatch' ); ?></button>
            <button class="button" data-name="user_bio" data-type="textarea"><?php _e( 'Biographical Info', 'gowatch' ); ?></button>
            <button class="button" data-name="password" data-type="password"><?php _e( 'Password', 'gowatch' ); ?></button>
            <button class="button" data-name="user_avatar" data-type="avatar"><?php _e( 'Avatar', 'gowatch' ); ?></button>

            <?php do_action( 'tszf_form_buttons_user' ); ?>
        </div>

        <?php
        $this->form_elements_common();
        $this->publish_button();
    }

    /**
     * Saves the form settings
     *
     * @param int $post_id
     * @param object $post
     * @return int|void
     */
    function save_form_meta( $post_id, $post, $update ) {

        do_action( 'tszf_check_post_type', $post, $update );

        if ( ! in_array( $post->post_type, array( 'tszf_forms', 'tszf_profile' ) ) ) {
            return;
        }

        if ( !isset($_POST['tszf_form_editor'] ) ) {
            return $post->ID;
        }

        if ( !wp_verify_nonce( $_POST['tszf_form_editor'], plugin_basename( __FILE__ ) ) ) {
            return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if ( !current_user_can( 'edit_post', $post->ID ) ) {
            return $post->ID;
        }

        $conditions = isset( $_POST['tszf_cond'] ) ? $_POST['tszf_cond'] : array();

        if ( count( $conditions ) ) {
            foreach ($conditions as $key => $condition) {
                if ( $condition['condition_status'] == 'no' ) {
                    unset( $conditions[$key] );
                }
            }
        }

        $_POST['tszf_input'] = isset( $_POST['tszf_input'] ) ? $_POST['tszf_input'] : array();

        foreach ( $_POST['tszf_input'] as $key => $field_val ) {
            if ( array_key_exists( 'options', $field_val) ) {
                $view_option = array();

                foreach ( $field_val['options'] as $options_key => $options_value ) {
                    $opt_value = ( $field_val['options_values'][$options_key] == '' ) ? $options_value : $field_val['options_values'][$options_key];
                    $view_option[$opt_value] =   $options_value;//$_POST['tszf_input'][$key]['options'][$opt_value] = $options_value;
                }

                unset($_POST['tszf_input'][$key]['options_values']);
                $_POST['tszf_input'][$key]['options'] = $view_option;
            }


            if ( $field_val['input_type'] == 'taxonomy' ) {
               $tax = get_terms( $field_val['name'],  array(
                    'orderby'    => 'count',
                    'hide_empty' => 0
                ) );

                $tax = is_array( $tax ) ? $tax : array();

                foreach($tax as $tax_obj) {
                    $terms[$tax_obj->term_id] = $tax_obj->name;
                }

                $_POST['tszf_input'][$key]['options'] = $terms;
                $terms = '';
            }
        }

        $contents = self::get_form_fields( $post->ID );

        $db_id = wp_list_pluck( $contents, 'ID' );

        $order = 0;
        foreach( $_POST['tszf_input'] as $key => $content ) {
            $content['tszf_cond'] = $_POST['tszf_cond'][$key];

            $field_id = isset( $content['id'] ) ? intval( $content['id'] ) : 0;

            if ( $field_id ) {
                $compare_id[$field_id] = $field_id;
                unset( $content['id'] );

                self::insert_form_field( $post->ID, $content, $field_id, $order );

            } else {
                self::insert_form_field( $post->ID, $content, null, $order );
            }

            $order++;
        }

        // delete fields from previous form
        $del_post_id = array_diff_key( $db_id, $compare_id );

        if ( $del_post_id ) {

            foreach ($del_post_id as $key => $post_id ) {
                wp_delete_post( $post_id , true );
            }

        } else if ( !count( $_POST['tszf_input'] ) && count( $db_id ) ) {

           foreach ( $db_id as $key => $post_id ) {

                wp_delete_post( $post_id , true );
            }
        }

        update_post_meta( $post->ID, $this->form_settings_key, $_POST['tszf_settings'] );
    }

    /**
     * Get form fields only
     *
     * @param  int $form_id
     * @return array
     */
    public static function get_form_fields( $form_id ) {

        $contents = get_children(array(
            'post_parent' => $form_id,
            'post_status' => 'publish',
            'post_type'   => 'tszf_input',
            'numberposts' => '-1',
            'orderby'     => 'menu_order',
            'order'       => 'ASC',
        ));

        return $contents;
    }

    /**
     * Edit form elements area for post
     *
     * @global object $post
     * @global string $pagenow
     */
    function edit_form_area() {

        global $post, $pagenow, $form_inputs;

        $form_inputs = tszf_get_form_fields( $post->ID );

        ?>

        <input type="hidden" name="tszf_form_editor" id="tszf_form_editor" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

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

            $con_fields = $this->get_conditional_fields( $form_inputs );

            foreach ( $form_inputs as $order => $input_field ) {

                $input_field['template'] = isset( $input_field['template'] ) ? $input_field['template'] : '';
                $method = $input_field['template'];

                $name = ucwords( str_replace( '_', ' ', $input_field['template'] ) );
                if ( isset( $cond_inputs[$order] ) ) {
                    $input_field = array_merge( $input_field, $cond_inputs[$order] );
                }

                if ( $method == 'taxonomy') {
                    TSZF_Admin_Template_Post::$method( $count, $name, $input_field['name'], $input_field );

                } else if ( method_exists( 'TSZF_Admin_Template_Post', $method ) ) {
                    TSZF_Admin_Template_Post::$method( $count, $name, $input_field );

                } else {
                    do_action( 'tszf_admin_template_post_' . $input_field['template'], $name, $count, $input_field, 'TSZF_Admin_Template_Post', $this );
                }

                $count++;
            }
        }
        ?>
        </ul>

        <?php
    }

    /**
     * Get all conditional fields
     *
     * @param  array $fields
     * @return array
     */
    public static function get_conditional_fields( $fields ) {

        $conditionals = array(
            'fields' => array(),
            'options' => array()
        );

        foreach ($fields as $field) {

            if ( !isset( $field['input_type'] ) ) {
                continue;
            }

            if ( !in_array( $field['input_type'], array('select', 'radio', 'checkbox', 'taxonomy')) ) {
                continue;
            }

            $conditionals['fields'][$field['name']] = $field['label'];
            $conditionals['options'][$field['name']] = $field['options'];
        }

        return $conditionals;
    }

    /**
     * Get only conditional options from fields
     *
     * @param  array $fields
     * @return array
     */
    public static function get_conditional_option( $fields ) {

        $conditionals = array(
            'fields' => array(),
            'options' => array()
        );

        foreach ($fields as $field) {

            if ( !in_array( $field['input_type'], array('select', 'radio', 'checkbox')) ) {
                continue;
            }

            $conditionals['fields'][$field['name']] = $field['label'];
            $conditionals['options'][$field['name']] = $field['options'];
        }

        return $conditionals;
    }

    /**
     * Generate a conditional field dropdown
     *
     * @param  array $fields
     * @return array
     */
    public static function get_conditional_fields_dropdown( $fields ) {

        $options = array('' => '- select -');

        if ( count( $fields ) ) {



            foreach ($fields as $key => $label) {
                $options[$key] = $label;
            }
        }

        return $options;
    }

    /**
     * Generate a conditional field dropdown
     *
     * @param  array $fields
     * @return array
     */
    public static function get_conditional_option_dropdown( $fields ) {

        $options = array('' => '- select -');

        if ( count( $fields ) ) {
            foreach ($fields as $key => $label) {
                $options[$key] = $label;
            }
        }

        return $options;
    }

    /**
     * Edit form elements area for profile
     *
     * @global object $post
     * @global string $pagenow
     */
    function edit_form_area_profile() {
        
        ?>
        <input type="hidden" name="tszf_form_editor" id="tszf_form_editor" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
        <?php
        do_action( 'tszf_edit_form_area_profile' );
    }

    /**
     * Ajax Callback handler for insrting fields in forms
     *
     * @return void
     */
    function ajax_post_add_element() {

        $name = $_POST['name'];
        $type = $_POST['type'];
        $field_id = $_POST['order'];

        switch ($name) {
            case 'post_title':
                TSZF_Admin_Template_Post::post_title( $field_id, 'Post Title');
                break;

            case 'post_content':
                TSZF_Admin_Template_Post::post_content( $field_id, 'Post Body');
                break;

            case 'post_excerpt':
                TSZF_Admin_Template_Post::post_excerpt( $field_id, 'Excerpt');
                break;

            case 'tags':
                TSZF_Admin_Template_Post::post_tags( $field_id, 'Tags');
                break;

            case 'featured_image':
                TSZF_Admin_Template_Post::featured_image( $field_id, 'Featured Image');
                break;

            case 'custom_text':
                TSZF_Admin_Template_Post::text_field( $field_id, 'Custom field: Text');
                break;

            case 'custom_textarea':
                TSZF_Admin_Template_Post::textarea_field( $field_id, 'Custom field: Textarea');
                break;

            case 'custom_select':
                TSZF_Admin_Template_Post::dropdown_field( $field_id, 'Custom field: Select');
                break;

            case 'custom_image':
                TSZF_Admin_Template::image_upload( $field_id, 'Custom field: Image' );
                break;

            case 'custom_multiselect':
                TSZF_Admin_Template_Post::multiple_select( $field_id, 'Custom field: Multiselect');
                break;

            case 'custom_radio':
                TSZF_Admin_Template_Post::radio_field( $field_id, 'Custom field: Radio');
                break;

            case 'custom_checkbox':
                TSZF_Admin_Template_Post::checkbox_field( $field_id, 'Custom field: Checkbox');
                break;

            case 'custom_url':
                TSZF_Admin_Template_Post::website_url( $field_id, 'Custom field: URL');
                break;

            case 'custom_email':
                TSZF_Admin_Template_Post::email_address( $field_id, 'Custom field: E-Mail');
                break;

            case 'custom_html':
                TSZF_Admin_Template_Post::custom_html( $field_id, 'HTML' );
                break;

            case 'category':
                TSZF_Admin_Template_Post::taxonomy( $field_id, 'Category', $type );
                break;

            case 'taxonomy':
                TSZF_Admin_Template_Post::taxonomy( $field_id, 'Taxonomy: ' . $type, $type );
                break;

            case 'section_break':
                TSZF_Admin_Template_Post::section_break( $field_id, 'Section Break' );
                break;

            case 'custom_hidden':
                TSZF_Admin_Template_Post::custom_hidden_field( $field_id, 'Hidden Field' );
                break;

            case 'user_login':
                TSZF_Admin_Template_Profile::user_login( $field_id, __( 'Username', 'gowatch' ) );
                break;

            case 'first_name':
                TSZF_Admin_Template_Profile::first_name( $field_id, __( 'First Name', 'gowatch' ) );
                break;

            case 'last_name':
                TSZF_Admin_Template_Profile::last_name( $field_id, __( 'Last Name', 'gowatch' ) );
                break;

            case 'nickname':
                TSZF_Admin_Template_Profile::nickname( $field_id, __( 'Nickname', 'gowatch' ) );
                break;

            case 'user_email':
                TSZF_Admin_Template_Profile::user_email( $field_id, __( 'E-mail', 'gowatch' ) );
                break;

            case 'user_url':
                TSZF_Admin_Template_Profile::user_url( $field_id, __( 'Website', 'gowatch' ) );
                break;

            case 'user_bio':
                TSZF_Admin_Template_Profile::description( $field_id, __( 'Biographical Info', 'gowatch' ) );
                break;

            case 'password':
                TSZF_Admin_Template_Profile::password( $field_id, __( 'Password', 'gowatch' ) );
                break;

            case 'user_avatar':
                TSZF_Admin_Template_Profile::avatar( $field_id, __( 'Avatar', 'gowatch' ) );
                break;

            default:
                do_action( 'tszf_admin_field_' . $name, $type, $field_id, 'TSZF_Admin_Template_Post', $this );
                break;
        }

        exit;
    }

}