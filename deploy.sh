#!/bin/bash
set -e

# Change to project directory (if not already there)
cd "$(dirname "$0")"

# Pull latest code (optional, can be skipped if already done)
# git pull origin main

echo "Rebuilding and restarting containers..."
docker compose up -d --build

echo "Waiting for app container to be ready..."
docker compose ps app | grep -q "running"

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
