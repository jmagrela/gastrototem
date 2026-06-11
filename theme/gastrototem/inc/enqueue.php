<?php
/**
 * Gastrototem · Enqueue
 *
 * Carga de assets, en orden:
 * 1. style.css (cabecera del theme)
 * 2. tokens.css (depende de style)
 * 3. base.css (depende de tokens)
 * 4. Google Fonts (Inter + Source Serif 4 + JetBrains Mono) con preconnect
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
 * Sintaxis ital,opsz,wght@1,8..60,400 para Source Serif 4 italic 400.
 */
function gtt_theme_google_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Serif+4:ital,opsz,wght@1,8..60,400&family=JetBrains+Mono:wght@400;500&display=swap';
}

/**
 * Enqueue de estilos: style + tokens + base.
 */
function gtt_theme_enqueue_styles() {
	wp_enqueue_style(
		'gastrototem-style',
		get_stylesheet_uri(),
		array(),
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

	/* Componentes del theme. Cada componente declara aquí su CSS y, si lo
	 * requiere, su JS. Todos los componentes dependen de gastrototem-base. */

	wp_enqueue_style(
		'gastrototem-header',
		GTT_THEME_URI . '/assets/css/components/header.css',
		array( 'gastrototem-base' ),
		gtt_theme_asset_version( '/assets/css/components/header.css' )
	);

	wp_enqueue_script(
		'gastrototem-header',
		GTT_THEME_URI . '/assets/js/components/header.js',
		array(),
		gtt_theme_asset_version( '/assets/js/components/header.js' ),
		true
	);

	wp_enqueue_style(
		'gastrototem-footer',
		GTT_THEME_URI . '/assets/css/components/footer.css',
		array( 'gastrototem-base' ),
		gtt_theme_asset_version( '/assets/css/components/footer.css' )
	);

	/* Documento: en páginas con la plantilla "Documento" Y en las interiores
	 * propias (page-{slug}.php), que reutilizan la banda de apertura .gtt-doc-band
	 * y su sentinel. El sentinel lo lee el observer del header (header.js). */
	if ( is_page_template( 'template-documento.php' ) || gtt_is_interior_page() ) {
		wp_enqueue_style(
			'gastrototem-documento',
			GTT_THEME_URI . '/assets/css/components/documento.css',
			array( 'gastrototem-base' ),
			gtt_theme_asset_version( '/assets/css/components/documento.css' )
		);
	}

	/* Primitivos editoriales (kicker, pasos, zonas, pull-quote): solo en las
	 * interiores propias, que los consumen vía partials. La home NO los carga:
	 * mantiene sus propias copias inline en pages/home.css (sin tocar). La
	 * unificación de ambas queda aparcada (ver components/primitivos.css). */
	if ( gtt_is_interior_page() ) {
		wp_enqueue_style(
			'gastrototem-primitivos',
			GTT_THEME_URI . '/assets/css/components/primitivos.css',
			array( 'gastrototem-base' ),
			gtt_theme_asset_version( '/assets/css/components/primitivos.css' )
		);
	}

	/* Páginas interiores: shell del cuerpo + secciones bespoke. Depende de los
	 * primitivos (orden de carga). Solo en las interiores propias. */
	if ( gtt_is_interior_page() ) {
		wp_enqueue_style(
			'gastrototem-paginas',
			GTT_THEME_URI . '/assets/css/pages/paginas.css',
			array( 'gastrototem-base', 'gastrototem-primitivos' ),
			gtt_theme_asset_version( '/assets/css/pages/paginas.css' )
		);
	}

	/* Home: hero de portada. Solo en la portada (front-page.php). El overlap
	 * hero↔contenido es CSS puro y el sentinel es arnés del observer del header.
	 * hero.js añade la capa de movimiento (zoom + desvanecido + parallax) con su
	 * propio listener de scroll; no toca header.js ni el observer. */
	if ( is_front_page() ) {
		wp_enqueue_style(
			'gastrototem-home',
			GTT_THEME_URI . '/assets/css/pages/home.css',
			array( 'gastrototem-base' ),
			gtt_theme_asset_version( '/assets/css/pages/home.css' )
		);

		wp_enqueue_script(
			'gastrototem-hero',
			GTT_THEME_URI . '/assets/js/components/hero.js',
			array(),
			gtt_theme_asset_version( '/assets/js/components/hero.js' ),
			true
		);
	}

	/* Splash: solo en la home. El overlay nace oculto por CSS y la decisión
	 * de mostrarlo (no-flash) es síncrona en template-parts/splash.php; este
	 * JS solo hace la coreografía temporizada. */
	if ( is_front_page() ) {
		wp_enqueue_style(
			'gastrototem-splash',
			GTT_THEME_URI . '/assets/css/components/splash.css',
			array( 'gastrototem-base' ),
			gtt_theme_asset_version( '/assets/css/components/splash.css' )
		);

		wp_enqueue_script(
			'gastrototem-splash',
			GTT_THEME_URI . '/assets/js/components/splash.js',
			array(),
			gtt_theme_asset_version( '/assets/js/components/splash.js' ),
			true
		);
	}

	/* Error 404: campo tinta a pantalla completa. Solo en is_404(). El header
	 * arranca forzado-transparente vía el contexto '404' (header.php/header.js);
	 * aquí solo se encola la hoja del campo. */
	if ( is_404() ) {
		wp_enqueue_style(
			'gastrototem-error-404',
			GTT_THEME_URI . '/assets/css/pages/error-404.css',
			array( 'gastrototem-base' ),
			gtt_theme_asset_version( '/assets/css/pages/error-404.css' )
		);
	}
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
