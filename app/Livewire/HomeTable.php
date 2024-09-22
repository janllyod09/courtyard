<?php

namespace App\Livewire;

use App\Models\Permits;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class HomeTable extends Component
{
    public $edit;
    public $thisPermits = [];
    public $companyName;
    public $name;
    public $registrantName;
    public $email;

    public function render(){
        $client = Auth::user();
        $permits = Permits::where('user_id', $client->id)->get();

        return view('livewire.home-table', [
            'client' => $client,
            'permits' => $permits,
        ]);
    }

    public function toggleEditProfile(){
        $user = Auth::user();
        $this->edit = true;
        $this->name = $user->name;
        $this->companyName = $user->company_name;
        $this->registrantName = $user->registrant_name;
        $this->email = $user->email;
        $this->thisPermits = $user->permits->map(function ($permit) {
            $permit = $permit->toArray();
            $permit['product'] = json_decode($permit['product'], true) ?: [];
            return $permit;
        })->toArray();
    }

    public function saveProfile(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'companyName' => 'required',
            'registrantName' => 'required',
            'thisPermits.*.permit_number' => 'required',
            'thisPermits.*.mining_type' => 'required',
            'thisPermits.*.permit_type' => 'required',
            'thisPermits.*.location' => 'required',
            'thisPermits.*.product' => 'required|array|min:1',
        ]);
        try{
            DB::beginTransaction();

            $user = Auth::user();
            $userData = User::findOrFail($user->id);
            $userData->update([
                'name' => $this->name,
                'email' => $this->email,
                'company_name' => $this->companyName,
                'registrant_name' => $this->registrantName,
            ]);
    
            // Delete existing permits and create new ones
            $userData->permits()->delete();
            foreach ($this->thisPermits as $permit) {
                $userData->permits()->create([
                    'permit_number' => $permit['permit_number'],
                    'mining_type' => $permit['mining_type'],
                    'permit_type' => $permit['permit_type'],
                    'location' => $permit['location'],
                    'product' => json_encode($permit['product']),
                ]);
            }
    
            DB::commit();
    
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
        $this->companyName = null;
        $this->name = null;
        $this->registrantName = null;
        $this->email = null;
        $this->thisPermits = [];
    }

    public function addPermit(){
        $this->thisPermits[] = [
            'permit_number' => '',
            'mining_type' => '',
            'permit_type' => '',
            'location' => '',
            'product' => [],
        ];
    }

    public function removePermit($index){
        if (count($this->thisPermits) > 1) {
            unset($this->thisPermits[$index]);
            $this->thisPermits = array_values($this->thisPermits);
        }
    }
}
