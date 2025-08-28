# Shise-Cal - 施設管理システム (GitHub Pages版)

このプロジェクトは、GitHub Pagesを使用してデモサイトとして公開されています。

## 🌐 デモサイト

GitHub Pagesで公開されたデモサイトにアクセスできます：
- **URL**: `https://[your-username].github.io/[repository-name]/`

## 📋 使用方法

### ログイン
1. デモサイトにアクセスすると、自動的にログイン画面にリダイレクトされます
2. 任意のユーザー名とパスワードを入力してください
3. 以下の7つの役割から選択できます：
   - **システム管理者**: 全施設・管理機能へのフルアクセス
   - **編集者**: 全施設情報の編集権限
   - **承認者**: 全施設の変更承認権限
   - **閲覧者（役員・本社）**: CSV/PDF出力付きで全施設の閲覧
   - **閲覧者（部門責任者）**: CSV/PDF出力付きで部門施設のみの閲覧
   - **閲覧者（地区担当）**: CSV/PDF出力付きで割り当てられた地区施設のみの閲覧
   - **閲覧者（事業所）**: 自施設情報のみの閲覧

### ダッシュボード
ログイン後、ダッシュボードで以下の機能を確認できます：
- ユーザー情報表示
- システム統計情報
- お知らせ・通知セクション
- 最近の活動履歴
- クイックアクション

## 🚀 GitHub Pagesへのデプロイ

### 自動デプロイ
このプロジェクトは GitHub Actions を使用して自動的にデプロイされます：

1. `main` または `master` ブランチにプッシュすると自動的にビルド・デプロイが実行されます
2. GitHub Actions が以下の処理を行います：
   - Node.js と PHP の環境セットアップ
   - 依存関係のインストール
   - アセットのビルド
   - 静的HTMLファイルの生成
   - GitHub Pages への公開

### 手動デプロイ
ローカルで静的サイトを生成する場合：

```bash
# プロジェクトディレクトリに移動
cd facility-management-system

# 依存関係のインストール
composer install --no-dev --optimize-autoloader
npm ci

# アセットのビルド
npm run build

# 静的サイトの生成
php artisan site:generate --output=../docs
```

### GitHub Pages の設定

1. GitHubリポジトリの「Settings」タブに移動
2. 左サイドバーの「Pages」をクリック
3. 「Source」で「Deploy from a branch」を選択
4. 「Branch」で「gh-pages」を選択
5. 「Save」をクリック

## 📁 ファイル構成

```
facility-management-system/
├── .github/workflows/deploy.yml    # GitHub Actions ワークフロー
├── app/Console/Commands/
│   └── GenerateStaticSite.php      # 静的サイト生成コマンド
├── resources/views/                 # Bladeテンプレート
├── public/                         # 静的アセット
└── docs/                          # 生成された静的サイト（GitHub Pages用）
```

## 🔧 技術仕様

- **フレームワーク**: Laravel 10
- **フロントエンド**: Bootstrap 5 + カスタムCSS
- **ビルドツール**: Vite
- **デプロイ**: GitHub Actions + GitHub Pages
- **対応ブラウザ**: モダンブラウザ（Chrome, Firefox, Safari, Edge）

## 📝 注意事項

- これはデモ版のため、実際のデータベース機能は含まれていません
- ログイン機能はフロントエンドのみの実装です
- 実際の本番環境では、適切なバックエンド実装が必要です

## 🤝 貢献

プロジェクトへの貢献を歓迎します：

1. このリポジトリをフォーク
2. 機能ブランチを作成 (`git checkout -b feature/amazing-feature`)
3. 変更をコミット (`git commit -m 'Add some amazing feature'`)
4. ブランチにプッシュ (`git push origin feature/amazing-feature`)
5. プルリクエストを作成

## 📄 ライセンス

このプロジェクトはMITライセンスの下で公開されています。