<?php
/**
 * Plantilla por defecto (fallback).
 *
 * Se usa cuando ninguna plantilla más específica coincide en la
 * jerarquía de templates de WordPress.
 *
 * @package Gastrototem
 */

get_header();
?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'gtt-template-entry' ); ?>>
			<header class="gtt-template-entry-header">
				<?php
				if ( is_singular() ) {
					the_title( '<h1 class="gtt-template-entry-title">', '</h1>' );
				} else {
					the_title(
						'<h2 class="gtt-template-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">',
						'</a></h2>'
					);
				}
				?>
			</header>

			<div class="gtt-template-entry-content">
				<?php
				if ( is_singular() ) {
					the_content();
				} else {
					the_excerpt();
				}
				?>
			</div>
		</article>

	<?php endwhile; ?>

	<?php the_posts_pagination(); ?>

<?php else : ?>

	<p class="gtt-template-no-content"><?php esc_html_e( 'No hay contenido todavía.', 'gastrototem' ); ?></p>

<?php endif; ?>

<?php
get_footer();
