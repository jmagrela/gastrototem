<?php
/**
 * Gastrototem — Header partial
 * Shared across all custom page templates.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class('gt-page'); ?>>
<?php wp_body_open(); ?>

<!-- Noise texture -->
<div class="noise-overlay" aria-hidden="true"></div>

<!-- Header -->
<header class="site-header">
  <div class="site-header__inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo" aria-label="Gastrototem — Inicio">
      <img src="<?php echo esc_url(gt_logo_url('white')); ?>" alt="Gastrototem" width="170" height="34">
    </a>
    <button class="nav-toggle" aria-label="Abrir menú" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
    <nav>
      <ul class="site-nav" role="list">
        <li><a href="<?php echo esc_url(home_url('/afinacion/')); ?>">Afinación</a></li>
        <li><a href="<?php echo esc_url(home_url('/criterio/')); ?>">Criterio</a></li>
        <li><a href="<?php echo esc_url(home_url('/nosotros/')); ?>">Nosotros</a></li>
        <li><a href="<?php echo esc_url(home_url('/contacto/')); ?>">Contacto</a></li>
        <li><a href="<?php echo esc_url(home_url('/afinacion/reservar/')); ?>" class="site-nav__cta">Reservar sesión</a></li>
      </ul>
    </nav>
  </div>
</header>
