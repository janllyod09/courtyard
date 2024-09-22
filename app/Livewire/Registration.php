<?php

namespace App\Livewire;

use App\Models\Permits;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class Registration extends Component
{
    public $password;
    public $c_password;
    public $companyName;
    public $name;
    public $registrantName;
    public $email;
    public $showModal = false;

    public $permits = [];

    protected $rules = [
        'companyName' => 'required',
        'registrantName' => 'required',
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'c_password' => 'required|same:password',
        'permits.*.permit_number' => 'required',
        'permits.*.mining_type' => 'required',
        'permits.*.permit_type' => 'required',
        'permits.*.location' => 'required',
        'permits.*.product' => 'required|array|min:1',
    ];

    protected $messages = [
        'password.required' => 'The password field is required.',
        'password.min' => 'The password must be at least 8 characters long.',
        'c_password.required' => 'The password confirmation field is required.',
        'c_password.same' => 'The password confirmation does not match the password.',
        'permits.*.permit_number.required' => 'The permit/contract number field is required.',
        'permits.*.mining_type.required' => 'Please select a mining type.',
        'permits.*.permit_type.required' => 'Please select a permit type.',
        'permits.*.location.required' => 'Please select a permit location.',
        'permits.*.product.required' => 'Please select at least one product.',
        'permits.*.product.min' => 'Please select at least one product.',
    ];

    public function mount()
    {
        $this->addPermit();
    }

    public function addPermit()
    {
        $this->permits[] = [
            'permit_number' => '',
            'mining_type' => '',
            'permit_type' => '',
            'location' => '',
            'product' => [],
        ];
    }

    public function removePermit($index)
    {
        if (count($this->permits) > 1) {
            unset($this->permits[$index]);
            $this->permits = array_values($this->permits);
        }
    }

    public function submit(){
        
        $this->validate();

        if (!$this->isPasswordComplex($this->password)) {
            $this->addError('password', 'The password must include at least one uppercase letter, one number, and one special character.');
            return;
        }
        sleep(1);
        

        // Create new user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'company_name' => $this->companyName,
            'registrant_name' => $this->registrantName,
            'user_role' => 'client',
        ]);

        foreach ($this->permits as $permitData) {
            Permits::create([
                'user_id' => $user->id,
                'permit_number' => $permitData['permit_number'],
                'mining_type' => $permitData['mining_type'],
                'permit_type' => $permitData['permit_type'],
                'location' => $permitData['location'],
                'product' => json_encode($permitData['product']),
            ]);
        }

        // Reset form fields
        $this->reset(['password', 'c_password', 'companyName', 'name', 'registrantName', 'email']);

        $this->showModal = true;
    }

    private function isPasswordComplex($password)
    {
        $containsUppercase = preg_match('/[A-Z]/', $password);
        $containsNumber = preg_match('/\d/', $password);
        $containsSpecialChar = preg_match('/[^A-Za-z0-9]/', $password);
        return $containsUppercase && $containsNumber && $containsSpecialChar;
    }

    public function render()
    {
        return view('livewire.registration');
    }
}