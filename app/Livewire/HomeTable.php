<?php

namespace App\Livewire;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class HomeTable extends Component
{
    public $edit;
    public $miningType = [];
    public $permitType = [];
    public $product = [];
    public $permitLocation = [];
    public $companyName;
    public $name;
    public $registrantName;
    public $email;
    public $contactNum;

    public function render(){
        $client = Auth::user();

        return view('livewire.home-table', [
            'client' => $client,
        ]);
    }

    public function toggleEditProfile(){
        $user = Auth::user();
        $this->edit = true;
        $this->name = $user->name;
        $this->registrantName = $user->registrant_name;
        $this->email = $user->email;
        $this->contactNum = $user->contact_num;
        $this->companyName = $user->company_name;
        $this->miningType = $user->mining_type;
        $this->permitType = $user->permit_type;
        $this->product = json_decode($user->product);
        $this->permitLocation = $user->permit_location;
    }

    public function saveProfile(){
        try{
            $user = Auth::user();
            $client = User::findOrFail($user->id);
            $client->update([
                'name' => $this->name,
                'email' => $this->email,
                'company_name' => $this->companyName,
                'registrant_name' => $this->registrantName,
                'contact_num' => $this->contactNum,
                'mining_type' => $this->miningType,
                'permit_type' => $this->permitType,
                'product' => json_encode($this->product),
                'permit_location' => $this->permitLocation,
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

    public function resetVariables(){
        $this->edit = null;
        $this->miningType = [];
        $this->permitType = [];
        $this->product = [];
        $this->permitLocation = [];
        $this->companyName = null;
        $this->name = null;
        $this->registrantName = null;
        $this->email = null;
        $this->contactNum = null;
    }
}
