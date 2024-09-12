<?php

namespace App\Livewire;

use App\Exports\SafetyHealthMonthlyReportExport;
use App\Models\CpMonthlyReports;
use App\Models\ExplosivesConsumptions;
use App\Models\FatalLostTimeAccidents;
use App\Models\MonthlyDeseases;
use App\Models\NonFatalLostTimeAccidents;
use App\Models\NonLostTimeAccidents;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReportTable extends Component
{
    use WithPagination, WithFileUploads;

    public $date;
    public $create;
    public $currentStep = 1;
    public $encoder;
    public $company;
    public $permitNumber;
    public $serviceContractor;
    public $unsafeAct;
    public $manHours;
    public $maleWorkers;
    public $femaleWorkers;
    public $serviceContractors;
    public $unsafeConditions;
    public $performingWork;
    public $minutes;
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

    public function render(){
        $user = Auth::user();
        $this->encoder = $user->name;
        $this->company = $user->company_name;
        $this->permitNumber = $user->contact_num;

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
        switch($this->currentStep){
            case 1:
                $this->validate([
                    'month' => 'required',
                    'manHours' => 'required',
                    'maleWorkers' => 'required',
                    'femaleWorkers' => 'required',
                    'serviceContractors' => 'required'
                ]);
                $this->currentStep += 1;
                break;
            case 2:
                $rules = [];
                $rules2 = [];
                $rules3 = [];
                if ($this->nlta > 0) {
                    $rules = [
                        'nltaPersons' => ['required', 'array', "size:{$this->nlta}"],
                        'nltaPersons.*.name' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.gender' => ['required', 'in:Male,Female'],
                        'nltaPersons.*.position' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.dateOfAccidentIllness' => ['required', 'date'],
                        'nltaPersons.*.time' => ['required', 'date_format:H:i'],
                        'nltaPersons.*.location' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.cause' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.cost_of_mitigation' => ['required', 'numeric', 'min:0'],
                        'nltaPersons.*.cost_of_property_damage' => ['required', 'numeric', 'min:0'],
                        'nltaPersons.*.performingWork' => ['required', 'boolean'],
                        'nltaPersons.*.incidentDescription' => ['required', 'string', 'max:1000'],
                    ];
            
                    $this->validate($rules);
                }
                if ($this->nflta > 0) {
                    $rules2 = [
                        'nfltaPersons' => ['required', 'array', "size:{$this->nflta}"],
                        'nfltaPersons.*.name' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.gender' => ['required', 'in:Male,Female'],
                        'nfltaPersons.*.position' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.dateOfAccidentIllness' => ['required', 'date'],
                        'nfltaPersons.*.time' => ['required', 'date_format:H:i'],
                        'nfltaPersons.*.location' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.cause' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.cost_of_mitigation' => ['required', 'numeric', 'min:0'],
                        'nfltaPersons.*.cost_of_property_damage' => ['required', 'numeric', 'min:0'],
                        'nfltaPersons.*.performingWork' => ['required', 'boolean'],
                        'nfltaPersons.*.incidentDescription' => ['required', 'string', 'max:1000'],
                    ];
            
                    $this->validate($rules);
                }
                if ($this->flta > 0) {
                    $rules3 = [
                        'fltaPersons' => ['required', 'array', "size:{$this->flta}"],
                        'fltaPersons.*.name' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.gender' => ['required', 'in:Male,Female'],
                        'fltaPersons.*.position' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.dateOfAccidentIllness' => ['required', 'date'],
                        'fltaPersons.*.time' => ['required', 'date_format:H:i'],
                        'fltaPersons.*.location' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.cause' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.cost_of_mitigation' => ['required', 'numeric', 'min:0'],
                        'fltaPersons.*.cost_of_property_damage' => ['required', 'numeric', 'min:0'],
                        'fltaPersons.*.performingWork' => ['required', 'boolean'],
                        'fltaPersons.*.incidentDescription' => ['required', 'string', 'max:1000'],
                    ];
            
                    $this->validate([$rules, $rules2, $rules3]);
                }
                $this->currentStep += 1;
                break;
            case 3:
                $this->validate([
                    'minutes' => 'required',
                ]);
                $this->currentStep += 1;
                break;
        }
    }

    public function previousStep(){
        $this->currentStep -= 1;
    }


    public function submit(){
        try {
            $user = Auth::user();
            if (!$user) {
                throw new Exception('User not authenticated');
            }

            $thisMonth = Carbon::parse($this->month);
            $hasMonthReport = CpMonthlyReports::whereMonth('month', $thisMonth->month)
                ->whereYear('month', $thisMonth->year)
                ->first();

            if ($hasMonthReport) {
                $this->dispatch('swal', [
                    'title' => 'Merun ka ng report para sa buwan na inilagay (You already have a report for the inputted month)',
                    'icon' => 'error'
                ]);
                return;
            }

            DB::beginTransaction();

            $fileName = $this->minutes->getClientOriginalName();
            $minutesPath = $this->minutes->storeAs('public/upload/minutes', $fileName); 

            $report = CpMonthlyReports::create([
                'user_id' => $user->id,
                'month' => $thisMonth,
                'date_encoded' => now(),
                'man_hours' => $this->manHours,
                'male_workers' => $this->maleWorkers,
                'female_workers' => $this->femaleWorkers,
                'service_contractors' => $this->serviceContractor,
                'non_lost_time_accident' => $this->nlta,
                'non_fatal_lost_time_accident' => $this->nflta,
                'fatal_lost_time_accident' => $this->flta,
                'nflt_days_lost' => $this->nfltaDaysLost,
                'flt_days_lost' => $this->fltaDaysLost,
                'minutes' => $minutesPath,
                'status' => 0,
            ]);

            $this->createAccidentRecords($report);
            $this->createDiseaseRecords($report);
            $this->createExplosivesConsumption($report);

            DB::commit();

            $this->dispatch('swal', [
                'title' => 'Tagumpay na naisumite (Submitted successfully)',
                'icon' => 'success'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createAccidentRecords($report){
        if ($this->nlta > 0) {
            $this->createAccidents($report, $this->nltaPersons, NonLostTimeAccidents::class);
        }
        if ($this->nflta > 0) {
            $this->createAccidents($report, $this->nfltaPersons, NonFatalLostTimeAccidents::class);
        }
        if ($this->flta > 0) {
            $this->createAccidents($report, $this->fltaPersons, FatalLostTimeAccidents::class);
        }
    }

    private function createAccidents($report, $persons, $modelClass){
        foreach ($persons as $person) {
            if (!empty($person['otherParts'])) {
                $person['partOfBodyInjured'][] = $person['otherParts'];
            }
            if(!$person['serviceContractor']){
                $person['serviceContractor'] = 0;
                $person['company'] = null;
            }
            if(!$person['unsafeAct']){
                $person['unsafeAct'] = 0;
                $person['unsafeActDescription'] = null;
            }
            if(!$person['unsafeConditions']){
                $person['unsafeConditions'] = 0;
                $person['unsafeConditionsDescription'] = null;
            }
            if($person['performingWork']){
                $person['performingWork'] = 0;
                $person['performingWorkDescription'] = null;
            }

            if(!$person['physicalInjury']){
                $person['physicalInjury'] = 0;
            }
            if(!$person['propertyDamage']){
                $person['propertyDamage'] = 0;
            }

            $modelClass::create([
                'report_id' => $report->id,
                'name' => $person['name'],
                'gender' => $person['gender'],
                'position' => $person['position'],
                'date_of_accident_illness' => $person['dateOfAccidentIllness'],
                'time' => $person['time'],
                'location' => $person['location'],
                'has_physical_injury' => $person['physicalInjury'],
                'has_property_damage' => $person['propertyDamage'],
                'is_service_contractor' => $person['serviceContractor'],
                'company' => $person['company'],
                'cause_of_accident_illness' => $person['cause'],
                'is_unsafe_acts' => $person['unsafeAct'],
                'is_unsafe_acts_description' => $person['unsafeActDescription'],
                'is_unsafe_conditions' => $person['unsafeConditions'],
                'is_unsafe_conditions_description' => $person['unsafeConditionsDescription'],
                'kind_of_accident' => json_encode($person['kindOfAccident']),
                'type_of_injury' => json_encode($person['typeOfInjury']),
                'part_of_body_injured' => json_encode($person['partOfBodyInjured']),
                'treatment' => json_encode($person['treatment']),
                'cost_of_mitigation' => $person['cost_of_mitigation'],
                'cost_of_property_damage' => $person['cost_of_property_damage'],
                'is_performing_routine_work' => $person['performingWork'],
                'is_not_performing_routine_work_description' => $person['performingWorkDescription'],
                'description_of_incident' => $person['incidentDescription'],
            ]);
        }
    }

    private function createDiseaseRecords($report)
    {
        foreach ($this->deseases as $disease) {
            MonthlyDeseases::create([
                'report_id' => $report->id,
                'desease' => $disease['desease'],
                'no_of_cases' => $disease['count'],
                'response' => $disease['response'],
            ]);
        }
    }

    private function createExplosivesConsumption($report)
    {
        ExplosivesConsumptions::create([
            'report_id' => $report->id,
            'dynamite' => $this->dynamite,
            'detonating_cord' => $this->detonatingCord,
            'non_elec_blasting_caps' => $this->nonElecBlastingCaps,
            'elec_blasting_caps' => $this->elecBlastingCaps,
            'fuse_lighter' => $this->fuseLighter,
            'connectors' => $this->connectors,
            'ammonium_nitrate' => $this->ammoniumNitrate,
            'shotshell_primer' => $this->shotshellPrimer,
            'primer' => $this->primer,
            'emulsion' => $this->emulsion,
            'others' => $this->others,
        ]);
    }

    public function downloadFile($path)
    {
        try{
            $fileName = basename($path);
        
            return Storage::download($path, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function exportReport($id){
        try{
            $report = CpMonthlyReports::findOrFail($id);
            if($report){
                $thisMonth = Carbon::parse($report->month);
                $monthYear = $thisMonth->format('F') . " " . $thisMonth->format('Y');
                $filters = [
                    'monthYear' => $monthYear,
                    'report' => $report,
                ];
                $filename = 'SafetyandHealthMonthlyReport.xlsx';
                return Excel::download(new SafetyHealthMonthlyReportExport($filters), $filename);
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}
