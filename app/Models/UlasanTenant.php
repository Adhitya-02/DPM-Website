<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanTenant extends Model
{
    protected $table = "ulasan_tenant";
    protected $guarded = [];
    public $timestamps = false;

     // Relasi ke model User
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id', 'id'); // 'user_id' adalah foreign key di tabel ulasan_tenant
     }
}
