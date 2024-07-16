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
        // Retrieve all roles
        $roles = Role::all();
        // Return the role information in JSON
        return response()->json($roles, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|max:50|unique:roles,role',
        ]);

        $role = Role::create([
            'role' => $request->role,
        ]);

        // JSON response
        return response()->json([
            'status' => 'Success',
            'data' => $role,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // Return the role information in JSON
        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role' => 'required|max:50|unique:roles,role,' . $role->id,
        ]);

        // Update the role
        $role->update([
            'role' => $request->role,
        ]);

        // Return the updated information in JSON
        return response()->json([
            'status' => 'Update OK',
            'data' => $role,
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
