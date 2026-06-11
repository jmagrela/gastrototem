<?php
/**
 * Página: /privacidad — política de privacidad (RGPD / LOPDGDD).
 *
 * Banda de apertura tinta + hoja de prosa .gtt-doc-prose (documento.css) con el
 * texto hardcodeado (no usa the_content()). Slug 'privacidad' (el que enlaza el
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
		'titular'   => 'Política de privacidad',
		'subtitulo' => 'Qué datos tratamos, con qué fin y durante cuánto tiempo.',
	)
);
?>

<div class="gtt-doc-content">
	<div class="gtt-doc-content__inner">
		<div class="gtt-doc-prose">

			<h2>Responsable del tratamiento</h2>
			<p>El responsable del tratamiento de los datos personales recogidos a través de este sitio es:</p>
			<ul>
				<li><strong>Denominación social:</strong> GASTROTOTEM S.L.</li>
				<li><strong>CIF:</strong> B90123514</li>
				<li><strong>Domicilio:</strong> Calle Bartolomé de Medina, 24, C.P. 41004, Sevilla (España)</li>
				<li><strong>Correo electrónico:</strong> info@gastrototem.com</li>
			</ul>

			<h2>Datos que tratamos y finalidades</h2>
			<h3>a) Reserva de la Sesión de Afinación</h3>
			<p>Para gestionar la reserva de la Sesión de Afinación y preparar la visita, tratamos el nombre y el correo electrónico de quien reserva, los datos del restaurante y los datos de pago, que se procesan a través de Stripe. <strong>Base jurídica:</strong> la ejecución de un contrato en el que el interesado es parte (art. 6.1.b RGPD).</p>
			<h3>b) Consultas por correo electrónico</h3>
			<p>Cuando nos escribes a info@gastrototem.com, tratamos los datos que nos facilites para atender tu consulta. <strong>Base jurídica:</strong> el consentimiento del interesado y el interés legítimo en responder a las solicitudes recibidas (art. 6.1.a y 6.1.f RGPD).</p>

			<h2>Destinatarios y encargados de tratamiento</h2>
			<p>No cedemos tus datos a terceros, salvo obligación legal. Para prestar el servicio recurrimos a proveedores que actúan como encargados de tratamiento, con los que se han suscrito los correspondientes contratos:</p>
			<ul>
				<li><strong>Alojamiento web:</strong> Hostinger International Ltd., que aloja el sitio y los datos asociados.</li>
				<li><strong>Pasarela de pago:</strong> Stripe Payments Europe, Ltd., que procesa los pagos de la reserva.</li>
			</ul>

			<h2>Transferencias internacionales</h2>
			<p>El procesamiento de pagos a través de Stripe puede implicar transferencias de datos fuera del Espacio Económico Europeo. Dichas transferencias se realizan con las garantías adecuadas previstas en el RGPD, en particular las cláusulas contractuales tipo aprobadas por la Comisión Europea.</p>

			<h2>Plazos de conservación</h2>
			<p>Conservamos los datos durante el tiempo necesario para cumplir la finalidad para la que se recogieron y, después, durante los plazos legalmente exigibles para atender posibles responsabilidades. Los datos de las consultas se conservan mientras sea necesario para gestionarlas.</p>

			<h2>Tus derechos</h2>
			<p>Puedes ejercer los derechos de acceso, rectificación, supresión, oposición, limitación del tratamiento y portabilidad de los datos escribiendo a info@gastrototem.com, indicando el derecho que deseas ejercer.</p>
			<p>Si consideras que el tratamiento no se ajusta a la normativa, tienes derecho a presentar una reclamación ante la Agencia Española de Protección de Datos (AEPD), en www.aepd.es.</p>

			<h2>Seguridad</h2>
			<p>Aplicamos las medidas técnicas y organizativas adecuadas para proteger los datos personales frente a la pérdida, el mal uso o el acceso no autorizado, conforme al estado de la técnica y a la naturaleza de los datos tratados.</p>

		</div>
	</div>
</div>

<?php
get_footer();
