<?php
/**
 * Template part: pull-quote
 *
 * Cita destacada de cierre de sección: regla corta + cita en Source Serif 4
 * Italic (grafito sobre papel) + atribución mono opcional. Mismo lenguaje que
 * la cita de las páginas-documento y de la home. Estilado por .gtt-pullquote
 * (assets/css/components/primitivos.css).
 *
 * Args (3.º parámetro de get_template_part):
 *   - cita       string  Texto de la cita. Requerido.
 *   - atribucion string  Atribución mono bajo la cita. Opcional.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gtt_cita  = isset( $args['cita'] ) ? (string) $args['cita'] : '';
$gtt_atrib = isset( $args['atribucion'] ) ? (string) $args['atribucion'] : '';

if ( '' === $gtt_cita ) {
	return;
}
?>
<figure class="gtt-pullquote">
	<hr class="gtt-pullquote__regla" aria-hidden="true">
	<blockquote class="gtt-pullquote__cita"><?php echo esc_html( $gtt_cita ); ?></blockquote>
	<?php if ( '' !== $gtt_atrib ) : ?>
		<figcaption class="gtt-pullquote__atribucion"><?php echo esc_html( $gtt_atrib ); ?></figcaption>
	<?php endif; ?>
</figure>
