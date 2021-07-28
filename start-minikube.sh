#!/bin/sh

# git clone https://github.com/goartisan/laravel-twitter-clone.git
# cd laravel-twitter-clone

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
sudo apt-get update && sudo apt-get install docker.io -y
sudo apt-get install conntrack

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

# Wait for a pod to start running
echo "Waiting for a pod is ready..."
sleep 5
while :
do
    POD_NAME=$(kubectl get pods -o jsonpath='{range .items[0]}{.metadata.name}{"\n"}')
    if [ "$(kubectl get pods ${POD_NAME} --no-headers -o custom-columns=':status.phase')" = "Running" ]
    then 
        echo ${POD_NAME}" is running"
        break
    else 
        sleep 1
    fi
done
sudo kubectl get pods

# Set up laravel
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "cp .env.example .env"
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "sed -i 's/DB_HOST=db/DB_HOST=0.0.0.0/g' .env"
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "composer install"
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "php artisan key:generate"
sleep 5
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "php artisan migrate"

# Apply ingress.yml
if grep "host: example.com" .k8s/ingress.yml; then
    echo -n host: && read HOST_NAME
    sed -i "s/- host: example.com/- host: ${HOST_NAME}/g" .k8s/ingress.yml
    echo .k8s/ingress.yml
fi
sudo kubectl apply -f .k8s/ingress.yml

# Start laravel
sudo kubectl exec -it deploy/${APP_NAME}-deployment -c php -- /bin/bash -c "php artisan serve --host=0.0.0.0 --port=80"
