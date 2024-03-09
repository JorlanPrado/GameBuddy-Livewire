<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class Single extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function Ban()
    {
        $this->user->is_banned = true;
        $this->user->save();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('BannedMessage', ['name' => __('User')])]);
        $this->emit('userBanned');
    }

    public function Unban()
    {
        $this->user->is_banned = false;
        $this->user->save();
        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UnbannedMessage', ['name' => __('User')])]);
        $this->emit('userUnbanned');
    }

    public function render()
    {
        return view('livewire.admin.user.single')
            ->layout('admin::layouts.app');
    }
}