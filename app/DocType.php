<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    protected $table = 'doc_types';

    protected $fillable = ['type'];

    public function docs() {
        return $this->hasMany(Document::class, 'doc_type')->orderBy('effective_date')->whereHas('customer');
    }
}
