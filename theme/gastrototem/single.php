<?php
/**
 * Plantilla por defecto para entradas individuales (post_type=post).
 *
 * @package Gastrototem
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'gtt-entry gtt-entry--single' ); ?>>
		<header class="gtt-entry-header">
			<?php the_title( '<h1 class="gtt-entry-title">', '</h1>' ); ?>

			<div class="gtt-entry-meta">
				<time class="gtt-entry-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
				<span class="gtt-entry-author">
					<?php
					/* translators: %s: nombre del autor */
					printf( esc_html__( 'Por %s', 'gastrototem' ), esc_html( get_the_author() ) );
					?>
				</span>
			</div>
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

		<footer class="gtt-entry-footer">
			<?php
			$categories = get_the_category_list( ', ' );
			if ( $categories ) {
				printf(
					'<p class="gtt-entry-cats">%s %s</p>',
					esc_html__( 'Categorías:', 'gastrototem' ),
					$categories // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}

			$tags = get_the_tag_list( '', ', ' );
			if ( $tags ) {
				printf(
					'<p class="gtt-entry-tags">%s %s</p>',
					esc_html__( 'Etiquetas:', 'gastrototem' ),
					$tags // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			?>
		</footer>
	</article>

	<?php
	the_post_navigation(
		array(
			'prev_text' => '<span class="gtt-nav-label">' . esc_html__( 'Anterior', 'gastrototem' ) . '</span> <span class="gtt-nav-title">%title</span>',
			'next_text' => '<span class="gtt-nav-label">' . esc_html__( 'Siguiente', 'gastrototem' ) . '</span> <span class="gtt-nav-title">%title</span>',
		)
	);

	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>

<?php endwhile; ?>

<?php
get_footer();
