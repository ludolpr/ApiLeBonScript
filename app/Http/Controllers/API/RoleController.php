<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Role $roles)
    {
        $request->validate([
            'role' => 'required|max:50',
        ]);

        $roles = Role::create([
            'role' => $request->role
        ]);

        // JSON response
        return response()->json([
            'status' => 'Success',
            'data' => $roles,
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json($role);
    }

   
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // ---------------------------------------------
        $request->validate(["role" => "required|max:50",
        ]);

        $role->update($request->all());
        // dd($request);

        return response()->json(["status" => "Mise à jour avec succèss",
            "data" => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Delete the role
        $role->delete();
        // Return the response in JSON
        return response()->json([
            'status' => 'Delete OK',
        ]);
    }
}