<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\ExplosivesConsumptions;

class ExplosiveTable extends Component
{
    public function render()
    {
        return view('livewire.explosive-table', [
            'consumptions' => $this->getProcessedConsumptionData(),
        ]);
    }

    private function getProcessedConsumptionData()
    {
        return ExplosivesConsumptions::with('cpMonthlyReports.user')
            ->get()
            ->map(function ($consumption) {
                $cpMonthlyReport = $consumption->cpMonthlyReports;
                $user = $cpMonthlyReport ? $cpMonthlyReport->user : null;

                return [
                    'mine_operator' => $user ? $user->company_name : 'N/A',
                    'permit_no' => $user ? $user->contact_num : 'N/A',
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
}