<?php
/**
 * Template part: bloque-pasos
 *
 * Lista de pasos numerados (01/02/03) con reglas, mismo lenguaje editorial que
 * el cuerpo de la home. Estilado por .gtt-pasos / .gtt-paso
 * (assets/css/components/primitivos.css).
 *
 * Args (3.º parámetro de get_template_part):
 *   - pasos array   Lista de pasos; cada uno array( 'titulo' => string, 'texto' => string ). Requerido.
 *   - coda  string  Texto de cierre bajo la lista. Opcional.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gtt_pasos = ( isset( $args['pasos'] ) && is_array( $args['pasos'] ) ) ? $args['pasos'] : array();
$gtt_coda  = isset( $args['coda'] ) ? (string) $args['coda'] : '';

if ( empty( $gtt_pasos ) ) {
	return;
}
?>
<ol class="gtt-pasos">
	<?php foreach ( $gtt_pasos as $gtt_i => $gtt_paso ) : ?>
		<li class="gtt-paso">
			<p class="gtt-paso__num"><?php echo esc_html( str_pad( (string) ( (int) $gtt_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
			<h2 class="gtt-paso__titulo"><?php echo esc_html( isset( $gtt_paso['titulo'] ) ? (string) $gtt_paso['titulo'] : '' ); ?></h2>
			<p class="gtt-paso__texto"><?php echo esc_html( isset( $gtt_paso['texto'] ) ? (string) $gtt_paso['texto'] : '' ); ?></p>
		</li>
	<?php endforeach; ?>
</ol>
<?php if ( '' !== $gtt_coda ) : ?>
	<p class="gtt-pasos-coda"><?php echo esc_html( $gtt_coda ); ?></p>
<?php endif; ?>
