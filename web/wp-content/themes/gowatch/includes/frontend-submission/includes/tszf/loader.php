<?php

class TSZF_Pro_Loader {

    public function __construct() {

        $this->includes();
        $this->instantiate();

        add_action( 'tszf_form_buttons_custom',             array( $this, 'tszf_form_buttons_custom_runner' ) );
        add_action( 'tszf_form_buttons_other',              array( $this, 'tszf_form_buttons_other_runner') );
        add_action( 'tszf_form_post_expiration',            array( $this, 'tszf_form_post_expiration_runner') );
        add_action( 'tszf_form_setting',                    array( $this, 'form_setting_runner' ),10,2 );
        add_action( 'tszf_form_settings_post_notification', array( $this, 'post_notification_hook_runner') );
        add_action( 'tszf_edit_form_area_profile',          array( $this, 'tszf_edit_form_area_profile_runner' ) );
        add_action( 'tszf_add_profile_form_top',            array( $this, 'tszf_add_profile_form_top_runner' ), 10, 2 );
        add_action( 'registration_setting' ,                array( $this, 'registration_setting_runner') );
        add_action( 'tszf_check_post_type' ,                array( $this, 'tszf_check_post_type_runner' ),10,2 );
        add_action( 'tszf_form_custom_taxonomies',          array( $this, 'tszf_form_custom_taxonomies_runner' ) );
        add_action( 'tszf_conditional_field_render_hook',   array( $this, 'tszf_conditional_field_render_hook_runner' ), 10, 3 );


        //render_form
        add_action( 'tszf_render_pro_repeat',                array( $this, 'tszf_render_pro_repeat_runner' ),10,7 );
        add_action( 'tszf_render_pro_date',                  array( $this, 'tszf_render_pro_date_runner' ),10,7 );
        add_action( 'tszf_render_pro_file_upload',           array( $this, 'tszf_render_pro_file_upload_runner' ),10,7 );
        add_action( 'tszf_render_pro_map',                   array( $this, 'tszf_render_pro_map_runner' ),10,7 );
        add_action( 'tszf_render_pro_country_list',          array( $this, 'tszf_render_pro_country_list_runner' ),10,7 );
        add_action( 'tszf_render_pro_numeric_text',          array( $this, 'tszf_render_pro_numeric_text_runner' ),10,7 );
        add_action( 'tszf_render_pro_address',               array( $this, 'tszf_render_pro_address_runner' ),10,7 );
        add_action( 'tszf_render_pro_step_start',            array( $this, 'tszf_render_pro_step_start_runner' ),10,9 );
        add_action( 'tszf_render_pro_action_hook',           array( $this, 'tszf_render_pro_action_hook_runner' ),10,9 );
        add_action( 'tszf_render_pro_toc',                   array( $this, 'tszf_render_pro_toc_runner' ),10,9 );


        //render element form in backend form builder
        add_action( 'tszf_admin_field_custom_repeater',               array( $this, 'tszf_admin_field_custom_repeater_runner'),10,4);
        add_action( 'tszf_admin_template_post_repeat_field',          array( $this, 'tszf_admin_template_post_repeat_field_runner'),10,5);
        add_action( 'tszf_admin_field_custom_date',                   array( $this, 'tszf_admin_field_custom_date_runner'),10,4);
        add_action( 'tszf_admin_template_post_date_field',            array( $this, 'tszf_admin_template_post_date_field_runner'),10,5);
        add_action( 'tszf_admin_field_custom_file',                   array( $this, 'tszf_admin_field_custom_file_runner'),10,4);
        add_action( 'tszf_admin_template_post_file_upload',           array( $this, 'tszf_admin_template_post_file_upload_runner'),10,5);
        add_action( 'tszf_admin_field_custom_map',                    array( $this, 'tszf_admin_field_custom_map_runner'),10,4);
        add_action( 'tszf_admin_template_post_google_map',            array( $this, 'tszf_admin_template_post_google_map_runner'),10,5);
        add_action( 'tszf_admin_field_country_select',                array( $this, 'tszf_admin_field_country_select_runner'),10,4);
        add_action( 'tszf_admin_template_post_country_list_field',    array( $this, 'tszf_admin_template_post_country_list_field_runner'),10,5);
        add_action( 'tszf_admin_field_numeric_field',                 array( $this, 'tszf_admin_field_numeric_field_runner'),10,4);
        add_action( 'tszf_admin_template_post_numeric_text_field',    array( $this, 'tszf_admin_template_post_numeric_text_field_runner'),10,5);
        add_action( 'tszf_admin_field_address_field',                 array( $this, 'tszf_admin_field_address_field_runner'),10,4);
        add_action( 'tszf_admin_template_post_address_field',         array( $this, 'tszf_admin_template_post_address_field_runner'),10,5);
        add_action( 'tszf_admin_field_step_start',                    array( $this, 'tszf_admin_field_step_start_runner'),10,4);
        add_action( 'tszf_admin_template_post_step_start',            array( $this, 'tszf_admin_template_post_step_start_runner'),10,5);
        add_action( 'tszf_admin_field_really_simple_captcha',         array( $this, 'tszf_admin_field_really_simple_captcha_runner'),10,4);
        add_action( 'tszf_admin_template_post_really_simple_captcha', array( $this, 'tszf_admin_template_post_really_simple_captcha_runner'),10,5);
        add_action( 'tszf_admin_field_action_hook',                   array( $this, 'tszf_admin_field_action_hook_runner'),10,4);
        add_action( 'tszf_admin_template_post_action_hook',           array( $this, 'tszf_admin_template_post_action_hook_runner'),10,5);
        add_action( 'tszf_admin_field_toc',                           array( $this, 'tszf_admin_field_toc_runner'),10,4);
        add_action( 'tszf_admin_template_post_toc',                   array( $this, 'tszf_admin_template_post_toc_runner'),10,5);

        // tab content actions
        add_action( 'tszf_admin_field_tab_content',                    array( $this, 'tszf_admin_field_tab_content_runner'),10,4);
        add_action( 'tszf_admin_template_post_tab_content',            array( $this, 'tszf_admin_template_post_tab_content_runner'),10,5);        

        //render_form
        add_action( 'tszf_add_post_form_top',  array($this, 'tszf_add_post_form_top_runner'),10,2 );
        add_action( 'tszf_edit_post_form_top', array($this, 'tszf_edit_post_form_top_runner'),10,3 );

        //page install
        add_filter( 'tszf_pro_page_install' , array( $this, 'install_pro_pages' ), 10, 1 );

        //delete post
        // add_action( 'trash_post', array( $this, 'delete_post_function' ) );
    }

    public function includes() {
        require_once TSZF_ROOT . '/includes/tszf/login.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'
        require_once TSZF_ROOT . '/includes/tszf/frontend-form-profile.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'

        if ( is_admin() ) {
            require_once TSZF_ROOT . '/includes/tszf/admin/posting-profile.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'
            require_once TSZF_ROOT . '/includes/tszf/admin/template-profile.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'
        }

        //class files to include tszf elements
        require_once TSZF_ROOT . '/includes/tszf/form.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'
        require_once TSZF_ROOT . '/includes/tszf/render-form.php'; //TSZF_ROOT = get_template_directory() . '/includes/frontend-submission'
    }

    public function instantiate(){
        TSZF_Login::init();
        new TSZF_Frontend_Form_Profile();

        if ( is_admin() ) {
            new TSZF_Admin_Posting_Profile();
        }
    }

    public function tszf_form_buttons_custom_runner() {
        //add formbuilder widget pro buttons
        TSZF_form_element::add_form_custom_buttons();
    }

    public function tszf_form_buttons_other_runner() {
        TSZF_form_element::add_form_other_buttons();
    }

    public function tszf_form_post_expiration_runner(){
        TSZF_form_element::render_form_expiration_tab();
    }

    public function form_setting_runner( $form_settings, $post ) {
        TSZF_form_element::add_form_settings_content( $form_settings, $post );
    }

    public function post_notification_hook_runner() {
        TSZF_form_element::add_post_notification_content();
    }

    public function tszf_edit_form_area_profile_runner() {
        TSZF_form_element::render_registration_form();
    }

    public function registration_setting_runner() {
        TSZF_form_element::render_registration_settings();
    }

    public function tszf_check_post_type_runner( $post, $update ) {
        TSZF_form_element::check_post_type( $post, $update );
    }

    public function tszf_form_custom_taxonomies_runner() {
        TSZF_form_element::render_custom_taxonomies_element();
    }

    public function tszf_conditional_field_render_hook_runner( $field_id, $con_fields, $obj ) {
        TSZF_form_element::render_conditional_field( $field_id, $con_fields, $obj );
    }

    //render_form
    public function tszf_render_pro_repeat_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ) {
        TSZF_render_form_element::repeat( $form_field, $post_id, $type, $form_id, $classname, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_date_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        TSZF_render_form_element::date( $form_field, $post_id, $type, $form_id, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }

    public function tszf_render_pro_file_upload_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        TSZF_render_form_element::file_upload( $form_field, $post_id, $type, $form_id, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }

    public function tszf_render_pro_map_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ) {
        TSZF_render_form_element::map( $form_field, $post_id, $type, $form_id, $classname, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_country_list_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        TSZF_render_form_element::country_list( $form_field, $post_id, $type, $form_id, $classname, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_numeric_text_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        TSZF_render_form_element::numeric_text( $form_field, $post_id, $type, $form_id, $classname, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_address_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        TSZF_render_form_element::address_field( $form_field, $post_id, $type, $form_id, $classname, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_step_start_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj, $multiform_start, $enable_multistep ) {
        TSZF_render_form_element::step_start( $form_field, $post_id, $type, $form_id, $multiform_start, $enable_multistep, $obj );
        $obj->conditional_logic( $form_field, $form_id );
    }

    public function tszf_render_pro_really_simple_captcha_runner( $form_field, $post_id, $type, $form_id, $multiform_start, $enable_multistep, $obj ){
        $form_field['name'] = 'really_simple_captcha';
        TSZF_render_form_element::really_simple_captcha( $form_field, $post_id, $form_id );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_action_hook_runner( $form_field, $post_id, $type, $form_id, $form_settings, $classname, $obj ){
        TSZF_render_form_element::action_hook( $form_field, $form_id, $post_id,  $form_settings );
        $obj->conditional_logic( $form_field, $form_id );
    }
    public function tszf_render_pro_toc_runner( $form_field, $post_id, $type, $form_id, $multiform_start, $enable_multistep, $obj ){
        TSZF_render_form_element::toc( $form_field, $post_id, $form_id );
        $obj->conditional_logic( $form_field, $form_id );
    }

    //form element's rendering form in backend form builder
    public function tszf_admin_field_custom_repeater_runner( $type, $field_id, $classname, $obj ) {
       TSZF_form_element::repeat_field( $field_id, 'Custom field: Repeat Field',$classname );
    }

    public function tszf_admin_template_post_repeat_field_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::repeat_field( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_custom_date_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::date_field( $field_id, 'Custom Field: Date',$classname );
    }
    public function tszf_admin_template_post_date_field_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::date_field( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_template_post_image_upload_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::image_upload( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_custom_file_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::file_upload( $field_id, 'Custom field: File Upload', $classname);
    }
    public function tszf_admin_template_post_file_upload_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::file_upload( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_custom_map_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::google_map( $field_id, 'Custom Field: Google Map',$classname );
    }
    public function tszf_admin_template_post_google_map_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::google_map( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_country_select_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::country_list_field( $field_id, 'Custom field: Select', $classname );
    }
    public function tszf_admin_template_post_country_list_field_runner( $name, $count, $input_field, $classname, $obj ) {
        TSZF_form_element::country_list_field( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_numeric_field_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::numeric_text_field( $field_id, 'Custom field: Numeric Text', $classname);
    }
    public function tszf_admin_template_post_numeric_text_field_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::numeric_text_field( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_address_field_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::address_field( $field_id, 'Custom field: Address',$classname);
    }
    public function tszf_admin_template_post_address_field_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::address_field( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_step_start_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::step_start( $field_id, 'Step Starts', $classname);
    }

    public function tszf_admin_field_tab_content_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::tab_content( $field_id, 'Tab Content', $classname);
    }

    public function tszf_admin_template_post_step_start_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::step_start( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_template_post_tab_content_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::tab_content( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_really_simple_captcha_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::really_simple_captcha( $field_id, 'Really Simple Captcha',$classname );
    }
    public function tszf_admin_template_post_really_simple_captcha_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::really_simple_captcha( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_action_hook_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::action_hook( $field_id, 'Action Hook', $classname );
    }
    public function tszf_admin_template_post_action_hook_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::action_hook( $count, $name, $classname, $input_field );
    }

    public function tszf_admin_field_toc_runner( $type, $field_id, $classname, $obj ){
        TSZF_form_element::toc( $field_id, 'TOC', $classname );
    }
    public function tszf_admin_template_post_toc_runner( $name, $count, $input_field, $classname, $obj ){
        TSZF_form_element::toc( $count, $name, $classname, $input_field );
    }

    public function tszf_add_profile_form_top_runner( $form_id, $form_settings ) {
        if ( isset( $form_settings['multistep_progressbar_type'] ) && $form_settings['multistep_progressbar_type'] == 'progressive' ) {
            wp_enqueue_script('jquery-ui-progressbar');
        }
    }

    //render_form
    public function tszf_add_post_form_top_runner( $form_id, $form_settings ) {
        if ( ! isset( $form_settings['enable_multistep'] ) || $form_settings['enable_multistep'] != 'yes' ) {
            return;
        }

        if ( $form_settings['multistep_progressbar_type'] == 'progressive' ) {
            wp_enqueue_script('jquery-ui-progressbar');
        }
    }

    public function tszf_edit_post_form_top_runner( $form_id, $post_id, $form_settings ) {

        if ( ! isset( $form_settings['enable_multistep'] ) || $form_settings['enable_multistep'] != 'yes' ) {
            return;
        }

        if ( isset( $form_settings['multistep_progressbar_type'] ) && $form_settings['multistep_progressbar_type'] == 'progressive' ) {
            wp_enqueue_script('jquery-ui-progressbar');
        }
    }

    //install pro version page
    function install_pro_pages( $profile_options ) {
        $tszf_pro_page_installer = new tszf_pro_page_installer();
        return $tszf_pro_page_installer->install_pro_version_pages( $profile_options );
    }

}

new TSZF_Pro_Loader();