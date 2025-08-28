# 設計書

## 概要

施設カルテシステム（Shise-Cal）は、Laravel フレームワークを使用したWebアプリケーションとして設計されます。AWS上でホストされ、ロールベースのアクセス制御、承認ワークフロー、ファイル管理機能を提供します。

## アーキテクチャ

### システム構成

```
[ユーザー] → [ALB] → [EC2/Laravel] → [RDS/MySQL] 
                           ↓
                      [S3/ファイル保管]
```

### 技術スタック

- **フレームワーク**: Laravel 10.x
- **言語**: PHP 8.2+
- **データベース**: MySQL 8.0
- **クラウド**: AWS (EC2, RDS, S3, ALB)
- **フロントエンド**: Laravel Blade + Bootstrap 5
- **認証**: Laravel Sanctum + IP制限ミドルウェア

### セキュリティ設計

- **認証**: メールアドレス + パスワード
- **IP制限**: カスタムミドルウェアで社内IP範囲を制限
- **ロールベース認証**: Laravel Gates/Policies
- **ファイルアクセス**: 署名付きURL（S3）

## ユーザーインターフェース設計

### 施設詳細画面の構造

施設詳細画面は入力項目一覧に基づき、大分類をタブ、分類をドロップダウンで整理します：

#### タブ構成（大分類）
1. **基本情報** - 施設の基本的な情報
2. **土地** - 土地の詳細情報
3. **建物** - 建物の詳細情報  
4. **ライフライン・設備** - 電気、ガス、水道、通信、エレベーター、空調機
5. **防犯・防災** - 防犯カメラ、電子錠、消防・防災
6. **契約書** - 各種契約書類の管理
7. **図面** - 建築図面類の管理
8. **大規模修繕履歴** - 修繕・改修工事の履歴
9. **ドキュメント** - その他の書類管理

#### 各タブ内のドロップダウン構成

**1. 基本情報タブ**
- 基本 (ドロップダウンなし - 全項目表示)

**2. 土地タブ**  
- 土地 (ドロップダウンなし - 全項目表示)

**3. 建物タブ**
- 建物 (ドロップダウンなし - 全項目表示)

**4. ライフライン・設備タブ**
- 電気 (ドロップダウン)
- ガス (ドロップダウン) 
- 水道 (ドロップダウン)
- 通信 (ドロップダウン)
- エレベーター (ドロップダウン)
- 空調機 (ドロップダウン)

**5. 防犯・防災タブ**
- 防犯カメラ (ドロップダウン)
- 電子錠 (ドロップダウン)
- 消防・防災 (ドロップダウン)

**6. 契約書タブ**
- 厨房委託 (ドロップダウン)
- 賃貸（休憩室） (ドロップダウン)
- 賃貸（倉庫） (ドロップダウン)
- 賃貸（駐車場） (ドロップダウン)
- カラオケ機器 (ドロップダウン)
- 定期清掃 (ドロップダウン)
- 害虫駆除 (ドロップダウン)
- リネン (ドロップダウン)
- クリーニング (ドロップダウン)
- 洗濯委託契約 (ドロップダウン)
- マットレンタル (ドロップダウン)
- 理美容 (ドロップダウン)
- 自動販売機 (ドロップダウン)
- コーヒー (ドロップダウン)
- 観葉植物 (ドロップダウン)
- 除排雪 (ドロップダウン)
- 産業廃棄物処理 (ドロップダウン)
- グリストラップ (ドロップダウン)
- その他契約書 (ドロップダウン)

**7. 図面タブ**
- 図面関係 (ドロップダウンなし - 全項目表示)

**8. 大規模修繕履歴タブ**
- 外壁（防水） (ドロップダウン)
- 外壁（塗装） (ドロップダウン)
- 内装リニューアル (ドロップダウン)
- 躯体修繕 (ドロップダウン)
- 内装修繕 (ドロップダウン)
- 修繕関連ドキュメント (ドロップダウン)

**9. ドキュメントタブ**
- その他ドキュメント (ドロップダウンなし - 全項目表示)

### フォーム入力仕様

#### 入力形式の統一
- **日付**: YYYY/MM/DD形式、表示は「2000年12月12日」
- **郵便番号**: ハイフンあり形式（123-4567）
- **電話番号**: ハイフンあり形式（03-1234-5678）
- **金額**: カンマ区切り表示（1,000,000円）
- **面積**: 小数点2桁まで表示（290.00㎡）

#### 自動計算機能
- 開設年数（開設日から自動計算）
- 築年数（竣工日から自動計算）
- 契約年数（契約期間から自動計算）
- 坪単価（価格÷面積で自動計算）
- 稼働率（実利用者数÷定員で自動計算）

#### 入力例表示
- 郵便番号: 例）123-4567
- 電話番号: 例）03-1234-5678
- FAX番号: 例）03-1234-5679
- フリーダイヤル: 例）0120-123-456
- メールアドレス: 例）info@example.com
- URL: 例）https://www.example.com
- 住所: 例）千葉県千葉市花見川区畑町455-5
- 建物名: 例）ハイネス高橋202号室
- 面積: 例）290.00
- 金額: 例）1,000,000
- 日付: 例）2000年12月12日

## コンポーネントと インターフェース

### 1. 認証・認可システム

#### User Model
```php
class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role_id'];
    
    public function role(): BelongsTo
    public function facilities(): BelongsToMany  // 地区担当者用
}
```

#### Role Model
```php
class Role extends Model
{
    const SYSTEM_ADMIN = 1;
    const EDITOR = 2;
    const APPROVER = 3;
    const VIEWER_EXECUTIVE = 4;
    const VIEWER_DEPARTMENT = 5;
    const VIEWER_REGIONAL = 6;
    const VIEWER_FACILITY = 7;
    const PRIMARY_RESPONDER = 8;
}
```

### 2. 施設管理システム

#### Facility Model
```php
class Facility extends Model
{
    protected $fillable = [
        // 基本情報
        'company_name', 'facility_code', 'designation_number', 'name', 
        'postal_code', 'address', 'building_name', 'phone_number', 'fax_number', 
        'free_dial', 'email', 'url', 'opening_date', 'building_structure', 
        'building_floors', 'room_count_paid', 'internal_ss_count', 'capacity', 
        'service_types', 'designation_renewal_date',
        
        // 土地情報
        'land_ownership', 'site_parking_spaces', 'site_area_sqm', 'site_area_tsubo',
        'land_purchase_price', 'land_rent', 'land_contract_start_date', 'land_contract_end_date',
        'land_auto_renewal', 'land_management_company', 'land_management_postal_code',
        'land_management_address', 'land_management_building_name', 'land_management_phone',
        'land_management_fax', 'land_management_email', 'land_management_url', 'land_management_notes',
        'land_owner_name', 'land_owner_postal_code', 'land_owner_address', 'land_owner_building_name',
        'land_owner_phone', 'land_owner_fax', 'land_owner_email', 'land_owner_url', 'land_owner_notes',
        
        // 建物情報  
        'building_ownership', 'building_area_sqm', 'building_area_tsubo', 'floor_area_sqm', 
        'floor_area_tsubo', 'building_main_price', 'building_cooperation_fund', 'building_rent_monthly',
        'building_contract_start_date', 'building_contract_end_date', 'building_auto_renewal',
        'building_management_company', 'building_management_postal_code', 'building_management_address',
        'building_management_building_name', 'building_management_phone', 'building_management_fax',
        'building_management_email', 'building_management_url', 'building_management_notes',
        'building_owner_name', 'building_owner_postal_code', 'building_owner_address', 
        'building_owner_building_name', 'building_owner_phone', 'building_owner_fax',
        'building_owner_email', 'building_owner_url', 'building_owner_notes',
        'construction_company', 'construction_company_phone', 'construction_company_notes',
        'completion_date', 'useful_life', 'building_inspection_type', 'building_inspection_date',
        'building_inspection_notes',
        
        // 部門・地区
        'department_id', 'region_id', 'status'
    ];
    
    protected $dates = [
        'opening_date', 'designation_renewal_date', 'land_contract_start_date', 'land_contract_end_date',
        'building_contract_start_date', 'building_contract_end_date', 'completion_date', 'building_inspection_date'
    ];
    
    protected $casts = [
        'service_types' => 'array',
        'site_area_sqm' => 'decimal:2',
        'site_area_tsubo' => 'decimal:2', 
        'building_area_sqm' => 'decimal:2',
        'building_area_tsubo' => 'decimal:2',
        'floor_area_sqm' => 'decimal:2',
        'floor_area_tsubo' => 'decimal:2',
        'land_purchase_price' => 'integer',
        'land_rent' => 'integer',
        'building_main_price' => 'integer',
        'building_cooperation_fund' => 'integer',
        'building_rent_monthly' => 'integer'
    ];
    
    public function department(): BelongsTo
    public function region(): BelongsTo
    public function maintenanceHistories(): HasMany
    public function documents(): HasMany
    public function approvals(): HasMany
    public function comments(): HasMany
    public function annualVerifications(): HasMany
    public function contractAlerts(): HasMany
    public function equipmentRecords(): HasMany
    public function contractRecords(): HasMany
    
    // 自動計算メソッド
    public function getOperatingYearsAttribute()
    {
        if (!$this->opening_date) return null;
        return $this->opening_date->diffForHumans(now(), true);
    }
    
    public function getBuildingAgeAttribute() 
    {
        if (!$this->completion_date) return null;
        return $this->completion_date->diffForHumans(now(), true);
    }
    
    public function getLandUnitPriceAttribute()
    {
        if (!$this->land_purchase_price || !$this->site_area_tsubo) return null;
        return $this->land_purchase_price / $this->site_area_tsubo;
    }
    
    public function getBuildingUnitPriceAttribute()
    {
        if (!$this->building_main_price || !$this->floor_area_tsubo) return null;
        return $this->building_main_price / $this->floor_area_tsubo;
    }
    
    // Input examples for form placeholders
    public static function inputExamples()
    {
        return [
            'name' => '例）○○介護センター',
            'postal_code' => '例）123-4567',
            'phone_number' => '例）03-1234-5678',
            'fax_number' => '例）03-1234-5679',
            'free_dial' => '例）0120-123-456',
            'email' => '例）info@example.com',
            'url' => '例）https://www.example.com',
            'address' => '例）千葉県千葉市花見川区畑町455-5',
            'building_name' => '例）ハイネス高橋202号室',
            'site_area_sqm' => '例）290.00',
            'land_purchase_price' => '例）10,000,000',
            'opening_date' => '例）2000年12月12日'
        ];
    }
}
```

#### MaintenanceHistory Model
```php
class MaintenanceHistory extends Model
{
    protected $fillable = [
        'facility_id', 'maintenance_date', 'description', 
        'details', 'cost', 'contractor'
    ];
}
```

### 3. 承認ワークフローシステム

#### Approval Model
```php
class Approval extends Model
{
    protected $fillable = [
        'facility_id', 'user_id', 'approver_id', 'type',
        'data_before', 'data_after', 'status', 'comments'
    ];
    
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
}
```

### 4. ファイル管理システム

#### Document Model
```php
class Document extends Model
{
    protected $fillable = [
        'facility_id', 'filename', 'original_name', 
        'file_path', 'file_size', 'mime_type', 'uploaded_by'
    ];
}
```

### 5. コメント・通知システム

#### Comment Model
```php
class Comment extends Model
{
    protected $fillable = [
        'facility_id', 'user_id', 'content', 'status', 'response'
    ];
    
    const STATUS_OPEN = 'open';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESOLVED = 'resolved';
}
```

### 6. 年次確認システム

#### AnnualVerification Model
```php
class AnnualVerification extends Model
{
    protected $fillable = [
        'facility_id', 'user_id', 'year', 'status', 
        'verified_at', 'discrepancies'
    ];
}
```

## データモデル

### データベース設計

#### 主要テーブル構造

**users テーブル**
- id (PK)
- name
- email (unique)
- password
- role_id (FK)
- department_id (FK) - 部門ID
- region_id (FK) - 地区ID（地区担当者用）
- facility_id (FK) - 施設ID（事業所ユーザー用）
- created_at, updated_at

**facilities テーブル** (入力項目一覧に基づく詳細設計)
- id (PK)
- 基本情報
  - company_name - 会社名
  - facility_code - 事業所コード
  - designation_number - 指定番号
  - name - 施設名 (required, unique)
  - postal_code - 郵便番号（ハイフンあり）
  - address - 住所
  - building_name - 住所（建物名）
  - phone_number - 電話番号
  - fax_number - FAX番号
  - free_dial - フリーダイヤル
  - email - メールアドレス
  - url - URL
  - opening_date - 開設日
  - building_structure - 建物構造
  - building_floors - 建物階数
  - room_count_paid - 居室数（有料）
  - internal_ss_count - 内SS数
  - capacity - 定員数
  - service_types (JSON) - サービスの種類
  - designation_renewal_date - 指定更新日
- 土地情報
  - land_ownership - 土地所有区分
  - site_parking_spaces - 敷地内駐車場台数
  - site_area_sqm - 敷地面積(㎡)
  - site_area_tsubo - 敷地面積(坪数)
  - land_purchase_price - 土地購入金額
  - land_rent - 土地家賃
  - land_contract_start_date - 土地契約開始日
  - land_contract_end_date - 土地契約終了日
  - land_auto_renewal - 土地自動更新の有無
  - land_management_* - 土地管理会社情報（会社名、住所、連絡先等）
  - land_owner_* - 土地オーナー情報（氏名、住所、連絡先等）
- 建物情報
  - building_ownership - 建物所有区分
  - building_area_sqm - 建築面積（㎡）
  - building_area_tsubo - 建築面積（坪数）
  - floor_area_sqm - 延床面積（㎡）
  - floor_area_tsubo - 延床面積（坪数）
  - building_main_price - 本体価格（建築費用）
  - building_cooperation_fund - 建設協力金
  - building_rent_monthly - 建物家賃（月）
  - building_contract_start_date - 建物契約開始日
  - building_contract_end_date - 建物契約終了日
  - building_auto_renewal - 建物自動更新の有無
  - building_management_* - 建物管理会社情報
  - building_owner_* - 建物オーナー情報
  - construction_company - 施工会社（会社名）
  - construction_company_phone - 施工会社（電話番号）
  - construction_company_notes - 施工会社備考欄
  - completion_date - 竣工日
  - useful_life - 耐用年数
  - building_inspection_type - 特定建築物定期調査（自社or他社）
  - building_inspection_date - 特定建築物定期調査（実施日）
  - building_inspection_notes - 特定建築物定期調査（備考）
- department_id (FK) - 所管部門
- region_id (FK) - 地区
- status - ステータス
- created_at, updated_at

**equipment_records テーブル** (設備管理)
- id (PK)
- facility_id (FK)
- category (enum: electrical, gas, water, communication, elevator, hvac)
- subcategory - 小分類
- equipment_type - 設備種別
- manufacturer - メーカー
- model - 型式
- installation_date - 設置年月日
- last_update_date - 更新年月日
- maintenance_company - 保守業者
- maintenance_date - 保守実施日
- inspection_date - 点検実施日
- notes - 備考
- status - ステータス
- created_at, updated_at

**contract_records テーブル** (契約管理)
- id (PK)
- facility_id (FK)
- contract_type (enum: kitchen, cleaning, pest_control, linen, parking, karaoke, vending_machine, beauty, snow_removal, waste_disposal, grease_trap, other)
- company_name - 会社名
- contract_start_date - 契約開始日
- contract_end_date - 契約終了日
- auto_renewal - 自動更新の有無
- amount - 契約金額
- notes - 備考
- status - ステータス
- created_at, updated_at

**departments テーブル**
- id (PK)
- name - 部門名（総務部、企画管理部、経理部等）
- created_at, updated_at

**regions テーブル**
- id (PK)
- name - 地区名
- department_id (FK) - 所管部門
- created_at, updated_at

**roles テーブル**
- id (PK)
- name - ロール名
- display_name - 表示名
- description - 説明
- created_at, updated_at

**approvals テーブル**
- id (PK)
- facility_id (FK)
- user_id (FK) - 申請者
- approver_id (FK) - 承認者
- type (enum: create, update, delete)
- data_before (JSON)
- data_after (JSON)
- status (enum: pending, approved, rejected)
- comments
- approved_at
- created_at, updated_at

**documents テーブル**
- id (PK)
- facility_id (FK)
- document_type (enum: contract, blueprint, inspection_report, other)
- filename
- original_name
- file_path (S3キー)
- file_size
- mime_type
- uploaded_by (FK)
- created_at, updated_at

**maintenance_histories テーブル**
- id (PK)
- facility_id (FK)
- maintenance_date - 修繕実施日
- maintenance_type - 修繕種別
- description - 修繕内容
- details - 詳細
- cost - 費用
- contractor - 施工業者
- created_by (FK)
- created_at, updated_at

**comments テーブル**
- id (PK)
- facility_id (FK)
- user_id (FK) - コメント投稿者
- content - コメント内容
- status (enum: open, in_progress, resolved)
- response - 対応内容
- responded_by (FK) - 対応者
- responded_at
- created_at, updated_at

**annual_verifications テーブル**
- id (PK)
- facility_id (FK)
- user_id (FK) - 確認者
- year - 対象年度
- status (enum: pending, verified, discrepancy_reported)
- discrepancies - 相違内容
- verified_at
- created_at, updated_at

**export_favorites テーブル**
- id (PK)
- user_id (FK)
- name - お気に入り名
- export_type (enum: csv, pdf)
- selected_fields (JSON) - 選択項目
- selected_facilities (JSON) - 選択施設
- created_at, updated_at

**audit_logs テーブル**
- id (PK)
- user_id (FK)
- action - アクション種別
- model_type - 対象モデル
- model_id - 対象ID
- old_values (JSON) - 変更前データ
- new_values (JSON) - 変更後データ
- ip_address - IPアドレス
- user_agent - ユーザーエージェント
- created_at

**contract_alerts テーブル** (契約期限アラート)
- id (PK)
- facility_id (FK)
- alert_type (enum: lease_contract, fire_insurance, earthquake_insurance)
- expiry_date - 期限日
- alert_date - アラート送信日
- status (enum: pending, sent, resolved)
- created_at, updated_at

### リレーション設計

- User → Role (多対一)
- User → Department (多対一)
- User → Region (多対一) - 地区担当者用
- User → Facility (多対一) - 事業所ユーザー用
- Department → Region (一対多)
- Region → Facility (一対多)
- Facility → Department (多対一)
- Facility → MaintenanceHistory (一対多)
- Facility → Document (一対多)
- Facility → Approval (一対多)
- Facility → Comment (一対多)
- Facility → AnnualVerification (一対多)
- User → ExportFavorite (一対多)
- User → AuditLog (一対多)
- Facility → ContractAlert (一対多)
- Facility → EquipmentRecord (一対多)
- Facility → ContractRecord (一対多)

## エラーハンドリング

### エラー処理戦略

1. **バリデーションエラー**
   - Laravel Form Requestを使用
   - 日本語エラーメッセージ
   - フロントエンドでのリアルタイム検証

2. **認証・認可エラー**
   - 403 Forbidden: 権限不足
   - 401 Unauthorized: 未認証
   - IP制限違反時の適切なメッセージ

3. **ファイルアップロードエラー**
   - ファイルサイズ制限
   - MIME type検証
   - S3アップロード失敗時の処理

4. **データベースエラー**
   - 重複データエラー
   - 外部キー制約エラー
   - トランザクション失敗時のロールバック

### ログ設計

```php
// カスタムログチャンネル
'channels' => [
    'audit' => [
        'driver' => 'daily',
        'path' => storage_path('logs/audit.log'),
        'level' => 'info',
    ],
    'security' => [
        'driver' => 'daily', 
        'path' => storage_path('logs/security.log'),
        'level' => 'warning',
    ],
]
```

## テスト戦略

### テスト分類

1. **単体テスト (PHPUnit)**
   - Model テスト
   - Service クラステスト
   - バリデーションテスト

2. **機能テスト (Feature Tests)**
   - 認証フロー
   - CRUD操作
   - 承認ワークフロー
   - ファイルアップロード

3. **ブラウザテスト (Laravel Dusk)**
   - ユーザーインターフェース
   - JavaScript機能
   - ファイルダウンロード

### テストデータ

```php
// Factory定義例
class FacilityFactory extends Factory
{
    public function definition()
    {
        return [
            'facility_code' => $this->faker->unique()->numerify('F####'),
            'name' => $this->faker->company . '事業所', // Required field
            'prefecture' => $this->faker->prefecture,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->optional()->numerify('#######'), // Optional
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'opening_date' => $this->faker->optional()->date(), // Optional
            'business_type' => $this->faker->randomElement(['通所介護', '訪問介護', '居宅介護支援']),
            'capacity' => $this->faker->numberBetween(10, 100),
            'floor_area' => $this->faker->randomFloat(2, 100, 1000),
            'construction_year' => $this->faker->year(),
            'department_id' => Department::factory(),
            'region_id' => Region::factory(),
        ];
    }
}
```

### CI/CD パイプライン

1. **コード品質チェック**
   - PHP CS Fixer
   - PHPStan
   - Laravel Pint

2. **自動テスト実行**
   - 単体テスト
   - 機能テスト
   - セキュリティテスト

3. **デプロイメント**
   - ステージング環境
   - 本番環境（承認後）

## パフォーマンス設計

### データベース最適化

1. **インデックス設計**
   - facilities.name (unique)
   - users.email (unique)
   - approvals.status + created_at
   - documents.facility_id

2. **クエリ最適化**
   - Eager Loading使用
   - N+1問題の回避
   - ページネーション実装

### キャッシュ戦略

```php
// 施設一覧のキャッシュ
Cache::remember('facilities.list', 3600, function () {
    return Facility::with('department', 'region')->get();
});

// ユーザー権限のキャッシュ
Cache::tags(['user.' . $userId])->remember('permissions', 1800, function () {
    return $user->getAllPermissions();
});
```

### ファイル配信最適化

- S3 CloudFront連携
- 署名付きURL（有効期限付き）
- 適切なCache-Controlヘッダー

## セキュリティ設計詳細

### IP制限実装

```php
class IpRestrictionMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedIps = config('security.allowed_ips');
        $clientIp = $request->ip();
        
        if (!in_array($clientIp, $allowedIps)) {
            abort(403, 'アクセスが許可されていません');
        }
        
        return $next($request);
    }
}
```

### ロールベース認可

```php
// Policy例
class FacilityPolicy
{
    public function view(User $user, Facility $facility)
    {
        return match($user->role->name) {
            'system_admin', 'editor', 'approver', 'viewer_executive' => true,
            'viewer_department' => $facility->department_id === $user->department_id,
            'viewer_regional' => $user->facilities->contains($facility->id),
            'viewer_facility' => $facility->id === $user->facility_id,
            default => false,
        };
    }
}
```

## 運用・保守設計

### 監視項目

1. **アプリケーション監視**
   - レスポンス時間
   - エラー率
   - ユーザーセッション数

2. **インフラ監視**
   - CPU/メモリ使用率
   - ディスク容量
   - ネットワーク帯域

3. **セキュリティ監視**
   - 不正アクセス試行
   - 異常なファイルアップロード
   - 権限昇格の試行

### バックアップ戦略

1. **データベース**
   - 日次自動バックアップ
   - ポイントインタイムリカバリ
   - 3世代保持

2. **ファイル**
   - S3クロスリージョンレプリケーション
   - バージョニング有効化
   - 3年間保持（法的要件）

### デプロイメント戦略

1. **Blue-Green デプロイメント**
   - ダウンタイム最小化
   - 即座のロールバック可能

2. **データベースマイグレーション**
   - 段階的スキーマ変更
   - 後方互換性の維持
### 7. 契約期限アラートシステム

#### EquipmentRecord Model
```php
class EquipmentRecord extends Model
{
    protected $fillable = [
        'facility_id', 'category', 'subcategory', 'equipment_type',
        'manufacturer', 'model', 'installation_date', 'last_update_date',
        'maintenance_company', 'maintenance_date', 'inspection_date',
        'notes', 'status'
    ];
    
    protected $dates = ['installation_date', 'last_update_date', 'maintenance_date', 'inspection_date'];
    
    const CATEGORY_ELECTRICAL = 'electrical';
    const CATEGORY_GAS = 'gas';
    const CATEGORY_WATER = 'water';
    const CATEGORY_COMMUNICATION = 'communication';
    const CATEGORY_ELEVATOR = 'elevator';
    const CATEGORY_HVAC = 'hvac';
}

#### ContractRecord Model
```php
class ContractRecord extends Model
{
    protected $fillable = [
        'facility_id', 'contract_type', 'company_name', 'contract_start_date',
        'contract_end_date', 'auto_renewal', 'amount', 'notes', 'status'
    ];
    
    protected $dates = ['contract_start_date', 'contract_end_date'];
    
    const TYPE_KITCHEN = 'kitchen';
    const TYPE_CLEANING = 'cleaning';
    const TYPE_PEST_CONTROL = 'pest_control';
    const TYPE_LINEN = 'linen';
    const TYPE_PARKING = 'parking';
    const TYPE_KARAOKE = 'karaoke';
    const TYPE_VENDING_MACHINE = 'vending_machine';
    const TYPE_BEAUTY = 'beauty';
    const TYPE_SNOW_REMOVAL = 'snow_removal';
    const TYPE_WASTE_DISPOSAL = 'waste_disposal';
    const TYPE_GREASE_TRAP = 'grease_trap';
    const TYPE_OTHER = 'other';
}

#### ContractAlert Model
```php
class ContractAlert extends Model
{
    protected $fillable = [
        'facility_id', 'alert_type', 'expiry_date', 
        'alert_date', 'status'
    ];
    
    protected $dates = ['expiry_date', 'alert_date'];
    
    const TYPE_LEASE = 'lease_contract';
    const TYPE_FIRE_INSURANCE = 'fire_insurance';
    const TYPE_EARTHQUAKE_INSURANCE = 'earthquake_insurance';
}
```

## 契約期限監視システム設計

### 契約期限監視システム

```php
class ContractMonitoringService
{
    public function checkExpiringContracts()
    {
        $facilities = Facility::all();
        
        foreach ($facilities as $facility) {
            // 賃貸借契約チェック
            if ($facility->lease_end_date && 
                $facility->lease_end_date->diffInDays(now()) <= 90) {
                $this->createAlert($facility, 'lease_contract');
            }
            
            // 火災保険チェック
            if ($facility->fire_insurance_end_date && 
                $facility->fire_insurance_end_date->diffInDays(now()) <= 60) {
                $this->createAlert($facility, 'fire_insurance');
            }
            
            // 地震保険チェック
            if ($facility->earthquake_insurance_end_date && 
                $facility->earthquake_insurance_end_date->diffInDays(now()) <= 60) {
                $this->createAlert($facility, 'earthquake_insurance');
            }
        }
    }
}
```