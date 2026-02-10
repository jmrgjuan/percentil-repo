FROM php:7.2-fpm

# Configure Debian archive repositories (Buster is archived)
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list \
    && sed -i 's|security.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i '/stretch-updates/d' /etc/apt/sources.list \
    && sed -i '/buster-updates/d' /etc/apt/sources.list \
    && echo "Acquire::Check-Valid-Until false;" > /etc/apt/apt.conf.d/99no-check-valid-until

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git unzip curl libzip-dev libicu-dev zlib1g-dev libxml2-dev libpng-dev libjpeg-dev openssh-client \
    && docker-php-ext-install pdo_mysql zip intl mbstring opcache \
    && rm -rf /var/lib/apt/lists/*

# Install Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy custom PHP configuration
COPY .devcontainer/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Create a non-root user 'vscode' with UID 1000
RUN groupadd -g 1000 vscode || true \
    && useradd -m -u 1000 -g 1000 -s /bin/bash vscode || true \
    && chown -R vscode:vscode /home/vscode

USER vscode
WORKDIR /workspace
