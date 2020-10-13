<?php 

 // Don't duplicate me!
 if ( !class_exists( 'Ts_Importer' ) ) {

	class Ts_Importer {

		/**
		 * Set name of the content file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $optionsDemo;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $widgets;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $content_demo;

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $flag_as_imported = array( 'content' => false, 'menus' => false, 'options' => false, 'widgets' =>false );

		/**
		 * imported sections to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $imported_demos = array();

	    /**
	     * Holds a copy of the object for easy reference.
	     *
	     * @since 0.0.2
	     *
	     * @var object
	     */
	    private static $instance;

	    /**
	     * Constructor. Hooks all interactions to initialize the class.
	     *
	     * @since 0.0.2
	     */
	    public function __construct() {

	    	$this->demo_files_path = get_template_directory() . '/import/demo-files/';

	        self::$instance = $this;

	    }

    	public function intro_html() {

			?>

			
			<?php if( !empty($this->imported_demos) ) { ?>

			  	<div style="background-color: #FAFFFB; margin:10px 0;padding: 5px 10px;color: #8AB38A;border: 2px solid #a1d3a2; clear:both; width:90%; line-height:18px;">
			  		<p><?php esc_html_e('Demo already imported', 'touchcodes'); ?></p>
			  	</div><?php
			   	//return;

			  }
    	}

	    /**
	     * demo_installer Output
	     *
	     * @since 0.0.2
	     *
	     * @return null
	     */
	    public function demo_installer() {

			$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

			if( !empty($this->imported_demos ) ) {

				$button_text = esc_html__('Import Again', 'touchcodes');

			} else {

				$button_text = esc_html__('Import Demo Data', 'touchcodes');

			}

			if ( function_exists('airkit_import_selectors') ) {
				airkit_import_selectors();
			} else {
				echo 'TouchCodes is not installed or you don\'t have the latest version. Please check.';
			}

	        ?>
	        <?php

	    }

	    public function process_imports( $slug ) {


	    	$this->content_demo = $this->demo_files_path . $_POST['demo-style'] . '.xml';
    		$this->widgets = get_template_directory_uri() . '/import/demo-files/' . $_POST['demo-style'] . '.json';
    		$this->optionsDemo = get_template_directory_uri() . '/import/demo-files/' . $_POST['demo-style'] . '.txt';

			if ( !empty( $this->content_demo ) && is_file( $this->content_demo ) ) {
				$this->set_demo_data( $this->content_demo );
			}

			$this->set_demo_options( $this->optionsDemo );

			if ( !empty( $this->widgets ) ) {
				$this->ajax_import_widget_data( $slug );
			}

        }


        public function ajax_import_widget_data( $slug ){

			self::clear_widgets();

			$plugin_dir_path = plugin_dir_path(__FILE__);
			// Forwardslash it
			
		    $file = str_replace('\\', '/', $this->widgets);
		    $plugin_dir_path = str_replace('\\', '/', $plugin_dir_path);


			$file = str_replace($plugin_dir_path, get_template_directory_uri() . '/import/demo-files/', $file);

        	$json_data = wp_remote_get($file);
    		$json_data = wp_remote_retrieve_body($json_data);
        	$json_data = json_decode($json_data, true);
        	$succes = ( self::parse_import_data( $json_data, $slug ) ) ? '' : 'Unknown Error Import Widgets';
        	echo airkit_var_sanitize( $succes, 'the_kses' );

        }

        private function clear_widgets() {
        	$sidebars = wp_get_sidebars_widgets();
        	$inactive = isset($sidebars['wp_inactive_widgets']) ? $sidebars['wp_inactive_widgets'] : array();

        	unset($sidebars['wp_inactive_widgets']);

        	foreach ( $sidebars as $sidebar => $widgets ) {
        		if ( is_array($inactive) && is_array($widgets) ) {
	        		$inactive = array_merge($inactive, $widgets);
        		}
        		$sidebars[$sidebar] = array();
        	}

        	$sidebars['wp_inactive_widgets'] = $inactive;
        	wp_set_sidebars_widgets( $sidebars );
        }

        public static function parse_import_data( $import_array, $slug ) {

        	$sidebars_data = $import_array[0];
        	$widget_data = $import_array[1];

        	$theme_slug = $slug;

        	$current_sidebars = get_option( 'sidebars_widgets' );

        	$currentSidebarsTs = get_option( $theme_slug . '_sidebars');


        	if( isset($currentSidebarsTs) && !empty($currentSidebarsTs) && is_array($currentSidebarsTs) ){
        		foreach($currentSidebarsTs as $index => $value){
        			$current_sidebars[$index] = array();
        		}
        	}

        	$new_widgets = array( );

        	if ( is_array( $sidebars_data ) ) {
	        	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

	        		foreach ( $import_widgets as $import_widget ) :
	        			//if the sidebar exists

	        			if ( isset( $current_sidebars[$import_sidebar] ) ) :
	        				$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
	        				$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
	        				$current_widget_data = get_option( 'widget_' . $title );
	        				$new_widget_name = self::get_new_widget_name( $title, $index );
	        				$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

	        				if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
	        					while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
	        						$new_index++;
	        					}
	        				}

	        				if( !is_array($current_sidebars[$import_sidebar]) ) $current_sidebars[$import_sidebar] = array();
	        				$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;

	        				if ( array_key_exists( $title, $new_widgets ) ) {
	        					$new_widgets[$title][$new_index] = $widget_data[$title][$index];
	        					$multiwidget = $new_widgets[$title]['_multiwidget'];
	        					unset( $new_widgets[$title]['_multiwidget'] );
	        					$new_widgets[$title]['_multiwidget'] = $multiwidget;
	        				} else {
	        					$current_widget_data[$new_index] = $widget_data[$title][$index];
	        					$current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : 1;
	        					$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
	        					$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
	        					unset( $current_widget_data['_multiwidget'] );
	        					$current_widget_data['_multiwidget'] = 1;
	        					$new_widgets[$title] = $current_widget_data;
	        				}

	        			endif;
	        		endforeach;
	        	endforeach;
        	}


        	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
        		update_option( 'sidebars_widgets', $current_sidebars );

        		foreach ( $new_widgets as $title => $content ) {
        			$content = apply_filters( 'widget_data_import', $content, $title );
        			update_option( 'widget_' . $title, $content );
        		}

        		return true;
        	}

        	return false;
        }

        public static function get_new_widget_name( $widget_name, $widget_index ) {
        	$current_sidebars = get_option( 'sidebars_widgets' );
        	$all_widget_array = array( );
        	foreach ( $current_sidebars as $sidebar => $widgets ) {
        		if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
        			foreach ( $widgets as $widget ) {
        				$all_widget_array[] = $widget;
        			}
        		}
        	}
        	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
        		$widget_index++;
        	}
        	$new_widget_name = $widget_name . '-' . $widget_index;
        	return $new_widget_name;
        }

        public function set_demo_options( $url ){

        	if( !function_exists('ts_enc_string') ) {
        	    echo ('You need to install TouchCodes plugin');
        	    return;
        	}

        	$file_headers = @get_headers( $url );

        	if( $file_headers[0] !== 'HTTP/1.1 404 Not Found' ) {

        		$file_data = wp_remote_fopen( $url );

        		$options = unserialize(ts_enc_string($file_data, 'decode'));

        		if ($options === null) {
        			return false;
        		} else {

    				foreach( $options as $option_name => $params ){
    					delete_option($option_name);
    					add_option($option_name, $params);
    				}

        		}
        	}else{
        		echo esc_html__('File settings.txt not found', 'touchcodes');
        	}
        }

	    public function set_demo_data( $file ) {

		    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

	        require_once ABSPATH . 'wp-admin/includes/import.php';

	        $importer_error = false;

	        if ( !class_exists( 'WP_Importer' ) ) {

	            $class_wp_import = get_template_directory() .'/import/class.wordpress-importer.php';

	            if ( file_exists( $class_wp_import ) )
	                require_once( $class_wp_import );
	            else
	                $importer_error = true;


	        }

	        if( $importer_error ){

	            die( "Error on import" );

	        } else {

	            if( !is_file( $file ) ) {

	                echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Import data folder) manually.";

	            } else {
	            	if ( class_exists( 'WP_Import' ) ) {
		               	$wp_import = new WP_Import();
		               	$wp_import->fetch_attachments = true;
		               	$wp_import->import( $file );
						$this->flag_as_imported['content'] = true;
					} else {
						echo 'No WP_Import Class';
					}

	         	}

	    	}

	    }

	}//class

}//function_exists

?>