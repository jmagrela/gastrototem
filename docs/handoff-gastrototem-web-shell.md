# Handoff · Gastrototem web (WordPress) · shell / header / splash

> Documento autocontenido. Pégalo entero al abrir la conversación nueva. Resume el estado real del trabajo del shell de la web pública en WordPress y cómo seguir. Las fuentes de verdad (MARCA.md, CONTRACT.md, CLAUDE.md) mandan sobre cualquier recuerdo.

---

## 0. Cómo trabajamos (guardarraíles, no negociables)

- **Una decisión a la vez.** Propuestas propositivas (borradores a los que Juanma reacciona), nunca cuestionarios abiertos. Afirmaciones breves ("lo veo bien", "dale caña", "sí", "ok") cierran decisiones.
- **Validación bloque a bloque**, nunca de golpe. Cuando Claude quiera "construir ya", parar y volver al orden.
- **No decidir de memoria ni copiando lo que improvisan las herramientas de abajo** (Lovable, el tema) cuando se desvía del manual. Verificar contra el código, no contra recuerdos.
- **`MARCA.md` es ley** por encima de Lovable, del código del tema y de los defaults de herramientas.
- **Lo construido y aprobado es decisión tomada.** No se reabre ni se reetiqueta como "opcional" por conveniencia técnica. Cambiar el *diseño* es decisión de Juanma; ahorrarse código no lo es.
- **Commits atómicos por concepto.** Gate de **diff + aprobación antes de cada commit**. CC nunca pushea a `main`. **Deploy siempre separado del commit** y con aprobación explícita.
- **Prompts a CC:** contexto inyectado entre marcadores `▼`/`▲` (CC no ve este chat), guardas verify-first ("verifica X; si se cumple haz Y; si no, para y avisa"), condiciones de parada explícitas, lectura vs. escritura declaradas, gate antes de commitear.
- **Juanma no es ingeniero:** micro-pasos atómicos, sin intermedios asumidos. Él aprueba cada gate, lanza los deploys y hace las pruebas de campo.

## 1. Repositorio y stack

- Repo: `/Users/jmagrela/gastrototem`. Tema clásico PHP standalone en `theme/gastrototem` (NO Astra, NO child theme).
- Rama de trabajo: **`feature/cimientos-finos`** (local, **sin pushear**, sin mergear).
- Referencia de diseño: repo Lovable clonado solo lectura en `/Users/jmagrela/gastrototem-afinacion-editorial` (React+Vite+Tailwind+shadcn; movimiento en CSS + estado, portable a vanilla). Es referencia, **no se exporta a producción**.
- Plugin de reservas `gastrototem-booking` v2.4.0 en staging; namespace REST `gastrototem/v1`. Tiene su **propio** `deploy.sh` en el repo de plugins (fuera de alcance aquí).
- CC **no tiene PHP** en su máquina (no puede `php -l`); por eso un error de sintaxis PHP saldría primero en el deploy a **staging**, nunca en producción → staging-first importa.

## 2. Fuentes de verdad (ya en el repo)

- **`docs/MARCA.md`** — incorporado este sesión (commit `97ad24c`). Es ley.
- `CONTRACT.md`, `CLAUDE.md` — en el proyecto.
- SVG oficiales de marca: en `theme/gastrototem/assets/brand/` (los **cuatro** presentes y correctos: mark, wordmark, lockup-horizontal, lockup-vertical, color `#1A1A22`, sin `#1d1d1b`). También empaquetados en el archivo de proyecto `gastrototem-svg-assets.md` (el sandbox no puede fetchear `gastrototem.com`).
- Memoria de Claude **corregida esta sesión** (las 5 correcciones del antiguo §4 ya están fijadas): namespace `gastrototem/v1`, tema standalone PHP, serif **Source Serif 4 Italic**, footer sin teléfono, plugin v2.4.0. La memoria ya no debería tropezar con esos errores.

## 3. deploy.sh (leído y verificado esta sesión — IMPORTANTE)

- En la raíz del repo. Hace **rsync solo de `theme/gastrototem/`**, desde el **working tree en disco** (NO de un ref de git): sube lo que haya físicamente, sea cual sea la rama. No hay que pushear para desplegar.
- **Por defecto va a STAGING.** Producción solo con `./deploy.sh production` + confirmación interactiva tecleada.
  - Staging: `.../public_html/2026/wp-content/themes/gastrototem/` (la carpeta **`/2026/`** = staging).
  - Producción: `.../public_html/wp-content/themes/gastrototem/` (sin `/2026/`).
  - **Mismo host/usuario/puerto para ambos** (147.93.93.132, u457559952, puerto 65002): solo cambia la ruta. RIESGO: un typo que pierda `/2026/` apuntaría a prod sin activar el flujo `production`. Hoy las rutas están bien.
- **`rsync -avz --delete`**: borra en destino lo que no exista en local, **dentro del directorio del tema** (irreversible en remoto). NO toca BD, ni caché/CDN, ni los `/assets/` o `/archivo-v1/` a nivel de sitio.
- **Admite `--dry-run`**: `./deploy.sh --dry-run` simula contra staging. **Regla: dry-run siempre antes de un deploy real, y revisar las líneas `deleting …`.**
- Autenticación por clave SSH (sin secretos en el script).

## 4. Estado actual — commits en `feature/cimientos-finos`

De más reciente a más antiguo:

- **(PENDIENTE de verificar) `fix(splash): aparición instantánea, transición solo en el fade-out`** — el ajuste está **aplicado al working tree** (solo `assets/css/components/splash.css`) y se dio el prompt de commit. **La nueva conversación debe empezar verificando con CC si ese commit ya está hecho** (`git log --oneline -6` + `git status`). Si no lo está, commitearlo atómico con ese mensaje, sin push ni deploy.
- `2ad6556` — feat(header): aparición del header tras el splash en la home.
- `6f955af` — feat(splash): overlay de entrada en home, una vez por sesión.
- `7156994` — feat(header): header fijo con pieles sólida/transparente y logo recoloreado por estado (Pieza 1).
- `97ad24c` — docs: añadir MARCA.md (manual de marca) a docs/.
- `b9e887f` — fix serif Source Serif 4 Italic (pre-sesión).
- (antes, en la rama) `86fd527` fix deploy.sh, `752033f` tokens de paleta.

### Desplegado a staging
Se hizo el **primer deploy a staging** (2026.gastrototem.com) del estado del working tree **hasta `2ad6556`** (9 archivos: theme.json, tokens.css, header.php, header.css, splash.css, header.js, splash.js, inc/enqueue.php, template-parts/splash.php). Dry-run limpio: **cero líneas `deleting`**, destino staging confirmado.
Verificado en vivo (Juanma + CC): la home carga (title "Gastrototem – Afinadores de cartas"), splash + bajada del header funcionan, recoloreado del logo correcto, no-flash OK, splash solo en home.
**Ojo: el `fix(splash)` del fade-in NO está en staging todavía** — su redeploy se acordó juntarlo con el de las bandas.

## 5. Qué está construido (la entrada del shell)

- **Header**: `position: fixed`, z 60, h-16/lg:h-20. Dos pieles por variables CSS:
  - Base (sin modificador) = **SÓLIDA** (fallback legible): fondo papel-100, borde grafito-200, logo variante **principal** (cuadrado tinta-500, palabra tinta-500, símbolo papel-100), hamburguesa siguiendo `--header-fg`.
  - `.gtt-header.is-transparent` = **TRANSPARENTE**: sin fondo ni borde, logo variante **línea** (cuadrado transparente, palabra y símbolo papel-100). *Esquema invertido respecto a Lovable a propósito.*
  - Logo recoloreado desde el SVG oficial vía CSS (`rect` / `path.st0` / `path.st1`), **sin editar el SVG canónico**. Transiciones: fondo/borde 240ms, logo 200ms.
  - **Aparición tras splash (intro)**: en home + primera visita de sesión + movimiento permitido, el header nace oculto (`.is-intro`, translateY −100%) por chequeo inline síncrono (no-flash), baja a **2100ms** en **400ms** (baile de dos clases `.is-intro`/`.is-revealing` para 400ms-bajada vs 200ms-base). Doble failsafe (inline 4000ms + JS idempotente). Reduced-motion lo salta. El transform base queda a 200ms (listo para el hide-on-hero futuro).
  - **Overlay/hamburguesa** del tema (ya buenos, sin tocar): fondo papel-200, entrada 200ms / salida 160ms, scroll-lock robusto, focus-trap, Escape, morph hamburguesa→X. Numerales I–V + CTA ("Reservar una sesión" / "Verificar zonas y fechas →").
- **Splash** (`template-parts/splash.php` + `splash.css` + `splash.js`): overlay papel a pantalla completa, lockup **vertical** centrado (variante principal), **solo en home** (`is_front_page()`), **una vez por sesión** (`sessionStorage["gtt_splash_shown"]`). No-flash por chequeo inline síncrono (nace oculto). Failsafe inline 4000ms. z-index var 200. Tiempos como vars CSS leídas por el JS: reposo 1200ms, fade-out 700ms (reduced-motion: 600ms, sin fade). Tras el fix: **aparición instantánea → reposo → fade-out** (sin fade-in).

## 6. El "cerebro" del header: mitad hecho

- **HECHO**: el intro (aparición tras el splash).
- **PENDIENTE — la pieza de las BANDAS**: el **observer transparente↔sólido** (IntersectionObserver sobre un **sentinel**). Enfoque ya validado y superior al `innerHeight*0.95` de Lovable (que tenía un bug latente en páginas-documento). El sentinel vive en la **banda de apertura**: cabecera tinta en páginas-documento; hero en la home (el hero es lo último). `data-gtt-context` (home/document) se aplazó: hay que añadirlo a `header.php` al construir el observer. La base sólida es el fallback; el JS añade `.is-transparent` sobre la banda y la quita al pasarla.
- También **PENDIENTE en esta pieza**: el **remate del `:hover` del toggle** (hoy va a tinta = poco contraste en piel transparente; arreglarlo cuando la transparente sea alcanzable).
- **Pieza 3 (después)**: hide-on-hero (solo home), lo último.

## 7. Siguiente paso (para la conversación nueva)

1. **Verificar git** (con CC, solo lectura): ¿está commiteado el `fix(splash)` del fade-in? Si no, commitearlo atómico (`fix(splash): aparición instantánea, transición solo en el fade-out`), sin push ni deploy.
2. **Arrancar la pieza de las bandas.** No construir a ciegas: primero **proponer a Juanma el troceado**, dónde se coloca el sentinel, y **en qué página se prueba** (hace falta una banda + una página que la monte para el field-test). Recordar el plan: shell (header/splash/footer) → páginas-documento → home/hero (lo último).
3. Cuando haya algo testeable, **deploy a staging juntando el `fix(splash)` pendiente** (dry-run primero), y prueba de campo de Juanma.

### Spec de referencia útil para el observer
- Sentinel al final de la banda de apertura; `rootMargin` superior = −(alto del header). Header arranca sólido (base); `.is-transparent` se añade mientras el sentinel está por encima y se quita al cruzarlo.
- Páginas-documento: abren con cabecera tinta a sangre (pt≈140 / pb≈96, texto papel). Páginas planas sin banda: header sólido desde la carga. **404 = campo tinta completo (100vh)**: el header se queda transparente, sin sentinel ni estado sólido.

## 8. Cabos sueltos / parkings

- **Redeploy del `fix(splash)`**: juntarlo con el deploy de las bandas.
- **Slug**: tema usa `/nosotros`, Lovable `/sobre-nosotros` (y antes `/acceso` vs `/acceder` para auth). Gana el slug real publicado en WP; alinear el menú y verificar. Housekeeping (Fase 3).
- **`#fff` del símbolo** en los SVG canónicos vs. "MARCA no usa blanco puro": pregunta de marca para el custodio, sin urgencia. No muerde al header (ahí el símbolo va papel, no blanco).
- **«GASTROTOTEM · ANDALUCÍA»**: vive en el **kicker del hero** y en el **footer**, NO en la barra de navegación (que es solo el logo). Confirmado.
- **Logo**: el "knockout/máscara" de Lovable es una **improvisación** que no existe en el sistema oficial; se reproduce con el SVG oficial recoloreando sus rellenos (decidido).
- `/cinematografico` y `/componentes`: andamiaje/galería de Lovable para probar estilos. **NO son páginas de producción, NO se portan.**
- La PWA `sesion.gastrototem.com` es **otro proyecto** (otra conversación); no se toca aquí.
