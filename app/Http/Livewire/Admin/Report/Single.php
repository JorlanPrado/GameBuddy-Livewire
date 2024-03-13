<?php

namespace App\Http\Livewire\Admin\Report;

use App\Models\Report;
use Livewire\Component;

class Single extends Component
{

    public $report;

    public function mount(Report $Report){
        $this->report = $Report;
    }

    public function delete()
    {
        $this->report->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Report') ]) ]);
        $this->emit('reportDeleted');
    }

    public function render()
    {
        return view('livewire.admin.report.single')
            ->layout('admin::layouts.app');
    }
}
