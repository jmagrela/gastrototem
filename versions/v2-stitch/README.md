# v2 — Claude Code + Stitch (Google)

**Origen:** generación visual a través de las herramientas MCP de Stitch, orquestadas por Claude Code.

**Estado:** PENDIENTE de generar.

## Cómo generarla

1. Abre una sesión nueva de Claude Code en este repo.
2. Pega el contenido completo de [`docs/superprompt-claude-code-stitch.md`](../../docs/superprompt-claude-code-stitch.md).
3. Claude Code ejecutará el flujo: `create_project` → `create_design_system` → `update_design_system` → `generate_screen_from_text` ×5 → `apply_design_system` → `generate_variants`.
4. Espera a que termine las 5 pantallas (puede tardar 15-25 min).
5. Pídele que **exporte el HTML** de cada pantalla a esta carpeta:
   - `index.html` (home)
   - `afinacion/index.html`
   - `criterio/index.html`
   - `nosotros/index.html`
   - `contacto/index.html`
6. Si Stitch no exporta directamente HTML estático, captura screenshots de cada pantalla y guárdalos en `screenshots/` para comparación visual.

## Limitaciones conocidas de Stitch

- **Tipografía:** no incluye Cormorant Garamond. Usaremos `EB_GARAMOND` como sustituto más cercano.
- **Stitch optimiza para apps móviles/dashboards** — generar landings tipo revista editorial es menos natural para la herramienta. Esperar resultados más "producto" y menos "magazine".
- **El acento `--rouge` `#5C1A1B`** se pasa como `overrideSecondaryColor`, pero Stitch puede ignorarlo si su sistema de tokens lo reinterpreta.

## Qué evaluar al recibir el output

- ¿Stitch entendió la dirección editorial o cayó en patrones de SaaS?
- ¿Las 5 pantallas son coherentes entre sí?
- ¿Las imágenes generadas respetan la dirección B&N íntima?
- ¿El copy mantiene el tono o introdujo buzzwords?

## Cuando esté lista

Documenta aquí: link al proyecto Stitch, screenshots, decisiones forzadas por la herramienta y dónde difiere del ideal.
