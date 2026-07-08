# Imagen para desplegar Convites (Laravel) en Render.
FROM php:8.4-cli

# Dependencias del sistema + extensiones PHP que necesita la app
# (pdo_pgsql para PostgreSQL de Render, zip/gd para el export a Excel).
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libpq-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo pdo_pgsql zip gd bcmath \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Instalar dependencias PHP primero (aprovecha la cache de Docker)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copiar el resto del proyecto
COPY . .
RUN composer dump-autoload --optimize --no-dev \
    && chmod -R 775 storage bootstrap/cache

# Render inyecta el puerto en $PORT; la app arranca via start.sh
CMD ["sh", "docker/start.sh"]
