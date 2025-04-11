<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propositions extends Model
{
    public $timestamps = false;
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
