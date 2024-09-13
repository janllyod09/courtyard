<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\CpMonthlyReports;
use App\Models\User;
use App\Models\MonthlyDeseases;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminSafetyAndHealthReportsTable extends Component
{
    public $reports = [];
    public $search = '';
    public $selectedYear;
    public $availableYears = [];

    public function mount()
    {
        $this->availableYears = $this->getAvailableYears();
        $this->selectedYear = $this->availableYears[0] ?? date('Y');
        $this->loadReportData();
    }

    public function updatedSearch()
    {
        $this->loadReportData();
    }

    public function updatedSelectedYear()
    {
        $this->loadReportData();
    }

    private function getAvailableYears()
    {
        $years = CpMonthlyReports::selectRaw('YEAR(month) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($years)) {
            $currentYear = date('Y');
            $years = [$currentYear];
        }

        return $years;
    }

    public function loadReportData()
    {
        $reports = CpMonthlyReports::select(
                'cp_monthly_reports.user_id',
                DB::raw('YEAR(cp_monthly_reports.month) as year'),
                DB::raw('QUARTER(cp_monthly_reports.month) as quarter'),
                DB::raw('SUM(cp_monthly_reports.non_lost_time_accident) as total_nlta'),
                DB::raw('SUM(cp_monthly_reports.non_fatal_lost_time_accident) as total_lta_nf'),
                DB::raw('SUM(cp_monthly_reports.fatal_lost_time_accident) as total_lta_f'),
                DB::raw('SUM(cp_monthly_reports.nflt_days_lost + cp_monthly_reports.flt_days_lost) as total_days_lost'),
                DB::raw('SUM(cp_monthly_reports.man_hours) as total_manhours'),
                DB::raw('SUM(cp_monthly_reports.male_workers) as total_male'),
                DB::raw('SUM(cp_monthly_reports.female_workers) as total_female'),
                DB::raw('GROUP_CONCAT(DISTINCT monthly_deseases.desease SEPARATOR ", ") as diseases'),
                DB::raw('SUM(monthly_deseases.no_of_cases) as total_cases')
            )
            ->leftJoin('monthly_deseases', 'cp_monthly_reports.id', '=', 'monthly_deseases.report_id')
            ->whereYear('cp_monthly_reports.month', $this->selectedYear)
            ->groupBy('cp_monthly_reports.user_id', 'year', 'quarter')
            ->with('user')
            ->get();

        $result = [];

        foreach ($reports as $report) {
            $mineOperator = $report->user->company_name ?? 'N/A';
            $tenement = $report->user->contact_num ?? 'N/A';
            $quarterName = $this->getQuarterName($report->quarter);

            if (!isset($result[$mineOperator])) {
                $result[$mineOperator] = [
                    'Tenement' => $tenement,
                    'First Quarter' => $this->getDefaultQuarterData(),
                    'Second Quarter' => $this->getDefaultQuarterData(),
                    'Third Quarter' => $this->getDefaultQuarterData(),
                    'Fourth Quarter' => $this->getDefaultQuarterData(),
                ];
            }

            $result[$mineOperator][$quarterName] = [
                'NLTA' => $report->total_nlta,
                'LTA-NF' => $report->total_lta_nf,
                'LTA-F' => $report->total_lta_f,
                'Days Lost' => $report->total_days_lost,
                'Manhours Worked' => $report->total_manhours,
                'Male Employees' => $report->total_male,
                'Female Employees' => $report->total_female,
                'Total Employees' => $report->total_male + $report->total_female,
                'Recorded Diseases' => $report->diseases ?: 'None',
                'No. of Cases' => $report->total_cases ?: 0,
            ];
        }

        // Filter results based on search
        if (!empty($this->search)) {
            $result = array_filter($result, function($key) {
                return stripos($key, $this->search) !== false;
            }, ARRAY_FILTER_USE_KEY);
        }

        $this->reports = $result;
    }

    private function getQuarterName($quarter)
    {
        return match ($quarter) {
            1 => 'First Quarter',
            2 => 'Second Quarter',
            3 => 'Third Quarter',
            4 => 'Fourth Quarter',
            default => 'Unknown Quarter',
        };
    }

    private function getDefaultQuarterData()
    {
        return [
            'NLTA' => 0,
            'LTA-NF' => 0,
            'LTA-F' => 0,
            'Days Lost' => 0,
            'Manhours Worked' => 0,
            'Male Employees' => 0,
            'Female Employees' => 0,
            'Total Employees' => 0,
            'Recorded Diseases' => 'None',
            'No. of Cases' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.admin-safety-and-health-reports-table');
    }
}