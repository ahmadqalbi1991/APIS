<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['name', 'rzr_id', 'email'];

    public function user () {
        return $this->hasOne(User::class, 'customer_id', 'id');
    }
}
