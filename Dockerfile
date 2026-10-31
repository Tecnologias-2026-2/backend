FROM php:8.4-cli

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pgsql pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY . .

EXPOSE 10000

CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t api api/index.php"]


