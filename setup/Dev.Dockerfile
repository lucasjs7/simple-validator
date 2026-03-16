FROM ubuntu:latest

# PHP
RUN apt-get update -y \
    && apt-get install -y php8.3-cli \
    && apt-get install -y php8.3-xml \
    && apt-get install -y php8.3-bcmath \
    && apt-get install -y php8.3-mbstring

# XDEBUG
RUN apt-get update -y \
    && apt-get install -y php8.3-xdebug \
    && echo "zend_extension=xdebug.so\n" \
            "xdebug.idekey=vsc\n" \
            "xdebug.mode=debug\n" \
            "xdebug.start_with_request=yes\n" \
            "xdebug.client_host=host.docker.internal\n" \
            "xdebug.remote_cookie_expire_time=1200\n" > /etc/php/8.3/cli/conf.d/20-xdebug.ini

# Build
# docker build --tag simple-validator-dev -f setup\Dev.Dockerfile .