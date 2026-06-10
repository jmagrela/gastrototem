<?php
/**
 * Página: /afinacion — la Sesión de Afinación al detalle.
 *
 * Banda de apertura tinta + cuerpo papel: los pasos, el precio con reserva por
 * zonas (estados estáticos) y la Afinación en Profundidad (sin reserva web, CTA
 * «Escríbenos»). Contexto de header 'document' vía gtt_is_interior_page().
 *
 * Andamiaje como front-page.php / template-documento.php: get_header() abre el
 * <main id="gtt-content"> y get_footer() lo cierra; aquí no se abre <main> nuevo.
 * Contenido editorial fijo (no usa the_content()).
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part(
	'template-parts/banda-apertura',
	null,
	array(
		'kicker'    => 'Afinación',
		'titular'   => 'Venimos a leer tu restaurante.',
		'subtitulo' => 'Una lectura completa, por escrito y firmada.',
	)
);
?>

<div class="gtt-pagina gtt-afinacion">
	<div class="gtt-pagina__inner">

		<section class="gtt-pagina-seccion" aria-labelledby="gtt-afinacion-pasos">
			<p class="gtt-kicker" id="gtt-afinacion-pasos">Los pasos</p>
			<?php
			get_template_part(
				'template-parts/bloque-pasos',
				null,
				array(
					'pasos' => array(
						array(
							'titulo' => 'Una visita',
							'texto'  => 'Venimos a comer como un cliente más, sin avisar. Leemos la carta, la sala, el servicio y el ritmo, todo a la vez.',
						),
						array(
							'titulo' => 'Una conversación',
							'texto'  => 'Antes de irnos nos sentamos contigo y te contamos a la cara lo que hemos leído. Sin rodeos.',
						),
						array(
							'titulo' => 'Un informe firmado',
							'texto'  => 'Te dejamos por escrito la lectura y las propuestas concretas, firmado, en el acto.',
						),
					),
					'coda'  => 'Y una llamada de control entre 15 y 30 días después, para resolver lo que haya surgido.',
				)
			);
			?>
		</section>

		<section class="gtt-pagina-seccion" aria-labelledby="gtt-afinacion-reservar">
			<p class="gtt-kicker" id="gtt-afinacion-reservar">Reservar</p>
			<p class="gtt-afinacion-precio">Una Sesión de Afinación son 1.000 € + IVA.</p>
			<p class="gtt-afinacion-nota">Todo lo anterior, incluido.</p>
			<p class="gtt-afinacion-zonas-intro">Se reserva por zonas. Esto es lo que hay abierto ahora mismo:</p>
			<div class="gtt-zonas-grid">
				<?php
				get_template_part(
					'template-parts/tarjeta-zona',
					null,
					array(
						'zona'    => 'Málaga',
						'estado'  => 'abierta',
						'cta_url' => '/reservar',
					)
				);
				get_template_part(
					'template-parts/tarjeta-zona',
					null,
					array(
						'zona'   => 'Granada',
						'estado' => 'sin-fechas',
					)
				);
				get_template_part(
					'template-parts/tarjeta-zona',
					null,
					array(
						'zona'   => 'Sevilla',
						'estado' => 'proximamente',
					)
				);
				?>
			</div>
		</section>

		<section class="gtt-pagina-seccion gtt-profundidad" aria-labelledby="gtt-afinacion-profundidad">
			<p class="gtt-kicker" id="gtt-afinacion-profundidad">Afinación en Profundidad</p>
			<p class="gtt-profundidad__texto">Un trabajo más extenso, para restaurantes que quieren ir más a fondo. Lo planteamos caso por caso.</p>
			<p class="gtt-profundidad__texto">Son 3.500 € + IVA. No se reserva por web.</p>
			<a class="gtt-pagina-mail gtt-profundidad__cta" href="mailto:info@gastrototem.com"><span class="gtt-pagina-mail-label">Escríbenos</span> <span class="gtt-pagina-mail-flecha" aria-hidden="true">→</span></a>
		</section>

	</div>
</div>

<?php
get_footer();
