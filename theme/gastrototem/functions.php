<?php
/**
 * Gastrototem Theme.
 *
 * Punto de entrada. Define constantes y carga los módulos de inc/.
 *
 * @package Gastrototem
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GTT_THEME_VERSION', '0.1.0' );
define( 'GTT_THEME_DIR', get_stylesheet_directory() );
define( 'GTT_THEME_URI', get_stylesheet_directory_uri() );

require_once GTT_THEME_DIR . '/inc/theme-setup.php';
require_once GTT_THEME_DIR . '/inc/enqueue.php';
require_once GTT_THEME_DIR . '/inc/security.php';
