<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://touchsize.com
 * @since      1.0.0
 *
 * @package    touchvideoads
 * @subpackage touchvideoads/includes
 */
class TouchVideoAds {

	public static $video_ad_options;

	function __construct()
	{

		self::$video_ad_options = array(

            array(
                'name'    => esc_html__( 'Choose advertising type', 'gowatch' ),
                'field'   => 'select',
                'options' => array(
                    'preroll'     => esc_html__( 'Pre Roll', 'gowatch' ),
                    'textover'    => esc_html__( 'Text over', 'gowatch' ),
                    'imageover'   => esc_html__( 'Image over', 'gowatch' )
                ),
                'id'      => 'video_ad_type',
                'std'     => 'n',
                'class_select' => 'airkit_trigger-options',
            ),

            /* SOF OPTIONS FOR PRE-ROLLS */

            array(
                'name'    => esc_html__( 'Upload video file', 'gowatch' ),
                'field'   => 'upload',
                'media-type' => 'video',
                'multiple'   => 'false',
                'id'      => 'preroll_video_file',
                'std'     => '',
                'class' => 'airkit_video_ad_type-preroll',
            ),

            array(
                'name'    => esc_html__( 'Include skip ad button', 'gowatch' ),
                'field'   => 'select',
                'options' => array(
                    'y'     => esc_html__( 'Enable skip button', 'gowatch' ),
                    'n'     => esc_html__( 'Disable skip button', 'gowatch' )
                ),
                'id'      => 'preroll_video_skip',
                'std'     => '',
                'class' => 'airkit_video_ad_type-preroll',
            ),

            /* EOF OPTIONS FOR PRE-ROLLS */

            /* SOF OPTIONS FOR IMAGE OVER */

            array(
                'name'    => esc_html__( 'Upload image file', 'gowatch' ),
                'field'   => 'upload',
                'media-type' => 'image',
                'multiple'   => 'false',
                'id'      => 'ad_image',
                'std'     => '',
                'class' => 'airkit_video_ad_type-imageover',
            ),

            array(
                'name'    => esc_html__( 'Start second', 'gowatch' ),
                'desc'    => esc_html__( 'Insert the second when you want your ad to be shown. Example: 10', 'gowatch' ),
                'type'	  => 'number',
                'field'   => 'input',
                'id'      => 'ad_image_start',
                'std'     => '',
                'class' => 'airkit_video_ad_type-imageover',
            ),
            array(
                'name'    => esc_html__( 'End second', 'gowatch' ),
                'desc'    => esc_html__( 'Insert the second when you want your ad to be hidden. Example: 15', 'gowatch' ),
                'type'	  => 'number',
                'field'   => 'input',
                'id'      => 'ad_image_end',
                'std'     => '',
                'class' => 'airkit_video_ad_type-imageover',
            ),

            /* EOF OPTIONS FOR IMAGE OVER */

            /* SOF OPTIONS FOR TEXT OVER */

            array(
                'name'    => esc_html__( 'Insert text over ad text', 'gowatch' ),
                'field'   => 'textarea',
                'id'      => 'ad_text',
                'std'     => '',
                'class' => 'airkit_video_ad_type-textover',
            ),

            array(
                'name'    => esc_html__( 'Start second', 'gowatch' ),
                'desc'    => esc_html__( 'Insert the second when you want your ad to be shown. Example: 10', 'gowatch' ),
                'type'	  => 'number',
                'field'   => 'input',
                'id'      => 'ad_text_start',
                'std'     => '',
                'class' => 'airkit_video_ad_type-textover',
            ),

            array(
                'name'    => esc_html__( 'End second', 'gowatch' ),
                'desc'    => esc_html__( 'Insert the second when you want your ad to be hidden. Example: 15', 'gowatch' ),
                'type'	  => 'number',
                'field'   => 'input',
                'id'      => 'ad_text_end',
                'std'     => '',
                'class' => 'airkit_video_ad_type-textover',
            ),

            /* EOF OPTIONS FOR TEXT OVER */

            array(
                'name'    => esc_html__( 'Set redirect link', 'gowatch' ),
                'desc'    => esc_html__( 'Set the link where the user will get redirected when clicks the pre-roll', 'gowatch' ),
                'type'	  => 'text',
                'field'   => 'input',
                'id'      => 'ad_link',
                'std'     => '',
            ),

            array(
                'name'    => esc_html__( 'Choose ad serving criteria', 'gowatch' ),
                'field'   => 'select',
                'options' => array(
                    'none'    	   => esc_html__( 'No criteria, show all', 'gowatch' ),
                    'tag'    	   => esc_html__( 'Post with selected tags', 'gowatch' ),
                    'category'     => esc_html__( 'Post with selected categories', 'gowatch' ),
                    'id'     	   => esc_html__( 'Post with specific IDs', 'gowatch' )
                ),
                'id'      => 'ad_criteria',
                'std'     => '',
                'class_select' => 'airkit_trigger-options',
            ),

            array(
                'name'    => esc_html__( 'Insert tag slugs, separated by commas', 'gowatch' ),
                'desc'    => esc_html__( 'Insert tag slugs, separated by commas. Example: tag1, tag2, tag3', 'gowatch' ),
                'field'   => 'textarea',
                'id'      => 'ad_criteria_tag',
                'std'     => '',
                'class' => 'airkit_ad_criteria-tag',
            ),

            array(
                'name'    => esc_html__( 'Insert category slugs, separated by commas', 'gowatch' ),
                'desc'    => esc_html__( 'Insert category slugs, separated by commas. Example: category1, category2, category3', 'gowatch' ),
                'field'   => 'textarea',
                'id'      => 'ad_criteria_category',
                'std'     => '',
                'class' => 'airkit_ad_criteria-category',
            ),

            array(
                'name'    => esc_html__( 'Insert video IDs, separated by commas', 'gowatch' ),
                'desc'    => esc_html__( 'Insert video IDs, separated by commas. Example: 123, 234, 345', 'gowatch' ),
                'field'   => 'textarea',
                'id'      => 'ad_criteria_id',
                'std'     => '',
                'class' => 'airkit_ad_criteria-id',
            ),

            array(
                'name'    => esc_html__( 'Exclude specific video IDs', 'gowatch' ),
                'desc'    => esc_html__( 'Insert video IDs, separated by commas. Example: 123, 234, 345', 'gowatch' ),
                'field'   => 'textarea',
                'id'      => 'ad_exclude_id',
                'std'     => '',
            ),

            array(
                'name'    => esc_html__( 'Choose counting mode', 'gowatch' ),
                'field'   => 'select',
                'desc'	  => 'Set the amount of clicks/views that you want to show this ad for',
                'options' => array(
                    'clicks'    => esc_html__( 'Clicks', 'gowatch' ),
                    'views'     => esc_html__( 'Views', 'gowatch' )
                ),
                'id'      => 'ad_count_mode',
                'std'     => '',
                'class_select' => 'airkit_trigger-options',

            ),

            array(
                'name'    => esc_html__( 'Max number of clicks', 'gowatch' ),
                'desc'    => esc_html__( 'Set the amount of clicks until this ad is clicked on. When this number is reached, the ad is automatically deactivated.', 'gowatch' ),
                'type'	  => 'text',
                'field'   => 'input',
                'id'      => 'ad_max_clicks',
                'std'     => '',
                'class' => 'airkit_ad_count_mode-clicks',
            ),

            array(
                'name'    => esc_html__( 'Max number of views', 'gowatch' ),
                'desc'    => esc_html__( 'Set the amount of views until this ad is shown. When this number is reached, the ad is automatically deactivated.', 'gowatch' ),
                'type'	  => 'text',
                'field'   => 'input',
                'id'      => 'ad_max_views',
                'std'     => '',
                'class' => 'airkit_ad_count_mode-views',
            ),

            array(
                'name'    => esc_html__( 'Ad is active', 'gowatch' ),
                'field'   => 'select',
                'desc'	  => 'Set the amount of clicks/views that you want to show this ad for',
                'options' => array(
                    'y'    => esc_html__( 'Active', 'gowatch' ),
                    'n'     => esc_html__( 'Deactivated', 'gowatch' )
                ),
                'id'      => 'ad_status',
                'std'     => 'y',
            ),

            array(
                'name'    => esc_html__( 'Counted views', 'gowatch' ),
                'desc'    => esc_html__( 'This is the amount of times this ad was viewed in it\'s lifetime while active.', 'gowatch' ),
                'type'	  => 'text',
                'field'   => 'the_value',
                'id'      => 'ad_served_views',
                'std'     => 0,
            ),

            array(
                'name'    => esc_html__( 'Counted clicks', 'gowatch' ),
                'desc'    => esc_html__( 'This is the amount of times this ad was clicked on in it\'s lifetime while active.', 'gowatch' ),
                'type'	  => 'text',
                'field'   => 'the_value',
                'id'      => 'ad_served_clicks',
                'std'     => 0,
            ),

        );

		// include scripts for front end
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts') );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts') );

		// Create the custom post type
		add_action( 'init', array( __CLASS__,  'create_videoad_custom_post' ), 100 );
		add_action( 'add_meta_boxes', array( __CLASS__,  'add_video_ads_metaboxes' ), 110 );
		add_action( 'save_post', array( __CLASS__,  'tva_save_postdata' ) );

	}

	public function load_scripts()
	{


	}

	public function load_admin_scripts()
	{
		
	}

	public static function create_videoad_custom_post()
	{

		$labels = array(
            'name'               => __( 'Video Ad', 'touchvideoads' ),
            'singular_name'      => __( 'Video Ad', 'touchvideoads' ),
            'add_new'            => __( 'Add New', 'touchvideoads' ),
            'add_new_item'       => __( 'Add New Video Ad', 'touchvideoads' ),
            'edit_item'          => __( 'Edit Video Ad', 'touchvideoads' ),
            'new_item'           => __( 'New Video Ad', 'touchvideoads' ),
            'all_items'          => __( 'All Video Ads', 'touchvideoads' ),
            'view_item'          => __( 'View Video Ad', 'touchvideoads' ),
            'search_items'       => __( 'Search Video Ads', 'touchvideoads' ),
            'not_found'          => __( 'No Video Ads found', 'touchvideoads' ),
            'not_found_in_trash' => __( 'No Video Ads found in Trash', 'touchvideoads' ),
            'parent_item_colon'  => '',
            'menu_name'          => __( 'Video Ads', 'touchvideoads' ),
        );

		$args = array(
			'labels'     => $labels,
 		    'public'     => true,
 		    'menu_icon'  => 'dashicons-chart-line',
		    'supports'   => array( 'title', 'thumbnail', 'author', 'revisions' ),
		);

		register_post_type( 'touch-video-ads', $args );
	}

	public static function add_video_ads_metaboxes()
	{
		add_meta_box('touch_video_ads_location', 'Video Ad Details', array( __CLASS__,  'touch_video_ads_location' ), 'touch-video-ads', 'normal', 'default');
	}
 
	public static function touch_video_ads_location()
	{
		// Check if theme is compatible with this.
		if ( !class_exists('airkit_Compilator') || !class_exists('airkit_Fields') ){
			echo 'The plugin is not compatible with this theme';
			return false;
		}

		$video_ad_options = self::$video_ad_options;

		foreach ($video_ad_options as $key => $field) {

			$results[$field['id']] = get_post_meta( get_the_ID(), $field['id'], true ); 

		}

		foreach ($video_ad_options as $key => $field) {
		
			if ( is_array( $field['field'] ) ) {
				// Add custom function from this class or another.
				call_user_func( $field['field'], $field, $results );

			} else {

				call_user_func( array( 'airkit_Fields', $field['field'] ), $field, $results );
			}		

		}

		wp_nonce_field( plugin_basename( __FILE__ ), 'tva_noncename' );
	}

	public static function tva_save_postdata( $post_id ){

		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !isset( $_POST['tva_noncename'] ) || !wp_verify_nonce( $_POST['tva_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
		}

		// Verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;


		// Check permissions to edit pages and/or posts
		if ( 'touch-video-ads' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
			  return $post_id;
		}

		$video_ad_options = self::$video_ad_options;

		foreach ($video_ad_options as $key => $field) {

			if ( isset( $_POST[ $field['id'] ] ) && $_POST[ $field['id'] ] != '' ) {
		  		update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] ); 
			}

		}

    }
}
?>