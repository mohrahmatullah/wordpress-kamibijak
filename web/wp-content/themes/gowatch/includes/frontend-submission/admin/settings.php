<?php

/**
 * WordPress settings API demo class
 *
 * @author TouchSize
 */
class TSZF_Admin_Settings {

    private $settings_api;
    private static $_instance;

    function __construct() {

        if ( !class_exists( 'TSZF_Settings_API' ) ) {
            require_once TSZF_ROOT . '/lib/class.settings-api.php';
        }

        $this->settings_api = new TSZF_Settings_API();

        add_action( 'admin_init', array($this, 'admin_init') );

    }

    // Instantiate singleton.
    public static function init() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function admin_init() {

        if ( isset( $_GET['page'] ) && $_GET['page'] != 'gowatch' ) {
            return;
        }

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }


    /**
     * tszf Settings sections
     *
     * @since 1.0
     * @return array
     */
    function get_settings_sections() {
        return tszf_settings_sections();
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        return tszf_settings_fields();
    }

    function plugin_page() {
        ?>
        
            <?php
            settings_errors();

            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
            ?>

        
        <?php
    }


    /**
     * Hanlde tools page action
     *
     * @return void
     */
    function handle_tools_action() {
        if ( ! isset( $_GET['tszf_action'] ) ) {
            return;
        }

        check_admin_referer( 'tszf-tools-action' );

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        global $wpdb;

        $action  = $_GET['tszf_action'];
        $message = 'del_forms';

        switch ($action) {
            case 'clear_settings':
                delete_option( 'tszf_general' );
                delete_option( 'tszf_dashboard' );
                delete_option( 'tszf_profile' );
                delete_option( '_tszf_page_created' );

                $message = 'settings_cleared';
                break;

            case 'del_post_forms':
                $this->delete_post_type( 'tszf_forms' );
                break;

            case 'del_pro_forms':
                $this->delete_post_type( 'tszf_profile' );
                break;

            default:
                # code...
                break;
        }

        wp_redirect( add_query_arg( array( 'msg' => $message ), admin_url( 'admin.php?page=tszf_tools&action=tools' ) ) );
        exit;
    }

    /**
     * Delete all posts by a post type
     *
     * @param  string $post_type
     * @return void
     */
    function delete_post_type( $post_type ) {
        $query = new WP_Query( array(
            'post_type'      => $post_type,
            'posts_per_page' => -1,
            'post_status'    => array( 'publish', 'draft', 'pending', 'trash' )
        ) );

        $posts = $query->get_posts();

        if ( $posts ) {
            foreach ($posts as $item) {
                wp_delete_post( $item->ID, true );
            }
        }
    }
}