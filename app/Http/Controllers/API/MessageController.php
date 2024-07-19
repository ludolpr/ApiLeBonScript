<?php

namespace App\Http\Controllers\API;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return response()->json($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Message $messages)
    {
        $request->validate([
            'message' => 'required|max:50',
        ]);

        $messages = Message::create([
            'message' => $request->messages
        ]);

        // JSON response
        return response()->json([
            'status' => 'Success',
            'data' => $messages,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return response()->json($message);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        // ---------------------------------------------
        $request->validate([
            "Message" => "required|max:50",
        ]);

        $message->update($request->all());

        return response()->json([
            "status" => "Mise à jour avec succèss",
            "data" => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        // Delete the Message
        $message->delete();
        // Return the response in JSON
        return response()->json([
            'status' => 'Delete OK',
        ]);
    }
}
