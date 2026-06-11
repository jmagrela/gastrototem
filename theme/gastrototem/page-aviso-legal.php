<?php
/**
 * Página: /aviso-legal — información legal del titular del sitio (LSSI Art. 10).
 *
 * Banda de apertura tinta + hoja de prosa .gtt-doc-prose (documento.css) con el
 * texto hardcodeado (no usa the_content()). Slug 'aviso-legal' (el que enlaza el
 * footer). Contexto de header 'document' vía gtt_is_interior_page().
 *
 * Andamiaje como las demás interiores: get_header() abre el <main id="gtt-content">
 * y get_footer() lo cierra. Borrador estándar con los datos del titular.
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
		'kicker'    => 'Legal',
		'titular'   => 'Aviso legal',
		'subtitulo' => 'Quién está detrás de Gastrototem y en qué términos.',
	)
);
?>

<div class="gtt-doc-content">
	<div class="gtt-doc-content__inner">
		<div class="gtt-doc-prose">

			<h2>Titular del sitio</h2>
			<p>En cumplimiento del artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y de Comercio Electrónico (LSSI-CE), se informa de los datos del titular de este sitio web:</p>
			<ul>
				<li><strong>Denominación social:</strong> GASTROTOTEM S.L.</li>
				<li><strong>CIF:</strong> B90123514</li>
				<li><strong>Domicilio:</strong> Calle Bartolomé de Medina, 24, C.P. 41004, Sevilla (España)</li>
				<li><strong>Correo electrónico:</strong> info@gastrototem.com</li>
			</ul>

			<h2>Objeto</h2>
			<p>Este sitio web tiene por objeto presentar los servicios de Gastrototem y permitir la reserva de la Sesión de Afinación. El acceso y la navegación atribuyen la condición de usuario e implican la aceptación de las condiciones recogidas en este aviso legal.</p>

			<h2>Condiciones de uso</h2>
			<p>El usuario se compromete a hacer un uso lícito del sitio y de sus contenidos, conforme a la ley, a la buena fe y al orden público, y a no emplearlos para fines ilícitos o lesivos para los derechos e intereses de terceros.</p>
			<p>Gastrototem se reserva el derecho de modificar, suspender o retirar, en cualquier momento y sin aviso previo, los contenidos y servicios del sitio.</p>

			<h2>Propiedad intelectual e industrial</h2>
			<p>Los contenidos de este sitio —textos, imágenes, diseño, marcas, logotipos y código— son titularidad de Gastrototem o de terceros que han autorizado su uso, y están protegidos por la normativa de propiedad intelectual e industrial. La marca «Gastrototem» y los signos distintivos que aparecen en el sitio pertenecen a su titular.</p>
			<p>Queda prohibida su reproducción, distribución, comunicación pública o transformación, total o parcial, sin la autorización previa y por escrito del titular, salvo en los casos permitidos por la ley.</p>

			<h2>Responsabilidad y enlaces</h2>
			<p>Gastrototem no se hace responsable de los daños que pudieran derivarse del uso del sitio ni de la presencia de virus u otros elementos lesivos introducidos por terceros al margen de su control.</p>
			<p>El sitio puede contener enlaces a páginas de terceros. Gastrototem no asume responsabilidad alguna sobre el contenido, las políticas o las prácticas de esos sitios externos.</p>

			<h2>Ley aplicable y jurisdicción</h2>
			<p>Las presentes condiciones se rigen por la legislación española. Para la resolución de cualquier controversia, las partes se someten a los Juzgados y Tribunales que correspondan conforme a la normativa aplicable.</p>

		</div>
	</div>
</div>

<?php
get_footer();
