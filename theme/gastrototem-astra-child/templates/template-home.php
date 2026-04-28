<?php
/**
 * Template Name: Gastrototem — Home
 */
get_template_part('parts/header');
?>

<section class="hero" id="hero">
  <div class="container hero__content">
    <p class="hero__label reveal">Gastrototem</p>
    <h1 class="hero__title reveal reveal-delay-1">
      Crítica gastronómica<br>que <em>afina restaurantes.</em>
    </h1>
    <p class="hero__subtitle reveal reveal-delay-2">
      No somos consultores. No somos agencia. Somos una firma de crítica especializada que entra en tu restaurante como cualquier cliente y te dice exactamente lo que necesitas oír.
    </p>
    <a href="<?php echo esc_url(home_url('/afinacion/')); ?>" class="hero__cta reveal reveal-delay-3">
      Conocer la Sesión de Afinación
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
  <a href="#manifiesto" class="hero__scroll" aria-label="Seguir leyendo">
    <span>Scroll</span>
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
  </a>
</section>

<section class="section" id="manifiesto">
  <div class="container">
    <p class="section__label reveal">El manifiesto</p>
    <h2 class="section__title reveal reveal-delay-1">La verdad no se vende.<br>Se dice cuando el criterio lo justifica.</h2>
    <div class="manifiesto">
      <div class="manifiesto__text reveal reveal-delay-2">
        <p>Un restaurante puede tener una cocina brillante y estar perdiendo clientes en la sala. Puede tener un servicio impecable y una carta que no cuenta nada. Los puntos ciegos no aparecen en la cuenta de resultados hasta que ya es tarde.</p>
        <p>Gastrototem nace para decir lo que nadie dice: lo que falla cuando todo parece funcionar. Con criterio profesional, sin dependencia, sin interés en agradar. Solo la verdad fundamentada de quienes llevan años evaluando restaurantes desde la mesa.</p>
      </div>
      <div class="manifiesto__aside reveal reveal-delay-3">
        <p class="manifiesto__quote">La visibilidad no se vende, se otorga cuando el criterio lo justifica.</p>
        <p class="manifiesto__attr">Principio fundacional</p>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark" id="servicio">
  <div class="container">
    <p class="section__label reveal">Qué hacemos</p>
    <h2 class="section__title reveal reveal-delay-1">La Sesión de Afinación.</h2>
    <p class="section__intro reveal reveal-delay-2">
      Un servicio cerrado, un día. Visita de incógnito como clientes reales, reunión inmediata con la propiedad y un informe profesional en 48 horas. 1.000 EUR + IVA.
    </p>
    <div class="servicio-grid">
      <div class="servicio-card reveal">
        <div class="servicio-card__number">01</div>
        <h3 class="servicio-card__title">Visita de incógnito</h3>
        <p class="servicio-card__text">Reservamos como cualquier cliente. Llegamos sin aviso. Vivimos tu restaurante exactamente como lo vive quien no te conoce.</p>
      </div>
      <div class="servicio-card reveal reveal-delay-1">
        <div class="servicio-card__number">02</div>
        <h3 class="servicio-card__title">Reunión inmediata</h3>
        <p class="servicio-card__text">Ese mismo día nos sentamos contigo. Sin filtros, sin rodeos. Te contamos lo que hemos visto, oído, comido y sentido.</p>
      </div>
      <div class="servicio-card reveal reveal-delay-2">
        <div class="servicio-card__number">03</div>
        <h3 class="servicio-card__title">Informe en 48h</h3>
        <p class="servicio-card__text">Un documento profesional con observaciones, juicio y acciones concretas priorizadas. Cada línea habla de tu restaurante.</p>
      </div>
    </div>
  </div>
</section>

<section class="section section--warm" id="principios">
  <div class="container">
    <p class="section__label reveal">Así trabajamos</p>
    <h2 class="section__title reveal reveal-delay-1">Cuatro principios.<br>Sin excepción.</h2>
    <div class="principios-grid">
      <div class="principio reveal">
        <div class="principio__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        </div>
        <h3 class="principio__title">Independencia absoluta</h3>
        <p class="principio__text">Nuestro criterio no se negocia. No tenemos acuerdos comerciales con proveedores, no vendemos visibilidad. Si lo decimos, es porque lo pensamos.</p>
      </div>
      <div class="principio reveal reveal-delay-1">
        <div class="principio__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
        </div>
        <h3 class="principio__title">Criterio fundamentado</h3>
        <p class="principio__text">No opinamos: evaluamos. Cada observación del informe tiene base profesional, contexto y una acción concreta con indicador de prioridad.</p>
      </div>
      <div class="principio reveal reveal-delay-2">
        <div class="principio__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <h3 class="principio__title">Sin agencia, sin gestión</h3>
        <p class="principio__text">No gestionamos redes, no hacemos auditorías financieras, no diseñamos cartas. Hacemos una cosa y la hacemos bien: decir la verdad sobre tu restaurante.</p>
      </div>
      <div class="principio reveal reveal-delay-3">
        <div class="principio__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h3 class="principio__title">Todo nace del trabajo real</h3>
        <p class="principio__text">Cada pieza de contenido, cada opinión pública, cada recomendación sale de una experiencia vivida. No fabricamos criterio: lo ejercemos en cada mesa.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" id="cifras">
  <div class="container">
    <p class="section__label reveal" style="justify-content: center;">En números</p>
    <div class="cifras">
      <div class="reveal">
        <div class="cifra__number">4</div>
        <div class="cifra__label">Áreas de evaluación</div>
      </div>
      <div class="reveal reveal-delay-1">
        <div class="cifra__number">1</div>
        <div class="cifra__label">Día de trabajo</div>
      </div>
      <div class="reveal reveal-delay-2">
        <div class="cifra__number">48h</div>
        <div class="cifra__label">Informe entregado</div>
      </div>
      <div class="reveal reveal-delay-3">
        <div class="cifra__number">30d</div>
        <div class="cifra__label">Seguimiento incluido</div>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark" id="equipo">
  <div class="container">
    <p class="section__label reveal">Quiénes somos</p>
    <h2 class="section__title reveal reveal-delay-1">Dos miradas.<br>Un criterio.</h2>
    <p class="section__intro reveal reveal-delay-2">
      Gastrototem es Fernando Huidobro y Juanma Agrela. Socios, críticos gastronómicos, con años de trayectoria evaluando restaurantes en Sevilla y más allá. No delegamos en colaboradores externos.
    </p>
    <div class="equipo-layout">
      <div class="persona reveal reveal-delay-2">
        <h3 class="persona__name">Fernando Huidobro</h3>
        <p class="persona__role">Socio fundador</p>
        <p class="persona__bio">Crítico gastronómico con trayectoria contrastada. Su mirada se centra en la precisión técnica, la coherencia de la propuesta y el rigor del producto.</p>
      </div>
      <div class="persona reveal reveal-delay-3">
        <h3 class="persona__name">Juanma Agrela</h3>
        <p class="persona__role">Socio fundador</p>
        <p class="persona__bio">Formado en comunicación y narrativa gastronómica. Evalúa la experiencia global, la sala, la atmósfera y la coherencia entre lo que un restaurante dice ser y lo que realmente es.</p>
      </div>
    </div>
  </div>
</section>

<section class="section section--warm">
  <div class="container cta-section">
    <p class="section__label reveal" style="justify-content: center;">Siguiente paso</p>
    <h2 class="cta-section__title reveal reveal-delay-1">Tu restaurante<br>merece una opinión<br>que no busque agradarte.</h2>
    <p class="cta-section__subtitle reveal reveal-delay-2">1.000 EUR + IVA &middot; Un día &middot; Informe en 48h</p>
    <a href="<?php echo esc_url(home_url('/afinacion/')); ?>" class="cta-section__btn reveal reveal-delay-3">
      Conocer la Sesión de Afinación
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
</section>

<?php get_template_part('parts/footer'); ?>
