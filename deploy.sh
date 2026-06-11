#!/bin/bash
# ============================================
# Gastrototem — Deploy theme via rsync
# ============================================
#
# Uso:
#   ./deploy.sh              → sube al staging
#   ./deploy.sh --dry-run    → simula sin subir nada
#   ./deploy.sh production   → sube a producción (cuando esté listo)
#

set -euo pipefail

# ── Configuración ────────────────────────────
# Edita estos valores con tus datos de Hostinger

STAGING_HOST="147.93.93.132"
STAGING_USER="u457559952"                          # usuario SSH de Hostinger
STAGING_PORT="65002"                               # puerto SSH de Hostinger (normalmente 65002)
STAGING_PATH="/home/u457559952/domains/gastrototem.com/public_html/2026/wp-content/themes/gastrototem/"

PRODUCTION_HOST="147.93.93.132"
PRODUCTION_USER="u457559952"
PRODUCTION_PORT="65002"
PRODUCTION_PATH="/home/u457559952/domains/gastrototem.com/public_html/wp-content/themes/gastrototem/"

LOCAL_PATH="$(dirname "$0")/theme/gastrototem/"

# ── Lógica ───────────────────────────────────

ENV="${1:-staging}"
DRY_RUN=""

if [ "$ENV" = "--dry-run" ]; then
  DRY_RUN="--dry-run"
  ENV="staging"
elif [ "${2:-}" = "--dry-run" ]; then
  DRY_RUN="--dry-run"
fi

case "$ENV" in
  staging)
    HOST="$STAGING_HOST"
    USER="$STAGING_USER"
    PORT="$STAGING_PORT"
    REMOTE_PATH="$STAGING_PATH"
    ;;
  production)
    HOST="$PRODUCTION_HOST"
    USER="$PRODUCTION_USER"
    PORT="$PRODUCTION_PORT"
    REMOTE_PATH="$PRODUCTION_PATH"
    read -p "¿Seguro que quieres subir a PRODUCCIÓN? (s/N) " confirm
    if [ "$confirm" != "s" ] && [ "$confirm" != "S" ]; then
      echo "Cancelado."
      exit 0
    fi
    ;;
  *)
    echo "Uso: ./deploy.sh [staging|production] [--dry-run]"
    exit 1
    ;;
esac

if [ -n "$DRY_RUN" ]; then
  echo "🔍 Simulación (dry-run) → $ENV"
else
  echo "🚀 Desplegando → $ENV ($HOST)"
fi

rsync -avz --delete \
  --exclude='.DS_Store' \
  --exclude='*.map' \
  --exclude='.git' \
  -e "ssh -p $PORT" \
  $DRY_RUN \
  "$LOCAL_PATH" \
  "${USER}@${HOST}:${REMOTE_PATH}"

if [ -n "$DRY_RUN" ]; then
  echo ""
  echo "✅ Simulación completa. Ejecuta sin --dry-run para subir."
else
  echo ""
  echo "✅ Desplegado en $ENV"

  # ── Auto-purga LiteSpeed (acorde al ENTORNO del deploy) ──────
  # El WP root se deriva de REMOTE_PATH —la MISMA variable por-entorno que usó
  # el rsync— quitando el sufijo del tema. Así la purga golpea siempre el mismo
  # entorno que se acaba de desplegar (staging→staging, prod→prod), nunca otro.
  # Tolerante a fallo: un error de purga NO rompe el deploy (queda como aviso).
  WP_PATH="${REMOTE_PATH%wp-content/themes/gastrototem/}"
  echo ""
  echo "🧹 Purgando cache LiteSpeed en ${ENV}..."
  ssh -p "$PORT" "${USER}@${HOST}" "cd '$WP_PATH' && wp litespeed-purge all" \
    || echo "[aviso] purga LiteSpeed falló: hazla manual (wp litespeed-purge all en $WP_PATH)"
fi
