# Handoff · Gastrototem web (WordPress) · shell + páginas-documento + header Lovable

> Documento autocontenido. Pégalo entero al abrir la conversación nueva. Resume el estado real del trabajo sobre la web pública en WordPress y cómo seguir. **Las fuentes de verdad (MARCA.md, CONTRACT.md, CLAUDE.md) mandan sobre cualquier recuerdo.** Donde este handoff diga "verificar contra código", se hace antes de construir.

---

## 0. Cómo trabajamos (guardarraíles)

**Decisión y ritmo**
- **Una decisión a la vez**, propuestas propositivas (borradores a los que Juanma reacciona), nunca cuestionarios abiertos. Afirmaciones breves ("dale", "dale caña", "sí", "ok") cierran decisiones; no se re-resume lo ya cerrado.
- **Recomendaciones explícitas, no menús de opciones.** Claude decide diseño/arquitectura/marca; Juanma reacciona.
- **`MARCA.md` es ley** por encima de Lovable, del código del tema y de los defaults de herramientas.
- **Respetar los diseños ya aprobados.** Lo aprobado en Lovable es decisión tomada. No se reabre ni se reetiqueta como "opcional" por conveniencia técnica. Si WP no encaja con el diseño aprobado, se reconfigura WP para servir el diseño (p. ej. ocultar el título nativo y rearmarlo), no se simplifica el diseño.

**Autonomía (recalibrado esta sesión — importante)**
- **Prompts amplios a CC y pocas idas y vueltas.** Para trabajo local y reversible (construir CSS/PHP/JS en la rama, commits atómicos) y para **deploys a STAGING**, CC actúa **del tirón** con la guarda de seguridad incluida. No se para a enseñar cada paso.
- **Juanma NO relayea cada "todo verde".** Si una ejecución sale limpia, sigue. Vuelve a Claude solo cuando hay **una decisión, un problema o una duda de diseño/marca**.
- **Gates que SÍ se mantienen (irreversibles):** deploy (dry-run + guarda), **nunca push a `main`**, **nunca tocar producción**, nada de cuentas/pagos. Claude sigue metiendo guardas *verify-first* en cada prompt para no depender de haber visto cada reporte.
- **Sin puente directo Claude.ai ↔ CC.** Claude (capa de arquitectura/diseño) corre en un entorno aislado y sin red: no llega al repo, terminal ni staging. CC ejecuta en la máquina de Juanma. El único puente es Juanma pegando. Claude no puede dar órdenes a CC directamente.
- Juanma no es ingeniero: micro-pasos atómicos para sus acciones, sin intermedios asumidos.

**Prompts a CC**
- Contexto inyectado entre marcadores `▼`/`▲` (CC no ve el chat de arquitectura).
- Guardas verify-first ("verifica X; si se cumple haz Y; si no, para y avisa"), condiciones de parada explícitas.
- **Commits atómicos por concepto**; `git add` SOLO de los archivos tocados. Nunca arrastrar el untracked ajeno (`docs/`, `gastrototem-app/`, `midjourney/`, `versions/`).

---

## 1. Repositorio y stack

- Repo: `/Users/jmagrela/gastrototem`. Tema clásico PHP standalone en `theme/gastrototem` (NO Astra, NO child theme).
- Rama de trabajo: **`feature/cimientos-finos`** (local, **sin pushear, sin mergear**).
- **HEAD actual: `d6045b8`.** (Ejecutar `git log --oneline` al abrir para ver la cadena exacta; este handoff lista hitos, no todos los hashes.)
- Referencia de diseño: repo Lovable clonado **solo lectura** en `/Users/jmagrela/gastrototem-afinacion-editorial`. Es referencia, **no se porta a producción**. Ojo: Lovable usa **Newsreader** italic como serif y kicker a **0.08em**; el tema usa **Source Serif 4 Italic** y **0.18em** (`--gtt-tracking-wide`) — gana el tema.
- Plugin `gastrototem-booking` v2.4.0 en staging; namespace REST `gastrototem/v1`.
- **CC no tiene PHP** en su máquina: un error de sintaxis PHP saldría primero en el **deploy a staging**, nunca en producción → staging-first importa.

---

## 2. Fuentes de verdad

- **`docs/MARCA.md`** — ley. Lecturas clave hechas esta sesión:
  - Tipografía §4.1 nombra **solo Inter + Source Serif 4 Italic**. Pero el tema (y Lovable) usan **JetBrains Mono** como tercera pila (kickers/etiquetas/datos), presente en `tokens.css`, footer y banda. → **Hueco de documentación, no error.** Recomendación pendiente: cerrar con una **MARCA v1.1** que añada JetBrains Mono como tercera familia. **Decisión del custodio (Juanma).**
  - Colores: tinta `#1F3050` (firma/fondos institucionales/acento-de-palabra, **nunca como texto sobre oscuro**), papel `#EFEAE0` (sustituye al blanco), grafito `#1A1A22` (texto). Nunca blanco puro ni negro puro.
  - Header inamovible «GASTROTOTEM · ANDALUCÍA» → vive en **kicker del hero y footer**, NO en la barra de navegación.
- `CONTRACT.md`, `CLAUDE.md` — en el proyecto.
- SVGs oficiales en `theme/gastrototem/assets/brand/`.

---

## 3. deploy.sh y caché (IMPORTANTE)

- `rsync` del working tree de **`theme/gastrototem/`**; sube lo que haya físicamente en disco (no depende de push).
- **Por defecto → STAGING** (`.../public_html/2026/wp-content/themes/gastrototem/`, la carpeta **`/2026/`**). Producción solo con `./deploy.sh production` (sin `/2026/`). Mismo host/usuario/puerto: solo cambia la ruta.
- `rsync -avz --delete`: borra en destino lo que no exista en local (irreversible en remoto, dentro del dir del tema). NO toca BD, ni caché, ni assets de sitio.
- **Guarda estándar antes de cualquier deploy real:** `./deploy.sh --dry-run`, comprobar que el destino contiene **`/2026/`** y que hay **cero líneas `deleting`**. Si falla cualquiera → parar.
- **Lección de caché LiteSpeed (recurrente):** tras desplegar plantillas/estructura nuevas del tema, la lista `page_templates` puede quedar **obsoleta en el object cache de LiteSpeed** (CLI no ve ese caché → CLI y web discrepan). Síntoma: WP ignora una plantilla válida y cae a `page.php` (`page-template-default`, sin banda, `data-gtt-context="flat"`). **Arreglo: `wp litespeed-purge all`** (el subcomando `litespeed-purge object` **no existe** en esta versión; `all` lo cubre) o el botón **Purge All** del plugin en `wp-admin`. **Purgar siempre tras un deploy de tema.** Propuesta abierta: añadir la purga al final de `deploy.sh`.

---

## 4. Sistema tipográfico real del tema (tokens.css)

- Tres pilas: `--gtt-font-sans` (Inter), `--gtt-font-serif` (Source Serif 4 Italic), `--gtt-font-mono` (JetBrains Mono 400/500).
- Tamaños: `xs` .75 · `sm` .875 · `base` 1.0625 (17px) · `lg` 1.25 (20) · `xl` 1.5 (24) · `2xl` clamp 28–32 · `3xl` clamp 36–48 · `4xl` clamp 44–72 · **`prose` 1.1875 (19px)** *(añadido esta sesión)*.
- Line-heights: `tight` 1.15 · `snug` 1.35 · `normal` 1.55 · `relaxed` 1.7 · **`prose` 1.6** *(añadido)*.
- Tracking: `--gtt-tracking-wide` 0.18em.
- Espaciado: 1=4 · 2=8 · 3=12 · 4=16 · 6=24 · 8=32 · 12=48 · 16=64 · 24=96 · 32=128.
- Contenedores: `--gtt-container-content` 64rem (1024px) · `--gtt-container-prose` 38rem (608px, medida de lectura).
- Stops útiles: grafito-200 `#C9C4B8` (regla fina), grafito-500 `#3F3D38` (texto soft/kicker), grafito-900 `#1A1A22` (texto), tinta-500 `#1F3050`, papel-100 `#EFEAE0`.
- Convención blindada: **cero hex y cero `font-family` literales** fuera de `tokens.css`; todo por variables.

---

## 5. Qué está construido y validado

**Shell** (header + splash + footer) — verificado en staging.

**Header — cerebro (Pieza 2) + alineación a Lovable**
- Observer transparente↔sólida: `IntersectionObserver` sobre `[data-gtt-sentinel]`, `rootMargin` superior = −`offsetHeight` del header (se recrea en `resize`), conmuta leyendo `data-gtt-context` (`document`/`home`/`404`/`flat`).
- Piel inicial **síncrona sin flash** vía `<script>` inline en `header.php` que lee `data-gtt-context`. Base sólida = fallback sin JS.
- Lógica de cruce robusta (usa `boundingClientRect.top <= offsetHeight`, aguanta bandas más altas que el viewport).
- **⚠️ AJUSTE NUEVO (hecho por Juanma+CC, alineado a Lovable, HEAD `d6045b8`):** el header ahora tiene **auto-hide sobre la banda** y movimiento alineado a Lovable, y **cambian las variantes de logo por piel**: **logo grafito en piel sólida**, **logo invertido (papel) sobre la banda tinta**.
  - **Esto SUPERSEDE la convención antigua** de las notas/memoria (que decía: sólida = variante principal tinta/papel; transparente = variante línea). **No actuar según esa memoria vieja.** La nueva sesión debe **verificar el comportamiento y variantes reales contra el código** (`assets/css/components/header.css`, `assets/js/components/header.js`, `template-parts/header-main.php`) antes de tocar el header.
- `data-gtt-context="404"` se emite pero **el 404 NO se fuerza transparente todavía**: va acoplado a su campo tinta (100vh), aún no construido. La rama JS del 404 hace `return` temprano hasta entonces.

**Splash** — overlay papel a pantalla completa, lockup vertical, solo home, una vez por sesión, no-flash, aparición instantánea → reposo → fade-out (sin fade-in). Validado.

**Páginas-documento** (plantilla `template-documento.php` + `documento.css` + enqueue condicional `is_page_template('template-documento.php')`)
- **Banda de apertura definitiva** (diseño aprobado Lovable + MARCA):
  - **Kicker** mono (JetBrains, 500, uppercase, `--gtt-tracking-wide`, ~12px, papel-100) ← `the_title()`.
  - **Título h1** Inter 600, `--gtt-text-4xl`, lh 1.05, papel-100 ← meta **`_gtt_titular`**.
  - **Subtítulo** Inter ~20px papel-100 ~80% ← `the_excerpt()` (solo `has_excerpt()`).
  - **Fallback:** si `_gtt_titular` vacío → h1 = `the_title()` y se oculta el kicker (no duplican).
  - Fondo tinta-500 a sangre, pt140/pb96, `[data-gtt-sentinel]` como último hijo (lo necesita el observer — preservar siempre).
  - Meta box **«Titular de la banda»** en `inc/meta-titular.php` (post_type `page`, nonce + `current_user_can` + `sanitize_text_field`).
- **Cuerpo de prosa** `.gtt-doc-prose` (envuelve `the_content()`):
  - Medida `--gtt-container-prose` (38rem), alineada a la izquierda bajo la banda.
  - Párrafo Inter 400, `--gtt-text-prose` (19px) / `--gtt-leading-prose` (1.6), grafito-900.
  - h2 `--gtt-text-2xl` / h3 `--gtt-text-xl`, Inter 600, grafito-900.
  - Enlaces tinta-500 sin subrayado; subrayado en hover con offset 3px.
  - Listas ul/ol estándar; `code` inline en mono.
  - **Cita/pull-quote** = `blockquote` en Source Serif 4 Italic 400, clamp 1.75–2.75rem, lh 1.25, grafito-900, con regla corta 48×1px grafito-200 (`::before`) y atribución (`cite`) en kicker mono. Es el momento serif italic de MARCA.

**Hitos de commit conocidos (orden):** `ad124db` (fix splash) → `0cc7678` (plantilla documento + sentinel) → `ca8f77d` (cerebro observer) → `7b2faf3` (hover toggle por piel) → `deefd70` (banda definitiva) → cuerpo de prosa → `c61e201` (un fix de header) → … alineación de header a Lovable → **HEAD `d6045b8`**. Verificar la cadena exacta con `git log`.

**Contenido de prueba en staging** (sembrado por CC vía WP-CLis): páginas-documento `afinacion` (10), `criterio` (12), `nosotros` (14), `contacto` (24) con plantilla Documento + lorem; página plana de control `pagina-plana` (63). `mi-cuenta` (32) y `reservar` (29) intactas (funcionales). **Es relleno de prueba, NO copy definitivo.**

---

## 6. Cabos sueltos / parkings

- **MARCA v1.1**: añadir JetBrains Mono como tercera familia. Decisión del custodio (Juanma).
- **Limpiar la página/contenido de prueba** antes de acercarse a producción (Juanma lo señaló al cerrar). El copy real es tarea aparte.
- **404**: construir el campo tinta (100vh) y entonces activar la rama de header forzado-transparente (el contexto ya se emite).
- **Footer**: verificar que el kicker «GASTROTOTEM · ANDALUCÍA» está donde debe (en una captura se veía "Andalucía · España" bajo contacto — confirmar).
- **Slug**: tema `/nosotros` vs Lovable `/sobre-nosotros`. Housekeeping de Fase 3. Las páginas de prueba se sembraron con los slugs del menú real.
- **Auto-purga en `deploy.sh`** tras deploys de tema (lección LiteSpeed).
- Deuda Prettier (`project_debt_prettier_wide`).
- La PWA `sesion.gastrototem.com` es **otro proyecto** (otra conversación); no se toca aquí.

---

## 7. Siguiente paso (para la conversación nueva)

1. **Verificar estado** (solo lectura, con CC): `git log --oneline` desde `d6045b8`, y leer el header real (`header.css` / `header.js` / `header-main.php`) para entender el **auto-hide + variantes de logo por piel** actuales — **contra el código, no contra memoria vieja**.
2. **Elegir bloque** (proponer a Juanma; el plan es shell → páginas-documento → home/hero, lo último):
   - **Home / hero**: el hero es la banda de apertura de la home; al montarle su `[data-gtt-sentinel]` heredará el observer (transparente sobre el hero). Comprobar cuánto del "hide-on-hero" ya cubre el auto-hide nuevo.
   - o **404 tinta** (campo 100vh + activar la rama de header).
   - o **pulido de páginas-documento** / **footer**.
3. Construir del tirón (prompt amplio): build + commit atómico + deploy a staging **con purga** + verificación curl. Field-test de Juanma solo si hay algo visual que dude.

---

*Fin del handoff. Rama `feature/cimientos-finos`, HEAD `d6045b8`, sin push, producción intocable.*
