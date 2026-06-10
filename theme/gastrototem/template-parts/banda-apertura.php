<?php
/**
 * Template part: banda-apertura
 *
 * Banda de apertura tinta a sangre para las páginas interiores propias
 * (page-{slug}.php). Reutiliza el componente .gtt-doc-band de la plantilla
 * "Documento" (assets/css/components/documento.css): kicker mono claro +
 * título h1 + subtítulo, con el [data-gtt-sentinel] en el borde inferior que
 * el observer del header (header.js) usa para conmutar la piel transparente↔sólida.
 *
 * Andamiaje: se llama tras get_header() (que ya abrió <main id="gtt-content">);
 * aquí no se abre ningún <main> nuevo. El <header> de la banda y el cuerpo de la
 * página son HERMANOS dentro de ese <main>, como en template-documento.php.
 *
 * Args (3.º parámetro de get_template_part):
 *   - kicker    string  Etiqueta mono (p. ej. «Afinación»). Opcional.
 *   - titular   string  Título h1 de la página. Requerido para que pinte.
 *   - subtitulo string  Subtítulo bajo el título. Opcional.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gtt_kicker    = isset( $args['kicker'] ) ? (string) $args['kicker'] : '';
$gtt_titular   = isset( $args['titular'] ) ? (string) $args['titular'] : '';
$gtt_subtitulo = isset( $args['subtitulo'] ) ? (string) $args['subtitulo'] : '';
?>
<header class="gtt-doc-band">
	<div class="gtt-doc-band__inner">
		<?php if ( '' !== $gtt_kicker ) : ?>
			<p class="gtt-doc-band__kicker"><?php echo esc_html( $gtt_kicker ); ?></p>
		<?php endif; ?>
		<?php if ( '' !== $gtt_titular ) : ?>
			<h1 class="gtt-doc-band__title"><?php echo esc_html( $gtt_titular ); ?></h1>
		<?php endif; ?>
		<?php if ( '' !== $gtt_subtitulo ) : ?>
			<p class="gtt-doc-band__subtitle"><?php echo esc_html( $gtt_subtitulo ); ?></p>
		<?php endif; ?>
	</div>
	<span class="gtt-doc-band__sentinel" data-gtt-sentinel aria-hidden="true"></span>
</header>
