FROM php:7.2-fpm

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git unzip libzip-dev libicu-dev libonig-dev zlib1g-dev libxml2-dev libpng-dev libjpeg-dev \
    && docker-php-ext-install pdo_mysql zip intl mbstring opcache \
    && rm -rf /var/lib/apt/lists/*

# Install Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create a non-root user 'vscode' with UID 1000
RUN groupadd -g 1000 vscode || true \
    && useradd -m -u 1000 -g 1000 -s /bin/bash vscode || true \
    && chown -R vscode:vscode /home/vscode

USER vscode
WORKDIR /workspace
