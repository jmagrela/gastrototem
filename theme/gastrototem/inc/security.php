<?php
/**
 * Gastrototem · Security & Hardening
 *
 * Hardening básico:
 * — Oculta la versión de WP del <head>
 * — Deshabilita XML-RPC
 * — Cierra enumeración de usuarios vía REST sin auth
 * — Quita los scripts/estilos de emoji
 * — Limita revisiones de posts a 5
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Quitar la versión de WP del <head>.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Deshabilitar XML-RPC.
 *
 * Tres capas:
 * 1. `xmlrpc_enabled` => false bloquea métodos autenticados.
 * 2. `xmlrpc_methods` => [] vacía el registro de métodos WP.
 * 3. Guard en `init` envía 403 si se accede a /xmlrpc.php directamente,
 *    cerrando también los endpoints informativos de IXR (system.*).
 *
 * Si en el futuro algún plugin (p.ej. Jetpack) necesita XML-RPC, hay
 * que retirar el guard del paso 3.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );
add_action(
	'init',
	function () {
		if ( ! empty( $_SERVER['SCRIPT_FILENAME'] )
			&& basename( $_SERVER['SCRIPT_FILENAME'] ) === 'xmlrpc.php' ) {
			http_response_code( 403 );
			header( 'Content-Type: text/plain; charset=utf-8' );
			exit( "XML-RPC disabled.\n" );
		}
	},
	0
);

/**
 * Cerrar enumeración de usuarios vía REST cuando no hay auth.
 */
function gastrototem_restrict_users_endpoint( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
	}
	return $endpoints;
}
add_filter( 'rest_endpoints', 'gastrototem_restrict_users_endpoint' );

/**
 * Quitar emoji scripts y estilos de WP.
 */
function gastrototem_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter(
		'tiny_mce_plugins',
		function ( $plugins ) {
			return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
		}
	);

	add_filter(
		'wp_resource_hints',
		function ( $urls, $relation_type ) {
			if ( 'dns-prefetch' === $relation_type ) {
				$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/' );
				$urls          = array_diff( $urls, array( $emoji_svg_url ) );
			}
			return $urls;
		},
		10,
		2
	);
}
add_action( 'init', 'gastrototem_disable_emojis' );

/**
 * Limitar revisiones de post a 5.
 */
add_filter(
	'wp_revisions_to_keep',
	function ( $num, $post ) {
		return 5;
	},
	10,
	2
);
