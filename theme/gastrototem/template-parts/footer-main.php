<?php
/**
 * Template part: footer-main
 *
 * Footer global sobre TINTA: CTA de reserva (piso 1) + 4 columnas (piso 2:
 * Navegación / Contacto / Zonas de afinación / Legal) + firma con logo invertido
 * (piso 3) + cierre (piso 4). Presentacional, sin JS. El logo se recolorea a la
 * variante invertida (papel sobre tinta) por CSS; no se edita el SVG canónico.
 *
 * Navegación: mismos labels y slugs que el menú del header (header-main.php).
 * Contacto: solo email (sin teléfono, MARCA). Cierre: inamovible
 * «GASTROTOTEM · ANDALUCÍA» (MARCA §2), nunca «España».
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Items (hardcodeados, no wp_nav_menu — misma justificación que el header).
 * Navegación = espejo de header-main.php (labels + slugs).
 * ---------------------------------------------------------------------- */

$items_nav = array(
	array( 'label' => 'Afinación',      'url' => '/afinacion' ),
	array( 'label' => 'Criterio',       'url' => '/criterio' ),
	array( 'label' => 'Sobre nosotros', 'url' => '/nosotros' ),
	array( 'label' => 'Contacto',       'url' => '/contacto' ),
	array( 'label' => 'Mi cuenta',      'url' => '/mi-cuenta' ),
);

$items_legal = array(
	array( 'label' => 'Aviso legal', 'url' => '/aviso-legal' ),
	array( 'label' => 'Privacidad',  'url' => '/privacidad' ),
	array( 'label' => 'Cookies',     'url' => '/cookies' ),
);

$zonas_abiertas = array( 'Granada', 'Málaga', 'Sevilla' );

/* Comparación de ruta actual para aria-current. */
$current_path = '';
if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
	$current_path = untrailingslashit(
		(string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
	);
}

?>
<footer class="gtt-footer" role="contentinfo">
	<div class="gtt-footer__inner">

		<div class="gtt-footer__tier-cta">
			<p class="gtt-footer__kicker gtt-footer__kicker--cta">Reservar una sesión</p>
			<a class="gtt-footer__cta-link" href="<?php echo esc_url( '/reservar' ); ?>">Verificar zonas y fechas <span class="gtt-footer__cta-arrow" aria-hidden="true">→</span></a>
		</div>

		<hr class="gtt-footer__rule" aria-hidden="true">

		<div class="gtt-footer__tier-cols">

			<nav class="gtt-footer__col" aria-label="Navegación del pie">
				<h2 class="gtt-footer__kicker">Navegación</h2>
				<ul class="gtt-footer__list" role="list">
					<?php foreach ( $items_nav as $item ) : ?>
						<?php $is_current = ( '' !== $current_path && $current_path === untrailingslashit( $item['url'] ) ); ?>
						<li class="gtt-footer__list-item">
							<a class="gtt-footer__link" href="<?php echo esc_url( $item['url'] ); ?>" <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<div class="gtt-footer__col">
				<h2 class="gtt-footer__kicker">Contacto</h2>
				<ul class="gtt-footer__list" role="list">
					<li class="gtt-footer__list-item">
						<a class="gtt-footer__link" href="mailto:info@gastrototem.com" aria-label="Enviar email a info@gastrototem.com">info@gastrototem.com</a>
					</li>
				</ul>
			</div>

			<div class="gtt-footer__col">
				<h2 class="gtt-footer__kicker">Zonas de afinación</h2>
				<ul class="gtt-footer__list" role="list">
					<?php foreach ( $zonas_abiertas as $zona ) : ?>
						<li class="gtt-footer__list-item gtt-footer__zona"><?php echo esc_html( $zona ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p class="gtt-footer__zonas-nota">Próximamente más zonas</p>
			</div>

			<nav class="gtt-footer__col" aria-label="Enlaces legales">
				<h2 class="gtt-footer__kicker">Legal</h2>
				<ul class="gtt-footer__list" role="list">
					<?php foreach ( $items_legal as $item ) : ?>
						<?php $is_current = ( '' !== $current_path && $current_path === untrailingslashit( $item['url'] ) ); ?>
						<li class="gtt-footer__list-item">
							<a class="gtt-footer__link" href="<?php echo esc_url( $item['url'] ); ?>" <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

		</div>

		<hr class="gtt-footer__rule" aria-hidden="true">

		<div class="gtt-footer__tier-firma">
			<a class="gtt-footer__lockup"
			   href="<?php echo esc_url( home_url( '/' ) ); ?>"
			   aria-label="Gastrototem · Inicio">
				<?php echo gtt_theme_inline_brand_svg( 'lockup-horizontal-gastrototem.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de marca controlado, sin input externo. ?>
			</a>
			<p class="gtt-footer__descriptor">Una firma de Alta Afinación Gastronómica · Andalucía</p>
		</div>

		<hr class="gtt-footer__rule" aria-hidden="true">

		<div class="gtt-footer__tier-cierre">
			<p class="gtt-footer__copyright">© MMXXVI · GASTROTOTEM · ANDALUCÍA</p>
			<p class="gtt-footer__folio">N.º 001</p>
		</div>

	</div>
</footer>
