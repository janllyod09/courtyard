<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\NonLostTimeAccidents;
use App\Models\NonFatalLostTimeAccidents;
use App\Models\FatalLostTimeAccidents;

class AccidentTable extends Component
{
    public function render()
    {
        return view('livewire.accident-table', [
            'accidents' => $this->getProcessedAccidentData(),
        ]);
    }

    private function getProcessedAccidentData()
    {
        $nonLostTimeAccidents = $this->processAccidents(NonLostTimeAccidents::with('cpMonthlyReports.user')->get(), 'Non-Lost Time');
        $nonFatalLostTimeAccidents = $this->processAccidents(NonFatalLostTimeAccidents::with('cpMonthlyReports.user')->get(), 'Non-Fatal Lost Time');
        $fatalLostTimeAccidents = $this->processAccidents(FatalLostTimeAccidents::with('cpMonthlyReports.user')->get(), 'Fatal Lost Time');

        return $nonLostTimeAccidents->concat($nonFatalLostTimeAccidents)->concat($fatalLostTimeAccidents);
    }

    private function processAccidents($accidents, $accidentType)
    {
        return $accidents->map(function ($accident) use ($accidentType) {
            $cpMonthlyReport = $accident->cpMonthlyReports;
            $user = $cpMonthlyReport ? $cpMonthlyReport->user : null;
            
            return [
                'accident_type' => $accidentType,
                'mine_operator' => $user ? $user->company_name : 'N/A',
                'permit_no' => $user ? $user->contact_num : 'N/A',
                'days_lost' => $this->getDaysLost($accidentType, $cpMonthlyReport),
                'name' => $accident->name,
                'gender' => $accident->gender,
                'age' => $accident->age ?? 'N/A',
                'position' => $accident->position,
                'service_contractor' => $accident->company,
                'date_of_accident' => $accident->date_of_accident_illness,
                'time_of_accident' => $accident->time,
                'location' => $accident->location,
                'kind_of_accident' => $this->formatJsonField($accident->kind_of_accident),
                'type_of_injury' => $this->formatJsonField($accident->type_of_injury),
                'part_of_body_injured' => $this->formatJsonField($accident->part_of_body_injured),
                'treatment' => $this->formatJsonField($accident->treatment),
                'total_accident_cost' => $this->calculateTotalCost($accident),
                'description_of_accident' => $accident->description_of_incident,
            ];
        });
    }

    private function getDaysLost($accidentType, $cpMonthlyReport)
    {
        if (!$cpMonthlyReport) {
            return 'N/A';
        }

        switch ($accidentType) {
            case 'Non-Fatal Lost Time':
                return $cpMonthlyReport->nflt_days_lost ?? 'N/A';
            case 'Fatal Lost Time':
                return $cpMonthlyReport->flt_days_lost ?? 'N/A';
            default:
                return 'N/A';
        }
    }

    private function calculateTotalCost($accident)
    {
        return $accident->cost_of_mitigation + $accident->cost_of_property_damage;
    }

    private function formatJsonField($field)
    {
        if (empty($field)) {
            return '';
        }
        if (is_string($field)) {
            $field = json_decode($field, true);
        }
        if (is_array($field)) {
            return implode(', ', $field);
        }
        return $field;
    }
}