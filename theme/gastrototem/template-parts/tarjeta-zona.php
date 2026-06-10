<?php
/**
 * Template part: tarjeta-zona
 *
 * Tarjeta de una zona reservable. Estado estático: abierta | sin-fechas |
 * proximamente. El CTA «Verificar fechas» SOLO aparece en estado «abierta».
 * Estilado por .gtt-zona (assets/css/components/primitivos.css).
 *
 * Los estados son estáticos por decisión; el cableado dinámico al plugin de
 * reservas (gastrototem-booking) es deuda aparcada, no se monta aquí.
 *
 * Args (3.º parámetro de get_template_part):
 *   - zona     string  Nombre de la zona. Requerido.
 *   - estado   string  abierta | sin-fechas | proximamente. Default: proximamente.
 *   - sublinea string  Sub-línea operativa. Opcional (default según estado).
 *   - cta_url  string  Destino del CTA (solo se pinta en «abierta»). Opcional.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gtt_zona   = isset( $args['zona'] ) ? (string) $args['zona'] : '';
$gtt_estado = isset( $args['estado'] ) ? (string) $args['estado'] : 'proximamente';
$gtt_cta    = isset( $args['cta_url'] ) ? (string) $args['cta_url'] : '';

$gtt_estados = array(
	'abierta'      => array(
		'etiqueta' => 'Abierta',
		'sublinea' => '',
		'cta'      => true,
	),
	'sin-fechas'   => array(
		'etiqueta' => 'Sin fechas',
		'sublinea' => 'Sin fechas disponibles ahora mismo.',
		'cta'      => false,
	),
	'proximamente' => array(
		'etiqueta' => 'Próximamente',
		'sublinea' => '',
		'cta'      => false,
	),
);

if ( ! isset( $gtt_estados[ $gtt_estado ] ) ) {
	$gtt_estado = 'proximamente';
}
$gtt_conf = $gtt_estados[ $gtt_estado ];

$gtt_sublinea = isset( $args['sublinea'] ) ? (string) $args['sublinea'] : $gtt_conf['sublinea'];
?>
<article class="gtt-zona">
	<div class="gtt-zona__estado">
		<span class="gtt-zona__punto gtt-zona__punto--<?php echo esc_attr( $gtt_estado ); ?>" aria-hidden="true"></span>
		<span class="gtt-kicker"><?php echo esc_html( $gtt_conf['etiqueta'] ); ?></span>
	</div>
	<h2 class="gtt-zona__nombre"><?php echo esc_html( $gtt_zona ); ?></h2>
	<?php if ( '' !== $gtt_sublinea ) : ?>
		<p class="gtt-zona__sublinea"><?php echo esc_html( $gtt_sublinea ); ?></p>
	<?php endif; ?>
	<?php if ( $gtt_conf['cta'] && '' !== $gtt_cta ) : ?>
		<a class="gtt-zona__cta" href="<?php echo esc_url( $gtt_cta ); ?>"><span class="gtt-zona__cta-label">Verificar fechas</span> <span class="gtt-zona__cta-flecha" aria-hidden="true">→</span></a>
	<?php endif; ?>
</article>
