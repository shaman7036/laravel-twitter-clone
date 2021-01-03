## アプリケーションの実行につきまして
必須技術
- docker
- docker-compose
- git 
 
必須メモリー
- 1GB

### リポジトリーのクローン
> git clone https://github.com/goartisan/b-twitter-laravel.git b_twitter_laravel  
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

### データベースの作成と初期データの投入
次のコマンドを実行し、dbコンテナにマウントされているsqlファイルを実行します。
> docker-compose exec db mysql -u root -pdocker -e "source docker-entrypoint-initdb.d/init.sql"  

パスワード入力実行のため[Warning]が出ますが、データベースが作成され初期データが投入されます。

### Laravelの起動
> docker-compose exec php php artisan serve --host=0.0.0.0 --port=80  

http://localhost  
(VMを介したDocker環境の場合、VMへのIPへアクセスしてください。)
