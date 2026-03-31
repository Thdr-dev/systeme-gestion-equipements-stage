<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiel extends Model{

    use SoftDeletes;

    protected $table = 'materiels';

    protected $fillable = ['nom', 'description', 'image', 'status', 'date_maintenance', 'delai_maintenance', 'sous_famille_id', 'unite_id'];

    public function sousFamille(){
        return $this->belongsTo(SousFamille::class);
    }

    public function unite(){
        return $this->belongsTo(Unite::class);
    }

    public function mouvements(){
        return $this->hasMany(Mouvement::class)->latest();
    }
    protected $casts = [
        'date_maintenance' => 'date',
        'delai_maintenance' => 'date',
    ];
}