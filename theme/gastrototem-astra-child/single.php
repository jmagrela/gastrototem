<?php
/**
 * Gastrototem — Single post template
 *
 * Individual article page for /criterio/ posts.
 * Uses the same header/footer as custom page templates.
 */
get_template_part('parts/header');

the_post();
$cat = gt_post_primary_category();
$reading_time = gt_reading_time(get_the_content());
?>

<!-- ARTICLE HEADER -->
<section class="page-header page-header--article">
  <div class="container">
    <?php if ($cat) : ?>
      <p class="page-header__label reveal"><?php echo esc_html($cat->name); ?></p>
    <?php endif; ?>
    <h1 class="page-header__title reveal reveal-delay-1"><?php the_title(); ?></h1>
    <div class="article-meta reveal reveal-delay-2">
      <span class="article-meta__author"><?php the_author(); ?></span>
      <span class="article-meta__sep">&middot;</span>
      <time class="article-meta__date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('j M Y'); ?></time>
      <span class="article-meta__sep">&middot;</span>
      <span class="article-meta__reading"><?php echo esc_html($reading_time); ?> min lectura</span>
    </div>
  </div>
</section>

<!-- ARTICLE BODY -->
<article class="article-body">
  <div class="container">
    <div class="article-content reveal">
      <?php the_content(); ?>
    </div>
  </div>
</article>

<!-- ARTICLE FOOTER — navigation between posts -->
<nav class="article-nav">
  <div class="container">
    <div class="article-nav__inner">
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      ?>
      <?php if ($prev) : ?>
      <a href="<?php echo get_permalink($prev); ?>" class="article-nav__link article-nav__link--prev">
        <span class="article-nav__label">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          Anterior
        </span>
        <span class="article-nav__title"><?php echo esc_html($prev->post_title); ?></span>
      </a>
      <?php endif; ?>
      <?php if ($next) : ?>
      <a href="<?php echo get_permalink($next); ?>" class="article-nav__link article-nav__link--next">
        <span class="article-nav__label">
          Siguiente
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
        <span class="article-nav__title"><?php echo esc_html($next->post_title); ?></span>
      </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- NEWSLETTER -->
<section class="newsletter">
  <div class="container">
    <h2 class="newsletter__title reveal">Criterio en tu correo.<br>Una vez al mes.</h2>
    <p class="newsletter__text reveal reveal-delay-1">
      Sin spam, sin promociones. Solo una reflexión mensual sobre gastronomía, servicio y cultura de restaurante.
    </p>
    <form class="newsletter__form reveal reveal-delay-2" action="#" method="post">
      <input type="email" class="newsletter__input" placeholder="Tu email profesional" required aria-label="Email">
      <button type="submit" class="newsletter__btn">Suscribir</button>
    </form>
  </div>
</section>

<?php get_template_part('parts/footer'); ?>
