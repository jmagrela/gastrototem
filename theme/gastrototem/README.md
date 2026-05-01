# Gastrototem · Theme

Theme propio standalone para el sitio público de **Gastrototem** — una firma andaluza de Alta Afinación Gastronómica.

Este theme contiene los **cimientos**: tokens de marca (paleta, tipografía, espaciado), enqueue de assets, configuración del editor de Gutenberg, plantillas PHP clásicas (esqueleto sin diseño) y los SVG oficiales del sistema de marca. Los componentes visuales y bloques se construyen en fases posteriores.

---

## Dependencias

| Pieza | Versión mínima |
|---|---|
| WordPress | 6.4 |
| PHP | 8.1 |
| Tema padre | **Ninguno** (theme standalone) |

El theme se coordina con el plugin de reservas `gastrototem-booking`, que comparte prefijos `--gtt-` (CSS) y `gtt_` (PHP) con este theme. El plugin no es requisito para que el theme cargue, pero sí para que las páginas de reserva funcionen.

---

## Estructura de carpetas

```
gastrototem/
├── style.css                 Cabecera del theme (sin reglas CSS)
├── functions.php             Punto de entrada: define constantes + carga inc/
├── theme.json                Tokens expuestos al editor de Gutenberg
├── README.md                 Este archivo
├── screenshot.png            Imagen del theme para wp-admin (1200×900)
├── index.php                 Plantilla fallback (loop genérico singular/archive)
├── header.php                Cabecera HTML: doctype, wp_head, branding, nav
├── footer.php                Pie HTML: footer + wp_footer
├── page.php                  Plantilla para páginas (post_type=page)
├── single.php                Plantilla para entradas individuales
├── archive.php               Plantilla de archivos (categorías, etiquetas, autor, fecha)
├── search.php                Plantilla de resultados de búsqueda
├── 404.php                   Plantilla para contenido no encontrado
├── comments.php              Plantilla de comentarios (incluida desde page/single)
├── assets/
│   ├── brand/                4 SVG oficiales del sistema de marca
│   ├── css/
│   │   ├── tokens.css        Custom properties (paleta completa, tipografía, espaciado)
│   │   ├── base.css          Reset suave + tipografía base + utilidades mínimas
│   │   └── editor.css        Estilos del editor (espejo de base + tokens)
│   └── js/                   Vacío. Reservado para fases posteriores.
├── inc/
│   ├── enqueue.php           Carga de Google Fonts + CSS del theme
│   ├── theme-setup.php       theme_supports, custom-logo, nav menus, text domain
│   └── security.php          Hardening básico (XML-RPC, version, emoji, etc.)
├── patterns/                 Vacío. Block patterns de futuras fases.
├── blocks/                   Vacío. ACF/native blocks de futuras fases.
├── template-parts/           Vacío. Partes de plantilla de futuras fases.
└── languages/                Vacío. Traducciones futuras.
```

---

## Convenciones de prefijos

| Prefijo | Uso | Origen |
|---|---|---|
| `--gtt-*` | CSS custom properties (tokens de marca) | Compartido (theme + plugin) |
| `.gtt-u-*` | Clases utilitarias CSS del theme | Theme |
| `.gtt-template-*` | Clases de plantillas PHP del theme | Theme |
| `.gtt-pattern-*`, `.gtt-block-*` | Clases de patterns y custom blocks (futuras fases) | Theme |
| `.gtt-*` (plano, sin sub-prefijo) | Clases del plugin de reservas | Plugin |
| `gtt_theme_*` | Funciones PHP del theme | Theme |
| `GTT_THEME_*` | Constantes PHP del theme | Theme |
| `gtt_*` | Funciones públicas del plugin de reservas | Plugin |
| `gastrototem` | Text domain (WP i18n) y slug del theme | Compartido |

Regla de integración: **el theme conoce al plugin** (consume sus shortcodes/funciones públicas), **el plugin no conoce al theme**. Los tokens `--gtt-*` del theme son la fuente única; el plugin los consume sin mapeos.

---

## Convención de prefijos CSS

Theme y plugin comparten el namespace `gtt-` pero se reparten el uso plano y los sub-prefijos para evitar colisiones. Esta es la convención **vinculante** para cualquier CSS o HTML que se añada al ecosistema:

- **`--gtt-*`** (sin sub-prefijo) — tokens visuales de marca (color, tipografía, espaciado). Se definen en `assets/css/tokens.css` del theme y se exponen también desde `theme.json` vía `--wp--preset--color--*`. **Compartidos** entre theme y plugin: el plugin los consume directamente sin alias intermedios.

- **`.gtt-*`** (sin sub-prefijo) — clases del **plugin** de reservas (`.gtt-btn`, `.gtt-form`, `.gtt-badge`, etc., para el booking flow y el portal de cliente). **El theme NO añade clases con este prefijo plano.**

- **`.gtt-u-*`** — clases utilitarias del theme. Pequeñas, reutilizables, una sola responsabilidad. Ejemplos actuales: `.gtt-u-mono`, `.gtt-u-serif-italic`.

- **`.gtt-template-*`**, **`.gtt-pattern-*`**, **`.gtt-block-*`** — sub-prefijos descriptivos para clases del theme que no son utilities. Cualquier futura clase del theme que no sea utility usará el sub-prefijo que corresponda según el caso (plantilla PHP, block pattern, custom block).

Si añades código nuevo y dudas si una clase debe ir plana o con sub-prefijo, la regla es simple: **plano solo en plugin**. Cualquier clase emitida desde el theme **siempre** lleva sub-prefijo.

### IDs estructurales

Los IDs estructurales del theme usan prefijo plano `gtt-` sin sub-prefijo (`gtt-content`, y cualquier futuro `gtt-main`, `gtt-primary`, etc.). La regla del sub-prefijo se reserva para clases CSS, donde existe riesgo real de colisión por cascada con clases del plugin u otros plugins. Los IDs son únicos por documento y no comparten ese riesgo, por lo que mantener el prefijo plano es coherente con la convención de WordPress core y de la mayoría de themes (`#content`, `#main`, `#primary`).

---

## Plantillas — jerarquía y convenciones

Plantillas PHP clásicas (no FSE). El theme cubre los contextos básicos de WordPress; cualquier contexto no cubierto cae en `index.php`.

| Contexto | Plantilla | Body class clave |
|---|---|---|
| Página estática | `page.php` | `page page-id-{N}` |
| Entrada individual | `single.php` | `single single-post postid-{N}` |
| Categoría / etiqueta / autor / fecha | `archive.php` | `archive` |
| Resultados de búsqueda | `search.php` | `search-results` |
| 404 | `404.php` | `error404` |
| Fallback | `index.php` | (varía) |

Convenciones uniformes en las plantillas:

- Estructuras semánticas (`<article>`, `<header>`, `<footer>`, `<nav>`, `<main>`).
- Clases con sub-prefijo `.gtt-template-*`: `gtt-template-entry`, `gtt-template-entry--page`, `gtt-template-archive-title`, `gtt-template-search-list`, `gtt-template-error-404`, etc. Ver "Convención de prefijos CSS" más arriba.
- Cero hex literales en plantillas. Todo el color y la tipografía vienen de `tokens.css`.
- Cero estilos inline. Layout y espaciado los define el CSS, no el PHP.
- Todos los strings de UI pasan por `__()` / `esc_html__()` con text domain `gastrototem`.
- `comments.php` se incluye desde `page.php` y `single.php` cuando hay comentarios o están abiertos.

---

## Convención de tokens — dos capas

El sistema de diseño vive en **dos capas separadas, con propósitos distintos**.

### Capa 1 · `theme.json` — paleta y tipografía expuestas al editor

Lista corta de 7 colores y 3 familias tipográficas, visible en los selectores de Gutenberg. Se mantiene **deliberadamente reducida** para evitar que se use cualquier color o tamaño "porque está ahí". Cualquier color añadido al editor es una decisión de marca, no un detalle técnico.

Generan automáticamente CSS custom properties prefijadas con `--wp--preset--`. Por ejemplo `--wp--preset--color--tinta-500` y `--wp--preset--font-family--inter`.

### Capa 2 · `assets/css/tokens.css` — escala completa con prefijo `--gtt-`

Paleta completa con **todos los stops** (50–900) por familia, alias semánticos, escala tipográfica con `clamp()`, espaciado en escala restringida y anchos de contenedor. Estas variables son la fuente de verdad para cualquier CSS del theme. **No se permiten valores hex literales fuera de tokens.css** (excepción: los SVG de marca, que llevan el color hardcoded por motivos de portabilidad).

Convención de nombres:

```
--gtt-color-{familia}-{stop}
--gtt-color-{semántico}
--gtt-font-{rol}
--gtt-text-{tamaño}
--gtt-leading-{tipo}
--gtt-tracking-{tipo}
--gtt-space-{n}
--gtt-container-{tipo}
```

---

## Añadir un nuevo color al sistema

Pasos a seguir, en orden, para mantener las dos capas coherentes:

1. **Define el color en `assets/css/tokens.css`** dentro del bloque `:root`, con el formato `--gtt-color-{familia}-{stop}`. Si añades una familia nueva, define todos sus stops (50, 100, 200… 900) para mantener la escala.
2. **Si el color debe estar en el editor**, añádelo a `theme.json` → `settings.color.palette` con un `slug` y un `name`. El slug se convierte automáticamente en `--wp--preset--color--{slug}`.
3. **Documenta el nuevo color** en la sección "Paleta disponible" de este README.
4. **No uses el hex literal en ningún CSS del theme** — siempre vía la variable de tokens.

Si el color es solo de uso interno (no se ofrece en el editor), basta con el paso 1.

---

## Añadir un bloque o pattern en futuras fases

- **Block patterns**: archivos PHP en `/patterns/`. Se registran automáticamente vía `register_block_pattern()` en una fase posterior.
- **Custom blocks** (ACF o nativos): código en `/blocks/`. Registro y enqueue se construyen cuando llegue la fase correspondiente.

Ambas carpetas están vacías a propósito en esta fase. Esta sección se ampliará cuando se aborden los bloques.

---

## Paleta disponible

### Capa 1 — visible en el editor (slug en `theme.json`)

| Slug | Hex | Uso |
|---|---|---|
| `tinta-500` | `#1F3050` | Color firma. Acento principal, fondo de mark. |
| `papel-100` | `#EFEAE0` | Fondo editorial cálido. |
| `grafito-900` | `#1A1A22` | Texto de cuerpo. |
| `grafito-600` | `#3F3D38` | Texto secundario, separadores. |
| `success` | `#3D5A3A` | Estados de UI exitosa. **No** uso editorial. |
| `warning` | `#8B6B1F` | Estados de UI de aviso. **No** uso editorial. |
| `error` | `#7A2A2A` | Estados de UI de error. **No** uso editorial. |

### Capa 2 — escala completa (variables CSS en `tokens.css`)

**Tinta** (color firma): `--gtt-color-tinta-50` → `--gtt-color-tinta-900`
**Papel** (soporte cálido): `--gtt-color-papel-50` → `--gtt-color-papel-900`
**Grafito** (texto y monocromo): `--gtt-color-grafito-50` → `--gtt-color-grafito-900`
**Semánticos** (UI funcional): `--gtt-color-success`, `--gtt-color-warning`, `--gtt-color-error`
**Aliases de uso**: `--gtt-color-bg`, `--gtt-color-text`, `--gtt-color-text-muted`, `--gtt-color-accent`, `--gtt-color-rule`
**Reservado**: `--gtt-color-blanco-puro` (`#FFFFFF`, solo documentos administrativos)

Notas:
- `grafito-800` y `grafito-900` coinciden en `#1A1A22` a propósito. `900` es el color firma de cuerpo; `800` queda como alias para necesidades futuras.
- El blanco puro `#FFFFFF` **nunca** se usa en piezas editoriales — se reserva para PDFs administrativos y documentos legales.

---

## Tipografía

Tres familias web, cada una con un rol claramente diferenciado.

| Familia | Pesos | Rol |
|---|---|---|
| **Inter** | 300, 400, 500, 600, 700 | Voz por defecto. Cuerpo, UI, titulares. |
| **Instrument Serif** | 400 italic | Acentos editoriales, pull quotes, palabras-acento. |
| **JetBrains Mono** | 400, 500 | Folios, kickers en mayúsculas, datos técnicos, valores hex. |

Pilas tipográficas en `tokens.css`: `--gtt-font-sans`, `--gtt-font-serif`, `--gtt-font-mono`.

### Por qué estas tres y no otras

**Inter** — geometría limpia, grado de detalle suficiente para usos editoriales y de UI sin caer en lo neutro corporativo. Soporta el rango completo de pesos que necesitamos (300–700) en una sola familia, lo que reduce la carga de Google Fonts.

**Instrument Serif** — italic acentuado, contraste alto, presencia editorial que recuerda a las cabeceras de revistas gastronómicas de los 60–70. Se usa **siempre** en italic, nunca en regular. Su rol es romper el ritmo del sans-serif, no establecerlo.

**JetBrains Mono** — monospace optimizada para legibilidad en pantallas, con tracking generoso. Aporta el componente "técnico/profesional" sin recurrir al cliché de Courier. Usada en mayúsculas con `letter-spacing: 0.18em` para folios y kickers.

### Por qué NO Helvetica, Arial, Georgia, ni Times New Roman

Las pilas tipográficas **no incluyen** Helvetica ni Arial. Los fallbacks sistema (`system-ui`, `-apple-system`, `BlinkMacSystemFont`, `Segoe UI`, `Roboto`) cubren todos los OS modernos con tipografías de **mejor calidad** que las web-safe genéricas. Las web-safe son un cliché de los 2000 que se evita conscientemente.

Self-hosting de las fuentes se evaluará en una fase posterior. Hoy se cargan vía Google Fonts con `preconnect` para minimizar el coste de latencia.

---

## Instalación

1. Copiar la carpeta `gastrototem/` a `wp-content/themes/` del WordPress de destino.
2. Desde `wp-admin → Apariencia → Temas`, activar **Gastrototem**.
3. Vaciar caché del sitio (LiteSpeed, plugin de caché, CDN si aplica).

Por línea de comandos (WP-CLI):

```bash
wp theme activate gastrototem
wp cache flush
wp litespeed-purge all
```

---

## Troubleshooting

### El theme aparece en wp-admin pero la home muestra plantillas de otro theme

Esto suele indicar que la opción `template` en `wp_options` apunta a un theme distinto del activo en `stylesheet`. Pasa típicamente al **restaurar una base de datos** que se hizo cuando este theme era child de Astra (la opción `template` quedaba en `astra`).

Solución:

```bash
wp option update template gastrototem
wp cache flush
wp litespeed-purge all
```

`wp theme activate gastrototem` no resuelve este caso porque WP-CLI considera el theme ya activo y omite el reset. Hay que actualizar la opción directamente.

### Las fuentes no cargan

Comprobar:

1. Que no haya un Content Security Policy bloqueando `fonts.googleapis.com` o `fonts.gstatic.com`.
2. Que el cliente no esté en una red sin acceso a Google.
3. Que los `preconnect` se estén emitiendo: `view-source` y buscar `<link rel="preconnect" href="https://fonts.googleapis.com">`.

Si las tres están bien, vaciar caché del navegador. Las fuentes se cargan vía un único enqueue en `inc/enqueue.php → gtt_theme_google_fonts_url()`.

### Body bg sale gris-azulado en vez de papel

Síntoma de los tiempos de child de Astra: el container de Astra metía `background-color: var(--ast-global-color-5)` con mayor specificity que `body`. Si aparece tras una restauración de DB anterior al pivote standalone, comprobar que `template` y `stylesheet` están en `gastrototem` (ver caso anterior) y que no queda ningún plugin de Astra activo.

---

## Versionado

`v0.1.0` — cimientos del theme standalone. Tokens, paleta, tipografía y plantillas PHP clásicas (esqueleto sin diseño). Marcador `Begin: gastrototem child theme foundation` (commit `11b679e` del repo principal). Pivote standalone completado en commit `cef9b8a`. Plantillas restantes añadidas en commit `4dc4a16`. Limpieza de prefijos CSS (utilidades a `.gtt-u-*`, plantillas a `.gtt-template-*`, semánticos a inglés) en commits `d2c7990`/`19c7b68`/`e45287f`/`382e6dd`.
