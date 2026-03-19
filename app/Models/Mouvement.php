<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mouvement extends Model{
    protected $fillable = ['type', 'commentaire', 'materiel_id', 'user_id', 'from_unite_id', 'to_unite_id'];

    public function materiel(){
        return $this->belongsTo(Materiel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function fromUnite(){
        return $this->belongsTo(Unite::class, 'from_unite_id');
    }

    public function toUnite(){
        return $this->belongsTo(Unite::class, 'to_unite_id');
    }
}