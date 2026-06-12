# Handoff · Gastrototem — Reconstrucción de la web en WordPress

> Para: la próxima conversación con Claude.
> De: la sesión anterior (cargada de contexto; se corta a propósito).
> Idioma de trabajo: **español**.
> Cómo usar esto: pégalo entero al abrir la conversación nueva. Es autocontenido. Las **fuentes de verdad** mandan sobre este documento si hay conflicto.

---

## 0 · Reglas que mandan (leer primero — son los errores de la sesión anterior convertidos en guardrails)

1. **El manual de marca `MARCA.md` es ley.** Está en `/mnt/project/MARCA.md`. Ante cualquier duda de marca (tipografía, color, léxico, logo, copy), se consulta el manual ANTES de decidir. No se decide de memoria ni copiando lo que improvisaron herramientas de abajo (Lovable, el tema). *(Error real de la sesión anterior: se «fijó» la serif desde la memoria y luego desde Lovable; el manual la fijaba en una línea desde el principio.)*
2. **Lo construido y aprobado es decisión tomada.** No se reabre ni se reetiqueta como «opcional». Si Juanma desarrolló y aprobó algo (p. ej. el splash, los movimientos del hero), es parte del diseño, no una propuesta en el aire. *(Error: tratar el splash como «opcional».)*
3. **No afirmar lo que no se puede verificar.** El diseño aprobado vive en el **repo de Lovable clonado** (motion incluido), no solo en los briefs. Verifica contra el código, no contra recuerdos. *(Error: decir «con los briefs basta, no se pierde nada» cuando había correcciones hechas a mano en Lovable que un brief no captura.)*
4. **La memoria de Claude tiene entradas obsoletas o erróneas** (ver §4). Las fuentes de verdad son: el manual, el `CONTRACT.md`, el repo de Lovable clonado, y el código vivo (tema + plugin). La memoria es falible.
5. **Método con Juanma (no es ingeniero):** bloque a bloque, una decisión a la vez, borradores propositivos (no cuestionarios), micro-pasos atómicos (comando/clic exactos), verify-first siempre. Ver §8.
6. **Léxico de marca** (`MARCA.md §5`): vetadas optimizar, mejorar (como promesa), transformar, refinar, premium, excelencia, pasión, etc. Aplica a copy, UI, mensajes de commit y PR. El trabajo **nunca se mide en tiempo** salvo «en el acto» (entrega del PDF) y «entre 15 y 30 días» (llamada de control).

---

## 1 · Qué estamos haciendo

Reconstruir la **web pública de Gastrototem en WordPress**, partiendo del diseño ya aprobado en Lovable. **Decisión firme:** se reconstruye en WordPress (no se mantiene el sitio React de Lovable, no se exporta su código a producción). El código de Lovable es **referencia de diseño** (estructura, copy y, crucialmente, los movimientos); la web final vive en WordPress para enchufarse al **plugin de reservas** (`gastrototem-booking`), que es el corazón operativo.

La web pública **se enchufa al plugin, no lo reinventa** (zonas, reservas, Stripe, portal cliente, atribución `?ref=`).

---

## 2 · Estado actual del código

**Repos (máquina de Juanma):**
- Umbrella: `/Users/jmagrela/gastrototem` · remote `github.com/jmagrela/gastrototem` · rama `main`.
- **Tema de producción = `theme/gastrototem`** — tema **clásico de WordPress en PHP** (standalone, v0.1.0), **activo** en staging `2026.gastrototem.com`. (NO es Astra+child; Astra ni está instalado.)
- Plugin `gastrototem-booking` **v2.4.0** activo en staging.
- Repo de Lovable **clonado como referencia (solo lectura):** `/Users/jmagrela/gastrototem-afinacion-editorial` (de `github.com/gastrototem-org/gastrototem-afinacion-editorial`). React 18 + Vite + Tailwind + shadcn/ui. **Todo el movimiento es CSS + estado React (sin Framer/GSAP) → portable a WP con CSS/JS vanilla.**

**Rama de trabajo en curso: `feature/cimientos-finos`** (creada desde `main`; NO pusheada, NO mergeada, NO desplegada). Commits atómicos:
1. `752033f` — `theme.json`: +2 presets de paleta `papel-200` (#E5DFD0) y `grafito-200` (#C9C4B8).
2. `86fd527` — `deploy.sh`: corregido destino `gastrototem-astra-child` → `gastrototem` (en LOCAL_PATH, STAGING_PATH, PRODUCTION_PATH y comentario). *(Antes apuntaba al tema muerto; con `--delete` habría sobrescrito el tema bueno.)*
3. **(recién aprobado)** Serif: Instrument Serif → **Source Serif 4 Italic** (en `inc/enqueue.php`, `theme.json`, `assets/css/tokens.css`). *Si al retomar no está commiteado, commitéalo (atómico) antes de seguir.*

**Sin WordPress local.** Para *ver* cambios hay que desplegar la rama a staging. El **primer despliegue real** debe ir precedido de `rsync --dry-run` para confirmar que el servidor coincide con lo local (que el `--delete` de `deploy.sh` no borre nada). `deploy.sh` ya apunta al tema correcto.

**Acceso staging:** SSH `u457559952@147.93.93.132:65002`, WP en `…/public_html/2026/`, wp-cli en `/usr/local/bin/wp`. Cache LiteSpeed (`wp litespeed-purge all`).

---

## 3 · Decisiones cerradas en esta sesión

- **Reconstruir en WordPress** (no mantener React, no exportar Lovable a producción).
- **Serif = Source Serif 4 Italic** (`MARCA.md §4.1`). Ni Instrument Serif (era desviación del tema) ni Newsreader (sustituto de Lovable). Solo cursiva, uso enfático (taglines, citas, palabras-acento).
- **Footer: SIN teléfono.** Fusión: footer del tema (sin teléfono, **zonas desde el plugin**) **+** del footer de Lovable se traen el **cierre con CTA**, el descriptor con **«· Andalucía»** y el folio **«N.º 001»**. (El footer de Lovable trae teléfono y zonas hardcodeadas Granada/Málaga/Sevilla: NO se copian.)
- **Splash: se reproduce** (está construido y aprobado; no es opcional).
- **El copy NO es definitivo:** se seguirá ajustando tras la conversión. En WP el texto vive en el editor de cada página → cambiarlo luego es directo y no toca código.

---

## 4 · Correcciones a la memoria de Claude (la memoria está obsoleta aquí)

- **Namespace REST = `gastrototem/v1`** (la memoria dice `gastrototem-afinacion/v1` — incorrecto; ver `CONTRACT.md`).
- **Tema = `gastrototem` standalone clásico PHP** (la memoria dice «Astra Pro + child theme» — incorrecto; Astra no está instalado).
- **Serif = Source Serif 4 Italic** (la memoria dice «Instrument Serif Italic» — incorrecto; era una desviación del tema).
- **Footer/teléfono:** el «issue abierto» de la memoria está resuelto — **no hay teléfono** (producción nunca lo tuvo; el de Lovable era una versión vieja).
- **Plugin en staging = v2.4.0** (CONTRACT.md describe la 2.2.0 — úsalo como guía y verifica contra el vivo si un detalle importa).

*(Juanma: si quieres, puedo dejar estas correcciones fijadas en la memoria para que la conversación nueva arranque sin estos errores. Dilo y lo hago.)*

---

## 5 · Fuentes de verdad y rutas

| Qué | Dónde | Manda sobre |
|---|---|---|
| Marca (tipografía, color, léxico, logo, voz) | `/mnt/project/MARCA.md` | TODO lo de marca |
| Contrato tema↔plugin de reservas | `/mnt/project/CONTRACT.md` | shortcodes, REST, zonas, atribución |
| Voz de informes (PDF firmado) | `/mnt/project/prompt-redaccion.md` | solo el motor de redacción |
| Reglas técnicas del repo | `/mnt/project/CLAUDE.md` | stack, gates, presencia, etc. |
| **Diseño aprobado + MOVIMIENTOS** | repo Lovable clonado `/Users/jmagrela/gastrototem-afinacion-editorial` | estructura, copy exacto, motion |
| Código vivo | tema `gastrototem` + plugin 2.4.0 en staging | ground truth de producción |

**Del `CONTRACT.md` (claves):** namespace `gastrototem/v1`; shortcodes `[gastrototem_booking]`→/reservar/, `[gastrototem_zona_estado zona=slug]` (tarjeta de zona con badge/fecha/CTA — **este es el que se estila como nuestra C7**), `[gastrototem_zonas]`, `[gastrototem_portal_cliente]`→/mi-cuenta/, `[gastrototem_auth]`→/acceso/. Atribución `?ref=CÓDIGO` → cookie `gtt_ref_code` 30d. **El plugin NO gestiona contenido editorial** (eso es tema + Gutenberg). Zonas reales: **5, todas Málaga** (capital, Costa del Sol oriental/occidental, Axarquía = abiertas; Interior = próximamente), **ninguna con fecha cargada todavía** (operativa pendiente de Juanma/Fernando — el tema solo pinta lo que el plugin diga).

**Colores (coinciden manual / tema / Lovable):** tinta `#1F3050`, papel `#EFEAE0`, papel-200/warm `#E5DFD0`, grafito `#1A1A22`, grafito-600/soft `#3F3D38`, regla fina/grafito-200 `#C9C4B8`. Semánticos UI: éxito `#3D5A3A`, aviso `#8B6B1F`, error `#7A2A2A`. Hover azul claro `#7B92C4` / `#152037`. Reglas duras (`MARCA §3.3`): nada de blanco/negro puros; `#1d1d1b` es bug → `#1A1A22`; tinta nunca sobre fondo oscuro; solo fondos papel/papel-puro/grafito/tinta.

**Tipografía:** Inter (sans, todo); **Source Serif 4 Italic** (serif, solo acentos/citas, siempre `font-style: italic`); JetBrains Mono (datos/kickers).

**Logo (`MARCA §4.2-4.3`):** siempre **SVG vector**, nunca `font-family`. Variantes en `assets/brand/`: `mark`, `wordmark`, `lockup-horizontal`, `lockup-vertical`. Color por CSS (`currentColor`), no por archivo. Cabecera del sitio **«GASTROTOTEM · ANDALUCÍA»** (inamovible).

---

## 6 · Referencia de diseño y movimiento (compacta — el detalle exacto está en el repo Lovable clonado; verifica números contra el código)

**Convención de páginas (validada):** cada página-documento abre con **cabecera sobre tinta** (banda a sangre `#1F3050`, texto papel, pt≈140 / pb≈96), header en estado A (transparente knockout) → estado B (sólido papel) al hacer scroll; cuerpo en papel; footer grafito. La 404 es campo tinta completo (min-height 100vh).

**Movimientos (lo que un pantallazo no captura — vive en el shell y en la Home). Archivos en el repo Lovable:**
- **Splash** (`src/components/SplashIntro.tsx`): una vez por sesión (`sessionStorage["gtt_splash_shown"]`); hold 1200ms → fade 700ms; reduced-motion 600/0; bloquea scroll; solo en Home y `/cinematografico`.
- **Header dos estados** (`src/components/SiteShell.tsx`): fixed, h-16/lg:h-20. Variante hero: sólido en `scrollY ≥ innerHeight*0.95`; oculto entre 20px y 95vh; bg transparent→#EFEAE0, borde→1px #C9C4B8 (240ms ease-out); **logo cross-fade de dos SVG** (knockout papel ↔ grafito, 200ms); reveal del header a 2100ms tras splash (translateY −100%→0, 400ms). Hamburguesa→X (translateY±7px rotate±45deg). **Overlay de menú** bg #E5DFD0, in 200ms/out 160ms, scroll-lock + Escape + focus-trap, numerales romanos I–V + CTA «Reservar una sesión / Verificar zonas y fechas →». **QUESTION ABIERTA:** el umbral 95vh es para el hero a pantalla completa; en páginas-documento (cabecera band, no llena pantalla) el sólido debe dispararse **al cruzar la cabecera**, no a 95vh. Resolver con CC al portar el header.
- **Hero cinematográfico** (`src/components/HeroCinematic.tsx`, Home): sticky top:0 100vh (pin); imagen `plato-002.webp`; **zoom** scale = 1 + progress·0.18 (1→1.18); **fade texto** opacity = 1 − (1−(1−p)³)·0.6 (1→0.4); reveals fade-up .9s `cubic-bezier(.2,.7,.1,1)` stagger .05/.25/.45/.65/.85s; «leemos» accent-in 1.2s; grain opacity .07 multiply. reduced-motion anula sticky/zoom/fade.
- **Micro:** flechas CTA hover translateX(4px) 180ms; hover enlaces footer →#7B92C4; FAQ +/− rotate 90deg + opacity (panel vía `hidden`). Todo respeta `prefers-reduced-motion` y `@media (hover:hover)`.

**Componentes (en `src/components/`):** C4 CTAPrimario (sección ink), C5 KickerMono (mono 13px uppercase tracking .08em, tonos oscuro/claro/tenue), C6 PullQuote (figure maxW 680, regla 48×1px, blockquote serif italic clamp(1.75rem,1.2rem+2.5vw,2.75rem) lh 1.25, sin comillas/atribución), **C7 TarjetaZona** (estados abierta/sin-fechas/próximamente; dots verde/ámbar/gris — **en WP esto es el shortcode `[gastrototem_zona_estado]` estilado, NO hardcodeado**), C8 FAQAcordeon, **C9 BloqueDePasos** (pasos 01 Una visita / 02 Una conversación / 03 Un PDF firmado; usado en Home y /afinacion).

**Rutas Lovable → archivos (copy exacto de cada página vive aquí):** `/`=`pages/Index.tsx`, `/afinacion`=`Afinacion.tsx`, `/criterio`=`Criterio.tsx`, `/sobre-nosotros`=`SobreNosotros.tsx`, `/contacto`=`Contacto.tsx`, `/404`=`NotFoundPage.tsx`. (`/cinematografico` y `/componentes` son andamiaje/galería, no se reconstruyen.) Las cinco páginas-documento son **estáticas** (su copy coincide casi literal con los briefs); el movimiento está en el shell y la Home.

---

## 7 · Plan de construcción (orden + estado)

1. ✅ **Cimientos:** `deploy.sh` + tokens `papel-200`/`grafito-200`. (commits 752033f, 86fd527)
2. ✅ **Serif → Source Serif 4 Italic.** (commit recién aprobado)
3. ⏭️ **SIGUIENTE — Shell (pieza grande, donde vive el movimiento).** Empezar con el **header de dos estados**: poner el header actual del tema (`template-parts/header-main.php`, `header.js`, su CSS) **al lado** de `SiteShell.tsx` del repo clonado y que CC **proponga el port exacto** (incluido el umbral de sólido en páginas-documento — la question abierta). Revisar, afinar, construir por piezas: header → splash → fusión del footer.
4. **Páginas-documento** (estáticas, rápidas): la **404** (ya especificada; coincide literal con Lovable) → contacto → sobre-nosotros → criterio → afinacion. Se rellenan los borradores que ya existen en staging y se publican una a una validando en staging.
5. **Home la última** (hero cinematográfico = lo más complejo).

**Cómo construir (gates):** rama de feature siempre, **nunca push a `main`**, verify-first, **diff + gate de aprobación antes de cada commit**, commits atómicos, **sin desplegar sin aprobación** (+ dry-run en el primer deploy). El tema es clásico PHP: las páginas se rellenan con contenido del editor (post_content) + shortcodes del plugin; los componentes C4–C9 se materializan como **patrones de bloque** (hoy `patterns/` y `blocks/` están vacíos; solo existen Header C1 y Footer C2 como template-parts).

---

## 8 · Método de trabajo y convención de prompts a CC

- **Con Juanma:** propuestas propositivas (borradores a los que reacciona), una decisión a la vez, validación bloque a bloque. Micro-pasos atómicos (no es ingeniero): comando/archivo/clic exactos, cómo obtener cada prerequisito. Si falta un dato del entorno, preguntar ese dato concreto.
- **Prompts a Claude Code:** se entregan como archivo `.md` con la prosa para Juanma fuera y el **bloque copiable entre marcadores `▼ … ▲`**. CC **no ve el chat** → inyectar siempre el contexto y las decisiones. **Blindar premisas con verify-first**: «verifica X; si se cumple haz Y; si no, párate y avisa». CC re-deriva con lo que tiene.
- **Lovable:** ya no se usa para construir; su repo clonado es solo referencia de lectura.

---

## 9 · Housekeeping diferido (Fase 3, no ahora)

- `/zonas/` tiene texto basura; existe una `/test/`; `/reserva-cancelada/` y `/acceso/` están en borrador (ojo: el slug de auth es **`/acceso/`**, no `/acceder/`).
- Cargar fechas/viajes reales en el plugin (las zonas no tienen `next_date` todavía).
- Blog/SEO + componente C9 «EntradaCriterio» aparcados.
- Deuda registrada de la app (PWA, repo aparte `gastrototem-app`): flake `client.test.ts`, presencia badge, import-order lint en `party/persistence.test.ts`. (No es la web; no tocar salvo que se pida.)

---

## 10 · Primer paso al retomar

Confirmar que el commit de la serif está hecho en `feature/cimientos-finos`. Luego, arrancar el **shell** con un prompt para CC que ponga `header-main.php` + `header.js` (+ su CSS) del tema **al lado** de `SiteShell.tsx` del repo clonado, y le pida un **plan de port** del header de dos estados (resolviendo el umbral en páginas-documento) — solo lectura/propuesta, sin tocar nada todavía. Revisarlo con Juanma antes de construir.
