<?php
/**
 * Plantilla por defecto para páginas (post_type=page).
 *
 * @package Gastrototem
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'gtt-entry gtt-entry--page' ); ?>>
		<header class="gtt-entry-header">
			<?php the_title( '<h1 class="gtt-entry-title">', '</h1>' ); ?>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="gtt-entry-thumbnail">
				<?php the_post_thumbnail( 'large' ); ?>
			</figure>
		<?php endif; ?>

		<div class="gtt-entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<nav class="gtt-page-links" aria-label="' . esc_attr__( 'Páginas de este contenido', 'gastrototem' ) . '">',
					'after'  => '</nav>',
				)
			);
			?>
		</div>
	</article>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>

<?php endwhile; ?>

<?php
get_footer();
