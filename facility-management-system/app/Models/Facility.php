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
        'facility_code',
        'name',
        'prefecture',
        'city',
        'postal_code',
        'address',
        'phone_number',
        'fax_number',
        'opening_date',
        'business_type',
        'capacity',
        'floor_area',
        'building_structure',
        'construction_year',
        'land_ownership',
        'building_ownership',
        'lease_start_date',
        'lease_end_date',
        'lease_monthly_rent',
        'management_company',
        'fire_insurance_company',
        'fire_insurance_start_date',
        'fire_insurance_end_date',
        'earthquake_insurance_company',
        'earthquake_insurance_start_date',
        'earthquake_insurance_end_date',
        'department_id',
        'region_id',
        'status'
    ];

    protected $dates = [
        'opening_date',
        'lease_start_date',
        'lease_end_date',
        'fire_insurance_start_date',
        'fire_insurance_end_date',
        'earthquake_insurance_start_date',
        'earthquake_insurance_end_date'
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
}