FROM ubuntu:18.04
RUN \
  sed -i 's/# \(.*multiverse$\)/\1/g' /etc/apt/sources.list && \
  apt-get update && \
  apt-get -y upgrade && \
  apt-get install -y build-essential && \
  apt-get install -y software-properties-common && \
  apt-get install -y byobu curl git htop man unzip vim wget

RUN rm -rf /var/lib/apt/lists/*

RUN add-apt-repository ppa:nginx/stable
RUN apt-get update && apt-get install -y nginx \
  php7.2 \
  php7.2-fpm  \
  php7.2-json  \
  php7.2-mbstring  \
  php7.2-sqlite3  \
  php7.2-odbc \
  php7.2-bcmath  \
  php7.2-cgi  \
  php7.2-cli  \
  php7.2-common  \
  php7.2-curl \
  php7.2-dev  \
  php7.2-json \
  php7.2-mbstring \
  php7.2-opcache \
  php7.2-readline \
  php7.2-xml  \
  php7.2-zip  \
  libfreetype6-dev \
  libmcrypt-dev \
  libpng-dev \
  libfreetype6-dev \
  && docker-php-ext-install -j$(nproc) iconv mcrypt \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd

  RUN rm -rf /etc/nginx/sites-enabled/default.conf

  # Add files.
  ADD doc_resources/hacker-news.conf /etc/nginx/sites-enabled/default.conf

  WORKDIR /var/www/html/hacker_news/

  EXPOSE 88
  CMD ["service nginx restart"]
  CMD ["service php7.2-fpm restart"]
