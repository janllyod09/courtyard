<?php

namespace App\Livewire;

use App\Models\QuarterlyEmergencyDrillReports;
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
    public $quarter;
    public $year;
    public $viewThisReport;
    public $reportId;

    public function render()
    {
        $user = Auth::user();
        $years = QuarterlyEmergencyDrillReports::where('user_id', $user->id)
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->paginate(10);

        $reports = QuarterlyEmergencyDrillReports::where('user_id', $user->id)
            ->whereIn('year', $years->pluck('year'))
            ->get()
            ->groupBy('year')
            ->map(function ($yearReports) {
                return $yearReports->groupBy('quarter');
            });

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
                'year' => 'required',
                'quarter' => 'required',
                'dateUploaded' => 'required',
                'drill' => 'required',
                'reportFile' => 'required',
            ]);

            $user = Auth::user();
            $thisYear = Carbon::parse($this->year);
            $year = $thisYear->format('Y');

            $fileName = $this->reportFile->getClientOriginalName();
            $reportFilePath = $this->reportFile->storeAs('public/upload/drill-reports', $fileName);
            $report = QuarterlyEmergencyDrillReports::create([
                'user_id' => $user->id,
                'year' => $year,
                'quarter' => $this->quarter,
                'date_uploaded' => now(),
                'type_of_emergency_drill' => $this->drill,
                'report' => $reportFilePath,
            ]);

            $this->resetVariables();
            $this->dispatch('swal', [
                'title' => 'Tagumpay na naisumite (Submitted successfully)',
                'icon' => 'success'
            ]);
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
                $this->quarter = $report->quarter;
                $this->year = $report->year;
            }
            dd($this->quarter);
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

    public function resetVariables(){
        $this->editReport = null;
        $this->addReport = null;
        $this->dateUploaded = null;
        $this->reportFile = null;
        $this->drill = null;
        $this->quarter = null;
        $this->year = null;
        $this->viewThisReport = null;
        $this->reportId = null;
    }
}