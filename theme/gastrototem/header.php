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

<script>
/* Piel inicial síncrona antes del primer pintado, según contexto.
   Fallback sin JS = piel sólida (base). Arrancan transparentes los contextos
   que abren sobre un campo oscuro a sangre: 'document' (banda tinta), 'home'
   (hero sobre foto) y '404' (campo tinta a pantalla completa). Mata el flash
   sólido→transparente. En 'document'/'home' el observer de header.js toma el
   relevo al hacer scroll; en '404' el observer se exime, así que la piel queda
   forzada-transparente (sin auto-hide ni toggle a sólido). */
( function () {
	var header = document.querySelector( '.gtt-header' );
	if ( ! header ) { return; }
	var ctx = header.getAttribute( 'data-gtt-context' );
	if ( ctx === 'document' || ctx === 'home' || ctx === '404' ) {
		header.classList.add( 'is-transparent' );
	}
}() );
</script>

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
