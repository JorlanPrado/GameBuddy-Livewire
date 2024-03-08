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
        $this->showUser = true;
        // Fetch a random user
        $this->randomUser = User::where('id', '!=', auth()->id())->inRandomOrder()->first();
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
        // If the "Start Matching" button is clicked, show the random user, otherwise show all users
        $users = $this->showUser ? collect([$this->randomUser]) : User::where('id', '!=', auth()->id())->get();
        
        return view('livewire.users', [
            'users' => User::where('id', '!=', auth()->id())->get()
        ]);
    }
}
