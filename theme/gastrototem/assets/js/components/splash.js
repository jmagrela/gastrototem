/*
 * Gastrototem · Component · Splash
 *
 * Coreografía temporizada del overlay de entrada (solo home). La decisión de
 * mostrarlo (no-flash) ya la tomó SÍNCRONAMENTE el script inline de splash.php:
 * si el overlay no tiene .is-active, este script no hace nada (visitante
 * recurrente o sin sesión disponible).
 *
 * Tiempos: quieto --splash-hold, fade --splash-fade (CSS), luego fija el flag
 * de sesión, restaura el scroll y retira el overlay. Los tiempos se leen de las
 * custom properties de splash.css (fuente única), de modo que reduced-motion
 * —que las reescribe a 600ms / 0— se respeta sin lógica extra aquí.
 *
 * Vanilla JS, sin frameworks. Encolado en el footer, solo en la home.
 */

( function () {
	'use strict';

	var splash = document.querySelector( '[data-gtt-splash]' );
	if ( ! splash ) {
		return;
	}

	/* Visitante recurrente (o sin sessionStorage): el inline no añadió
	 * .is-active. No mostrar ni tocar nada. */
	if ( ! splash.classList.contains( 'is-active' ) ) {
		return;
	}

	var styles = window.getComputedStyle( splash );
	var hold = parseFloat( styles.getPropertyValue( '--splash-hold' ) );
	var fade = parseFloat( styles.getPropertyValue( '--splash-fade' ) );
	if ( isNaN( hold ) ) {
		hold = 1200;
	}
	if ( isNaN( fade ) ) {
		fade = 700;
	}

	function finish() {
		try {
			window.sessionStorage.setItem( 'gtt_splash_shown', '1' );
		} catch ( e ) {}
		document.documentElement.classList.remove( 'gtt-splash-lock' );
		if ( splash.parentNode ) {
			splash.parentNode.removeChild( splash );
		}
	}

	/* Tras el reposo, dispara el fade (CSS reacciona a .is-leaving). */
	setTimeout( function () {
		splash.classList.add( 'is-leaving' );
	}, hold );

	/* Al completarse el fade: fija flag, libera scroll, retira el overlay.
	 * Con reduced-motion fade=0, así que esto ocurre a los 600ms, instantáneo. */
	setTimeout( finish, hold + fade );
}() );
