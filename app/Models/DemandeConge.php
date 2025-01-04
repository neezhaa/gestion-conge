<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeConge extends Model
{
    protected $fillable = [
        'employe_id',
        'nbr_jours_demandes',
        'motif_conge',
        'date_debut',
        'date_fin',
        'statut',
    ];

    public function employe() {
        return $this->belongsTo(Employe::class);
    }

    public function notifications() {
        return $this->manyToMany(Employe::class);
    }
}
