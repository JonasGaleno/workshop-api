#!/bin/bash
set -e

# Ajusta permissões
chmod -R 775 storage bootstrap/cache

# Instala dependências se necessário
if [ ! -d "vendor" ]; then
    composer install
fi

# Gera key se não existir
if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

exec "$@"
