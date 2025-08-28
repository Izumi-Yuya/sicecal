<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    // Role constants based on requirements
    const SYSTEM_ADMIN = 1;
    const EDITOR = 2;
    const APPROVER = 3;
    const VIEWER_EXECUTIVE = 4;
    const VIEWER_DEPARTMENT = 5;
    const VIEWER_REGIONAL = 6;
    const VIEWER_FACILITY = 7;
    const PRIMARY_RESPONDER = 8;

    /**
     * Get the users for the role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get role display names mapping
     */
    public static function getDisplayNames(): array
    {
        return [
            'system_admin' => 'システム管理者',
            'editor' => '編集者',
            'approver' => '承認者',
            'viewer_executive' => '閲覧者（役員・本社）',
            'viewer_department' => '閲覧者（部門責任者）',
            'viewer_regional' => '閲覧者（地区担当）',
            'viewer_facility' => '閲覧者（事業所）',
            'primary_responder' => '一次対応者'
        ];
    }
}