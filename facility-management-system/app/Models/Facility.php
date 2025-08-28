<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;

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
        'department_id', 'region_id', 'status',
        
        // Legacy fields for backward compatibility
        'prefecture', 'city', 'business_type', 'construction_year', 'floor_area',
        'land_ownership', 'building_ownership', 'lease_start_date', 'lease_end_date', 
        'lease_monthly_rent', 'management_company', 'fire_insurance_company',
        'fire_insurance_start_date', 'fire_insurance_end_date', 'earthquake_insurance_company',
        'earthquake_insurance_start_date', 'earthquake_insurance_end_date'
    ];

    protected $casts = [
        'opening_date' => 'date',
        'designation_renewal_date' => 'date',
        'land_contract_start_date' => 'date', 
        'land_contract_end_date' => 'date',
        'building_contract_start_date' => 'date', 
        'building_contract_end_date' => 'date',
        'completion_date' => 'date', 
        'building_inspection_date' => 'date',
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
        'building_rent_monthly' => 'integer',
        // Legacy fields
        'lease_start_date' => 'date',
        'lease_end_date' => 'date',
        'fire_insurance_start_date' => 'date',
        'fire_insurance_end_date' => 'date',
        'earthquake_insurance_start_date' => 'date',
        'earthquake_insurance_end_date' => 'date'
    ];

    /**
     * Get the department that owns the facility.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the region that owns the facility.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the users for the facility.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get maintenance histories for the facility.
     */
    public function maintenanceHistories(): HasMany
    {
        return $this->hasMany(MaintenanceHistory::class);
    }

    /**
     * Get documents for the facility.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get approvals for the facility.
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    /**
     * Get comments for the facility.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get annual verifications for the facility.
     */
    public function annualVerifications(): HasMany
    {
        return $this->hasMany(AnnualVerification::class);
    }

    // 自動計算メソッド
    public function getOperatingYearsAttribute()
    {
        if (!$this->opening_date) return null;
        $diff = $this->opening_date->diff(now());
        return $diff->y . '年' . $diff->m . 'ヶ月';
    }
    
    public function getBuildingAgeAttribute() 
    {
        if (!$this->completion_date) return null;
        $diff = $this->completion_date->diff(now());
        return $diff->y . '年' . $diff->m . 'ヶ月';
    }
    
    public function getLandUnitPriceAttribute()
    {
        if (!$this->land_purchase_price || !$this->site_area_tsubo) return null;
        return number_format($this->land_purchase_price / $this->site_area_tsubo);
    }
    
    public function getBuildingUnitPriceAttribute()
    {
        if (!$this->building_main_price || !$this->floor_area_tsubo) return null;
        return number_format($this->building_main_price / $this->floor_area_tsubo);
    }

    public function getLandContractYearsAttribute()
    {
        if (!$this->land_contract_start_date || !$this->land_contract_end_date) return null;
        $diff = $this->land_contract_start_date->diff($this->land_contract_end_date);
        return $diff->y . '年' . $diff->m . 'ヶ月';
    }

    public function getBuildingContractYearsAttribute()
    {
        if (!$this->building_contract_start_date || !$this->building_contract_end_date) return null;
        $diff = $this->building_contract_start_date->diff($this->building_contract_end_date);
        return $diff->y . '年' . $diff->m . 'ヶ月';
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