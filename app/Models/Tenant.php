<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = "tenants";

    protected $fillable = [
        'code',
        'name',
        'host_id',
        'status',
        'is_deleted',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id', 'id');
    }
}
