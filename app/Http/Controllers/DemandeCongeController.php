<?php

namespace App\Http\Controllers;

use App\Models\DemandeConge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeCongeController extends Controller
{
    /**
     * Récupère toutes les demandes de congé de l'employé connecté.
     */
    public function index(Request $request)
    {
        // Récupérer l'ID de l'employé connecté
        $employeId = Auth::id();

        // Récupérer les demandes de congé de l'employé connecté
        $demandes = DemandeConge::where('employe_id', $employeId)->get();
        $demandes = DemandeConge::all();

        return response()->json([
            'message' => 'Demandes de congé récupérées avec succès',
            'data' => $demandes,
        ], 200);
    }

    /**
     * Crée une nouvelle demande de congé.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif_conge' => 'required|string|in:vacances,maladie,congé maternité,congé paternité,congé évènement familial,congé naissance enfant,congé formation,congé personnel,congé voyage affaires,congé fin année,congé déménagement,congé marriage,congé adoption,congé études,congé sans solde,congé deuil,congé solidarité familiale,congé religieux',
        ]);

        // Calcul du nombre de jours demandés
        $dateDebut = new \DateTime($request->date_debut);
        $dateFin = new \DateTime($request->date_fin);
        $nbrJoursDemandes = $dateDebut->diff($dateFin)->days + 1;

        // Création de la demande de congé
        $demandeConge = DemandeConge::create([
            'employe_id' => Auth::id(), // Utiliser l'ID de l'employé connecté
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'motif_conge' => $request->motif_conge,
            'nbr_jours_demandes' => $nbrJoursDemandes,
            'statut' => 'en attente',
        ]);

        return response()->json([
            'message' => 'Demande de congé créée avec succès',
            'data' => $demandeConge,
        ], 201);
    }

    /**
     * Affiche les détails d'une demande de congé spécifique.
     */
    public function show(DemandeConge $demandeConge)
    {
        // Vérifier que la demande appartient à l'employé connecté
        if ($demandeConge->employe_id !== Auth::id()) {
            return response()->json([
                'message' => 'Accès non autorisé',
            ], 403);
        }

        return response()->json([
            'message' => 'Détails de la demande de congé',
            'data' => $demandeConge,
        ], 200);
    }

    /**
     * Met à jour une demande de congé existante.
     */
    public function update(Request $request, DemandeConge $demandeConge)
    {
        // Vérifier que la demande appartient à l'employé connecté
        if ($demandeConge->employe_id !== Auth::id()) {
            return response()->json([
                'message' => 'Accès non autorisé',
            ], 403);
        }

        // Validation des données
        $request->validate([
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
            'motif_conge' => 'sometimes|string|in:vacances,maladie,congé maternité,congé paternité,congé évènement familial,congé naissance enfant,congé formation,congé personnel,congé voyage affaires,congé fin année,congé déménagement,congé marriage,congé adoption,congé études,congé sans solde,congé deuil,congé solidarité familiale,congé religieux',
        ]);

        // Mettre à jour la demande de congé
        $demandeConge->update($request->all());

        return response()->json([
            'message' => 'Demande de congé mise à jour avec succès',
            'data' => $demandeConge,
        ], 200);
    }

    /**
     * Supprime une demande de congé existante.
     */
    public function destroy($id)
    {

        $demandeConge = DemandeConge::find($id);

        // Vérifier que la demande appartient à l'employé connecté
        // if ($demandeConge->employe_id !== Auth::id()) {
        //     return response()->json([
        //         'message' => 'Accès non autorisé',
        //         "data" => $demandeConge
        //     ], 403);
        // }
        // Supprimer la demande de congé

        $demandeConge->delete();

        return response()->json([
            'message' => 'Demande de congé supprimée avec succès',
        ], 200);
    }
}