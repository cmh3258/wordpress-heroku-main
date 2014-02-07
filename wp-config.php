<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_db');

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
define('AUTH_KEY',         '=RP$@x|cUO>qs!$`,8Q6(-IbvB@U$(MHkJY5e~t]OMD 1H1`rP}T|rE!+OocSd4c');
define('SECURE_AUTH_KEY',  'aIC.`/R*<Xc+@A qHxqUU9vGg*-{)g-Xf2L;@!RyM+2.@Kv2-j3&6xKVJgW=>{%Y');
define('LOGGED_IN_KEY',    'fAi;6xPhMwt;tys%8+.mu<qqg:8-!+sbV90*-(::og+dX+QLn6A#]_*W<-0LN*x7');
define('NONCE_KEY',        'l,NO#;ZZ+0nFC}-Tzqmv/{%-mussv2#1MV,VO&hK>M}=`}x[BO|HmLt2?J-MepX~');
define('AUTH_SALT',        'B%]n-!NYmB%zcG*6<R#<:275tq)G.Hj%b3K>G|m$q`j,a<r4cORt5Sy9VQUX%(9C');
define('SECURE_AUTH_SALT', '>r0w}0lz*X&=S&n<g}g)!N@51$[`!D Dg44@S|?)+RDu@!QNL9W}a8mKL,LJr.9=');
define('LOGGED_IN_SALT',   '&6$YgWIL62Upo?q^1Y-~NG`f-}hY1~`7+L09Sg,mqJ.U$DbPYss,66wJf[yzW5K|');
define('NONCE_SALT',       'e~@f]?^I>o*|;^$Z{aq]s1v?HXUu3Y|@Ht$?Z>4=-u%)FUOTLmb=AR!9lw1F S($');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_github';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
