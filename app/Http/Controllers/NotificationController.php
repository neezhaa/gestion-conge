<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Récupérer l'ID de l'employé connecté
        $employeId = Auth::id();

        // Filtrer les notifications pour l'employé connecté
        $notifications = Notification::all();

        return response()->json($notifications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'message' => 'required|string',
            'type' => 'required|string',
            'demande_conge_id' => 'nullable|exists:demande_conges,id',
        ]);

        // Ajouter l'ID de l'employé connecté
        $data = $request->all();
        // $data['employe_id'] = Auth::id();

        // Créer la notification
        $notification = Notification::create($data);

        return response()->json($notification, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        // Récupérer l'ID de l'employé connecté
        $employeId = Auth::id();

        // Récupérer la notification uniquement si elle appartient à l'employé connecté
        $notification = Notification::where('id', $id)
            ->where('employe_id', $employeId)
            ->firstOrFail();

        return response()->json($notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        // Récupérer l'ID de l'employé connecté
        $employeId = Auth::id();

        // Récupérer la notification uniquement si elle appartient à l'employé connecté
        $notification = Notification::where('id', $id)
            ->where('employe_id', $employeId)
            ->firstOrFail();

        // Valider les données de la requête
        $request->validate([
            'message' => 'sometimes|string',
            'type' => 'sometimes|string',
            'demande_conge_id' => 'nullable|exists:demande_conges,id',
        ]);

        // Mettre à jour la notification
        $notification->update($request->all());

        return response()->json($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        // Récupérer l'ID de l'employé connecté
        $employeId = Auth::id();

        // Récupérer la notification uniquement si elle appartient à l'employé connecté
        $notification = Notification::where('id', $id)
            ->where('employe_id', $employeId)
            ->firstOrFail();

        // Supprimer la notification
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully!']);
    }
}