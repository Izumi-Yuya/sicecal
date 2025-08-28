<?php

namespace App\Services;

/**
 * ロールベースアクセス制御サービス
 * 
 * 施設管理システムの7つのロールに基づいたアクセス制御を管理
 */
class RoleService
{
    /**
     * システムで定義されているロール一覧
     */
    const ROLES = [
        'system_admin' => [
            'name' => 'システム管理者',
            'description' => '全施設と管理機能へのフルアクセス',
            'level' => 1,
            'permissions' => [
                'view_all_facilities',
                'edit_all_facilities',
                'approve_changes',
                'manage_users',
                'system_settings',
                'export_data',
                'delete_facilities'
            ]
        ],
        'editor' => [
            'name' => '編集者',
            'description' => '全施設情報の編集権限',
            'level' => 2,
            'permissions' => [
                'view_all_facilities',
                'edit_all_facilities',
                'export_data'
            ]
        ],
        'approver' => [
            'name' => '承認者',
            'description' => '全施設の変更承認権限',
            'level' => 3,
            'permissions' => [
                'view_all_facilities',
                'approve_changes',
                'export_data'
            ]
        ],
        'viewer_executive' => [
            'name' => '閲覧者（役員・本社）',
            'description' => 'CSV/PDF出力付きで全施設の閲覧',
            'level' => 4,
            'permissions' => [
                'view_all_facilities',
                'export_data'
            ]
        ],
        'viewer_department' => [
            'name' => '閲覧者（部門責任者）',
            'description' => 'CSV/PDF出力付きで部門施設のみの閲覧',
            'level' => 5,
            'permissions' => [
                'view_department_facilities',
                'export_data'
            ]
        ],
        'viewer_district' => [
            'name' => '閲覧者（地区担当）',
            'description' => 'CSV/PDF出力付きで割り当てられた地区施設のみの閲覧',
            'level' => 6,
            'permissions' => [
                'view_district_facilities',
                'export_data'
            ]
        ],
        'viewer_facility' => [
            'name' => '閲覧者（事業所）',
            'description' => '自施設情報のみの閲覧',
            'level' => 7,
            'permissions' => [
                'view_own_facility'
            ]
        ]
    ];

    /**
     * ユーザーのロール情報を取得
     */
    public static function getUserRole($roleKey)
    {
        return self::ROLES[$roleKey] ?? null;
    }

    /**
     * ユーザーが特定の権限を持っているかチェック
     */
    public static function hasPermission($userRole, $permission)
    {
        $role = self::getUserRole($userRole);
        return $role && in_array($permission, $role['permissions']);
    }

    /**
     * ユーザーがアクセス可能な施設の範囲を取得
     */
    public static function getAccessibleFacilities($userRole, $userDepartment = null, $userDistrict = null, $userFacilityId = null)
    {
        switch ($userRole) {
            case 'system_admin':
            case 'editor':
            case 'approver':
            case 'viewer_executive':
                return 'all'; // 全施設
                
            case 'viewer_department':
                return ['type' => 'department', 'value' => $userDepartment];
                
            case 'viewer_district':
                return ['type' => 'district', 'value' => $userDistrict];
                
            case 'viewer_facility':
                return ['type' => 'facility', 'value' => $userFacilityId];
                
            default:
                return 'none';
        }
    }

    /**
     * ロール一覧を取得（ログイン画面用）
     */
    public static function getLoginRoles()
    {
        $loginRoles = [];
        foreach (self::ROLES as $key => $role) {
            $loginRoles[$key] = $role['name'];
        }
        return $loginRoles;
    }

    /**
     * ユーザーが編集権限を持っているかチェック
     */
    public static function canEdit($userRole)
    {
        return self::hasPermission($userRole, 'edit_all_facilities');
    }

    /**
     * ユーザーが承認権限を持っているかチェック
     */
    public static function canApprove($userRole)
    {
        return self::hasPermission($userRole, 'approve_changes');
    }

    /**
     * ユーザーがエクスポート権限を持っているかチェック
     */
    public static function canExport($userRole)
    {
        return self::hasPermission($userRole, 'export_data');
    }

    /**
     * ユーザーがシステム管理権限を持っているかチェック
     */
    public static function isSystemAdmin($userRole)
    {
        return $userRole === 'system_admin';
    }
}