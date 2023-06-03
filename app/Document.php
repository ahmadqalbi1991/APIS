<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = ['file', 'doc_description', 'effective_date', 'doc_number', 'doc_name', 'doc_type', 'customer_id'];

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
