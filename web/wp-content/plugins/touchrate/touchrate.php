<?php
/**
 * Plugin Name: Touch Rate
 * Plugin URI: http://touchsize.com/
 * Description: Adds star rating functionality to a WordPress website
 * Version: 1.0.0
 * Author: Touchsize
 * Author URI: http://touchsize.com/
 * Text Domain: touchrate
 * Domain Path:
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( !defined('TS_TR__FILE__') ) define( 'TS_TR__FILE__', __FILE__ );
if ( !defined('TS_TR__DIR__') ) define( 'TS_TR__DIR__', dirname( __FILE__ ) );
if ( !defined('TS_TR__VERSION') ) define( 'TS_TR__VERSION', '1.0.0' );
if ( !defined('TS_TR__INC') ) define( 'TS_TR__INC' , TS_TR__DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR );

if ( !function_exists( 'touchrate_autoloader' ) ) {
    function touchrate_autoloader( $class )
    {
        $path = TS_TR__INC . 'class.' . strtolower( str_replace( '_', '-', $class ) ) . '.php';

        if ( file_exists( $path ) ) {

            include( $path );
        }
    }
    spl_autoload_register( 'touchrate_autoloader' );
}

$touchrate = new TouchRate();
register_activation_hook( TS_TR__FILE__, array( $touchrate, 'create_table_touchrate' ) );

?>