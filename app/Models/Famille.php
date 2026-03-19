<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model{
    protected $fillable = ['nomFam'];

    public function sousFamilles(){
        return $this->hasMany(SousFamille::class);
    }

}