# Handoff · Gastrototem Web · Sesión de componentes C5–C10

Documento de traspaso para abrir una sesión limpia. Resume el estado del trabajo de la web `2026.gastrototem.com` tras cerrar el shell completo de `/cinematografico` y el primer componente C4. State-passing.

---

## Qué es esto y de dónde viene

Trabajo en la web 2026 de Gastrototem (firma andaluza de Alta Afinación Gastronómica). Flujo de producción de tres etapas: **Midjourney** (banco fotográfico) → **Lovable** (prototipo visual) → **Claude Code** (producción WordPress + Astra Pro). La memoria de marca completa está en userMemories y en `/mnt/project/` (manual v1.1, propuesta de modelo de negocio, SVG assets, contract).

La sesión anterior cerró el **shell cinematográfico completo** y el **primer componente reutilizable**. Esta sesión nueva continúa con los componentes restantes.

---

## Estado: qué está CERRADO

### Shell completo de `/cinematografico` (en Lovable)

Página completa de arriba a abajo, validada:

- **Splash inicial** tipo Netflix: lockup vertical principal (cuadrado tinta + símbolo papel + wordmark grafito) centrado sobre papel-100, 1.2s estático, fade-out de opacidad (sin scale/zoom), sessionStorage (una vez por sesión), prefers-reduced-motion. Tras el splash, el header hace slide-in desde arriba.
- **Hero cinematográfico**: imagen `plato-002.webp` a sangre con overlay degradado abajo→arriba; tagline en 3 líneas ("Donde otros ven una comida, / nosotros *leemos* / un restaurante."); "leemos" en Newsreader italic + tinta; descripción; dos CTAs ("Verificar zonas y fechas →" y "Ver cómo afinamos"); pie "UNA VISITA · UN AFINAMIENTO · UN PDF FIRMADO EN EL ACTO" + "LÁM. I — SALA VACÍA"; cabecera "GASTROTOTEM · ANDALUCÍA" + "N.º 001 · MMXXVI" + "FOLIO I — APERTURA".
- **Hero sticky con zoom**: al scrollear, hero queda sticky; la imagen hace zoom continuo 1.0→1.05 (linear); el texto hace fade 1.0→0.4 con curva ease-out cubic (no escala); prefers-reduced-motion lo desactiva.
- **Header con dos estados**: A (transparente, lockup knockout, sobre hero oscuro) y B (sólido papel-100 + border-bottom, lockup grafito). Comportamiento de scroll: **oculto durante el hero** (excepto top absoluto, umbral 20px); visible en estado A arriba del todo; visible en estado B una vez pasado el hero (heroH·0.95); el crossfade A↔B ocurre mientras el header está oculto.
- **Overlay del menú**: pantalla completa papel-200; header permanece visible encima; crossfade del lockup a grafito-sobre-papel al abrir; 5 items con numerales romanos (I Afinación, II Criterio, III Sobre nosotros, IV Contacto, rule, V Mi cuenta); CTA "RESERVAR UNA SESIÓN / Verificar zonas y fechas →"; morph hamburguesa→X; focus trap; cierra con X/item/Escape, no con click en fondo.
- **Footer** (oscuro, grafito-900): 4 zonas — CTA de cierre ("RESERVAR UNA SESIÓN / Verificar zonas y fechas →"), cuerpo de 4 columnas (Navegación / Contacto / Zonas Abiertas / Legal), firma de marca (lockup knockout + "Una firma de Alta Afinación Gastronómica · Andalucía"), copyright ("© MMXXVI GASTROTOTEM · ANDALUCÍA" + "N.º 001"). La columna Zonas usa placeholder estático (Granada/Málaga/Sevilla + "Próximamente más zonas"); en producción leerá del plugin `gastrototem-booking`.

### Ruta `/componentes` (galería, en Lovable)

Ruta nueva con shell completo alrededor (header sólido + footer). Catálogo de componentes reutilizables. El splash NO aparece aquí.

### Componente C4 · CTA primario (cerrado)

Bloque full-bleed sobre fondo tinta `#1F3050` (único bloque del sitio con el azul firma como fondo). Kicker mono "RESERVAR UNA SESIÓN" (70% opacidad) + titular Inter Medium "Una visita basta para empezar a afinar." (sobreescribible por prop, rompe en 2 líneas) + botón "Verificar zonas y fechas →" (flecha translateX 4px en hover) + línea de apoyo mono "UNA VISITA · UN AFINAMIENTO · UN PDF FIRMADO EN EL ACTO" (50% opacidad). Implementado con props (`title`, `kicker`, `ctaLabel`, `ctaHref`, `supportLine`, `showSupportLine`) para reutilización por página.

---

## Estado: qué queda PENDIENTE (objetivo de la sesión nueva)

### Componentes C5–C10

**IMPORTANTE — corregir el inventario.** El inventario que arrastraba la sesión anterior decía "C4-C10: CTA primario, tarjeta zona con plugin, bloque OJA, pull quote, kicker mono, FAQ acordeón". Dos problemas detectados y resueltos:

1. **"bloque OJA" es un error de transcripción.** No corresponde a nada del léxico de marca ni de los archivos del proyecto. Se elimina del inventario. No inventar un componente para rellenar ese hueco.
2. El recuento no cuadraba (6 nombres para 7 códigos C4–C10). **Primera tarea de la sesión nueva: fijar el inventario real de componentes consultando los archivos del proyecto y la memoria, antes de diseñar nada.**

Componentes razonablemente confirmados que quedan (a validar el listado definitivo al abrir):
- **Tarjeta de zona** (con lectura del plugin: nombre de zona, estado de disponibilidad, fechas).
- **Pull quote** (cita destacada editorial).
- **Kicker mono** (la etiqueta monoespaciada ya usada por todo el sitio; formalizarla como componente átomo).
- **FAQ acordeón.**

Orden recomendado: **kicker mono primero** (es el átomo que ya usan los demás), luego pull quote, tarjeta de zona, FAQ.

### Después de los componentes (fases siguientes, NO en esta sesión)

- **Fase 2 — Páginas**: Home, /afinacion, /sobre-nosotros, /criterio (índice + entrada), /contacto, 404.
- **Fase 3 — Plugin rediseñado**: /reservar (7 pasos), /mi-cuenta, /acceder, /reserva-confirmada, /reserva-cancelada.
- **Fase 4 — Templates email** (~14).
- **Fase 5 — Block patterns + ACF blocks Gutenberg.**
- **Fase 6 — Auditoría + cleanups.**
- **Lote textual**: aviso legal, privacidad, cookies.
- **PROCESO-OPERATIVO.md**: documento de lecciones, a escribir al final.

---

## Deudas técnicas conocidas (resueltas en producción, NO en Lovable)

1. **Lockup knockout en estado A (header) y en footer**: en Lovable renderiza como placeholder (cuadrado oscuro con G tipográfica + wordmark en font-family), NO como el SVG real knockout. Esto es un comportamiento sistemático de Lovable con SVGs que llevan el wordmark completo. **En producción WordPress (Claude Code) se incrusta el SVG real con `file_get_contents()` desde `/assets/brand/`** y renderiza perfecto. El usuario indicó que ya están resueltas en su instancia de Lovable; verificar al abrir si procede.
2. **Splash lockup vertical**: mismo riesgo de placeholder; misma resolución en producción.

Los SVG reales construidos en la sesión anterior (todos sin `<mask>`, con `fill-rule="evenodd"`, robustos a duplicados): lockup horizontal knockout, lockup horizontal grafito-sobre-papel, lockup vertical principal. Están en los outputs de la sesión anterior y deben re-adjuntarse o re-incrustarse según se necesiten.

---

## Convenciones BLINDADAS (no preguntar, aplicar)

- **Header del sitio**: "GASTROTOTEM · ANDALUCÍA" — INAMOVIBLE. No probar variantes Granada/Málaga/Sevilla.
- **Cromática**: Tinta-500 `#1F3050` (firma), Papel-100 `#EFEAE0` (fondo), Papel-200 `#E5DFD0` (overlay), Grafito-900 `#1A1A22` (texto/footer), Grafito-600 `#3F3D38` (rules sobre oscuro), Grafito-200 `#C9C4B8` (rules/auxiliar). Si en un SVG aparece `#1D1D1B` (default Illustrator), sustituir por `#1A1A22`.
- **Tipografía**: Inter (cuerpo, UI, titulares), Instrument Serif Italic (acentos editoriales puntuales — en Lovable se usa Newsreader italic como sustituto), JetBrains Mono (kickers, datos). Logo Gastrototem SIEMPRE SVG vectorial, nunca font-family.
- **Taglines**: Conceptual "Donde otros ven una comida, nosotros leemos un restaurante." Operativo "Una visita. Una conversación. Un PDF firmado. En el acto." Descriptor "Una firma de Alta Afinación Gastronómica."
- **Léxico**: afinar/afinación/afinamiento/afinador. Vetados: optimizar, mejorar, transformar, refinar, asesorar, consultar, excelencia, innovación, sinergia, premium, top, vip, pasión, comunidad, familia, holístico, integral, 360, journey, ecosistema.
- **El trabajo NO se mide en tiempo.** Vetar duraciones en copy ("tres horas", "una jornada", "dos días"). Excepciones: "en el acto" (entrega PDF) y "entre 15 y 30 días" (llamada de control posterior).

---

## Método de trabajo (respetar)

- **Borradores propositivos, no cuestionarios.** Claude propone decisiones concretas con razonamiento; el usuario reacciona.
- **Bloque a bloque, una decisión a la vez.** Validar antes de avanzar. Nunca presentar una fase entera de golpe.
- **Briefs Lovable en `.md` limpio**, separando lo que es para el usuario (prosa) de lo que es para Lovable (bloque copiable). SVGs van inline dentro del propio brief (no como adjunto: la cadena de adjuntos se rompe). El usuario pasa solo el `.md` a Lovable.
- **Para variantes nuevas en Lovable, pedir ruta nueva explícita** ("no tocar la ruta anterior"). Lovable mezcla iteraciones si se pide "modificación" sobre la misma ruta.
- **Verificar contraste de TODO el texto sobre foto**, no solo la palabra-acento. Verificar con screenshot real de Lovable, no con mockup local (el clamp de Lovable da tamaños mayores de lo que estima un render local).
- **Decisiones de diseño cerradas en conversación → un brief Lovable → screenshots de validación → cierre.**
- Cuando Lovable afirme haber implementado algo que no se ve en pantalla: hacer **pregunta diagnóstica** (no consume iteración de código) antes de gastar otra iteración. Patrón recurrente con SVGs complejos.

---

## Entornos activos

- **Lovable**: prototipo visual. Rutas activas: `/cinematografico` (shell completo cerrado), `/componentes` (galería con C4 cerrado, pendiente C5–C10).
- **Midjourney**: v8 alpha. Estructura prompt validada: `--ar 16:9 --style raw --v 8 --s 75`. Banco fotográfico con plato-002 en uso. (MJ v8 alpha NO respeta posiciones porcentuales numéricas — solo left/right + large/small, y aun así se desvía.)
- **Claude Code** (producción WordPress, fases posteriores): theme base + plugin `gastrototem-booking`.

---

## Primera acción de la sesión nueva

1. Leer este handoff + userMemories + archivos de `/mnt/project/`.
2. **Fijar el inventario real de componentes C5–C10** consultando archivos del proyecto y memoria (corregir el desajuste de recuento, confirmar que "OJA" se elimina).
3. Proponer orden de trabajo (recomendado: kicker mono primero).
4. Empezar bloque a bloque con el primer componente, en borrador propositivo.
