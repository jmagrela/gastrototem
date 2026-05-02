<?php
/**
 * Brand SVG inline helpers.
 *
 * @package gastrototem-theme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'gtt_theme_inline_brand_svg' ) ) {
	/**
	 * Returns the contents of a brand SVG file from /assets/brand/, ready to inline.
	 *
	 * Reads the file once per request and caches the raw contents in a static map
	 * keyed by filename. Subsequent calls with the same filename do not re-read disk.
	 * The aria-hidden attribute is applied per-call (after cache lookup), so the same
	 * SVG can be served with and without aria-hidden in different call sites of the
	 * same request without invalidating the cache.
	 *
	 * Fails silently: if the file does not exist or is not readable, returns an empty
	 * string. No notice, no warning, no error — same behavior as the inline logic
	 * being replaced from header and footer templates (C1 / C2).
	 *
	 * No SVG sanitization is performed. The /assets/brand/ directory contains
	 * brand-controlled assets, not user input. If untrusted SVG sources are ever
	 * introduced, the caller is responsible for sanitization (e.g., wp_kses with
	 * an SVG-aware allowlist).
	 *
	 * @param string $filename    Exact filename within /assets/brand/, including extension.
	 *                            Example: 'lockup-horizontal-gastrototem.svg'.
	 * @param bool   $aria_hidden Whether to inject aria-hidden="true" on the <svg> root.
	 *                            Default true (the typical case: SVG inside a labeled
	 *                            anchor or button, where the parent already provides
	 *                            the accessible name).
	 *
	 * @return string The SVG markup ready to inline, or '' on failure.
	 */
	function gtt_theme_inline_brand_svg( string $filename, bool $aria_hidden = true ): string {
		static $cache = array();

		// Caché por filename, no por path — la clave es estable y compacta.
		if ( ! isset( $cache[ $filename ] ) ) {
			$path                  = get_stylesheet_directory() . '/assets/brand/' . $filename;
			$cache[ $filename ] = is_readable( $path ) ? (string) file_get_contents( $path ) : '';
		}

		$svg = $cache[ $filename ];

		if ( '' === $svg ) {
			return '';
		}

		// El aria-hidden se aplica en cada llamada sobre el contenido cacheado, lo
		// que permite servir el mismo SVG con o sin aria-hidden en distintos call
		// sites de la misma request sin re-leer disco.
		if ( $aria_hidden ) {
			$svg = str_replace( '<svg', '<svg aria-hidden="true"', $svg );
		}

		return $svg;
	}
}
