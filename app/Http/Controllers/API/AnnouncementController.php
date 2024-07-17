<?php

namespace App\Http\Controllers\API;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all announcements
        $announcements = Announcement::all();
        // Return the announcements information in JSON
        return response()->json($announcements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:400',
            'picture' => 'nullable|max:255',
            'id_category' => 'sometimes|integer|exists:categories,id',
            'id_user' => 'sometimes|integer|exists:users,id'
        ]);

        $announcement = Announcement::create(['title' => $request->title, 'description' => $request->description, 'picture' => $request->picture, 'id_user' => $request->id_user,
            'id_category' => $request->id_category,

        ]);

        // JSON response
        return response()->json([
            'status' => 'Success',
            'data' => $announcement,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        // Return the announcement information in JSON
        return response()->json($announcement, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:400',
            'picture' => 'nullable|max:255',
            'id_category' => 'sometimes|integer|exists:categories,id',
            'id_user' => 'sometimes|integer|exists:users,id'
        ]);

        // Update the announcement
        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'picture' => $request->picture,
            'id_user' => $request->id_user,
            'id_category' => $request->id_category,
        ]);

        // Return the updated information in JSON
        return response()->json([
            'status' => 'Update OK',
            'data' => $announcement,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        // Delete the announcement
        $announcement->delete();
        // Return the response in JSON
        return response()->json([
            'status' => 'Delete OK',
        ]);
    }
}