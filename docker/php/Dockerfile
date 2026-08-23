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
    libzip-dev

# キャッシュのクリア
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP 拡張モジュールのインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composerの取得
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ワーキングディレクトリの設定
WORKDIR /var/www/html