FROM php:8.3-fpm

# パッケージの更新と必要な依存ライブラリのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    ca-certificates

# Node.js 22 をインストール（npm と npx も含まれる）
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# キャッシュのクリア
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP 拡張モジュールのインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip sockets

# Composerの取得
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ワーキングディレクトリの設定
WORKDIR /var/www/html

# systemd の queue worker 用 service を /etc/systemd/system/ に配置
COPY systemd/laravel-queue.service /etc/systemd/system/laravel-queue.service
RUN chmod 644 /etc/systemd/system/laravel-queue.service