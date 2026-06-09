/*
 * Gastrototem · Component · Header
 *
 * Toggle del overlay del menú principal: abrir/cerrar, body scroll lock
 * con compensación de scrollbar, focus trap, cierre por Escape, cierre
 * por click en links del overlay.
 *
 * Vanilla JS, sin frameworks, sin polyfills. Target: navegadores modernos.
 */

(function () {
	'use strict';

	const header = document.querySelector('.gtt-header');
	if (!header) return;

	const toggle = header.querySelector('.gtt-header__toggle');
	const overlay = header.querySelector('.gtt-menu-overlay');
	if (!toggle || !overlay) return;

	let isOpen = false;
	let cachedScrollY = 0;
	let cachedBodyPosition = '';
	let cachedBodyTop = '';
	let cachedBodyLeft = '';
	let cachedBodyRight = '';
	let cachedBodyPaddingRight = '';

	/**
	 * Construye explícitamente la lista de focusables del overlay.
	 * Orden: toggle (X) → links del overlay en orden DOM → loop al toggle.
	 */
	function getFocusables() {
		return [toggle, ...overlay.querySelectorAll('a')];
	}

	/**
	 * Body scroll lock robusto:
	 *
	 * El approach simple (overflow:hidden) pierde scrollY al cerrar en
	 * Chromium. La técnica robusta fija el body con position:fixed +
	 * top:-scrollY, lo que mantiene el contenido visualmente en su sitio
	 * sin permitir scroll. Al cerrar, restauramos los estilos cacheados y
	 * hacemos un window.scrollTo para volver exactamente donde estábamos.
	 *
	 * Funciona en Chromium, Safari y Firefox.
	 */
	function lockBodyScroll() {
		cachedScrollY = window.scrollY;
		const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

		cachedBodyPosition = document.body.style.position;
		cachedBodyTop = document.body.style.top;
		cachedBodyLeft = document.body.style.left;
		cachedBodyRight = document.body.style.right;
		cachedBodyPaddingRight = document.body.style.paddingRight;

		document.body.style.position = 'fixed';
		document.body.style.top = -cachedScrollY + 'px';
		document.body.style.left = '0';
		document.body.style.right = '0';
		if (scrollbarWidth > 0) {
			document.body.style.paddingRight = scrollbarWidth + 'px';
		}
	}

	function unlockBodyScroll() {
		const targetScrollY = cachedScrollY;
		document.body.style.position = cachedBodyPosition;
		document.body.style.top = cachedBodyTop;
		document.body.style.left = cachedBodyLeft;
		document.body.style.right = cachedBodyRight;
		document.body.style.paddingRight = cachedBodyPaddingRight;

		/* Tras quitar position:fixed del body, el motor no ha reflowed aún:
		 * documentElement.scrollHeight sigue cacheado al tamaño del viewport
		 * (porque el body fixed no contribuía al flow). Si llamamos scrollTo
		 * síncronamente, se cappea contra ese scrollHeight viejo y termina
		 * en 0. La solución robusta cross-browser es esperar dos rAF: el
		 * primero deja que el motor agende el reflow, el segundo dispara
		 * tras el siguiente paint con scrollHeight ya correcto. */
		requestAnimationFrame( function () {
			requestAnimationFrame( function () {
				window.scrollTo( 0, targetScrollY );
			} );
		} );
	}

	/**
	 * Focus trap: ciclar Tab / Shift+Tab dentro de la lista de focusables.
	 * Solo prevenimos default en los bordes para no interferir con el cycle
	 * natural del navegador en el medio.
	 */
	function handleFocusTrap(event) {
		if (event.key !== 'Tab') return;

		const focusables = getFocusables();
		if (focusables.length === 0) return;

		const first = focusables[0];
		const last = focusables[focusables.length - 1];
		const active = document.activeElement;

		if (event.shiftKey) {
			if (active === first) {
				event.preventDefault();
				last.focus();
			}
		} else {
			if (active === last) {
				event.preventDefault();
				first.focus();
			}
		}
	}

	function handleEscape(event) {
		if (event.key === 'Escape' && isOpen) {
			close();
		}
	}

	function open() {
		if (isOpen) return;
		isOpen = true;

		toggle.classList.add('is-open');
		overlay.classList.add('is-open');
		header.classList.add('is-menu-open');
		toggle.setAttribute('aria-expanded', 'true');
		toggle.setAttribute('aria-label', 'Cerrar menú');
		overlay.setAttribute('aria-hidden', 'false');

		lockBodyScroll();

		overlay.addEventListener('keydown', handleFocusTrap);
		document.addEventListener('keydown', handleEscape);
	}

	function close() {
		if (!isOpen) return;
		isOpen = false;

		toggle.classList.remove('is-open');
		overlay.classList.remove('is-open');
		header.classList.remove('is-menu-open');
		toggle.setAttribute('aria-expanded', 'false');
		toggle.setAttribute('aria-label', 'Abrir menú');
		overlay.setAttribute('aria-hidden', 'true');

		unlockBodyScroll();

		overlay.removeEventListener('keydown', handleFocusTrap);
		document.removeEventListener('keydown', handleEscape);

		toggle.focus();
	}

	/* -----------------------------------------------------------------
	 * Listeners permanentes
	 * -------------------------------------------------------------- */

	toggle.addEventListener('click', function () {
		if (isOpen) {
			close();
		} else {
			open();
		}
	});

	/* Cierre por click en cualquier <a> del overlay (event delegation).
	 * El <a> navega normalmente; cerrar antes para que la transición sea
	 * limpia si la navegación es interna. */
	overlay.addEventListener('click', function (event) {
		const link = event.target.closest('a');
		if (link && overlay.contains(link)) {
			close();
		}
	});
})();

/*
 * Gastrototem · Component · Header · Aparición tras el splash
 *
 * Bloque autocontenido, independiente del controlador del overlay de arriba.
 * En la home, si el header arranca con .is-intro (lo añadió el script inline
 * síncrono de header.php cuando no hay flag de sesión ni reduced-motion), lo
 * revelamos tras el fade del splash con el dance de dos clases que la CSS
 * espera: .is-revealing (transform 400ms) → quitar .is-intro (baja) → limpiar.
 *
 * Idempotente con el failsafe inline de header.php: si .is-intro ya no está
 * (failsafe o nunca añadida), no hace nada.
 */
(function () {
	'use strict';

	/* Delay de la bajada: justo tras el fade del splash (~1900ms). */
	const INTRO_REVEAL_DELAY = 2100;

	/* Margen para limpiar .is-revealing si no llegara transitionend
	 * (transición de 400ms; 600 da holgura). */
	const INTRO_CLEANUP_FALLBACK = 600;

	const header = document.querySelector('.gtt-header');
	if (!header || !header.classList.contains('is-intro')) {
		return;
	}

	setTimeout(function () {
		/* El failsafe inline pudo revelarlo ya: no dupliques. */
		if (!header.classList.contains('is-intro')) {
			return;
		}

		header.classList.add('is-revealing');   // transform a 400ms durante la bajada
		header.classList.remove('is-intro');     // dispara translateY(0)

		const cleanup = function () {
			header.classList.remove('is-revealing');
			header.removeEventListener('transitionend', onEnd);
		};
		const onEnd = function (event) {
			if (event.target === header && event.propertyName === 'transform') {
				cleanup();
			}
		};

		header.addEventListener('transitionend', onEnd);
		setTimeout(cleanup, INTRO_CLEANUP_FALLBACK);
	}, INTRO_REVEAL_DELAY);
})();

/*
 * Gastrototem · Component · Header · Conmutación de piel (cerebro)
 *
 * IntersectionObserver sobre [data-gtt-sentinel] (borde inferior de la banda de
 * apertura): mientras el sentinel no ha cruzado el borde inferior del header, la
 * piel es transparente; al cruzarlo, sólida. Lee el contexto de data-gtt-context;
 * 404 se exime (su campo tinta es un bloque posterior). Sin banda → sólida.
 * No hay token de altura del header: se lee header.offsetHeight y el observer se
 * recrea en resize (debounce 150ms) para mantener el rootMargin correcto.
 */
( function () {
	if ( typeof IntersectionObserver === 'undefined' ) { return; }
	var header = document.querySelector( '.gtt-header' );
	if ( ! header ) { return; }
	var ctx = header.getAttribute( 'data-gtt-context' );
	if ( ctx === '404' ) { return; } // futuro: forzar transparente sobre campo tinta
	var sentinel = document.querySelector( '[data-gtt-sentinel]' );
	if ( ! sentinel ) {
		header.classList.remove( 'is-transparent', 'is-hidden' ); // sin banda → sólida y visible (defensivo)
		return;
	}
	var observer = null;
	function update() {
		var h = header.offsetHeight;
		var top = sentinel.getBoundingClientRect().top;
		var past = top <= h; // el borde inferior de la banda alcanzó el del header
		header.classList.toggle( 'is-transparent', ! past );
		// Auto-ocultación: sobre la banda (transparente) el header solo se ve
		// en el top; al bajar se oculta. Sobre el contenido (sólido) siempre
		// visible. El umbral es el sentinel, no una altura fija.
		header.classList.toggle( 'is-hidden', ! past && window.scrollY > 0 );
	}
	function setup() {
		if ( observer ) { observer.disconnect(); }
		var h = header.offsetHeight;
		observer = new IntersectionObserver( function () { update(); }, {
			rootMargin: '-' + h + 'px 0px 0px 0px',
			threshold: 0
		} );
		observer.observe( sentinel );
		update();
	}
	setup();
	var resizeTimer;
	window.addEventListener( 'resize', function () {
		clearTimeout( resizeTimer );
		resizeTimer = setTimeout( setup, 150 );
	} );
	// El IntersectionObserver solo dispara al cruzar el sentinel; la
	// auto-ocultación depende de la posición de scroll dentro de la banda,
	// así que recalculamos también en scroll (throttled con rAF).
	var ticking = false;
	window.addEventListener( 'scroll', function () {
		if ( ticking ) { return; }
		ticking = true;
		requestAnimationFrame( function () { update(); ticking = false; } );
	}, { passive: true } );
}() );
