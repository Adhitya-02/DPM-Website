<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    protected $table = "user";
    protected $guarded = [];
    public $timestamps = false;

    /**
     * Get the tenant associated with the user through UserTenant pivot table
     */
    public function tenant()
    {
        return $this->hasOneThrough(Tenant::class, UserTenant::class, 'user_id', 'id', 'id', 'tenant_id');
    }

    /**
     * Get the UserTenant relationship (pivot table)
     */
    public function userTenant()
    {
        return $this->hasOne(UserTenant::class, 'user_id', 'id');
    }

    /**
     * Get multiple UserTenant relationships if user can have multiple tenants
     */
    public function userTenants()
    {
        return $this->hasMany(UserTenant::class, 'user_id', 'id');
    }

    /**
     * Get the user type (tipe user)
     */
    public function tipeuser()
    {
        return $this->belongsTo(TipeUser::class, 'tipe_user_id', 'id');
    }

    /**
     * Get all bookings made by this user
     */
    public function bookings()
    {
        return $this->hasMany(UserTenantBooking::class, 'user_id', 'id');
    }

    /**
     * Get all ratings given by this user
     */
    public function ratings()
    {
        return $this->hasMany(UserTenantRating::class, 'user_id', 'id');
    }

    /**
     * Get all reviews written by this user
     */
    public function ulasan()
    {
        return $this->hasMany(UlasanTenant::class, 'user_id', 'id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->tipe_user_id == 1;
    }

    /**
     * Check if user is tenant manager
     */
    public function isTenantManager()
    {
        return $this->tipe_user_id == 2;
    }

    /**
     * Check if user is regular user/customer
     */
    public function isCustomer()
    {
        return $this->tipe_user_id == 3;
    }

    /**
     * Get user's full name or email if name not available
     */
    public function getDisplayNameAttribute()
    {
        return $this->nama ?? $this->email ?? 'User';
    }

    /**
     * Get user type name
     */
    public function getUserTypeNameAttribute()
    {
        $types = [
            1 => 'Admin',
            2 => 'Pengelola Tenant',
            3 => 'Pengguna'
        ];
        
        return $types[$this->tipe_user_id] ?? 'Unknown';
    }

    /**
     * Scope to get users by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipe_user_id', $type);
    }

    /**
     * Scope to get admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('tipe_user_id', 1);
    }

    /**
     * Scope to get tenant managers
     */
    public function scopeTenantManagers($query)
    {
        return $query->where('tipe_user_id', 2);
    }

    /**
     * Scope to get customers
     */
    public function scopeCustomers($query)
    {
        return $query->where('tipe_user_id', 3);
    }
}