<?php

namespace App\Livewire;

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
    public $contactNum;
    public $miningType = [];
    public $permitType = [];
    public $product = [];
    public $permitLocation = [];
    public $showModal = false;

    protected $rules = [
        'companyName' => 'required',
        'registrantName' => 'required',
        'product' => 'required|array|min:1',
        'contactNum' => 'required',
        'miningType' => 'required|array|min:1',
        'permitType' => 'required|array|min:1',
        'permitLocation' => 'required|array|min:1',
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'c_password' => 'required|same:password',
    ];

    protected $messages = [
        'password.required' => 'The password field is required.',
        'password.min' => 'The password must be at least 8 characters long.',
        'c_password.required' => 'The password confirmation field is required.',
        'c_password.same' => 'The password confirmation does not match the password.',
        'miningType.required' => 'Please select at least one mining type.',
        'permitType.required' => 'Please select at least one permit type.',
        'product.required' => 'Please select at least one product.',
        'permitLocation.required' => 'Please select at least one permit location.',
    ];

    public function submit()
    {
        
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
            'user_role' => 'emp',
            'contact_num' => $this->contactNum,
            'mining_type' => json_encode($this->miningType),
            'permit_type' => json_encode($this->permitType),
            'product' => json_encode($this->product),
            'permit_location' => json_encode($this->permitLocation),
        ]);

        // Reset form fields
        $this->reset(['password', 'c_password', 'companyName', 'name', 'registrantName', 'email', 'contactNum', 'miningType', 'permitType', 'product', 'permitLocation']);

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