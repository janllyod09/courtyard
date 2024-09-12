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
    public $serviceContractor;
    public $unsafeAct;
    public $unsafeConditions;
    public $performingWork;
    public $month;
    public $nlta = 0;
    public $nflta = 0;
    public $flta = 0;
    public $nfltaDaysLost;
    public $fltaDaysLost;
    public $nltaPersons = [];
    public $nfltaPersons = [];
    public $fltaPersons = [];
    public $deseases = [];
    public $blastingContractor;
    public $dynamite;
    public $detonatingCord;
    public $nonElecBlastingCaps;
    public $elecBlastingCaps;
    public $fuseLighter;
    public $connectors;
    public $ammoniumNitrate;
    public $shotshellPrimer;
    public $primer;
    public $emulsion;
    public $others;
    

    public function mount(){
        $this->updateNltaCount();
        $this->updateNfltaCount();
        $this->updateFltaCount();
        $this->deseases[] = [
            'desease' => '', 
            'count' => '',
            'response' => '',
        ];
    }

    public function render()
    {
        $user = Auth::user();

        $reports = CpMonthlyReports::where('user_id', $user->id)
            ->when($this->date, function ($query) {
                $query->whereMonth('month', Carbon::parse($this->date)->month)
                    ->whereYear('month', Carbon::parse($this->date)->year);
            })
            ->paginate(10);

        $this->updateNltaCount();
        $this->updateNfltaCount();
        $this->updateFltaCount();

        return view('livewire.report-table',[
            'reports' => $reports,
        ]);
    }

    public function addNltaPerson(){
        $this->nltaPersons[] = [
            'name' => '',
            'gender' => '',
            'position' => '',
            'dateOfAccidentIllness' => '',
            'time' => '',
            'location' => '',
            'serviceContractor' => '',
            'company' => '',
            'physicalInjury' => '',
            'propertyDamage' => '',
            'cause' => '',
            'unsafeAct' => '',
            'unsafeActDescription' => '',
            'unsafeConditions' => '',
            'unsafeConditionsDescription' => '',
            'kindOfAccident' => [],
            'typeOfInjury' => [],
            'partOfBodyInjured' => [],
            'otherParts' => '',
            'treatment' => [],
            'cost_of_mitigation' => '',
            'cost_of_property_damage' => '',
            'performingWork' => '',
            'performingWorkDescription' => '',
            'incidentDescription' => '',
        ];
    }

    public function addNfltaPerson(){
        $this->nfltaPersons[] = [
            'name' => '',
            'gender' => '',
            'position' => '',
            'dateOfAccidentIllness' => '',
            'time' => '',
            'location' => '',
            'serviceContractor' => '',
            'company' => '',
            'physicalInjury' => '',
            'propertyDamage' => '',
            'cause' => '',
            'unsafeAct' => '',
            'unsafeActDescription' => '',
            'unsafeConditions' => '',
            'unsafeConditionsDescription' => '',
            'kindOfAccident' => [],
            'typeOfInjury' => [],
            'partOfBodyInjured' => [],
            'otherParts' => '',
            'treatment' => [],
            'cost_of_mitigation' => '',
            'cost_of_property_damage' => '',
            'performingWork' => '',
            'performingWorkDescription' => '',
            'incidentDescription' => '',
        ];
    }

    public function addFltaPerson(){
        $this->fltaPersons[] = [
            'name' => '',
            'gender' => '',
            'position' => '',
            'dateOfAccidentIllness' => '',
            'time' => '',
            'location' => '',
            'serviceContractor' => '',
            'company' => '',
            'physicalInjury' => '',
            'propertyDamage' => '',
            'cause' => '',
            'unsafeAct' => '',
            'unsafeActDescription' => '',
            'unsafeConditions' => '',
            'unsafeConditionsDescription' => '',
            'kindOfAccident' => [],
            'typeOfInjury' => [],
            'partOfBodyInjured' => [],
            'otherParts' => '',
            'treatment' => [],
            'cost_of_mitigation' => '',
            'cost_of_property_damage' => '',
            'performingWork' => '',
            'performingWorkDescription' => '',
            'incidentDescription' => '',
        ];
    }

    public function updateNltaCount(){
        $currentCount = count($this->nltaPersons);
        if ($this->nlta > $currentCount) {
            for ($i = $currentCount; $i < $this->nlta; $i++) {
                $this->addNltaPerson();
            }
        } elseif ($this->nlta < $currentCount) {
            $this->nltaPersons = array_slice($this->nltaPersons, 0, $this->nlta ?: 0);
        }
    }

    public function updateNfltaCount(){
        $currentCount = count($this->nfltaPersons);
        if ($this->nflta > $currentCount) {
            for ($i = $currentCount; $i < $this->nflta; $i++) {
                $this->addNfltaPerson();
            }
        } elseif ($this->nflta < $currentCount) {
            $this->nfltaPersons = array_slice($this->nfltaPersons, 0, $this->nflta ?: 0);
        }
    }

    public function updateFltaCount(){
        $currentCount = count($this->fltaPersons);
        if ($this->flta > $currentCount) {
            for ($i = $currentCount; $i < $this->flta; $i++) {
                $this->addFltaPerson();
            }
        } elseif ($this->flta < $currentCount) {
            $this->fltaPersons = array_slice($this->fltaPersons, 0, $this->flta ?: 0);
        }
    }

    public function submit(){
        $this->validate();
        
        // Process and save the data
        foreach ($this->nltaPersons as &$person) {
            $person['kindOfAccident'] = json_encode($person['kindOfAccident']);
        }

    }

    public function addDesease(){
        $this->deseases[] = [
            'desease' => '', 
            'count' => '',
            'response' => '',
        ];
    }
    public function removeDesease($index){
        unset($this->deseases[$index]);
        $this->deseases = array_values($this->deseases);
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
