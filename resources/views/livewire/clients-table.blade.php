<div class="w-full">

    <style>
        .scrollbar-thin1::-webkit-scrollbar {
                width: 5px;
            }

        .scrollbar-thin1::-webkit-scrollbar-thumb {
            background-color: #c0c0c04b;
        }

        .scrollbar-thin1::-webkit-scrollbar-track {
            background-color: #ffffff23;
        }

        @media (max-width: 1024px){
            .custom-d{
                display: block;
            }
        }

        @media (max-width: 768px){
            .m-scrollable{
                width: 100%;
                overflow-x: scroll;
            }
        }

        @media (min-width:1024px){
            .custom-p{
                padding-bottom: 14px !important;
            }
        }

        @-webkit-keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner-border {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: text-bottom;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner-border .75s linear infinite;
            animation: spinner-border .75s linear infinite;
            color: rgb(0, 255, 42);
        }
    </style>

    @php
        function safeJsonDecode($value) {
            if (is_string($value)) {
                return json_decode($value, true) ?: [$value];
            }
            return is_array($value) ? $value : [$value];
        }
    @endphp

    <div class="flex justify-center w-full">
        <div class="w-full bg-white rounded-2xl p-3 sm:p-6 shadow dark:bg-gray-800 overflow-x-visible">
            <div class="pb-4 mb-3 pt-4 sm:pt-0">
                <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white">MGAR CP PORTAL Clients</h1>
            </div>

            <div class="mb-6 flex flex-col sm:flex-row items-end justify-between">
                <div class="w-full sm:w-1/3 sm:mr-4">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-slate-400 mb-1">Search</label>
                    <input type="text" id="search" wire:model.live="search"
                        class="px-2 py-1.5 block w-full shadow-sm sm:text-sm border border-gray-400 hover:bg-gray-300 rounded-md
                            dark:hover:bg-slate-600 dark:border-slate-600
                            dark:text-gray-300 dark:bg-gray-800"
                        placeholder="Enter company or registered name">
                </div>

                <div class="w-full sm:w-2/3 flex flex-col sm:flex-row sm:justify-end sm:space-x-4">
                    <!-- Export to Excel -->
                    <div class="relative inline-block text-left">
                        <button wire:click="exportClients"
                            class="peer mt-4 sm:mt-1 inline-flex items-center dark:hover:bg-slate-600 dark:border-slate-600
                            justify-center px-4 py-1.5 text-sm font-medium tracking-wide 
                            text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                            rounded-lg border border-gray-400 hover:bg-gray-300 focus:outline-none"
                            type="button" title="Export Clients">
                            <img class="flex dark:hidden" src="/images/export-excel.png" width="22" alt="" wire:loading.remove wire:target="exportClients">
                            <img class="hidden dark:block" src="/images/export-excel-dark.png" width="22" alt="" wire:loading.remove wire:target="exportClients">
                            <div wire:loading wire:target="exportClients">
                                <div class="spinner-border small text-primary" role="status">
                                </div>
                            </div>
                        </button>                    
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="w-full">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
                        <div class="inline-block w-full py-2 align-middle">
                            <div>
                                <div class="overflow-hidden border dark:border-gray-700 rounded-lg">

                                    <div>
                                        <div class="overflow-x-auto">
                                            <table class="w-full min-w-full">
                                                <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl">
                                                    <tr class="whitespace-nowrap">
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                            
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                            Company Name
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                            Registrant Name
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                            Email
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                            Permit/Contract Number
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                            Mining Type
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                            Product
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                            Permit Type
                                                        </th>
                                                        <th scope="col" class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                            Permit Location
                                                        </th>
                                                        {{-- <th class="px-5 py-3 text-gray-100 text-sm font-medium text-center uppercase sticky right-0 z-10 bg-gray-600 dark:bg-gray-600">
                                                            Action
                                                        </th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-neutral-200 dark:divide-gray-400">
                                                    @foreach ($clients as $client)
                                                        <tr class="text-neutral-800 dark:text-neutral-200">
                                                            <td class="px-2 py-2 flex justify-center items-center">
                                                                <div class="flex justify-center items-center cursor-pointer" style="width: 50px; height: 50px" wire:click='toggleViewClient({{ $client->id }})'>
                                                                    @if ($client->profile_photo_path)
                                                                        <img src="{{ route('profile-photo.file', ['filename' => basename($client->profile_photo_path)]) }}" 
                                                                                alt="{{ Auth::user()->name }}" 
                                                                                class="w-full h-full rounded-full hover:grayscale">
                                                                    @else
                                                                        <img class="w-full h-full rounded-full hover:grayscale" src="{{ asset('images/blank-profile.png') }}" alt="">
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="px-5 py-4 text-left text-sm font-medium whitespace-nowrap">
                                                                {{ $client->company_name }}
                                                            </td>
                                                            <td class="px-5 py-4 text-left text-sm font-medium whitespace-nowrap">
                                                                {{ $client->name }}
                                                            </td>
                                                            <td class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                                {{ $client->email }}
                                                            </td>
                                                            <td class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                                {{ $client->contact_num }}
                                                            </td>
                                                            <td class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap uppercase">
                                                                {{ $client->mining_type }}
                                                            </td>
                                                            <td class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                                {{ implode(', ', safeJsonDecode($client->product)) }}
                                                            </td>
                                                            <td class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap uppercase">
                                                                {{ $client->permit_type }}
                                                            </td>
                                                            <td class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                                {{ $client->permit_location }}
                                                            </td>
                                                            {{-- <td class="px-5 py-4 text-sm font-medium text-center whitespace-nowrap sticky right-0 z-10 bg-white dark:bg-gray-800">
                                                                <div class="relative">
                                                                    <button wire:click="toggleEditRole({{ $client->id }})" 
                                                                        class="peer inline-flex items-center justify-center px-4 py-2
                                                                        text-sm font-medium tracking-wide text-blue-500 hover:text-blue-600 
                                                                        focus:outline-none" title="View">
                                                                        <i class="bi bi-eye-fill"></i>
                                                                    </button>
                                                                    <button wire:click="toggleDelete({{ $client->id }}, 'role')" 
                                                                        class=" text-red-600 hover:text-red-900 dark:text-red-600 
                                                                        dark:hover:text-red-900" title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @if ($clients->isEmpty())
                                                <div class="p-4 text-center text-gray-500 dark:text-gray-300">
                                                    No records!
                                                </div> 
                                            @endif
                                        </div>
                                        <div class="p-5 text-neutral-500 dark:text-neutral-200 bg-gray-200 dark:bg-gray-700">
                                            {{ $clients->links() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>


    {{-- View Client Modal --}}
    <x-modal id="clientModal" maxWidth="md" wire:model="clientId" centered>
        <div class="p-4">
         
            <div class="flex flex-col sm:flex-row gap-4 sm:items-center">
                @if ($selectedClient->profile_photo_path)
                    <img src="{{ route('profile-photo.file', ['filename' => basename($selectedClient->profile_photo_path)]) }}" 
                            alt="{{ $selectedClient->name }}" 
                            width="100" height="100"
                            class="w-20 h-20 rounded-full">
                @else
                    <img class="w-20 h-20 rounded-full" src="{{ $selectedClient->profile_photo_url }}" width="100" height="100" alt="" />
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-100">{{ $selectedClient->company_name }}</h1>
                    <p>{{ $selectedClient->email }}</p>
                </div>
            </div>

            <div class="text-sm">
                <div>
                    <p class="ml-0 sm:ml-4">Permit/Contract No.: <span class="font-bold">{{ $selectedClient->contact_num }}</span></p>
                </div>
                
                <div>
                    <p class="ml-0 sm:ml-4">Mining Type: 
                        <span class="font-bold uppercase">
                            {{ $selectedClient->mining_type }}
                        </span>
                    </p>
                </div>
                
                <div>
                    <p class="ml-0 sm:ml-4">Product: <span class="font-bold">{{ implode(', ', safeJsonDecode($selectedClient->product)) }}</span></p> 
                </div>
                
                <div>
                    <p class="ml-0 sm:ml-4">Permit Type: <span class="font-bold uppercase">{{ $selectedClient->permit_type }}</span></p> 
                </div>
                
                <div>
                    <p class="ml-0 sm:ml-4">Permit Location: <span class="font-bold">{{ $selectedClient->permit_location }}</span></p> 
                </div>
            </div>

        </div>
    </x-modal>

</div>