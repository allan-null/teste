#!/bin/sh
# Esse script é o supervisor dos processos vitais para o funcionamento do CRUD.
# Ele inicia junto com o container e reinicializa os processos caso dêem crash.

# Define os arquivos onde estão salvos os PIDs (ID de processo)
# seguindo o padrão atual do Alpine Linux.
phpPIDFile=/var/run/php-fpm.pid
nginxPIDFile=/run/nginx/nginx.pid

# Loop para checar se os processos não estão rodando, e os reinicializa caso
# precisar.
while [ true ]; do
  mysqlPIDFile=$(ls /var/lib/mysql/*.pid | head -1)

  if [[ -z "$mysqlPIDFile" ]] || [[ ! -e $mysqlPIDFile ]] || [[ ! -d "/proc/$(cat "$mysqlPIDFile")" ]]; then
    echo 'Starting MySQL...'
    cd /usr
    /usr/bin/mysqld_safe --datadir='/var/lib/mysql' &
    sleep 5
    mysql -e "USE employees;" 2>/dev/null || mysql < /var/www/html/docker/database.sql
  fi

  if [[ ! -e $nginxPIDFile ]] || [[ ! -d "/proc/$(cat $nginxPIDFile)" ]]; then
    echo 'Starting nginx...'
    # Copia as configurações customizadas do nginx antes de inicializá-lo
    cp /var/www/html/docker/nginx.conf /etc/nginx/http.d/default.conf

    nginx &
  fi

  if [[ ! -e $phpPIDFile ]] || [[ ! -d "/proc/$(cat $phpPIDFile)" ]]; then
    echo 'Starting PHP FPM...'
    php-fpm83 -g $phpPIDFile
  fi

  sleep 1
done
