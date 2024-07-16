<?php

namespace App\Http\Controllers\API;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return response()->json($announcements, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:400',
            'picture' => 'nullable|max:255',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'picture' => $request->picture,
            'user_id' => $request->user()->id, // Assuming the user is authenticated
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
        ]);

        // Update the announcement
        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'picture' => $request->picture,
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
