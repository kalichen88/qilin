#!/usr/bin/env bash
set -e
APP_DIR="${APP_DIR:-/opt/wanli-v2}"
cd "$APP_DIR"
echo "[deploy] pull ..."
git pull --rebase origin main
[ -f .env ] || { cp .env.example .env; echo "[deploy] 已生成 .env，请编辑 DB/Redis/JWT_SECRET/PAY_DRIVER 等"; }
echo "[deploy] docker compose up ..."
 docker compose -f deploy/docker-compose.prod.yml up -d --build
echo "[deploy] done. 健康检查: curl http://127.0.0.1:9501/health"
