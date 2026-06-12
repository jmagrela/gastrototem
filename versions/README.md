# Versiones de diseño — Gastrototem 2.0

Tres direcciones visuales para la web de Gastrototem, generadas con herramientas distintas. La idea es compararlas en paralelo y elegir la dirección final (o cherry-pickear lo mejor de cada una).

## Las tres versiones

| Carpeta | Origen | Estado |
| --- | --- | --- |
| [`v1-claude-code/`](./v1-claude-code/) | **Claude Code** — diseño manual del agente, abril 2026 | Completa, 5 páginas + blog |
| [`v2-stitch/`](./v2-stitch/) | **Claude Code + Stitch** (Google) — generación visual asistida | Pendiente — usa el [superprompt](../docs/superprompt-claude-code-stitch.md) |
| [`v3-claude-design/`](./v3-claude-design/) | **Claude.ai/design** — generación directa desde prompt | Pendiente — usa el [superprompt](../docs/superprompt-claude-design.md) |

## Cómo previsualizar

Desde la raíz del proyecto:

```bash
npx serve versions/
```

Luego abre tres pestañas:
- http://localhost:3000/v1-claude-code/
- http://localhost:3000/v2-stitch/
- http://localhost:3000/v3-claude-design/

## Snapshot del estado original

El diseño v1 también está congelado como tag de git:

```bash
git checkout design-v1-claude-code   # ver el repo en el estado del v1
git checkout main                    # volver
```

Las carpetas `site/` y `theme/` de la raíz son el "sistema vivo" (lo que se desplegaría a WordPress). `versions/v1-claude-code/` es la copia estática para comparación.

## Criterios de evaluación sugeridos

Cuando llegues a comparar, evalúa cada versión por:

1. **Primer impacto** — ¿el hero engancha en 3 segundos?
2. **Coherencia editorial** — ¿parece dossier de crítico o landing de SaaS?
3. **Jerarquía de mensaje** — ¿el principio fundacional está claro?
4. **Uso del acento `--rouge`** — ¿es discreto o invasivo?
5. **Tratamiento fotográfico** — ¿íntimo o aspiracional?
6. **CTAs** — ¿hay diferenciación entre "reservar" y "leer"?
7. **Prueba social** — ¿se demuestra autoridad o solo se afirma?
8. **Mobile** — ¿se mantiene la sobriedad o se rompe?

## Decisión final

Cuando elijas una dirección (o una combinación), documenta aquí la decisión y los detalles a portar a `site/` y `theme/` para producción.
