<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\ExplosivesConsumptions;
use Illuminate\Support\Facades\DB;

class ExplosiveTable extends Component
{
    public $search = '';  // For search input
    public $year = '';    // For year filter

    public function render()
    {
        return view('livewire.explosive-table', [
            'consumptions' => $this->getProcessedConsumptionData(),
            'availableYears' => $this->getAvailableYears(), // Provide available years for the dropdown
        ]);
    }

    private function getProcessedConsumptionData()
    {
        $query = ExplosivesConsumptions::with('cpMonthlyReports.user');

        // Filter by year
        if ($this->year) {
            $query->whereHas('cpMonthlyReports', function ($q) {
                $q->whereYear('month', $this->year);
            });
        }

        // Filter by search input (mine operator or tenement)
        if ($this->search) {
            $query->whereHas('cpMonthlyReports.user', function ($q) {
                $q->where('company_name', 'like', '%' . $this->search . '%')
                  ->orWhere('contact_num', 'like', '%' . $this->search . '%');
            });
        }

        return $query->get()->map(function ($consumption) {
            $cpMonthlyReport = $consumption->cpMonthlyReports;
            $user = $cpMonthlyReport ? $cpMonthlyReport->user : null;

            return [
                'mine_operator' => $user ? $user->company_name : 'N/A',
                'permit_no' => $user ? $user->permits()->get() : 'N/A',
                'blasting_contractor' => $consumption->blasting_contractor,
                'dynamite' => $consumption->dynamite,
                'detonating_cord' => $consumption->detonating_cord,
                'non_elec_blasting_caps' => $consumption->non_elec_blasting_caps,
                'elec_blasting_caps' => $consumption->elec_blasting_caps,
                'fuse_lighter' => $consumption->fuse_lighter,
                'connectors' => $consumption->connectors,
                'ammonium_nitrate' => $consumption->ammonium_nitrate,
                'shotshell_primer' => $consumption->shotshell_primer,
                'primer' => $consumption->primer,
                'emulsion' => $consumption->emulsion,
                'others' => $consumption->others,
            ];
        });
    }

    private function getAvailableYears()
    {
        return DB::table('cp_monthly_reports')
                 ->select(DB::raw('YEAR(month) as year'))
                 ->groupBy('year')
                 ->orderBy('year', 'desc')
                 ->pluck('year');
    }
}
