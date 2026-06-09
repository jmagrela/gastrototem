<?php
/**
 * Template Name: Documento
 *
 * Plantilla de "página-documento": una banda de apertura tinta a sangre con un
 * sentinel en su borde inferior (arnés para un futuro IntersectionObserver del
 * header, en una pieza posterior) y, debajo, el contenido normal de la página.
 *
 * Andamiaje idéntico a page.php: get_header() abre <main id="gtt-content"> y
 * get_footer() lo cierra; aquí no se abre ningún <main> nuevo.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<header class="gtt-doc-band">
		<div class="gtt-doc-band__inner">
			<?php
			$titular = trim( (string) get_post_meta( get_the_ID(), '_gtt_titular', true ) );
			if ( '' !== $titular ) :
				?>
				<p class="gtt-doc-band__kicker"><?php the_title(); ?></p>
				<h1 class="gtt-doc-band__title"><?php echo esc_html( $titular ); ?></h1>
				<?php
			else :
				?>
				<h1 class="gtt-doc-band__title"><?php the_title(); ?></h1>
				<?php
			endif;
			?>
			<?php if ( has_excerpt() ) : ?>
				<p class="gtt-doc-band__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
		<span class="gtt-doc-band__sentinel" data-gtt-sentinel aria-hidden="true"></span>
	</header>

	<div class="gtt-doc-content">
		<div class="gtt-doc-content__inner">
			<?php the_content(); ?>
		</div>
	</div>

<?php endwhile; ?>

<?php
get_footer();
