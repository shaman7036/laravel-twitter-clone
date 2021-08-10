#!/bin/bash

# git clone https://github.com/goartisan/laravel-twitter-clone.git && cd laravel-twitter-clone

# Check if a user is root or not
if [ $(id -u) -ne 0 ]; then
    echo 'You are not running a shell as root user, please run "sudo su" first.'
    exit
fi

# https://docs.docker.com/engine/install/ubuntu/

# Install docker
if ! command -v docker
then
  sudo apt-get remove docker docker-engine docker.io containerd runc
  sudo apt-get update && sudo apt-get install -y \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg-agent \
    software-properties-common
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
  sudo apt-key fingerprint 0EBFCD88
  sudo add-apt-repository \
    "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
    $(lsb_release -cs) \
    stable"
  sudo apt-get update && sudo apt-get install -y docker-ce docker-ce-cli containerd.io
fi

# Create volumes
docker volume create app-volume
docker volume create data

# Stop all containers
docker stop $(docker ps -aq)

# Build and run a db image
docker build -t laravel-twitter-clone/db:latest -f ./.docker/db/Dockerfile .
docker run --rm -d \
  --name db \
  --network host \
  -e MYSQL_DATABASE=laravel_twitter_clone \
  -e MYSQL_ROOT_PASSWORD=docker \
  -v data:/var/lib/mysql \
  -p 3306:3306 \
  laravel-twitter-clone/db:latest

# Build and run a php image
if grep "DB_HOST=db" server/.env.example; then
    sed -i "s/DB_HOST=db/DB_HOST=127.0.0.1/g" server/.env.example
    echo 'Replaced "DB_HOST=db" with "DB_HOST=127.0.0.1" in server/.env.example'
fi
docker build -t laravel-twitter-clone/php:latest -f ./.docker/php/Dockerfile .
docker run --rm -d \
  --name php \
  --network host \
  -v app-volume:/var/www \
  -p 9000:9000 \
  laravel-twitter-clone/php:latest

# Build and run a nginx image
if grep "fastcgi_pass php:9000;" .docker/nginx/default.conf; then
    sed -i "s/fastcgi_pass php:9000;/fastcgi_pass 127.0.0.1:9000;/g" .docker/nginx/default.conf
    echo 'Replaced "fastcgi_pass php:9000;" with "fastcgi_pass 127.0.0.1:9000;" in .docker/nginx/default.conf'
fi
cp .env.example .env
docker build -t laravel-twitter-clone/nginx:latest -f ./.docker/nginx/Dockerfile .
docker run --rm -d \
  --name nginx \
  --network host \
  -v app-volume:/var/www \
  -p 80:80 \
  laravel-twitter-clone/nginx:latest

# Set up laravel
docker exec -it php composer install
docker exec -it php php artisan key:generate
docker exec -it php php artisan migrate:refresh
docker exec -it db mysql -uroot -pdocker -e "source docker-entrypoint-initdb.d/init.sql"
docker exec -it php chown -R www-data:www-data public/storage/
docker exec -it php chown -R www-data:www-data storage/
