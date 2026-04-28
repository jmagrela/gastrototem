# Superprompt — Claude Code + Stitch (Gastrototem 2.0)

> Pégalo entero a Claude Code. Él orquestará Stitch vía las MCP tools (`mcp__stitch__*`) en el orden correcto.

---

## ROL

Actúa como **director de arte y diseñador de producto** trabajando con Stitch (UI generator de Google) a través de las herramientas MCP. Vas a producir el sistema visual completo y las pantallas clave de la web de **Gastrototem**, una firma de crítica gastronómica española.

No improvises el flujo. Sigue el plan exactamente. Después de cada paso, muestra el resultado al usuario y pregunta si seguimos o iteramos.

---

## FLUJO DE EJECUCIÓN (no te lo saltes)

1. **Crear proyecto** con `mcp__stitch__create_project` → `title: "Gastrototem 2.0 — Web"`. Guarda el `projectId`.
2. **Crear el design system** con `mcp__stitch__create_design_system` usando los parámetros de la sección "DESIGN SYSTEM" de abajo. Guarda el `assetId`.
3. **Llama `mcp__stitch__update_design_system`** inmediatamente después para aplicarlo y mostrarlo en la UI.
4. **Generar las 5 pantallas** una a una con `mcp__stitch__generate_screen_from_text`, en este orden: Home → Afinación → Criterio → Nosotros → Contacto. Usa los prompts literales de la sección "PANTALLAS". `deviceType: DESKTOP` salvo cuando se indique. `modelId: GEMINI_3_1_PRO` (máxima calidad).
5. Después de la home, **muestra al usuario el screenshot** y pregunta: ¿seguimos con las otras 4 o iteramos esta primero?
6. **Aplica el design system a cada pantalla** con `mcp__stitch__apply_design_system` para asegurar consistencia.
7. Cuando las 5 estén listas, **genera 3 variantes de la home** con `mcp__stitch__generate_variants` (`creativeRange: EXPLORE`, `aspects: [LAYOUT, IMAGES]`, `variantCount: 3`) para que el usuario elija la dirección final.
8. Iterar con `mcp__stitch__edit_screens` según feedback.

**Importante:** las llamadas a `generate_screen_from_text`, `edit_screens` y `generate_variants` tardan minutos. **No reintentes** — si falla por timeout, espera y consulta con `get_screen` o `get_project`.

---

## CONTEXTO DE MARCA

**Gastrototem S.L.** (Sevilla). Fundadores: Fernando Huidobro y Juanma Agrela. Críticos gastronómicos con trayectoria contrastada.

**No son agencia. No son consultores.** Entran de incógnito en restaurantes, viven la experiencia como cualquier cliente, se reúnen el mismo día con la propiedad y entregan un **Informe de Afinación** (PDF) en 48 horas. Cuatro áreas: cocina, sala, experiencia global, coherencia.

**Productos:**
- **Sesión de Afinación** — 1.000 € + IVA, un día, informe en 48h, seguimiento a 30 días.
- **Programa Premium Mazzocco** — 3.500 €, tres sesiones en un mes (Málaga).

**Principio fundacional:** *"La visibilidad no se vende. Se otorga cuando el criterio lo justifica."*

**Tono:** directo, fundamentado, sin condescendencia, sin autobombo. Voz de un crítico de 25 años de oficio. **Cero adjetivos vacíos. Cero superlativos. Cero buzzwords** ("experiencia única", "innovador", "soluciones", "viaje culinario", "transformar" — prohibidos).

**Referencias visuales mentales:** NYT Cooking, Eater, Le Monde, Apartamento Magazine, Loose Leaf, Boundary London, Magnus Nilsson cookbooks. **Editorial premium**, no SaaS, no startup, no foodie de Instagram.

---

## DESIGN SYSTEM — parámetros exactos para `create_design_system`

```json
{
  "designSystem": {
    "displayName": "Gastrototem Editorial",
    "theme": {
      "colorMode": "LIGHT",
      "colorVariant": "MONOCHROME",
      "headlineFont": "EB_GARAMOND",
      "bodyFont": "INTER",
      "labelFont": "INTER",
      "roundness": "ROUND_FOUR",
      "customColor": "#0a0a0a",
      "overridePrimaryColor": "#0a0a0a",
      "overrideSecondaryColor": "#5C1A1B",
      "overrideNeutralColor": "#f7f5f0",
      "designMd": "<<< pegar el bloque DESIGN_MD de abajo >>>"
    }
  }
}
```

**Nota sobre fuentes:** Stitch no incluye Cormorant Garamond. `EB_GARAMOND` es el equivalente más fiel (clásico, italics elegantes). Si la primera tirada queda fría, alternativa: `LIBRE_CASLON_TEXT` o `BODONI_MODA`.

### `designMd` — pegar literal en el campo `designMd` del theme

```markdown
# Gastrototem — Design System

## Esencia
Marca editorial de crítica gastronómica. Sobriedad de revista impresa, no de app.
La estética es la del dossier de un inspector que ha cenado en mil mesas:
papel cálido, tinta densa, márgenes generosos, una sola tinta de acento.

## Paleta (tokens)
- `--ink` `#0a0a0a` — negro principal, fondos hero/dark, body sobre claros
- `--paper` `#ffffff` — fondo principal
- `--off-white` `#f7f5f0` — fondo cálido alterno (papel reciclado)
- `--linen` `#e8e4dc` — bordes, separadores, fondos de tarjeta
- `--ash` `#999690` — tipografía secundaria, labels, eyebrow
- `--graphite` `#3d3a35` — body sobre fondos claros
- `--rouge` `#5C1A1B` — ACENTO ÚNICO (burdeos, tinta de lacre).
  Solo para: indicadores de prioridad alta, hover de blog, subrayados puntuales,
  sello de informe, asterisco de marca, scroll progress.
  NUNCA en CTAs grandes ni grandes superficies.

## Tipografía
- **Display/serif:** EB Garamond — titulares, cifras XL, citas, blockquotes.
  Italic para palabras clave del título ("afina", "criterio").
- **Body/sans:** Inter 300/400/500/600/700.
- **Eyebrow/labels:** Inter 600, uppercase, tracking 0.18em, 11px.
- Escala fluida con clamp(). Cuerpo base 17px, line-height 1.7-1.85.

## Forma y borde
- Esquinas: 4px máximo (ROUND_FOUR). Casi todo a 0px.
- Líneas separadoras 1px `--linen`. Cero cajas con relleno.
- Sombras solo `rgba(10,10,10, 0.04 a 0.12)`. Cero sombras coloridas.
- Cero gradientes saturados.

## Atmósfera
- Noise overlay sutil opacidad 0.04-0.06 sobre fondos negros (textura de tinta).
- Microanimaciones discretas: reveal-on-scroll 16px translate, 0.6s,
  easing `cubic-bezier(0.22, 1, 0.36, 1)`.
- Hover en tarjetas: translateY(-2px) + cambio de fondo (no de borde).
- Scroll progress 1px arriba en `--rouge`.

## Botones — 3 niveles
1. **Primario:** fondo `--ink`, texto `--paper`, padding 22x56px,
   tracking 3px uppercase, hover translateY(-2px) + sombra suave.
2. **Inverso (sobre dark):** fondo `--paper`, texto `--ink`.
3. **Texto/link:** subrayado 1px `--linen`, hover subrayado `--rouge`,
   gap aumenta en hover si lleva flecha.

## Indicador de prioridad (informe)
Pills 1px border, uppercase 10px tracking 2px:
- `PRIORIDAD ALTA` — fondo `--rouge`, texto `--paper`
- `PRIORIDAD MEDIA` — borde `--ink`, texto `--ink`
- `PRIORIDAD BAJA` — borde `--ash`, texto `--ash`

## Identidad complementaria
Wordmark GASTROTOTEM en geometría plana actual + monograma G·T como SELLO
editorial (las iniciales separadas por punto medio, dentro de un círculo
finísimo o un cuadro tipo "matasellos de crítico"). El sello aparece como:
favicon, marca de agua del informe, isotipo de redes, rúbrica al pie de la home.
Color: `--ink` por defecto, `--rouge` cuando funciona como "sello de aprobación".

## Fotografía — INNEGOCIABLE
- B&N alto contraste o duotono ink+rouge MUY desaturado.
- Composiciones íntimas, NO aspiracionales: manos cortando pan, copa medio
  bebida, mantel arrugado, nota manuscrita junto a un cubierto, luz de sala
  vacía a las 4pm, carta abierta sobre madera oscura.
- PROHIBIDO: platos perfectos estilo Instagram, gente sonriendo a cámara,
  chefs posando, planos cenitales de comida colorida.
- Las fotos van a sangre en hero y secciones clave, con overlay 60-80% negro
  para mantener contraste de texto.

## Reglas innegociables
1. Cero emojis en cualquier parte del producto.
2. Cero buzzwords: prohibido "experiencia única", "pasión por", "soluciones",
   "innovador", "transformar", "viaje culinario", "excelencia".
3. Cero testimonios con foto y comilla grande. Si hay prueba social,
   va como caso anónimo y editorial.
4. Cero descuentos visibles, cero "oferta limitada", cero countdowns.
5. Cero animaciones llamativas. Si dudas, no animes.
```

---

## PANTALLAS — prompts para `generate_screen_from_text`

Cada bloque siguiente es **el prompt literal** que debes pasar al campo `prompt` de `generate_screen_from_text`. Genera todas en `DESKTOP` salvo donde se indique.

---

### PANTALLA 1 · HOME

```
Diseña la home de Gastrototem, una firma española de crítica gastronómica que "afina restaurantes". Estética editorial premium tipo NYT Cooking + Apartamento Magazine. Layout de revista impresa, no de SaaS.

Estructura vertical (DESKTOP, 1440px de ancho):

1) HERO FULL-VIEWPORT
- Fondo: fotografía B&N a sangre de una mesa de restaurante puesta vista cenital o lateral baja, mantel claro arrugado, copa de vino tinto medio bebida, cubertería pesada. Overlay negro 70%.
- Header fijo arriba: logo wordmark "GASTROTOTEM" en blanco a la izquierda; nav "Afinación · Criterio · Nosotros · Contacto" en gris claro tracking abierto; CTA "Reservar sesión" en pill blanco con texto negro y un punto rojo burdeos (#5C1A1B) 6px arriba a la derecha del botón.
- Eyebrow centrado-izquierda: "§ FIRMA DE CRÍTICA GASTRONÓMICA · SEVILLA" en uppercase, tracking 4px, gris claro.
- H1 serif XL (EB Garamond, ~96px, italic en "afina"): "Crítica gastronómica que afina restaurantes."
- Subtítulo (Inter 300, ~20px, gris claro, max 600px): "Entramos como cualquier cliente. Te decimos lo que nadie te dice. En 48 horas tienes el informe."
- 1 solo CTA primario: pill blanco con texto negro "Conocer la Sesión de Afinación →".
- Abajo a la izquierda: línea fina vertical 60px + texto "001" pequeño (numeración editorial de sección). NO scroll arrow.

2) SECCIÓN 002 — CITA DE AUTORIDAD
- Fondo off-white #f7f5f0.
- Una sola cita serif italic XL ocupando ~80% del ancho: "La mejor cocina de tu vida puede estar perdiendo clientes en la sala. Y nadie te lo está diciendo."
- Atribución pequeña: "— FERNANDO HUIDOBRO, SOCIO FUNDADOR" uppercase tracking 3px.
- Debajo, una "rúbrica caligráfica" manuscrita simulada.

3) SECCIÓN 003 — MANIFIESTO (dos columnas)
- Fondo blanco.
- Eyebrow: "003 — EL MANIFIESTO".
- H2 serif: "La verdad no se vende. Se dice cuando el criterio lo justifica."
- Col izquierda: dos párrafos editoriales sobre puntos ciegos operativos.
- Col derecha: principio fundacional en serif italic grande con borde izquierdo 2px burdeos #5C1A1B.

4) SECCIÓN 004 — LA SESIÓN DE AFINACIÓN (dark)
- Fondo negro #0a0a0a, texto blanco.
- Eyebrow blanco: "004 — QUÉ HACEMOS".
- H2 serif: "La Sesión de Afinación."
- Subtítulo gris: "Un servicio cerrado, un día. 1.000 € + IVA."
- Grid de 3 columnas separadas por líneas 1px en blanco al 8%:
  · 01 (numeración serif XL en blanco al 12%) "Visita de incógnito" — "Reservamos como cualquier cliente. Llegamos sin aviso."
  · 02 "Reunión inmediata" — "Ese mismo día. Sin filtros, sin rodeos."
  · 03 "Informe en 48h" — "Documento profesional. Acciones priorizadas."
- Banda inferior con línea de precio destacada: "1.000 € + IVA · UN DÍA · INFORME EN 48H".
- CTA inverso (fondo blanco, texto negro): "Ver el detalle de la Afinación →".

5) SECCIÓN 005 — CUATRO PRINCIPIOS (grid 2×2)
- Fondo off-white.
- Eyebrow: "005 — ASÍ TRABAJAMOS".
- H2 serif: "Cuatro principios. Sin excepción."
- 4 tarjetas con icono de línea fina 1.5px (NO rellenos): Independencia absoluta · Criterio fundamentado · Sin agencia, sin gestión · Todo nace del trabajo real. Cada tarjeta con título uppercase 13px tracking 3px y descripción Inter 300.

6) SECCIÓN 006 — CASOS (anónimos)
- Fondo blanco.
- Eyebrow: "006 — TRABAJO RECIENTE".
- H2 serif: "Restaurantes afinados."
- 3 tarjetas tipo dossier, layout horizontal con borde superior 1px:
  · "RESTAURANTE 1★ MICHELIN · SEVILLA · 2025" — "Detectamos un punto ciego de servicio en el pase. Reorganizado el flujo, los tiempos cayeron un 22%."
  · "BISTRÓ FAMILIAR · CÁDIZ · 2025" — "La carta no contaba lo que la cocina hacía. Reescrita con criterio narrativo, ticket medio +14%."
  · "GRUPO 4 LOCALES · MÁLAGA · 2024" — "Coherencia de marca dispersa entre locales. Definida una identidad común."
- Sin testimonios con comillas. Sin nombres de cliente. Hechos.

7) SECCIÓN 007 — CIFRAS
- Fondo off-white.
- Banda superior tipográfica serif italic: "+25 años de oficio · cientos de mesas evaluadas · dos miradas · un criterio".
- 4 cifras en serif XL centradas: "4 / Áreas de evaluación", "1 día / De trabajo", "48h / Informe entregado", "30d / Seguimiento incluido".

8) SECCIÓN 008 — EQUIPO (dark)
- Fondo negro.
- Eyebrow blanco: "008 — QUIÉNES SOMOS".
- H2 serif blanco: "Dos miradas. Un criterio."
- Dos retratos B&N a sangre ratio 3:4, miradas serias, no sonrisas, ropa neutra.
  · Fernando Huidobro · Socio fundador · bio breve sobre precisión técnica y rigor de producto.
  · Juanma Agrela · Socio fundador · bio breve sobre experiencia global, sala y coherencia.

9) SECCIÓN 009 — CTA FINAL
- Fondo off-white, centrado.
- Eyebrow: "009 — SIGUIENTE PASO".
- H2 serif XL: "Tu restaurante merece una opinión que no busque agradarte."
- CTA primario gigante negro: "Reservar Sesión de Afinación →".
- Microcopy gris debajo: "Disponibilidad: 4 sesiones al mes. Lista de espera activa."

10) FOOTER (dark)
- Fondo negro.
- 4 columnas: Brand (logo blanco + tagline + dirección Sevilla) · Servicios · Compañía · Conecta.
- Sello G·T monograma arriba a la derecha.
- Línea inferior con copyright + redes (Instagram, LinkedIn) iconos 1px stroke.

NO USAR: emojis, ilustraciones cartoon, gradientes saturados, fotos de chefs sonriendo, fotos de platos coloridos perfectamente emplatados, badges de "oferta", countdowns, testimonios con foto.
USAR: fotografía B&N alto contraste, líneas finas 1px, mucho espacio en blanco, tipografía serif para titulares, sans Inter para body, una sola tinta de acento burdeos #5C1A1B usada con extrema discreción.
```

---

### PANTALLA 2 · `/AFINACION` (detalle del servicio)

```
Diseña la página /afinacion de Gastrototem (DESKTOP). Misma estética editorial premium B&N + acento burdeos #5C1A1B.

1) PAGE HEADER
- Fondo negro #0a0a0a.
- Eyebrow gris: "EL SERVICIO".
- H1 serif XL blanco (italic en "Sesión"): "La Sesión de Afinación."
- Subtítulo Inter 300: "Un día. Un informe. Una decisión que cambia el restaurante."

2) SECCIÓN — EL PROBLEMA
- Fondo blanco.
- Cita serif italic XL con borde izquierdo 2px linen: "Un restaurante puede tener una cocina brillante y estar perdiendo clientes en la sala. Los puntos ciegos no aparecen en la cuenta de resultados hasta que ya es tarde."
- Texto editorial debajo, dos párrafos.

3) SECCIÓN — LAS 4 ÁREAS (grid 2×2)
- Fondo off-white.
- Eyebrow: "QUÉ EVALUAMOS".
- H2 serif: "Cuatro áreas. Una mirada completa."
- 4 tarjetas con número serif XL gris claro, título uppercase, lista de 3-4 puntos con bullet "—":
  · 01 COCINA: materia prima, técnica, identidad culinaria, carta como documento.
  · 02 SALA: bienvenida, tiempos, conocimiento de carta, hospitalidad, cierre.
  · 03 EXPERIENCIA GLOBAL: atmósfera, coherencia espacio-oferta-precio, fluidez.
  · 04 COHERENCIA DE LA PROPUESTA: si el restaurante es lo que dice ser, presencia digital incluida.

4) SECCIÓN — PROCESO (3 pasos horizontales)
- Fondo blanco.
- Línea conectora horizontal 1px linen entre los 3 pasos.
- Cada paso: círculo 72px con número serif dentro, título uppercase, descripción breve, badge tiempo: "1 NOCHE" / "MISMO DÍA" / "48 HORAS".

5) SECCIÓN — PRECIO
- Fondo off-white, centrado.
- Cifra serif XL gigante (~140px): "1.000".
- Subtítulo: "EUROS + IVA · SERVICIO CERRADO".
- Lista horizontal de 4 ítems incluidos con bullet rouge: visita de incógnito · reunión inmediata · informe en 48h · seguimiento a 30 días.
- CTA primario negro grande: "Reservar Sesión →".
- Microcopy: "Segunda visita opcional al mismo precio."

6) SECCIÓN — EJEMPLO DE INFORME
- Fondo negro, layout 2 columnas.
- Izquierda: texto editorial sobre el informe + lista de qué incluye.
- Derecha: mockup de página real del PDF (tarjeta sobre fondo off-white) mostrando título "INFORME DE AFINACIÓN", una observación de área "SALA" con descripción y un pill rouge "PRIORIDAD ALTA".
- CTA secundario: "Descargar muestra (PDF) →" (pide email).

7) SECCIÓN — PARA QUIÉN
- Fondo blanco.
- 3 perfiles con borde superior 1px linen:
  · EL RELOJERO — restaurante maduro con puntos ciegos operativos. Señal: «todo funciona pero ya no crece».
  · EL CONSTRUCTOR — a punto de escalar o abrir segundo local. Señal: «necesito saber qué replicar».
  · EL ASPIRACIONAL — buena cocina sin reconocimiento en guías. Señal: «merezco más visibilidad».

8) SECCIÓN — PARA QUIÉN NO
- Fondo off-white.
- Bloque corto de honestidad como recurso de venta:
  · Eyebrow rouge: "DESCARTA SI...".
  · H3: "El Guardián."
  · Texto: "Quien busca validar lo que ya hace, no mejorarlo. Si vienes a que te demos la razón, no es para ti."

9) FAQ ACORDEÓN (5-7 preguntas)
- ¿Qué pasa si no estoy en Sevilla? · ¿Quién hace la visita? · ¿Pueden firmar NDA? · ¿Cuánto dura el informe? · ¿Qué incluye el seguimiento? · ¿Hay descuentos por volumen?

10) CTA FINAL
- Fondo negro.
- "Reservar Sesión de Afinación →" + microcopy de disponibilidad.
```

---

### PANTALLA 3 · `/CRITERIO` (blog)

```
Diseña la página /criterio de Gastrototem (DESKTOP) — el blog editorial. Estética igual.

1) PAGE HEADER
- Fondo negro.
- Eyebrow: "ARTÍCULOS".
- H1 serif XL: "Criterio."
- Subtítulo: "Lo que aprendemos en cada mesa. Sin filtros editoriales."

2) FILTROS DE CATEGORÍA
- Banda con chips horizontales 1px border: Todos · Cocina · Sala · Crítica · Cultura gastronómica · Casos.
- Chip activo con borde rouge.

3) FEATURED POST
- Layout 2 columnas, fondo off-white.
- Izquierda: imagen B&N grande de detalle gastronómico (mano cortando pan oscuro, cuchillo).
- Derecha: eyebrow rouge "DESTACADO · SALA", H2 serif italic grande del título, excerpt 3 líneas, meta "12 ABR 2026 · 8 MIN", link "Leer artículo →" con flecha que se separa al hover.

4) GRID DE ARTÍCULOS (2 columnas, 6 posts)
- Fondo blanco.
- Cada tarjeta: imagen pequeña B&N opcional arriba, eyebrow categoría uppercase tracking 3px, título serif 32px, excerpt 2 líneas Inter 300, meta gris (fecha · tiempo lectura).
- Hover: fondo cambia a off-white, categoría se vuelve rouge.
- Línea separadora 1px linen entre tarjetas.

5) PAGINACIÓN
- Centrada, números 44x44px, página actual con fondo negro y texto blanco.

6) NEWSLETTER (dark)
- Fondo negro centrado.
- Eyebrow: "RECIBE EL CRITERIO".
- H2 serif: "Un correo al mes. Solo lo que aprendemos en mesa."
- Form inline: input email transparente con borde 1px gris + botón blanco "Suscribirse".
- Microcopy: "Sin spam. Cancela cuando quieras."

7) FOOTER (igual al de la home)
```

---

### PANTALLA 4 · `/NOSOTROS`

```
Diseña la página /nosotros de Gastrototem (DESKTOP).

1) PAGE HEADER
- Fondo negro.
- Eyebrow: "EL EQUIPO".
- H1 serif XL: "Dos miradas. Un criterio."
- Subtítulo: "Fernando Huidobro y Juanma Agrela. Críticos, socios, sevillanos."

2) FOUNDERS (2 columnas)
- Fondo blanco.
- Cada founder: retrato B&N grande ratio 3:4 (mirada lateral o directa, sin sonrisa, ropa neutra), nombre serif XL 40px, role uppercase tracking 3px gris, bio en 3 párrafos Inter 300, links sociales pequeños abajo (Instagram, LinkedIn) iconos 1px stroke.

3) SECCIÓN — HISTORIA
- Fondo off-white, layout 2 columnas.
- Izquierda: texto editorial sobre cómo nace Gastrototem 2.0 desde la trayectoria de ambos críticos.
- Derecha: cita serif italic grande sobre el origen, con borde izquierdo 2px linen.

4) SECCIÓN — VALORES (dark, grid 3 columnas)
- Fondo negro.
- Eyebrow blanco: "ASÍ PENSAMOS".
- H2 serif: "Tres valores no negociables."
- 3 columnas con borde superior 2px blanco: Independencia absoluta · Criterio fundamentado · Trabajo real, no fabricado.

5) SECCIÓN — LO QUE NO HACEMOS
- Fondo off-white.
- Eyebrow rouge: "PARA QUE QUEDE CLARO".
- H2 serif: "Lo que NO somos."
- Lista vertical con cruz roja (X) en burdeos:
  · No somos agencia.
  · No gestionamos redes sociales.
  · No hacemos auditorías financieras.
  · No diseñamos cartas ni interiores.
  · No vendemos visibilidad.

6) CTA FINAL (igual al de la home)

7) FOOTER
```

---

### PANTALLA 5 · `/CONTACTO`

```
Diseña la página /contacto de Gastrototem (DESKTOP).

1) PAGE HEADER
- Fondo negro.
- Eyebrow: "HABLEMOS".
- H1 serif XL: "Empieza la conversación."
- Subtítulo: "Cuéntanos sobre tu restaurante. Te respondemos en 24h."

2) LAYOUT 2 COLUMNAS (fondo blanco)

IZQUIERDA — FORMULARIO MINIMALISTA
- Sin cajas, solo línea inferior 1px linen por campo.
- Labels flotantes uppercase 12px tracking 1.5px que suben al focus.
- Campos: Nombre · Restaurante · Ciudad · Teléfono · Motivo (select: Reservar Afinación / Programa Premium / Consulta general / Prensa) · Mensaje (textarea).
- Botón submit alineado a la izquierda: pill negro "Enviar consulta →".

DERECHA — INFO DE CONTACTO
- 3 bloques con eyebrow uppercase + valor:
  · ESCRÍBENOS — info@gastrototem.com
  · LLÁMANOS — +34 XXX XXX XXX
  · DÓNDE ESTAMOS — Sevilla, España
- Booking callout destacado abajo (fondo off-white, padding generoso):
  · Eyebrow: "RUTA RÁPIDA".
  · "¿Quieres ir directo al grano? Reserva online tu Sesión de Afinación."
  · Link "Reservar ahora →" con flecha que se separa al hover.

3) FAQ MINI (5 preguntas)
- Fondo off-white.
- Acordeón vertical, separadores 1px linen, "+" rotando a "x" al abrir.

4) FOOTER (igual al de la home)
```

---

## DESPUÉS DE GENERAR — ITERACIÓN

Cuando las 5 pantallas estén listas:

1. **Aplica el design system** a todas con `apply_design_system` (recoge `selectedScreenInstances` desde `get_project`).
2. **Captura screenshots** de cada una y pásalas al usuario en formato visual usando `mcp__nimbalyst-mcp__display_to_user` (image type) si es posible, o describe lo que ves.
3. **Genera 3 variantes de la home** con `generate_variants`:
   ```json
   {
     "creativeRange": "EXPLORE",
     "aspects": ["LAYOUT", "IMAGES"],
     "variantCount": 3
   }
   ```
4. Pregunta al usuario: ¿qué dirección elige? ¿Refinar (REFINE) o reimaginar (REIMAGINE) alguna sección?
5. Para cambios concretos, usa `edit_screens` con prompts quirúrgicos del tipo:
   - "En el hero, sustituye la fotografía por un primer plano cenital de manos sobre un mantel oscuro con una copa de vino."
   - "En la sección de precios, aumenta el tamaño de la cifra '1.000' un 30%."
   - "Cambia el botón 'Reservar sesión' del header — añade el texto '· 1.000 €' después de 'Reservar sesión' en el mismo botón."

---

## ENTREGABLE FINAL ESPERADO

1. Un proyecto Stitch llamado **"Gastrototem 2.0 — Web"** con el design system aplicado.
2. **5 pantallas finales** (Home, Afinación, Criterio, Nosotros, Contacto) coherentes entre sí.
3. **3 variantes de home** para que el usuario elija dirección.
4. URL del proyecto Stitch + screenshots de cada pantalla pasados al usuario.
5. Un resumen breve de las decisiones tomadas y dónde el design system de Stitch difiere del ideal (por ejemplo: EB Garamond en vez de Cormorant Garamond) por si quiere ajustar.

---

## RECORDATORIO DE TONO

Si en algún momento Stitch genera copy con buzzwords ("experiencia única", "innovador", "transformamos"), **regenera con `edit_screens` corrigiendo el copy**. La marca pierde valor cada vez que aparece una de esas palabras. La voz tiene que poder decirla un crítico que ha estado 25 años evaluando restaurantes. Si no, reescríbela.
