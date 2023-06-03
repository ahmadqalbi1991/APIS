<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custody extends Model
{
    protected $table = 'custody';
    protected $fillable = [
        'current_custody',
        'status',
        'start_date',
        'receiving_party',
        'change_date',
        'initialized_by',
        'partner_to_send_to',
        'final_address',
        'final_location',
        'address_country',
        'address_state',
        'address_city',
        'location_country',
        'location_state',
        'location_city',
        'customer_id',
        'order_id',
        'asset_id'
    ];

    public function country1()
    {
        return $this->belongsTo(Country::class, 'address_country', 'id');
    }

    public function state1()
    {
        return $this->belongsTo(State::class, 'address_state', 'id');
    }

    public function city1()
    {
        return $this->belongsTo(City::class, 'address_city', 'id');
    }

    public function country2()
    {
        return $this->belongsTo(Country::class, 'location_country', 'id');
    }

    public function state2()
    {
        return $this->belongsTo(State::class, 'location_state', 'id');
    }

    public function city2()
    {
        return $this->belongsTo(City::class, 'location_city', 'id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function asset() {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }
}
