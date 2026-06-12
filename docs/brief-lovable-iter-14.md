# Brief Lovable · iteración 14 · Ruta `/componentes` + C4 CTA primario

**Ruta:** crear ruta NUEVA `/componentes`. No tocar `/cinematografico` ni ninguna otra ruta existente.

Esta ruta es una galería de componentes para validar las piezas reutilizables del sitio antes de montar las páginas reales. Llevará el shell completo (header + footer reales) alrededor. En esta iteración montamos el primer componente: el CTA primario (C4).

---

## Estructura de la ruta `/componentes`

- Header del sitio arriba (el mismo `SiteShell` o componente de header que usa `/cinematografico`). En esta ruta el header arranca directamente en estado B sólido (fondo papel-100, lockup grafito, border-bottom), porque `/componentes` no tiene hero oscuro. Sin lógica de ocultación durante hero (no hay hero). El header puede quedar fijo arriba o con show-on-scroll-up estándar — para esta galería, déjalo fijo siempre visible.
- Cuerpo: fondo papel-100 `#EFEAE0`. Cada componente se monta en una sección con un pequeño rótulo identificador encima (mono, gris) que diga el nombre del componente, p.ej. `C4 · CTA PRIMARIO`. Este rótulo es solo para la galería de desarrollo, no formará parte del componente en producción.
- Footer del sitio abajo (el mismo footer de `/cinematografico`).
- Padding vertical generoso entre componentes (128px) para que respiren en la galería.

El splash NO debe aparecer en `/componentes` (es solo para la home / rutas cinematográficas). Si el splash está montado globalmente, asegurar que no se dispara aquí, o que respeta el sessionStorage.

---

## Componente C4 · CTA primario

Bloque de llamada a la acción de ancho completo, pensado para cerrar secciones dentro de las páginas. Fondo tinta (azul firma), el único bloque del sitio que usa el azul de marca como fondo a sangre.

### Estructura visual

Bloque a todo el ancho del viewport (full-bleed), con el contenido centrado en un contenedor con max-width y padding lateral estándar (64px desktop / 32px tablet / 20px mobile).

- **Fondo:** tinta-500 `#1F3050` a sangre.
- **Padding interno vertical:** 96px arriba y abajo en desktop, 72px en tablet, 56px en mobile.
- **Alineación del contenido:** a la izquierda (no centrado), siguiendo el patrón editorial del resto del sitio.

### Contenido, de arriba a abajo

1. **Kicker (mono):**
   - Texto: `RESERVAR UNA SESIÓN`
   - Estilo: JetBrains Mono 500, 12px, uppercase, letter-spacing `0.18em`.
   - Color: papel-100 a 70% de opacidad, o el stop tinta-200 si existe un azul claro legible. Aproximación segura: `rgba(239, 234, 224, 0.7)`.
   - Margin-bottom: 20px.

2. **Titular (Inter):**
   - Texto por defecto: "Una visita basta para empezar a afinar."
   - Estilo: Inter Medium (peso 500), tamaño grande con clamp aproximado `clamp(32px, 5vw, 56px)`, line-height 1.1.
   - Color: papel-100 `#EFEAE0`.
   - Max-width del titular: aproximadamente 16-18 caracteres por línea para que rompa en 2 líneas en desktop ("Una visita basta para / empezar a afinar."). Ajustar max-width en `ch` o px hasta lograr ese quiebre.
   - Margin-bottom: 32px.
   - **Importante:** este titular debe ser fácilmente sobreescribible por página. Implementarlo como prop del componente (p.ej. `title`) con el valor por defecto indicado. En la galería se muestra el default.

3. **Botón de acción:**
   - Texto: "Verificar zonas y fechas →" (flecha → Unicode).
   - Estilo: Inter Medium, 18px desktop / 16px mobile.
   - Tratamiento: enlace de texto con la flecha, NO botón con caja rellena. Coherente con los CTA del hero y footer.
   - Color: papel-100 `#EFEAE0`.
   - Hover (desktop): el texto se mantiene papel-100, la flecha → hace `translateX(4px)` en 180ms. Opcionalmente, aparece un subrayado fino (1px) bajo el texto en hover.
   - Click: navega a `/reservar`.
   - Margin-bottom: 24px.

4. **Línea de apoyo (mono, opcional pero incluida por defecto):**
   - Texto: `UNA VISITA · UN AFINAMIENTO · UN PDF FIRMADO EN EL ACTO`
   - Estilo: JetBrains Mono 400, 11px, uppercase, letter-spacing `0.18em`.
   - Color: papel-100 a 50% de opacidad: `rgba(239, 234, 224, 0.5)`.
   - Esta línea también sobreescribible/ocultable por prop (p.ej. `supportLine`), pero visible por defecto.

### Props del componente (para reutilización futura)

```tsx
interface CTAPrimarioProps {
  kicker?: string;        // default: "RESERVAR UNA SESIÓN"
  title?: string;         // default: "Una visita basta para empezar a afinar."
  ctaLabel?: string;      // default: "Verificar zonas y fechas →"
  ctaHref?: string;       // default: "/reservar"
  supportLine?: string;   // default: "UNA VISITA · UN AFINAMIENTO · UN PDF FIRMADO EN EL ACTO"
  showSupportLine?: boolean; // default: true
}
```

### Responsive

- Desktop (≥1024px): titular a `clamp` máximo, padding 96px vertical.
- Tablet (768-1023px): titular intermedio, padding 72px.
- Mobile (<768px): titular mínimo del clamp, padding 56px, la línea de apoyo mono puede romper en 2 líneas (está bien).

### prefers-reduced-motion

El único movimiento es el `translateX` de la flecha en hover (180ms). Con `prefers-reduced-motion: reduce`, desactivar ese desplazamiento (la flecha queda fija, solo cambia el subrayado si se implementó).

---

## Lo que NO se toca

- `/cinematografico` y todos sus componentes (hero, header, overlay, splash, footer).
- Cualquier lógica existente del shell.

`/componentes` es una ruta nueva e independiente. Reutiliza el header y footer existentes (importándolos como componentes), pero no los modifica.

---

## Validación posterior

1. Cargar `/componentes` en desktop: header sólido arriba, rótulo `C4 · CTA PRIMARIO`, el bloque CTA con fondo tinta azul, kicker + titular en 2 líneas + botón + línea de apoyo, footer abajo.
2. Mobile: mismo bloque, titular en el tamaño mínimo del clamp, padding reducido, línea de apoyo legible (puede romper en 2 líneas).
3. Hover sobre el botón "Verificar zonas y fechas →": la flecha se desplaza 4px a la derecha.
4. Verificar que el fondo es tinta `#1F3050` (azul firma), no grafito ni negro.
5. Verificar que el header arranca en estado sólido (papel) directamente, sin estado transparente (no hay hero oscuro en esta ruta).
