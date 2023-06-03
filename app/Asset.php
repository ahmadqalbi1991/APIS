<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';
    protected $fillable = [
        'server_rack',
        'server_rack_number',
        'manufacture',
        'model',
        'serial',
        'cpu_manufacture',
        'cpu_part_number',
        'cpu_qty',
        'memory_qty',
        'memory_capacity',
        'asset_tag',
        'hardware_manufacture',
        'hard_drive_qty',
        'hard_drive_capacity',
        'user_id',
        'address_id',
        'status',
        'weight',
        'company_id'
    ];

    public function orders() {
        return $this->hasMany(Order::class, 'asset_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Address() {
        return $this->belongsTo(UserAddress::class, 'address_id', 'id');
    }
}
