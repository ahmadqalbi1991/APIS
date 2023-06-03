<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['company_name', 'email', 'code', 'number'];

    public function users() {
        return $this->hasMany(User::class, 'company_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'company_id')->where('role', 'management');
    }
}
