<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyReportsData extends Component
{
    public $totalUsers;
    public $monthlyData;
    public $miningTypeData;
    public $monthlyReportData;

    public function mount()
    {
        $this->fetchData();
    }

    private function fetchData(){
        $currentYear = Carbon::now()->year;
        $monthlyReports = DB::table('cp_monthly_reports')
            ->select(DB::raw('MONTH(month) as month'), DB::raw('COUNT(DISTINCT user_id) as count'))
            ->whereYear('month', $currentYear)
            ->groupBy(DB::raw('MONTH(month)'))
            ->orderBy('month')
            ->get();

        $this->monthlyReportData = collect(range(1, 12))->map(function ($month) use ($monthlyReports) {
            $report = $monthlyReports->firstWhere('month', $month);
            return [
                'month' => Carbon::create()->month($month)->format('M'),
                'count' => $report ? $report->count : 0,
            ];
        })->values()->toArray();
    }
    
    public function render()
    {
        return view('livewire.monthly-reports-data');
    }
}
