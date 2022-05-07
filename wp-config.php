<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'portfolio_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0uLsGWAEt]xinTI8[6!2Bj}O0]LSeX9~O^-9)IB%u3;$Qw=uk?+4;rZ39].zp7h%' );
define( 'SECURE_AUTH_KEY',  '.;>UnfRS{#Ucg@9YQ#yw`!=AbW|>jp$IM9Asmz~4?j_?jN5.qqS=@<2B0C0]Q/bd' );
define( 'LOGGED_IN_KEY',    '#wnBF?;z.pzU 6Cswr15d.o!c^&H;hcFCn<XpqFG9[I?TP&XbT9No8(WIiDkii !' );
define( 'NONCE_KEY',        '[1X?`t6i`3W*S]8n,ru}~6^wOida;LPf0<>tvk+;EoXF}P#$_.^*;O3s[m#RBby,' );
define( 'AUTH_SALT',        '[ex%1kLq/,bvJlb7^+:0xgWDq=rbcnkWWHx:^bf-|e-/}fo8tKb`W@T*|qmh>}<5' );
define( 'SECURE_AUTH_SALT', 'PbT+]V@!Bk{3JGB*@DtY/Psi4F7hOvbm]+)o*U2bw$q,ES<;v}&V69G!+Po:Nj}A' );
define( 'LOGGED_IN_SALT',   'D)+u2(&,tiV 0<Z]c*I]AqzzGh^HVd]o5VDihM)RJ^G9r-|4!%H1WPxEFsM<!h).' );
define( 'NONCE_SALT',       'L<.z9^/`@OFG!T&l+*F sQEGAb9=G79j9.[241M=0oJrs8RJWtLwabgi%?AgY!f,' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
