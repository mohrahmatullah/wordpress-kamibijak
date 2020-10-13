<?php
/**
*  Init all hooks to admin dashboard.
*/
class Ts_Init_Admin
{
	static function init()
	{

		$theme_shortcodes = get_option( TSS_THEMENAME . '_shortcodes' );

		add_action( 'admin_footer', array( 'Ts_Init_Admin', 'get_modal' ) );

		if ( ! empty( $theme_shortcodes ) ) {

			// Register button's shortcodes.
			add_filter( 'mce_buttons', array( 'Ts_Init_Admin', 'register_buttons' ) );

			add_filter( 'tiny_mce_before_init', array( 'Ts_Init_Admin', 'tiny_mce_before_init' ) );

			if ( defined(TSS_THEMENAME) ) {

				self::css_custom_gsl_swf();
			}
		}

		// Add settings to general options theme.
		add_filter( 'ts_get_options', array( 'Ts_Init_Admin', 'ts_get_options' ), 10, 3 );
	}

	// Register button's shortcodes.
	static function register_buttons( $buttons )
	{
	    array_push( $buttons, 'separator', 'ts_pushortcodes' );

	    return $buttons;
	}

	static function ts_get_options( $fields, $extract, $tab = 'general' )
	{
	    $themes = array( 'videotouch', 'hopeful', 'esquise', 'shootback', 'slimvideo', 'hologram', 'syncope', 'aspact' );

	    if ( defined( 'TSS_THEMENAME' ) && ! in_array( TSS_THEMENAME, $themes ) ) {

	    	if ( $extract == 'tabs' ) {

	    		$tab_css = array(
	    			'css' => array(
	    				'title' => esc_html__( 'Custom CSS', 'touchcodes' ),
						'class' => 'code',
						'desc' => 'Add your custom CSS below',
					)
	    		);

	    		// Insert tab custom css in 10 position from page theme options.
	    		$fields = array_merge( array_slice( $fields, 0, 10 ), $tab_css, array_slice( $fields, 10 ) );

	    	} else {

	    		if ( $tab == 'all' ) {

	    			$fields['css'] = array(
    					'name'  => esc_html__( 'Custom JavaScript code', 'touchcodes' ),
    					'desc'  => esc_html__( 'Google analytics or any other scripts you have.', 'touchcodes' ),
    					'field' => 'code_area',
    					'id'    => 'custom_javascript',
    					'std'   => ''
	    			);
	    		}
	    		if ( $tab == 'css' ) {

	    			$fields['css'] = array(
    					'name'  => esc_html__( 'Custom CSS code', 'touchcodes' ),
    					'desc'  => esc_html__( 'Just add your styles without any additional tags.', 'touchcodes' ),
    					'field' => 'code_area',
    					'id'    => 'custom_css',
    					'std'   => ''
	    			);
	    		}
	    	}
	    }

	    return $fields;
	}

	// Render modal's shortcodes in admin footer.
	static function get_modal()
	{
		global $wp_query, $post, $query;

			echo 	'<div id="ts-builder-elements-modal-preloader"></div>
					<div id="airkit_builder-settings-shortcode" style="display:none;">
		            	<div class="modal-dialog">
		                	<div class="airkit_modal-body"></div>
		            	</div>
		        	</div>';
	}

	static function css_custom_gsl_swf()
	{
        if ( false === get_option( 'inline_style' ) ) {

            update_option( 'inline_style', '' );
        }

       // Register a section
       add_settings_section(
           'css_section',
           __( 'Custom CSS', 'touchcodes' ),
           array( __CLASS__, 'gsl_swf_inline_style' ),
           'inline_style'
       );

       register_setting( 'inline_style', 'inline_style' );
	}

	// Add option inline style to theme global options.
	static function gsl_swf_inline_style()
	{
	    echo '<p>' . __( 'Insert here your custom CSS', 'touchcodes' ) . '</p>';

	    $css = ( $options = get_option( 'inline_style' ) ) && isset( $options['css'] ) ? $options['css'] : '';

	    echo '<textarea name="inline_style" cols="80" rows="30">' . get_option( 'inline_style', '' ) . '</textarea>';
	}

	static function tiny_mce_before_init( $initArray )
	{
		$shortcodes = array();
		$theme_shortcodes = get_option( TSS_THEMENAME . '_shortcodes' );


		if ( ! empty( $theme_shortcodes ) ) {

			foreach ( $theme_shortcodes as $key => $name ) {

				$shortcodes[] = "{
			                       	text: '$name',
			                       	value: '$key',
			                       	onclick: function() {
			                        	shortcode_modal( '$key', '$name' );
			                       	}
			                   	}";
			}
		}

		$shortcodes = implode( ',', $shortcodes );

	    $initArray['setup'] =
	        "[function(ed) {
	            ed.addButton('ts_pushortcodes', {
	               type: 'menubutton',
	               icon: 'icon ts_shortcode_icon',
	               menu: [
	               		$shortcodes,
	                   {
	                       text: 'Columns',
	                       value: '',
	                       onclick: function() {

	                       },

	                       menu: [
	                           {
	                               text: '1/2 + 1/2',
	                               value: 'ts_one_half',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[ts_row]\
	                                       [ts_one_half]\
	                                           Add Content here\
	                                       [/ts_one_half]\
	                                       [ts_one_half]\
	                                           Add Content here\
	                                       [/ts_one_half]\
	                                   [/ts_row]');
	                               }
	                           },
	                           {
	                               text: '1/3 + 1/3 + 1/3',
	                               value: 'ts_one_third',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[ts_row]\
	                                       [ts_one_third]\
	                                           Add Content here\
	                                       [/ts_one_third]\
	                                       [ts_one_third]\
	                                           Add Content here\
	                                       [/ts_one_third]\
	                                       [ts_one_third]\
	                                           Add Content here\
	                                       [/ts_one_third]\
	                                   [/ts_row]' );
	                               }
	                           },
	                           {
	                               text: '2/3 + 1/3',
	                               value: 'ts_two_third',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[ts_row]\
	                                       [ts_two_third]\
	                                           Add 2/3 Content here\
	                                       [/ts_two_third]\
	                                       [ts_one_third]\
	                                           Add 1/3 Content here\
	                                       [/ts_one_third]\
	                                   [/ts_row]');
	                               }
	                           },
	                           {
	                               text: '1/4 + 1/4 + 1/4 + 1/4',
	                               value: 'ts_one_fourth',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[ts_row]\
	                                       [ts_one_fourth]\
	                                           Add Content here\
	                                       [/ts_one_fourth]\
	                                       [ts_one_fourth]\
	                                           Add Content here\
	                                       [/ts_one_fourth]\
	                                       [ts_one_fourth]\
	                                           Add Content here\
	                                       [/ts_one_fourth]\
	                                       [ts_one_fourth]\
	                                           Add Content here\
	                                       [/ts_one_fourth]\
	                                   [/ts_row]' );
	                               }
	                           },
	                       ]
	                   },
	                   {
	                       text: 'List',
	                       value: '',
	                       onclick: function() {

	                       },

	                       menu: [
	                           {
	                               text: 'Star',
	                               value: 'star',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[star]\
	                                       <ul><li>Add Content here</li><li>Add Content here</li></ul>\
	                                   [/star]');
	                               }
	                           },
	                           {
	                               text: 'Arrow',
	                               value: 'arrow',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[arrow]\
	                                       <ul><li>Add Content here</li><li>Add Content here</li></ul>\
	                                   [/arrow]' );
	                               }
	                           },
	                           {
	                               text: 'Thumb',
	                               value: 'thumb',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[thumb]\
	                                       <ul><li>Add Content here</li><li>Add Content here</li></ul>\
	                                   [/thumb]');
	                               }
	                           },
	                           {
	                               text: 'Question',
	                               value: 'question',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[question]\
	                                       <ul><li>Add Content here</li><li>Add Content here</li></ul>\
	                                   [/question]' );
	                               }
	                           },
	                           {
	                               text: 'Direction',
	                               value: 'direction',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[direction]\
	                                      <ul><li>Add Content here</li><li>Add Content here</li></ul>\
	                                   [/direction]' );
	                               }
	                           },
	                           {
	                               text: 'Tick',
	                               value: 'tick',
	                               onclick: function(e) {
	                                  tinyMCE.activeEditor.selection.setContent(
	                                   '[tick]\
	                                       <ul><li>Add Content here</li><li>Add Content here</li></ul>\
	                                   [/tick]' );
	                               }
	                           }
	                       ]
	                   }
	               ]
	           });
	        }][0]";

	    return $initArray;
	}
}


/*
 * Add 'Featured' column for admin posts listings.
 */

if ( !function_exists( 'airkit_add_custom_true' ) ) {

	function airkit_add_custom_true( $columns ) {

	    $add_column_for = array( 'video', 'ts-gallery', 'post', 'event' );

	    $post_type = get_post_type(get_the_ID());

	    if ( in_array( $post_type , $add_column_for ) ) {

	        $columns['featured_article'] = 'Featured';

	    }

	    return $columns;
	}
	add_filter('manage_posts_columns', 'airkit_add_custom_true', 10, 1);
}




/*
 * 'Featured' column template.
 */

if ( !function_exists( 'airkit_columns_content_featured' ) ) {

	function airkit_columns_content_featured( $columnName, $post_ID ) {

	    $add_column_for = array( 'video', 'ts-gallery', 'post', 'event' );

	    $post_type = get_post_type( $post_ID );

	    if ( in_array( $post_type, $add_column_for ) && $columnName == 'featured_article' ) {

	        $meta_values = get_post_meta( $post_ID, 'featured', true );
	        $selected = $meta_values == 'yes' ? 'checked' : '';

	        echo '<input type="checkbox"'. $selected .' name="featured_article" class="featured" value="'. esc_attr( $post_ID ) .'">';
	        echo '<input type="hidden" value="updateFeatures" />';

	    }
	}
	add_action('manage_posts_custom_column', 'airkit_columns_content_featured', 10, 2);

}

?>