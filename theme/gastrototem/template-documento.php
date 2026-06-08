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
			<h1 class="gtt-doc-band__title"><?php the_title(); ?></h1>
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
