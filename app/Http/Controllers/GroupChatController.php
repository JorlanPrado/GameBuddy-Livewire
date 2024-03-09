<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupChat; // Import the GroupChat model with the correct namespace

class GroupChatController extends Controller
{
    public function index()
    {
        $groupChats = GroupChat::all();
        return response()->json($groupChats, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $groupChat = GroupChat::create($request->all());
        return response()->json($groupChat, 201);
    }

    public function getLobbyChats()
{
    // Retrieve the group chats for lobbies
    // This could involve querying your database or any other data source
    $lobbyChats = GroupChat::where('lobby', true)->get();

    // Return the retrieved data as JSON response
    return response()->json($lobbyChats);
}
}
