<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'kamibijak_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*Sxn|OKtkI|/jrVpqEYDzmnt~z9*#zQUcm{~^*ja+ </Rh-FZ&$=yN-MQ8G#hm+g');
define('SECURE_AUTH_KEY',  'rpPPkV|dK2^T!GWt)VO(F8M/qv[Qce+Zf)#i!n$Du^7KDp2fs(06jjwcdU~62k+2');
define('LOGGED_IN_KEY',    'vyE*[/d`tPGj3.:6B;EW4FEllw_Sb!Ljm^nm#LA0k{cH?% {3p,Mh9eN|=5+.ncZ');
define('NONCE_KEY',        'ux_-D0w~>FwsJy#r1c[A,Wg#T%knY`/0AlrS|S`K3<7K>X(Uz|Soi}N^zm*I2{|~');
define('AUTH_SALT',        'ZiVT{4)-3ym%*h~K&18nb-vE%&Ee7&Xn/6^`Y44O~a$61XnU.=^Vjt6S0Uk@d;/v');
define('SECURE_AUTH_SALT', 'y4Xuc(vY>siZ^wr^w&$WUrhb9b=0:uAy4LUXAD[QRL@Ia}.zQi>0TlhC3LO|NL)3');
define('LOGGED_IN_SALT',   'qWxoa[l`MoqU|h|YT+8IMF05q&U|}9&NK[d+9!>,)%$hj+mNz[zAXYA/_S(+wxqA');
define('NONCE_SALT',       'p`,]EjwHWuI{T]J&48xF[3yp6yQ-ZN.t?}<f4>t}j1}V$z1|P/5B/D6+gaj(~77(');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Fix Plugin Instalation */
//define('FS_METHOD', 'direct');

define('WP_MEMORY_LIMIT', '256M');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
