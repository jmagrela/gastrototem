# MARCA.md

> Documento de marca de Gastrototem. Fuente única de verdad para identidad, léxico, voz y reglas de aplicación.
>
> Versión 1.1 · Junio 2026 · Aprobado por Fernando Huidobro y Juan M. Agrela
>
> Custodio único: Juan M. Agrela. Si este archivo cambia, sincroniza la copia del otro repositorio en el mismo commit cuando sea posible.

---

## 1. Para quién es este documento

Este documento lo lee **Claude Code** al abrir cada sesión de trabajo sobre cualquier repositorio de Gastrototem. Es el briefing de marca que el agente necesita para no contradecir la identidad de la firma al escribir código, copy, configuración o documentación.

Lo que aquí está escrito **prevalece sobre cualquier sugerencia genérica del agente**. Si una mejor práctica de la industria choca con una regla de este documento, gana este documento. Si una librería propone un componente que viola estas reglas, no se usa la librería tal cual — se adapta o se descarta.

Lo que aquí **no** está:
- Cómo se hace tal cosa técnicamente. Eso vive en el `CLAUDE.md` de cada repositorio.
- Stack, arquitectura, hosting, dependencias. Lo mismo: en cada `CLAUDE.md`.
- Historia, motivación, posicionamiento comercial. Eso vive en el sitio público y en el manual de marca v1.1 (PDF, no técnico).
- Léxico de redacción de informes detallado. Eso vive en `prompt-redaccion.md`. Este documento es más amplio y aplica a cualquier salida — no solo informes.

---

## 2. Qué es Gastrototem

**Categoría:** firma andaluza de **Alta Afinación Gastronómica**.

**No es:**
- agencia
- consultora
- crítica gastronómica al uso
- marketing hostelero
- branding
- formación

Cada vez que el agente escriba código, copy o documentación, debe recordar que la categoría es **afinación**, y solo afinación. Si una palabra de las prohibidas anteriores aparece en cualquier salida, está mal.

**Servicios:**
- **Sesión de Afinación** — 1.000 € + IVA. Único servicio público con CTA de reserva directa.
- **Afinación en Profundidad** — 3.500 € + IVA. Versión extendida. Mencionada discretamente, sin CTA, solo «consultar / escríbenos». **Nunca se llama «Premium».**

**Socios fundadores:**
- **Fernando Huidobro** · rol: «Afinador de cartas» · Málaga · título institucional: «Fundador de la Academia Andaluza de Gastronomía y Turismo» — nunca «Presidente de Honor».
- **Juan M. Agrela** · divulgador gastronómico y especialista en comunicación · Granada.

**Aliados internos** (Mazzocco Gourmet, Linkers, Goma Brand, Pilsa Educa): **nunca se nombran en salidas públicas**. En código, copy, documentación, comunicación al cliente — no aparecen. Si hay que referirse a ellos, se hace por categoría genérica (consultoría hostelera, branding gastronómico, formación, distribución gourmet).

**Cabecera del sitio (header inamovible):** «GASTROTOTEM · ANDALUCÍA». Sin variantes con Granada, Málaga, Sevilla ni cualquier otro toponímico. Si en cualquier archivo aparece escrito de otra forma, es un bug.

---

## 3. Paleta cromática

### 3.1 Colores principales

| Token | Hex | Rol |
|---|---|---|
| `tinta` | `#1F3050` | color de firma · fondos institucionales · marca principal |
| `papel` | `#EFEAE0` | fondos cálidos · sustituye al blanco puro |
| `grafito` | `#1A1A22` | texto largo · variante monocroma reservada |

### 3.2 Colores semánticos (solo UI, nunca branding)

| Token | Hex | Uso |
|---|---|---|
| `exito` | `#3D5A3A` | confirmaciones, éxito de operación |
| `aviso` | `#8B6B1F` | warnings, advertencias |
| `error` | `#7A2A2A` | errores, validaciones fallidas |

### 3.3 Reglas duras

- **El blanco puro `#FFFFFF` no se usa nunca como fondo.** Siempre `papel` (`#EFEAE0`).
- **El negro puro `#000000` no se usa nunca como texto.** Siempre `grafito` (`#1A1A22`).
- **`#1d1d1b`** (default de Illustrator) **es bug**. Si aparece en cualquier SVG, se sustituye por `grafito` `#1A1A22` antes de incorporarlo al repo.
- **Tinta es color-acento de palabra**, no color de texto largo. Válido sobre fondos claros o zonas fotográficas iluminadas. **Nunca tinta sobre fondos oscuros** — el contraste falla y la palabra desaparece.
- **No se usan fondos cromáticos no autorizados.** Solo `papel`, `papel puro` (raro, situaciones de máxima austeridad), `grafito` y `tinta`. Cualquier otro color de fondo rompe el sistema.
- **Variante principal del mark:** papel sobre tinta (cuadrado de fondo tinta, símbolo en papel). Variante grafito (monocroma) reservada para papelería oficial y prensa. **Todo mockup, web, social y presentación usa la principal por defecto** salvo indicación expresa.

### 3.4 Stops 50–900 por familia

Cada familia (tinta, papel, grafito) tiene una escala completa de stops del 50 al 900. La escala vive en el repo correspondiente como CSS custom properties. Solo los stops principales se exponen al selector de tema. Si un componente necesita un stop intermedio, accede vía `var(--familia-300)` directamente — no se añade al selector.

La implementación técnica concreta de la escala vive en `CLAUDE.md` del repo correspondiente.

---

## 4. Sistema tipográfico

### 4.1 Familias

- **Inter** (sans-serif) — sistema, UI, copy general, navegación, formularios.
- **Source Serif 4 Italic** — uso enfático, decorativo, reservado para taglines, citas y palabras-acento. **Nunca para párrafos largos.**
- **JetBrains Mono** (monospace) — datos, cifras, kickers, etiquetas y tablas (precios, fechas, códigos, encabezados de columna). Nunca para párrafos largos ni para el logotipo.

### 4.2 Reglas duras de uso

- **El logotipo es siempre SVG vector.** Nunca se reescribe con `font-family`. La palabra «Gastrototem» en el logotipo es una **path dentro del SVG**, no texto. Si en cualquier archivo aparece `font-family: 'Helvetica'` o similar para escribir «Gastrototem», es bug. Stop inmediato y vuelta atrás.
- **En cuerpo de texto (no logotipo)** la palabra «Gastrototem» se escribe en texto plano, hereda la tipografía del contexto (Inter normalmente).
- **Inter es la única sans-serif del sistema.** No se mezcla con Helvetica, Arial, system-ui ni nada similar. Si una librería viene con su propia sans, se sobreescribe.
- **Source Serif 4 Italic se usa con moderación.** Una palabra-acento por bloque como mucho. Una cita por sección. Si aparece más de eso, está mal.

### 4.3 SVGs oficiales del logotipo

Los archivos canónicos viven en `gastrototem.com/assets/brand/` (web pública), y en una copia local versionada dentro del repo de la app:

- `mark-gastrototem.svg` — solo el cuadrado (símbolo aislado)
- `wordmark-gastrototem.svg` — solo la palabra
- `lockup-horizontal-gastrototem.svg` — cuadrado + palabra en horizontal
- `lockup-vertical-gastrototem.svg` — cuadrado + palabra en vertical

### 4.4 Geometría del logotipo

- **Lockup horizontal:** el espacio entre el cuadrado y la palabra es **igual al ancho de una «o» del wordmark**. Ni más ni menos. Si Claude Code modifica un SVG y rompe esta proporción, el lockup deja de ser oficial.
- **Radio del cuadrado del mark:** 12 unidades sobre 92.2 totales (≈13%). No se cuadra a esquina recta, no se redondea más.
- **Área de protección:** alrededor del logo hay una zona libre **igual a la altura del propio mark**. Ningún elemento gráfico, fotográfico o tipográfico puede invadir esa zona.

### 4.5 Tamaños mínimos (cascada)

Cuando el espacio no permite el lockup completo, se desciende en cascada:

```
lockup → wordmark → mark → no usar logo
```

Mínimos absolutos:
- **Lockup horizontal:** 130 px / 32 mm
- **Wordmark:** 100 px / 25 mm
- **Mark:** 16 px / 8 mm

Por debajo del mínimo del mark, **no se usa logotipo**. Mejor el silencio que un logo ilegible.

---

## 5. Léxico de marca

### 5.1 Alcance de esta sección

El léxico que sigue aplica a **toda salida pública o semipública** de Gastrototem: copy de web, microcopy de UI, mensajes de error, emails transaccionales, descripciones de PR, comentarios de código que serán visibles, mensajes de commit, contenido de redes, slides, propuestas comerciales.

**No aplica** a comentarios internos privados de código (puedes comentar `// TODO: optimizar query` sin pánico) ni a documentación interna de implementación. Pero sí aplica a cualquier `string` que pueda llegar a un usuario.

**Para la redacción de informes de afinación** (el informe firmado), el léxico canónico vive en `prompt-redaccion.md`. Esa es la versión más detallada y específica. Si hay conflicto entre ambos documentos, **gana `prompt-redaccion.md` para informes** y **gana `MARCA.md` para todo lo demás**.

### 5.2 Palabras propias (úsalas siempre que el contexto lo permita)

| Palabra | En lugar de |
|---|---|
| afinar / afinación / afinamiento / afinador / afinado | mejorar, optimizar, ajustar, refinar |
| mesa | experiencia de cliente, customer experience |
| cliente más exigente | target, público objetivo, buyer persona |
| oficio | experiencia profesional |
| documento / informe firmado | reporte, auditoría |
| de incógnito | mystery shopping |
| lectura del restaurante | análisis |

**Distinción entre afinación y afinamiento:**
- *Afinación* es el sustantivo del **servicio** — Sesión de Afinación, contratar una afinación.
- *Afinamiento* es el término amplio para hablar del **proceso o resultado** — un afinamiento profundo, el oficio del afinamiento.

### 5.3 Palabras vetadas (jamás aparecen en salida pública)

excelencia · innovación · sinergia · garantizar · transformar · optimizar · ecosistema · customer journey · journey · holístico · integral · solución (genérica) · 360 · premium · top · élite · VIP · pasión · apasionados · apasionante · filosofía de… · comprometernos · compromiso (vacío) · innovador · disruptivo · vanguardia · familia · comunidad · fomentar · potenciar · impulsar · disfrutar · disfrute · apostar / apuesta · próxima generación · nueva era · asesorar / consultar · mejorar (genérico) · calidad sin más

**Aclaración sobre «mejorar»:** vetada cuando es verbo de promesa (*«mejoramos tu restaurante»*); tolerable cuando es descriptiva con objeto físico concreto (*«mejorar la temperatura del salmorejo»*). En la duda, usar **afinar**.

### 5.4 Palabras tolerables (con cuidado)

- **profesional / profesionales** — medido. No en cada párrafo.
- **trayectoria** — sin inflar.
- **crítica gastronómica** — solo en contexto histórico (linaje) o cuando aclara la diferencia con la afinación. Nunca como descripción del propio servicio.
- **equipo** — para el equipo del restaurante: sí. Para Gastrototem: no — son los socios, los afinadores, la firma.
- **privado / privacidad** — sí, sin hacer bandera obsesiva.
- **andaluz / Andalucía** — sin tópicos. *Firma andaluza* es válido. *Pasión andaluza, sabor andaluz* — fuera.
- **linaje** — solo en contexto histórico.

**Regla de método:** entre palabra propia y tolerable, elige la propia. Entre tolerable y vetada, no dudes — elige el silencio.

### 5.5 Taglines canónicos

- **Conceptual:** «Donde otros ven una comida, nosotros leemos un restaurante.»
- **Operacional:** «Una visita. Una conversación. Un informe firmado. En el acto.»
- **Descriptor:** «Gastrototem · Una firma de Alta Afinación Gastronómica.»

Estos tres taglines son **textuales**. No se reformulan, no se traducen libremente, no se acortan creativamente. Si Claude Code va a usar un tagline, lo cita exacto o no lo usa.

### 5.6 Lo que el trabajo nunca se mide en

**No se mide en horas, jornadas, días, mañanas, tardes.** Cualquier copy, microcopy, descripción de servicio o mensaje al cliente que diga «en tres horas observamos», «tras una jornada», «dos días de inmersión» o similar **es bug**.

**Excepciones permitidas (las únicas):**
- «en el acto» — referido a la entrega del informe firmado.
- «entre 15 y 30 días» — referido a la llamada de seguimiento.
- Horas y minutos del restaurante observado (datos del propio restaurante: «a las 14:25 entran tres mesas») — esto sí.

---

## 6. Referencia al destilado de redacción

Para **informes de afinación** (el informe firmado entregado al cliente al final de la sesión), existe un documento especializado:

**`prompt-redaccion.md`** — destilado de identidad y voz para el motor de redacción de informes. Custodio único: Juan M. Agrela.

Ese documento contiene:
- Identidad funcional del modelo de redacción (es traductor de notas, no autor)
- Estructura fija del informe (cinco secciones: Llegada, Platos, Sala, Coherencia, Veredicto)
- Unidad mínima Observación + Juicio + Acción
- Voz 03 (informe) frente a las otras voces de la marca
- Hoja de auditoría interna que el modelo se autoaplica

**Cuándo usar `MARCA.md` vs `prompt-redaccion.md`:**

| Situación | Documento que rige |
|---|---|
| Copy de web, UI, emails, redes | MARCA.md |
| Mensaje de commit o PR | MARCA.md (sección 5) |
| Cualquier cosa que vaya al informe firmado del cliente | prompt-redaccion.md |
| Configuración del prompt enviado a la API | prompt-redaccion.md |
| Componente UI que muestra un fragmento del informe | ambos: visualmente MARCA.md, contenido prompt-redaccion.md |

Si Claude Code está construyendo un componente, función o flujo que **toca el motor de redacción**, debe leer `prompt-redaccion.md` antes de empezar. Si solo toca UI o copy general, basta con MARCA.md.

---

## 7. Cinco principios de voz aplicados al producto

Los cinco principios viven completos en `prompt-redaccion.md`. Aquí los reformulo con foco en salidas técnicas — UI, microcopy, mensajes, errores, descripciones de producto. Son los mismos principios; cambia el contexto donde se aplican.

**01 · Autoridad sin condescendencia.**
En microcopy: nunca explicas al usuario «lo que tiene que entender». Le das información operativa y confías en que decida. Mal: *«Recuerda que es muy importante que rellenes todos los campos antes de enviar»*. Bien: *«Faltan tres campos por rellenar.»*

**02 · Concreción antes que abstracción.**
En errores: dices qué pasó y dónde. Mal: *«Algo ha salido mal»*. Bien: *«La sesión expiró hace 4 minutos. Inicia sesión otra vez.»* Si tienes el dato, lo dices.

**03 · Voz con peso o silencio.**
En vacíos de UI: si una pantalla no tiene nada que mostrar, no la rellenas con texto motivacional. Mal: *«¡Aún no hay nada aquí! ¡Empieza a crear tu primera sesión y verás todo lo que puedes hacer!»*. Bien: *«Sin sesiones registradas.»* Y un botón claro al lado.

**04 · Ningún término que use cualquier producto SaaS.**
Esta regla es la que más vigilancia requiere. Microcopy de SaaS está saturado de términos genéricos: *dashboard*, *workspace*, *onboarding*, *insight*, *boost*, *unlock*, *journey*, *experience*. Si Claude Code propone microcopy con uno de estos términos, lo cambia por uno propio: panel, escritorio de trabajo, primera sesión, observación, refuerzo, abrir, recorrido, visita.

**05 · La metáfora musical es herramienta, no decoración.**
Lo mismo que en redacción de informes: usar afinar/templar/ajustar/sonar refuerza la marca cuando aporta sentido. Repetirla en cada microcopy la abarata. Usar afinar como verbo de acción («afinar tu carta») está bien si el contexto lo justifica. Usarlo en cada botón («afina aquí», «afina allí») la convierte en muletilla.

---

## 8. Lo que nunca se hace

Reglas duras de marca, transversales a cualquier salida del producto. Si Claude Code va a hacer algo que entra en esta lista, **se detiene y pregunta antes de continuar**.

### 8.1 De marca

- **No se reescribe el wordmark con `font-family`.** El logotipo es SVG vector. Si en cualquier archivo aparece `font-family: 'Helvetica'` para escribir «Gastrototem», es bug.
- **No se modifica la geometría del logotipo.** Proporciones, radio del cuadrado, espaciado del lockup — fijos. Si un SVG oficial entra al repo y Claude Code lo modifica, vuelve atrás.
- **No se aplican efectos al logotipo:** sin sombras, sin brillos, sin degradados, sin biseles, sin glow.
- **No se rota el logotipo.** Posición ortogonal siempre.
- **No se mezcla el logotipo con fondos saturados.** Solo `tinta`, `papel`, `papel puro` y `grafito` como fondo. Cualquier otro color rompe el sistema.
- **No se añade tagline pegado al logotipo.** Los taglines viven en el copy, no anclados al lockup.
- **No se nombran los aliados de Gastrototem** (Mazzocco, Linkers, Goma Brand, Pilsa Educa) en ninguna salida pública. Categoría genérica, sí; nombre, no.

### 8.2 De voz y comunicación

- **No se promete transformaciones.** La promesa es operativa: visita, conversación, informe firmado, propuestas concretas. Lo que el restaurante haga después es su decisión.
- **No se ofrece lo que no se hace.** Gastrototem no asesora, no consulta, no acompaña, no forma. Hace afinaciones. Si el copy implica algo distinto, está mal.
- **No se compara el restaurante con otros restaurantes ni con marcas.** Ni en redes, ni en propuestas comerciales, ni en informes.
- **No se usa lenguaje de marketing.** Sin emoticonos. Sin mayúsculas enfáticas. Sin signos de exclamación en CTAs. Sin urgencia artificial («solo hoy», «últimas plazas», «no te lo pierdas»).
- **No se critica a otros gremios** (influencers, consultores, críticos clásicos). Diferenciación por hacer bien el trabajo, no por atacar.
- **No se llama «Premium» a nada.** La versión extendida es **Afinación en Profundidad**.
- **No se mide el trabajo en horas, jornadas, días.** Solo «en el acto» y «entre 15 y 30 días». El tiempo del restaurante observado sí se mide; el tiempo del oficio de Gastrototem, no.

### 8.3 De datos del cliente

- **Las notas de la sesión son material altamente sensible.** Contienen observaciones críticas sobre restaurantes reales. No se exponen en logs públicos, no se envían a herramientas de terceros para debugging, no se incluyen en mensajes de error que lleguen al frontend.
- **El informe firmado pertenece exclusivamente al cliente final del restaurante.** No se reutiliza, no se comparte como ejemplo, no se usa para marketing.
- **Las fotos de mesa pueden contener clientes reales del restaurante.** Cara visible, niños, situaciones identificables. No se usan jamás para marketing ni para entrenamiento de modelos.

Las políticas técnicas concretas de retención, cifrado y borrado viven en el `CLAUDE.md` del repo correspondiente.

---

## 9. Glosario mínimo

Términos del oficio que Claude Code va a encontrar en código, comentarios, documentación, copy, y debe entender sin ambigüedad.

- **Afinación** — el servicio de Gastrototem. Una visita más conversación más informe firmado.
- **Afinamiento** — el proceso o resultado de afinar, en abstracto.
- **Sesión de Afinación** — el servicio principal, 1.000 € + IVA.
- **Afinación en Profundidad** — la versión extendida, 3.500 € + IVA. Nunca llamada «Premium».
- **Afinador** — Fernando o Juan en su rol de visitante de incógnito.
- **De incógnito** — modo en que se hace la visita; sin avisar al restaurante. Sustituye a *mystery shopping*.
- **Mesa** — la unidad de observación. Donde ocurre la sesión.
- **Cliente más exigente** — el comensal-tipo que la afinación tiene en cuenta para juzgar.
- **Lectura del restaurante** — el output mental del afinador. Lo que se vuelca al PDF.
- **Informe firmado** — el entregable del servicio. Documento físico-digital (PDF) con la afinación, firmado por Fernando y Juan en el acto. En copy público: siempre «informe firmado», nunca «PDF firmado».
- **En el acto** — referido al informe: entregado al final de la conversación, en presencia de la propiedad.
- **Conversación** — el momento posterior a la comida, antes del PDF, donde se comparte la lectura con la propiedad. Cara a cara.
- **Llamada de control** — el seguimiento, entre 15 y 30 días después.
- **Profile A · B · C** — segmentación interna de tres tipos de cliente directo: A = consolidado estancado, B = nuevo proyecto con ambición, C = restaurante en forma que afina por oficio. Nunca aparece esta nomenclatura en salida pública.
- **Brief pre-visita** — el formulario que el cliente rellena al reservar. Contexto interno, no aparece nunca en el cuerpo del informe.
- **Notas de sesión** — el material en bruto capturado durante la comida en la app. Texto, voz, fotos, valoraciones.
- **Booking** — registro de una reserva. Conecta los dos lados de Gastrototem (web + app) vía `booking_id`.
- **Session token** — credencial efímera que autentica al afinador en la app, derivada del `booking_id`.

---

## 10. Gobernanza del documento

### 10.1 Custodio único

**Juan M. Agrela** es el custodio único de `MARCA.md` y `prompt-redaccion.md`. Cualquier cambio en estos documentos pasa por él. Fernando Huidobro tiene voz consultiva en cambios de fondo (léxico, voz, principios), pero no edita los archivos directamente.

### 10.2 Documentos compartidos

`MARCA.md` y `prompt-redaccion.md` viven duplicados en `/docs/` de cada repositorio donde son necesarios. La sincronización se gestiona a mano. Si en el futuro la deriva entre copias se vuelve un problema, se monta script de sincronización con git hooks o GitHub Actions.

Los SVGs oficiales del logotipo se duplican igualmente, en la ruta de assets que cada repo decida.

### 10.3 Versionado

Versionado semántico simplificado: **mayor.menor**. No usamos parches.

- **Mayor** (1.0 → 2.0): cambio de identidad de marca, paleta nueva, nueva categoría de servicio, replanteamiento estructural. Requiere validación de ambos socios y revisión de todo el material producido bajo la versión anterior.
- **Menor** (1.0 → 1.1): refinamiento de léxico, ajustes de reglas, adiciones de prohibiciones, nuevos principios. Validación de Juan, notificación a Fernando.

Cada cambio entra al repo con commit message claro: `marca: subir profesional a vetada — v1.3` o `marca: añadir regla de privacidad en fotos de mesa — v1.4`.

### 10.4 Cuándo se revisa

**Revisión activa:**
- Al cerrar cada trimestre (cuando exista informe de deriva del subsistema de aprendizaje).
- Cuando entre en producción una nueva pieza significativa (web pública, app pública, primer informe firmado externo).
- Cuando un cliente real señale un problema de marca.

**Revisión pasiva** (sin disparador concreto): no. MARCA.md no se revisa "porque toca". Los documentos vivos cambian cuando hay razón para cambiarlos. El silencio entre versiones es señal de salud, no de abandono.

### 10.5 Conflicto entre Claude Code y este documento

Si Claude Code, mientras trabaja en cualquier repo, encuentra una contradicción entre lo que pide el usuario en una sesión y lo que dice este documento, **gana este documento**. El comportamiento esperado:

1. Claude Code señala la contradicción en su respuesta.
2. Cita la sección concreta de `MARCA.md` que rige.
3. Propone al usuario o bien adaptar el encargo a la regla, o bien — si el caso lo justifica — someter la regla a revisión por el custodio.
4. **No procede sin resolver el conflicto.** No "asume" que el usuario tiene razón sobre la marca.

Esto puede generar fricción puntual con el flujo de trabajo, y es deliberado. La marca se protege siendo costosa de violar.

---

*Fin de `MARCA.md`. Versión 1.1 · Junio 2026.*
