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
	let cachedBodyOverflow = '';
	let cachedBodyPaddingRight = '';

	/**
	 * Construye explícitamente la lista de focusables del overlay.
	 * Orden: toggle (X) → links del overlay en orden DOM → loop al toggle.
	 */
	function getFocusables() {
		return [toggle, ...overlay.querySelectorAll('a')];
	}

	/**
	 * Aplica body scroll lock con compensación del scrollbar para evitar
	 * salto lateral del contenido al ocultar el scroll.
	 */
	function lockBodyScroll() {
		const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
		cachedBodyOverflow = document.body.style.overflow;
		cachedBodyPaddingRight = document.body.style.paddingRight;
		document.body.style.overflow = 'hidden';
		if (scrollbarWidth > 0) {
			document.body.style.paddingRight = scrollbarWidth + 'px';
		}
	}

	function unlockBodyScroll() {
		document.body.style.overflow = cachedBodyOverflow;
		document.body.style.paddingRight = cachedBodyPaddingRight;
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
