<?php
/**
 * Template Name: Gastrototem — Criterio
 *
 * Dynamic blog listing page. Pulls published posts from WordPress.
 * The latest post appears as featured; the rest in a grid.
 */
get_template_part('parts/header');

// Pagination
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>

<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <p class="page-header__label reveal">Criterio</p>
    <h1 class="page-header__title reveal reveal-delay-1">Lo que pensamos<br>sobre <em>gastronomía.</em></h1>
    <p class="page-header__intro reveal reveal-delay-2">
      Opinión fundamentada sobre cocina, sala, servicio y cultura de restaurante. Sin condescendencia, sin autobombo. Todo lo que publicamos nace del trabajo real.
    </p>
  </div>
</section>

<?php
// --- FEATURED POST (latest post, only on page 1) ---
if ($paged === 1) :
    $featured = new WP_Query([
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ]);

    if ($featured->have_posts()) : $featured->the_post();
        $cat = gt_post_primary_category();
        $reading_time = gt_reading_time(get_the_content());
?>
<section class="featured">
  <div class="container">
    <div class="featured-layout">
      <div class="reveal">
        <?php if ($cat) : ?>
          <p class="featured__category"><?php echo esc_html($cat->name); ?></p>
        <?php endif; ?>
        <h2 class="featured__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="featured__excerpt">
          <?php echo esc_html(wp_trim_words(get_the_excerpt(), 40, '…')); ?>
        </p>
        <a href="<?php the_permalink(); ?>" class="featured__link">
          Leer artículo
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="featured__visual reveal reveal-delay-2">
        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('large'); ?>
        <?php else : ?>
          &laquo; &raquo;
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php
    endif;
    wp_reset_postdata();
endif;
?>

<!-- BLOG GRID -->
<?php
$offset = ($paged === 1) ? 1 : 0; // skip featured post on page 1
$grid = new WP_Query([
    'posts_per_page' => 6,
    'paged'          => $paged,
    'offset'         => $offset,
    'post_status'    => 'publish',
]);

if ($grid->have_posts()) :
?>
<section class="blog-section">
  <div class="container">
    <div class="blog-grid">
      <?php
      $i = 0;
      while ($grid->have_posts()) : $grid->the_post();
          $cat = gt_post_primary_category();
          $reading_time = gt_reading_time(get_the_content());
          $delay_class = ($i % 2 === 1) ? ' reveal-delay-1' : '';
          $i++;
      ?>
      <article class="blog-card reveal<?php echo $delay_class; ?>">
        <?php if ($cat) : ?>
          <p class="blog-card__category"><?php echo esc_html($cat->name); ?></p>
        <?php endif; ?>
        <h3 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="blog-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 25, '…')); ?></p>
        <div class="blog-card__meta">
          <span><?php the_author(); ?></span>
          <span><?php echo esc_html($reading_time); ?> min lectura</span>
        </div>
      </article>
      <?php endwhile; ?>
    </div>

    <?php // Pagination
    $total_pages = $grid->max_num_pages;
    if ($total_pages > 1) : ?>
    <nav class="blog-pagination" aria-label="Paginación del blog">
      <?php
      echo paginate_links([
          'total'     => $total_pages,
          'current'   => $paged,
          'prev_text' => '&larr; Anterior',
          'next_text' => 'Siguiente &rarr;',
      ]);
      ?>
    </nav>
    <?php endif; ?>
  </div>
</section>
<?php
endif;
wp_reset_postdata();
?>

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
