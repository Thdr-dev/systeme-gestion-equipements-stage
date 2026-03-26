<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model{
    protected $fillable = ['nom', 'type', 'description', 'ville', 'parent_id'];

    public function parent(){
        return $this->belongsTo(Unite::class, 'parent_id');
    }

    public function enfants(){
        return $this->hasMany(Unite::class, 'parent_id');
    }

    public function materiels(){
        return $this->hasMany(Materiel::class);
    }
}