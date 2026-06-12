# Handoff · Gastrototem web (WordPress) · web pública feature-complete → criba de copy + MARCA v1.1

> Documento autocontenido. Pégalo entero al abrir la conversación nueva. Resume el estado real de la web pública tras cerrar 404 + legales + housekeeping, y cómo seguir. **Las fuentes de verdad (MARCA.md, CONTRACT.md, CLAUDE.md) mandan sobre cualquier recuerdo.** Donde diga «verificar contra código», se hace antes de construir. CC arranca con contexto limpio: todo lo que necesite va inyectado en los prompts. **HEAD y hashes: verificar con `git log --oneline` al abrir** (nunca asumir estado de merge/deploy).

---

## 0. Cómo trabajamos (guardarraíles)

**Ritmo**
- **Prompts LARGOS a CC que abarquen MUCHO trabajo en una pasada.** Avanzar ágil y **revisar concienzudamente DESPUÉS**, sobre lo construido, en vez de fraccionar en piezas o validar con checkpoints intermedios. Los conjuntos de páginas se plantean de una sola pasada.
- Lo que NO cambia: las **decisiones de diseño/marca van una a una** (Claude propone borradores propositivos, Juanma reacciona; «dale / dale caña / sí / venga» cierran y se procede sin re-resumir). Lo que insulta a Juanma es repetir lo mismo dos veces, no el ritmo.
- **KILL CRITIC**: recomendación comprometida, no menú equidistante.

**Regla de parada de CC** (para no frenar a mitad de un bloque grande)
- Corrección de marca con solución obvia (palabra vetada con sustituto claro, color fuera de paleta a su token): aplícala, anótala, sigue.
- Lo dudoso o de criterio de custodio sin corrección clara: marcador visible `[REVISAR-MARCA: …]` y sigue.
- Vuelve a mitad SOLO si un error técnico bloquea build o deploy.
- Reporta al final: correcciones aplicadas + marcadores `[REVISAR-MARCA]`.

**Gates irreversibles que SÍ se mantienen**
- Deploy: `./deploy.sh --dry-run`; el destino debe contener **`/2026/`** y **cero líneas `deleting`**; si falla cualquiera, parar. La salida del dry-run se devuelve **literal** (no resumida).
- **Nunca push a `main`. Nunca tocar producción.** Nada de cuentas/pagos.

**Mecánica**
- Sin puente Claude.ai ↔ CC. Claude corre aislado y sin red. El único puente es Juanma pegando.
- Juanma no es ingeniero: micro-pasos atómicos para SUS acciones; si falta un dato del entorno, pedir ese dato concreto.
- Prompts a CC: contexto entre marcadores `▼`/`▲` (CC no ve el chat); guardas verify-first («verifica X; si se cumple haz Y; si no, para y avisa»); **commits atómicos por concepto**; `git add` SOLO de lo tocado, **nunca** arrastrar untracked ajeno (`docs/`, `gastrototem-app/`, `midjourney/`, `versions/`).
- Working language: **español**.

---

## 1. Repositorio y stack

- Repo: `/Users/jmagrela/gastrototem`. Tema clásico PHP standalone en `theme/gastrototem` (NO Astra, NO child theme).
- Rama: **`feature/cimientos-finos`** (local, **sin pushear, sin mergear**).
- Hashes-faro de esta sesión (verificar con `git log`): `f504778` (HEAD al abrir, home ya completa) · interiores = commit de scaffolding + uno por página (hashes a verificar) · `8cc26fb` (404) · `27bc125` (deploy auto-purga, enmendado) · `0be827e` (legales, enmendado; era `f21383a`).
- Referencia de diseño: repo Lovable en `/Users/jmagrela/gastrototem-afinacion-editorial` (**solo lectura**). No se porta literal.
- Plugin `gastrototem-booking` v2.4.0 en staging; namespace REST `gastrototem/v1`. `/reservar` y `/mi-cuenta` son del plugin: **no se tocan**.
- CC no tiene PHP local: un error de sintaxis sale en el deploy a staging, nunca en producción → staging-first importa.
- Hosting: **Hostinger** (LiteSpeed; server `hcdn`).

---

## 2. Fuentes de verdad

- **`docs/MARCA.md`** (v1.0) — ley sobre Lovable, el código del tema y los defaults de herramientas. CC lo lee al abrir sesión.
- `CONTRACT.md`, `CLAUDE.md` — en el proyecto.
- SVGs oficiales en `theme/gastrototem/assets/brand/`.
- Recordatorios clave: header inamovible **«GASTROTOTEM · ANDALUCÍA»** (sin otros topónimos, sin «España»); tinta `#1F3050` / papel `#EFEAE0` / grafito `#1A1A22`; **tinta nunca texto sobre fondo oscuro** → sobre oscuro, acentos en Source Serif 4 Italic **papel**; logo siempre SVG vector; `#1d1d1b` → `#1A1A22`; aliados (Mazzocco, Linkers, Goma Brand, Pilsa Educa) **jamás en salida pública NI en reportes**.

---

## 3. deploy.sh y caché

- `rsync` del working tree de `theme/gastrototem/`. Por defecto → **STAGING**; la RUTA de deploy contiene **`/2026/`** (guarda del dry-run). La **URL pública** de staging es **`https://2026.gastrototem.com/`** (la ruta `gastrototem.com/2026/` da 404). Producción solo con `./deploy.sh production`. **Intocable** hasta terminar.
- **LiteSpeed**: la **auto-purga ya está integrada** en `deploy.sh` (commit `27bc125`): purga por entorno (staging→staging, prod→prod), tolerante a fallo (un fallo de purga no rompe el deploy). Ya no hace falta purgar a mano tras deploy de tema.

---

## 4. Sistema tipográfico (tokens.css)

- Tres pilas en uso: `--gtt-font-sans` (Inter), `--gtt-font-serif` (Source Serif 4 Italic, solo acentos/citas), `--gtt-font-mono` (JetBrains Mono, kickers/datos/tablas).
- **Pendiente MARCA v1.1**: oficializar **JetBrains Mono** como tercera familia (MARCA §4.1 solo lista Inter + Source Serif 4 Italic; el tema ya la usa).
- Contenedores: `content` 64rem, `prose` 38rem (`.gtt-doc-prose`). **Convención blindada: cero hex y cero `font-family` literales fuera de `tokens.css`; todo por `var(--gtt-*)`.**

---

## 5. Qué está construido (web pública — feature-complete en staging)

Todo verificado en staging (desktop + móvil + nav), HTTP 200, plantilla correcta, sin errores PHP.

- **Shell**: header con cerebro `IntersectionObserver` + pieles por `data-gtt-context`; auto-hide sobre banda; splash papel (solo home, una vez por sesión). Footer tinta (4 columnas + CTA «Verificar zonas y fechas»; email único canal, sin teléfono, sin «España»).
- **Contextos de header** vía `gtt_header_context()`: `home` · `document` (interiores + legales) · `flat` (`/reservar`, `/mi-cuenta`) · `404`.
- **HOME** (`front-page.php`): hero sticky con foto, grano y parallax 24px; cuerpo (qué hacemos, los pasos, precio 1.000 € + IVA, tarjetas de zona, pull-quote). Validada y cerrada.
- **Interiores** (4, páginas propias `page-{slug}.php`, contexto `document`, banda-apertura tinta + secciones bespoke):
  - `/afinacion` — pasos · precio 1.000 € + 3 tarjetas de zona estáticas (Málaga abierta · **Granada sin fechas** · Sevilla próximamente) · bloque **Afinación en Profundidad** 3.500 € + IVA (sin CTA de reserva; CTA **«Escríbenos»** → `mailto:info@gastrototem.com`; nunca «Premium»; clases genéricas `gtt-profundidad`).
  - `/criterio` — el punto de vista (2 párrafos) · grid 2×2 «Las cuatro miradas» (Carta/Sala/Servicio/Ritmo) · pull-quote.
  - `/nosotros` — el oficio (3 párrafos) · «Los dos» (Huidobro «Afinador de cartas» · Málaga · «Fundador de la Academia Andaluza de Gastronomía y Turismo»; Agrela «divulgador gastronómico y especialista en comunicación» · Granada) · pull-quote. (Slug real = `/nosotros`.)
  - `/contacto` — canales: Correo (`info@gastrototem.com`, email único) · Reservar → `/afinacion` · La firma (descriptor). **Sin formulario, sin teléfono.**
- **Legales** (3, `page-{slug}.php`, patrón documento, slugs reales `aviso-legal` / `privacidad` / `cookies`, añadidos a `gtt_interior_page_slugs()`):
  - Titular: **GASTROTOTEM S.L. · CIF B90123514 · C/ Bartolomé de Medina, 24 · 41004 Sevilla · info@gastrototem.com**.
  - **Registro Mercantil: decisión de custodio de NO incluirlo** (sin marcador). *Matiz factual para la gestoría: LSSI-CE Art. 10 lo pide para una S.L.*
  - Encargados nombrados: **Hostinger International Ltd.** (hosting) y **Stripe** (pasarela de pago). [Estos NO son los «aliados» vetados.]
  - Política de cookies: tabla con las cookies REALES auditadas (ver §8). Las 3 Pages estaban en draft (IDs 16/18/20) → **publicadas con wp-cli, `_wp_page_template=default`** (sin GOTCHA), LiteSpeed purgado.
- **404** (`404.php`, commit `8cc26fb`): campo tinta a pantalla completa (100vh); header en rama `404` **forzado-transparente** (logo papel invertido, sin auto-hide ni toggle a sólido); micro-script de arranque transparente extendido a `404`. Copy: kicker mono «Error 404» · «La página que buscas no está **aquí**.» («aquí» en serif italic papel) · CTA «Volver al inicio» → home.

---

## 6. Decisiones de marca de esta sesión

- **«informe firmado»** en todo el copy (sustituye a «PDF firmado»). Decisión de custodio. **Pendiente de oficializar en MARCA v1.1** (§5.5 tagline operacional + §9 glosario + `prompt-redaccion.md` de la app). Mientras tanto se inyecta a CC para que no lo revuelva a «PDF» citando MARCA v1.0.
- **Afinación en Profundidad**: CTA «Escríbenos» (no «Consultar» — vetada §5.3), nunca «Premium», sin CTA de reserva.
- **4 interiores = páginas propias** (no `template-documento.php`); **3 legales = patrón documento**. `template-documento.php` queda intacto para documento largo de verdad.
- **/contacto sin formulario y sin teléfono** (email único canal).
- **Banner de cookies: no necesario ahora** (solo cookies técnicas; ver §8).
- **Registro Mercantil: no se incluye** en los legales.

---

## 7. Siguiente bloque: CRIBA DE COPY + MARCA v1.1

Bloque de marca/custodio (Juanma propone-reacciona, una decisión a una). Cubre:

1. **MARCA v1.1** (custodio: Juanma):
   - Oficializar **«informe firmado»**: tagline operacional §5.5, glosario §9, y `prompt-redaccion.md` (repo de la app — es otra conversación/proyecto, coordinar).
   - Añadir **JetBrains Mono** como tercera familia tipográfica (§4.1).
   - Commit con mensaje de versión claro (§10.3).
2. **Criba fina de todo el copy público** (home + 4 interiores + 3 legales) contra MARCA §5.2/§5.3 (léxico propio/vetado), taglines textuales §5.5, voz §7. En esta sesión CC no dejó ningún `[REVISAR-MARCA]`, pero la criba es la pasada deliberada y atenta sobre el copy ya publicado.

Esto puede avanzar **en paralelo** a la espera de la gestoría; no depende de ella.

---

## 8. Ruta a producción (checklist) + cabos / parkings

**Antes de promocionar:**
- [ ] **Gestoría**: revisar los tres legales (incl. la decisión registral y el matiz LSSI Art. 10) antes de tocar producción.
- [ ] **Criba de copy + MARCA v1.1** (§7).

**Mecánica de promoción a producción** (cuando Juanma dé el go):
- [ ] `./deploy.sh production` (sin `/2026/`; producción hasta ahora **intocable**).
- [ ] **Re-publicar las 3 Pages legales en prod** (presumiblemente en draft allí, como estaban en staging) y limpiar su `_wp_page_template`.
- [ ] **Limpiar Pages de prueba en wp-admin** (dominio de Juanma): `test`, `prueba-de-banda`, `pagina-plana`, `zonas`. (`/cinematografico` y `/componentes` no existen en ningún sitio — no hay nada que borrar en el tema.)

**Inventario de cookies (auditado en staging)** — todas técnicas/necesarias, navegación anónima = **0 cookies**:

| Cookie | Titular | Finalidad | Duración |
|---|---|---|---|
| `__stripe_mid` / `__stripe_sid` | Stripe | Antifraude / seguridad de pago | 1 año / 30 min |
| `wordpress_logged_in_*` / `wp-settings-*` | WordPress | Sesión / preferencias (tras login) | sesión / 1 año |
| `_lscache_vary` | LiteSpeed (Hostinger) | Variación de caché (tras login) | sesión |

→ Solo técnicas → exentas Art. 22.2 LSSI → **sin banner ahora**.

**Radar / parkings:**
- [ ] **GA4 + Meta Pixel** (previstos en el plan de marketing): en cuanto entren, la política de cookies se actualiza y el **banner de consentimiento pasa a ser OBLIGATORIO**. No montarlo antes.
- [ ] **Script `accounts.google.com/gsi/client`** (botón «Acceder con Google» de «Mi cuenta»): carga global en todas las páginas; no instala cookies en navegación pasiva, pero conviene **acotarlo a la página de cuenta**. Verificar antes si lo enquela el tema o el plugin (plugin = no tocar sin más). Declarado como tercero en la política.
- [ ] (Opcional, recomendado por vender la Sesión online) **Condiciones de contratación** (4.ª página legal). El footer hoy solo enlaza las tres.
- [ ] Deuda Prettier.
- La PWA `sesion.gastrototem.com` es **otro proyecto** (otra conversación); no se toca aquí. El cambio de `prompt-redaccion.md` por «informe firmado» se coordina con ese repo.

---

## 9. Aprendizajes clave de la sesión

- **Aliados (Mazzocco/Linkers/Goma Brand/Pilsa Educa) jamás se nombran — ni siquiera en los reportes de CC.** Esta sesión hubo un falso positivo: CC llamó «bloque Mazzocco» al de Afinación en Profundidad en su propio reporte; el repo estaba limpio (grep en código, nombres de archivo y mensajes de commit = 0). Aun así, la regla más cara de violar (§8.1) merece el grep ante la mínima señal.
- **Caracteres multibyte/«smart» (…, comillas tipográficas) pegados en scripts de shell revientan bajo `set -u`** (`ENV: unbound variable`). Usar `${VAR}` y ASCII. (Incidencia en la línea de purga, resuelta y enmendada local.)
- **GOTCHA de Pages en draft**: una Page en draft no sirve su `page-{slug}.php` hasta **publicarla** y dejar `_wp_page_template=default` (vía wp-cli, sin GOTCHA). **Se repetirá al promocionar a producción** (las legales también estarán en draft allí).
- **Cookie audit**: navegación anónima = 0 cookies; solo técnicas (Stripe/WP/LiteSpeed). Hosting = Hostinger (auto-detectado, nombrado como encargado).
- **Verificar el estado real renderizado, no el recuerdo**: un «Granada con fechas» del reporte era error de lectura; home y `/afinacion` renderizan idéntico (sin fechas).

---

*Fin del handoff. Rama `feature/cimientos-finos`, sin push, producción intocable. La web pública está feature-complete en staging; lo que queda es criba de copy + MARCA v1.1, revisión de gestoría y la mecánica de promoción. HEAD y hashes a verificar al abrir.*
