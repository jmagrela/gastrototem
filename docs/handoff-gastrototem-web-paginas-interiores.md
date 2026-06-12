# Handoff · Gastrototem web (WordPress) · home completa → páginas interiores

> Documento autocontenido. Pégalo entero al abrir la conversación nueva. Resume el estado real de la web pública y cómo seguir. **Las fuentes de verdad (MARCA.md, CONTRACT.md, CLAUDE.md) mandan sobre cualquier recuerdo.** Donde diga «verificar contra código», se hace antes de construir. CC tiene el contexto limpio (clear hecho): no recuerda nada de la sesión anterior; todo lo que necesite va inyectado en los prompts.

---

## 0. Cómo trabajamos (guardarraíles)

**Ritmo (RECALIBRADO esta sesión — manda sobre la nota antigua de «bloque a bloque»)**
- **Prompts LARGOS a CC que abarquen MUCHO trabajo en una sola pasada.** Avanzar ágilmente y **revisar concienzudamente DESPUÉS**, sobre lo construido, en vez de fraccionar en piezas pequeñas o validar con checkpoints intermedios.
- **El desarrollo de conjuntos de páginas se plantea en una sola pasada.** (Aplicado ya a las páginas interiores: ver §7.)
- Lo que NO cambia: las **decisiones de diseño/marca van una a una** (Claude propone borradores propositivos, Juanma reacciona; afirmaciones «dale / dale caña / sí / venga» cierran y se procede sin re-resumir). Lo que insulta a Juanma es repetir lo mismo dos veces, no el ritmo.
- **KILL CRITIC**: recomendación comprometida, no menú equidistante.

**Regla de parada de CC (para no frenar a mitad de un bloque grande)**
- Correcciones de marca con solución obvia (PDF→informe, color fuera de paleta a su token, palabra vetada con sustituto claro): **aplícalas y anótalas, sigue**.
- Lo dudoso o de criterio de custodio sin corrección clara: déjalo con marcador visible `[REVISAR-MARCA: …]` en el copy y **sigue**.
- Vuelve a mitad SOLO si un error técnico bloquea build o deploy.
- Reporta al final: (a) correcciones aplicadas, (b) marcadores `[REVISAR-MARCA]`.

**Gates irreversibles que SÍ se mantienen**
- Deploy: `./deploy.sh --dry-run`, el destino debe contener **`/2026/`** y **cero líneas `deleting`**; si falla cualquiera, parar.
- **Nunca push a `main`. Nunca tocar producción.** Nada de cuentas/pagos.

**Mecánica**
- Sin puente Claude.ai ↔ CC. Claude corre aislado y sin red (no llega a repo/terminal/staging). El único puente es Juanma pegando.
- Juanma no es ingeniero: micro-pasos atómicos para SUS acciones; si falta un dato del entorno, pedir ese dato concreto.
- Prompts a CC: contexto entre marcadores `▼`/`▲` (CC no ve el chat); guardas verify-first («verifica X; si se cumple haz Y; si no, para y avisa»); **commits atómicos por concepto**; `git add` SOLO de lo tocado, **nunca** arrastrar untracked ajeno (`docs/`, `gastrototem-app/`, `midjourney/`, `versions/`).
- Working language: **español**.

---

## 1. Repositorio y stack

- Repo: `/Users/jmagrela/gastrototem`. Tema clásico PHP standalone en `theme/gastrototem` (NO Astra, NO child theme).
- Rama: **`feature/cimientos-finos`** (local, **sin pushear, sin mergear**).
- **HEAD: a verificar con `git log --oneline` al abrir** (ver §5: la última tanda quedó lanzada pero su ejecución no está confirmada por reporte).
- Referencia de diseño: repo Lovable clonado **solo lectura** en `/Users/jmagrela/gastrototem-afinacion-editorial`. Referencia, no se porta literal.
- Plugin `gastrototem-booking` v2.4.0 en staging; namespace REST `gastrototem/v1`.
- CC no tiene PHP en su máquina: un error de sintaxis PHP saldría en el deploy a staging, nunca en producción → staging-first importa.

---

## 2. Fuentes de verdad

- **`docs/MARCA.md`** — ley sobre Lovable, el código del tema y los defaults de herramientas. CC lo lee al abrir sesión.
- `CONTRACT.md`, `CLAUDE.md` — en el proyecto.
- SVGs oficiales en `theme/gastrototem/assets/brand/`.
- Recordatorios de marca clave para web: header inamovible **«GASTROTOTEM · ANDALUCÍA»** (sin otros topónimos, sin «España»); colores tinta `#1F3050` / papel `#EFEAE0` / grafito `#1A1A22`; **tinta nunca como texto sobre fondo oscuro** (§3.3) → sobre oscuro, acentos en **Source Serif 4 Italic papel**; logo siempre SVG vector (nunca `font-family`); `#1d1d1b` → `#1A1A22`.

---

## 3. deploy.sh y caché

- `rsync` del working tree de `theme/gastrototem/` (sube lo que haya en disco; no depende de push).
- Por defecto → **STAGING**. La RUTA de deploy en el servidor contiene **`/2026/`** (guarda del dry-run). Ojo: la **URL pública** de staging es el subdominio **`https://2026.gastrototem.com/`** (la ruta `gastrototem.com/2026/` da 404). No confundir la guarda de ruta con la URL de verificación.
- Producción solo con `./deploy.sh production` (sin `/2026/`). **Intocable** hasta terminar.
- **LiteSpeed**: tras desplegar plantillas/estructura nuevas del tema, **`wp litespeed-purge all`** (o «Purge All» en wp-admin). Purgar siempre tras deploy de tema. *Parking:* añadir la purga al final de `deploy.sh`.

---

## 4. Sistema tipográfico del tema (tokens.css)

- Tres pilas: `--gtt-font-sans` (Inter), `--gtt-font-serif` (Source Serif 4 Italic, solo acentos/citas), `--gtt-font-mono` (JetBrains Mono, kickers/datos).
- Tamaños incl. `prose` 1.1875 (19px) y `4xl` clamp 44–72 (H1). Contenedores: `content` 64rem, `prose` 38rem.
- Tracking ancho `--gtt-tracking-wide` 0.18em.
- Stops útiles: grafito-200 `#C9C4B8`, grafito-500/600, grafito-900 `#1A1A22`, tinta-500 `#1F3050`, papel-100 `#EFEAE0`.
- **Convención blindada: cero hex y cero `font-family` literales fuera de `tokens.css`; todo por `var(--gtt-*)`.**

---

## 5. Qué está construido (web)

**Shell** (header + splash + footer) — verificado en staging.
- **Header**: cerebro `IntersectionObserver` sobre `[data-gtt-sentinel]`; piel sólida↔transparente por `data-gtt-context` (`document`/`home`/`404`/`flat`); **auto-hide sobre la banda** (`is-hidden ↔ !past && scrollY>0`) → reaparece sólido al entrar en contenido; **logo grafito en sólida / logo invertido papel sobre banda tinta**. Micro-script síncrono en `header.php` arranca transparente para `document` **y `home`** (extendido esta sesión, mata el flash sin splash / reduced-motion). `404` emite contexto pero su rama de header sigue inactiva hasta construir el campo tinta.
- **Splash**: overlay papel a pantalla completa, solo home, una vez por sesión, no-flash. El scroll-lock (`overflow:hidden` transitorio) se retira antes de cualquier scroll → no afecta al sticky del hero.
- **Páginas-documento**: `template-documento.php` + `documento.css`. Banda de apertura tinta (kicker mono ← `the_title()`, h1 ← meta `_gtt_titular`, subtítulo ← `the_excerpt()`), sentinel en el borde inferior, cuerpo de prosa `.gtt-doc-prose` (medida 38rem, blockquote = momento serif italic con regla corta + atribución mono). Meta box «Titular de la banda» en `inc/meta-titular.php`.

**HOME** — construida y validada (cuerpo confirmado OK por Juanma):
- **Estructura**: `front-page.php`. `get_header()` abre el **único** `<main id="gtt-content">`; dentro, hermanos: `<section class="gtt-hero">` (sticky, z-0, 100vh, grafito) y `<div class="gtt-home-contenido">` (z-1, papel, sube por encima). El **`[data-gtt-sentinel]`** es el primer hijo del div papel. Hero full-bleed sin bug de 100vw (usa width:100%). CSS condicional `is_front_page()` en `assets/css/pages/home.css`.
- **Hero Pieza 1** (commits `f7ff460`, `6b6c219`): foto `assets/img/plato-002.webp` (object-cover, eager, fetchpriority high), composición editorial (rótulos mono «Gastrototem · Andalucía» / «N.º 001 · MMXXVI», folio, kicker «Una firma de Alta Afinación Gastronómica», H1 conceptual con **«leemos» en serif italic PAPEL**, CTAs `#zonas` / `#metodo`, banda inferior).
- **Hero Pieza 2** (commits `85a3b2e` grano, `9cf1b91` movimiento): zoom foto 1→1.18, desvanecido del texto (easeOut cúbico, 1→0.40) + **parallax 24px** (adición nuestra, Lovable solo desvanece; **Juanma decidió MANTENERLO**), grano SVG feTurbulence 0.06 estático. `prefers-reduced-motion`: hero quieto, solo grano. `hero.js` con su propio listener rAF; no toca header.
- **Cuerpo** (secciones de Lovable `Index.tsx`): «Qué hacemos», «Los pasos» (01 Una visita / 02 Una conversación / 03 **Un informe firmado**), «Reservar» (precio **1.000 € + IVA**, «Ver la Sesión al detalle»), tarjetas de zona (Málaga abierta · Granada sin fechas · Sevilla próximamente), pull-quote «Detrás de cada lectura hay un criterio y dos personas.»

**TANDA DE CORRECCIONES — HECHA Y VALIDADA** (Juanma dio el visto bueno a la home completa)
Tras comparar con la home de Lovable (PDFs), se hizo esta tanda y la home quedó cerrada:
1. **Footer estilo Lovable**: rehacer `template-parts/footer-main.php` + `footer.css` sobre **tinta**, con CTA grande «Verificar zonas y fechas» + 4 columnas (Navegación / Contacto / Zonas abiertas / Legal) + logo invertido + cierre «© MMXXVI · GASTROTOTEM · ANDALUCÍA · N.º 001». Correcciones de marca: **sin teléfono** (email único canal), **sin «España»** (era el bug «Andalucía · España»), slugs de navegación alineados con el menú del header. El CTA pasa a vivir en el footer global → se **retira** el CTA suelto del cuerpo de la home para no duplicarlo.
2. **Subtítulo del hero recuperado** (el descriptivo de Lovable, no el tagline operacional): «Visitamos restaurantes, los escuchamos como un afinador escucha un instrumento, y devolvemos un informe firmado con propuestas concretas.»
3. **H1 con aire**: tamaño/ancho para que rompa en 3 líneas («un restaurante.» en su propia línea), como Lovable, sin `<br>` forzados.

---

## 6. Decisiones de marca tomadas esta sesión

- **«informe firmado» sustituye a «PDF firmado» en todo el copy** (subtítulo, banda inferior, paso 03, footer). Es decisión del custodio (Juanma). **Pendiente de oficializar como MARCA v1.1**: tagline operacional §5.5, glosario §9, y `prompt-redaccion.md` (app) — se hace en la fase de criba de copy, no ahora.
- **Acentos sobre fondo oscuro en serif italic papel, nunca tinta** (§3.3). Aplicado a «leemos».
- **Subtítulo del hero** = el descriptivo de Lovable (no el tagline operacional).
- **Parallax 24px del texto del hero**: se mantiene (adición nuestra).

---

## 7. Siguiente bloque: PÁGINAS INTERIORES (en una sola pasada)

Decisión de Juanma: plantear el desarrollo de **todas** las páginas interiores **de una sola pasada** (prompt largo, mucho trabajo, revisión concienzuda después).

**Páginas** (slugs reales del tema): `/afinacion`, `/criterio`, `/nosotros`, `/contacto`.
**Referencia Lovable**: `src/pages/Afinacion.tsx`, `Criterio.tsx`, `SobreNosotros.tsx`, `Contacto.tsx` (+ componentes que monten). **NO tocar** `/reservar` ni `/mi-cuenta` (del plugin booking, funcionales).

**Plan para la nueva conversación:**
1. **Foto de estado** (solo lectura, CC): `git log --oneline -15` para fijar HEAD y los hashes. La home está **completa y validada** (Juanma dio el visto bueno: hero + cuerpo + footer estilo Lovable + subtítulo + H1). Solo queda revisar si el footer dejó algún `[REVISAR]` de páginas legales.
2. **Leer Lovable** (las 4 páginas interiores + sus componentes) y decidir, por página, si encajan en `template-documento.php` (ya existe: banda tinta + prosa) o si el diseño Lovable pide secciones propias (p. ej. `/afinacion` con precio + Afinación en Profundidad sin CTA de reserva; `/contacto` con formulario/datos; `/criterio` editorial; `/nosotros` con los dos socios).
3. **Portar las 4 en una sola tanda**, con copy de Lovable como base trabajable y las guardas de marca de §0 (informe firmado; sin teléfono salvo donde MARCA lo permita; sin aliados; léxico §5.3; tinta nunca texto sobre oscuro; «Afinación en Profundidad» 3.500 € + IVA solo «consultar», nunca «Premium»; ojo `/contacto`: email único canal público). Commits atómicos por página. Un deploy al final (dry-run + purga + curl).

**Datos de contacto:** Fernando `info@gastrototem.com`, +34 609 50 17 07 (Málaga) — el teléfono **no** va en footer; verificar caso por caso en `/contacto`/`/nosotros` qué es público. Datos de Juan: pendientes de confirmar, **no inventar**.

---

## 8. Cabos sueltos / parkings

- **MARCA v1.1**: oficializar «informe firmado» (§5.5 + §9 + `prompt-redaccion.md`) y añadir JetBrains Mono como tercera familia. Custodio: Juanma.
- **Páginas legales** (aviso legal / privacidad / cookies): el footer las enlaza; confirmar que existen o crearlas.
- **Limpiar el contenido de prueba** antes de acercarse a producción.
- **404 tinta**: campo 100vh + activar la rama de header forzado-transparente (el contexto ya se emite).
- **Slug** `/nosotros` vs Lovable `/sobre-nosotros`: el footer nuevo ya usa el del header; mantener coherencia en las interiores.
- **Auto-purga LiteSpeed** en `deploy.sh`.
- Deuda Prettier.
- La PWA `sesion.gastrototem.com` es **otro proyecto** (otra conversación); no se toca aquí.

---

*Fin del handoff. Rama `feature/cimientos-finos`, sin push, producción intocable. HEAD a verificar al abrir.*
