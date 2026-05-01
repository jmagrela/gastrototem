<?php
/**
 * Gastrototem Child Theme.
 *
 * Punto de entrada. Verifica el tema padre, define constantes
 * y carga los módulos de inc/.
 *
 * @package Gastrototem
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GASTROTOTEM_VERSION', '0.1.0' );
define( 'GASTROTOTEM_DIR', get_stylesheet_directory() );
define( 'GASTROTOTEM_URI', get_stylesheet_directory_uri() );

/**
 * Comprueba que Astra está presente como tema padre.
 */
function gastrototem_parent_is_active() {
	$template = wp_get_theme()->get_template();
	return 'astra' === $template
		&& file_exists( get_template_directory() . '/style.css' );
}

/**
 * Aviso en admin si Astra no está disponible.
 */
function gastrototem_parent_missing_notice() {
	echo '<div class="notice notice-error"><p>';
	echo esc_html__(
		'El tema Gastrototem requiere Astra como tema padre. Instala y activa Astra antes de usar este child.',
		'gastrototem'
	);
	echo '</p></div>';
}

if ( gastrototem_parent_is_active() ) {
	require_once GASTROTOTEM_DIR . '/inc/theme-setup.php';
	require_once GASTROTOTEM_DIR . '/inc/enqueue.php';
	require_once GASTROTOTEM_DIR . '/inc/security.php';
} else {
	add_action( 'admin_notices', 'gastrototem_parent_missing_notice' );
}
