<?php
/**
 * Plugin Name: Touch Video Ads
 * Plugin URI: http://touchsize.com/
 * Description: Video Advertising options
 * Version: 1.0.0
 * Author: Touchsize
 * Author URI: http://touchsize.com/
 * Text Domain: touchvideoads
 * Domain Path:
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined('TS_VA__FILE__') ) define( 'TS_VA__FILE__', __FILE__ );
if ( !defined('TS_VA__DIR__') ) define( 'TS_VA__DIR__', dirname( __FILE__ ) );
if ( !defined('TS_VA__VERSION') ) define( 'TS_VA__VERSION', '1.0.0' );
if ( !defined('TS_VA__INC') ) define( 'TS_VA__INC' , TS_VA__DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR );

if ( !function_exists( 'touchvideoads_autoloader' ) ) {
    function touchvideoads_autoloader( $class )
    {
        $path = TS_VA__INC . 'class.' . strtolower( str_replace( '_', '-', $class ) ) . '.php';

        if ( file_exists( $path ) ) {

            include( $path );
        }
    }
    spl_autoload_register( 'touchvideoads_autoloader' );
}

$touchvideoads = new TouchVideoAds();

?>