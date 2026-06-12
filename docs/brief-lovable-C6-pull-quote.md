# Brief Lovable · C6 · Pull quote

Añadir el componente **C6 · Pull quote** a la galería `/componentes`, debajo de la sección C5 ya existente. No se toca ninguna otra ruta ni los componentes C4/C5.

---

## Para ti (no es para Lovable)

Es la cita editorial destacada: la pieza donde el serif italic (Newsreader en Lovable, Source Serif 4 en producción) tiene su momento grande. Vivirá en `/sobre-nosotros`, en las entradas de `/criterio` y puntualmente en `/afinacion`.

Dos cosas a vigilar en el screenshot de validación: (1) que la regla fina superior se vea como separador sobrio y no se pierda, y (2) que la atribución de abajo salga con el estilo del kicker mono C5 —el pull quote reutiliza ese átomo para el pie, no inventa estilo nuevo. Las citas de muestra son copy de marca real, sirven de placeholder.

Pásale a Lovable solo el bloque de abajo.

---

## ▼ BLOQUE PARA LOVABLE ▼

### Alcance estricto

- Trabajar SOLO en la ruta `/componentes`.
- AÑADIR una sección nueva debajo de la sección existente `C5 · KICKER MONO`. NO modificar C4, C5, el shell (header/footer) ni ninguna otra ruta (`/cinematografico` intacta).
- Misma separación vertical entre secciones que ya usa la galería (128px).

### Qué es C6

La cita editorial destacada: una frase que se saca del cuerpo de texto y se agranda para que pese. Es un componente protagonista (a diferencia del kicker, que es metadato). Reutiliza el átomo C5 (kicker mono) para su línea de atribución.

### Tratamiento de la cita (texto principal)

- Familia: **Newsreader italic** (sustituto de Source Serif 4 Italic). Italic siempre.
- Tamaño: **`clamp(1.75rem, 1.2rem + 2.5vw, 2.75rem)`** (escala con el viewport; ≈28px móvil → ≈44px escritorio). SÍ escala, al contrario que el kicker.
- Peso: **Regular (400)**. NO bold; el italic ya da el carácter.
- Line-height: **1.25** (apretado, bloque compacto).
- Alineación: **izquierda**.
- Medida máxima: **680px** (`max-width: 680px`); la cita no ocupa todo el ancho de escritorio, se contiene a la izquierda dentro de ese ancho.
- Color según `tono` (ver abajo).
- SIN comillas decorativas (nada de glifo `"` gigante). Si una cita concreta lleva comillas internas, se usan las angulares españolas «» como caracteres del texto.

### Regla fina superior

- Encima de la cita, una **regla horizontal de 1px**, ancho **48px**, alineada a la izquierda.
- Separación entre la regla y la cita: ~24px.
- Color de la regla según `tono`:
  - `tono="oscuro"` → `#C9C4B8` (grafito-200).
  - `tono="claro"` → `#3F3D38` (grafito-600).

### Atribución (opcional)

- Debajo de la cita (~24px de separación), renderizada con el **mismo estilo del kicker mono C5** (JetBrains Mono Medium, 13px, uppercase por CSS, tracking 0.08em).
- Reutilizar el componente C5 si es posible; el `tono` del kicker debe casar con el fondo (`oscuro` sobre claro, `claro` sobre oscuro).
- El separador `·` va como carácter dentro del string.
- Si no se pasa atribución, la cita se muestra sola, sin pie y sin espacio reservado.

### Tonos (prop `tono`)

Solo dos valores:

- **`oscuro`** (default) → cita en `#1A1A22` (grafito-900), para fondos claros (papel).
- **`claro`** → cita en `#EFEAE0` (papel-100), para fondos oscuros (grafito, tinta).

NO añadir variante en tinta `#1F3050` para el texto de la cita (tinta no se usa en texto largo).

### API del componente

- `cita` (string, requerido) — el texto de la cita.
- `atribucion` (string, opcional) — render como kicker mono C5; si falta, no se muestra pie.
- `tono` — `"oscuro"` (default) | `"claro"`.

NO añadir props de tamaño, color libre, alineación ni comillas decorativas. Rígido como C5.

### Cómo mostrarlo en la galería

Sección con rótulo de desarrollo encima: `C6 · PULL QUOTE` (mono, pequeño, gris — igual que los rótulos de C4/C5). Debajo, **dos tarjetas de muestra apiladas**, cada una con su fondo real, padding generoso (ej. 64px) y esquinas ligeramente redondeadas:

1. **Fondo papel-200 `#E5DFD0`**, `tono="oscuro"`, CON atribución:
   - cita: `Un restaurante en forma también se afina. Como un piano bien tocado, que necesita templarse cada cierto tiempo.`
   - atribucion: `Gastrototem · Criterio`
2. **Fondo grafito `#1A1A22`**, `tono="claro"`, SIN atribución:
   - cita: `Donde otros ven una comida, nosotros leemos un restaurante.`

Bajo cada tarjeta (fuera de la tarjeta), un micro-rótulo de desarrollo en mono pequeño y gris:
- Tarjeta 1: `tono="oscuro" + atribución`
- Tarjeta 2: `tono="claro" sin atribución`

Tanto el rótulo `C6 · PULL QUOTE` como los micro-rótulos son solo para la galería de desarrollo; no forman parte del componente.

### Notas

- Newsreader y JetBrains Mono ya están cargadas en el proyecto; no añadir imports de fuente nuevos.
- La atribución pasa al componente en caja natural ("Gastrototem · Criterio"); el estilo de kicker la sube a mayúsculas por CSS.

### Criterios de aceptación

- Existe una sección `C6 · PULL QUOTE` debajo de `C5 · KICKER MONO` en `/componentes`.
- C4, C5 y el shell quedan sin cambios.
- Las dos tarjetas se ven con sus fondos correctos (papel-200, grafito).
- La cita sale en Newsreader italic, tamaño grande, alineada a la izquierda, con medida contenida (no ocupa todo el ancho en escritorio).
- La regla fina de 48px aparece encima de cada cita, alineada a la izquierda, en el color correcto según fondo.
- La atribución de la tarjeta 1 sale con estilo de kicker mono (mayúsculas, mono, tracking); la tarjeta 2 no tiene pie.
- Contraste correcto: grafito sobre papel-200, papel sobre grafito.

## ▲ FIN DEL BLOQUE PARA LOVABLE ▲
