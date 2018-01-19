FROM php:5.6-apache
ENV TERM xterm
RUN apt-get update && apt-get install -y \
    wget \
    git \
    unzip \
    nano 
# && rm -rf /var/lib/apt/lists/*
ADD https://github.com/BaileyProgramming/class-api/composer-install.sh /var/
RUN chmod +x /var/composer-install.sh
Run /var/composer-install.sh
RUN mv composer.phar /usr/local/bin/composer
RUN composer require slim/slim "3.0"
RUN a2enmod rewrite
ADD https://github.com/BaileyProgramming/class-api/public /var/www/html/public/
ADD https://github.com/BaileyProgramming/class-api/000-default.conf /etc/apache2/sites-available/
