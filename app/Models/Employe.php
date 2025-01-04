<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class Employe extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'password',
        'poste',
        'solde_conge',
        'date_embauche',
        'is_admin'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function demandes_conges() {
        return $this->hasMany(DemandeConge::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

    // public function fullName()
    // {
    //     return "{$this->prenom} {$this->nom}";
    // }
}
