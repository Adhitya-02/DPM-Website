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
    public function tenant()
    {
        return $this->hasOneThrough(Tenant::class, UserTenant::class, 'user_id', 'id', 'id', 'tenant_id');
    }
    public function tipeuser()
    {
        return $this->belongsTo(TipeUser::class, 'tipe_user_id');
    }
}
