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
define('DB_NAME', 'lj_partition_2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'adminpw4mysql');

/** MySQL hostname */
define('DB_HOST', '192.168.100.97');

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
define('AUTH_KEY',         'Q-weZw{&pPae2-DVv0Tx JT#wO^Duq~goZwcu`)#!da* ?pZ>QW&/31F&v3-]{l ');
define('SECURE_AUTH_KEY',  '/m#WTP%*Mqp|m+F2`.*|sd%`{}TF9Vh5dzwck=pIV^4`9;dz&?>}q%GEd,/~)jLe');
define('LOGGED_IN_KEY',    '~&c7gcBFXFR;A9}E2xMyqkA/+egD:W50amA5FcR+KJmvxO|<%n;w-/>)jMM]$@9S');
define('NONCE_KEY',        ':@(6}-$jh}$:AGG$>WvHlK^%MmSJCw85M3~C9g+#,GJj:|O;_BZ{MJ~+AE$=FBdQ');
define('AUTH_SALT',        '&RG@7dYh<3_2mG4lOL7!|NHx$5*)fq$v^!.l=+){W+]S2fq+L4H<XKHtzA+c|Dhc');
define('SECURE_AUTH_SALT', '{gI~C)A;6)<wY|fJ_9Dc!( z<e&<iHP4w@{m^`tp6`e,uZ],fk0y-.?,VM8Ma%C)');
define('LOGGED_IN_SALT',   'l<b@I~+|!?F/q+-x3o:lF<HNZN?PYC?w+E +M;=?U#kk_xstQ(pL9<}sT?9o5gm^');
define('NONCE_SALT',       '%-nfd97T~Txkw=PQ$vYOPWVv0xoU{;}4G?>jN+U{&BvU]w/FWoMp)g-ynfh/GOd[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
