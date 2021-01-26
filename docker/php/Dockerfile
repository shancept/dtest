FROM yiisoftware/yii2-php:7.2-fpm

RUN pecl install xdebug || docker-php-ext-enable xdebug
RUN docker-php-ext-install opcache

COPY base.ini /usr/local/etc/php/conf.d/base.ini
COPY php.ini /usr/local/etc/php/conf.d/php.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini