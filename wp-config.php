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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ubayubay_optical' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'd;A.CXGv2}!wVUe5(vU_8=5*n&A7wIUs@kT]c)a5]5|zm#5EM%`WnhQ&?z8Hix#:' );
define( 'SECURE_AUTH_KEY',  'S4KGSYuS,=sLFH*:+^6V*2cs<Kvko^*sRUiM:I0,TCoe>lQT&/=f( XK(d.RD+eq' );
define( 'LOGGED_IN_KEY',    'Bj7bPrYJ8wku/?^GWgOyD*wqI;fM1O}T&:?v5D:d&P($ZqsYB7);AH*IY$cbYhNb' );
define( 'NONCE_KEY',        '@.h5A,%/3F}^[i{zH>bHv_@5XCDP{IWn 8.T9Q^xufChdy48r-(4vSY*I4VNMb1(' );
define( 'AUTH_SALT',        'qn5j0^j)DVJB&(raTw,>K&]^`1m!B!2E9f0w|1|Salrn|,*C)#P9 cC8~fi[P5O@' );
define( 'SECURE_AUTH_SALT', 'pVK$:*</?Bl@/7g$#^BEx~F&H1}^+aNy/6]TQ+ohSoeSiaYN@A9Q{i[ ubg5LB(g' );
define( 'LOGGED_IN_SALT',   'E=B->Vs.(MPe|o(de$69>e^6I9|j6z*q3f;)j~))nel7=#5qbo&)`qm}Vk}.q!YQ' );
define( 'NONCE_SALT',       'MpVLRpLTH9CWt?#UoW7RF]?^_{Ss[xJl[P1hVXBmPx4m^9cILdk z&jir(NMnP>3' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
