<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materiel extends Model{
    protected $table = 'materiels';

    protected $fillable = ['nom', 'image', 'status', 'date_maintenance', 'sous_famille_id', 'unite_id'];

    public function sousFamille(){
        return $this->belongsTo(SousFamille::class);
    }

    public function unite(){
        return $this->belongsTo(Unite::class);
    }

    public function mouvements(){
        return $this->hasMany(Mouvement::class)->latest();
    }
}