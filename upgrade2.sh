#!/bin/bash

LATEST_IMAGE=${1:-coolify-custom:dev}
SKIP_BACKUP=${2:-false}
ENV_FILE="/data/coolify/source/.env"

DATE=$(date +%Y-%m-%d-%H-%M-%S)
LOGFILE="/data/coolify/source/upgrade-${DATE}.log"

# ❌ Прибираємо завантаження з CDN
# ✅ Використовуємо локальні файли: docker-compose.yml, .env.production

# Backup .env
if [ "$SKIP_BACKUP" != "true" ]; then
    if [ -f "$ENV_FILE" ]; then
        echo "Creating backup of existing .env file to .env-$DATE" >>"$LOGFILE"
        cp "$ENV_FILE" "$ENV_FILE-$DATE"
    else
        echo "No existing .env file found to backup" >>"$LOGFILE"
    fi
fi

# Merge .env.production → .env
if [ -f /data/coolify/source/.env.production ]; then
    echo "Merging .env.production values into .env" >>"$LOGFILE"
    awk -F '=' '!seen[$1]++' "$ENV_FILE" /data/coolify/source/.env.production > "$ENV_FILE.tmp" && mv "$ENV_FILE.tmp" "$ENV_FILE"
    echo ".env file merged successfully" >>"$LOGFILE"
fi

update_env_var() {
    local key="$1"
    local value="$2"
    if grep -q "^${key}=$" "$ENV_FILE"; then
        sed -i "s|^${key}=$|${key}=${value}|" "$ENV_FILE"
        echo " - Updated value of ${key} as the current value was empty" >>"$LOGFILE"
    elif ! grep -q "^${key}=" "$ENV_FILE"; then
        printf '%s=%s\n' "$key" "$value" >>"$ENV_FILE"
        echo " - Added ${key} with default value as the variable was missing" >>"$LOGFILE"
    fi
}

echo "Checking and updating environment variables if necessary..." >>"$LOGFILE"
update_env_var "PUSHER_APP_ID" "$(openssl rand -hex 32)"
update_env_var "PUSHER_APP_KEY" "$(openssl rand -hex 32)"
update_env_var "PUSHER_APP_SECRET" "$(openssl rand -hex 32)"

# Ensure network exists
if ! docker network inspect coolify >/dev/null 2>&1; then
    docker network create --attachable coolify || docker network create --attachable coolify
fi

# 🔄 Запускаємо docker compose напряму
docker compose --env-file "$ENV_FILE" \
  -f /data/coolify/source/docker-compose.yml \
  -f /data/coolify/source/docker-compose.prod.yml \
  up -d --remove-orphans --force-recreate >>"$LOGFILE" 2>&1
