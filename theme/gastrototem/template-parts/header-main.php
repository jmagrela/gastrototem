<?php
/**
 * Template part: header-main
 *
 * Header del sitio + overlay de menú principal.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * Items del menú (hardcodeados, no wp_nav_menu — ver Observaciones del prompt)
 * ---------------------------------------------------------------------- */

$items_primary = array(
	array( 'numeral' => 'i',   'label' => 'Afinación',      'url' => '/afinacion' ),
	array( 'numeral' => 'ii',  'label' => 'Criterio',       'url' => '/criterio' ),
	array( 'numeral' => 'iii', 'label' => 'Sobre nosotros', 'url' => '/nosotros' ),
	array( 'numeral' => 'iv',  'label' => 'Contacto',       'url' => '/contacto' ),
);

$items_secondary = array(
	array( 'numeral' => 'v',   'label' => 'Mi cuenta',      'url' => '/mi-cuenta' ),
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
 * Lockup SVG inline · cacheado en static para no leer disco en cada render
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
<header class="gtt-header" role="banner">

	<a class="gtt-skip-link" href="#gtt-content">Saltar al contenido</a>

	<div class="gtt-header__bar">

		<a class="gtt-header__lockup"
		   href="<?php echo esc_url( home_url( '/' ) ); ?>"
		   aria-label="Gastrototem · Inicio">
			<?php echo $gtt_get_lockup_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de marca controlado, sin input externo. ?>
		</a>

		<button class="gtt-header__toggle" type="button"
		        aria-label="Abrir menú"
		        aria-expanded="false"
		        aria-controls="gtt-menu-overlay">
			<svg viewBox="0 0 28 16" width="28" height="16" aria-hidden="true" focusable="false">
				<line class="gtt-toggle-line gtt-toggle-line--top"
				      x1="0" y1="1" x2="28" y2="1"
				      stroke="currentColor" stroke-width="1.5" stroke-linecap="butt" />
				<line class="gtt-toggle-line gtt-toggle-line--middle"
				      x1="0" y1="8" x2="28" y2="8"
				      stroke="currentColor" stroke-width="1.5" stroke-linecap="butt" />
				<line class="gtt-toggle-line gtt-toggle-line--bottom"
				      x1="0" y1="15" x2="28" y2="15"
				      stroke="currentColor" stroke-width="1.5" stroke-linecap="butt" />
			</svg>
		</button>

	</div>

	<nav id="gtt-menu-overlay" class="gtt-menu-overlay"
	     aria-label="Menú principal"
	     aria-hidden="true">

		<div class="gtt-menu-overlay__inner">

			<ul class="gtt-menu-overlay__list" role="list">
				<?php foreach ( $items_primary as $item ) : ?>
					<?php $is_current = ( '' !== $current_path && $current_path === untrailingslashit( $item['url'] ) ); ?>
					<li class="gtt-menu-overlay__item">
						<a class="gtt-menu-overlay__link"
						   href="<?php echo esc_url( $item['url'] ); ?>"
						   <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
							<span class="gtt-menu-overlay__numeral" aria-hidden="true"><?php echo esc_html( $item['numeral'] ); ?></span>
							<span class="gtt-menu-overlay__label"><?php echo esc_html( $item['label'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<hr class="gtt-menu-overlay__rule" aria-hidden="true">

			<ul class="gtt-menu-overlay__list gtt-menu-overlay__list--secondary" role="list">
				<?php foreach ( $items_secondary as $item ) : ?>
					<?php $is_current = ( '' !== $current_path && $current_path === untrailingslashit( $item['url'] ) ); ?>
					<li class="gtt-menu-overlay__item">
						<a class="gtt-menu-overlay__link"
						   href="<?php echo esc_url( $item['url'] ); ?>"
						   <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
							<span class="gtt-menu-overlay__numeral" aria-hidden="true"><?php echo esc_html( $item['numeral'] ); ?></span>
							<span class="gtt-menu-overlay__label"><?php echo esc_html( $item['label'] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="gtt-menu-overlay__cta">
				<p class="gtt-menu-overlay__kicker">Reservar una sesión</p>
				<a class="gtt-menu-overlay__cta-link" href="<?php echo esc_url( '/reservar' ); ?>">Verificar zonas y fechas <span class="gtt-menu-overlay__cta-arrow" aria-hidden="true">→</span></a>
			</div>

		</div>
	</nav>

</header>
