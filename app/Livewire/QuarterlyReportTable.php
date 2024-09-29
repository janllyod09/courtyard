<?php

namespace App\Livewire;

use App\Models\Permits;
use App\Models\QuarterlyEmergencyDrillReports;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class QuarterlyReportTable extends Component
{
    use WithPagination, WithFileUploads;

    public $create;
    public $editReport;
    public $addReport;
    public $dateUploaded;
    public $reportFile;
    public $drill;
    public $yearQuarter;
    public $year;
    public $viewThisReport;
    public $reportId;
    public $deleteId;
    public $editReportId;
    public $permitNumbers = [];
    public $permitNumber;
    public $yearReport;

    public function render()
    {
        $user = Auth::user();
        $years = collect();
        $reports = collect();

        if($user->user_role == 'client'){
            $this->permitNumbers = Permits::where('user_id', $user->id)->select('permit_number')->get();
            $years = QuarterlyEmergencyDrillReports::where('user_id', $user->id)
                ->select('year', 'permit_number')
                ->distinct('year', 'permit_number')
                ->when($this->year, function ($query) {
                    return $query->where('year', $this->year);
                })
                ->orderBy('year', 'desc')
                ->paginate(10);
    
            $reports = QuarterlyEmergencyDrillReports::where('user_id', $user->id)
                ->whereIn('year', $years->pluck('year'))
                ->get()
                ->groupBy('year')
                ->map(function ($yearReports) {
                    return $yearReports->groupBy('quarter');
                });
        }else{
            $yearsQuery = User::join('quarterly_emergency_drill_reports', 'quarterly_emergency_drill_reports.user_id', 'users.id')
                ->select('quarterly_emergency_drill_reports.year', 'users.company_name', 'quarterly_emergency_drill_reports.permit_number')
                ->distinct('quarterly_emergency_drill_reports.year', 'users.company_name', 'quarterly_emergency_drill_reports.permit_number')
                ->when($this->year, function ($query) {
                    return $query->where('year', $this->year);
                })
                ->orderBy('year', 'desc');

            $years = $yearsQuery->paginate(10);

            $reportYears = $years->pluck('year')->unique();

            $reports = QuarterlyEmergencyDrillReports::whereIn('year', $reportYears)
                ->get()
                ->groupBy('year')
                ->map(function ($yearReports) {
                    return $yearReports->groupBy('quarter');
                });
        }

        return view('livewire.quarterly-report-table', [
            'reports' => $reports,
            'years' => $years,
        ]);
    }

    public function toggleCreateReport(){
        $this->dateUploaded = now()->format('d/m/Y');
        $this->editReport = true;
        $this->addReport = true;
    }

    public function saveReport(){
        try{
            $this->validate([
                'yearReport' => 'required',
                'yearQuarter' => 'required',
                'dateUploaded' => 'required',
                'permitNumber' => 'required',
                'drill' => 'required',
            ]);

            $user = Auth::user();

            $reportFilePath = null;
            if($this->reportFile){
                $fileName = $this->reportFile->getClientOriginalName();
                $reportFilePath = $this->reportFile->storeAs('public/upload/drill-reports', $fileName);
            }

            $thisReport = QuarterlyEmergencyDrillReports::where('year', $this->yearReport)
                        ->where('quarter', $this->yearQuarter)
                        ->first();

            if ($thisReport && !$this->editReportId) {
                $this->dispatch('swal', [
                    'title' => 'May report kana para sa quarter na ito (You already have a report for this quarter)',
                    'icon' => 'error'
                ]);
                return;
            }

            $report = QuarterlyEmergencyDrillReports::create([
                'user_id' => $user->id,
                'permit_number' => $this->permitNumber,
                'year' => $this->yearReport,
                'quarter' => $this->yearQuarter,
                'date_uploaded' => now(),
                'type_of_emergency_drill' => $this->drill,
                'report' => $reportFilePath,
            ]);

            $this->resetVariables();
            $this->dispatch('swal', [
                'title' => 'Tagumpay na naisumite (Submitted successfully)',
                'icon' => 'success'
            ]);
            $this->dispatch('formSubmitted');
        }catch(Exception $e){
            throw $e;
        }
    }

    public function viewReport($id){
        $this->reportId = $id;
        $this->viewThisReport = true;
        try{
            $report = QuarterlyEmergencyDrillReports::findOrFail($id);
            if($report){
                $this->dateUploaded = $report->date_uploaded;
                $this->reportFile = $report->report;
                $this->drill = $report->type_of_emergency_drill;
                $this->yearQuarter = $report->quarter;
                $this->year = $report->year;
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function downloadFile($path){
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

    public function toggleEditReport($id){
        $report = QuarterlyEmergencyDrillReports::findOrFail($id);
        $this->editReport = true;
        $this->yearReport = $report->year;
        $this->yearQuarter =  $report->quarter;
        $this->drill = $report->type_of_emergency_drill;
        $this->reportFile = $report->report;
    }
    
    public function toggleDelete($userId){
        $this->deleteId = $userId;
    }

    public function deleteData(){
        $report = QuarterlyEmergencyDrillReports::findOrFail($this->deleteId);
        $report->delete();
        $this->deleteId = null;
        $this->dispatch('swal', [
            'title' => 'Tagumpay na nabura (Deleted successfully)',
            'icon' => 'success'
        ]);
    }

    public function resetVariables(){
        $this->editReport = null;
        $this->addReport = null;
        $this->dateUploaded = null;
        $this->reportFile = null;
        $this->drill = null;
        $this->yearQuarter = null;
        $this->year = null;
        $this->viewThisReport = null;
        $this->reportId = null;
        $this->deleteId = null;
        $this->editReportId = null;
        $this->yearReport = null;
        $this->permitNumber = null;
    }
}
