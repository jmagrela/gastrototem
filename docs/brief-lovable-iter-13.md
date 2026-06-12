# Brief Lovable · iteración 13 · Footer

**Ruta:** `/cinematografico` — añadir el footer al final de la página, después de la sección dummy. Será el footer global del sitio (aparecerá en todas las páginas), pero lo montamos y validamos aquí.

Footer oscuro sobre fondo grafito-900, estructura en cuatro zonas: CTA de cierre, navegación + contacto + zonas + legal, firma de marca, y línea de copyright. No tocar nada del hero, header, overlay, splash, ni sección dummy.

---

## Fondo y marco general

- Fondo: grafito-900 `#1A1A22` a todo el ancho.
- Texto base: papel-100 `#EFEAE0`.
- Texto secundario / auxiliar: grafito-200 `#C9C4B8` (para datos, copyright, etiquetas).
- Padding: 96px arriba / 64px abajo en desktop, 64px / 48px en mobile. Padding lateral igual al del resto del sitio (64px desktop, 32px tablet, 20px mobile).
- El footer es el único bloque del sitio que invierte a oscuro. Cierra el documento como una contraportada.

---

## Zona 1 — CTA de cierre (banda superior)

Bloque destacado, separado de las zonas inferiores por un margen amplio (96px desktop / 64px mobile).

- Kicker mono: `RESERVAR UNA SESIÓN` en JetBrains Mono 500, 12px, uppercase, letter-spacing `0.18em`, color grafito-200 `#C9C4B8`. Margin-bottom 16px.
- Línea grande CTA: "Verificar zonas y fechas →" en Inter Medium, tamaño grande (clamp aproximado 32px mobile → 56px desktop), color papel-100 `#EFEAE0`. La flecha → es Unicode.
- Hover (desktop): color pasa a tinta-300 (un azul claro legible sobre grafito, aproximadamente `#7B92C4`; si no existe ese stop, usar papel-100 con la flecha desplazándose). La flecha → hace `translateX(4px)` en 180ms.
- Click: navega a `/reservar`.
- Sin lockup en esta zona. El CTA queda limpio: solo kicker + línea grande.

Separador tras Zona 1: rule horizontal 1px grafito-600 `#3F3D38` a todo el ancho del contenedor, con margen vertical de 64px.

---

## Zona 2 — Navegación + contacto + zonas + legal (cuerpo, cuatro columnas)

Grid de cuatro columnas en desktop (≥1024px), dos columnas en tablet (768-1023px), una columna apilada en mobile (<768px). Gap generoso entre columnas (48px desktop).

Cada columna tiene un encabezado en mono pequeño y debajo su contenido.

**Columna 1 — Navegación.**
- Encabezado mono: `NAVEGACIÓN` (JetBrains Mono 500, 11px, uppercase, letter-spacing `0.18em`, color grafito-200). Margin-bottom 20px.
- Lista vertical, sin numerales romanos:
  - Afinación → /afinacion
  - Criterio → /criterio
  - Sobre nosotros → /sobre-nosotros
  - Contacto → /contacto
  - Mi cuenta → /mi-cuenta
- Cada item: Inter Regular 16px, color papel-100, line-height generoso (2.0 aprox). Hover (desktop): color tinta-300 / papel con leve desplazamiento, 180ms.

**Columna 2 — Contacto.**
- Encabezado mono: `CONTACTO`. Mismo estilo.
- info@gastrototem.com (mailto link).
- +34 609 50 17 07 (tel link).
- Inter Regular 16px, papel-100. Sin direcciones físicas.

**Columna 3 — Zonas.**
- Encabezado mono: `ZONAS ABIERTAS`. Mismo estilo.
- Contenido dinámico: leer del plugin de reservas qué zonas están abiertas actualmente. En esta maqueta de Lovable (sin conexión al plugin real), usar contenido placeholder estático:
  - Granada
  - Málaga
  - Sevilla
  - (debajo, en grafito-200 más pequeño) "Próximamente más zonas"
- Inter Regular 16px, papel-100.
- Nota para producción (no implementar ahora, solo dejar comentario en el código): en WordPress este bloque leerá dinámicamente las zonas activas del plugin `gastrototem-booking`. Si no hay datos, fallback a "Consultar agenda".

**Columna 4 — Legal.**
- Encabezado mono: `LEGAL`. Mismo estilo.
- Aviso legal → /aviso-legal
- Privacidad → /privacidad
- Cookies → /cookies
- Inter Regular 16px, papel-100. Hover igual que navegación.

Separador tras Zona 2: rule horizontal 1px grafito-600 `#3F3D38` a todo el ancho, margen vertical 48px.

---

## Zona 3 — Firma de marca (banda inferior)

Fila con dos elementos, alineados verticalmente al centro. En desktop: lockup a la izquierda, descriptor a la derecha (space-between). En mobile: apilados, lockup arriba, descriptor debajo, ambos alineados a la izquierda.

**Lockup (izquierda):** lockup horizontal en variante knockout sobre grafito. El cuadrado del mark es papel `#EFEAE0` con el símbolo recortado dejando ver el fondo grafito a través; el wordmark "Gastrototem." en papel `#EFEAE0`. Ancho 160px desktop / 130px mobile.

Usar este SVG inline (es el knockout sin `<mask>`, con `fill-rule="evenodd"`, robusto):

```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 404.6 92.2" aria-label="Gastrototem">
  <path fill="#EFEAE0" fillRule="evenodd" d="M12,0 L80.2,0 A12,12 0 0 1 92.2,12 L92.2,80.2 A12,12 0 0 1 80.2,92.2 L12,92.2 A12,12 0 0 1 0,80.2 L0,12 A12,12 0 0 1 12,0 Z M64.6,54.7c-.7,2.9-2.3,5.6-4.9,8.2-4.3,4.3-9.2,6.3-14.9,6-5.8-.1-11.3-2.8-16.4-7.9-5.2-5.2-7.9-10.8-8.2-16.8-.3-6,1.9-11.3,6.6-16.1s8.4-6.3,12.9-6.7c4.5-.4,8.5.8,12,3.5l-6.6,6.6c-2.7-1.7-5.5-2-8.3-.9-1.6.6-3,1.6-4.4,3-2.6,2.6-3.7,5.7-3.4,9.3.3,3.6,2.4,7.4,6.3,11.3s7.6,5.8,11.1,5.7c3.4-.2,6.3-1.4,8.6-3.7s3.4-4.7,3.6-7.5c.1-2.7-.7-5.3-2.4-7.8l-7.4,7.4-5.4-5.4,13.4-13.4,17.2,17.2-4.4,4.4-4.7-3.3c.2,2.8.1,5.1-.3,6.7Z M70.7,60.3 L80,60.3 L80,69.5 L70.7,69.5 Z"/>
  <g transform="translate(117.7, 28.35)" fill="#EFEAE0">
    <path d="M22.3,33.8c-1.9,1.1-4.2,1.7-6.9,1.7-4.5,0-8.1-1.6-11-4.7C1.5,27.8,0,23.5,0,18.1S1.5,8.2,4.5,4.9C7.5,1.6,11.5,0,16.4,0s7.7,1.1,10.3,3.3c2.6,2.2,4.1,4.9,4.5,8.1h-6.9c-.5-2.3-1.8-3.9-3.9-4.8-1.2-.5-2.5-.8-3.9-.8-2.7,0-5,1-6.7,3.1-1.7,2.1-2.6,5.1-2.6,9.3s.9,7.1,2.8,8.8c1.9,1.7,4,2.6,6.5,2.6s4.3-.7,5.8-2.1c1.5-1.4,2.4-3.2,2.8-5.4h-7.8v-5.6h14.1v18.1h-4.7l-.7-4.2c-1.4,1.6-2.6,2.7-3.7,3.4Z"/>
    <path d="M38.5,12.4c1.7-2.2,4.7-3.3,8.9-3.3s5.2.5,7.3,1.6,3.2,3.1,3.2,6.1v11.5c0,.8,0,1.8,0,2.9,0,.9.2,1.4.4,1.7.2.3.5.6,1,.8v1h-7.1c-.2-.5-.3-1-.4-1.4,0-.4-.1-.9-.2-1.5-.9,1-1.9,1.8-3.1,2.5-1.4.8-3,1.2-4.8,1.2s-4.1-.6-5.6-1.9c-1.5-1.3-2.2-3.1-2.2-5.5s1.2-5.3,3.6-6.7c1.3-.7,3.2-1.3,5.7-1.6l2.2-.3c1.2-.2,2.1-.3,2.6-.6.9-.4,1.4-1,1.4-1.9s-.4-1.7-1.1-2.1c-.7-.4-1.8-.6-3.1-.6s-2.6.4-3.3,1.1c-.5.6-.8,1.3-.9,2.3h-6.3c.1-2.2.7-4,1.8-5.4ZM43.4,29.9c.6.5,1.4.8,2.2.8,1.4,0,2.7-.4,3.9-1.2,1.2-.8,1.8-2.3,1.8-4.5v-2.4c-.4.3-.8.5-1.2.6-.4.2-1,.3-1.7.4l-1.5.3c-1.4.2-2.4.5-3,.9-1,.6-1.5,1.5-1.5,2.8s.3,1.9.9,2.4Z"/>
    <path d="M80.9,10.8c2,1.3,3.1,3.4,3.4,6.5h-6.5c0-.8-.3-1.5-.7-2-.7-.9-1.9-1.3-3.7-1.3s-2.4.2-3,.7c-.6.4-.9,1-.9,1.6s.3,1.3,1,1.6c.6.4,2.9,1,6.8,1.8,2.6.6,4.5,1.5,5.8,2.8,1.3,1.3,1.9,2.8,1.9,4.7s-.9,4.5-2.8,6.1c-1.8,1.6-4.7,2.3-8.5,2.3s-6.8-.8-8.7-2.5c-1.9-1.7-2.8-3.8-2.8-6.3h6.6c.1,1.2.4,2,.9,2.5.8.9,2.3,1.3,4.5,1.3s2.3-.2,3.1-.6c.8-.4,1.1-1,1.1-1.7s-.3-1.3-.9-1.7-2.9-1-6.8-2c-2.8-.7-4.8-1.6-6-2.6-1.2-1-1.7-2.5-1.7-4.5s.9-4.3,2.7-5.9,4.4-2.5,7.6-2.5,5.7.6,7.6,1.9Z"/>
    <path d="M101.2,30v4.9h-3.1c-3.1.2-5.2-.3-6.3-1.5-.7-.7-1.1-1.9-1.1-3.5v-15.4h-3.5v-4.7h3.5V2.9h6.5v7h4.1v4.7h-4.1v13.2c0,1,.1,1.7.4,1.9s1.1.4,2.4.4.4,0,.6,0c.2,0,.4,0,.7,0Z"/>
    <path d="M118,15.7c-2.6,0-4.4.9-5.3,2.6-.5,1-.8,2.4-.8,4.4v11.9h-6.6V9.7h6.2v4.4c1-1.7,1.9-2.8,2.6-3.4,1.2-1,2.8-1.5,4.8-1.5s.2,0,.3,0c0,0,.3,0,.6,0v6.7c-.4,0-.8,0-1.1,0-.3,0-.6,0-.8,0Z"/>
    <path d="M144.5,12.8c2.1,2.6,3.2,5.8,3.2,9.4s-1.1,6.8-3.2,9.4c-2.1,2.6-5.3,3.9-9.6,3.9s-7.5-1.3-9.6-3.9c-2.1-2.6-3.2-5.7-3.2-9.4s1.1-6.7,3.2-9.4c2.1-2.6,5.3-4,9.6-4s7.5,1.3,9.6,4ZM134.9,14.4c-1.9,0-3.4.7-4.4,2-1,1.4-1.5,3.3-1.5,5.8s.5,4.4,1.5,5.8c1,1.4,2.5,2,4.4,2s3.4-.7,4.4-2c1-1.4,1.5-3.3,1.5-5.8s-.5-4.4-1.5-5.8c-1-1.4-2.5-2-4.4-2Z"/>
    <path d="M163.8,30v4.9h-3.1c-3.1.2-5.2-.3-6.3-1.5-.7-.7-1.1-1.9-1.1-3.5v-15.4h-3.5v-4.7h3.5V2.9h6.5v7h4.1v4.7h-4.1v13.2c0,1,.1,1.7.4,1.9s1.1.4,2.4.4.4,0,.6,0,.4,0,.7,0Z"/>
    <path d="M188.8,12.8c2.1,2.6,3.2,5.8,3.2,9.4s-1.1,6.8-3.2,9.4c-2.1,2.6-5.3,3.9-9.6,3.9s-7.5-1.3-9.6-3.9c-2.1-2.6-3.2-5.7-3.2-9.4s1.1-6.7,3.2-9.4c2.1-2.6,5.3-4,9.6-4s7.5,1.3,9.6,4ZM179.2,14.4c-1.9,0-3.4.7-4.4,2-1,1.4-1.5,3.3-1.5,5.8s.5,4.4,1.5,5.8c1,1.4,2.5,2,4.4,2s3.4-.7,4.4-2c1-1.4,1.5-3.3,1.5-5.8s-.5-4.4-1.5-5.8c-1-1.4-2.5-2-4.4-2Z"/>
    <path d="M208,30v4.9h-3.1c-3.1.2-5.2-.3-6.3-1.5-.7-.7-1.1-1.9-1.1-3.5v-15.4h-3.5v-4.7h3.5V2.9h6.5v7h4.1v4.7h-4.1v13.2c0,1,.1,1.7.4,1.9s1.1.4,2.4.4.4,0,.6,0c.2,0,.4,0,.7,0Z"/>
    <path d="M233.6,27.3c-.2,1.5-.9,3-2.3,4.5-2.1,2.4-5.1,3.6-9,3.6s-6-1-8.4-3.1c-2.4-2-3.6-5.4-3.6-10s1.1-7.6,3.3-9.9,5-3.5,8.5-3.5,3.9.4,5.6,1.2c1.7.8,3,2,4.1,3.7,1,1.5,1.6,3.2,1.9,5.2.2,1.1.2,2.8.2,4.9h-17.1c0,2.5.9,4.3,2.4,5.3.9.6,2,.9,3.3.9s2.4-.4,3.3-1.1c.5-.4.9-1,1.2-1.7h6.7ZM227.2,19.7c-.1-1.7-.6-3-1.6-3.9s-2.1-1.3-3.5-1.3-2.7.5-3.5,1.4c-.8.9-1.4,2.2-1.6,3.8h10.1Z"/>
    <path d="M252.4,16.5c-.6-1.2-1.6-1.8-3.2-1.8s-3.1.6-3.8,1.8c-.4.7-.5,1.7-.5,3.1v15h-6.6V9.7h6.3v3.6c.8-1.3,1.6-2.2,2.3-2.8,1.3-1,2.9-1.5,4.9-1.5s3.5.4,4.6,1.3c.9.8,1.7,1.8,2.2,3,.9-1.5,1.9-2.5,3.2-3.2,1.3-.7,2.8-1,4.5-1s2.2.2,3.3.6c1.1.4,2,1.2,2.9,2.2.7.9,1.2,1.9,1.4,3.2.2.8.2,2.1.2,3.7v15.7h-6.7v-15.9c0-.9-.2-1.7-.5-2.3-.6-1.2-1.7-1.7-3.2-1.7s-3,.7-3.7,2.2c-.4.8-.5,1.7-.5,2.9v14.9h-6.6v-14.9c0-1.5-.2-2.6-.5-3.2Z"/>
    <path d="M279.9,27.8h6.9v6.8h-6.9v-6.8Z"/>
  </g>
</svg>
```

**Descriptor (derecha):** texto "Una firma de Alta Afinación Gastronómica · Andalucía" en Inter Regular 14px, color grafito-200 `#C9C4B8`. En desktop alineado a la derecha; en mobile alineado a la izquierda bajo el lockup.

Separador tras Zona 3: rule horizontal 1px grafito-600 `#3F3D38` a todo el ancho, margen vertical 32px.

---

## Zona 4 — Copyright (pie del pie)

Fila final, dos elementos en space-between (desktop) o apilados (mobile):

- Izquierda: `© MMXXVI GASTROTOTEM · ANDALUCÍA` en JetBrains Mono 400, 11px, uppercase, letter-spacing `0.18em`, color grafito-200 `#C9C4B8`.
- Derecha: `N.º 001` en el mismo estilo mono (identificador editorial, eco del que aparece en el hero).

---

## prefers-reduced-motion

No aplica especialmente al footer (no tiene animaciones más allá de los hovers de 180ms). Los hovers respetan el comportamiento estándar.

---

## Lo que NO se toca

- Hero, header, overlay, splash, hero sticky con zoom, sección dummy.
- Lógica de scroll del header.
- Cualquier componente existente del shell.

El footer se añade como bloque nuevo al final del flujo de la página, después de la sección dummy.

---

## Validación posterior

1. Footer completo en desktop: verificar las cuatro zonas, las cuatro columnas de Zona 2 alineadas, los separadores entre zonas, el lockup knockout sobre grafito en Zona 3 (cuadrado papel con símbolo recortado dejando ver el grafito a través).
2. Footer en mobile: columnas apiladas, lockup y descriptor apilados en Zona 3, copyright apilado en Zona 4.
3. Hover sobre items de navegación y sobre el CTA de cierre: cambio de color + desplazamiento de la flecha en el CTA.
4. Verificar que el lockup knockout renderiza correctamente (cuadrado papel claro, no oscuro). Si renderiza como cuadrado oscuro con símbolo claro, el knockout falló — reportar.
