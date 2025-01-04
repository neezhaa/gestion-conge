<?php

namespace App\Http\Controllers;

use App\Models\DemandeConge;
use Illuminate\Http\Request;

class DemandeCongeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes_conges = DemandeConge::all();
        return response()->json($demandes_conges);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // $demandeConge = DemandeConge::create($data);
        $demandeConge = $request->employe()->demandes_conges()->create($data);
        return response()->json([
            'message' => 'Demande de congé crée avec succès.',
            'demande_conge' => $demandeConge
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $demandeConge = DemandeConge::findOrFail($id);
        return response()->json($demandeConge);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $demandeConge = DemandeConge::findOrFail($id);
        $demandeConge->update($data);
        return response()->json($demandeConge);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $demandeConge = DemandeConge::findOrFail($id);
        $demandeConge->delete();
        return response()->json(data: ['message' => 'Leave request deleted successfully!']);
    }
}
