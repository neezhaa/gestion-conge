<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demande_conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->integer('nbr_jours_demandes');
            $table->enum('motif_conge', [
                'vacances',
                'maladie',
                'congé maternité',
                'congé paternité',
                'congé évènement familial',
                'congé naissance enfant',
                'congé formation',
                'congé personnel',
                'congé voyage affaires',
                'congé fin année',
                'congé déménagement',
                'congé marriage',
                'congé adoption',
                'congé études',
                'congé sans solde',
                'congé deuil',
                'congé solidarité familiale',
                'congé religieux',

            ])->default('vacances');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['en attente', 'accepté', 'refusé'])->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_conges');
    }
};
