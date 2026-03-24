<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model{
    protected $fillable = ['nom', 'description', 'ville'];

    public function materiels(){
        return $this->hasMany(Materiel::class);
    }
}