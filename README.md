# Shise-Cal - 施設管理システム

施設情報を一元管理するWebアプリケーションです。権限管理と承認機能により、業務効率と情報の整合性向上を目的としています。

## 🌐 デモサイト

GitHub Pagesで公開されたデモサイトにアクセスできます：
- **URL**: https://[your-username].github.io/[repository-name]/

## 📋 機能概要

### ユーザー認証とロール管理
- 7つの役割に基づいたアクセス制御
- システム管理者、編集者、承認者、各種閲覧者

### 施設情報管理
- 施設の登録、更新、削除
- 承認ワークフロー
- ドキュメント・ファイル管理

### データ出力・レポート機能
- CSV/PDF形式での出力
- 権限に基づいた出力制御

## 🚀 使用方法

### デモサイトでの操作
1. デモサイトにアクセス
2. 任意のユーザー名・パスワードを入力
3. 役割を選択してログイン
4. ダッシュボードで各機能を確認

### ローカル開発環境

#### 必要な環境
- PHP 8.1以上
- Node.js 18以上
- Composer

#### セットアップ
```bash
# リポジトリをクローン
git clone [repository-url]
cd [repository-name]

# Laravel プロジェクトのセットアップ
cd facility-management-system
composer install
cp .env.example .env
php artisan key:generate

# フロントエンドのセットアップ
npm install
npm run dev

# 開発サーバー起動
php artisan serve
```

## 📁 プロジェクト構成

```
├── facility-management-system/     # Laravel アプリケーション
│   ├── app/                       # アプリケーションロジック
│   ├── resources/                 # ビュー・アセット
│   ├── public/                    # 静的ファイル
│   └── .github/workflows/         # GitHub Actions
├── docs/                          # 生成された静的サイト
└── README.md                      # このファイル
```

## 🔧 技術スタック

- **バックエンド**: Laravel 10
- **フロントエンド**: Bootstrap 5, Sass
- **ビルドツール**: Vite
- **デプロイ**: GitHub Actions + GitHub Pages

## 📝 ライセンス

このプロジェクトはMITライセンスの下で公開されています。

## 🤝 貢献

プロジェクトへの貢献を歓迎します。プルリクエストやイシューの報告をお待ちしています。