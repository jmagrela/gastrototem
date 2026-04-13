# Gastrototem 2.0 — Spec de modelo de negocio, tecnología y marketing

Fecha: 2026-04-13
Autores: Juanma Agrela (diseño del formato), Fernando Huidobro (producto premium)
Estado: Aprobado para planificación de implementación

---

## 1. Contexto y situación actual

Gastrototem S.L. (Sevilla) pivota de agencia 360 de servicios para gastronomía a firma de crítica gastronómica especializada que afina restaurantes.

**Estado actual:**
- En transición: mantienen clientes del modelo antiguo mientras arrancan el nuevo
- PACG (70% de facturación histórica) paralizado por falta de financiación
- Acuerdo verbal de intención con Mazzocco Gourmet (distribuidora en Málaga), sin condiciones cerradas
- Fernando Huidobro reside en Málaga, Juanma Agrela en Granada
- Disponibilidad objetivo: ~10h/semana entre ambos socios (decisión de calidad de vida, no restricción)

**Territorio de arranque:** provincia de Málaga exclusivamente. Granada se activa cuando la demanda lo justifique.

---

## 2. Catálogo de productos

### 2.1. Sesión de Afinación — 1.000 EUR + IVA

Producto principal. Canal abierto: web, ads, orgánico, Mazzocco.

**Qué incluye:**
- Visita de incógnito al restaurante como clientes reales (2h, compartiendo platos)
- Informe de Afinación PDF generado por IA, revisado por los socios (2-3 páginas)
- Reunión inmediata con la propiedad (1h máximo) para presentar el informe
- Llamada de control a 30 días (10 minutos)

**Qué NO incluye:**
- Segunda visita (se paga como sesión nueva)
- Visibilidad en canales de Gastrototem (se otorga si el criterio lo justifica, nunca se vende)
- Gestión de redes, diseño web, consultoría financiera ni ningún servicio de agencia

**Horas por sesión:**

| Fase | Horas |
|---|---|
| Pre-visita (leer formulario, check digital, confirmar reserva) | 0,5h |
| Desplazamiento (provincia de Málaga) | 0-1,5h |
| Comida de incógnito | 2h |
| Revisión del informe generado por IA | 0,5h |
| Reunión con propiedad | 1h |
| Llamada de control 30 días | 0,15h |
| **Total** | **4-5,5h** |

**Rentabilidad:** 182-250 EUR/hora.

### 2.2. Programa de Afinación en Profundidad — 3.500 EUR + IVA

Producto premium diferenciado. Canal exclusivo: Mazzocco Gourmet, máximo 1 cliente/mes.

**Qué incluye:**
- **Visita 1:** Sesión de afinación completa (idéntica al producto estándar)
- **Visita 2 (30-45 días después):** Control de implementación. Visita pactada (no incógnito). 2h máximo. Se revisa en sala y cocina lo que se recomendó. Informe de seguimiento breve (1 página).
- **Visita 3 (60-90 días después):** Nueva visita de incógnito. Informe comparativo antes/después (2-3 páginas). Documenta la transformación.
- **Veredicto final firmado** por ambos socios. Si es positivo, se otorga visibilidad en canales de Gastrototem como reconocimiento.

**Horas totales del programa:**

| Visita | Horas |
|---|---|
| Visita 1 (sesión completa) | 4-5,5h |
| Visita 2 (control, sin incógnito, sin comida completa) | 2-3h |
| Visita 3 (incógnito + informe comparativo) | 4-5,5h |
| **Total** | **10-14h** |

**Rentabilidad:** 250-350 EUR/hora (antes de comisión Mazzocco). 213-298 EUR/hora (con comisión 15%).

---

## 3. Estructura comercial con Mazzocco Gourmet

### 3.1. Modelo de relación

- Mazzocco refiere clientes, Gastrototem factura directamente al restaurante
- Mazzocco cobra comisión a 30 días del cobro al cliente
- No hay exclusividad geográfica — Mazzocco tiene prioridad comercial en Málaga por la relación

### 3.2. Comisiones

| Producto | Comisión Mazzocco | Neto Gastrototem |
|---|---|---|
| Sesión de Afinación (1.000 EUR) | 10% = 100 EUR | 900 EUR |
| Programa Premium (3.500 EUR) | 15% = 525 EUR | 2.975 EUR |

La diferencia de comisión incentiva a Mazzocco a mover el premium con sus clientes selectos.

### 3.3. Condiciones clave

- Clientes que llegan por web/ads propios de Gastrototem no generan comisión, aunque sean clientes de Mazzocco como distribuidora
- Mazzocco dispone de un enlace/código de referido para trackear sus clientes y liquidar comisiones
- Gastrototem mantiene independencia total de criterio. Si un producto de Mazzocco es malo, se dice en el informe
- Material necesario de Gastrototem para Mazzocco: one-pager PDF con el servicio + argumentario adaptado

---

## 4. Piezas tecnológicas

Las tres piezas se integran en la web WordPress de gastrototem.com. Son aplicaciones web, no apps nativas.

### 4.1. App de Reserva

**Calendario configurable:**
- Vista mensual con disponibilidad por zona geográfica (Málaga capital, Costa del Sol, interior de la provincia)
- Franjas horarias: comida o cena
- Panel admin para que los socios configuren disponibilidad (marcar/desmarcar días y zonas)
- Bloqueo automático al alcanzar máximo de sesiones del mes

**Formulario pre-visita (integrado en el flujo de reserva):**
El cliente elige fecha/zona → rellena el formulario → paga → reserva confirmada.

Campos del formulario:
- Nombre del restaurante, dirección, teléfono, web, Instagram
- Tipo de cocina y concepto en una frase
- Nº cubiertos, equipo sala/cocina, servicios que realizan
- Gestión de reservas (teléfono/plataforma/mixto)
- Principal reto del negocio ahora mismo
- Qué quiere que se preste especial atención
- ¿Ha trabajado con asesor/consultor antes?

**Pago:**
- Stripe integrado. 100% al reservar.
- Emails automáticos: confirmación de pago + recordatorio 48h antes

**Panel admin:**
- Reservas programadas con datos del formulario
- Gestión de disponibilidad
- Historial de sesiones realizadas
- Estado por cliente: pendiente / realizada / informe entregado / control 30d hecho
- Tracking de origen del lead (web directa, ads, Mazzocco referido)

### 4.2. App de Notas en Vivo

Interfaz móvil responsive para uso durante la sesión. Acceso desde URL privada vinculada a la reserva del día. Carga automáticamente los datos del formulario pre-visita.

**Bloque 1 — Llegada y entorno:**
- Primera impresión exterior (fachada, señalización, acceso)
- Recepción y bienvenida (quién, cómo, tiempo de espera)
- Ambiente interior (iluminación, acústica, temperatura, limpieza)
- Valoración rápida: selector 1-5 + campo de texto libre

**Bloque 2 — Platos (repetible, uno por plato):**
- Nombre del plato tal como aparece en carta
- Foto del plato (integrada, se hace desde la app, vinculada automáticamente al plato)
- Materia prima: selector 1-5 + comentario
- Técnica/ejecución: selector 1-5 + comentario
- Presentación/emplatado: selector 1-5 + comentario (la foto sirve de referencia directa)
- Relación con el concepto del restaurante: comentario libre
- Nota de voz rápida (transcripción automática)

**Bloque 3 — Servicio de sala:**
- Tiempos entre platos
- Conocimiento de la carta por parte del personal
- Hospitalidad y capacidad de resolver imprevistos
- Gestión del cierre (cuenta, despedida)
- Valoración rápida: selector 1-5 + campo de texto libre

**Bloque 4 — Experiencia global y coherencia:**
- ¿Fluye la experiencia sin fricción?
- ¿El restaurante es lo que dice ser? (coherencia promesa vs. realidad)
- ¿El precio se corresponde con lo entregado?
- Observación más destacada del día (texto o nota de voz)

**Bloque 5 — Veredicto rápido pre-reunión:**
- 3 cosas que funcionan bien
- 3 cosas que hay que cambiar ya
- 1 frase de veredicto global
- Se rellena antes de la reunión y alimenta directamente el informe

**Funcionalidades clave:**
- Nota de voz con transcripción automática en cualquier campo
- Guardado automático continuo (sin botón de guardar)
- Funciona offline y sincroniza al recuperar conexión
- Ambos socios pueden editar la misma sesión simultáneamente desde sus móviles
- Fotos se exportan en dos resoluciones: alta para informe PDF, originales para uso en redes

### 4.3. Motor de Informes IA

**Flujo de generación:**
1. Al completar el Bloque 5, se pulsa "Generar Informe"
2. La IA recibe: datos del formulario pre-visita + notas/valoraciones/transcripciones + fotos + plantilla
3. Genera borrador completo en 1-2 minutos
4. Los socios revisan en el móvil, ajustan y confirman
5. Se genera PDF con identidad visual Gastrototem
6. Listo para la reunión con la propiedad

**Plantilla del informe:**

```
INFORME DE AFINACIÓN GASTROTOTEM
[Nombre del restaurante] — [Localidad] — [Fecha]
Sesión realizada por Fernando Huidobro y Juanma Agrela

─────────────────────────────────

1. LA COCINA
   Observación: [redactado con voz de crítica gastronómica]
   Juicio: [valoración directa, sin condescendencia]
   Acción: [qué hacer, con indicador de prioridad]
   [Fotos de platos relevantes con comentarios visuales]

2. LA SALA
   Observación — Juicio — Acción

3. LA EXPERIENCIA GLOBAL
   Observación — Juicio — Acción

4. LA COHERENCIA DE LA PROPUESTA
   Observación — Juicio — Acción

─────────────────────────────────

ACCIONES PRIORITARIAS
• [ATENCIÓN INMEDIATA] ...
• [MEJORA RECOMENDADA] ...
• [AFINACIÓN FINA] ...

─────────────────────────────────

VEREDICTO
[Párrafo de cierre firmado por ambos socios]

Fernando Huidobro · Juanma Agrela
Gastrototem — Alta Afinación Gastronómica
```

**Indicadores de prioridad:**
- **ATENCIÓN INMEDIATA** — Problemas que afectan a la experiencia del cliente hoy. Resolver en días.
- **MEJORA RECOMENDADA** — Cambios que elevan la calidad notablemente. Plazo: 2-4 semanas.
- **AFINACIÓN FINA** — Detalles que separan un buen restaurante de uno excelente. Sin urgencia, impacto acumulativo.

**Tono de la IA:**
- Crítica gastronómica profesional. Directo, fundamentado, sin florituras.
- No inventa — solo redacta a partir de las notas reales. Campos vacíos se omiten.
- Transcripciones de voz se integran como materia prima, no se copian literalmente.
- Veredicto final basado en el Bloque 5 pero con mayor peso narrativo.
- Extensión: 2-3 páginas máximo. Legible en 10 minutos.
- Fotos de platos incluidas cuando hay algo que destacar, valorar o corregir (emplatado, limpieza, presentación).

**Pago del Programa Premium:**
- 100% al confirmar la reserva de la Visita 1 (3.500 EUR + IVA). El compromiso de 3 visitas requiere pago completo por adelantado.

**Informes adicionales para Programa Premium:**
- Visita 2: Informe de seguimiento breve (1 página). Qué se implementó, qué no, valoración del progreso.
- Visita 3: Informe comparativo antes/después (2-3 páginas). Misma estructura con columna comparativa. Incluye veredicto final firmado.

---

## 5. Estrategia de marketing

### 5.1. SEO

**Estrategia de keywords por intención de propietarios:**

| Intención | Keywords | Contenido |
|---|---|---|
| "Mi restaurante no despega" | mejorar restaurante, consultor gastronómico, asesor restaurantes | Landing /afinacion |
| "Quiero estar en guías" | cómo entrar en guía Michelin, mejorar reseñas restaurante | Blog /criterio |
| "Necesito opinión externa" | crítica profesional restaurante, auditoría gastronómica | Blog /criterio |
| "Qué estoy haciendo mal" | errores comunes restaurantes, por qué no vienen clientes | Blog /criterio |
| Búsqueda de marca | gastrototem, fernando huidobro consultor | Home + /nosotros |

**Blog /criterio:**
- 2 artículos/mes generados con IA a partir de observaciones reales
- Cada artículo ataca una keyword de cola larga con intención de propietarios
- CTA al final: enlace directo a reservar sesión
- SEO local: contexto andaluz/malagueño cuando sea natural

**SEO técnico:**
- Schema markup: LocalBusiness + Person (Huidobro, Agrela)
- Google Business Profile optimizado: categoría "Consultor gastronómico"
- PageSpeed > 85 en móvil
- Google Search Console desde el día 1

### 5.2. Google Ads — Captura de demanda existente

- Presupuesto: 100-150 EUR/mes
- Campaña de Search, 2 grupos de anuncios:
  - Intención directa: "consultor gastronómico Málaga", "asesor restaurantes Málaga", "mejorar restaurante Málaga"
  - Problema: "mi restaurante no funciona", "mejorar servicio restaurante", "crítica profesional restaurante"
- Geolocalización: provincia de Málaga exclusivamente
- Keywords negativas: gratis, barato, económico, curso, empleo, receta, restaurante cerca
- Landing: /afinacion con sistema de reserva
- Conversiones: reserva completada (pago), clic en botón de reserva
- CPL estimado: 30-50 EUR

### 5.3. Meta Ads — Generación de demanda

- Presupuesto: 150-200 EUR/mes
- **Campaña 1 — Awareness (60%):** Vídeo corto o carrusel con observación real anonimizada. Segmentación: intereses hostelería/gastronomía + Málaga provincia + edad 30-60.
- **Campaña 2 — Conversión (40%):** Retargeting a visitantes web / interacciones con campaña 1. Caso de trabajo o anuncio directo con precio. Landing: /afinacion.

### 5.4. Proyección de ADS

| Métrica | Mensual |
|---|---|
| Inversión total | 250-350 EUR |
| Leads estimados (CPL 40 EUR) | 6-9 |
| Conversión 40% | 2-4 clientes |
| Facturación generada | 2.000-4.000 EUR |
| ROI sobre inversión en ads | 6x-16x |

### 5.5. Contenido orgánico

- 3 publicaciones/semana Instagram, 1-2 LinkedIn
- Todo nace del trabajo real: foto de llegada, observación post-sesión, reflexión de criterio
- Coste: 0 EUR

### 5.6. Mazzocco como canal comercial

- Presenta el servicio en sus visitas comerciales habituales
- Enlace/código de referido para tracking
- Selecciona 1 cliente/mes de su cartera top para el programa premium
- Material de Gastrototem: one-pager PDF + argumentario

---

## 6. Proyección de facturación

| Escenario | Sesiones/mes | Premium/mes | Bruto mensual | Bruto anual | Horas/semana |
|---|---|---|---|---|---|
| Conservador | 4 | 0 | 4.000 EUR | 48.000 EUR | 4-5,5h |
| Objetivo | 4 | 1 | 7.500 EUR | 90.000 EUR | 6,5-9h |
| Óptimo | 6 | 1 | 9.500 EUR | 114.000 EUR | 8,5-12h |

Inversión en marketing: 250-350 EUR/mes (3.000-4.200 EUR/año).

---

## 7. Decisiones explícitas

- El territorio de arranque es Málaga provincia. Granada se activa cuando la demanda lo justifique.
- La Sesión de Afinación es el producto principal y el foco de toda la inversión en marketing.
- El Programa Premium existe como producto de prestigio, no como motor de facturación.
- Mazzocco cobra comisión siempre (10% estándar, 15% premium) para mantener su interés comercial activo.
- La visibilidad en canales de Gastrototem nunca se vende. Se otorga cuando el criterio lo justifica.
- Las tres piezas tecnológicas (app de reserva, app de notas, motor de informes IA) son requisito previo para que la operativa sea rentable.
- El PACG se gestiona por separado cuando se reactive. No condiciona el diseño de este modelo.
