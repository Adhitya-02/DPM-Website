<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTenant extends Model
{
    protected $table = "user_tenant";
    protected $guarded = [];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
