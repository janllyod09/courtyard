<?php

namespace App\Livewire;

use App\Exports\ClientsExport;
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

    public function mount(){
        $this->selectedClient = Auth::user();
    }

    public function render(){
        $clients = User::where('user_role', 'client')
            ->when($this->search, function ($query) {
                return $query->search(trim($this->search));
            })
            ->paginate(10);

        return view('livewire.clients-table', [
            'clients' => $clients,
        ]);
    }

    public function exportClients(){
        try{
            $clients = User::where('user_role', 'client')
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

    public function toggleViewClient($id){
        $this->clientId = $id;
        $this->selectedClient = User::findOrFail($id);
    }

    public function resetVariables(){
        $this->clientId = null;
        $this->selectedClient = Auth::user();
    }
}