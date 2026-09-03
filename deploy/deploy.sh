#!/usr/bin/env bash
set -e
APP_DIR="${APP_DIR:-/opt/wanli-v2}"
cd "$APP_DIR"
echo "[deploy] pull ..."
git pull --rebase origin main
echo "[deploy] composer install ..."
composer install --no-dev -o --no-interaction
[ -f .env ] || { cp .env.example .env; echo "[deploy] 已生成 .env，请编辑 DB/Redis/JWT_SECRET/PAY_DRIVER 等"; }
echo "[deploy] build frontends ..."
(cd frontend/c-vue3 && npm i && npm run build)
(cd frontend/admin-react18 && npm i && npm run build)
echo "[deploy] start stack (docker) ..."
docker compose -f docker-compose.prod.yml up -d --build
echo "[deploy] done. 健康检查: curl http://127.0.0.1:9501/health"
