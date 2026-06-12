# Handoff — Cierre de F3 · a3 · Pieza 1 → apertura del PR `style:` y la Pieza 2

> Documento de traspaso para arrancar en sesión limpia.
> Claude no conserva memoria entre conversaciones; este doc restituye el contexto.
> **Inyectar al inicio de la nueva sesión.** Cuando quede obsoleto, commitearlo con cabecera `OBSOLETO`, no borrarlo.
> **No commitear tokens ni valores de secretos** (solo nombres de variables).
>
> Repo: `gastrototem-org/gastrototem-app` · App: `sesion.gastrototem.com` · Staging WP: `2026.gastrototem.com`
> Worker PartyKit: `gastrototem-sync` (sin tocar en todo F3).
> `main` al cerrar este handoff: **`3184af2`** (Merge PR #49) · 572 tests verdes · **DESPLEGADO en prod** (`main`↔prod convergen desde el cierre de la Pieza 1).
> Deployment de prod vigente: `dpl_FMT7nSM9NHMoEf91S2LDMGLgemyy`.
> Plataforma: **Vercel Pro** (subido durante la sesión anterior; antes era Hobby). Fluid compute ON.

---

## 0. En una frase

La **Pieza 1 de a3 está CERRADA**: el tubo cliente del motor de redacción funciona de punta a punta en producción (genera un informe largo real, lo persiste y lo muestra), y el fix del timeout que el smoke destapó está en prod. Quedan dos frentes: un **PR `style:`** trivial que salda deuda de lint acumulada (despacharlo primero, deja `main` limpio), y la **Pieza 2** — la pantalla de revisión/edición del informe, con la frontera del "firmar" como decisión gorda a diseñar.

---

## 1. Estado actual (qué está hecho)

`main` en `3184af2`. `pnpm typecheck` + `pnpm test:run` verdes (572). `pnpm build` verde. Deploys manuales por CC (`npx vercel@latest deploy --prod`); sin CI. `GTT_PLUGIN_BASE_URL` → staging (`https://2026.gastrototem.com/wp-json/gastrototem-afinacion/v1`). `ANTHROPIC_API_KEY` + `R2_*` (`R2_ACCESS_KEY_ID/R2_SECRET_ACCESS_KEY/R2_BUCKET_NAME/R2_ENDPOINT`) + `GTT_PLUGIN_BASE_URL` confirmadas en Production.

**Lado servidor del motor (a1+a2) — CERRADO, en main, en prod.** Store `gtt_session_reports` (`version(5)`), tipo `Report` en `src/types/db.ts`. Endpoint `POST /api/redaccion/generate` (`src/app/api/redaccion/generate/route.ts`): auth Bearer que corta antes de Claude (401/410/404), `assembleUserMessage` (vallado de tres capas), `system` = destilado (`docs/prompt-redaccion.md`, leído en runtime con `fs.readFileSync` + `outputFileTracingIncludes`), traza pesada best-effort a R2. Devuelve `{ markdown, traceRef, modelo, destiladoVersion }`. Tipos en `src/types/redaccion.ts`.

**Pieza 1 de a3 (tubo cliente) — CERRADA, en main, en prod, smoke verde.**
- `src/lib/redaccion/requestBody.ts` — `buildRedaccionBody(session, notes, menuItems)` puro: mapea dominio→contrato (`datos` ← restaurant.name/address; `brief` ← restaurant.concept/currentChallenges/focusAreas; `notas` planas con block y menuItemId; `carta` ← menu_items vivos). `regenerar` omitido. Fotos fuera por diseño.
- `src/lib/redaccion/generate.ts` — `postAndPersistInforme(body, sessionToken, deviceId?)`: `fetch` con Bearer (espeja el patrón de `src/lib/carta/extract.ts`); **solo al 200 persiste 1 fila `Report`** (`estado:'borrador'`); error → sin fila huérfana.
- `src/lib/db/reports.ts` — `createReport`/`getReport`/`listReports` (molde `createNote`: uuid v7, timestamps, deviceId sellado, `versionFinalFirmada:null`, `deletedAt:null`). Export en `db/index.ts`. **Sin publisher de sync** (eso es Pieza 3).
- `src/components/informe/InformePanel.tsx` — render del markdown en **crudo** (`<pre>` solo lectura, overlay `fixed inset-0 z-50`), incluye el bloque `## Auditoría interna` **literal**. Botón "Volver".
- `src/components/informe/InformeLauncher.tsx` — botón **derivado de `listReports`**: 0 filas → "Generar informe" (POST); ≥1 → "Ver informe" (abre la más reciente sin POST). Estado en vuelo `phase: 'idle'|'generando'|'error'` en React (no fila), bloquea el disparador. `view: 'captura'|'informe'`. `openReport` guarda el **objeto** `Report` (no el id) para pintar sin esperar a que la consulta reactiva se repueble.
- Montado en `src/app/sesion/[token]/page.tsx` junto a `CapturaZone` dentro de `SyncProvider`. Copy en `src/lib/copy.ts` (dominio informe).

**Fix del timeout (PR #49) — en main, en prod.** El smoke destapó un 502 por timeout del SDK (30 s) en informes largos. Solución en `route.ts`, **solo-redaccion** (extract intacto, sus constantes son locales e independientes):
- `messages.create` → `messages.stream` + `await stream.finalMessage()` (acumulación y contrato de respuesta intactos).
- `export const runtime = "nodejs"` (fija la dependencia dura de `fs`).
- `export const maxDuration = 300` (techo de Pro).
- `REDACCION_TIMEOUT_MS = 280_000` (un poco por debajo de `maxDuration` para que un corte lo dé nuestro catch → 502, no Vercel → 504).
- `REDACCION_MAX_RETRIES = 0` (un reintento de una generación larga no cabe en `maxDuration` y duplica el reloj; si falla, el usuario reintenta con el botón).
- Guard del log del catch (PR #48) **permanente**: `console.error` con `err.status`+`err.message`, sin payload.

---

## 2. Decisiones cerradas — NO relitigar

- **Reparto cliente/servidor:** cliente envía datos **estructurados**; servidor serializa+valla. Cliente persiste `Report`; servidor persiste la traza (R2, best-effort). Fotos fuera del input.
- **Persistir la fila solo al éxito (200).** `'generando'` es estado de UI en vuelo (React), nunca fila; bloquea el disparador. El valor `'generando'` del enum se queda en el tipo para la Pieza 3.
- **Pantalla propia del informe = toggle in-island** (`view`), `InformePanel` como overlay `fixed inset-0 z-50`, botón "Volver". **Sin sub-ruta** (evita una segunda validación del token; el informe es estado efímero en IndexedDB). Si en el futuro se necesita enlace compartible, se añade sin rehacer.
- **Botón derivado de `listReports`:** no duplica informes ni gasta llamadas. La regeneración real (`regenerar:true` → Opus) vive en la Pieza 2, no aquí.
- **Render en crudo** en Pieza 1; el formato legible se decide en Pieza 2 (`react-markdown` + `remark-gfm` es la dependencia candidata, no añadida aún por §14).
- **El bloque `## Auditoría interna` se devuelve y muestra literal.** Lo borra el humano en la Pieza 2 — nunca el servidor ni el cliente.
- **Fix del timeout** (streaming + maxDuration 300 + timeout 280 + retries 0 + runtime nodejs) tal cual; **no tocar `/api/menu/extract`** (funciona con 30 s, constantes locales).

---

## 3. Lo siguiente (orden recomendado)

**Bloque 0 — PR `style:` (primero, trivial).** Recoge toda la deuda de lint de un golpe, **sin mezclar con código funcional**:
- `simple-import-sort` en: `src/lib/db/index.ts` (**regenerar con `eslint --fix`**, no depender de ningún stash), `party/persistence.test.ts`, `src/app/api/redaccion/generate/route.ts`, `src/lib/redaccion/assemble.ts`.
- La línea `datos:` en `route.ts` (formato previo re-colapsado).
- Rama `style/...`, PR, merge tras aprobación. No requiere deploy.

**Bloque a3 · Pieza 2 — pantalla de revisión/edición.** Decisiones de diseño a abrir una a una:
- Render del markdown: ¿formateado (añadir `react-markdown`+`remark-gfm`) o seguir en crudo editable? (decisión abierta).
- Edición del markdown del informe.
- Borrado del bloque `## Auditoría interna` (acción del humano).
- **Frontera del "firmar" / freeze** (la decisión gorda): `versionFinalFirmada` pasa de `null` a string, `estado: 'borrador' → 'firmado'`. Definir qué significa firmar, si es reversible, y la UX. **Empezar el diseño por aquí.**
- Regeneración con Opus (`regenerar:true`) vive en esta pieza.

**Pieza 3 (después).** Cableado de sync de `gtt_session_reports` (lectura a dos móviles; entra en juego el `'generando'` del enum; publisher de sync).

**Bloque b y siguientes.** PDF, envío (Resend), espejo a Drive.

---

## 4. Deudas técnicas registradas

Las del `style:` (arriba) + flake en `client.test.ts` (hardening con fake timers), presencia badge (ubicación primero, luego contraste), import-order. Estado vivo en `project_phase_status.md` (actualizado por CC al cerrar la Pieza 1).

---

## 5. Marca y voz (lo que toca)

La pantalla de edición de la Pieza 2 es UI nueva → respeta cabecera **"GASTROTOTEM · ANDALUCÍA"** (inmóvil), léxico vetado (optimizar/mejorar/transformar/premium/etc.), logo siempre **SVG vectorial** (nunca `font-family`), colores oficiales (Tinta `#1F3050`, Papel `#EFEAE0`, Grafito `#1A1A22`; semánticos solo en UI funcional), tipografía web (Inter body/UI; Source Serif 4 Italic acentos; JetBrains Mono datos). El contenido del informe lo produce el destilado, no la Pieza 2. El informe **no mide el trabajo en tiempo** (excepciones "en el acto" / "entre 15 y 30 días"); lo garantiza el destilado.

---

## 6. Método y gates (estándar)

- **Una cosa a la vez, bloque a bloque.** Claude propone borradores propositivos; el custodio reacciona. "Ok"/"sí" = avanzar sin re-resumir lo cerrado.
- **El custodio NO es ingeniero:** micro-pasos atómicos, comando exacto, archivo exacto, dónde clicar; nunca "como antes"; si falta un dato de entorno, preguntar ese dato concreto.
- **Claude (arquitectura) diseña y revisa; Claude Code ejecuta el repo.** Para bloques con UI + deploy: **plan + verify-first primero, sin código**, revisar el plan antes de implementar. Relays a CC en bloques aislados y copiables, con contexto inyectado y guardas verify-first ("verifica X; si no se cumple, PARA y reporta").
- **Gates:** rama `feat/...` o `style/...`, **NUNCA push directo a `main`**, `pnpm typecheck` + `pnpm test:run` (+ `build` cuando toque rutas/tracing) verdes, **CC pausa y espera aprobación explícita antes de mergear**. Vía PR. Commits atómicos.
- **Smoke con peer real = condición de cierre** de cualquier bloque que toque deploy/runtime. Deploys manuales por CC tras aprobación.
- **Idioma:** español.

---

## 7. Aprendizajes de la sesión de cierre de la Pieza 1

- **El destilado en runtime sobre Vercel FUNCIONA** (`outputFileTracingIncludes` + `fs.readFileSync` a nivel de módulo). Era el riesgo técnico abierto de F3; queda despejado.
- **El smoke con peer real es diagnóstico, no solo validación.** Destapó dos riesgos invisibles al build local: el timeout estructural y que el plan de Vercel (Hobby) ni soportaba el producto ni encajaba con un negocio comercial. Hacerlo antes de invertir en UI fue acertado.
- **Generaciones largas de LLM en serverless:** patrón = streaming + `maxDuration` (acorde al plan) + timeout del SDK alineado y algo por debajo de `maxDuration` (para que el corte lo dé el catch → 502, no la plataforma → 504) + `maxRetries: 0`. El **plan de la plataforma es un límite duro a verificar ANTES de diseñar** (Hobby 60 s, Pro 300 s). En Pro, el tiempo esperando I/O (la llamada a Claude) no cuenta como CPU facturable.
- **Un `catch {}` ciego en un endpoint de pago es deuda:** debe loguear `err.status`+`err.message` (sin payload). Sin eso, un 502 no es diagnosticable.
- **Diagnóstico disciplinado:** instrumentar primero (1 línea de log), observar, y arreglar con conocimiento — no un fix especulativo. Comparar el endpoint que funciona (`extract`) con el que falla (`redaccion`) fue diagnóstico gratuito antes de desplegar nada.

---

*Estado al cerrar este handoff: `main@3184af2` (Merge PR #49), 572 tests verdes, desplegado en prod (`dpl_FMT7nSM9NHMoEf91S2LDMGLgemyy`, alias `sesion.gastrototem.com`). Pieza 1 de a3 cerrada (tubo cliente + render crudo + deploy + smoke real verde) y fix del timeout en prod. Siguiente: PR `style:` (trivial, primero) → Pieza 2 (revisión/edición; abrir el diseño por la frontera del firmar). Pieza 3 (sync) después.*
