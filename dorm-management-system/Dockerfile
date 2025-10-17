# 2️⃣ Run stage — Laravel с Apache
FROM php:8.2-apache

# Устанавливаем необходимые пакеты для PHP и PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Копируем код Laravel
COPY . /var/www/html

# Копируем собранные фронтовые файлы
COPY --from=build /app/public /var/www/html/public

# Настраиваем порты
EXPOSE 8080
CMD ["apache2-foreground"]
