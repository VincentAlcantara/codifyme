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
define('DB_NAME', 'codifyme');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '~xqLSwdot#p=_=otFn+|*2DodpAI|EqUuWn*NX~kE.qAvU.Bvxk2E!h*|(= 8{pL');
define('SECURE_AUTH_KEY',  'nUIuIPmzaLclwc|Yu3w>7~_@yrb]M7?v92g{4S)awr9}(>f8<WuAzaN&afix9%xj');
define('LOGGED_IN_KEY',    '1h`.!L!xj-p*PCHt%CHe|O)<U8Hz|a$ &Tb3}-`r9+b?NrxuenPlvS!E$Gw)2-~*');
define('NONCE_KEY',        '=#P+pro1.5nKp-gV9+vH>J~m|T$^k/`3ZfJZ`[b&PXKnx(CN~*Z#mz2U2=8+sbwT');
define('AUTH_SALT',        'sem~#VLz:5@`(h[8I4Ax4D;8+wdJ|E+~n(wO*M7sUw:MzPu!rrD)y[[8Yx_1jrX4');
define('SECURE_AUTH_SALT', 'f7mab<!cX%Q%D&nea!;K3:xP--$}r14qBIDO*iAPe5Om)D_.l.ohLi I^E@wV= A');
define('LOGGED_IN_SALT',   'b<lQCvHc*HX0:k|3Xlch8{$c,_.3Y5MCRr8-bY|xG2CEpj/j,+7Fojhr)--GUvnu');
define('NONCE_SALT',       '^T7sa-=^DXG*qu1)V:n+B=wp~N*Q-H`~j-#}*NC6 @$&Ko#U1~^>6r*TrvtCGs#v');

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
