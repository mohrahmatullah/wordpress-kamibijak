<?php
define( 'TSZF_VERSION', '2.3.13' );
define( 'TSZF_FILE', __FILE__ );
define( 'TSZF_ROOT', get_template_directory() . '/includes/frontend-submission' );
define( 'CHILD_TSZF_ROOT', get_stylesheet_directory() . '/includes/frontend-submission' );
define( 'TSZF_ROOT_URI', get_template_directory_uri() . '/includes/frontend-submission' );
define( 'TSZF_ASSET_URI', TSZF_ROOT_URI . '/assets' );

/**
 * Autoload class files on demand
 *
 * `TSZF_Form_Posting` becomes => form-posting.php
 * `TSZF_Dashboard` becomes => dashboard.php
 *
 * @param string $class requested class name
 */
function tszf_autoload( $class ) {

    if ( stripos( $class, 'TSZF_' ) !== false ) {

        $admin = ( stripos( $class, '_Admin_' ) !== false ) ? true : false;

        if ( $admin ) {
            $class_name = str_replace( array('TSZF_Admin_', '_'), array('', '-'), $class );
            $filename = TSZF_ROOT . '/admin/' . strtolower( $class_name ) . '.php';
            $child_theme_filename = CHILD_TSZF_ROOT . '/admin/' . strtolower( $class_name ) . '.php';
        } else {
            $class_name = str_replace( array('TSZF_', '_'), array('', '-'), $class );
            $filename = TSZF_ROOT . '/class/' . strtolower( $class_name ) . '.php';
            $child_theme_filename = CHILD_TSZF_ROOT . '/class/' . strtolower( $class_name ) . '.php';
        }

        // This is autoload and it works.
        if ( file_exists($child_theme_filename) ) {
            require_once $child_theme_filename;
        } elseif ( file_exists( $filename ) ) {
            require_once $filename;
        }
    }
}

spl_autoload_register( 'tszf_autoload' );

/**
 * Main bootstrap class for Touchsize Frontend Submission
 *
 * @package Touchsize Frontend Submission
 */
class TSZF_User_Frontend {

    private static $_instance;
    private $is_pro = false;

    function __construct() {

        $this->includes();

        $this->instantiate();

        // set schedule event
        add_action( 'tszf_remove_expired_post_hook', array( $this, 'action_to_remove_exipred_post' ) );

        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin_scripts') );

    }


    /**
     * Action when posts expiration date is passed
     *
     */
    public function action_to_remove_exipred_post(){
        $args = array(
            'meta_key'       => 'tszf-post_expiration_date',
            'meta_value'     => date('Y-m-d'),
            'post_type'      => get_post_types(),
            'post_status'    => 'publish',
            'posts_per_page' => -1
        );

        $mail_subject = apply_filters( 'tszf_post_expiry_mail_subject', sprintf( '[%s] %s', get_bloginfo( 'name' ), __( 'Your Post Has Been Expired', 'gowatch' ) ) );
        $posts        = get_posts( $args );

        foreach ($posts as $each_post) {
            $post_to_update = array(
                'ID'           => $each_post->ID,
                'post_status'  => get_post_meta( $each_post->ID, 'tszf-expired_post_status', true ) ? get_post_meta( $each_post->ID, 'tszf-expired_post_status', true ) : 'draft'
            );

            wp_update_post( $post_to_update );

            if ( $message = get_post_meta( $each_post->ID, 'tszf-post_expiration_message', true ) ) {
                wp_mail( $each_post->post_author, $mail_subject, $message );
            }
        }
    }

    public static function init() {

        if ( !self::$_instance ) {
            self::$_instance = new TSZF_User_Frontend();
        }

        return self::$_instance;
    }

    public function includes() {

        require_once TSZF_ROOT . '/tszf-functions.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'

        $is_expired = false;
        $has_pro = true;


        if ( ! $is_expired && $has_pro ) {
            
            require_once TSZF_ROOT . '/includes/tszf/loader.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'

            $this->is_pro = true;

        }

        if ( is_admin() ) {
            require_once TSZF_ROOT . '/admin/settings-options.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'
        }

    }

    /**
     * Instantiate the classes
     *
     * @return void
     */
    function instantiate() {

        new TSZF_Upload();

        TSZF_Frontend_Form_Post::init(); // requires for form preview

        if ( is_admin() ) {
            
            TSZF_Admin_Settings::init();
            new TSZF_Admin_Form();
            new TSZF_Admin_Posting();
            new TSZF_Admin_Installer();

        } else {

            new TSZF_Frontend_Dashboard();

        }
    }

    /**
     * Enqueues Styles and Scripts when the shortkeys are used only
     *
     * @uses has_shortkey()
     */
    function enqueue_scripts() {
        global $post;

        $scheme = is_ssl() ? 'https' : 'http';

        if ( isset ( $post->ID ) ) {
            ?>
            <script type="text/javascript" id="tszf-language-script">
                var error_str_obj = {
                    'required' : '<?php _e( 'is required', 'gowatch' ); ?>',
                    'mismatch' : '<?php _e( 'does not match', 'gowatch' ); ?>',
                    'validation' : '<?php _e( 'is not valid', 'gowatch' ); ?>'
                }
            </script>
            <?php
            wp_enqueue_script( 'tszf-form', TSZF_ASSET_URI . '/js/frontend-form.js', array('jquery'), false, true );
            wp_enqueue_script( 'tszf-repeat-field', TSZF_ASSET_URI . '/js/repeat-field.js', array('jquery'), false, true );
            wp_enqueue_script( 'tszf-conditional-logic', TSZF_ASSET_URI . '/js/conditional-logic.js', array('jquery'), false, true );
        }

        if ( tszf_get_option( 'load_script', 'tszf_general', 'on') == 'on') {
            $this->plugin_scripts();
        } else if ( tszf_has_shortkey( 'tszf_form' ) || tszf_has_shortkey( 'tszf_edit' ) || tszf_has_shortkey( 'tszf_profile' ) || tszf_has_shortkey( 'tszf_dashboard' ) ) {
            $this->plugin_scripts();
        }
    }


    /**
     * Enqueues scripts for backend.
     *
     * @uses has_shortcode()
     */
    function enqueue_admin_scripts() {
        global $post;
        wp_enqueue_script( 'tszf-repeat-field', TSZF_ASSET_URI . '/js/repeat-field.js', array('jquery'), false, true );
        wp_localize_script( 'tszf-upload', 'tszf_frontend_upload', array(
            'confirmMsg' => __( 'Are you sure?', 'gowatch' ),
            'nonce'      => wp_create_nonce( 'tszf_nonce' ),
            'ajaxurl'    => admin_url( 'admin-ajax.php' ),
            'plupload'   => array(
                'url'              => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'tszf-upload-nonce' ),
                'flash_swf_url'    => includes_url( 'js/plupload/plupload.flash.swf' ),
                'filters'          => array(array('title' => __( 'Allowed Files', 'gowatch' ), 'extensions' => '*')),
                'multipart'        => true,
                'urlstream_upload' => true,
            )
        ));        
    }

    function plugin_scripts() {

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script( 'suggest' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'plupload-handlers' );
        wp_enqueue_script( 'jquery-ui-timepicker', TSZF_ASSET_URI . '/js/jquery-ui-timepicker-addon.js', array('jquery-ui-datepicker'), false, true );
        wp_enqueue_script( 'tszf-upload', TSZF_ASSET_URI . '/js/upload.js', array('jquery', 'plupload-handlers'), false, true );

        wp_localize_script( 'tszf-form', 'tszf_frontend', array(
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'error_message' => __( 'Please fix the errors to proceed', 'gowatch' ),
            'nonce'         => wp_create_nonce( 'tszf_nonce' )
        ) );

        wp_localize_script( 'tszf-upload', 'tszf_frontend_upload', array(
            'confirmMsg' => __( 'Are you sure?', 'gowatch' ),
            'nonce'      => wp_create_nonce( 'tszf_nonce' ),
            'ajaxurl'    => admin_url( 'admin-ajax.php' ),
            'plupload'   => array(
                'url'              => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'tszf-upload-nonce' ),
                'flash_swf_url'    => includes_url( 'js/plupload/plupload.flash.swf' ),
                'filters'          => array(array('title' => __( 'Allowed Files', 'gowatch' ), 'extensions' => '*')),
                'multipart'        => true,
                'urlstream_upload' => true,
            )
        ));
    }

    /**
     * Block user access to admin panel for specific roles
     *
     * @global string $pagenow
     */
    function block_admin_access() {
        global $pagenow;

        // bail out if we are from WP Cli
        if ( defined( 'WP_CLI' ) ) {
            return;
        }

        $access_level = tszf_get_option( 'admin_access', 'tszf_general', 'read' );
        $valid_pages  = array('admin-ajax.php', 'admin-post.php', 'async-upload.php', 'media-upload.php');

        if ( ! current_user_can( $access_level ) && !in_array( $pagenow, $valid_pages ) ) {
            // wp_die( __( 'Access Denied. Your site administrator has blocked your access to the WordPress back-office.', 'gowatch' ) );
            wp_redirect( home_url() );
            exit;
        }
    }


    /**
     * The main logging function
     *
     * @uses error_log
     * @param string $type type of the error. e.g: debug, error, info
     * @param string $msg
     */
    public static function log( $type = '', $msg = '' ) {
        $msg = sprintf( "[%s][%s] %s\n", date( 'd.m.Y h:i:s' ), $type, $msg );
        error_log( $msg, 3, TSZF_ROOT . '/log.txt' );
    }

    /**
     * Returns if the plugin is in PRO version
     *
     * @return boolean
     */
    public function is_pro() {
        return $this->is_pro;
    }


    /**
     * Show renew prompt once the license key is expired
     *
     * @return void
     */
    function license_expired() {
        echo '';
    }

}

/**
 * Returns the singleton instance
 *
 * @return \TSZF_User_Frontend
 */
function tszf() {
    return TSZF_User_Frontend::init();
}

// kickoff the plugin
tszf();