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
        'facility_code', 'name', 'prefecture', 'city', 'postal_code', 'address',
        'phone_number', 'fax_number', 'opening_date', 'business_type', 'capacity',
        'floor_area', 'building_structure', 'construction_year', 'land_ownership',
        'building_ownership', 'lease_start_date', 'lease_end_date', 'lease_monthly_rent',
        'management_company', 'fire_insurance_company', 'fire_insurance_start_date',
        'fire_insurance_end_date', 'earthquake_insurance_company', 'earthquake_insurance_start_date',
        'earthquake_insurance_end_date', 'department_id', 'region_id', 'status'
    ];
    
    protected $dates = [
        'opening_date', 'lease_start_date', 'lease_end_date',
        'fire_insurance_start_date', 'fire_insurance_end_date',
        'earthquake_insurance_start_date', 'earthquake_insurance_end_date'
    ];
    
    public function department(): BelongsTo
    public function region(): BelongsTo
    public function maintenanceHistories(): HasMany
    public function documents(): HasMany
    public function approvals(): HasMany
    public function comments(): HasMany
    public function annualVerifications(): HasMany
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

**facilities テーブル** (元仕様書の入力項目に基づく)
- id (PK)
- facility_code (unique) - 事業所コード
- name (unique) - 施設名
- prefecture - 都道府県
- city - 市区町村
- postal_code - 郵便番号（7桁、ハイフンなし）
- address - 住所
- phone_number - 電話番号
- fax_number - FAX番号
- opening_date - 開設年月日
- business_type - 事業種別
- capacity - 定員
- floor_area - 延床面積
- building_structure - 建物構造
- construction_year - 建築年
- land_ownership - 土地所有区分
- building_ownership - 建物所有区分
- lease_start_date - 賃貸借契約開始日
- lease_end_date - 賃貸借契約終了日
- lease_monthly_rent - 月額賃料
- management_company - 管理会社
- fire_insurance_company - 火災保険会社
- fire_insurance_start_date - 火災保険開始日
- fire_insurance_end_date - 火災保険終了日
- earthquake_insurance_company - 地震保険会社
- earthquake_insurance_start_date - 地震保険開始日
- earthquake_insurance_end_date - 地震保険終了日
- department_id (FK) - 所管部門
- region_id (FK) - 地区
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

**meeting_schedules テーブル** (定例会管理)
- id (PK)
- title - 会議名
- meeting_date - 開催日時
- department_id (FK) - 主催部門
- attendees (JSON) - 参加者リスト
- agenda (TEXT) - 議題
- status (enum: scheduled, completed, cancelled)
- created_by (FK)
- created_at, updated_at

**facility_utilization テーブル** (施設稼働状況)
- id (PK)
- facility_id (FK)
- year_month - 対象年月（YYYY-MM形式）
- capacity - 定員
- actual_users - 実利用者数
- utilization_rate - 稼働率（自動計算）
- notes - 備考
- created_by (FK)
- created_at, updated_at

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
            'name' => $this->faker->company . '事業所',
            'prefecture' => $this->faker->prefecture,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->numerify('#######'),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'opening_date' => $this->faker->date(),
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
### 8. 
定例会・会議管理システム

#### MeetingSchedule Model
```php
class MeetingSchedule extends Model
{
    protected $fillable = [
        'title', 'meeting_date', 'department_id', 'attendees',
        'agenda', 'status', 'created_by'
    ];
    
    protected $casts = [
        'attendees' => 'array',
        'meeting_date' => 'datetime'
    ];
}
```

### 9. 施設稼働状況管理システム

#### FacilityUtilization Model
```php
class FacilityUtilization extends Model
{
    protected $fillable = [
        'facility_id', 'year_month', 'capacity', 'actual_users',
        'utilization_rate', 'notes', 'created_by'
    ];
    
    // 稼働率自動計算
    public function calculateUtilizationRate()
    {
        if ($this->capacity > 0) {
            $this->utilization_rate = ($this->actual_users / $this->capacity) * 100;
        }
    }
}
```

### 10. 契約期限アラートシステム

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

## 定例会サポート機能設計

### 会議用レポート生成

```php
class MeetingReportService
{
    public function generateMeetingReport($departmentId, $reportType)
    {
        $facilities = Facility::where('department_id', $departmentId)
            ->with(['utilization', 'contractAlerts', 'maintenanceHistories'])
            ->get();
            
        return [
            'facilities_summary' => $this->getFacilitiesSummary($facilities),
            'utilization_report' => $this->getUtilizationReport($facilities),
            'contract_alerts' => $this->getContractAlerts($facilities),
            'maintenance_summary' => $this->getMaintenanceSummary($facilities)
        ];
    }
}
```

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