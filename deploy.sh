#!/bin/bash
set -e

# Change to project directory (if not already there)
cd "$(dirname "$0")"

# Pull latest code (optional, can be skipped if already done)
# git pull origin main

echo "Rebuilding and restarting containers..."
docker compose up -d --build

echo "Waiting for app container to be ready..."
app_container="$(docker compose ps -q app)"
if [ -z "$app_container" ]; then
	echo "Error: Could not find app container."
	exit 1
fi

max_wait_seconds=60
elapsed_seconds=0

while [ "$(docker inspect -f '{{.State.Running}}' "$app_container" 2>/dev/null)" != "true" ]; do
	if [ "$elapsed_seconds" -ge "$max_wait_seconds" ]; then
		echo "Error: App container did not reach running state within ${max_wait_seconds}s."
		exit 1
	fi
	sleep 2
	elapsed_seconds=$((elapsed_seconds + 2))
done

echo "Installing PHP dependencies..."
docker compose exec -T app composer install --no-dev --optimize-autoloader --no-interaction

echo "Installing Node dependencies..."
docker compose exec -T app npm ci

echo "Building assets..."
docker compose exec -T app npm run build

echo "Running database migrations..."
docker compose exec -T app php artisan migrate --force --no-interaction

echo "Optimizing Laravel cache..."
docker compose exec -T app php artisan optimize

echo "Deployment complete!"
