<?php
/**
 * Gastrototem — Footer partial
 * Shared across all custom page templates.
 */
?>

<!-- Footer -->
<footer class="site-footer">
  <div class="site-footer__inner">
    <div class="footer-brand">
      <img src="<?php echo esc_url(gt_logo_url('white')); ?>" alt="Gastrototem" width="140" height="28">
      <p class="footer-brand__desc">Crítica gastronómica que afina restaurantes. Sevilla.</p>
    </div>
    <div class="footer-col">
      <h4 class="footer-col__title">Navegar</h4>
      <ul class="footer-col__list">
        <li><a href="<?php echo esc_url(home_url('/')); ?>">Inicio</a></li>
        <li><a href="<?php echo esc_url(home_url('/afinacion/')); ?>">Afinación</a></li>
        <li><a href="<?php echo esc_url(home_url('/criterio/')); ?>">Criterio</a></li>
        <li><a href="<?php echo esc_url(home_url('/nosotros/')); ?>">Nosotros</a></li>
        <li><a href="<?php echo esc_url(home_url('/contacto/')); ?>">Contacto</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4 class="footer-col__title">Legal</h4>
      <ul class="footer-col__list">
        <li><a href="<?php echo esc_url(home_url('/aviso-legal/')); ?>">Aviso legal</a></li>
        <li><a href="<?php echo esc_url(home_url('/privacidad/')); ?>">Privacidad</a></li>
        <li><a href="<?php echo esc_url(home_url('/cookies/')); ?>">Cookies</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4 class="footer-col__title">Contacto</h4>
      <ul class="footer-col__list">
        <li><a href="mailto:hola@gastrototem.com">hola@gastrototem.com</a></li>
        <li><a href="https://instagram.com/gastrototem" target="_blank" rel="noopener">Instagram</a></li>
        <li><a href="https://linkedin.com/company/gastrototem" target="_blank" rel="noopener">LinkedIn</a></li>
      </ul>
    </div>
  </div>
  <div class="site-footer__bottom">
    <span>&copy; <?php echo date('Y'); ?> Gastrototem S.L. &mdash; B90123514</span>
    <div class="footer-social">
      <a href="https://instagram.com/gastrototem" target="_blank" rel="noopener" aria-label="Instagram">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg>
      </a>
      <a href="https://linkedin.com/company/gastrototem" target="_blank" rel="noopener" aria-label="LinkedIn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-4 0v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
      </a>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
