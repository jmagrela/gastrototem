<?php
/**
 * Plantilla 404 — contenido no encontrado.
 *
 * @package Gastrototem
 */

get_header();
?>

<section class="gtt-error-404">
	<header class="gtt-error-header">
		<h1 class="gtt-error-title">
			<?php esc_html_e( 'Página no encontrada', 'gastrototem' ); ?>
		</h1>
	</header>

	<div class="gtt-error-content">
		<p>
			<?php esc_html_e( 'La dirección que has introducido no corresponde a ningún contenido. Puede que el enlace sea antiguo o que haya un error de tecleo.', 'gastrototem' ); ?>
		</p>

		<p>
			<a class="gtt-error-home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Volver a la portada', 'gastrototem' ); ?>
			</a>
		</p>

		<?php get_search_form(); ?>
	</div>
</section>

<?php
get_footer();
