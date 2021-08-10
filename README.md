## アプリケーションの実行につきまして

Ubuntuにおけるインフラの構築をShellスクリプトとしてまとめました。  
リポジトリ内にある各環境に対応したShellを実行することによってアプリケーションを自動展開する事ができます。

### リポジトリのクローン

```
git clone https://github.com/goartisan/laravel-twitter-clone.git && cd laravel-twitter-clone
```

### Dockerによる実行

環境
- Linux Ubuntu (16.04 | 18.04 | 20.04)
- 1GB Memory

```
bash start-docker.sh
```

### Docker Composeによる実行

環境
- Linux Ubuntu (16.04 | 18.04 | 20.04)
- 1GB Memory

```
bash start-docker-compose.sh
```

### Kubernetes(Minikube)による実行

環境
- Linux Ubuntu (16.04 | 18.04 | 20.04)
- 2GB Memory
- 2 CPUs

```
bash start-minikube.sh
```
