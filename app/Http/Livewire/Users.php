<?php

namespace App\Http\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{

    public $showUser = false; // Flag to indicate whether to show a user or not
    public $randomUser; // Flag to indicate whether to show a user or not

    public function startMatching()
    {
        // Get the interests of the authenticated user
        $currentUserInterests = auth()->user()->interests->pluck('id')->toArray();

        // Fetch a random user with at least one common interest
        $this->randomUser = User::where('id', '!=', auth()->id())
            ->where('isAdmin', false)
            ->whereHas('interests', function ($query) use ($currentUserInterests) {
                $query->whereIn('interest_id', $currentUserInterests);
            })
            ->inRandomOrder()
            ->first();

        $this->showUser = true;
    }

    public function message($userId)
    {

        //  $createdConversation =   Conversation::updateOrCreate(['sender_id' => auth()->id(), 'receiver_id' => $userId]);

        $authenticatedUserId = auth()->id();

        # Check if conversation already exists
        $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
            $query->where('sender_id', $authenticatedUserId)
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $authenticatedUserId);
            })->first();

        if ($existingConversation) {
            # Conversation already exists, redirect to existing conversation
            return redirect()->route('chat', ['query' => $existingConversation->id]);
        }

        # Create new conversation
        $createdConversation = Conversation::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $userId,
        ]);

        return redirect()->route('chat', ['query' => $createdConversation->id]);
    }


    public function render()
    {
        // Retrieve all non-admin users
        $users = User::where('id', '!=', auth()->id())->where('isAdmin', false)->get();

        // If the "Start Matching" button is clicked, show the random user, otherwise show all users
        // $users = $this->showUser ? collect([$this->randomUser]) : $users;

        return view('livewire.users', [
            'users' => $users
        ]);
    }
}
