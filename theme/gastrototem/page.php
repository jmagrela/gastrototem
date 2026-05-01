<?php
/**
 * Plantilla por defecto para páginas (post_type=page).
 *
 * @package Gastrototem
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'gtt-template-entry gtt-template-entry--page' ); ?>>
		<header class="gtt-template-entry-header">
			<?php the_title( '<h1 class="gtt-template-entry-title">', '</h1>' ); ?>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="gtt-template-entry-thumbnail">
				<?php the_post_thumbnail( 'large' ); ?>
			</figure>
		<?php endif; ?>

		<div class="gtt-template-entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<nav class="gtt-template-page-links" aria-label="' . esc_attr__( 'Páginas de este contenido', 'gastrototem' ) . '">',
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
