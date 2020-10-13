<?php

class Ts_Add_Shortcode
{
	function __construct()
	{
		$shortcodes = array(
			'ts_one_half',
			'ts_one_third',
			'ts_one_fourth',
			'ts_two_third',
			'ts_row',
			'thumb',
			'star',
			'arrow',
			'question',
			'direction',
			'tick',
			'item'
		);

		$theme_shortcodes = get_option( TSS_THEMENAME . '_shortcodes' );

		if ( ! empty( $theme_shortcodes ) ) {

			foreach ( $theme_shortcodes as $key => $shortcode ) {

				add_shortcode( 'ts_' . $key, array( &$this, 'theme_shortcodes' ) );
			}
		}

		foreach ( $shortcodes as $short ) {

			add_shortcode( $short, array( &$this, $short ) );
		}
	}

	function ts_one_half( $atts, $content = null )
	{
	    return '<div class="col-lg-6 col-md-6 col-sm-12">' . do_shortcode( $content ) . '</div>';
	}

	function ts_one_third( $atts, $content = null )
	{
	    return '<div class="col-lg-4 col-md-4 col-sm-12">' . do_shortcode( $content ) . '</div>';
	}

	function ts_two_third( $atts, $content = null )
	{
	    return '<div class="col-lg-8 col-md-8 col-sm-12">' . do_shortcode( $content ) . '</div>';
	}

	function ts_one_fourth( $atts, $content = null )
	{
	    return '<div class="col-lg-3 col-md-3 col-sm-12">' . do_shortcode( $content ) . '</div>';
	}

	function ts_row( $atts, $content = null )
	{
	    return '<div class="row">' . do_shortcode( $content ) . '</div>';
	}

	function star( $atts, $content = null )
	{
	    return '<div class="ts-shortcode-list ts-star">' . $content . '</div>';
	}

	function arrow( $atts, $content = null )
	{
	    return '<div class="ts-shortcode-list ts-arrow">' . $content . '</div>';
	}

	function thumb( $atts, $content = null )
	{
	    return '<div class="ts-shortcode-list ts-thumb">' . $content . '</div>';
	}

	function question( $atts, $content = null )
	{
	    return '<div class="ts-shortcode-list ts-question">' . $content . '</div>';
	}

	function direction( $atts, $content = null )
	{
	    return '<div class="ts-shortcode-list ts-direction">' . $content . '</div>';
	}

	function tick( $atts, $content = null )
	{
	    return '<div class="ts-shortcode-list ts-tick">' . $content . '</div>';
	}

	function item( $atts, $content = null )
	{

	   	if ( isset( $content ) ) {

	   		if ( $atts['item-type'] == 'tab' || $atts['item-type'] == 'toggle' || $atts['item-type'] == 'listed_features' || $atts['item-type'] == 'features_blocks' || $atts['item-type'] == 'feature_blocks' || $atts['item-type'] == 'timeline-features' || $atts['item-type'] == 'pricing_tables' ) {

	   			$atts['text'] = $content;
	   		}
	   	}

	    return json_encode( $atts );
	}

	function theme_shortcodes( $atts, $content = null )
	{
		if ( ! empty( $content ) ) {

			preg_match( '/^*[^\[item]*/', $content, $matches );

			$atts['items'] = json_decode( '[' . str_replace('}{', '},{', do_shortcode( $content ) ) . ']', true );
		}

		$atts['shortcode'] = 'y';

		$article_views  = array( 'grid', 'thumbnail', 'big', 'list_view', 'mosaic', 'super', 'timeline_view', 'category', 'small-articles' );

		// Check if shortcode is a list post view type
		if ( in_array( $atts['element-type'],  $article_views) ) {

			$content = '<div class="row">' . call_user_func( array( 'airkit_Compilator', 'view_articles' ), $atts ) . '</div>';
			
		} else{

			$content = call_user_func( array( 'airkit_Compilator', str_replace( '-', '_', $atts['element-type'] ) . '_element' ), $atts );
		}

		$amp_preview = function_exists('is_amp_endpoint') && is_amp_endpoint();

		// Check if shortcode is a list post view type
		if ( in_array( $atts['element-type'], $article_views) ) {

			if ( !$amp_preview ) {

				$content = '<div class="row">' . call_user_func( array( 'airkit_Compilator', 'view_articles' ), $atts ) . '</div>';

			}

		} else {
			
			if ( !$amp_preview ) {

				$content = call_user_func( array( 'airkit_Compilator', str_replace( '-', '_', $atts['element-type'] ) . '_element' ), $atts );

			}
		}		

		if ( preg_match( '/^<div[^>]*/', $content, $matches ) ) {

			$content = preg_replace( '/^<div[^>]*/', '', $content );

			$search = array(
				'col-md-12',
				'col-lg-12',
				'col-sm-12',
				'col-xs-12'
			);

			$content = str_replace( $search, 'airkit-shortcode-element', $matches[0] ) . $content;
		}



		return $content;
	}

	function x( $atts, $content = null ){ return $settings; }
}
// End.