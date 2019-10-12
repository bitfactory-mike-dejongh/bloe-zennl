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

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Root path */
if ( !defined('ROOT') )
	define('ROOT', dirname(dirname(__FILE__)) . '/');

/* Forced constants not to be overridden by the .env configuration file. */
define('WP_AUTO_UPDATE_CORE', false);

/* Read .env file for environment specific configuration. */
if (file_exists(ROOT . ".env")) {
	$handle = fopen(ROOT . ".env", "r");
	if ($handle) {
		while (($line = fgets($handle)) !== false) {
			$values = explode('=', trim($line), 2);
			if (!empty($values[0]) && !defined($values[0]) && isset($values[1])) {
				define($values[0], $values[1] == "true" ? true : ($values[1] == "false" ? false : $values[1]));
			}
		}
		fclose($handle);
	} else {
		http_response_code(500);
		die('failed opening .env file');
	}
} else {
	http_response_code(500);
	die('missing .env file, please create and .env file by copying the .env.example');
}

/* Default WordPress settings when omitted from .env file. */
$table_prefix  = defined('TABLE_PREFIX') ? TABLE_PREFIX : 'wp_';

if (!defined('WP_DEBUG'))
	define('WP_DEBUG', false);

if (!defined('FS_METHOD'))
	define('FS_METHOD', 'direct');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
