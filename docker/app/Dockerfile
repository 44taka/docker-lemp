FROM php:8.1-fpm

# php.iniをコピー
COPY ./docker/app/php.ini /usr/local/etc/app/php.ini

# Composer install
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# パッケージ管理ツール(apt)-getの更新と各パッケージやphp拡張モジュールのインストール
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    && docker-php-ext-install pdo_mysql bcmath

# コンテナでの作業ディレクトリを指定(docker-compose exec app bashを利用した時のカレントディレクトリになる)
WORKDIR /var/www/html