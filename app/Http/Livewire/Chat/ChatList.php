<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;
    public $conversations;
    public $type = 'all';

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->conversations = collect();
    }

    public function render()
    {
        if ($this->type === 'lobbies') {
            $this->conversations = $this->conversations->filter(function ($conversation) {
                return $conversation->getReceiver->type === 'group';
            });
        }

        $user = auth()->user();
        $conversations = $user ? $user->conversations()->latest('updated_at')->get() : collect([]);
        $this->conversations = $conversations;
        return view('livewire.chat.chat-list', [
            'conversations' => $this->conversations
        ]);
    }

    public function deleteByUser($id)
    {

        $userId = auth()->id();
        $conversation = Conversation::find(decrypt($id));


        $conversation->messages()->each(function ($message) use ($userId) {

            if ($message->sender_id === $userId) {

                $message->update(['sender_deleted_at' => now()]);

            } elseif ($message->receiver_id === $userId) {

                $message->update(['receiver_deleted_at' => now()]);

            }

        });


        $receiverAlsoDeleted = $conversation->messages()
            ->where(function ($query) use ($userId) {

                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);

            })->where(function ($query) use ($userId) {

                $query->whereNull('sender_deleted_at')
                    ->orWhereNull('receiver_deleted_at');

            })->doesntExist();



        if ($receiverAlsoDeleted) {

            $conversation->forceDelete();
            # code...
        }



        return redirect(route('chat.index'));

    }
}