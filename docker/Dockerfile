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
    nodejs \
    npm \
    && apt-get autoremove --purge -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# php extensions
#TODO: check if -configure required
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
RUN docker-php-ext-install -j$(nproc) \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mysqli pdo pdo_mysql \
    gd

# apache config
ENV APACHE_DOCUMENT_ROOT /app/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf && \
    sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    a2enmod rewrite info

# composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /app
COPY . /app
#COPY docker/supervisor/workers.conf /etc/supervisor/conf.d
RUN chmod 777 -R storage
RUN chmod +x /app/docker/run.sh
EXPOSE 80
CMD ["yarn", "run", "prod"]
#CMD /app/docker/run.sh




# FROM node:18-alpine
# WORKDIR /app
# RUN apt-get install -y 
# COPY . .
#RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app
#COPY package*.json ./
#COPY resources ./
#COPY webpack.mix.js ./
#USER node
#RUN npm install npm@latest -g
#RUN npm install
#RUN npm rebuild node-sass
#COPY --chown=node:node . .
# EXPOSE 8080
# CMD [ "npm", "run", "hot" ]
