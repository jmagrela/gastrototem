# Gastrototem · Child Theme

Child theme de **Astra** para el sitio público de **Gastrototem** — una firma andaluza de Alta Afinación Gastronómica.

Este theme contiene únicamente los **cimientos**: tokens de marca (paleta, tipografía, espaciado), enqueue de assets, configuración del editor de Gutenberg y los SVG oficiales del sistema de marca. Los componentes visuales, plantillas de página y bloques se construyen en fases posteriores.

---

## Dependencias

| Pieza | Versión mínima |
|---|---|
| WordPress | 6.4 |
| PHP | 8.1 |
| Tema padre | **Astra** (Pro recomendado, no requerido) |

Si Astra no está instalado o activo como tema padre, el child aborta sus enqueue y muestra un aviso en el admin. No se carga nada que pueda romper el sitio.

---

## Estructura de carpetas

```
gastrototem/
├── style.css                 Cabecera del child (sin reglas CSS)
├── functions.php             Punto de entrada: guard de Astra + require de inc/
├── theme.json                Tokens expuestos al editor de Gutenberg
├── README.md                 Este archivo
├── screenshot.png            Imagen del theme para wp-admin (1200×900)
├── assets/
│   ├── brand/                4 SVG oficiales del sistema de marca
│   ├── css/
│   │   ├── tokens.css        Custom properties (paleta completa, tipografía, espaciado)
│   │   ├── base.css          Reset suave + tipografía base + utilidades mínimas
│   │   └── editor.css        Estilos del editor (espejo de base + tokens)
│   └── js/                   Vacío. Reservado para fases posteriores.
├── inc/
│   ├── enqueue.php           Carga de Google Fonts + CSS del child
│   ├── theme-setup.php       theme_supports, image sizes, text domain
│   └── security.php          Hardening básico (XML-RPC, version, emoji, etc.)
├── patterns/                 Vacío. Block patterns de futuras fases.
├── blocks/                   Vacío. ACF/native blocks de futuras fases.
├── template-parts/           Vacío. Partes de plantilla de futuras fases.
└── languages/                Vacío. Traducciones futuras.
```

---

## Convención de tokens — dos capas

El sistema de diseño vive en **dos capas separadas, con propósitos distintos**.

### Capa 1 · `theme.json` — paleta y tipografía expuestas al editor

Lista corta de 7 colores y 3 familias tipográficas, visible en los selectores de Gutenberg. Se mantiene **deliberadamente reducida** para evitar que se use cualquier color o tamaño "porque está ahí". Cualquier color añadido al editor es una decisión de marca, no un detalle técnico.

Generan automáticamente CSS custom properties prefijadas con `--wp--preset--`. Por ejemplo `--wp--preset--color--tinta-500` y `--wp--preset--font-family--inter`.

### Capa 2 · `assets/css/tokens.css` — escala completa con prefijo `--gt-`

Paleta completa con **todos los stops** (50–900) por familia, alias semánticos, escala tipográfica con `clamp()`, espaciado en escala restringida y anchos de contenedor. Estas variables son la fuente de verdad para cualquier CSS del theme. **No se permiten valores hex literales fuera de tokens.css** (excepción: los SVG de marca, que llevan el color hardcoded por motivos de portabilidad).

Convención de nombres:

```
--gt-color-{familia}-{stop}
--gt-color-{semántico}
--gt-font-{rol}
--gt-text-{tamaño}
--gt-leading-{tipo}
--gt-tracking-{tipo}
--gt-space-{n}
--gt-container-{tipo}
```

---

## Añadir un nuevo color al sistema

Pasos a seguir, en orden, para mantener las dos capas coherentes:

1. **Define el color en `assets/css/tokens.css`** dentro del bloque `:root`, con el formato `--gt-color-{familia}-{stop}`. Si añades una familia nueva, define todos sus stops (50, 100, 200… 900) para mantener la escala.
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
| `exito` | `#3D5A3A` | Estados de UI exitosa. **No** uso editorial. |
| `aviso` | `#8B6B1F` | Estados de UI de aviso. **No** uso editorial. |
| `error` | `#7A2A2A` | Estados de UI de error. **No** uso editorial. |

### Capa 2 — escala completa (variables CSS en `tokens.css`)

**Tinta** (color firma): `--gt-color-tinta-50` → `--gt-color-tinta-900`
**Papel** (soporte cálido): `--gt-color-papel-50` → `--gt-color-papel-900`
**Grafito** (texto y monocromo): `--gt-color-grafito-50` → `--gt-color-grafito-900`
**Semánticos** (UI funcional): `--gt-color-exito`, `--gt-color-aviso`, `--gt-color-error`
**Aliases de uso**: `--gt-color-bg`, `--gt-color-text`, `--gt-color-text-muted`, `--gt-color-accent`, `--gt-color-rule`
**Reservado**: `--gt-color-blanco-puro` (`#FFFFFF`, solo documentos administrativos)

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

Pilas tipográficas en `tokens.css`: `--gt-font-sans`, `--gt-font-serif`, `--gt-font-mono`.

### Por qué estas tres y no otras

**Inter** — geometría limpia, grado de detalle suficiente para usos editoriales y de UI sin caer en lo neutro corporativo. Soporta el rango completo de pesos que necesitamos (300–700) en una sola familia, lo que reduce la carga de Google Fonts.

**Instrument Serif** — italic acentuado, contraste alto, presencia editorial que recuerda a las cabeceras de revistas gastronómicas de los 60–70. Se usa **siempre** en italic, nunca en regular. Su rol es romper el ritmo del sans-serif, no establecerlo.

**JetBrains Mono** — monospace optimizada para legibilidad en pantallas, con tracking generoso. Aporta el componente "técnico/profesional" sin recurrir al cliché de Courier. Usada en mayúsculas con `letter-spacing: 0.18em` para folios y kickers.

### Por qué NO Helvetica, Arial, Georgia, ni Times New Roman

Las pilas tipográficas **no incluyen** Helvetica ni Arial. Los fallbacks sistema (`system-ui`, `-apple-system`, `BlinkMacSystemFont`, `Segoe UI`, `Roboto`) cubren todos los OS modernos con tipografías de **mejor calidad** que las web-safe genéricas. Las web-safe son un cliché de los 2000 que se evita conscientemente.

Self-hosting de las fuentes se evaluará en una fase posterior. Hoy se cargan vía Google Fonts con `preconnect` para minimizar el coste de latencia.

---

## Versionado

`v0.1.0` — cimientos del child theme. Sin componentes, sin páginas. Marcador `Begin: gastrototem child theme foundation` (commit `11b679e` del repo principal).
