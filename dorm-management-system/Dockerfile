# 1️⃣ Build stage — собираем фронтенд (Vite)
FROM node:18 AS build

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# 2️⃣ Run stage — Laravel с Apache
FROM php:8.2-apache

# Устанавливаем нужные PHP-расширения
RUN docker-php-ext-install pdo pdo_pgsql pdo_mysql

# Копируем код Laravel
COPY . /var/www/html

# Копируем собранные фронтовые файлы из первой стадии
COPY --from=build /app/public /var/www/html/public

# Настраиваем права и порты
EXPOSE 8080
CMD ["apache2-foreground"]
