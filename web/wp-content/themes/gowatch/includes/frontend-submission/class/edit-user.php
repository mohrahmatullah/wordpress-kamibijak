<?php
require_once(ABSPATH . '/wp-admin/includes/user.php');

function tszf_edit_users() {

    ob_start();
    //if user is logged in
    if ( is_user_logged_in() ) {

        //this user can edit the users
        if ( current_user_can( 'edit_users' ) ) {

            $action = isset( $_GET['action'] ) ? $_GET['action'] : 'show';
            $user_id = isset( $_GET['user_id'] ) ? intval( $_GET['user_id'] ) : 0;
            $userdata = get_userdata( $user_id );

            switch ($action) {
                case 'edit':
                    //if user exists
                    if ( $user_id && $userdata ) {
                        TSZF_Edit_Profile::show_form( $user_id );
                    } else {
                        printf( __( "User doesn't exists", 'gowatch' ) );
                    }
                    break;

                case 'tszf_add_user':
                    tszf_add_user();
                    break;

                default: tszf_show_users();
            }
        } else { // user don't have any permission
            printf( __( "You don't have permission for this purpose", 'gowatch' ) );
        }
    } else { //user is not logged in
        printf( __( "This page is restricted. Please %s to view this page.", 'gowatch' ), wp_loginout( '', false ) );
    }

    return ob_get_clean();
}


function tszf_show_users() {
    global $wpdb, $userdata;

    //delete user
    if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "del" ) {

        $nonce = $_REQUEST['_wpnonce'];
        if ( !wp_verify_nonce( $nonce, 'tszf_del_user' ) ) {
            wp_die( 'Cheting?' );
        }

        $delete_flag = false;

        //get users info
        $cur_user = $userdata->ID;
        $to_be_deleted = ( isset( $_GET['user_id'] ) ) ? intval( $_GET['user_id'] ) : 0;

        //user can't delete himself and not the admin, whose id is 1
        if ( $cur_user != $to_be_deleted && $to_be_deleted != 1 ) {

            //check that user exists
            $get_user = get_userdata( $to_be_deleted );
            if ( $get_user ) {
                $delete_flag = true;
            }
        }

        //var_dump($to_be_deleted);
        //delete the user
        if ( current_user_can( 'delete_users' ) && $delete_flag == true ) {
            //var_dump($userdata);
            wp_delete_user( $to_be_deleted );
            echo '<div class="success airkit_alert alert-success">' . __( 'User Deleted', 'gowatch' ) . '</div>';
        } else {
            echo '<div class="error airkit_alert alert-danger">Cheatin&#8217; uh?</div>';
        }
    }

    $sql = "SELECT ID, display_name FROM $wpdb->users ORDER BY user_registered ASC";
    $users = $wpdb->get_results( $sql );
    ?>

    <a class="tszf-button" href="<?php the_permalink(); ?>?action=tszf_add_user">Add New User</a>

    <?php if ( $users ) : ?>
        <table class="tszf-table" cellpadding="0" cellspacing="0">
            <tr>
                <th><?php _e( 'Username', 'gowatch' ); ?></th>
                <th><?php _e( 'Action', 'gowatch' ); ?></th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><a href="<?php echo get_author_posts_url( $user->ID ); ?>"><?php printf( esc_attr__( '%s', 'gowatch' ), $user->display_name ); ?></td>
                    <td>
                        <a href="<?php echo wp_nonce_url(get_permalink() . '?action=edit&user_id='. $user->ID, 'tszf_edit_user'); ?>"><?php _e( 'Edit', 'gowatch' ); ?></a>
                        <a href="<?php echo wp_nonce_url( the_permalink( 'echo=false' ) . "?action=del&user_id=" . $user->ID, 'tszf_del_user' ) ?>" onclick="return confirm('Are you sure to delete this user?');"><span style="color: red;"><?php _e( 'Delete', 'gowatch' ); ?></span></a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </table>

    <?php endif; ?>

    <?php
}

function tszf_add_user() {
    global $wp_error;
    //get admin template file. wp_dropdown_role is there :(
    require_once(ABSPATH . '/wp-admin/includes/template.php');
    ?>
    <?php if ( current_user_can( 'create_users' ) ) : ?>

        <h3><?php _e( 'Add New User', 'gowatch' ); ?></h3>

        <?php
        if ( isset( $_POST['tszf_new_user_submit'] ) ) {
            $errors = array();

            $username = sanitize_user( $_POST['user_login'] );
            $email = trim( $_POST['user_email'] );
            $role = $_POST['role'];

            $error = null;
            $error = tszf_register_new_user( $username, $email, $role );
            if ( !is_wp_error( $error ) ) {
                echo '<div class="success airkit_alert alert-success">' . __( 'User Added', 'gowatch' ) . '</div>';
            } else {
                echo '<div class="error airkit_alert alert-danger">' . $error->get_error_message() . '</div>';
            }
        }
        ?>

        <form action="" method="post">

            <ul class="tszf-post-form">
                <li>
                    <label for="user_login">
                        <?php _e( 'Username', 'gowatch' ); ?> <span class="required">*</span>
                    </label>
                    <input type="text" name="user_login" id="user_login" minlength="2" value="<?php if ( isset( $_POST['user_login'] ) ) echo tszf_clean_tags( $_POST['user_login'] ); ?>">
                    <div class="clear"></div>
                </li>

                <li>
                    <label for="user_email">
                        <?php _e( 'Email', 'gowatch' ); ?> <span class="required">*</span>
                    </label>
                    <input type="text" name="user_email" id="user_email" minlength="2" value="<?php if ( isset( $_POST['user_email'] ) ) echo tszf_clean_tags( $_POST['user_email'] ); ?>">
                    <div class="clear"></div>
                </li>

                <li>
                    <label for="role">
                        <?php _e( 'Role', 'gowatch' ); ?>
                    </label>

                    <select name="role" id="role">
                        <?php
                        if ( !$new_user_role ) {
                            $new_user_role = !empty( $current_role ) ? $current_role : get_option( 'default_role' );
                        }
                        wp_dropdown_roles( $new_user_role );
                        ?>
                    </select>

                    <div class="clear"></div>
                </li>

                <li>
                    <label>&nbsp;</label>
                    <input class="tszf_submit" type="submit" name="tszf_new_user_submit" value="<?php echo esc_attr( __( 'Add New User', 'gowatch' ) ); ?>">
                </li>

            </ul>

        </form>

    <?php endif; ?>

    <?php
}

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function tszf_register_new_user( $user_login, $user_email, $role ) {
    $errors = new WP_Error();

    $sanitized_user_login = sanitize_user( $user_login );
    $user_email = apply_filters( 'user_registration_email', $user_email );

    // Check the username
    if ( $sanitized_user_login == '' ) {
        $errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.', 'gowatch' ) );
    } elseif ( !validate_username( $user_login ) ) {
        $errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.', 'gowatch' ) );
        $sanitized_user_login = '';
    } elseif ( username_exists( $sanitized_user_login ) ) {
        $errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.', 'gowatch' ) );
    }

    // Check the e-mail address
    if ( $user_email == '' ) {
        $errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.', 'gowatch' ) );
    } elseif ( !is_email( $user_email ) ) {
        $errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.', 'gowatch' ) );
        $user_email = '';
    } elseif ( email_exists( $user_email ) ) {
        $errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.', 'gowatch' ) );
    }

    do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

    $errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

    if ( $errors->get_error_code() )
        return $errors;

    $user_pass = wp_generate_password( 12, false );
    //$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );

    $userdata = array(
        'user_login' => $sanitized_user_login,
        'user_email' => $user_email,
        'user_pas' => $user_pass,
        'role' => $role
    );

    $user_id = wp_insert_user( $userdata );

    if ( !$user_id ) {
        $errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'gowatch' ), get_option( 'admin_email' ) ) );
        return $errors;
    }

    update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

    wp_send_new_user_notifications( $user_id );

    return $user_id;
}
