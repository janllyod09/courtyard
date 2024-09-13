<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Livewire\Component;

class QuarterlyReportsData extends Component
{
    public $quarterlyData;
    public $currentYear;

    public function mount()
    {
        $this->currentYear = Carbon::now()->year;
        $this->fetchData();
    }

    private function fetchData()
    {
        $reports = DB::table('quarterly_emergency_drill_reports')
            ->select('quarter', DB::raw('COUNT(DISTINCT user_id) as count'))
            ->where('year', $this->currentYear)
            ->groupBy('quarter')
            ->orderBy('quarter')
            ->get();

        $this->quarterlyData = collect(range(1, 4))->map(function ($quarter) use ($reports) {
            $report = $reports->firstWhere('quarter', $quarter);
            return [
                'quarter' => 'Q' . $quarter,
                'count' => $report ? $report->count : 0,
            ];
        })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.quarterly-reports-data');
    }
}
