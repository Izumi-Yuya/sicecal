# 施設カルテシステム - プロジェクト基盤セットアップ

## 完了した作業

### 1. Laravel 10.x プロジェクトの初期化
- Laravel 10.x フレームワークのインストール完了
- 基本的なプロジェクト構造の作成
- 環境設定ファイル (.env) の設定

### 2. Bootstrap 5 とフロントエンド開発環境のセットアップ
- Bootstrap 5.3.x のインストール
- Sass (SCSS) サポートの追加
- Vite ビルドシステムの設定
- カスタムスタイルシートの作成

## インストールされたパッケージ

### NPM パッケージ
- `bootstrap@^5.3.0` - Bootstrap 5 フレームワーク
- `@popperjs/core` - Bootstrap のドロップダウン、ポップオーバー等に必要
- `sass` - Sass/SCSS コンパイラ

### Laravel パッケージ
- Laravel 10.x (最新安定版)
- Laravel Sanctum (認証用)
- Laravel Tinker (デバッグ用)

## ファイル構造

### フロントエンド関連
```
resources/
├── sass/
│   ├── app.scss          # メインSassファイル
│   ├── _variables.scss   # Bootstrap変数のオーバーライド
│   └── _custom.scss      # カスタムスタイル
├── js/
│   ├── app.js           # メインJavaScriptファイル
│   └── bootstrap.js     # Bootstrap設定
└── views/
    ├── layouts/
    │   └── app.blade.php # メインレイアウト
    ├── welcome.blade.php # ホームページ
    └── test-bootstrap.blade.php # Bootstrapテストページ
```

### 設定ファイル
- `vite.config.js` - Viteビルド設定
- `package.json` - NPM依存関係
- `.env` - 環境設定

## 利用可能な機能

### 1. レスポンシブレイアウト
- Bootstrap 5のグリッドシステム
- モバイルファーストデザイン
- 日本語フォント対応 (Noto Sans JP)

### 2. UIコンポーネント
- ナビゲーションバー
- カード
- ボタン
- フォーム
- テーブル
- モーダル
- アラート

### 3. カスタムスタイル
- 施設管理システム用のカラーパレット
- カスタムコンポーネントスタイル
- ファイルアップロード用スタイル
- ステータスバッジ

## 開発コマンド

### フロントエンド開発
```bash
# 開発サーバー起動 (ホットリロード)
npm run dev

# 本番用ビルド
npm run build
```

### Laravel開発
```bash
# 開発サーバー起動
php artisan serve

# キャッシュクリア
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## テストページ

### Bootstrap コンポーネントテスト
- URL: `/test-bootstrap`
- 各種Bootstrapコンポーネントの動作確認
- JavaScript機能のテスト

## 次のステップ

1. データベース設計と基本モデルの実装
2. 認証・認可システムの実装
3. 施設情報管理機能の実装

## 注意事項

- Sass の deprecation warning は Bootstrap 5 の既知の問題です
- 本番環境では `npm run build` でアセットをビルドしてください
- 開発時は `npm run dev` でホットリロードを利用できます