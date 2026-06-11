<?php
/**
 * Página: /cookies — política de cookies (LSSI Art. 22.2 / RGPD).
 *
 * Banda de apertura tinta + hoja de prosa .gtt-doc-prose (documento.css) con el
 * texto hardcodeado (no usa the_content()). Slug 'cookies' (el que enlaza el
 * footer). Contexto de header 'document' vía gtt_is_interior_page().
 *
 * La tabla lista las cookies REALES auditadas en staging (técnicas/necesarias).
 * No hay analítica ni marketing: el sitio está exento de banner de consentimiento
 * (Art. 22.2 LSSI). Si en el futuro se añade GA4/Meta u otra cookie no esencial,
 * habrá que actualizar esta tabla y montar el banner.
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
		'titular'   => 'Política de cookies',
		'subtitulo' => 'Qué se guarda en tu navegador y por qué.',
	)
);
?>

<div class="gtt-doc-content">
	<div class="gtt-doc-content__inner">
		<div class="gtt-doc-prose">

			<h2>Qué son las cookies</h2>
			<p>Una cookie es un pequeño archivo de texto que un sitio web guarda en tu navegador cuando lo visitas. Sirve para recordar información entre páginas o entre visitas. Algunas son imprescindibles para que el sitio funcione; otras tienen fines de medición o publicidad.</p>

			<h2>Cookies que utiliza este sitio</h2>
			<p>Durante la navegación habitual por el sitio no se instala ninguna cookie. Las siguientes pueden instalarse únicamente al iniciar sesión en el área «Mi cuenta» o al completar el pago de una reserva. Todas son técnicas y necesarias:</p>

			<div class="gtt-doc-prose__table">
				<table>
					<thead>
						<tr>
							<th>Cookie</th>
							<th>Titular</th>
							<th>Finalidad</th>
							<th>Duración</th>
							<th>Tipo</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>__stripe_mid</td>
							<td>Stripe Payments Europe, Ltd.</td>
							<td>Prevención de fraude en el pago.</td>
							<td>1 año</td>
							<td>Técnica / necesaria</td>
						</tr>
						<tr>
							<td>__stripe_sid</td>
							<td>Stripe Payments Europe, Ltd.</td>
							<td>Seguridad de la sesión de pago.</td>
							<td>30 minutos</td>
							<td>Técnica / necesaria</td>
						</tr>
						<tr>
							<td>wordpress_logged_in_*</td>
							<td>Gastrototem (WordPress)</td>
							<td>Mantener la sesión de un usuario registrado en «Mi cuenta».</td>
							<td>Sesión</td>
							<td>Técnica / necesaria</td>
						</tr>
						<tr>
							<td>wp-settings-*</td>
							<td>Gastrototem (WordPress)</td>
							<td>Recordar preferencias de la interfaz del usuario registrado.</td>
							<td>1 año</td>
							<td>Técnica / necesaria</td>
						</tr>
						<tr>
							<td>_lscache_vary</td>
							<td>Gastrototem (LiteSpeed, vía Hostinger)</td>
							<td>Servir la versión correcta de la caché a usuarios registrados.</td>
							<td>Sesión</td>
							<td>Técnica / necesaria</td>
						</tr>
					</tbody>
				</table>
			</div>

			<h2>Servicios de terceros</h2>
			<p>El área «Mi cuenta» ofrece la opción de acceder con una cuenta de Google, que carga un script de Google Identity Services. Si decides usar esa opción, Google podrá instalar sus propias cookies en sus dominios, conforme a su propia política de privacidad. El pago de las reservas se procesa a través de Stripe, responsable de las cookies técnicas descritas en la tabla.</p>

			<h2>Base legal y consentimiento</h2>
			<p>Las cookies enumeradas son técnicas y necesarias para prestar un servicio expresamente solicitado por el usuario (acceder a su cuenta o completar un pago). Por ello están exentas del deber de consentimiento previo, conforme al artículo 22.2 de la LSSI-CE. Este sitio no utiliza cookies de analítica ni de publicidad.</p>

			<h2>Cómo desactivar las cookies</h2>
			<p>Puedes configurar tu navegador para bloquear o eliminar las cookies desde sus opciones de privacidad. Ten en cuenta que bloquear las cookies técnicas puede impedir el acceso a tu cuenta o la finalización de un pago. Encontrarás las instrucciones en la ayuda de tu navegador (Chrome, Firefox, Safari, Edge u otros).</p>

		</div>
	</div>
</div>

<?php
get_footer();
