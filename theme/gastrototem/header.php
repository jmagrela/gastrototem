<?php
/**
 * Cabecera del documento.
 *
 * @package Gastrototem
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( is_front_page() ) { get_template_part( 'template-parts/splash' ); } ?>

<?php get_template_part( 'template-parts/header-main' ); ?>

<?php if ( is_front_page() ) : ?>
<script>
/* Intro del header: decisión SÍNCRONA antes del primer pintado (espejo del
 * splash). Solo en la home. Si NO hay flag de sesión y NO se pide menos
 * movimiento, el header arranca oculto (.is-intro) y header.js lo baja tras
 * el fade del splash. try/catch: sin sessionStorage (modo privado) → sin intro,
 * header visible; nunca atascado oculto. */
( function () {
	try {
		if ( window.sessionStorage.getItem( 'gtt_splash_shown' ) ) {
			return;
		}
	} catch ( e ) {
		return;
	}
	if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}
	var header = document.querySelector( '.gtt-header' );
	if ( header ) {
		header.classList.add( 'is-intro' );

		/* Failsafe: si header.js no revelara el header, este timeout generoso
		 * quita .is-intro para no dejarlo fuera de pantalla. Idempotente: si
		 * header.js ya lo quitó, no hace nada. */
		setTimeout( function () {
			header.classList.remove( 'is-intro' );
		}, 4000 );
	}
}() );
</script>
<?php endif; ?>

<main id="gtt-content" class="gtt-template-site-main" role="main">
