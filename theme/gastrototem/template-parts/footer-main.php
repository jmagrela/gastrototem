<?php
/**
 * Template part: footer-main
 *
 * Footer del sitio: CTA editorial + utility row (BRAND/CONTACTO/LEGAL)
 * + copyright. Puramente presentacional, sin JS.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Items legales (hardcodeados, no wp_nav_menu — misma justificación que C1)
 * ---------------------------------------------------------------------- */

$items_legal = array(
	array( 'label' => 'Aviso legal', 'url' => '/aviso-legal' ),
	array( 'label' => 'Privacidad',  'url' => '/privacidad' ),
	array( 'label' => 'Cookies',     'url' => '/cookies' ),
);

/* -------------------------------------------------------------------------
 * Comparación de ruta actual para aria-current
 * ---------------------------------------------------------------------- */

$current_path = '';
if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
	$current_path = untrailingslashit(
		(string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
	);
}

/* -------------------------------------------------------------------------
 * Lockup SVG inline · cacheado en static (mismo patrón que header-main)
 * ---------------------------------------------------------------------- */

$gtt_get_lockup_svg = static function (): string {
	static $cached;
	if ( ! isset( $cached ) ) {
		$path = get_stylesheet_directory() . '/assets/brand/lockup-horizontal-gastrototem.svg';
		if ( ! is_readable( $path ) ) {
			$cached = '';
		} else {
			$svg = file_get_contents( $path );
			if ( false === $svg || '' === $svg ) {
				$cached = '';
			} else {
				$cached = str_replace( '<svg', '<svg aria-hidden="true"', $svg );
			}
		}
	}
	return $cached;
};

?>
<footer class="gtt-footer" role="contentinfo">

	<div class="gtt-footer__inner">

		<div class="gtt-footer__tier-cta">
			<h2 class="gtt-footer__kicker gtt-footer__kicker--cta">Reservar una sesión</h2>
			<a class="gtt-footer__cta-link" href="<?php echo esc_url( '/reservar' ); ?>">Verificar zonas y fechas <span class="gtt-footer__cta-arrow" aria-hidden="true">→</span></a>
		</div>

		<hr class="gtt-footer__rule" aria-hidden="true">

		<div class="gtt-footer__tier-utility">

			<div class="gtt-footer__col gtt-footer__col--brand">
				<a class="gtt-footer__lockup"
				   href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   aria-label="Gastrototem · Inicio">
					<?php echo $gtt_get_lockup_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de marca controlado, sin input externo. ?>
				</a>
				<p class="gtt-footer__descriptor">Una firma de Alta Afinación Gastronómica.</p>
			</div>

			<div class="gtt-footer__col gtt-footer__col--contacto">
				<h2 class="gtt-footer__kicker">Contacto</h2>
				<a class="gtt-footer__email"
				   href="mailto:info@gastrototem.com"
				   aria-label="Enviar email a info@gastrototem.com">info@gastrototem.com</a>
				<p class="gtt-footer__location">Andalucía · España</p>
			</div>

			<div class="gtt-footer__col gtt-footer__col--legal">
				<h2 class="gtt-footer__kicker">Legal</h2>
				<ul class="gtt-footer__legal-list" role="list">
					<?php foreach ( $items_legal as $item ) : ?>
						<?php $is_current = ( '' !== $current_path && $current_path === untrailingslashit( $item['url'] ) ); ?>
						<li class="gtt-footer__legal-item">
							<a class="gtt-footer__legal-link"
							   href="<?php echo esc_url( $item['url'] ); ?>"
							   <?php echo $is_current ? 'aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

		</div>

		<p class="gtt-footer__copyright">© <?php echo esc_html( current_time( 'Y' ) ); ?> Gastrototem</p>

	</div>
</footer>
