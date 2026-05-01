<?php
/**
 * Gastrototem · Enqueue
 *
 * Carga de assets, en orden:
 * 1. Astra parent style.css
 * 2. Child style.css (cabecera)
 * 3. tokens.css (depende de child style)
 * 4. base.css (depende de tokens)
 * 5. Google Fonts (Inter + Instrument Serif + JetBrains Mono) con preconnect
 *
 * Versionado por filemtime() para cache-busting en desarrollo.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Versión basada en mtime del archivo (cache-busting en dev).
 */
function gtt_theme_asset_version( $relative_path ) {
	$absolute = GTT_THEME_DIR . $relative_path;
	return file_exists( $absolute ) ? (string) filemtime( $absolute ) : GTT_THEME_VERSION;
}

/**
 * URL única de Google Fonts con las tres familias.
 *
 * Sintaxis ital,wght@1,400 para Instrument Serif italic 400.
 */
function gtt_theme_google_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Instrument+Serif:ital,wght@1,400&family=JetBrains+Mono:wght@400;500&display=swap';
}

/**
 * Enqueue de estilos parent + child + tokens + base.
 */
function gtt_theme_enqueue_styles() {
	wp_enqueue_style(
		'astra-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'astra' )->get( 'Version' )
	);

	wp_enqueue_style(
		'gastrototem-style',
		get_stylesheet_uri(),
		array( 'astra-parent-style' ),
		gtt_theme_asset_version( '/style.css' )
	);

	wp_enqueue_style(
		'gastrototem-tokens',
		GTT_THEME_URI . '/assets/css/tokens.css',
		array( 'gastrototem-style' ),
		gtt_theme_asset_version( '/assets/css/tokens.css' )
	);

	wp_enqueue_style(
		'gastrototem-base',
		GTT_THEME_URI . '/assets/css/base.css',
		array( 'gastrototem-tokens' ),
		gtt_theme_asset_version( '/assets/css/base.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'gtt_theme_enqueue_styles' );

/**
 * Enqueue de Google Fonts.
 */
function gtt_theme_enqueue_fonts() {
	wp_enqueue_style(
		'gastrototem-google-fonts',
		gtt_theme_google_fonts_url(),
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'gtt_theme_enqueue_fonts' );

/**
 * Resource hints: preconnect a Google Fonts.
 */
function gtt_theme_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'gtt_theme_resource_hints', 10, 2 );

/**
 * Estilos para el editor de Gutenberg.
 *
 * Importante: se registra en after_setup_theme con prioridad mayor que
 * gtt_theme_setup() para que add_theme_support('editor-styles') ya
 * haya corrido.
 */
function gtt_theme_enqueue_editor_styles() {
	add_editor_style( 'assets/css/editor.css' );
	add_editor_style( gtt_theme_google_fonts_url() );
}
add_action( 'after_setup_theme', 'gtt_theme_enqueue_editor_styles', 11 );
