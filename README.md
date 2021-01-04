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

### phpコンテナの作成
> docker-compose run php

作成に伴い依存パッケージがインスートールされ、APP_KEYが生成されます。
### 各コンテナの起動
> docker-compose up -d

### 各コンテナの動作の確認
> docker-compose ps  

3つのコンテナのStateが全て```Up```になってるのを確認してください。

### データベースの作成と初期データの投入
> docker-compose exec db mysql -u root -pdocker -e "source docker-entrypoint-initdb.d/init.sql"  

パスワード入力実行のため[Warning]が出ますが、データベースが作成され初期データが投入されます。

### アクセス
> http://localhost/home  

(VMを介したDocker環境の場合、VMへのIPへアクセスしてください。)
