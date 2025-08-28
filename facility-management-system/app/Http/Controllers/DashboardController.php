<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Approval;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with role-based statistics.
     */
    public function index(Request $request)
    {
        $user = $this->getCurrentUser($request);
        
        if (!$user) {
            return redirect('/')->with('error', 'ログインが必要です');
        }

        // Get role-based statistics
        $statistics = $this->getStatistics($user);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($user);
        
        // Get contract alerts
        $contractAlerts = $this->getContractAlerts($user);
        
        // Get pending comments for primary responders
        $pendingComments = $this->getPendingComments($user);
        
        // Get pending approvals for approvers
        $pendingApprovals = $this->getPendingApprovals($user);

        return view('dashboard', compact(
            'user',
            'statistics', 
            'recentActivities',
            'contractAlerts',
            'pendingComments',
            'pendingApprovals'
        ));
    }

    /**
     * Get current user from session (demo implementation).
     */
    private function getCurrentUser(Request $request)
    {
        $sessionUser = session('user');
        if (!$sessionUser) {
            return null;
        }

        // Create a mock user object with role information
        return (object) [
            'name' => $sessionUser['name'],
            'role' => $sessionUser['role'],
            'role_display' => $sessionUser['role_display'],
            'logged_in_at' => $sessionUser['logged_in_at'],
            'department_id' => 1, // Mock department ID
            'region_id' => 1,     // Mock region ID  
            'facility_id' => 1    // Mock facility ID
        ];
    }

    /**
     * Get statistics based on user role.
     */
    private function getStatistics($user)
    {
        $stats = [
            'total_facilities' => 0,
            'pending_approvals' => 0,
            'expiring_contracts' => 0,
            'unread_comments' => 0
        ];

        // For demo purposes, return mock data based on role
        // In real implementation, these would be actual database queries
        switch ($user->role) {
            case 'system_admin':
            case 'editor':
            case 'approver':
            case 'viewer_executive':
                $stats = [
                    'total_facilities' => 245,
                    'pending_approvals' => 5,
                    'expiring_contracts' => 3,
                    'unread_comments' => 12
                ];
                break;
                
            case 'viewer_department':
                $stats = [
                    'total_facilities' => 45,
                    'pending_approvals' => 2,
                    'expiring_contracts' => 1,
                    'unread_comments' => 3
                ];
                break;
                
            case 'viewer_regional':
                $stats = [
                    'total_facilities' => 15,
                    'pending_approvals' => 1,
                    'expiring_contracts' => 0,
                    'unread_comments' => 1
                ];
                break;
                
            case 'viewer_facility':
                $stats = [
                    'total_facilities' => 1,
                    'pending_approvals' => 0,
                    'expiring_contracts' => 0,
                    'unread_comments' => 0
                ];
                break;
        }

        return $stats;
    }

    /**
     * Get recent activities based on user role.
     */
    private function getRecentActivities($user)
    {
        // Mock recent activities data
        $activities = [
            [
                'title' => '施設情報が更新されました',
                'description' => '東京第一事業所 - 住所情報の変更',
                'time' => '2時間前',
                'type' => 'update'
            ],
            [
                'title' => '承認が完了しました',
                'description' => '大阪支店 - 契約情報の承認',
                'time' => '4時間前',
                'type' => 'approval'
            ],
            [
                'title' => '新しいコメントが投稿されました',
                'description' => '名古屋営業所 - 修繕に関する質問',
                'time' => '6時間前',
                'type' => 'comment'
            ]
        ];

        // Filter activities based on user role
        switch ($user->role) {
            case 'viewer_facility':
                // Only show activities for their facility
                $activities = array_slice($activities, 0, 1);
                break;
            case 'viewer_regional':
                // Show activities for their region
                $activities = array_slice($activities, 0, 2);
                break;
        }

        return $activities;
    }

    /**
     * Get contract alerts based on user role.
     */
    private function getContractAlerts($user)
    {
        // Mock contract alerts data
        $alerts = [
            [
                'facility_name' => '横浜事業所',
                'contract_type' => '賃貸借契約',
                'expiry_date' => '2024/03/31',
                'alert_level' => 'warning'
            ],
            [
                'facility_name' => '福岡支店',
                'contract_type' => '火災保険',
                'expiry_date' => '2024/02/15',
                'alert_level' => 'danger'
            ],
            [
                'facility_name' => '仙台営業所',
                'contract_type' => '地震保険',
                'expiry_date' => '2024/04/10',
                'alert_level' => 'warning'
            ]
        ];

        // Filter alerts based on user role
        switch ($user->role) {
            case 'viewer_facility':
                // Only show alerts for their facility
                $alerts = array_slice($alerts, 0, 1);
                break;
            case 'viewer_regional':
                // Show alerts for their region
                $alerts = array_slice($alerts, 0, 2);
                break;
        }

        return $alerts;
    }

    /**
     * Get pending comments for primary responders.
     */
    private function getPendingComments($user)
    {
        if (!in_array($user->role, ['editor', 'primary_responder', 'system_admin'])) {
            return [];
        }

        // Mock pending comments data
        return [
            [
                'facility_name' => '東京第一事業所',
                'content' => '修繕に関する質問があります',
                'posted_by' => '田中太郎',
                'posted_at' => '1時間前'
            ],
            [
                'facility_name' => '大阪支店',
                'content' => '契約内容の確認をお願いします',
                'posted_by' => '佐藤花子',
                'posted_at' => '3時間前'
            ]
        ];
    }

    /**
     * Get pending approvals for approvers.
     */
    private function getPendingApprovals($user)
    {
        if (!in_array($user->role, ['approver', 'system_admin'])) {
            return [];
        }

        // Mock pending approvals data
        return [
            [
                'facility_name' => '名古屋営業所',
                'type' => '施設情報更新',
                'requested_by' => '山田次郎',
                'requested_at' => '30分前',
                'status' => 'pending'
            ],
            [
                'facility_name' => '福岡支店',
                'type' => '契約情報変更',
                'requested_by' => '鈴木一郎',
                'requested_at' => '2時間前',
                'status' => 'pending'
            ]
        ];
    }
}