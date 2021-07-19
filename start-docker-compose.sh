#!/bin/sh

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
  sudo curl -L "https://github.com/docker/compose/releases/download/1.27.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
  sudo chmod +x /usr/local/bin/docker-compose && \
  sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
fi

# Build and up
sudo docker-compose down
sudo docker-compose build
sudo docker-compose up -d
sudo docker-compose ps
sudo docker-compose exec -T db mysql -uroot -pdocker -e "source docker-entrypoint-initdb.d/init.sql"
sudo docker-compose exec -T php cp .env.example .env
sudo docker-compose exec -T php composer install
sudo docker-compose exec -T php php artisan key:generate
sudo sleep 5
sudo docker-compose exec -T php php artisan serv --host=0.0.0.0 --port=80
