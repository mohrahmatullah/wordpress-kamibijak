<?php

class TSZF_Admin_Posting_Profile extends TSZF_Admin_Posting {

    function __construct() {

        add_action( 'personal_options_update', array($this, 'save_fields') );
        add_action( 'edit_user_profile_update', array($this, 'save_fields') );

        add_action( 'show_user_profile', array($this, 'render_form') );
        add_action( 'edit_user_profile', array($this, 'render_form') );

        add_action( 'personal_options_update', array($this, 'post_lock_update') );
        add_action( 'edit_user_profile_update', array($this, 'post_lock_update') );

        add_action( 'show_user_profile', array($this, 'post_lock_form') );
        add_action( 'edit_user_profile', array($this, 'post_lock_form') );

        add_action( 'wp_ajax_tszf_delete_avatar', array($this, 'delete_avatar_ajax') );
        add_action( 'wp_ajax_nopriv_tszf_delete_avatar', array($this, 'delete_avatar_ajax') );

        add_action( 'admin_enqueue_scripts', array($this, 'user_profile_scripts') );
    }

    /**
     * User profile edit related scripts
     *
     * @param  string $hook
     *
     * @return void
     */
    function user_profile_scripts( $hook ) {
        if ( ! in_array( $hook, array( 'profile.php', 'user-edit.php', 'user-add-post.php' ) ) ) {
            return;
        }

        $scheme = is_ssl() ? 'https' : 'http';
        wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?key=AIzaSyBigTQD4E05c8Tk7XgGvJkyP8L9qnzN3ro&sensor=true' );
        wp_enqueue_script( 'jquery-ui-autocomplete' );
    }

    function delete_avatar_ajax() {

        if ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) {
            $user_id = $_POST['user_id'];
        } else {
            $user_id = get_current_user_id();
        }

        $avatar = get_user_meta( $user_id, 'user_avatar', true );
        if ( $avatar ) {
            $upload_dir = wp_upload_dir();

            $full_url = str_replace( $upload_dir['baseurl'],  $upload_dir['basedir'], $avatar );

            if ( file_exists( $full_url ) ) {
                unlink( $full_url );
                delete_user_meta( $user_id, 'user_avatar' );
            }
        }

        die();
    }

    function get_role_name( $userdata ) {
        return reset( $userdata->roles );
    }

    function render_form( $userdata, $post_id = NULL, $preview = false ) {
        $option = get_option( 'tszf_profile', array() );

        if ( !isset( $option['roles'][$this->get_role_name( $userdata )] ) || empty( $option['roles'][$this->get_role_name( $userdata )] ) ) {
            return;
        }

        $form_id = $option['roles'][$this->get_role_name( $userdata )];
        list($post_fields, $taxonomy_fields, $custom_fields) = $this->get_input_fields( $form_id );

        if ( !$custom_fields ) {
            return;
        }
        ?>

        <input type="hidden" name="tszf_cf_update" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
        <input type="hidden" name="tszf_cf_form_id" value="<?php echo airkit_var_sanitize( $form_id, 'true' ); ?>" />

        <table class="form-table tszf-cf-table">
            <tbody>
                <?php
                // reset -> get the first item
                $item = $this->search( $post_fields, 'name', 'avatar' );
                if ( $avatar = reset( $item ) ) {
                    $this->render_item_before( $avatar );
                    $this->image_upload( $avatar, $userdata->ID, 'user', $form_id );
                    $this->render_item_after( $avatar );
                }

                $this->render_items( $custom_fields, $userdata->ID, 'user', $form_id, get_post_meta( $form_id, 'tszf_form', true ) );
                ?>
            </tbody>
        </table>
        <?php
        $this->scripts_styles();
    }

    function save_fields( $user_id ) {

        global $post;
        !is_object( $post ) ? $post = new stdClass():'';
        !isset ( $post->ID ) ? $post->ID = '' : '';

        if ( !isset( $_POST['tszf_cf_update'] ) ) {
            return $post->ID;
        }

        if ( !wp_verify_nonce( $_POST['tszf_cf_update'], plugin_basename( __FILE__ ) ) ) {
            return $post->ID;
        }

        list($post_fields, $taxonomy_fields, $custom_fields) = self::get_input_fields( $_POST['tszf_cf_form_id'] );
        TSZF_Frontend_Form_Profile::update_user_meta( $custom_fields, $user_id );
    }

    /**
     * Adds the postlock form in users profile
     *
     * @param object $profileuser
     */
    function post_lock_form( $profileuser ) {

        if ( is_admin() && current_user_can( 'edit_users' ) ) {
            $select = ( $profileuser->tszf_postlock == 'yes' ) ? 'yes' : 'no';
            ?>

            <h3><?php _e( 'tszf Post Lock', 'gowatch' ); ?></h3>
            <table class="form-table">
                <tr>
                    <th><label for="tszf-post-lock"><?php _e( 'Lock Post:', 'gowatch' ); ?> </label></th>
                    <td>
                        <select name="tszf_postlock" id="tszf-post-lock">
                            <option value="no"<?php selected( $select, 'no' ); ?>>No</option>
                            <option value="yes"<?php selected( $select, 'yes' ); ?>>Yes</option>
                        </select>
                        <span class="description"><?php _e( 'Lock user from creating new post.', 'gowatch' ); ?></span></em>
                    </td>
                </tr>

                <tr>
                    <th><label for="tszf_lock_cause"><?php _e( 'Lock Reason:', 'gowatch' ); ?> </label></th>
                    <td>
                        <input type="text" name="tszf_lock_cause" id="tszf_lock_cause" class="regular-text" value="<?php echo esc_attr( $profileuser->tszf_lock_cause ); ?>" />
                    </td>
                </tr>
            </table>
            <?php
        }
    }

    /**
     * Update user profile lock
     *
     * @param int $user_id
     */
    function post_lock_update( $user_id ) {
        if ( is_admin() && current_user_can( 'edit_users' ) ) {
            update_user_meta( $user_id, 'tszf_postlock', $_POST['tszf_postlock'] );
            update_user_meta( $user_id, 'tszf_lock_cause', $_POST['tszf_lock_cause'] );
        }
    }

}