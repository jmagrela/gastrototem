<?php
/**
 * Página: /contacto — canales (sin formulario, sin teléfono).
 *
 * Banda de apertura tinta + cuerpo papel: canales (Correo, único; Reservar →
 * /afinacion; La firma, descriptor) y una cita de cierre. Por decisión: sin
 * formulario y sin teléfono, solo el correo como canal. Contexto de header
 * 'document' vía gtt_is_interior_page().
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
		'kicker'    => 'Contacto',
		'titular'   => 'Escríbenos.',
		'subtitulo' => 'Cuéntanos qué restaurante quieres afinar.',
	)
);
?>

<div class="gtt-pagina gtt-contacto">
	<div class="gtt-pagina__inner">

		<section class="gtt-pagina-seccion" aria-label="Canales">

			<div class="gtt-canal">
				<p class="gtt-kicker">Correo</p>
				<a class="gtt-canal__mail" href="mailto:info@gastrototem.com" aria-label="Enviar email a info@gastrototem.com">info@gastrototem.com</a>
				<p class="gtt-canal__texto">Para la Afinación en Profundidad, prensa o cualquier otro asunto.</p>
			</div>

			<div class="gtt-canal">
				<p class="gtt-kicker">Reservar</p>
				<p class="gtt-canal__texto">El calendario de la Sesión de Afinación está en <a href="<?php echo esc_url( '/afinacion' ); ?>">Afinación →</a></p>
			</div>

			<div class="gtt-canal">
				<p class="gtt-kicker">La firma</p>
				<p class="gtt-firma-descriptor">Gastrototem · Una firma de Alta Afinación Gastronómica.</p>
				<p class="gtt-firma-descriptor__nota">Te responde uno de los dos.</p>
			</div>

		</section>

		<section class="gtt-pagina-seccion">
			<?php
			get_template_part(
				'template-parts/pull-quote',
				null,
				array(
					'cita' => 'Donde otros ven una comida, nosotros leemos un restaurante.',
				)
			);
			?>
		</section>

	</div>
</div>

<?php
get_footer();
