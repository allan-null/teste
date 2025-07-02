FROM alpine:latest

RUN apk add --no-cache nginx php-fpm mysql mysql-client php-mysqli 

RUN mysql_install_db --user=mysql --datadir=/var/lib/mysql
