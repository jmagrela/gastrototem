<?php
/**
 * Gastrototem · Theme Setup
 *
 * Theme supports, image sizes y carga del text domain.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configura los soportes de tema.
 */
function gtt_theme_setup() {
	load_child_theme_textdomain( 'gastrototem', GTT_THEME_DIR . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );

	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);
}
add_action( 'after_setup_theme', 'gtt_theme_setup' );
