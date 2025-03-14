<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = Employe::all();
        return response()->json($employes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'password' => 'required|string',
            'poste' => 'required|string',
            'solde_conge' => 'required|integer|max:18',
            'date_embauche' => 'required|date',
            'is_admin' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $employe = Employe::create($validated);

        return response()->json($employe);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employe = Employe::findOrFail($id);
        return response()->json($employe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nom_complet' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:employes,email',
            'password' => 'sometimes|required|string',
            'poste' => 'sometimes|required|string',
            'solde_conge' => 'sometimes|required|integer|max:18',
            'date_embauche' => 'sometimes|required|date',
            'is_admin' => 'sometimes|required|boolean',
        ]);

        // $validated['password'] = Hash::make($validated['password']);

        $employe = Employe::findOrFail($id);
        $employe->update($validated);
        return response()->json($employe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employe = Employe::findOrFail($id);
        $employe->delete();
        return response()->json(['message' => 'Employee deleted successfully!']);
    }
}
