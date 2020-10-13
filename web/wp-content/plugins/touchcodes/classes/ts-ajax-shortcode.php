<?php
/**
*  Add ajax actions shortcodes.
*/
class Ts_Ajax_Shortcode
{
	function __construct()
	{
		add_action( 'wp_ajax_airkit_theme_shortcodes', array( &$this, 'touch_theme_shortcodes' ) );
		add_action('wp_ajax_nopriv_airkit_theme_shortcodes', 'touch_theme_shortcodes');
	}

	function touch_theme_shortcodes()
	{

		airkit_BuilderSettings::modal_fields( $_POST['type'] );

		die();
	}
}