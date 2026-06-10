<?php
/**
 * Página: /nosotros — el oficio y los dos afinadores.
 *
 * Banda de apertura tinta + cuerpo papel: el oficio (prosa), los dos (Huidobro /
 * Agrela) y una cita de cierre. Slug 'nosotros' (el que enlazan el menú del
 * header y el footer). Contexto de header 'document' vía gtt_is_interior_page().
 *
 * Andamiaje como front-page.php: get_header() abre el <main id="gtt-content"> y
 * get_footer() lo cierra. Contenido editorial fijo (no usa the_content()).
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
		'kicker'    => 'Sobre nosotros',
		'titular'   => 'Una firma de Alta Afinación Gastronómica.',
		'subtitulo' => 'Dos afinadores, desde Andalucía.',
	)
);
?>

<div class="gtt-pagina gtt-nosotros">
	<div class="gtt-pagina__inner">

		<section class="gtt-pagina-seccion" aria-labelledby="gtt-nosotros-oficio">
			<p class="gtt-kicker" id="gtt-nosotros-oficio">El oficio</p>
			<div class="gtt-prosa">
				<p>Afinar un restaurante es leerlo entero. Comemos como un cliente más, sin avisar, y atendemos a todo lo que un comensal nota sin saber nombrarlo: la carta, la sala, el servicio, el ritmo, el punto exacto en que algo desafina.</p>
				<p>Te entregamos una lectura concreta de tu restaurante, hecha sobre el terreno. Antes de irnos nos sentamos contigo, te la contamos a la cara y te dejamos un informe firmado en el acto.</p>
				<p>Lo que hagas con esa lectura es decisión tuya. Respondemos de la lectura y de las propuestas concretas que la acompañan; del restaurante, respondes tú.</p>
			</div>
		</section>

		<section class="gtt-pagina-seccion" aria-labelledby="gtt-nosotros-dos">
			<p class="gtt-kicker" id="gtt-nosotros-dos">Los dos</p>
			<p class="gtt-dos__intro">Gastrototem es una firma de dos. Cada visita la hacen ellos.</p>
			<div class="gtt-dos">
				<article class="gtt-persona">
					<p class="gtt-persona__nombre">Fernando Huidobro</p>
					<p class="gtt-persona__rol">Afinador de cartas · Málaga</p>
					<p class="gtt-persona__bio">Fundador de la Academia Andaluza de Gastronomía y Turismo. Lee la carta y la sala con el oído de quien lleva toda una vida en ellas.</p>
				</article>
				<article class="gtt-persona">
					<p class="gtt-persona__nombre">Juan M. Agrela</p>
					<p class="gtt-persona__rol">Divulgador gastronómico · Granada</p>
					<p class="gtt-persona__bio">Especialista en comunicación. Da forma a la lectura y a las propuestas concretas que el restaurante se lleva.</p>
				</article>
			</div>
		</section>

		<section class="gtt-pagina-seccion">
			<?php
			get_template_part(
				'template-parts/pull-quote',
				null,
				array(
					'cita' => 'Una sola cosa: leer un restaurante entero.',
				)
			);
			?>
		</section>

	</div>
</div>

<?php
get_footer();
