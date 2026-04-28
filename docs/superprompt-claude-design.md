# Superprompt para Claude.ai/design — Gastrototem 2.0

---

## ROL Y MARCO

Actúa como **director de arte y diseñador web senior** especializado en marcas editoriales premium del sector gastronómico (referencias mentales: NYT Cooking, Eater, Le Monde, Apartamento Magazine, Magnus Nilsson Cookbook editions, Loose Leaf, Boundary London).

Vas a diseñar y prototipar la web completa de **Gastrototem**, una firma de crítica gastronómica especializada que "afina restaurantes". Quiero código real (HTML semántico + CSS moderno con variables, sin frameworks pesados; Tailwind solo si añade claridad). Producción-ready, responsive, accesible (WCAG AA), PageSpeed > 90 móvil.

---

## QUIÉN ES GASTROTOTEM

**Gastrototem S.L.** (Sevilla) — fundada por Fernando Huidobro y Juanma Agrela, dos críticos gastronómicos con trayectoria contrastada. **No son una agencia. No son consultores. No gestionan redes ni hacen auditorías financieras.**

**Lo que hacen:** entran en un restaurante como cualquier cliente (incógnito, sin avisar), viven la experiencia completa, se reúnen el mismo día con la propiedad y entregan un **Informe de Afinación** (PDF) en 48 horas. Cuatro áreas: cocina, sala, experiencia global, coherencia de la propuesta.

**Producto principal:**
- **Sesión de Afinación** — 1.000 € + IVA, un día, informe en 48h, seguimiento a 30 días.
- **Programa Premium Mazzocco** — 3.500 €, tres sesiones en un mes para restaurantes de la red Mazzocco en Málaga.

**Principio fundacional:** *"La visibilidad no se vende. Se otorga cuando el criterio lo justifica."*

**Tono de marca:** directo, fundamentado, sin condescendencia, sin autobombo. La voz de un crítico que ha comido en mil mesas, no la de un coach motivacional. **Cero adjetivos vacíos. Cero superlativos.** Si dices que algo es excelente, lo demuestras.

---

## SISTEMA VISUAL — DIRECCIÓN

### Paleta

| Token | Hex | Uso |
| --- | --- | --- |
| `--ink` | `#0a0a0a` | Negro principal, fondos de hero y secciones oscuras, tipografía body |
| `--paper` | `#ffffff` | Fondo principal |
| `--off-white` | `#f7f5f0` | Fondo cálido alterno (ligeramente más cálido que el actual `#f7f7f5` para alejarse del frío) |
| `--linen` | `#e8e4dc` | Bordes, separadores, fondos de tarjeta |
| `--ash` | `#999690` | Tipografía secundaria, labels |
| `--graphite` | `#3d3a35` | Body sobre fondos claros |
| `--rouge` | `#5C1A1B` | **Acento único** — burdeos profundo, casi tinta de lacre. Solo para indicadores de prioridad alta, hover de links de blog, subrayados puntuales, sello de informe, asterisco de marca. **Nunca para CTAs grandes.** |

Cero gradientes con saturación. Cero sombras coloridas. Sombras solo `rgba(10,10,10, 0.04 a 0.12)`.

### Tipografía

- **Display / serif:** `Cormorant Garamond` (400, 400-italic, 600). Para titulares, cifras grandes, citas, blockquotes.
- **Body / sans:** `Inter` (300, 400, 500, 600, 700). Más neutra y legible que Montserrat — la cambiamos.
- **Eyebrow / labels:** Inter 600, tracking 0.18em, uppercase, 11px.
- **Acento editorial:** considera **una capa caligráfica manuscrita** (`Caveat` o `Petit Formal Script`) **solo para una firma manuscrita** debajo de citas — uso quirúrgico, máx. 2 ocurrencias en la home.

Escala tipográfica fluida con `clamp()`. Cuerpo base 17px, line-height 1.7-1.85 en bloques largos.

### Identidad de marca — más allá del wordmark

El wordmark actual `GASTROTOTEM` en caja negra es funcional pero plano. Diseña **un sello/marca complementaria**:

- Un **monograma editorial**: las iniciales `G·T` separadas por un punto medio, encerradas en un círculo finísimo (1px) o en un sello cuadrado tipo "matasellos de crítico".
- Este sello aparece como **favicon, marca de agua sutil al pie del informe, isotipo de redes sociales, y como rúbrica en la home** ("aprobado por el criterio Gastrototem").
- En color: tinta `--ink` por defecto, `--rouge` cuando funciona como sello de aprobación.

El wordmark mantiene su geometría actual pero **respira más**: sin caja contenedora en las páginas claras (solo en hero negro). Tracking ligeramente más abierto.

### Texturas y atmósfera

- **Noise overlay** sutil (opacidad 0.04-0.06, no 0.025) sobre fondos negros — texturiza la "tinta".
- **Líneas finas (1px) de \****`--linen`** como separadores, nunca cajas con relleno.
- **Microanimaciones** discretas: reveal-on-scroll con translate 16px (no 30) y duración 0.6s, easing `cubic-bezier(0.22, 1, 0.36, 1)`. Hover en tarjetas con `transform: translateY(-2px)` y cambio de fondo, no de borde.
- **Cursor personalizado opcional** en hero: punto 8px tinta sólida con halo 24px translúcido.
- **Indicador de scroll**: barra 1px arriba (`--rouge`) que avanza con el scroll de la página.

### Fotografía — CRÍTICO

La web actual no tiene fotos. **No es negociable que las tenga.** Define cómo deben ser y dónde van. Si la herramienta puede generar imágenes, genera placeholders que respeten esta dirección:

- **B&N alto contraste o duotono ink+rouge muy desaturado.**
- Composiciones íntimas, no aspiracionales: manos cortando pan, copa medio bebida, mantel arrugado, una nota manuscrita junto a un cubierto, luz de sala vacía a las 4pm, una carta abierta sobre madera oscura.
- **Nada de platos perfectamente emplatados estilo Instagram. Nada de gente sonriendo a cámara.** Esto es periodismo gastronómico, no marketing de restaurante.
- Usa fotografías como **fondos a sangre** en hero y secciones clave (con overlay 60-80% negro para mantener contraste de texto).

---

## ARQUITECTURA Y PÁGINAS

Diseña **5 páginas completas** + componentes compartidos:

### 1. `/` — Home

**Hero (full viewport):**
- Fondo: foto B&N a sangre (mesa puesta, luz lateral, plano cenital o muy bajo) + overlay negro 70%.
- Eyebrow: `§ FIRMA DE CRÍTICA GASTRONÓMICA · SEVILLA` (con el `§` como marca tipográfica)
- H1 serif XL (clamp 56-110px): **"Crítica gastronómica que \*afina\* restaurantes."** ("afina" en itálica)
- Subtítulo (1 sola línea, máx. 110 caracteres): "Entramos como cualquier cliente. Te decimos lo que nadie te dice. En 48 horas tienes el informe."
- 1 solo CTA primario: `Conocer la Sesión de Afinación →`
- Sin scroll arrow flotante (es ruido). En su lugar, una línea fina vertical 60px abajo a la izquierda con el texto `001` (numeración editorial de sección).

**Sección 002 — Cita de autoridad (banda intermedia, fondo \****`--off-white`**\*\*):**
- Una sola cita en serif itálica XL ocupando ~80% del ancho:  
  *"La mejor cocina de tu vida puede estar perdiendo clientes en la sala. Y nadie te lo está diciendo."*
- Atribución pequeña: `— Fernando Huidobro, Socio fundador` con la rúbrica caligráfica debajo.

**Sección 003 — Manifiesto (dos columnas):**
- Columna izquierda: dos párrafos editoriales (ya existen en el código actual, mantenlos).
- Columna derecha: el **principio fundacional** en serif itálica grande con borde izquierdo `--rouge` 2px.

**Sección 004 — La Sesión de Afinación (fondo \****`--ink`**\*\*):**
- 3 pasos con numeración serif XL en `rgba(255,255,255,0.08)`:
  1. **Visita de incógnito** — Reservamos como cualquier cliente.
  2. **Reunión inmediata** — Ese mismo día. Sin filtros.
  3. **Informe en 48h** — Documento profesional. Acciones priorizadas.
- Línea de precio destacada: `1.000 € + IVA · Un día · Informe en 48h`
- CTA: `Ver el detalle de la Afinación →`

**Sección 005 — Cuatro principios (grid 2×2, fondo \****`--off-white`**\*\*):**
- Iconografía de línea 1.5px (no rellenos): independencia, criterio, foco, autenticidad.
- Hover: el icono se rellena de `--ink`.

**Sección 006 — Casos (anónimos):**
- Sección nueva. Tres tarjetas tipo dossier:
  - `RESTAURANTE 1★ MICHELIN · SEVILLA · 2025` — "Detectamos un punto ciego de servicio en el pase. Reorganizado el flujo, los tiempos cayeron un 22%."
  - `BISTRÓ FAMILIAR · CÁDIZ · 2025` — "La carta no contaba lo que la cocina hacía. Reescrita con criterio narrativo, ticket medio +14%."
  - `GRUPO 4 LOCALES · MÁLAGA · 2024` — "Coherencia de marca dispersa entre locales. Definida una identidad de criterio común."
- Tono: hechos, no testimonios. Cero comillas de cliente.

**Sección 007 — Cifras (4 columnas):**
- Mantén 4 / 1 día / 48h / 30d como están, **pero añade un bloque previo más emocional**: 
  - `+25 AÑOS DE OFICIO · CIENTOS DE MESAS EVALUADAS · DOS MIRADAS · UN CRITERIO`
  - Como banda tipográfica en serif itálica antes del grid de cifras operativas.

**Sección 008 — Equipo (fondo \****`--ink`**\*\*):**
- Dos retratos B&N a sangre ratio 3:4. Sin sonrisa. Mirada lateral o directa. Ropa neutra.
- Fernando Huidobro · Socio fundador · bio breve.
- Juanma Agrela · Socio fundador · bio breve.

**Sección 009 — CTA final (fondo \****`--off-white`**\*\*):**
- "Tu restaurante merece una opinión que no busque agradarte."
- CTA grande negro: `Reservar Sesión de Afinación →`
- Microcopy debajo: "Disponibilidad: 4 sesiones al mes. Lista de espera activa." (escasez real, no fabricada)

---

### 2. `/afinacion` — Detalle del servicio

- Page header negro con título `La Sesión de Afinación.` y subtítulo: `Un día. Un informe. Una decisión que cambia el restaurante.`
- Sección "El problema" — cita serif grande + texto.
- Sección "Las 4 áreas" — grid 2×2 con cocina / sala / experiencia global / coherencia. Cada tarjeta lista 3-4 puntos con `—` como bullet.
- Sección "Proceso" — 3 pasos con numeración serif y línea conectora.
- Sección "Precio" — el `1.000` en cifra serif XL (clamp 100-160px), centrado, lista de "qué incluye" debajo, CTA.
- **Sección nueva: "Ejemplo de informe"** — preview visual de página real del PDF (mockup) con CTA `Descargar muestra (PDF)` que pide email. Reduce fricción de compra.
- Sección "Para quién" — 3 perfiles (Relojero, Constructor, Aspiracional) con bordes top y descripción.
- Sección "Para quién NO" — bloque corto, fondo `--off-white`, honestidad como recurso de venta: "El Guardián — quien busca validar lo que ya hace, no mejorarlo. Si vienes a que te demos la razón, no es para ti."
- FAQ acordeón.
- CTA final.

---

### 3. `/criterio` — Blog

- Page header con título `Criterio.` y subtítulo: `Lo que aprendemos en cada mesa. Sin filtros editoriales.`
- **Featured post** destacado: layout 2 columnas, imagen B&N a la derecha, contenido a la izquierda con eyebrow de categoría en `--rouge`.
- Grid de 2 columnas con 6 posts más.
- Cada tarjeta: categoría (uppercase tracking, color `--rouge` en hover), título serif, excerpt 2 líneas, meta (fecha · tiempo lectura).
- Filtro por categoría arriba (chips horizontales).
- Newsletter al pie sobre fondo `--ink`.

---

### 4. `/nosotros` — Equipo y filosofía

- Page header negro.
- Sección "Founders" — dos columnas, retrato grande B&N + nombre serif XL + role + bio en 3 párrafos + links sociales.
- Sección "Historia" — texto editorial dos columnas con cita lateral.
- Sección "Valores" — grid 3 columnas sobre fondo `--ink`.
- Sección "Lo que NO hacemos" — bloque de honestidad: lista de servicios que no ofrecen (no agencia, no gestión de redes, no auditoría financiera, no diseño de cartas).
- CTA final.

---

### 5. `/contacto` — Formulario y reserva

- Page header.
- Layout 2 columnas:
  - **Izquierda:** formulario minimalista (labels flotantes, sin cajas, solo línea inferior). Campos: nombre, restaurante, ciudad, teléfono, motivo (select), mensaje. Botón submit `Enviar consulta →`.
  - **Derecha:** info de contacto (email, teléfono, dirección Sevilla), horario, y un **booking callout** destacado: `¿Quieres ir directo al grano? → Reserva online tu Sesión de Afinación`.
- Sección FAQ mini.
- Mapa opcional (B&N, estilo `mapbox.streets-mono` o similar).

---

## COMPONENTES TRANSVERSALES

### Header
- Fixed top, fondo `--ink`, blur si hace falta.
- Logo izquierda (versión blanca).
- Nav central/derecha: `Afinación · Criterio · Nosotros · Contacto · [Reservar sesión 1.000€]`
- El botón `Reservar` con fondo `--paper`, color `--ink`, **un punto rojo \****`--rouge`**\*\* 6px arriba a la derecha** que indica "agenda activa".
- En móvil: hamburguesa que abre overlay full-screen negro con nav vertical centrada en serif grande.

### Footer
- Fondo `--ink`, 4 columnas: Brand (logo + tagline + dirección) · Servicios · Compañía · Conecta.
- Línea de copyright + redes sociales (Instagram, LinkedIn) con iconos 1px stroke.
- **Sello monograma \****`G·T`**\*\* arriba a la derecha** como rúbrica de marca.

### Botones
3 niveles claros:
1. **Primario:** fondo `--ink`, color `--paper`, padding 22px 56px, tracking 3px uppercase, hover `translateY(-2px)` + sombra suave.
2. **Inverso (sobre dark):** fondo `--paper`, color `--ink`.
3. **Texto/link:** subrayado 1px `--linen`, hover subrayado `--rouge`, gap aumenta en hover si lleva flecha.

### Indicador de prioridad (informe)
- Pill 1px border, uppercase 10px tracking 2px:
  - `PRIORIDAD ALTA` — fondo `--rouge`, texto `--paper`
  - `PRIORIDAD MEDIA` — borde `--ink`, texto `--ink`
  - `PRIORIDAD BAJA` — borde `--ash`, texto `--ash`

---

## REQUISITOS TÉCNICOS

- **HTML semántico** (header, main, section, article, footer, nav).
- **CSS moderno** con variables CSS, `clamp()` para tipografía fluida, grid + flex. Sin SCSS.
- **Sin frameworks JS pesados.** Vanilla JS para: nav móvil, FAQ acordeón, reveal-on-scroll (`IntersectionObserver`), scroll progress bar.
- **Accesibilidad:** contraste AA mínimo, `aria-labels` en interactivos, focus visible (outline `--rouge` 2px offset 4px).
- **Responsive:** móvil primero, breakpoints 480 / 768 / 1024 / 1200.
- **Performance:** Inter y Cormorant con `display=swap`, preconnect a Google Fonts, imágenes con `loading="lazy"` y `<picture>` con WebP fallback.
- **SEO:** meta title + description únicos por página, schema.org `Organization` + `Service` en home y `/afinacion`, Open Graph completo.

---

## ENTREGABLE ESPERADO

1. **Las 5 páginas en HTML/CSS** funcionando, navegables entre sí.
2. **Una hoja de estilos compartida** (`gastrototem.css`) con todos los componentes y tokens.
3. **Un README breve** explicando la arquitectura y cómo extender.
4. **Mockup del monograma \****`G·T`** como SVG inline.
5. **Si la herramienta lo permite:** generar 6-8 imágenes B&N de placeholder respetando la dirección fotográfica descrita.

---

## REGLAS DE ESTILO INNEGOCIABLES

1. **Cero emojis** en la web. Cero stock de "chefs sonriendo".
2. **Cero buzzwords:** prohibido "experiencia única", "pasión por", "soluciones", "innovador", "transformar", "viaje culinario", "excelencia".
3. **Cero testimonios con foto y comilla grande.** Si hay prueba social, va como caso anónimo y editorial.
4. **Cero descuentos visibles, cero "oferta limitada", cero countdowns.** El precio se mantiene; la escasez es real (4/mes), no fabricada.
5. **Cero animaciones llamativas.** Reveal-on-scroll discreto y nada más. Si dudas, no animes.
6. **Cada palabra de copy debe poder decirla un crítico que ha estado 25 años evaluando restaurantes.** Si no, reescríbela.

---

**Resultado esperado:** una web que parezca un dossier editorial impreso, no una landing de SaaS. Que un dueño de restaurante sienta que está abriendo la portada de Le Monde, no entrando a una agencia. Que el precio de 1.000 € parezca incluso barato por la calidad percibida.

Empieza por la home completa. Luego el resto de páginas en orden. Comparte cada una al terminarla.
