# v3 — Claude.ai/design

**Origen:** generación directa desde la plataforma web de Anthropic (claude.ai/design).

**Estado:** PENDIENTE de generar.

## Cómo generarla

1. Abre [claude.ai/design](https://claude.ai/design) en el navegador.
2. Pega el contenido completo de [`docs/superprompt-claude-design.md`](../../docs/superprompt-claude-design.md).
3. Claude generará la home primero. Espera al render completo.
4. Itera por las otras 4 páginas pidiendo "ahora /afinacion", "ahora /criterio", etc.
5. **Descarga el código** (HTML + CSS) de cada página y guárdalo en esta carpeta:
   - `index.html` (home)
   - `afinacion/index.html`
   - `criterio/index.html`
   - `nosotros/index.html`
   - `contacto/index.html`
   - `assets/css/styles.css`
   - `assets/img/` (si genera imágenes)
6. También guarda screenshots de cada página en `screenshots/` por si el código no se exporta limpio.

## Qué evaluar al recibir el output

- ¿La home parece "dossier editorial impreso" o "landing de SaaS"?
- ¿El monograma G·T se materializó como sello visual?
- ¿El acento `--rouge` se usó con discreción quirúrgica o invadió la paleta?
- ¿Las 5 páginas mantienen coherencia tipográfica y de espaciado?
- ¿El código generado es production-ready o requiere reescritura?
- ¿Cumple PageSpeed > 85 móvil sin retoques?

## Diferencia esperada vs v2 (Stitch)

Claude.ai/design genera **código real** (HTML/CSS/JS). Stitch genera **mockups visuales** primero y luego permite exportar código. Por eso v3 debería ser más cercano al ideal editorial y más fácil de portar a producción que v2.

## Cuando esté lista

Documenta aquí: link a la sesión de claude.ai/design (si es compartible), screenshots, fragmentos de código que merezca la pena rescatar incluso si no se elige esta versión.
