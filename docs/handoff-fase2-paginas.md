# Handoff · Gastrototem Web · Fase 2 — Páginas

Documento de traspaso para abrir una sesión limpia. Resume el estado de la web `2026.gastrototem.com` tras cerrar la **galería completa de componentes C4–C8**. State-passing. La sesión nueva arranca la **Fase 2: páginas**.

---

## Qué es esto y de dónde viene

Trabajo en la web 2026 de Gastrototem (firma andaluza de Alta Afinación Gastronómica). Flujo de producción de tres etapas: **Midjourney** (banco fotográfico) → **Lovable** (prototipo visual) → **Claude Code** (producción WordPress + Astra Pro). La memoria de marca completa está en userMemories y en `/mnt/project/` (manual v1.1, propuesta de modelo de negocio, SVG assets, contract).

Las sesiones anteriores cerraron, en este orden: el **shell cinematográfico completo** (`/cinematografico`), y luego la **galería de componentes reutilizables completa** (`/componentes`, C4–C8). Esta sesión nueva ya no diseña componentes: ensambla **páginas** con ellos.

---

## Estado: qué está CERRADO

### Shell completo de `/cinematografico` (en Lovable)

Página completa validada: splash Netflix (lockup vertical, 1.2s, fade-out, sessionStorage, reduce-motion); hero cinematográfico (`plato-002.webp`, overlay degradado, tagline 3 líneas con "leemos" en serif italic + tinta, dos CTAs, pies y cabeceras de folio); hero sticky con zoom (imagen 1.0→1.05, texto fade 1.0→0.4); header de dos estados (A transparente knockout sobre hero oscuro / B sólido papel-100); overlay de menú (papel-200, 5 items con numerales romanos, crossfade de lockup, morph hamburguesa→X, focus trap); footer oscuro de 4 zonas. Detalle completo en el handoff anterior (componentes C5–C10), que sigue siendo válido para el shell.

### Galería de componentes `/componentes` (en Lovable) — COMPLETA

Ruta con shell completo (header sólido + footer), sin splash. Contiene las secciones C4 a C8, cada una con su rótulo de desarrollo (`Cx · NOMBRE`), tarjetas de muestra sobre sus fondos reales, y micro-rótulos de desarrollo que indican props. Todo lo "de galería" (rótulos, micro-rótulos, notas de datos de ejemplo) NO forma parte de los componentes; desaparece en producción.

**Inventario cerrado y APIs.** El sistema se cierra sobre sí mismo: C6 y C7 reutilizan el átomo C5.

**C4 · CTA primario** (cerrado en sesión previa). Bloque full-bleed sobre tinta `#1F3050`. Props: `title`, `kicker`, `ctaLabel`, `ctaHref`, `supportLine`, `showSupportLine`.

**C5 · Kicker mono** (átomo tipográfico). JetBrains Mono Medium 500, **13px fijo** (sin clamp), tracking 0.08em, uppercase por CSS, line-height 1.4. Separador `·` como carácter en el string.
- API: `text` (caja natural; el componente sube a mayúsculas), `tono` (`oscuro` default / `claro` / `tenue`), `as` (default `span`).
- Tonos: `oscuro` = grafito-900 `#1A1A22` · `claro` = papel-100 `#EFEAE0` · `tenue` = papel-100 al **60%** de opacidad.
- Rígido a propósito: sin tamaño, color libre ni alineación.

**C6 · Pull quote** (cita editorial). Newsreader italic (sustituto de Source Serif 4 Italic en Lovable), `clamp(1.75rem, 1.2rem + 2.5vw, 2.75rem)` (≈28→44px, SÍ escala), Regular 400, line-height 1.25, alineado izquierda, **max-width 680px**. Regla fina superior de 48px×1px a la izquierda (grafito-200 sobre claro / grafito-600 sobre oscuro). Sin comillas decorativas; «» como caracteres si una cita las necesita. La atribución reutiliza el kicker C5.
- API: `cita` (requerido), `atribucion` (opcional → render como kicker C5, tono según fondo), `tono` (`oscuro` default / `claro` — NO tinta para el texto de la cita, NO tenue).
- Regla de uso (disciplina, no impuesta por el componente): **un pull quote por sección** (manual §4.2). No encadenar dos, ni meterlo en sección que ya tenga otra palabra en serif italic.

**C7 · Tarjeta de zona** (con estado/datos). Ficha papel-100, borde hairline 1px grafito-200 `#C9C4B8`, radio 6px, padding 32px, **sin sombra**. Fila de estado = punto de color 8px + etiqueta kicker C5 `tono="oscuro"` (la etiqueta SIEMPRE en gris; el color vive SOLO en el punto). Nombre de zona Inter Medium ~24px grafito. Sub-línea opcional Inter Regular 14px grafito 70%. CTA "Verificar fechas →" solo en estado abierta. Por defecto sobre fondo claro; sin variante oscura.
- Estados: `abierta` (punto verde éxito `#3D5A3A` / etiqueta `ABIERTA` / con CTA) · `sin-fechas` (punto ámbar aviso `#8B6B1F` / `SIN FECHAS` / sub-línea "Sin fechas disponibles ahora mismo." / sin CTA) · `proximamente` (punto neutro grafito-200 `#C9C4B8` / `PRÓXIMAMENTE` / sin CTA).
- API: `zona` (requerido), `estado` (`abierta`|`sin-fechas`|`proximamente`, requerido — deriva etiqueta, color de punto, sub-línea por defecto y presencia de CTA), `sublinea` (opcional override), `ctaHref` (opcional; CTA solo si `estado="abierta"` Y hay `ctaHref`).
- En producción lee del plugin `gastrototem-booking`. En Lovable, datos mock (Málaga abierta / Granada sin-fechas / Sevilla próximamente).

**C8 · FAQ acordeón** (con interacción). Comportamiento: **varios paneles abiertos a la vez** (abrir uno no cierra otros); todas cerradas al inicio salvo `abrirPrimera`; accesibilidad de teclado completa (`<button>` real en encabezado, `aria-expanded`, `aria-controls`, panel con `role="region"` + `aria-labelledby`, Enter/Espacio, foco visible no suprimido); animación de altura 200ms ease-out con indicador `+`→`−`, instantáneo bajo `prefers-reduced-motion`. Anatomía tipo "ledger": filas separadas por rule hairline 1px grafito-200 (arriba, abajo y entre filas), fondo papel, **sin cajas ni sombras**, max-width 760px. Pregunta Inter Medium 19px. Indicador `+`/`−` (no chevron) grafito-600, hover→grafito-900. Respuesta Inter Regular 16px line-height 1.6, max 640px, enlaces en tinta `#1F3050` subrayados. NO usa kicker (las preguntas son prosa).
- API: `items` (array de `{ pregunta, respuesta }`; la respuesta admite párrafos y enlaces), `abrirPrimera` (bool, default `false`).

**Sobre la numeración:** C1 Header y C2 Footer se cerraron como prompts de producción (Claude Code), no como piezas de galería. C3 fue el refactor del helper de SVG inline (no es ítem de galería). "OJA" era un error de transcripción, disuelto. C9/C10 nunca existieron (eran un techo de rango inflado de una sesión previa). El inventario real es C4–C8 y está completo. No hay componentes pendientes que descubrir.

---

## Estado: qué queda PENDIENTE (objetivo de la sesión nueva)

### Fase 2 — Páginas

Ensamblar las páginas del sitio con los componentes ya cerrados. Páginas:

- **Home**
- **`/afinacion`** (servicios; Sesión de Afinación 1.000€+IVA con reserva; Afinación en Profundidad 3.500€+IVA mencionada discretamente, sin CTA de reserva, solo "consultar")
- **`/sobre-nosotros`**
- **`/criterio`** (índice del blog + entrada tipo)
- **`/contacto`**
- **404**

**Orden recomendado (a fijar al abrir, no impuesto):** una opción razonable es empezar por las páginas "hoja" más contenidas (`/contacto`, 404, `/sobre-nosotros`) para rodar el ensamblaje, y dejar **Home** —que reúne piezas de varias— hacia el final, cuando los patrones ya estén decididos. La otra opción es arrancar por Home porque fija el tono. **Primera tarea de la sesión nueva: proponer y fijar el orden de páginas antes de diseñar.**

**Posibles componentes nuevos (C9+):** al maquetar las páginas puede aparecer una pieza reutilizable genuina que aún no existe —candidatos plausibles: un **bloque de pasos** ("Una visita · Una conversación · Un PDF firmado"), una **tarjeta de entrada de blog** para el índice de `/criterio`, un **bloque de servicio/precio**. NO inventarlos por adelantado: se añaden como C9+ solo cuando una página los pida de verdad, con su decisión propia.

### Fases siguientes (NO en esta sesión)

- **Fase 3 — Plugin rediseñado:** `/reservar` (7 pasos), `/mi-cuenta`, `/acceder`, `/reserva-confirmada`, `/reserva-cancelada`.
- **Fase 4 — Templates email** (~14).
- **Fase 5 — Block patterns + ACF blocks Gutenberg.**
- **Fase 6 — Auditoría + cleanups.**
- **Lote textual:** aviso legal, privacidad, cookies.
- **PROCESO-OPERATIVO.md:** documento de lecciones, al final.

---

## Deudas técnicas conocidas (resueltas en producción, NO en Lovable)

1. **Logo/lockup como placeholder.** En header, footer y splash, el lockup renderiza como placeholder font-family ("Gastrototem.") y un cuadrado con G tipográfica, NO como el SVG knockout real. Es comportamiento sistemático de Lovable con SVGs que llevan el wordmark completo. Confirmado de nuevo en todos los screenshots de esta sesión: NO es regresión, no se toca en Lovable. **En producción WordPress (Claude Code) se incrusta el SVG real con `file_get_contents()` desde `/assets/brand/`.** Los SVG reales (sin `<mask>`, con `fill-rule="evenodd"`) viven en outputs de sesiones previas; re-adjuntar/re-incrustar según se necesiten.
2. **Migración de C4 al átomo C5 en producción.** Al traducir C4 a producción, sus dos kickers absorben el cambio validado: el principal (hoy ~70%) pasa a `tono="claro"` pleno; la línea de apoyo (hoy ~50%) pasa a `tono="tenue"` (60%). No se toca C4 en Lovable.

---

## Convenciones BLINDADAS (no preguntar, aplicar)

- **Header del sitio:** "GASTROTOTEM · ANDALUCÍA" — INAMOVIBLE. Sin variantes con toponimos.
- **Cromática:** Tinta-500 `#1F3050` (firma), Papel-100 `#EFEAE0` (fondo), Papel-200 `#E5DFD0` (overlay/tarjetas), Grafito-900 `#1A1A22` (texto/footer), Grafito-600 `#3F3D38` (rules sobre oscuro / indicadores), Grafito-200 `#C9C4B8` (rules/auxiliar). Semánticos solo para UI funcional: éxito `#3D5A3A`, aviso `#8B6B1F`, error `#7A2A2A`. Si en un SVG aparece `#1D1D1B` (default Illustrator), sustituir por `#1A1A22`.
- **Tipografía:** Inter (cuerpo, UI, titulares, preguntas), Source Serif 4 Italic (acentos editoriales y citas — Newsreader italic como sustituto en Lovable), JetBrains Mono (kickers, datos). Logo SIEMPRE SVG vectorial, nunca font-family.
- **Taglines:** Conceptual "Donde otros ven una comida, nosotros leemos un restaurante." Operativo "Una visita. Una conversación. Un PDF firmado. En el acto." Descriptor "Una firma de Alta Afinación Gastronómica." Convención de hero: "UNA VISITA · UN AFINAMIENTO · UN PDF FIRMADO EN EL ACTO" (el elemento central es siempre "UN AFINAMIENTO", nunca tiempo).
- **Léxico:** afinar/afinación/afinamiento/afinador. Vetados: optimizar, mejorar, transformar, refinar, asesorar, consultar, excelencia, innovación, sinergia, premium, top, vip, pasión, comunidad, familia, holístico, integral, 360, journey, ecosistema.
- **El trabajo NO se mide en tiempo.** Vetar duraciones en copy. Excepciones: "en el acto" (entrega PDF) y "entre 15 y 30 días" (llamada de control posterior).
- **Sin "siempre disponible".** La disponibilidad se lee dinámicamente por zonas (lo materializa C7).

---

## Método de trabajo (respetar)

- **Borradores propositivos, no cuestionarios.** Claude propone decisiones concretas con razonamiento; el usuario reacciona.
- **Bloque a bloque, una decisión a la vez.** Validar antes de avanzar. Nunca presentar una fase/página entera de golpe.
- **Briefs Lovable en `.md` limpio**, separando prosa-para-el-usuario del bloque-copiable-para-Lovable (entre marcadores ▼/▲). SVGs van inline en el propio brief. El usuario pasa solo el bloque a Lovable.
- **Para variantes nuevas en Lovable, pedir ruta nueva explícita.** Para páginas: probablemente cada página es su propia ruta (`/`, `/afinacion`, etc.); indicar siempre "no tocar rutas anteriores".
- **Verificar contraste de TODO el texto sobre foto/fondo** con screenshot real de Lovable (su clamp da tamaños mayores de lo que estima un render local).
- **Pregunta diagnóstica antes de iterar a ciegas** cuando Lovable afirme algo que no se ve en pantalla (patrón recurrente con SVGs complejos).
- **Decisiones cerradas → un brief → screenshots de validación → cierre.**

---

## Entornos activos

- **Lovable:** prototipo visual. Rutas cerradas: `/cinematografico` (shell), `/componentes` (galería C4–C8). La Fase 2 abre rutas de página nuevas.
- **Midjourney:** v8 alpha. Estructura validada: `--ar 16:9 --style raw --v 8 --s 75`. `plato-002` en uso. (No respeta posiciones porcentuales numéricas; solo left/right + large/small, y aun así se desvía. "Run as HD" es re-render, no upscale.)
- **Claude Code** (producción WordPress, fases posteriores): theme base Astra Pro + plugin `gastrototem-booking`. Regla: CC empuja solo la rama de feature, nunca a main.

---

## Primera acción de la sesión nueva

1. Leer este handoff + userMemories + archivos de `/mnt/project/` (manual v1.1, propuesta de modelo de negocio, SVG assets, contract). El handoff anterior (C5–C10) sigue siendo la referencia del detalle del shell.
2. **Proponer y fijar el orden de las páginas de Fase 2.**
3. Empezar bloque a bloque con la primera página, en borrador propositivo, ensamblando los componentes C4–C8 ya cerrados (y proponiendo C9+ solo si una página lo pide de verdad).
