# skill-test

Laravel開発環境（Docker Compose）

## 環境

- PHP 8.4 (FPM, Alpine)
- Nginx (Alpine)
- MySQL 8.0
- Composer 2.9
- Node.js 20

## 必要なもの

- Docker
- Docker Compose
- Make

## セットアップ

### 1. コンテナの起動

```bash
make build
make up
```

### 2. Laravelのインストール（初回のみ）

```bash
docker-compose exec skill-test-app composer create-project laravel/laravel src
```

### 3. アクセス

- **HTTPS**: https://localhost:18443
- **HTTP**: http://localhost:18080 (自動的にHTTPSへリダイレクト)
- **MySQL**: localhost:13307

### データベース接続情報

- Host: `skill-test-db` (コンテナ内) / `localhost` (ホストから)
- Port: `3306` (コンテナ内) / `13307` (ホストから)
- Database: `laravel`
- Username: `laravel`
- Password: `laravel_password`
- Root Password: `root_password`

## Makeコマンド

```bash
make help       # ヘルプを表示
make up         # コンテナを起動
make down       # コンテナを停止・削除
make build      # コンテナをビルド
make restart    # コンテナを再起動
make logs       # ログを表示
make ps         # コンテナ一覧を表示
make attach-app # PHPコンテナにアタッチ
make pint       # コードフォーマット（Laravel Pint）
make pint-test  # フォーマットチェックのみ
make ide-helper # IDE Helperファイル生成
make clean      # コンテナ停止・ボリューム削除
```

## SSL証明書について

開発環境用の自己署名証明書はコンテナ起動時に自動生成されます。

- コンテナ起動（または再起動）のたびに新しい証明書が生成されます
- 証明書は `docker/nginx/ssl/` に保存されます
- 証明書の有効期限は365日です

ブラウザで証明書の警告が表示される場合は、安全でないページとして続行してください。

## コンテナ構成

- `skill-test-app`: PHP-FPMアプリケーションサーバー
- `skill-test-nginx`: Nginx Webサーバー
- `skill-test-db`: MySQL データベース
- `skill-test-network`: コンテナ間通信用ネットワーク
- `skill-test-db-data`: データベースの永続化ボリューム