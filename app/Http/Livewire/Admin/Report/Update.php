<?php

namespace App\Http\Livewire\Admin\Report;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $report;

    
    protected $rules = [
        
    ];

    public function mount(Report $Report){
        $this->report = $Report;
        
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if($this->getRules())
            $this->validate();

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Report') ]) ]);
        
        $this->report->update([
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.report.update', [
            'report' => $this->report
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Report') ])]);
    }
}
