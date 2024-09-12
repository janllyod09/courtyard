<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\CpMonthlyReports;
use App\Models\User;
use Carbon\Carbon;

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
        // Retrieve all users who are mine operators
        $users = User::whereNotNull('company_name')
            ->where('company_name', 'like', '%' . $this->search . '%')
            ->get();
        $userIds = $users->pluck('id')->toArray();

        // Retrieve all reports and their associated users for the selected year
        $reports = CpMonthlyReports::whereIn('user_id', $userIds)
            ->whereYear('month', $this->selectedYear)
            ->with('user')
            ->get();

        // Initialize the data structure for storing the results
        $result = [];

        // Aggregate the data
        foreach ($reports as $report) {
            $mineOperator = $report->user->company_name ?? 'N/A';
            $tenement = $report->user->contact_num ?? 'N/A';
            $month = Carbon::parse($report->month)->month;
            $quarter = ceil($month / 3);
            $quarterName = $this->getQuarterName($quarter);

            // Initialize array for mine operator if not already set
            if (!isset($result[$mineOperator])) {
                $result[$mineOperator] = [
                    'Tenement' => $tenement,
                    'First Quarter' => $this->getDefaultQuarterData(),
                    'Second Quarter' => $this->getDefaultQuarterData(),
                    'Third Quarter' => $this->getDefaultQuarterData(),
                    'Fourth Quarter' => $this->getDefaultQuarterData(),
                ];
            }

            if (isset($result[$mineOperator][$quarterName])) {
                $result[$mineOperator][$quarterName]['NLTA'] += $report->nonLostTimeAccidents()->count();
                $result[$mineOperator][$quarterName]['LTA-NF'] += $report->nonFatalLostTimeAccidents()->count();
                $result[$mineOperator][$quarterName]['LTA-F'] += $report->fatalLostTimeAccidents()->count();
                $result[$mineOperator][$quarterName]['Manhours Worked'] += $report->man_hours;
                $result[$mineOperator][$quarterName]['Male Employees'] += $report->male_workers;
                $result[$mineOperator][$quarterName]['Female Employees'] += $report->female_workers;
            }
        }

        // Initialize default data for users without reports
        foreach ($users as $user) {
            $mineOperator = $user->company_name;
            if (!isset($result[$mineOperator])) {
                $result[$mineOperator] = [
                    'Tenement' => $user->contact_num,
                    'First Quarter' => $this->getDefaultQuarterData(),
                    'Second Quarter' => $this->getDefaultQuarterData(),
                    'Third Quarter' => $this->getDefaultQuarterData(),
                    'Fourth Quarter' => $this->getDefaultQuarterData(),
                ];
            }
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
            'Manhours Worked' => 0,
            'Male Employees' => 0,
            'Female Employees' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.admin-safety-and-health-reports-table');
    }
}