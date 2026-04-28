<?php
/**
 * Template Name: Gastrototem — Contacto
 */
get_template_part('parts/header');
?>


<!-- PAGE HEADER -->
<section class="page-header">
  <div class="container">
    <p class="page-header__label reveal">Contacto</p>
    <h1 class="page-header__title reveal reveal-delay-1">Hablemos<br><em>sin rodeos.</em></h1>
    <p class="page-header__intro reveal reveal-delay-2">
      Si tienes un restaurante y quieres saber lo que realmente necesitas oir, escribenos. Sin compromiso, sin formularios eternos.
    </p>
  </div>
</section>

<!-- CONTACT -->
<section class="contact-section">
  <div class="container">
    <div class="contact-layout">
      <!-- FORM -->
      <div class="reveal">
        <form class="contact-form" action="#" method="post">
          <div class="form-group">
            <input type="text" id="nombre" name="nombre" placeholder=" " required>
            <label for="nombre">Nombre</label>
          </div>
          <div class="form-group">
            <input type="email" id="email" name="email" placeholder=" " required>
            <label for="email">Email</label>
          </div>
          <div class="form-group">
            <input type="text" id="restaurante" name="restaurante" placeholder=" ">
            <label for="restaurante">Restaurante (opcional)</label>
          </div>
          <div class="form-group">
            <input type="text" id="ciudad" name="ciudad" placeholder=" ">
            <label for="ciudad">Ciudad</label>
          </div>
          <div class="form-group">
            <select id="asunto" name="asunto" required>
              <option value="" disabled selected></option>
              <option value="afinación">Quiero reservar una Sesión de Afinación</option>
              <option value="información">Quiero más información</option>
              <option value="prensa">Prensa / colaboración</option>
              <option value="otro">Otro</option>
            </select>
            <label for="asunto">Asunto</label>
          </div>
          <div class="form-group">
            <textarea id="mensaje" name="mensaje" placeholder=" " rows="4" required></textarea>
            <label for="mensaje">Mensaje</label>
          </div>
          <button type="submit" class="form-submit">
            Enviar mensaje
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </button>
        </form>
      </div>

      <!-- INFO -->
      <div class="reveal reveal-delay-2">
        <div class="contact-info__group">
          <p class="contact-info__label">Email</p>
          <p class="contact-info__value"><a href="mailto:hola@gastrototem.com">hola@gastrototem.com</a></p>
        </div>
        <div class="contact-info__group">
          <p class="contact-info__label">Redes</p>
          <p class="contact-info__value">
            <a href="https://instagram.com/gastrototem" target="_blank" rel="noopener">Instagram @gastrototem</a><br>
            <a href="https://linkedin.com/company/gastrototem" target="_blank" rel="noopener">LinkedIn</a>
          </p>
        </div>
        <div class="contact-info__group">
          <p class="contact-info__label">Base</p>
          <p class="contact-info__value">Sevilla, España<br>Sesiones en toda la península</p>
        </div>
        <div class="contact-info__group">
          <p class="contact-info__label">Tiempo de respuesta</p>
          <p class="contact-info__value">Respondemos en menos de 24 horas laborables</p>
        </div>

        <div class="booking-callout">
          <h3 class="booking-callout__title">Reservar directamente</h3>
          <p class="booking-callout__text">Si ya sabes que quieres una Sesión de Afinación, puedes reservar directamente sin pasar por el formulario.</p>
          <a href="<?php echo esc_url(home_url('/afinacion/reservar/')); ?>" class="booking-callout__link">
            Ir a reserva
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ MINI -->
<section class="faq-mini">
  <div class="container">
    <h2 class="faq-mini__title reveal">Antes de escribir</h2>
    <div class="faq-mini__item reveal">
      <p class="faq-mini__q">¿Trabajáis fuera de Sevilla?</p>
      <p class="faq-mini__a">Sí. Realizamos sesiones en toda España. Los desplazamientos fuera de Sevilla pueden implicar gastos adicionales de transporte y alojamiento, que se presupuestan por adelantado.</p>
    </div>
    <div class="faq-mini__item reveal reveal-delay-1">
      <p class="faq-mini__q">¿Cuánto cuesta?</p>
      <p class="faq-mini__a">La Sesión de Afinación tiene un precio cerrado de 1.000 EUR + IVA. Incluye visita de incógnito, reunión inmediata, informe profesional en 48h y llamada de control a 30 dias.</p>
    </div>
    <div class="faq-mini__item reveal reveal-delay-2">
      <p class="faq-mini__q">¿Hacéis consultoría, gestión de redes o diseño de cartas?</p>
      <p class="faq-mini__a">No. Hacemos una sola cosa: evaluar tu restaurante con criterio profesional y entregarte un díagnóstico honesto. No somos agencia.</p>
    </div>
  </div>
</section>

<!-- FOOTER -->

<?php get_template_part('parts/footer'); ?>
