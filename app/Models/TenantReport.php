<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantReport extends Model
{
    protected $table = "tenant_report";
    protected $guarded = [];
    public $timestamps = false;
}
