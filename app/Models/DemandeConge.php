<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeConge extends Model
{
    // Champs remplissables (mass assignable)
    protected $fillable = [
        'employe_id',
        'nbr_jours_demandes',
        'motif_conge',
        'date_debut',
        'date_fin',
        'statut',
    ];

    // Relation avec l'employé
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    // Relation avec les notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}