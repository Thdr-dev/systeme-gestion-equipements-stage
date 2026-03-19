<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model{
    protected $fillable = ['nom', 'ville'];

    // Liste du matériel actuellement présent dans cette unité
    public function materiels(){
        return $this->hasMany(Materiel::class);
    }
}