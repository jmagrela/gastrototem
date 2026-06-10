<?php
/**
 * Página: /criterio — el punto de vista y las cuatro miradas.
 *
 * Banda de apertura tinta + cuerpo papel: el punto de vista (prosa), las cuatro
 * miradas (Carta / Sala / Servicio / Ritmo en rejilla con hairlines) y una cita
 * de cierre. Contexto de header 'document' vía gtt_is_interior_page().
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
		'kicker'    => 'Criterio',
		'titular'   => 'Pensamos los restaurantes en voz alta.',
		'subtitulo' => 'Notas de oficio sobre la carta, la sala y el servicio.',
	)
);
?>

<div class="gtt-pagina gtt-criterio">
	<div class="gtt-pagina__inner">

		<section class="gtt-pagina-seccion" aria-labelledby="gtt-criterio-punto">
			<p class="gtt-kicker" id="gtt-criterio-punto">El punto de vista</p>
			<div class="gtt-prosa">
				<p>No puntuamos restaurantes; los leemos. Una nota dice si algo gustó. Una lectura dice qué pasa, qué desafina y por qué.</p>
				<p>Un restaurante se lee por partes; estas cuatro son las que más dicen de él.</p>
			</div>
		</section>

		<section class="gtt-pagina-seccion" aria-labelledby="gtt-criterio-miradas">
			<p class="gtt-kicker" id="gtt-criterio-miradas">Las cuatro miradas</p>
			<div class="gtt-miradas">
				<article class="gtt-mirada">
					<h2 class="gtt-mirada__titulo">Carta</h2>
					<p class="gtt-mirada__texto">Una carta dice quién manda en la cocina: si tiene foco o quiere abarcarlo todo, si lo que promete puede sostenerlo. Una corta y firme casi siempre dice más que una larga e indecisa.</p>
				</article>
				<article class="gtt-mirada">
					<h2 class="gtt-mirada__titulo">Sala</h2>
					<p class="gtt-mirada__texto">La sala se nota sin mirarla: la luz, el ruido, la distancia entre mesas, dónde te sientan. Una buena sala te coloca bien sin que sepas por qué.</p>
				</article>
				<article class="gtt-mirada">
					<h2 class="gtt-mirada__titulo">Servicio</h2>
					<p class="gtt-mirada__texto">El servicio se ve en los bordes: cómo te reciben, cómo desaparecen cuando sobran, cómo te despiden. El final —pedir la cuenta, irse— se descuida casi siempre, y se nota siempre.</p>
				</article>
				<article class="gtt-mirada">
					<h2 class="gtt-mirada__titulo">Ritmo</h2>
					<p class="gtt-mirada__texto">El ritmo es el plato que no figura en la carta: cuánto esperas, cómo llega cada cosa, si la comida respira o atropella. Servir demasiado rápido cuenta lo mismo que demasiado lento.</p>
				</article>
			</div>
		</section>

		<section class="gtt-pagina-seccion">
			<?php
			get_template_part(
				'template-parts/pull-quote',
				null,
				array(
					'cita' => 'Lo que más dice de un restaurante casi nunca está en el plato.',
				)
			);
			?>
		</section>

	</div>
</div>

<?php
get_footer();
