<?php
define('AIRKIT_THEMENAME', 'gowatch');

if ( ! defined('AIRKIT_PREFIX') ) {
    define('AIRKIT_PREFIX', 'airkit_');
}

if ( ! defined( 'AIRKIT_PATH' ) ) {
    define( 'AIRKIT_PATH', get_template_directory() );
}


if ( is_admin() ) {

	//Fields Class
	require ( AIRKIT_PATH . '/includes/class.fields.php' );

	//Builder settings.
	require ( AIRKIT_PATH . '/includes/builder/class.builder-settings.php' );

	// Layout builder templates
	require ( AIRKIT_PATH . '/includes/builder/class.template.php' );

    // Meta revisions
    require ( AIRKIT_PATH . '/includes/builder/class.revisions.php' );

    // Options theme.
    require ( AIRKIT_PATH . '/includes/class.options.php' );

    // YouTube Video Importers
    require ( AIRKIT_PATH . '/includes/class.videoimporter.php' );
}

// Customizer Options theme.
require ( get_template_directory() . '/includes/wpcustomize.php' );

// Alert require plugins
require ( AIRKIT_PATH . '/required-plugins/class.tgm-plugin-activation.php' );

// Include to search tags and custom post
// require ( AIRKIT_PATH . '/includes/class.rfm-taxonomy-search.php' );

// Functions
require ( AIRKIT_PATH . '/includes/functions.php' );

// Define custom constants, image sizes, nav menus...
require ( AIRKIT_PATH . '/includes/theme-setup.php' );
require ( AIRKIT_PATH . '/includes/class.images.php' );
new Airkit_Images();

// Frontend submission.
require ( AIRKIT_PATH . '/includes/frontend-submission/tszf.php' );

// Post Meta
require ( AIRKIT_PATH . '/includes/class.postmeta.php' );

// Layout Compilator
require ( AIRKIT_PATH . '/includes/class.compilator.php' );

// Dynamic included CSS and JavaScript
require ( AIRKIT_PATH . '/includes/dynamic-css-and-js.php' );

// Dynamic Google fonts.
require ( AIRKIT_PATH . '/includes/class.typography.php' );
new Airkit_Google_Fonts();

// Likes system
require ( AIRKIT_PATH . '/includes/class.touchsize-likes.php' );

// Aqua resizer
require ( AIRKIT_PATH . '/includes/aq_resizer.php' );

// Include for the widgets
require ( AIRKIT_PATH . '/includes/class.widgets.php' );

if( function_exists('bp_is_active') ) {
    // BuddyPress Compatibility
    require ( AIRKIT_PATH . '/includes/class.bp-extend.php' );
    new Airkit_BP_Extend();

}

/**
 * Autoloads files when requested
 * 
 * @since  1.0.0
 * @param  string $class_name Name of the class being requested
 */
function airkit_widgetFileAutoloader( $class_name ) {

    /**
     * If the class being requested does not start with our prefix,
     * we know it's not one in our project
     */

    /*
     * Remove 'airkit_' prefix from filename.
     */

    if( 0 == strpos( $class_name, 'airkit_widget_' ) ) {

        $class_name = str_replace( 'airkit_widget_', 'widget_', $class_name );

    }

    if ( 0 !== strpos( $class_name, 'widget_' ) ) {
        return;
    }

    // Compile our path from the current location
    $airkit_file = AIRKIT_PATH . '/includes/widgets/'. $class_name .'.php';

    // If a file is found
    if ( file_exists( $airkit_file ) ) {
        // Then load it up!
        require ( $airkit_file );
    }
}

spl_autoload_register( 'airkit_widgetFileAutoloader' );

// Register theme custom widgets
$airkit_widgets = array(
    'airkit_widget_advertising'     => 'advertising',
    'airkit_widget_comments'        => 'comments',
    'airkit_widget_facebook'        => 'facebook',
    'airkit_widget_flickr'          => 'flickr',
    'airkit_widget_instagram'       => 'instagram',
    'airkit_widget_latest_posts'    => 'latest_posts',
    'airkit_widget_list_events'     => 'list-events',
    'airkit_widget_most_liked'      => 'most-liked',
    'airkit_widget_most_viewed'     => 'most-viewed',
    'airkit_widget_popular'         => 'popular',
    'airkit_widget_tabber'          => 'tabber',
    'airkit_widget_tags'            => 'tags',
    'airkit_widget_tweets'          => 'tweets',
    'airkit_widget_column_menu'     => 'column_menu',
    'airkit_widget_list_categories' => 'list_categories',
    'airkit_widget_stats'           => 'stats',
    'airkit_widget_social_icons'    => 'social_icons',
    'airkit_widget_latest_reviews'  => 'latest_reviews',
    'airkit_widget_social_follow'   => 'social_follow',
);

foreach ( $airkit_widgets as $key => $value ) {

    if ( class_exists( $key ) ) {

        register_widget( $key );

    }

}

// Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
function airkit_addMenuClassAttr( $ulclass ) {
	return preg_replace('/<div class="(.*)"><ul/im', '<div><ul class="$1"', $ulclass);
}
add_filter( 'wp_page_menu', 'airkit_addMenuClassAttr' );

if ( ! isset( $content_width ) ) $content_width = 960;

// Add WooCommerce Support for the theme
require ( AIRKIT_PATH . '/woocommerce/theme-woocommerce.php' );

require ( AIRKIT_PATH . '/includes/class.megamenu.php' );

new airkit_Is_Megamenu();

// Ajax
require ( AIRKIT_PATH . '/includes/ajax.php' );

// Custom posts and Metadata
require ( AIRKIT_PATH . '/includes/custom-posts.php' );

?>