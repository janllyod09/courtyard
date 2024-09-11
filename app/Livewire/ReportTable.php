<?php

namespace App\Livewire;

use App\Models\CpMonthlyReports;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ReportTable extends Component
{
    use WithPagination, WithFileUploads;

    public $date;
    public $create = true;
    public $currentStep = 1;

    public function render()
    {
        $user = Auth::user();

        $reports = CpMonthlyReports::where('user_id', $user->id)
            ->when($this->date, function ($query) {
                $query->whereMonth('month', Carbon::parse($this->date)->month)
                    ->whereYear('month', Carbon::parse($this->date)->year);
            })
            ->paginate(10);

        return view('livewire.report-table',[
            'reports' => $reports,
        ]);
    }


    public function toggleCreateReport(){
        $this->create = !$this->create;
    }

    public function nextStep(){
        $this->currentStep += 1;
    }

    public function previousStep(){
        $this->currentStep -= 1;
    }
}
