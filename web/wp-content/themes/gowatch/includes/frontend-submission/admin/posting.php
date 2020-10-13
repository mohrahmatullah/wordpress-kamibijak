<?php

/**
 * Admin side posting handler
 *
 * Builds custom fields UI for post add/edit screen
 * and handles value saving.
 *
 * @package Touchsize Frontend Submission
 */
class TSZF_Admin_Posting extends TSZF_Render_Form {

    function __construct() {
        add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_script') );

        add_action( 'save_post', array($this, 'save_meta'), 1, 2 ); // save the custom fields
    }

    function enqueue_script() {
        global $pagenow;

        if ( !in_array( $pagenow, array('profile.php', 'post-new.php', 'post.php', 'user-edit.php') ) ) {
            return;
        }

        $scheme = is_ssl() ? 'https' : 'http';

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'jquery-ui-timepicker', TSZF_ASSET_URI . '/js/jquery-ui-timepicker-addon.js', array('jquery-ui-datepicker') );
        wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?key=AIzaSyBigTQD4E05c8Tk7XgGvJkyP8L9qnzN3ro&sensor=true' );

        wp_enqueue_script( 'tszf-upload', TSZF_ASSET_URI . '/js/upload.js', array('jquery', 'plupload-handlers') );
        wp_localize_script( 'tszf-upload', 'tszf_frontend_upload', array(
            'confirmMsg' => __( 'Are you sure?', 'gowatch' ),
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'tszf_nonce' ),
            'plupload' => array(
                'url' => admin_url( 'admin-ajax.php' ) . '?nonce=' . wp_create_nonce( 'tszf_featured_img' ),
                'flash_swf_url' => includes_url( 'js/plupload/plupload.flash.swf' ),
                'filters' => array(array('title' => __( 'Allowed Files', 'gowatch' ), 'extensions' => '*')),
                'multipart' => true,
                'urlstream_upload' => true,
            )
        ) );
    }

    function add_meta_boxes() {


        $form_id = get_frontend_submission_active_id();
        $form_settings = tszf_get_form_settings( $form_id );

        $post_type = isset( $form_settings['post_type'] ) ? $form_settings['post_type'] : false ;

        if ( !isset( $post_type ) || $post_type == false ) {
            return;
        }

        add_meta_box( 'tszf-custom-fields', __( 'Frontend Submission Custom Fields', 'gowatch' ), array($this, 'render_form'), $post_type, 'normal', 'high' );

    }

    function hide_form() {
        ?>
        <style type="text/css">
            #tszf-custom-fields { display: none; }
        </style>
        <?php
    }

    function render_form( $form_id, $post_id = null, $preview = false) {
        global $post;

        // On Edit post, show form that is currently set to active.
        $form_id = get_frontend_submission_active_id();
        $form_settings = tszf_get_form_settings( $form_id );


        // hide the metabox itself if no form ID is set
        if ( !$form_id ) {
            $this->hide_form();
            return;
        }

        list($post_fields, $taxonomy_fields, $custom_fields) = $this->get_input_fields( $form_id, $post->ID );

        if ( empty( $custom_fields ) ) {
            _e( 'No custom fields found.', 'gowatch' );
            return;
        }
        ?>

        <input type="hidden" name="tszf_cf_update" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
        <input type="hidden" name="tszf_cf_form_id" value="<?php echo airkit_var_sanitize( $form_id, 'esc_attr' ); ?>" />

        <div class="form-table tszf-cf-table">
            <?php
                $this->render_items( $custom_fields, $post->ID, 'post', $form_id, $form_settings );
            ?>
        </div>
        <?php
        $this->scripts_styles();
    }

    /**
     * Prints form input label
     *
     * @param string $attr
     */
    function label( $attr, $post_id = 0 ) {
        if ( isset( $attr['label'] ) ) {
            echo airkit_var_sanitize( $attr['label'] . $this->required_mark( $attr ), 'the_kses' );
        }
    }

    function render_item_before( $form_field, $post_id = 0 ) {
        echo '<div class="ts-option-line">';
        $this->label( $form_field );
    }

    function render_item_after( $form_field ) {
        echo '</div>';
    }

    function scripts_styles() {
        ?>
        <script type="text/javascript">
            jQuery(function($){
                var tszf = {
                    init: function() {
                        $('.tszf-cf-table').on('click', 'img.tszf-clone-field', this.cloneField);
                        $('.tszf-cf-table').on('click', 'img.tszf-remove-field', this.removeField);
                        $('.tszf-cf-table').on('click', 'a.tszf-delete-avatar', this.deleteAvatar);
                    },
                    cloneField: function(e) {
                        e.preventDefault();

                        var $div = $(this).closest('tr');
                        var $clone = $div.clone();
                        // console.log($clone);

                        //clear the inputs
                        $clone.find('input').val('');
                        $clone.find(':checked').attr('checked', '');
                        $div.after($clone);
                    },

                    removeField: function() {
                        //check if it's the only item
                        var $parent = $(this).closest('tr');
                        var items = $parent.siblings().andSelf().length;

                        if( items > 1 ) {
                            $parent.remove();
                        }
                    },

                    deleteAvatar: function(e) {
                        e.preventDefault();

                        var data = {
                            action: 'tszf_delete_avatar',
                            user_id : $('#profile-page').find('#user_id').val(),
                            _wpnonce: '<?php echo wp_create_nonce( 'tszf_nonce' ); ?>'
                        };

                        if ( confirm( $(this).data('confirm') ) ) {
                            $.post(ajaxurl, data, function() {
                                window.location.reload();
                            });
                        }
                    }
                };

                tszf.init();
            });

        </script>
        <style type="text/css">
            ul.tszf-attachment-list li {
                display: inline-block;
                border: 1px solid #dfdfdf;
                padding: 25px;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                margin-right: 5px;
                position: relative;
            }
            ul.tszf-attachment-list li a.dl-link {
                margin-top: 15px;
                display: block;
            }
            ul.tszf-attachment-list li a.attachment-delete {
                position: absolute;
                top: 0;
                right: 0;
                text-decoration: none;
                padding: 3px 12px;
                border: 1px solid #C47272;
                color: #ffffff;
                text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
                background-color: #da4f49;
                background-image: -moz-linear-gradient(top, #ee5f5b, #bd362f);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#bd362f));
                background-image: -webkit-linear-gradient(top, #ee5f5b, #bd362f);
                background-image: -o-linear-gradient(top, #ee5f5b, #bd362f);
                background-image: linear-gradient(to bottom, #ee5f5b, #bd362f);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffee5f5b', endColorstr='#ffbd362f', GradientType=0);
                border-color: #bd362f #bd362f #802420;
                border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                *background-color: #bd362f;
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }
            ul.tszf-attachment-list li a.attachment-delete:hover,
            ul.tszf-attachment-list li a.attachment-delete:active {
                color: #ffffff;
                background-color: #bd362f;
                *background-color: #a9302a;
            }

            .tszf-cf-table table th,
            .tszf-cf-table table td{
                padding-left: 0 !important;
            }

            .tszf-cf-table .required { color: red;}
            .tszf-cf-table textarea { width: 400px; }

        </style>
        <?php
    }

    // Save the Metabox Data
    function save_meta( $post_id, $post ) {
        if ( !isset( $_POST['tszf_cf_update'] ) ) {
            return $post->ID;
        }

        if ( !wp_verify_nonce( $_POST['tszf_cf_update'], plugin_basename( __FILE__ ) ) ) {
            return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if ( !current_user_can( 'edit_post', $post->ID ) )
            return $post->ID;

        list( $post_vars, $tax_vars, $meta_vars ) = self::get_input_fields( $_POST['tszf_cf_form_id'], $post->ID );

        TSZF_Frontend_Form_Post::update_post_meta( $meta_vars, $post->ID );

        update_post_meta( $post->ID, '_tszf_form_id', $_POST['tszf_cf_form_id'] );
    }

}