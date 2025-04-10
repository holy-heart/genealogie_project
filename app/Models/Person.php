<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 

class Person extends Model
{
    protected $fillable = [
        'created_by', 'first_name', 'last_name', 'birth_name', 'middle_names', 'date_of_birth',
    ];

    public function children()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'parent_id', 'child_id');
    }

    public function parents()
    {
        return $this->belongsToMany(Person::class, 'relationships', 'child_id', 'parent_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parentlink($target, $recu = 0, &$visited = null, &$path = null, $allRelations = null)
    {
        // Initialisation au premier appel
        if ($visited === null) {
            $visited = [$this->id => true];
            $path = [$this->id];
            
            // Précharge toutes les relations en une seule requête
            $allRelations = DB::table('relationships')
                ->whereIn('child_id', function($query) {
                    $query->select('id')->from('people');
                })
                ->orWhereIn('parent_id', function($query) {
                    $query->select('id')->from('people');
                })
                ->get()
                ->groupBy(function($item) {
                    return $item->child_id;
                });
        }
    
        // Protection contre la récursion infinie
        if ($recu > 25) {
            return false;
        }
    
        // Si la cible est trouvée
        if (end($path) == $target) {
            return [
                'degree' => $recu,
                'path' => $path
            ];
        }
    
        $currentId = end($path);
    
        // Récupère les relations depuis le cache
        $relations = $allRelations->get($currentId, collect())
            ->merge($allRelations->flatten(1)->where('parent_id', $currentId));
    
        foreach ($relations as $relation) {
            $linkId = ($relation->child_id == $currentId) ? $relation->parent_id : $relation->child_id;
            
            if (!isset($visited[$linkId])) {
                $visited[$linkId] = true;
                $path[] = $linkId;
    
                $result = $this->parentlink($target, $recu + 1, $visited, $path, $allRelations);
    
                if ($result !== false) {
                    return $result;
                }
    
                // Backtrack
                array_pop($path);
            }
        }
    
        return false;
    }




}

