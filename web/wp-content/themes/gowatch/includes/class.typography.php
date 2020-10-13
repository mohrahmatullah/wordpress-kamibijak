<?php
/**
 * Processes typography-related fields
 * and generates the google-font link.
 *
 * @package     Airkit
 * @category    Core
 * @author      TouchSize
 * @copyright   Copyright (c) 2016, TouchSize
 * @license     https://www.gnu.org/licenses/gpl-3.0.en.html
 * @since       1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'Airkit_Google_Fonts' ) ) {

	/**
	 * Manages the way Google Fonts are enqueued.
	 */
	final class Airkit_Google_Fonts {

		/**
		 * The array of fonts
		 *
		 * @access private
		 * @var array
		 */
		private $fonts = array();

		/**
		 * An array of all google fonts.
		 *
		 * @static
		 * @access private
		 * @var array
		 */
		private $google_fonts = array();

		/**
		 * The array of subsets
		 *
		 * @access private
		 * @var array
		 */
		private $subsets = array();

		/**
		 * The google link
		 *
		 * @access private
		 * @var string
		 */
		private $link = '';

		/**
		 * The class constructor.
		 */
		public function __construct() {

			// Populate the array of google fonts.
			$this->google_fonts = $this->get_google_fonts();

			// Enqueue link.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 105 );

		}

		/**
		 * Calls all the other necessary methods to populate and create the link.
		 */
		public function enqueue() {

	
			// Go through our fields and populate $this->fonts.
			$this->loop_fields();

			// Goes through $this->fonts and adds or removes things as needed.
			$this->process_fonts();

			// Go through $this->fonts and populate $this->link.
			$this->create_link();

			// If $this->link is not empty then enqueue it.
			if ( '' !== $this->link ) {
				wp_enqueue_style( 'airkit_google_fonts', esc_url( $this->link ), array(), null );
			}

		}

		/**
		 * Goes through all our fields and then populates the $this->fonts property.
		 */
		private function loop_fields() {

			$typography = ( $typography = get_option( 'gowatch_options' ) ) && isset( $typography['typography'] ) ? $typography['typography'] : array();
			
			$this->subsets = isset( $typography['extra']['subsets'] ) ? $typography['extra']['subsets'] : array();

			foreach ( $typography as $key => $value ) {

				if ( 'extra' == $key || 'custom' == $key ) continue;

				$this->generate_google_font( $key, $value );

			}

		}

		/*
	     * Hardcoded inclusion of google font.
		 */
		public function add_dynamic_font( $key, $font ) {

			$this->generate_google_font( $key, $font );
			$this->process_fonts();
			// Go through $this->fonts and populate $this->link.
			$this->create_link();

			// If $this->link is not empty then enqueue it.
			if ( '' !== $this->link ) {
				wp_enqueue_style( 'airkit_google_fonts_' . esc_attr( $key ), esc_url( $this->link ), array(), null );
			}			

		}

		/**
		 * Processes the field.
		 *
		 * @param string $key typography field key
		 * @param array $value Typography field values
		 */
		private function generate_google_font( $key, $value ) {

			$skip = array( 'Arial', 'Times New Roman', 'Tahoma', 'Georgia', 'Comic Sans', 'Verdana' );

			// Get Typekit fonts
	      	$typekit_names = airkit_option_value( 'typography' ,'typekit-name' );

	      	if ( $typekit_names !== '' ) {

				$typekit_names = explode( ',', $typekit_names );

				if ( is_array( $typekit_names ) ) {
					foreach ($typekit_names as $font) {
						array_push( $skip, $font );
					}
				}

	      	}
			// Get custom Fonts
	      	$custom_fonts = airkit_option_value('typography', 'font_items');

			if ( is_array( $custom_fonts ) && $custom_fonts !== '' ) {
				foreach ($custom_fonts as $key => $font) {
					array_push( $skip, $font['font-face'] );
				}
			}


			// If we don't have a font-family then we can skip this.
			if ( ! isset( $value['family'] ) ) {
				return;
			}

			// if is system font, then we can also skip this
			if( in_array($value['family'], $skip ) ) {
				return;
			}
			if ( isset( $this->google_fonts[ $value['family'] ][ 'variants' ] ) ) {
				$value['variant'] = implode( ',', $this->google_fonts[ $value['family'] ][ 'variants' ] );
			}

			// Add the requested google-font.
			if ( ! array_key_exists( $value['family'] , $this->fonts ) ) {
				$this->fonts[ $value['family'] ] = array();
			}
			// Add variants to requested google font.
			if ( isset( $value['variant'] ) && ! in_array( $value['variant'], $this->fonts[ $value['family'] ], true ) ) {
				$this->fonts[ $value['family'] ][] = $value['variant'];
			}

		}

		/**
		 * Determines the validity of the selected font as well as its properties.
		 * This is vital to make sure that the google-font script that we'll generate later
		 * does not contain any invalid options.
		 */
		private function process_fonts() {

			// Early exit if font-family is empty.
			if ( empty( $this->fonts ) ) {
				return;
			}

			// Get selected subsets
			$subsets = airkit_option_value('typography', 'extra');
			$valid_subsets = array( );
			

			foreach ( $this->fonts as $font => $variants ) {

				// Determine if this is indeed a google font or not.
				// If it's not, then just remove it from the array.
				// if ( ! array_key_exists( $font, $this->google_fonts ) ) {
				// 	unset( $this->fonts[ $font ] );
				// 	continue;
				// }

				// Get all valid font variants for this font.
				$font_variants = array();

				if ( isset( $this->google_fonts[ $font ]['variants'] ) ) {

					$font_variants = $this->google_fonts[ $font ]['variants'];

				}				

				// Check if the selected subsets exist, even in one of the selected fonts.
				// If they don't, then they have to be removed otherwise the link will fail.
				if ( isset( $this->google_fonts[ $font ]['subsets'] ) ) {

					foreach ( $this->subsets as $subset ) {

						if ( in_array( $subset, $this->google_fonts[ $font ]['subsets'], true ) ) {
							$valid_subsets[] = $subset;
						}

					}

				}				
			}			

			$this->subsets = $valid_subsets;			

		}

		/**
		 * Creates the google-fonts link.
		 */
		private function create_link() {

			// If we don't have any fonts then we can exit.
			if ( empty( $this->fonts ) ) {
				return;
			}

			// Get font-family + subsets.
			$link_fonts = array();

			foreach ( $this->fonts as $font => $variants ) {

				$variants = implode( ',', $variants );

				$link_font = str_replace( ' ', '+', $font );

				if ( ! empty( $variants ) ) {

					$link_font .= ':' . $variants;

				}

				$link_fonts[] = $link_font;
			}

			if ( ! empty( $this->subsets ) ) {
				$this->subsets = array_unique( $this->subsets );
			}	

			$protocol = is_ssl() ? 'https' : 'http';

			$this->link = add_query_arg( array(
				'family' => str_replace( '%2B', '+', urlencode( implode( '|', $link_fonts ) ) ),
				'subset' => urlencode( implode( ',', $this->subsets ) ),
			), $protocol . '://fonts.googleapis.com/css' );
		}

		/**
		 * Return an normalized array of all available Google Fonts.
		 *
		 * @return array    Normalized array containg all Google fonts.
		 */
		private function get_google_fonts() {
			if( get_transient( 'airkit_google_fonts' ) ) {

				$this->google_fonts = get_transient( 'airkit_google_fonts' );

			} else if( null === $this->google_fonts || empty( $this->google_fonts ) ) {

				$fonts = $this->google_fonts_get_array();

				$google_fonts = array();

				if ( is_array( $fonts ) || is_object( $fonts ) ) {

					foreach ( $fonts as $font ) {

						if ( !isset( $font['family'] ) ) {
							return false;
						}

						$google_fonts[ $font['family'] ] = array(
							'label'    => $font['family'],
							'variants' => $font['variants'],
							'subsets'  => $font['subsets'],
							'category' => $font['category'],
						);

					}

				}

				$this->google_fonts = $google_fonts;
			}

			return $this->google_fonts;

		}

		/**
		 * Return an array of Google Fonts and their available variants.
		 *
		 * @return array    All Google Fonts.
		 */
		private function google_fonts_get_array() {


			$live_font_list = $this->airkit_get_fontlist();
			
			if ( !is_wp_error( $live_font_list ) && isset( $live_font_list ) ) {

				$font_list = $live_font_list;

			} else {
				$font_list = array('Arial', 'Tahoma');
			}

			return $font_list;

		}

		private function fetch_googlefonts_array() {

			// delete_transient( 'airkit_google_fonts' );

			if ( get_transient( 'airkit_google_fonts' ) ) {

				// Create font transient for 12 hours
				$font_list = get_transient( 'airkit_google_fonts' );

			} else {

				// Request new font list
				$api_key = airkit_option_value( 'typography', 'extra' );
				if ( !isset( $api_key['google_fonts_key'] ) || empty( $api_key['google_fonts_key'] ) ) {
					$api_key = array();
					$api_key['google_fonts_key'] = 'AIzaSyDeHWMNvn__nAwzrnUDJCeUrviMxNBu5R8';
				}
				$font_list = wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . esc_attr( $api_key['google_fonts_key'] ) );

				$font_list = json_decode( $font_list['body'], TRUE );

				// Check if request is ok, store it in transient
				if ( !is_wp_error( $font_list ) && !isset($font_list['error']) ) {
					// Parse the information in the right way
					foreach ($font_list['items'] as $key => $value) {
						$final_fonts[ $value['family'] ] = $value;
					}

					set_transient( 'airkit_google_fonts', $final_fonts, 12 * HOUR_IN_SECONDS );
				} else {
					return new WP_Error( 'broke', __( "Font fetch is wrong", "gowatch" ) );
				}

			}

			return $font_list;

		}


		private function airkit_get_fontlist() {

			if ( get_transient( 'airkit_google_fonts' ) ) {

				// Create font transient for 12 hours
				$final_fonts = get_transient( 'airkit_google_fonts' );

			} else {
				$api_key = airkit_option_value( 'typography', 'extra' );

				/*
				 * First we want to try to update the font transient with the
				 * latest fonts if possible by sending an API request to google. 
				 * If this is not possible then the theme will just use the 
				 * current list of webfonts.
				 */
				// Get list of fonts as a JSON Object from Google's server
				$response = wp_remote_get( "https://www.googleapis.com/webfonts/v1/webfonts?key=" . esc_attr($api_key['google_fonts_key']), array( 'sslverify' => false ) );	
				/*
				 * Now we want to check that the request has a valid response
				 * from google. If the request is not valid then we fall back
				 * to the webfonts.json file.
				 */

				$json = false;
				// Check it is a valid request
				if ( ! is_wp_error( $response ) ) {
					$font_list = json_decode( $response['body'], true );
					// Make sure that the valid response from google is not an error message
					if ( ! isset( $font_list['error'] ) ) {
						$json = $response['body'];
					}
				}
				/**
				 * Pull in raw file from the WordPress subversion 
				 * repository as a last resort. 
				 * 
				 */
				if ( false == $json ) {
					$fonts_from_repo = wp_remote_fopen( "https://touchsize.com/red-area/webfonts.json", array( 'sslverify' => false ) );
					$json            = $fonts_from_repo;
				}
				$font_output = json_decode( $json, true );
				$final_fonts = array();
				foreach ($font_output['items'] as $key => $value) {
					$final_fonts[ $value['family'] ] = $value;
				}

				set_transient( 'airkit_google_fonts', $final_fonts, 180 * HOUR_IN_SECONDS );

			}

			return $final_fonts;
		}
	}
}
