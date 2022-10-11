
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
define( 'DB_NAME', 'practicedatabase' );

/** Database username */
define( 'DB_USER', 'nvxcq8oj5pjwifrt' );

/** Database password */
define( 'DB_PASSWORD', 'f1zuggtovusw78z2' );

/** Database hostname */
define( 'DB_HOST', 'ltnya0pnki2ck9w8.chr7pe7iynqr.eu-west-1.rds.amazonaws.com' );

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
define( 'AUTH_KEY',         '~v9vC7xAlby._rYx$-d4O$F10s~97ZN7@=a<E<!g*kTX5J24GtYF%EgxuQ%a)ZV$' );
define( 'SECURE_AUTH_KEY',  'cma~7_9n!_l^Ux0S{`t,:`Gp/`8boyi<d^8y)m$@O-+?&FB^(`sOJb-~t8AA{b:g' );
define( 'LOGGED_IN_KEY',    '[:3mcWWN~i:n&JGG1q^*iWH:[DF>G@g &hWar(eSauG[j~NLXj_IYL?Nd66_t|dm' );
define( 'NONCE_KEY',        'bo,>)+H2</|W,u=&9 _O_T@W2lc1RuYB1)^sp?TjIF0 5&g-5(6eo~&e*1C,mR]$' );
define( 'AUTH_SALT',        '9H<p+@(IPb;x.Plq5SMu/-8s)lm%WIy9N04,7wihTGRpTa/|uznMCQNAy&|Vcjcy' );
define( 'SECURE_AUTH_SALT', ':&?!/9 MI7YK.uggjUCSJ#3*/[a*N{*(}O}%cI/&ubRys,BGg;ox)=#39k?PQ[;u' );
define( 'LOGGED_IN_SALT',   ']I_^t=lQk1&8Mz8C=:39g./[:nR(y^@PlsSfp8M+tYhf2!iGJzIrJEPD<e2D_4>o' );
define( 'NONCE_SALT',       'SzA2%RYs,v7-=4o@&z]tNX&UneKj:)!U^i(?c>Q`ouu8[;^pwfw??e:Yi9lBY(Wn' );

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
