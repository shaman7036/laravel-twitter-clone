## アプリケーションの実行につきまして
必須技術
- docker
- docker-compose
- git 
 
必須メモリー
- 2GB

### リポジトリーのクローン
> git clone -b release/v0.1 https://github.com/goartisan/b-twitter-laravel.git b_twitter_laravel  
> cd b_twitter_laravel

### コンテナの作成と起動
> docker-compose up -d --build

### 各コンテナの動作の確認
> docker-compose ps  

3つのコンテナのStatusが全て```Up```になってるのを確認してください。

### 依存パッケージのインストール
> docker-compose exec php composer install

### APP_KEYの生成
> cp ./server/.env.example ./server/.env  
> docker-compose exec php php artisan key:generate

### データーベースの作成
> docker-compose exec db mysqladmin -u root -pdocker create b_twitter_laravel  

パスワード入力実行のため[Warning]が出ますが、データーベースが作成されます。

### マイグレーション
> docker-compose exec php php artisan migrate 

### Laravelの起動
> docker-compose exec php php artisan serve --host=0.0.0.0 --port=80  

http://localhost  
(VMを介したDocker環境の場合、VMへのIPへアクセスしてください。)
