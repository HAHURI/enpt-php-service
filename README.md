# DockerベースのまっさらなPHPのてんぷれーと

起動するサービスは以下の通り
```
nginx     HTTP接続層
php       CGI言語
pgsql     DB
pgadmin   Postgres管理用WebUI
```

## 起動・停止

起動
```
$ docker-compose up -d
```
停止
```
$ docker-compose down
```

## URL

サービスのWebページ  
```
localhost:9999
```
postgresのサーバー
```
localhost:5432
```
pgadminの管理画面
```
localhost:5050
```


## 構成
* 改修して行く先は「./app」配置
* nginxの設定は「./nginx/site.conf」
* pgsqlのデータは「./pgsql」配置


## pgadminへの接続
デフォルトのログインアカウントは以下の通り
```
USER：user@domain.com
PASS：SuperSecret
```

データベースの追加は以下の通り
```
サーバー名：自由に決めて
HOSTNAME：enpt-php-service_pgsql_1
DBNAME：postgres
USERNAME：postgres
PASSWORD：example
PORT:5432
```


## めも

### Herokuにapp階層以下をあげる方法

```
$ heroku auth:login
Enter your Heroku credentials:
Email: [ユーザ登録したときのメールアドレス]
Password: [ユーザ登録したときのパスワード]
Logged in as [ユーザ登録したときのメールアドレス]
$ heroku create [アプリケーション名] --buildpack heroku/php
```
「heroku create [アプリケーション名] --buildpack heroku/php」でHerokuにPHPアプリの雛形ができるっぽい。

### Herokuのpostgresを雛形に追加する

```
$ heroku addons:add heroku-postgresql
```
postgresを追加する。  
でも、これだとDBとPHPが紐づいていないっぽい。

### HerokuのPHPアプリにpostgresを紐付ける
まず、postgresの詳細情報を「heroku config」で調べる。
```
$ heroku config
DATABASE_URL: postgres://[ユーザ名]:[パスワード]@[ホスト名]:[ポート]/[データベース名]
```
DATABASE_URLから、各種DB設定が読み取れる。  
ちなみに、この値を使えば、外から接続もできるっぽい。  
Herokuの環境変数？を以下のように追加する。

```
$ heroku config:set DB_CONNECTION=pgsql
$ heroku config:set DB_HOST=[ホスト名]
$ heroku config:set DB_PORT=[ポート]
$ heroku config:set DB_DATABASE=[データベース名]
$ heroku config:set DB_USERNAME=[ユーザ名]
$ heroku config:set DB_PASSWORD=[パスワード]
```

### Herokuにサービスをあげる

まず、作ったHerokuのPHPアプリをpushするリモートリポジトリに追加する。
```
git remote add heroku https://git.heroku.com/[アプリケーション名].git
```
そして、herokuに反映したい変更をコミットする。
コミットとか荒れるし、ブランチを切ってやるのが良いと思う。
```
git add .
git commit -m 'コミットメッセージ'
```
最後にHerokuにpushする。
```
git subtree push --prefix app/ heroku master
```
これの結果、エラーが出なければあげれたはず。


### Herokuにあげたアプリが動いていることを確認する

```
heroku open
```
きっと表示されるのです。


### HerokuのpostgresをLocalのpgadminから使う
```
$ heroku config
DATABASE_URL: postgres://[ユーザ名]:[パスワード]@[ホスト名]:[ポート]/[データベース名]
```
- 言語設定は英語にしておく（日本語の方が不安定？）
- heroku configのpostgresの値をDB情報に記入
- 「DB Restriction」に[データベース名]を設定して、自分のDBだけ表示されるようにする  

どうしても接続は不安定なので、接続が切れたら再読むといけるはず。


参考にしました！  
https://qiita.com/kai_kou/items/b708178a4322337061e3#laravel%E3%81%AE%E3%83%9E%E3%82%A4%E3%82%B0%E3%83%AC%E3%83%BC%E3%82%B7%E3%83%A7%E3%83%B3
