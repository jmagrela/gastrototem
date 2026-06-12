# v1 — Claude Code (diseño manual)

**Origen:** generado por Claude Code en abril 2026 a partir de las especificaciones del proyecto (CLAUDE.md, Plan de Marketing, Manual Estratégico). Diseño completamente manual, sin herramientas de generación visual.

**Estado:** completa. 5 páginas + blog de 7 posts (los posts están en `/blog/` de la raíz, no aquí).

## Sistema visual

- **Paleta:** B&N puro. Negro `#0a0a0a`, blanco, off-white `#f7f7f5`, grises cálidos. **Sin acento cromático.**
- **Tipografía:** Cormorant Garamond (serif) + Montserrat (sans).
- **Logo:** wordmark `GASTROTOTEM` en caja negra.
- **Texturas:** noise overlay sutil (opacidad 0.025).

## Páginas incluidas

- `index.html` — Home
- `afinacion/` — Detalle del servicio
- `criterio/` — Blog
- `nosotros/` — Equipo
- `contacto/` — Formulario
- `aviso-legal/`, `privacidad/`, `cookies/` — Legales

## Cómo previsualizar

Desde la raíz del proyecto:
```bash
npx serve versions/v1-claude-code/
```

## Diferencias con `site/` y `theme/` de la raíz

Esta carpeta es un **snapshot estático** para comparación. El sistema vivo está en:
- `site/` — versión estática original (idéntica a esta).
- `theme/gastrototem-astra-child/` — tema WordPress hijo basado en Astra (lo que va a producción).

Ambos están congelados en el tag de git `design-v1-claude-code`.

## Lo que ya identificamos como mejorable (ver análisis)

1. Falta tensión visual — todo es elegante pero no engancha en 3 segundos.
2. Logo plano sin memorabilidad.
3. **Cero fotografía** — el plan dice "fotografía gastronómica de calidad" pero solo hay placeholders grises.
4. Hero compite consigo mismo (demasiados elementos).
5. Cero diferenciación sectorial — podría ser cualquier estudio.
6. CTAs idénticos sin jerarquía.
7. Cifras solo operativas, sin emocionales.
8. **Sin prueba social** — autoridad afirmada, no demostrada.

Estas observaciones son el input que alimenta los superprompts de v2 y v3.
