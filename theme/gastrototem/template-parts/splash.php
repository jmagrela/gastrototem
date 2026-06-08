<?php
/**
 * Template part: splash
 *
 * Overlay de entrada del sitio. Se monta SOLO en la home y se muestra una
 * vez por sesión; luego se desvanece (la coreografía temporizada vive en
 * assets/js/components/splash.js).
 *
 * NO-FLASH (crítico): la decisión de mostrar/ocultar es SÍNCRONA, antes del
 * primer pintado. El overlay nace OCULTO por CSS (.gtt-splash sin .is-active)
 * y el micro-script inline de abajo solo lo revela —y bloquea el scroll— si
 * el flag de sesión NO existe. Quien ya lo vio no ve ni un parpadeo. Un script
 * encolado (footer) correría tras el primer pintado y provocaría flash, por eso
 * esta decisión va inline aquí y no en splash.js.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="gtt-splash" data-gtt-splash aria-hidden="true">
	<div class="gtt-splash__lockup">
		<?php echo gtt_theme_inline_brand_svg( 'lockup-vertical-gastrototem.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de marca controlado, sin input externo. ?>
	</div>
</div>
<script>
/* No-flash: estado inicial síncrono. El overlay nace oculto (CSS); se revela
 * y se bloquea el scroll solo si NO hay flag de sesión. Si sessionStorage no
 * está disponible (p. ej. modo privado), se sale sin mostrar: por defecto
 * oculto, nunca atascado. La animación la maneja splash.js. */
( function () {
	try {
		if ( window.sessionStorage.getItem( 'gtt_splash_shown' ) ) {
			return;
		}
	} catch ( e ) {
		return;
	}
	var splash = document.querySelector( '[data-gtt-splash]' );
	if ( splash ) {
		splash.classList.add( 'is-active' );
		document.documentElement.classList.add( 'gtt-splash-lock' );

		/* Failsafe anti-atasco: si splash.js (footer) no llegara a ejecutarse
		 * tras haberse activado el splash, este timeout generoso fuerza la
		 * retirada para no dejar el overlay ni el scroll bloqueados.
		 * Idempotente: si splash.js ya lo retiró (overlay fuera del DOM), no
		 * hace nada. Solo se arma cuando el splash se activó. */
		setTimeout( function () {
			if ( ! splash.parentNode ) {
				return;
			}
			splash.classList.remove( 'is-active' );
			document.documentElement.classList.remove( 'gtt-splash-lock' );
			splash.parentNode.removeChild( splash );
		}, 4000 );
	}
}() );
</script>
