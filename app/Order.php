<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id', 'created_by', 'asset_id', 'price', 'tax', 'service_charges', 'order_date', 'order_for'];

    public function customer() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function asset() {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function custody() {
        return $this->hasOne(Custody::class, 'order_id', 'id');
    }
}
