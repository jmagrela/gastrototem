<?php
/**
 * Cabecera del documento.
 *
 * @package Gastrototem
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="gtt-template-skip-link screen-reader-text" href="#gtt-content">
	<?php esc_html_e( 'Saltar al contenido', 'gastrototem' ); ?>
</a>

<header class="gtt-template-site-header" role="banner">
	<div class="gtt-template-site-branding">
		<?php
		if ( has_custom_logo() ) {
			the_custom_logo();
		} else {
			printf(
				'<a href="%1$s" rel="home" class="gtt-template-site-title">%2$s</a>',
				esc_url( home_url( '/' ) ),
				esc_html( get_bloginfo( 'name' ) )
			);
		}
		?>
	</div>

	<?php
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => 'nav',
				'container_class' => 'gtt-template-nav-primary',
				'menu_class'     => 'gtt-template-nav-list',
			)
		);
	}
	?>
</header>

<main id="gtt-content" class="gtt-template-site-main" role="main">
