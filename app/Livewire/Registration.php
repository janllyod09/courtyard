<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Registration extends Component
{
    public $firstname;
    public $middlename;
    public $lastname;
    public $address;
    public $email;
    public $password;
    public $c_password;
    public $showModal = false;
    public $user_role = 'client';

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'middlename' => 'nullable|string|max:255',
        'lastname' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'c_password' => 'required|same:password',
    ];

    protected $messages = [
        'firstname.required' => 'The first name field is required.',
        'lastname.required' => 'The last name field is required.',
        'address.required' => 'The address field is required.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please provide a valid email address.',
        'email.unique' => 'This email address is already registered.',
        'password.required' => 'The password field is required.',
        'password.min' => 'The password must be at least 8 characters.',
        'c_password.required' => 'The confirmation password field is required.',
        'c_password.same' => 'The password confirmation does not match the password.',
    ];

    public function submit()
    {
        $this->validate();

        if (!$this->isPasswordComplex($this->password)) {
            $this->addError('password', 'The password must include at least one uppercase letter, one number, and one special character.');
            return;
        }

        // Create a new user
        User::create([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'address' => $this->address,
            'user_role' => $this->user_role,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Reset fields after successful registration
        $this->reset(['firstname', 'middlename', 'lastname', 'address', 'email', 'password', 'c_password']);

        // Show success modal
        $this->showModal = true;
    }

    private function isPasswordComplex($password)
    {
        return preg_match('/[A-Z]/', $password) && // Contains at least one uppercase letter
               preg_match('/\d/', $password) &&    // Contains at least one number
               preg_match('/[^A-Za-z0-9]/', $password); // Contains at least one special character
    }

    public function render()
    {
        return view('livewire.registration');
    }
}
