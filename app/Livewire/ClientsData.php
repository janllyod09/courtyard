<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class ClientsData extends Component
{
    public $totalUsers;
    public $monthlyData;

    public function mount()
    {
        $this->fetchData();
    }

    private function fetchData()
    {
        $clients = User::where('user_role', 'client')->get();
        $this->totalUsers = $clients->count();

        $groupedClients = $clients->groupBy(function ($client) {
            return Carbon::parse($client->created_at)->format('Y-m');
        });

        $this->monthlyData = collect(range(1, 12))->map(function ($month) use ($groupedClients) {
            $date = Carbon::now()->startOfYear()->addMonths($month - 1);
            $count = $groupedClients->get($date->format('Y-m'), collect())->count();
            return [
                'month' => $date->format('M'),
                'count' => $count,
            ];
        })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.clients-data');
    }
}
