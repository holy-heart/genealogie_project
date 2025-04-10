<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $table = 'relationships';

    // Relation avec la personne parent
    public function parent()
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }

    // Relation avec la personne enfant
    public function child()
    {
        return $this->belongsTo(Person::class, 'child_id');
    }

    // Relation avec l'utilisateur-créateur
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
