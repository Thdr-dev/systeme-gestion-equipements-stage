<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousFamille extends Model{
    protected $fillable = ['nomSousFam', 'famille_id'];

    public function famille(){
        return $this->belongsTo(Famille::class);
    }

    public function materiels(){
        return $this->hasMany(Materiel::class);
    }
}