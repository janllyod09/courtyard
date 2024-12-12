<?php

namespace App\Livewire;

use App\Models\Permits;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;
use App\Services\PdfTemplateService;
use Illuminate\Support\Facades\Storage;

class HomeTable extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $fillUpForm = false;
    public $uploadFile = false;
    public $fullname;
    public $address;
    public $position;
    public $qualification = [];
    public $files = [];
    public $file;

    protected $rules = [
        'position' => 'required|string',
        'qualification' => 'required|array|min:1',
        'files.*' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
    ];

    public function submit()
    {
        $this->validate([
            'files.property_title' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'files.hoa_due_certificate' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'files.special_power_of_attorney' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);
        $user = Auth::user();

        if ($user) {
            $propertyTitlePath = $this->storeFile($this->files['property_title']);
            $user->update([
                'position' => $this->position,
                'qualification' => implode(',', $this->qualification),
                // 'property_title_path' => $this->storeFile($this->files['property_title']),
                'property_title_path' => $propertyTitlePath,
                'hoa_due_certificate_path' => $this->storeFile($this->files['hoa_due_certificate']),
                'special_power_of_attorney_path' => $this->storeFile($this->files['special_power_of_attorney']),
                // 'property_title_name' => $this->files['property_title']->getClientOriginalName(),
                'property_title_name' => $this->files['property_title']->getClientOriginalName(),
                'hoa_due_certificate_name' => $this->files['hoa_due_certificate']->getClientOriginalName(),
                'special_power_of_attorney_name' => $this->files['special_power_of_attorney']->getClientOriginalName(),
            ]);
        }

        $this->dispatch('swal', [
            'title' => "You have successfully filled up the form!",
            'icon' => 'success'
        ]);

        $this->resetForm();
        $this->closeForm();
    }

    private function storeFile($file)
    {
        // Use a more unique filename to prevent overwriting
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        return $file->storeAs('attachments', $filename, 'public');
    }

    public function removeFile($key)
    {
        $user = Auth::user();
    
        if ($user && isset($this->files[$key])) {
            Storage::disk('public')->delete($user->{$key . '_path'});
    
            $user->update([
                "{$key}_path" => null,
                "{$key}_name" => null,
            ]);
    
            unset($this->files[$key]);
        }
    }
    
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Check if a user is logged in
        if (Auth::check()) {
            $users = User::query()
                ->where('id', Auth::user()->id)
                ->where(function($query) {
                    $query->where('lastname', 'like', '%' . $this->search . '%')
                          ->orWhere('firstname', 'like', '%' . $this->search . '%')
                          ->orWhere('middlename', 'like', '%' . $this->search . '%')
                          ->orWhere('address', 'like', '%' . $this->search . '%');
                })
                ->paginate($this->perPage);
        } else {
            // If no user is logged in, return an empty collection
            $users = collect();
        }
    
        return view('livewire.home-table', [
            'users' => $users,
        ]);
    }

    public function openForm()
    {
        $this->loadUserData();
        $this->fillUpForm = true;
    }

    public function closeForm()
    {
        $this->fillUpForm = false;
        $this->resetForm();
    }

    public function resetVariables()
    {
        $this->position = null;
        $this->qualification = null;
        $this->attachment = null;
        $this->files = [];
    }

    public function loadUserData()
    {
        $user = Auth::user();
        if ($user) {
            $this->fullname = $user->lastname . ', ' . $user->firstname . ' ' . ($user->middlename ?? '');
            $this->address = $user->address ?? 'Address not provided';
        }
    }
    
    public function resetForm()
    {
        $this->reset([
            'position',
            'qualification',
            'files',
        ]);
    }

    public function exportForm($userId)
    {
        // Ensure the user is authorized to export their own form
        if (Auth::id() !== $userId) {
            $this->dispatch('swal', [
                'title' => "Unauthorized Access",
                'icon' => 'error'
            ]);
            return;
        }
    
        // Fetch the user
        $user = User::findOrFail($userId);
    
        // Prepare user data
        $userData = [
            'fullname' => $user->lastname . ', ' . $user->firstname . ' ' . ($user->middlename ?? ''),
            'name' => $user->firstname . ' ' . ($user->middlename ?? '') . ' ' . $user->lastname,
            'address' => $user->address ?? 'Address not provided',
            'position' => $user->position ?? 'N/A',
            'qualification' => $user->qualification ? explode(',', $user->qualification) : [],
        ];
    
        try {
            $templatePath = storage_path('app/templates/Certificate-of-Candidacy-2022-to-2023.pdf');
    
            $pdf = new Fpdi();
    
            $pdf->AddPage();
            $pdf->setSourceFile($templatePath);
            $templatePage = $pdf->importPage(1);
            $pdf->useTemplate($templatePage);

            $pdf->SetFont('Helvetica', 'B', 24);
            $pageWidth = $pdf->GetPageWidth();
            $titleText = 'CERTIFICATE OF CANDIDACY';
            $titleWidth = $pdf->GetStringWidth($titleText);
            $centerX = ($pageWidth - $titleWidth) / 2;
            $pdf->SetXY($centerX, 30);
            $pdf->Cell($titleWidth, 10, $titleText, 0, 1, 'C');
    
            $pdf->SetFont('Helvetica', '', 12);
    
            $pdf->SetXY(25, 45);
            $text = 'I, ' . $userData['fullname'] . ' of legal age and a resident of ' . $userData['address'] . " Courtyard of Maia Alta Dalig 2, Antipolo City Rizal is filing my candidacy to run on the below position (Choose only the most desired and suitable position):";
            $pdf->MultiCell(160, 7, $text, 0, 'J');
    
            $positionOptions = [
                'President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'Board of Director (1 of 3 Slots)'
            ];
            $yOffset = $pdf->GetY() + 5;
            foreach ($positionOptions as $position) {
                $pdf->SetXY(35, $yOffset);
                $pdf->Cell(0, 10, '[ ' . ($userData['position'] == $position ? 'x' : '  ') . ' ] ' . $position, 0, 1);
                $yOffset += 5;
            }
    
            $yOffset += 10;
            $pdf->SetXY(25, $yOffset);
            $pdf->MultiCell(160, 7, 'I hereby confirm that I am qualified to the position in compliance and defined by the Constitution and By Law (Please check all applicable qualifications):', 0, 'L');
    
            $qualificationOptions = [
                'Must be of legal age',
                'Must be in good standing',
                'Must be an actual resident of Courtyard of Maia Alta for at least six (6)   months as certified by the association secretary',
                'Has not been convicted by final judgement of an offense involving moral  turpitude',
                'Legitimate Spouse of a member may be a candidate in lieu of the member in accordance with the provisions of Rule 9 of Implementing Rules and Regulations of Magna Carta for Homeowners and Homeowners Associations'
            ];
            
            $extraMargin = 10;
            $availableWidthForQualifications = 160 - $extraMargin;
            $yOffset = $pdf->GetY() + 5;
            $indent = 35;
            
            foreach ($qualificationOptions as $qualification) {
                $pdf->SetXY($indent, $yOffset);
            
                $checked = in_array($qualification, $userData['qualification']) ? '[ x ]' : '[   ]';
            
                $pdf->MultiCell($availableWidthForQualifications, 6, "$checked $qualification", 0, 'J');
            
                $yOffset = $pdf->GetY() + 2;
            }

            $indent = 25;
            $yOffset = $pdf->GetY() + 15;

            $pdf->SetXY($indent, $yOffset);
            $pdf->SetFont('Arial', 'U', 12); 
            $pdf->Cell(0, 6, "{$userData['name']}", 0, 1, 'L');

            $pdf->SetXY($indent, $pdf->GetY());
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 6, 'Candidates Signature Over Printed Name', 0, 1, 'L');

            $pdf->SetXY($indent, $pdf->GetY());
            $pdf->SetFont('Arial', 'I', 10);
            $pdf->Cell(0, 6, '(to be signed during personal filing / candidate presentation)', 0, 1, 'L');


            $filename = 'Certificate-of-Candidacy-2025.pdf';
            $filepath = storage_path('app/public/exports/' . $filename);
    
            if (!file_exists(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }

            $pdf->Output($filepath, 'F');
    
            $this->dispatch('swal', [
                'title' => "PDF Exported Successfully!",
                'text' => "Your form has been exported.",
                'icon' => 'success'
            ]);
    
            return response()->download($filepath, $filename, [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(true);
    
        } catch (Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
    
            $this->dispatch('swal', [
                'title' => "Export Failed",
                'text' => "There was an error exporting the PDF. Please try again.",
                'icon' => 'error'
            ]);
        }
    }

    public function openUpload()
    {
        $this->uploadFile = true;
    }

    public function closeUpload()
    {
        $this->uploadFile = false;
    }

    public function submitFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Retrieve the logged-in user
        $user = auth()->user();

        if ($this->file && $user) {
            $filePath = $this->file->store('uploads', 'public');

            // Update the user's record with the file path
            $user->update([
                'upload_file_path' => $filePath,
            ]);

            // Reset the file input field
            $this->file = null;

            // Emit a success message
            $this->dispatch('swal', [
                'title' => "You have successfully uploaded the file!",
                'icon' => 'success'
            ]);

            $this->closeUpload();
        }
    }

    public function removeFileUpload()
    {
        $this->file = null;
    }
    
}
