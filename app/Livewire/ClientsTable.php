<?php

namespace App\Livewire;

use App\Exports\ClientsExport;
use App\Models\Permits;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ClientsTable extends Component
{
    use WithPagination;
    public $search;
    public $clientId;
    public $selectedClient;
    public $permitNum;
    public $deleteId;

    public function mount(){
        $this->selectedClient = Auth::user();
    }

    public function render(){
        $clients = User::where('users.user_role', 'client')
            ->when($this->search, function ($query) {
                return $query->search(trim($this->search));
            })
            ->join('permits', 'permits.user_id', 'users.id')
            ->select('users.*', 'permits.permit_number', 'permits.location','permits.product','permits.permit_type','permits.mining_type',)
            ->paginate(10);

        return view('livewire.clients-table', [
            'clients' => $clients,
        ]);
    }

    public function exportClients(){
        try{
            $clients = User::where('users.user_role', 'client')
                ->join('permits', 'permits.user_id', 'users.id')
                ->when($this->search, function ($query) {
                    return $query->search(trim($this->search));
                })->get();

            $filters = [
                'clients' => $clients,
            ];
            return Excel::download(new ClientsExport($filters), 'ClientsList.xlsx');
            
        }catch(Exception $e){
            throw $e;
        }
    }

    public function toggleViewClient($id, $permit){
        $this->clientId = $id;
        $this->selectedClient = User::where('users.id', $id)
                ->join('permits', 'permits.user_id', 'users.id')
                ->where('permits.permit_number', $permit)
                ->first();
    }

    public function toggleDelete($userId){
        $this->deleteId = $userId;
    }

    public function deleteData(){
        try {
            $user = User::where('id', $this->deleteId)->first();
            if ($user) {
                $user->delete();
                $message = "Client deleted successfully!";
                $this->resetVariables();
                $this->dispatch('swal', [
                    'title' => $message,
                    'icon' => 'success'
                ]);            
            }
        } catch (Exception $e) {
            $this->dispatch('swal', [
                'title' => "Client deletion was unsuccessful!",
                'icon' => 'error'
            ]);
            $this->resetVariables();
            throw $e;
        }
    }

    public function resetVariables(){
        $this->clientId = null;
        $this->deleteId = null;
    }
}
