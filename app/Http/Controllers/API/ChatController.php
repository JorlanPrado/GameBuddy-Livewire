<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Validator;


class ChatController extends Controller
{


    public function index($conversationId)
    {
        $userId = auth()->id();
        $messages = Message::where('conversation_id', $conversationId)
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)->whereNull('sender_deleted_at');
            })->orWhere(function ($query) use ($userId) {
                $query->where('receiver_id', $userId)->whereNull('receiver_deleted_at');
            })->get();

        return response()->json(['messages' => $messages], 200);
    }

    public function store(Request $request, $conversationId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id, // Assuming receiver_id is provided in the request
            'body' => $request->body
        ]);

        // Send notifications or perform other actions as needed

        return response()->json(['message' => $message], 201);
    }


    public function deleteConversation($conversationId)
{
    $userId = auth()->id();
    $conversation = Conversation::find($conversationId);

    // Check if the conversation exists
    if (!$conversation) {
        return response()->json(['message' => 'Conversation not found'], 404);
    }

    // Check if the authenticated user is part of the conversation
    if ($conversation->sender_id !== $userId && $conversation->receiver_id !== $userId) {
        return response()->json(['message' => 'You are not authorized to delete this conversation'], 403);
    }

    // Update messages deletion status
    $conversation->messages()->each(function ($message) use ($userId) {
        if ($message->sender_id === $userId) {
            $message->update(['sender_deleted_at' => now()]);
        } elseif ($message->receiver_id === $userId) {
            $message->update(['receiver_deleted_at' => now()]);
        }
    });

    // Check if both sender and receiver have deleted messages
    $receiverAlsoDeleted = $conversation->messages()
        ->where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })->where(function ($query) use ($userId) {
            $query->whereNull('sender_deleted_at')
                ->orWhereNull('receiver_deleted_at');
        })->doesntExist();

    // If both sender and receiver deleted messages, delete the conversation
    if ($receiverAlsoDeleted) {
        $conversation->forceDelete();
    }

    return response()->json(['message' => 'Conversation deleted successfully']);
}

    public function getConversation($conversationId)
    {
        $authenticatedUserId = auth()->id();
      
        // Check if the authenticated user exists
        if (!$authenticatedUserId) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Retrieve conversation details
        $conversation = Conversation::findOrFail($conversationId);
        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        // Check if the authenticated user is a participant in the conversation
        if ($authenticatedUserId != $conversation->sender_id && $authenticatedUserId != $conversation->receiver_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark messages belonging to the receiver as read
        Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', $authenticatedUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['conversation' => $conversation], 200);
    }

    public function sendMessage(Request $request, $userId)
    {
        $authenticatedUserId = auth()->id();
      
        // Check if the authenticated user exists
        if (!$authenticatedUserId) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Check if the target user exists
        $targetUser = User::find($userId);
        if (!$targetUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if conversation already exists
        $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('sender_id', $authenticatedUserId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $authenticatedUserId);
        })->first();
        
        if ($existingConversation) {
            // Conversation already exists, return conversation details
            return response()->json(['conversation_id' => $existingConversation->id], 200);
        }
  
        // Create new conversation
        $createdConversation = Conversation::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $userId,
        ]);

        return response()->json(['conversation_id' => $createdConversation->id], 201);
    }


    public function register(Request $request)
    {
        $rules = array(
            "name" => "required|min:5|max:15",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|max:20"
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $result = $user->save();

            if ($result) {
                return response()->json(["Result" => "New user has been registered"], 201);
            } else {
                return response()->json(["Result" => "Failed to register user"], 500);
            }
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;
    
            return response()->json(['user' => $user, 'token' => $token], 200);
        }
    
        return response()->json(['message' => 'Unauthorized'], 401);
    }

}
