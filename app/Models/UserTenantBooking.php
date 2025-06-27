<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTenantBooking extends Model
{
    protected $table = "user_tenant_booking";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
