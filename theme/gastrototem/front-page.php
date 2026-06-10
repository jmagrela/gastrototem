<?php
/**
 * Plantilla de portada (front page).
 *
 * Hero de apertura a sangre (foto + composición editorial sobre el grafito) y,
 * debajo, el contenido de la página. Pieza 1: estructura + composición, SIN capa
 * de movimiento (el zoom-scroll / desvanecido / grano son una pieza posterior).
 *
 * Andamiaje idéntico a page.php / template-documento.php: get_header() abre
 * <main id="gtt-content"> y get_footer() lo cierra; aquí NO se abre ningún <main>
 * nuevo (regla dura: un solo <main> por documento). El hero <section> y el
 * contenedor de contenido son HERMANOS dentro de ese <main>.
 *
 * El overlap (contenido sólido subiendo por encima del hero) es CSS puro:
 * .gtt-hero es position:sticky;z-index:0 y .gtt-home-contenido es relative;z-index:1.
 * El sentinel (primer hijo de .gtt-home-contenido) es el arnés del observer del
 * header: mientras no cruza el borde inferior del header, piel transparente.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="gtt-hero" aria-label="Apertura">

	<img class="gtt-hero__foto"
	     src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/plato-002.webp' ); ?>"
	     alt=""
	     loading="eager"
	     fetchpriority="high"
	     decoding="async">

	<div class="gtt-hero__overlay" aria-hidden="true"></div>

	<div class="gtt-hero__contenido">

		<div class="gtt-hero__cabecera">
			<span class="gtt-hero__rotulo">Gastrototem · Andalucía</span>
			<span class="gtt-hero__rotulo">N.º 001 · MMXXVI</span>
		</div>

		<div class="gtt-hero__composicion">
			<p class="gtt-hero__folio">Folio I · Apertura</p>
			<p class="gtt-hero__kicker">Una firma de Alta Afinación Gastronómica</p>
			<h1 class="gtt-hero__titulo">Donde otros ven una comida, nosotros <em class="gtt-hero__acento">leemos</em> un restaurante.</h1>
			<p class="gtt-hero__subtitulo">Una visita. Una conversación. Un informe firmado. En el acto.</p>
			<div class="gtt-hero__ctas">
				<a class="gtt-hero__cta gtt-hero__cta--primario" href="#zonas">Verificar zonas y fechas <span class="gtt-hero__cta-flecha" aria-hidden="true">→</span></a>
				<a class="gtt-hero__cta gtt-hero__cta--secundario" href="#metodo">Ver cómo afinamos</a>
			</div>
		</div>

		<div class="gtt-hero__banda" aria-hidden="true">
			<span class="gtt-hero__rotulo">Una visita · Un afinamiento · Un informe firmado en el acto</span>
			<span class="gtt-hero__rotulo gtt-hero__rotulo--lamina">Lám. I — Sala vacía</span>
		</div>

	</div>
</section>

<div class="gtt-home-contenido">

	<span class="gtt-hero__sentinel" data-gtt-sentinel aria-hidden="true"></span>

	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>

</div>

<?php
get_footer();
