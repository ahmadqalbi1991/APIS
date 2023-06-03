<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    public function assets() {
        return $this->hasMany(Asset::class, 'address_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
