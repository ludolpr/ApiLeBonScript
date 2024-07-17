<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'picture' => 'nullable|max:50',
            'zipcode' => 'required|numeric|digits:5',
            'address' => 'required|max:150',
            'town' => 'required|max:100',
            'coords' => 'required|max:150',
            'id_role' => 'sometimes|integer|exists:roles,id',
        ]);

        // valeur par defaut
        $roleId = $request->id_role ?? 1;

        // Create user
        $user = User::create([
            'name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'picture' => $request->picture, 'zipcode' => $request->zipcode, 'address' => $request->address, 'town' => $request->town, 'coords' => $request->coords, 'id_role' => $roleId, 
        ]);

        // JSON response
        return response()->json([
            'status' => 'Success',
            'data' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Return the user information in JSON
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate(['name' => 'required|max:100', 'email' => 'required',
            'password' => 'required|min:8',
            'picture' => 'nullable|max:50',
            'zipcode' => 'required|numeric|digits:5',
            'address' => 'required|max:150',
            'town' => 'required|max:100',
            'coords' => 'required|max:150',
            'id_role' => 'sometimes|integer|exists:roles,id',
        ]);

        // valeur par defaut
        $roleId = $request->id_role ?? 1;

        // Update the user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'picture' => $request->picture,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'town' => $request->town,
            'coords' => $request->coords,
            'id_role' => $roleId,
        ]);

        // Return the updated information in JSON
        return response()->json([
            'status' => 'Update OK',
            'data' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();
        // Return the response in JSON
        return response()->json([
            'status' => 'Delete OK',
        ]);
    }
}