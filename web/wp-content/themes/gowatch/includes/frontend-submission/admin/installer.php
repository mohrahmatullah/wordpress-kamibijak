<?php

/**
 * Page installer
 *
 */
class TSZF_Admin_Installer {

    function __construct() {

        add_action( 'after_switch_theme', array( &$this, 'install_page_templates' ) );  
        // Create default form templates.
        add_action( 'after_switch_theme', array( &$this, 'create_default_forms' ) );                        

        add_action( 'wp_ajax_airkit_reinstall_forms', array( &$this, 'reinstall_forms' ) );
    }


    /**
     * Create a page with title and content
     *
     * @param  string $page_title
     * @param  string $post_content
     * @return false|int
     */
    function create_page( $page_title, $post_content = '', $post_type = 'page' ) {

        $page_id = wp_insert_post( array(
            'post_title'     => $page_title,
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'comment_status' => 'closed',
            'post_content'   => $post_content
        ) );

        if ( $page_id && ! is_wp_error( $page_id ) ) {
          
            return $page_id;
        }

        return false;
    }

    /**
     * Create a basic registration form by default
     *
     * @return int|boolean
     */
    function create_reg_form() {
        $form_id = $this->create_page( __( 'Registration', 'gowatch' ), '', 'tszf_profile' );

        if ( $form_id ) {
            $form_fields = array(
                array(
                    'input_type'  => 'email',//Should NOT Be translated.
                    'template'    => 'user_email',//Should NOT Be translated.
                    'required'    => 'yes',//Should NOT Be translated.
                    'label'       => esc_html__( 'Email', 'gowatch' ),
                    'name'        => 'user_email',//Should NOT Be translated.
                    'is_meta'     => 'no',//Should NOT Be translated.
                    'help'        => '',//Should NOT Be translated.
                    'css'         => '',//Should NOT Be translated.
                    'placeholder' => '',//Should NOT Be translated.
                    'default'     => '',//Should NOT Be translated.
                    'size'        => '40',//Should NOT Be translated.
                    'tszf_cond'   => NULL,
                ),
                array(
                    'input_type'    => 'password',//Should NOT Be translated.
                    'template'      => 'password',//Should NOT Be translated.
                    'required'      => 'yes',//Should NOT Be translated.
                    'label'         => esc_html__( 'Password', 'gowatch' ),
                    'name'          => 'password',//Should NOT Be translated.
                    'is_meta'       => 'no',//Should NOT Be translated.
                    'help'          => '',//Should NOT Be translated.
                    'css'           => '',//Should NOT Be translated.
                    'placeholder'   => '',//Should NOT Be translated.
                    'default'       => '',//Should NOT Be translated.
                    'size'          => '40',//Should NOT Be translated.
                    'min_length'    => '5',//Should NOT Be translated.
                    'repeat_pass'   => 'yes',//Should NOT Be translated.
                    're_pass_label' => esc_html__( 'Confirm Password', 'gowatch' ),
                    'pass_strength' => 'yes',//Should NOT Be translated.
                    'tszf_cond'     => NULL
                )
            );

            foreach ($form_fields as $order => $field) {
                TSZF_Admin_Form::insert_form_field( $form_id, $field, false, $order );
            }

            update_post_meta( $form_id, 'tszf_form_settings', array(
                'role'           => 'subscriber',//Should NOT Be translated.
                'redirect_to'    => 'same',//Should NOT Be translated.
                'message'        => esc_html__( 'Registration successful', 'gowatch' ),
                'update_message' => esc_html__( 'Profile updated successfully', 'gowatch' ),
                'page_id'        => '0',//Should NOT Be translated.
                'url'            => '',//Should NOT Be translated.
                'submit_text'    => esc_html__( 'Register', 'gowatch' ),
                'update_text'    => esc_html__( 'Update Profile', 'gowatch' ),
            ) );
            // Set active Frontend submission form ID to $form_id
            airkit_update_option( 'general', 'frontend_registration_form', $form_id );        
            
            return $form_id;
        }

        return false;
    }

    /**
     * Create a post form
     *
     * @return void
     */
    function create_form() {

        $form_id = $this->create_page( esc_html__( 'Default Form', 'gowatch' ), '', 'tszf_forms' );

        if ( $form_id ) {

            $form_fields = array(

              array (
                    'input_type'  => 'text',
                    'template'    => 'post_title',
                    'required'    => 'yes',
                    'label'       => 'Post Title',
                    'name'        => 'post_title',
                    'is_meta'     => 'no',
                    'help'        => 'Write post title here',
                    'css'         => '',
                    'show_edit'   => 'no',
                    'columns'     => '1',
                    'placeholder' => 'Enter your post title',
                    'default'     => '',
                    'size'        => '40',
                    'tszf_cond'   => array (),
              ),   

              array (
                  'input_type'  => 'textarea',
                  'template'    => 'post_content',
                  'required'    => 'yes',
                  'label'       => 'Article content',
                  'name'        => 'post_content',
                  'is_meta'     => 'no',
                  'help'        => 'This is the video description field. Please enter some descriptive text about your video.',
                  'css'         => '',
                  'show_edit'   => 'yes',
                  'columns'     => '1',
                  'rows'        => '5',
                  'cols'        => '25',
                  'placeholder' => 'Article content',
                  'default'     => '',
                  'rich'        => 'no',
                  'insert_image' => 'no',
                  'word_restriction' => '',
                  'tszf_cond' => 
                  array (),
                ), 

              array (
                'input_type'   => 'taxonomy',
                'template'     => 'taxonomy',
                'required'     => 'yes',
                'label'        => 'Select the category',
                'name'         => 'videos_categories',
                'is_meta'      => 'no',
                'help'         => 'Choose category for your post',
                'css'          => '',
                'show_edit'    => 'yes',
                'columns'      => '2',
                'type'         => 'select',
                'orderby'      => 'name',
                'order'        => 'ASC',
                'exclude_type' => 'exclude',
                'exclude'      => '',
                'woo_attr'     => 'no',
                'woo_attr_vis' => 'no',
                'options'      =>  array (),
                'tszf_cond'    => array (),
              ),

              array (
                'input_type' => 'text',
                'template'   => 'post_tags',
                'required'   => 'no',
                'label'      => 'Tags',
                'name'       => 'tags',
                'is_meta'    => 'no',
                'help'       => '',
                'css'        => '',
                'show_edit'  => 'yes',
                'columns'    => '2',
                'placeholder'=> 'Insert video tags separated by commas',
                'default'    => '',
                'size'       => '40',
                'tszf_cond'  => array (),
              ),   

              array (
                'input_type' => 'image_upload',
                'template' => 'featured_image',
                'count' => '1',
                'required' => 'yes',
                'label' => 'Please add a thumbnail for your video',
                'name' => 'featured_image',
                'is_meta' => 'no',
                'help' => '',
                'css' => '',
                'show_edit' => 'yes',
                'columns' => '1',
                'max_size' => '9999',
                'tszf_cond' => array (),
              ),              

              array (
                'input_type' => 'tab_content',
                'template'   => 'tab_content',
                'required'   => 'yes',
                'label'      => 'Upload video',
                'name'       => 'upload_video',
                'is_meta' => 'yes',
                'help' => '',
                'css' => '',
                'show_edit' => 'yes',
                'image' => '',
                'action' => 'start',
                'active_tab' => '123',
                'tszf_cond' => NULL,
              ),

              array (
                  'input_type' => 'file_upload',
                  'template' => 'file_upload',
                  'required' => 'no',
                  'label' => 'Upload video',
                  'name' => 'video_upload',
                  'is_meta' => 'yes',
                  'help' => 'Click to upload your MP4 video. Attention, only MP4 is allowed!',
                  'css' => '',
                  'show_edit' => 'yes',
                  'columns' => '1',
                  'max_size' => '2024000',
                  'count' => '1',
                  'extension' => 
                  array (
                    0 => 'images',
                    1 => 'video',
                  ),
                  'tszf_cond' => array (),
                ),                 

              array (
                'input_type' => 'tab_content',
                'template' => 'tab_content',
                'required' => 'no',
                'label' => 'Use URL',
                'name' => 'use_url',
                'is_meta' => 'yes',
                'help' => '',
                'css' => '',
                'show_edit' => 'yes',
                'image' => '',
                'action' => 'new',
                'active_tab' => '',
                'tszf_cond' => NULL,
              ),

              array (
                'input_type' => 'text',
                'template' => 'text_field',
                'required' => 'no',
                'label' => 'Video URL',
                'name' => 'video_url',
                'is_meta' => 'yes',
                'help' => 'Insert your oEmbed URL here. You can add a YouTube, vimeo, DailyMotion URL of the video.',
                'css' => '',
                'show_edit' => 'yes',
                'columns' => '1',
                'placeholder' => '',
                'default' => '',
                'size' => '40',
                'tszf_cond' => array (),
              ),

              array (
                  'input_type' => 'tab_content',
                  'template' => 'tab_content',
                  'required' => 'yes',
                  'label' => 'Embed code',
                  'name' => 'embed_code',
                  'is_meta' => 'yes',
                  'help' => '',
                  'css' => '',
                  'show_edit' => 'yes',
                  'image' => '',
                  'action' => 'new',
                  'active_tab' => '',
                  'tszf_cond' => NULL,
              ), 

              array (
                'input_type' => 'textarea',
                'template' => 'textarea_field',
                'required' => 'no',
                'label' => 'Embed code',
                'name' => 'video_embed',
                'is_meta' => 'yes',
                'help' => 'Insert your iFrame code in the textarea',
                'css' => '',
                'show_edit' => 'yes',
                'columns' => '1',
                'rows' => '5',
                'cols' => '25',
                'placeholder' => '',
                'default' => '',
                'rich' => 'no',
                'word_restriction' => '',
                'tszf_cond' => array (),
              ),            

              array (
                'input_type' => 'tab_content',
                'template' => 'tab_content',
                'required' => 'yes',
                'label' => 'End tab',
                'name' => 'end_tab',
                'is_meta' => 'yes',
                'help' => '',
                'css' => '',
                'show_edit' => 'yes',
                'image' => '',
                'action' => 'end',
                'active_tab' => '',
                'tszf_cond' => NULL,
              ),

            );

            foreach ( $form_fields as $order => $field ) {

                TSZF_Admin_Form::insert_form_field( $form_id, $field, false, $order );

            }

            $settings = array(
                'post_type'        => 'video',//Should NOT Be translated.
                'post_status'      => 'publish',//Should NOT Be translated.
                'post_format'      => '0',//Should NOT Be translated.
                'default_cat'      => '-1',//Should NOT Be translated.
                'guest_post'       => 'false',//Should NOT Be translated.
                'guest_details'    => 'true',//Should NOT Be translated.
                'name_label'       => esc_html__( 'Name', 'gowatch' ),
                'email_label'      => esc_html__( 'Email', 'gowatch' ),
                'message_restrict' => esc_html__( 'This page is restricted. Please Log in / Register to view this page.', 'gowatch' ),
                'redirect_to'      => 'post',//Should NOT Be translated.
                'message'          => esc_html__( 'Post saved', 'gowatch' ),
                'page_id'          => '',//Should NOT Be translated.
                'url'              => '',//Should NOT Be translated.
                'comment_status'   => 'open',//Should NOT Be translated.
                'submit_text'      => esc_html__( 'Submit', 'gowatch' ),
                'draft_post'       => 'false',//Should NOT Be translated.
                'edit_post_status' => 'publish',//Should NOT Be translated.
                'edit_redirect_to' => 'same',//Should NOT Be translated.
                'update_message'   => esc_html__( 'Post updated successfully', 'gowatch' ),
                'edit_page_id'     => '',//Should NOT Be translated.
                'edit_url'         => '',//Should NOT Be translated.
                'update_text'      => esc_html__( 'Update', 'gowatch' ),
                'notification'     => array(
                    'new'          => 'on',//Should NOT Be translated.
                    'new_to'       => get_option( 'admin_email' ),
                    'new_subject'  => esc_html__( 'New post created', 'gowatch' ),
                    'new_body'     => /*THIS IS AN EDITABLE TEMPLATE EXAMPLE. IT SHOULD NOT BE TRANSLATED, AS IT IS EDITABLE FROM THEME OPTIONS. */ "Hi Admin, \r\n\r\nA new post has been created in your site %sitename% (%siteurl%). \r\n\r\nHere is the details: \r\nPost Title: %post_title% \r\nContent: %post_content% \r\nAuthor: %author% \r\nPost URL: %permalink% \r\nEdit URL: %editlink%", 
                    'edit'         => 'off',//Should NOT Be translated.
                    'edit_to'      => get_option( 'admin_email' ),//Should NOT Be translated.
                    'edit_subject' => esc_html__( 'A post has been edited', 'gowatch' ),
                    'edit_body'    => /*THIS IS AN EDITABLE TEMPLATE EXAMPLE. IT SHOULD NOT BE TRANSLATED, AS IT IS EDITABLE FROM THEME OPTIONS. */ "Hi Admin, \r\n\r\nThe post \"%post_title%\" has been updated. \r\n\r\nHere is the details: \r\nPost Title: %post_title% \r\nContent: %post_content% \r\nAuthor: %author% \r\nPost URL: %permalink% \r\nEdit URL: %editlink%",
                ),
            );

            update_post_meta( $form_id, 'tszf_form_settings', $settings );
        }

        // Set active Frontend submission form ID to $form_id
        airkit_update_option( 'general', 'frontend_submission_form', $form_id );

    }

    /*
     * Add frontend pages templates
     */
    function install_page_templates(){

        $pages = array(
            'user-add-post.php'        => esc_html__( 'Add new post', 'gowatch' ),
            'user-profile.php'         => esc_html__( 'Profile', 'gowatch' ),
            'user-login-register.php'  => esc_html__( 'Login / Register', 'gowatch' ),
        );

        foreach( $pages as $file => $title ) {

            $existing = get_pages( array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => $file
                )
            );

            if( !isset( $existing ) || empty( $existing ) ){

                $args = array(
                    'post_type'     => 'page',//THIS SHOULD NOT BE TRANSLATED
                    'post_title'    => $title,
                    'post_status'   => 'publish',//THIS SHOULD NOT BE TRANSLATED
                    'page_template' => $file
                );

                wp_insert_post( $args );
            }
        }
    }   

    /*
     * Create default Frontend forms.
     */ 
    function create_default_forms() {

        $this->create_form();
        $this->create_reg_form();

    }

    /*
     | AJAX Reinstall forms.
     */
     public function reinstall_forms()
     {
        check_ajax_referer( 'extern_request_die', 'nonce' );

        $response = array( 'status' => 'waiting' );

        try {

          $this->create_default_forms();
          // Success response
          $response = array('status' => 'done' );

        }catch( Exception $exception ) {

          $response = array( 'status' => 'error', 'error' => $exception );

        }finally{

          echo json_encode( $response );
          die();

        }

     }    

}