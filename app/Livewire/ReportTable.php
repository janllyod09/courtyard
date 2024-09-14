<?php

namespace App\Livewire;

use App\Exports\SafetyHealthMonthlyReportExport;
use App\Models\CpMonthlyReports;
use App\Models\ExplosivesConsumptions;
use App\Models\FatalLostTimeAccidents;
use App\Models\MonthlyDeseases;
use App\Models\NonFatalLostTimeAccidents;
use App\Models\NonLostTimeAccidents;
use App\Models\QuarterlyEmergencyDrillReports;
use App\Models\User;
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

    public $search;
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
    public $deleteId;
    public $editReportId;
    public $reportStatus;
    public $reportStatusId;
    public $tableView = 0;
    public $thisYear;

    public function mount(){
        $this->updateNltaCount();
        $this->updateNfltaCount();
        $this->updateFltaCount();
        $this->deseases[] = [
            'desease' => '', 
            'count' => '',
            'response' => '',
        ];

        $user = Auth::user();
        if($user->user_role === 'admin'){
            $this->date = now()->format('Y-m');
        }
        $this->thisYear = 2024;
    }

    public function render(){
        $user = Auth::user();
        $this->encoder = $user->name;
        $this->company = $user->company_name;
        $this->permitNumber = $user->contact_num;

        $reports = CpMonthlyReports::query()
                    ->when($this->date, function ($query) {
                        $date = Carbon::parse($this->date);
                        return $query->whereMonth('cp_monthly_reports.month', $date->month)
                            ->whereYear('cp_monthly_reports.month', $date->year);
                    })
                    ->when($this->search, function ($query) {
                        return $query->search(trim($this->search));
                    })
                    ->join('users', 'users.id', 'cp_monthly_reports.user_id')
                    ->when($user->user_role === 'client', function ($query) use ($user) {
                        return $query->where('cp_monthly_reports.user_id', $user->id);
                    })
                    ->select('cp_monthly_reports.*', 'users.company_name')
                    ->orderBy('cp_monthly_reports.month', 'DESC')
                    ->paginate(10);

        $reports2 = CpMonthlyReports::query()
            ->when($this->thisYear, function ($query) {
                return $query->whereYear('cp_monthly_reports.month', $this->thisYear);
            })
            ->when($this->search, function ($query) {
                return $query->search(trim($this->search));
            })
            ->join('users', 'users.id', 'cp_monthly_reports.user_id')
            ->when($user->user_role === 'client', function ($query) use ($user) {
                return $query->where('cp_monthly_reports.user_id', $user->id);
            })
            ->select('cp_monthly_reports.*', 'users.company_name')
            ->orderBy('cp_monthly_reports.month', 'DESC')
            ->get();

        $this->updateNltaCount();
        $this->updateNfltaCount();
        $this->updateFltaCount();

        return view('livewire.report-table',[
            'reports' => $reports,
            'reports2' => $reports2,
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
        if($this->create){
            $this->create = null;
            $this->resetVariables();
            $this->resetValidation();
        }else{
            $this->create = true;
        }
    }

    public function toggleEditReport($id){
        $this->editReportId = $id;
        $report = CpMonthlyReports::with(['nonLostTimeAccidents', 'nonFatalLostTimeAccidents', 'fatalLostTimeAccidents', 'monthlyDeseases'])->findOrFail($id);
        if($report){
            $this->create = true;
            $this->month = Carbon::parse($report->month)->format('Y-m');
            $this->manHours = $report->man_hours;
            $this->maleWorkers = $report->male_workers;
            $this->femaleWorkers = $report->female_workers;
            $this->serviceContractors = $report->service_contractors;
            $this->nlta = $report->non_lost_time_accident;
            $this->nflta = $report->non_fatal_lost_time_accident;
            $this->flta = $report->fatal_lost_time_accident;
            $this->nfltaDaysLost = $report->nflt_days_lost;
            $this->fltaDaysLost = $report->flt_days_lost;
            $this->minutes = $report->minutes;
            $this->nltaPersons = $this->formatAccidentData($report->nonLostTimeAccidents);
            $this->nfltaPersons = $this->formatAccidentData($report->nonFatalLostTimeAccidents);
            $this->fltaPersons = $this->formatAccidentData($report->fatalLostTimeAccidents);
            $this->deseases = $report->monthlyDeseases->map(function ($disease) {
                return [
                    'desease' => $disease->desease,
                    'count' => $disease->no_of_cases,
                    'response' => $disease->response,
                ];
            })->toArray();

            // Populate explosives consumption
            if ($report->explosivesConsumptions) {
                $explosives = $report->explosivesConsumptions;
                $this->blastingContractor = $explosives->blasting_contractor;
                $this->dynamite = $explosives->dynamite;
                $this->detonatingCord = $explosives->detonating_cord;
                $this->nonElecBlastingCaps = $explosives->non_elec_blasting_caps;
                $this->elecBlastingCaps = $explosives->elec_blasting_caps;
                $this->fuseLighter = $explosives->fuse_lighter;
                $this->connectors = $explosives->connectors;
                $this->ammoniumNitrate = $explosives->ammonium_nitrate;
                $this->shotshellPrimer = $explosives->shotshell_primer;
                $this->primer = $explosives->primer;
                $this->emulsion = $explosives->emulsion;
                $this->others = $explosives->others;
            }
        }
    }

    private function formatAccidentData($accidents){
        return $accidents->map(function ($accident) {
            return [
                'name' => $accident->name,
                'gender' => $accident->gender,
                'position' => $accident->position,
                'dateOfAccidentIllness' => $accident->date_of_accident_illness,
                'time' => $accident->time,
                'location' => $accident->location,
                'physicalInjury' => $accident->has_physical_injury ? true : false,
                'propertyDamage' => $accident->has_property_damage ? true : false,
                'serviceContractor' => $accident->is_service_contractor ? true : false,
                'company' => $accident->company,
                'cause' => $accident->cause_of_accident_illness,
                'unsafeAct' => $accident->is_unsafe_acts ? true : false,
                'unsafeActDescription' => $accident->is_unsafe_acts_description,
                'unsafeConditions' => $accident->is_unsafe_conditions ? true : false,
                'unsafeConditionsDescription' => $accident->is_unsafe_conditions_description,
                'kindOfAccident' => json_decode($accident->kind_of_accident, true),
                'typeOfInjury' => json_decode($accident->type_of_injury, true),
                'partOfBodyInjured' => json_decode($accident->part_of_body_injured, true),
                'treatment' => json_decode($accident->treatment, true),
                'cost_of_mitigation' => $accident->cost_of_mitigation,
                'cost_of_property_damage' => $accident->cost_of_property_damage,
                'performingWork' => $accident->is_performing_routine_work ? true : false,
                'performingWorkDescription' => $accident->is_not_performing_routine_work_description,
                'incidentDescription' => $accident->description_of_incident,
            ];
        })->toArray();
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
                if ($this->nlta > 0) {
                    $rules = [
                        'nltaPersons' => ['required', 'array', "size:{$this->nlta}"],
                        'nltaPersons.*.name' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.gender' => ['required', 'in:Male,Female'],
                        'nltaPersons.*.position' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.dateOfAccidentIllness' => ['required', 'date'],
                        'nltaPersons.*.time' => ['required'],
                        'nltaPersons.*.location' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.cause' => ['required', 'string', 'max:255'],
                        'nltaPersons.*.incidentDescription' => ['required', 'string', 'max:1000'],
                    ];
            
                    $this->validate($rules);
                }
                $this->currentStep += 1;
                break;
            case 3:
                if ($this->nflta > 0) {
                    $rules = [
                        'nfltaPersons' => ['required', 'array', "size:{$this->nflta}"],
                        'nfltaPersons.*.name' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.gender' => ['required', 'in:Male,Female'],
                        'nfltaPersons.*.position' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.dateOfAccidentIllness' => ['required', 'date'],
                        'nfltaPersons.*.time' => ['required'],
                        'nfltaPersons.*.location' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.cause' => ['required', 'string', 'max:255'],
                        'nfltaPersons.*.incidentDescription' => ['required', 'string', 'max:1000'],
                    ];
            
                    $this->validate($rules);
                }
                $this->currentStep += 1;
                break;
            case 4:
                if ($this->flta > 0) {
                    $rules = [
                        'fltaPersons' => ['required', 'array', "size:{$this->flta}"],
                        'fltaPersons.*.name' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.gender' => ['required', 'in:Male,Female'],
                        'fltaPersons.*.position' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.dateOfAccidentIllness' => ['required', 'date'],
                        'fltaPersons.*.time' => ['required'],
                        'fltaPersons.*.location' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.cause' => ['required', 'string', 'max:255'],
                        'fltaPersons.*.incidentDescription' => ['required', 'string', 'max:1000'],
                    ];

                    $this->validate($rules);
                }
                $this->currentStep += 1;
                break;
            case 5:
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

            if ($hasMonthReport && !$this->editReportId) {
                $this->dispatch('swal', [
                    'title' => 'Merun ka ng report para sa buwan na inilagay (You already have a report for the inputted month)',
                    'icon' => 'error'
                ]);
                return;
            }

            DB::beginTransaction();

            if ($this->editReportId) {
                $oldReport = CpMonthlyReports::findOrFail($this->editReportId);
                $oldReport->delete();
            }

            $fileName = $this->minutes->getClientOriginalName();
            $minutesPath = $this->minutes->storeAs('public/upload/minutes', $fileName); 

            $report = CpMonthlyReports::create([
                'user_id' => $user->id,
                'month' => $thisMonth,
                'date_encoded' => now(),
                'man_hours' => $this->manHours,
                'male_workers' => $this->maleWorkers,
                'female_workers' => $this->femaleWorkers,
                'service_contractors' => $this->serviceContractors,
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
            $this->dispatch('formSubmitted');
            $this->resetVariables();
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
                'name' => $person['name'] ?: null,
                'gender' => $person['gender'] ?: null,
                'position' => $person['position'] ?: null,
                'date_of_accident_illness' => $person['dateOfAccidentIllness'] ?: null,
                'time' => $person['time'] ?: null,
                'location' => $person['location'] ?: null,
                'has_physical_injury' => $person['physicalInjury'] ?: null,
                'has_property_damage' => $person['propertyDamage'] ?: null,
                'is_service_contractor' => $person['serviceContractor'] ?: null,
                'company' => $person['company'] ?: null,
                'cause_of_accident_illness' => $person['cause'] ?: null,
                'is_unsafe_acts' => $person['unsafeAct'] ?: null,
                'is_unsafe_acts_description' => $person['unsafeActDescription'] ?: null,
                'is_unsafe_conditions' => $person['unsafeConditions'] ?: null,
                'is_unsafe_conditions_description' => $person['unsafeConditionsDescription'] ?: null,
                'kind_of_accident' => json_encode($person['kindOfAccident']) ?: null,
                'type_of_injury' => json_encode($person['typeOfInjury']) ?: null,
                'part_of_body_injured' => json_encode($person['partOfBodyInjured']) ?: null,
                'treatment' => json_encode($person['treatment']) ?: null,
                'cost_of_mitigation' => $person['cost_of_mitigation'] ?: null,
                'cost_of_property_damage' => $person['cost_of_property_damage'] ?: null,
                'is_performing_routine_work' => $person['performingWork'] ?: null,
                'is_not_performing_routine_work_description' => $person['performingWorkDescription'] ?: null,
                'description_of_incident' => $person['incidentDescription'] ?: null,
            ]);
        }
    }

    private function createDiseaseRecords($report){
        if(!empty($this->deseases)){
            foreach ($this->deseases as $disease) {
                MonthlyDeseases::create([
                    'report_id' => $report->id,
                    'desease' => $disease['desease'] ?: null,
                    'no_of_cases' => $disease['count'] ?: null,
                    'response' => $disease['response'] ?: null,
                ]);
            }
        }
    }

    private function createExplosivesConsumption($report){
        ExplosivesConsumptions::create([
            'report_id' => $report->id,
            'blasting_contractor' => $this->blastingContractor ?: null,
            'dynamite' => $this->dynamite ?: null,
            'detonating_cord' => $this->detonatingCord ?: null,
            'non_elec_blasting_caps' => $this->nonElecBlastingCaps ?: null,
            'elec_blasting_caps' => $this->elecBlastingCaps ?: null,
            'fuse_lighter' => $this->fuseLighter ?: null,
            'connectors' => $this->connectors ?: null,
            'ammonium_nitrate' => $this->ammoniumNitrate ?: null,
            'shotshell_primer' => $this->shotshellPrimer ?: null,
            'primer' => $this->primer ?: null,
            'emulsion' => $this->emulsion ?: null,
            'others' => $this->others ?: null,
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
            $report = CpMonthlyReports::with(['nonLostTimeAccidents', 'nonFatalLostTimeAccidents', 'fatalLostTimeAccidents', 'monthlyDeseases'])->findOrFail($id);
            if($report){
                $thisMonth = Carbon::parse($report->month);
                $monthYear = $thisMonth->format('F') . " " . $thisMonth->format('Y');
                $month = $thisMonth->format('F');
                $user = Auth::user();

                $client = null;
                $userId = null;
                if($user->user_role == 'admin'){
                    $client = User::where('id', $report->user_id)->first();
                    $userId = $report->user_id;
                }else{
                    $userId = $user->id;
                }

                $injuredPersonnel = collect([
                    'nonLostTimeAccidents' => $report->nonLostTimeAccidents,
                    'nonFatalLostTimeAccidents' => $report->nonFatalLostTimeAccidents,
                    'fatalLostTimeAccidents' => $report->fatalLostTimeAccidents,
                    'monthlyDeseases' => $report->monthlyDeseases,
                ]);

                $quarterlyEmergencyReports = QuarterlyEmergencyDrillReports::where('user_id', $userId)
                                        ->where('year', $thisMonth->format('Y'))
                                        ->get();
                $filters = [
                    'monthYear' => $monthYear,
                    'month' => $month,
                    'report' => $report,
                    'injuredPersonnel' => $injuredPersonnel,
                    'quarterlyEmergencyReports' => $quarterlyEmergencyReports,
                    'client' => $client,
                ];
                $filename = 'SafetyandHealthMonthlyReport.xlsx';
                return Excel::download(new SafetyHealthMonthlyReportExport($filters), $filename);
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function toggleDelete($userId){
        $this->deleteId = $userId;
    }

    public function toggleEditReportStatus($id){
        $user = Auth::user();
        if($user->user_role == 'admin'){
            $this->reportStatusId = $id;
            $report = CpMonthlyReports::findOrFail($this->reportStatusId);
            $this->reportStatus = $report->status;
        }
    }

    public function saveReportStatus(){
        try{
            $report = CpMonthlyReports::findOrFail($this->reportStatusId);
            if($report){
                $report->update([
                    'status' => $this->reportStatus,
                ]);
                $this->reportStatusId = null;
                $this->dispatch('swal', [
                    'title' => 'Tagumpay na nabago ang status (Status updated successfully)',
                    'icon' => 'success'
                ]);
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function deleteData(){
        $report = CpMonthlyReports::findOrFail($this->deleteId);
        $report->delete();
        $this->deleteId = null;
        $this->dispatch('swal', [
            'title' => 'Tagumpay na nabura (Deleted successfully)',
            'icon' => 'success'
        ]);
    }

    public function resetVariables(){
        $this->create = null;
        $this->serviceContractor = null;
        $this->unsafeAct = null;
        $this->manHours = null;
        $this->maleWorkers = null;
        $this->femaleWorkers = null;
        $this->serviceContractors = null;
        $this->unsafeConditions = null;
        $this->performingWork = null;
        $this->minutes = null;
        $this->month = null;
        $this->nlta = 0;
        $this->nflta = 0;
        $this->flta = 0;
        $this->nfltaDaysLost = null;
        $this->fltaDaysLost = null;
        $this->nltaPersons = [];
        $this->nfltaPersons = [];
        $this->fltaPersons = [];
        $this->deseases = [];
        $this->blastingContractor = null;
        $this->dynamite = null;
        $this->detonatingCord = null;
        $this->nonElecBlastingCaps = null;
        $this->elecBlastingCaps = null;
        $this->fuseLighter = null;
        $this->connectors = null;
        $this->ammoniumNitrate = null;
        $this->shotshellPrimer = null;
        $this->primer = null;
        $this->emulsion = null;
        $this->others = null;
        $this->deleteId = null;
        $this->currentStep = 1;
        $this->editReportId = null;
    }
}
