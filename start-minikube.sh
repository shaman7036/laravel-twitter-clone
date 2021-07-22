#!/bin/sh

APP_NAME=laravel-twitter-clone

# Check if a user is root or not
if [ $(id -u) -ne 0 ]; then
    echo 'You are not running a shell as root user, please run "sudo su" first.'
    exit
fi

# Install minikube
if ! command -v minikube
then
    curl -Lo minikube https://storage.googleapis.com/minikube/releases/latest/minikube-linux-amd64 
    chmod +x minikube
    sudo mv minikube /usr/local/bin/
fi

# Install kubectl
if ! command -v kubectl
then
    curl -Lo kubectl https://storage.googleapis.com/kubernetes-release/release/$(curl -s https://storage.googleapis.com/kubernetes-release/release/stable.txt)/bin/linux/amd64/kubectl 
    chmod +x kubectl
    sudo mv kubectl /usr/local/bin/
fi

# Install docker
if ! command -v docker
then
    sudo apt-get update && sudo apt-get install docker.io -y
    sudo apt-get install conntrack
fi

# Move the repository to /data
path=$(pwd)
if $path=/data/${APP_NAME}; then
    echo $path
else
    cd /
    sudo mkdir -p data
    sudo mv $path /data/${APP_NAME}
fi

# Start minikube
sudo minikube start --vm-driver=none

# Enable ingress
sudo minikube addons enable ingress

# Apply deployment.yml and service.yml
cd /
cd /data/${APP_NAME}
sudo kubectl apply -f .k8s/deployment.yml -f .k8s/service.yml
sleep 10
sudo kubectl get pods
sleep 20

# Set up laravel
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "cp .env.example .env"
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "sed -i 's/DB_HOST=db/DB_HOST=0.0.0.0/g' .env"
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "composer install"
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "php artisan key:generate"
sleep 5
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "php artisan migrate"

# Apply ingress.yml
sudo kubectl apply -f .k8s/ingress.yml

# Start laravel
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "php artisan serve --host=0.0.0.0 --port=80"
