<?php
/**
 * Plantilla por defecto para archivos (categorías, etiquetas, autor, fecha).
 *
 * @package Gastrototem
 */

get_header();
?>

<?php if ( have_posts() ) : ?>

	<header class="gtt-archive-header">
		<?php the_archive_title( '<h1 class="gtt-archive-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="gtt-archive-description">', '</div>' ); ?>
	</header>

	<div class="gtt-archive-list">
		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'gtt-entry gtt-entry--archive' ); ?>>
				<header class="gtt-entry-header">
					<?php
					the_title(
						'<h2 class="gtt-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">',
						'</a></h2>'
					);
					?>

					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="gtt-entry-meta">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</div>
					<?php endif; ?>
				</header>

				<div class="gtt-entry-summary">
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

	<p class="gtt-no-content">
		<?php esc_html_e( 'No hay contenido en este archivo todavía.', 'gastrototem' ); ?>
	</p>

<?php endif; ?>

<?php
get_footer();
