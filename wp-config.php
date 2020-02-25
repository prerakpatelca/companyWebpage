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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '*jl>*-=@dScS)bWvS da}XjoZGD{6c7I&VTNz23f<*3aX*.J2GR>1vY|KdtlPN`d' );
define( 'SECURE_AUTH_KEY',  '5pV>:|{?fb3N{:MhGHU1jM&q:R#G#/]z3:#{s- ](K(QDT4O5I:Cgr}t()^*k6;h' );
define( 'LOGGED_IN_KEY',    'Fc7x>pcMiz}@:kUPL~v+8+DYgu0HidyurAwHy>I4K9 YZ7q#><6&[rY@|]z=-uT?' );
define( 'NONCE_KEY',        'Tlh8ep_^AEj7o&u?I&~lrD{)]}L<wOlv6y/o7`?-4g$sWsi!1W4r7tgd;FuaCO7m' );
define( 'AUTH_SALT',        'S>&~z+AE[-.&[l]LOHw`^AP8DLG9DYcUl?uteXiuL1K`f)Bm2H$!sodP4UwV!6tL' );
define( 'SECURE_AUTH_SALT', ',?kg1DPIiueJCs8%htjSPg@vO~o#UmkTwE;zajgOrkCLc6Q =YRw%w5JeuuA1 ?}' );
define( 'LOGGED_IN_SALT',   'Zn>k&KhJQjLcJ.,Ep?,K,($HH/*]iyj7)h-Z .n[jQz$Ef|17TQG.^)]c2/:bAuj' );
define( 'NONCE_SALT',       '7;@Eg <ABBFb=0V,<^TE-LsQGb+~1FS1h7sPC~X!/E6M~i`Il7u%w*!5KAAI NM(' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
