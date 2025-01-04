<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'employe_id',
        'type',
        'message',
        'demande_conge_id',
    ];

    public function demandes_conges() {
        return $this->manyToMany(DemandeConge::class);
    }

    public function employe() {
        return $this->belongsTo(Notification::class);
    }
}
