/*
 * Gastrototem · Component · Home Hero · Movimiento por scroll
 *
 * Pieza 2 del hero: liga el scroll a dos transforms compuestos (GPU) y una
 * opacidad. Fiel a HeroCinematic.tsx del prototipo (referencia, no porte):
 *   - foto: scale(1 → 1.18) lineal con el progreso.
 *   - texto: opacidad 1 → 0.4 siguiendo easeOut cúbico + translateY sutil
 *            (parallax; el archivo de referencia no lleva translateY, así que la
 *            magnitud es propia, de partida para field-test).
 *
 * AISLAMIENTO (guarda dura): este bloque NO toca header.js, ni el observer del
 * header, ni el splash. Tiene su PROPIO listener de scroll rAF-throttled.
 *
 * Rendimiento: lee window.scrollY una sola vez por frame dentro de apply(), que
 * solo corre vía requestAnimationFrame; escribe únicamente transform/opacity
 * (sin reflow por frame). La altura del hero se cachea y se recalcula en resize
 * (debounce 150ms, como header.js).
 *
 * prefers-reduced-motion: sin zoom, sin parallax, texto opaco — no se instala
 * ningún listener y no se escribe estilo inline; el hero queda como la Pieza 1
 * (el grano es CSS estático y se mantiene).
 */
( function () {
	'use strict';

	var hero = document.querySelector( '.gtt-hero' );
	if ( ! hero ) { return; }

	var foto = hero.querySelector( '.gtt-hero__foto' );
	var contenido = hero.querySelector( '.gtt-hero__contenido' );
	if ( ! foto || ! contenido ) { return; }

	/* prefers-reduced-motion: dejar el hero estático (Pieza 1 + grano). */
	if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	var SCALE_GAIN = 0.18;     /* foto: scale 1 → 1.18 (referencia) */
	var FADE_DEPTH = 0.6;      /* texto: opacidad 1 → 0.4 (1 - 0.6, referencia) */
	var PARALLAX_PX = 24;      /* texto: translateY hasta -24px (sutil, propio) */

	var heroH = hero.offsetHeight || window.innerHeight || 1;
	var ticking = false;

	function apply() {
		ticking = false;
		var progress = window.scrollY / heroH;   /* única lectura de scroll por frame */
		if ( progress < 0 ) { progress = 0; } else if ( progress > 1 ) { progress = 1; }

		var ease = 1 - Math.pow( 1 - progress, 3 );   /* easeOut cúbico */

		foto.style.transform = 'scale(' + ( 1 + SCALE_GAIN * progress ) + ')';
		contenido.style.opacity = String( 1 - FADE_DEPTH * ease );
		contenido.style.transform = 'translateY(' + ( -PARALLAX_PX * progress ) + 'px)';
	}

	function onScroll() {
		if ( ticking ) { return; }
		ticking = true;
		requestAnimationFrame( apply );
	}

	apply();   /* estado inicial coherente (por si la página carga ya scrolleada) */
	window.addEventListener( 'scroll', onScroll, { passive: true } );

	var resizeTimer;
	window.addEventListener( 'resize', function () {
		clearTimeout( resizeTimer );
		resizeTimer = setTimeout( function () {
			heroH = hero.offsetHeight || window.innerHeight || 1;
			apply();
		}, 150 );
	} );
}() );
