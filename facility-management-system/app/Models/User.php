<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'department_id',
        'region_id',
        'facility_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the department that owns the user.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the region that owns the user.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the facility that owns the user (for facility users).
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    /**
     * The facilities that belong to the user (for regional users).
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'user_facilities');
    }

    /**
     * Check if user has specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user can access facility.
     */
    public function canAccessFacility($facilityId): bool
    {
        if (!$this->role) {
            return false;
        }

        return match($this->role->name) {
            'system_admin', 'editor', 'approver', 'viewer_executive' => true,
            'viewer_department' => $this->department_id && 
                Facility::where('id', $facilityId)->where('department_id', $this->department_id)->exists(),
            'viewer_regional' => $this->facilities()->where('facility_id', $facilityId)->exists(),
            'viewer_facility' => $this->facility_id == $facilityId,
            default => false,
        };
    }
}
