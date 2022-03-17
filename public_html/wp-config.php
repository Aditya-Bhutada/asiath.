<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u742613684_IB1L9' );

/** MySQL database username */
define( 'DB_USER', 'u742613684_mWYSo' );

/** MySQL database password */
define( 'DB_PASSWORD', 'gzKB3LvngE' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '{e[Cvk4E1p{,<aLZrs8Rx8  ^[cCRW>17s_anZOnj7hL6i^z6>=q1-D%Z$/NrS/b' );
define( 'SECURE_AUTH_KEY',   'X&_L~I#b87V_O7HLntn}Xj*gB8GEjqxFOfj%$*UNtU#zRVEwuvb:^ ^x:E+u0 5T' );
define( 'LOGGED_IN_KEY',     'h4gv$o)_;K.F9QZ:9&$nG;CwDlzaF=6v Og?(@+6H2t~>q(Kl6Ja%k4b`WSor?;E' );
define( 'NONCE_KEY',         '%]|MX]^01lK0G^^A<+L8))Q>UR[9o/(1c?!]l1o^RrbE@^!:E<lcaphOGp&b|{U<' );
define( 'AUTH_SALT',         'EpMI:`wCKSliRVNXx!|d[!*mk kN`H+ :TSN$qwRSPm}!I6()F+mK3hI3S3J;^7Z' );
define( 'SECURE_AUTH_SALT',  'p/|%3}Yghg.-Ub8GDn)2opL/^g5ED5j=H[M`Yz96(>zbCquZ5:}AaH?m*I]_|>n<' );
define( 'LOGGED_IN_SALT',    '6R/%Z6z({IlrMwo:F}q|}&cRD4Y,V?65&+ t-O|HyP|~xT0tgIC^ND2(4? |p+1X' );
define( 'NONCE_SALT',        ';.dWey6]LW#a 1JM1{yFF`33|xfBi@#GT[&1Kqay_Jp7IaMw[k-LUPf~aotCqHgA' );
define( 'WP_CACHE_KEY_SALT', '.;,mR5k#g1LA<DOvV#}VE.#I)DKM$gKUJE0jt`THe9Eg|n}zpE/&Z0)+,y<P|Lp`' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
