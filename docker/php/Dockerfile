# Complete Docker Setup for Laravel 10 with Breeze, Tailwind and Vite

## File Structure

```
project-root/
├── docker/
│   ├── php/
│   │   ├── Dockerfile
│   │   └── local.ini
│   ├── nginx/
│   │   └── default.conf
│   ├── mysql/
│   │   └── my.cnf
│   └── node/
│       └── Dockerfile
├── docker-compose.yml
├── vite.config.js (to be updated)
└── .env (to be updated)
```

## PHP Dockerfile (docker/php/Dockerfile)

FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Change current user to www-data
USER www-data

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]

## PHP Configuration (docker/php/local.ini)

upload_max_filesize=40M
post_max_size=40M
memory_limit=512M

## Nginx Configuration (docker/nginx/default.conf)

server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/public;
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}

## MySQL Configuration (docker/mysql/my.cnf)

[mysqld]
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

## Node Dockerfile for Vite (docker/node/Dockerfile)

FROM node:18-alpine

WORKDIR /var/www

# Install dependencies
RUN apk add --no-cache bash

# Expose Vite's development server port
EXPOSE 5173

# Command to run when container starts - specifically for Vite
CMD ["sh", "-c", "npm run dev -- --host 0.0.0.0"]

## Docker Compose (docker-compose.yml)

version: '3.8'

services:
  # PHP Service
  php:
    build:
      context: .
      dockerfile: docker/php/Dockerfile
    container_name: laravel_php
    restart: unless-stopped
    tty: true
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - laravel_network

  # Nginx Service
  nginx:
    image: nginx:alpine
    container_name: laravel_nginx
    restart: unless-stopped
    tty: true
    ports:
      - "80:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - laravel_network
    depends_on:
      - php
      - mysql

  # MySQL Service
  mysql:
    image: mysql:8.0
    container_name: laravel_mysql
    restart: unless-stopped
    tty: true
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_USER: laravel
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: root
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
      - ./docker/mysql/my.cnf:/etc/mysql/my.cnf
    networks:
      - laravel_network

  # Redis Service
  redis:
    image: redis:alpine
    container_name: laravel_redis
    restart: unless-stopped
    ports:
      - "6379:6379"
    networks:
      - laravel_network

  # Node Service for Vite
  node:
    build:
      context: .
      dockerfile: docker/node/Dockerfile
    container_name: laravel_node
    volumes:
      - ./:/var/www
    ports:
      - "5173:5173"
    networks:
      - laravel_network
    depends_on:
      - php

networks:
  laravel_network:
    driver: bridge

volumes:
  mysql_data:
    driver: local

## Vite Configuration (vite.config.js)

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        },
        watch: {
            usePolling: true,
        },
    },
});



## Setup Instructions

# 1. Create the necessary directories
mkdir -p docker/php docker/nginx docker/mysql docker/node

# 2. Create the configuration files as shown above

# 3. Build and start the Docker containers
docker-compose up -d

# 4. Install Laravel dependencies
docker-compose exec php composer install

# 5. Generate application key
docker-compose exec php php artisan key:generate

# 6. Run migrations
docker-compose exec php php artisan migrate

# 7. Install frontend dependencies
docker-compose exec node npm install

# 8. For development, keep the node container running with Vite
# It's already started with docker-compose up

# 9. For production builds
docker-compose exec node npm run build

# Your Laravel application should now be accessible at:
# - Main app: http://localhost
# - Vite dev server: http://localhost:5173