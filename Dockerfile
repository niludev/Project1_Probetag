FROM symfony

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && git config --global --add safe.directory /app \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --link \
    --from=ghcr.io/symfony-cli/symfony-cli:latest \
    /usr/local/bin/symfony /usr/bin/symfony

WORKDIR /app

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
