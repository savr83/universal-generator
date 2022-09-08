FROM php:8.1.10-apache-bullseye as base

# packages
RUN apt-get update && apt-get install -y \
    supervisor \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
# imap requirements    
    libc-client-dev \
    libkrb5-dev \
# utils
    mc \
    vim \
    net-tools \
# install latest nodejs    
    && curl -fsSL https://deb.nodesource.com/setup_current.x | sudo -E bash - \
    && apt-get install -y nodejs \
# install yarn
    && curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | sudo tee /usr/share/keyrings/yarnkey.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg] https://dl.yarnpkg.com/debian stable main" | sudo tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update && apt-get -y install yarn \
# cleanup    
    && apt-get autoremove --purge -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*



# php extensions
#TODO: check if -configure required
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install -j$(nproc) \
    bcmath \
    bz2 \
    calendar \
    gd \
    intl \
    mysqli \
    opcache \
    pdo pdo_mysql \
    iconv \
    imap

# apache config
ENV APACHE_DOCUMENT_ROOT /app/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf && \
    sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    a2enmod rewrite info

# composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app
COPY . .
#COPY docker/supervisor/workers.conf /etc/supervisor/conf.d
RUN chmod 777 -R storage
#RUN chmod +x /app/docker/run.sh
EXPOSE 80
CMD /app/docker/run.sh
#CMD ["npm", "run", "prod"]
#CMD /app/docker/run.sh

FROM base as build
RUN composer install \
    && yarn

FROM build as dev
#RUN yarn dev

FROM build as prod
RUN yarn prod

