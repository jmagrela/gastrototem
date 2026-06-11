<?php
/**
 * Plantilla 404 — contenido no encontrado.
 *
 * Campo tinta a pantalla completa. El header se sirve en contexto '404'
 * (gtt_header_context()): el micro-script de header.php lo arranca
 * forzado-transparente y el observer de header.js exime '404' (sin auto-hide
 * ni toggle a sólido). Copy sobrio; «aquí» en serif italic papel. Todo el
 * texto en papel sobre el campo tinta. Estilos en assets/css/pages/error-404.css
 * (encolado condicional is_404()).
 *
 * @package Gastrototem
 */

get_header();
?>

<section class="gtt-error404">
	<div class="gtt-error404__inner">
		<p class="gtt-error404__kicker">Error 404</p>
		<h1 class="gtt-error404__title">La página que buscas no está <em class="gtt-error404__accent">aquí</em>.</h1>
		<a class="gtt-error404__cta" href="<?php echo esc_url( home_url( '/' ) ); ?>">Volver al inicio</a>
	</div>
</section>

<?php
get_footer();
