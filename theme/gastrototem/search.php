<?php
/**
 * Plantilla de resultados de búsqueda.
 *
 * @package Gastrototem
 */

get_header();
?>

<header class="gtt-template-search-header">
	<h1 class="gtt-template-search-title">
		<?php
		/* translators: %s: término de búsqueda */
		printf(
			esc_html__( 'Resultados para: %s', 'gastrototem' ),
			'<span class="gtt-template-search-query">' . esc_html( get_search_query() ) . '</span>'
		);
		?>
	</h1>
</header>

<?php if ( have_posts() ) : ?>

	<div class="gtt-template-search-list">
		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'gtt-template-entry gtt-template-entry--search' ); ?>>
				<header class="gtt-template-entry-header">
					<?php
					the_title(
						'<h2 class="gtt-template-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">',
						'</a></h2>'
					);
					?>
				</header>

				<div class="gtt-template-entry-summary">
					<?php the_excerpt(); ?>
				</div>
			</article>

		<?php endwhile; ?>
	</div>

	<?php
	the_posts_pagination(
		array(
			'prev_text' => esc_html__( 'Anterior', 'gastrototem' ),
			'next_text' => esc_html__( 'Siguiente', 'gastrototem' ),
		)
	);
	?>

<?php else : ?>

	<div class="gtt-template-search-empty">
		<p><?php esc_html_e( 'No se han encontrado resultados. Prueba con otras palabras.', 'gastrototem' ); ?></p>
		<?php get_search_form(); ?>
	</div>

<?php endif; ?>

<?php
get_footer();
