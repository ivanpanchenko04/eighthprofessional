<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'eighthprofessional' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'eU#2o,dz]u==)9RPve7JSKfGOO3cODb+EMmCQb I%{@p:MM-+8.v*{*- kRV;`=e' );
define( 'SECURE_AUTH_KEY',  ')!&hLBt(X=2HMzQ[~,:|6.J;4_yvYs6.l 8VuOb_@aE~iyYK<bzjh[B>Uj*Z!QU$' );
define( 'LOGGED_IN_KEY',    'Ka8 %w==CrQgEHpMl->%tG;raRN3 U{Bf9u|(##,kU|bt~;:%+s6#~72h=jaO+i6' );
define( 'NONCE_KEY',        'uMqZ{(>q<uJiGoo.G&K@ByOD73&S]b_dE p/kciF4jE)<P=3F @Rm5H1&wy-?fvg' );
define( 'AUTH_SALT',        'zsLlu60hSz&G*Y5Pe?!=}, *;$A&e[t?-O EaC#z}[mu~=hT_^+{nhn9/Fx702E}' );
define( 'SECURE_AUTH_SALT', 'uu%Q;EOIy.3zHJCT|S{y-{dtB3yL|/#u&XCZh+$@q)92RVsZDB2GMyS_mY=bo8UJ' );
define( 'LOGGED_IN_SALT',   'i&mHLsRdF]otII@V$oQd#8n:7il2-9&@,,n2@+M1HgM)yB@j3S8KPkw/|CXFn|D0' );
define( 'NONCE_SALT',       'udj<,|PC8#;-6g,GGnY}=(rD!A<B)7&wP08*EeJgHp{byf0RH?H?o -}7A-y%jtl' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
