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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'prueba' );

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
define( 'AUTH_KEY',         'k5T[($lC3(kMwDLyR{EdfYt!o=|D_*UK0QUT&Jh{(*TtJ)n/[Y>l;`,qoq8)SmdA' );
define( 'SECURE_AUTH_KEY',  'a)K0/&B=/9cr T{rKl<2)XH<{HsYZiIQ 5%t)=GfB,$0}ap1PC+p5T`k$}568[,}' );
define( 'LOGGED_IN_KEY',    'dMO~DnfohhrTc`X2q*NXFR}h6gL!aTLd=UeH(PXU4(9$lTNH28H< )i{6.quYb]3' );
define( 'NONCE_KEY',        ');~OoVaUPY}Ku.YY.9Ie|I?[!H(i$b8^|o&yyc?;JF1V1<4`Sx1.?`lp}5}Y;`=#' );
define( 'AUTH_SALT',        ']qF?T2M8rIGJ!g)vWW$A|VEXiokc]so {UZXy4{g{D(aa%9PU}o,KOOlC?]7_++s' );
define( 'SECURE_AUTH_SALT', 'AJAY++V7Etnnek[XIne[@21|J<@%06$[j;#3&@b[<GQeCpe{%$~tQr.eR=(5y|pS' );
define( 'LOGGED_IN_SALT',   '*Ie+(M(qWVnrB54?=y*Y5^rU4%69Sr-_DoV$HhbNRb +F$oVKGZpd5F{z#x5bT,4' );
define( 'NONCE_SALT',       'Gl04uO#|S_T98I1Vto0_7{$Aipe;v]7c#t0R<$B.fmLvZi7cn/d0TKZ9Nft(t)Wl' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
