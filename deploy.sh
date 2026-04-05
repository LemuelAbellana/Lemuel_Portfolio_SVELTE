#!/bin/bash
set -e

# Change to project directory (if not already there)
cd "$(dirname "$0")"

# Pull latest code (optional, can be skipped if already done)
# git pull origin main

echo "Installing PHP dependencies..."
docker compose exec app composer install --no-dev --optimize-autoloader

echo "Installing Node dependencies..."
docker compose exec app npm ci

echo "Building assets..."
docker compose exec app npm run build

echo "Running database migrations..."
docker compose exec app php artisan migrate --force

echo "Optimizing Laravel cache..."
docker compose exec app php artisan optimize

echo "Rebuilding and restarting containers..."
docker compose up -d --build

echo "Deployment complete!"
