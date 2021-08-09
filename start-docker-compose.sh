#!/bin/bash

# git clone https://github.com/goartisan/laravel-twitter-clone.git && cd laravel-twitter-clone

# Check if a user is root or not
if [ $(id -u) -ne 0 ]; then
    echo 'You are not running a shell as root user, please run "sudo su" first.'
    exit
fi

# https://docs.docker.com/engine/install/ubuntu/
# https://docs.docker.com/compose/install/

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

# Install docker-compose
if ! command -v docker-compose
then
  sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
  sudo chmod +x /usr/local/bin/docker-compose && \
  sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
fi

# Select a mode to build containers
echo "Select:"
select MODE in "Production" "Development"
do
  case ${MODE} in
    "Production" ) DOCKER_COMPOSE="docker-compose -f docker-compose.production.yml"; break;;
    "Development" ) DOCKER_COMPOSE="docker-compose"; break;;
  esac
done

# Set up laravel
sudo docker stop $(sudo docker ps -aqf "name=laravel-twitter-clone_nginx")
sudo ${DOCKER_COMPOSE} build
sudo ${DOCKER_COMPOSE} up -d
sudo ${DOCKER_COMPOSE} ps
sudo ${DOCKER_COMPOSE} exec -T db mysql -uroot -pdocker -e "source docker-entrypoint-initdb.d/init.sql"
sudo ${DOCKER_COMPOSE} exec -T php cp .env.example .env
sudo ${DOCKER_COMPOSE} exec -T php composer install
sudo ${DOCKER_COMPOSE} exec -T php php artisan key:generate
sudo sleep 5
if [ ${MODE} = "Production" ]
then
  sudo ${DOCKER_COMPOSE} exec -T php sh -c "chown -R www-data:www-data public/storage/"
  sudo ${DOCKER_COMPOSE} exec -T php sh -c "chown -R www-data:www-data storage/"
else
  sudo ${DOCKER_COMPOSE} exec -T php php artisan serv --host=0.0.0.0 --port=80
fi
