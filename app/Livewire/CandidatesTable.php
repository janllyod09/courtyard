<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class CandidatesTable extends Component
{
    public $search = '';
    public $editingUser = null;
    public $statuses = ['Not Applied Yet', 'For Review by ELECOM', 'Approved', 'Disapproved'];

    // Method to update statuses automatically based on conditions
    public function render()
    {
        // Get users excluding admins
        $users = User::where('user_role', '!=', 'admin')
            ->where(function ($query) {
                $query->where('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('middlename', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%');
            })
            ->get();

        // Automatically update the status for users who meet the criteria
        foreach ($users as $user) {
            // Check if the required fields have values
            if ($user->status === 'Not Applied Yet' && 
                $user->position && 
                $user->qualification && 
                $user->property_title_path && 
                $user->hoa_due_certificate_path && 
                $user->special_power_of_attorney_path && 
                $user->property_title_name && 
                $user->hoa_due_certificate_name && 
                $user->special_power_of_attorney_name && 
                $user->upload_file_path) 
            {
                // Change the status if all necessary fields are filled
                $user->status = 'For Review by ELECOM';
                $user->save();
            }
        }

        return view('livewire.candidates-table', [
            'users' => $users,
        ]);
    }

    // Admin function to approve a user
    public function approveUser($userId)
    {
        $user = User::find($userId);
        $user->status = 'Approved';
        $user->save();
        session()->flash('message', 'User approved successfully.');
    }

    // Admin function to disapprove a user
    public function disapproveUser($userId)
    {
        $user = User::find($userId);
        $user->status = 'Disapproved';
        $user->save();
        session()->flash('message', 'User disapproved successfully.');
    }
}
