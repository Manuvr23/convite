#!/usr/bin/env sh
set -e

# Enlace de storage publico (fotos/musica). Puede existir ya; no falla si es asi.
php artisan storage:link || true

# Crear/actualizar las tablas en la base de datos de Render.
php artisan migrate --force

# Arrancar la app en el puerto que asigna Render (o 8080 en local).
php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
