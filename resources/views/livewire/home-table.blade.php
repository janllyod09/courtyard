<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto"
x-data="{ 
    selectedTab: '',
    init() { 
        Livewire.on('formSubmitted', () => {
            // Reload the page
            window.location.reload();
        });
    } 
}" 
>


    <div id="clock" class="text-lg font-semibold mb-4 text-gray-400 dark:text-gray-500 h-10 text-center">
        <!-- Time will be displayed here -->
    </div>

    <x-dashboard.welcome-banner />


    <div class="flex flex-col sm:flex-row gap-4 sm:items-center">
        @if (Auth::user()->profile_photo_path)
            <img src="{{ route('profile-photo.file', ['filename' => basename(Auth::user()->profile_photo_path)]) }}" 
                    alt="{{ Auth::user()->name }}" 
                    width="100" height="100"
                    class="w-20 h-20 rounded-full">
        @else
            <img class="w-20 h-20 rounded-full" src="{{ Auth::user()->profile_photo_url }}" width="100" height="100" alt="" />
        @endif
        <div>
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-100">{{ $client->company_name }} <span class="text-xs cursor-pointer hover:text-blue-500" wire:click='toggleEditProfile'><i class="bi bi-pencil" title="Edit Profile"></i></span></h1>
            <p>{{ $client->email }}</p>
        </div>
    </div>
    <div class="text-sm">
        @php
            function safeJsonDecode($value) {
                if (is_string($value)) {
                    return json_decode($value, true) ?: [$value];
                }
                return is_array($value) ? $value : [$value];
            }
            function formatMiningType($type) {
                if ($type === 'surface_quarry') {
                    return 'Surface o Quarry';
                }
                return ucwords(str_replace('_', ' ', $type));
            }
        @endphp

        <div class="w-full grid grid-cols-4 gap-4 mt-4">
            @foreach ($permits as $index => $permit)
                <div class="col-span-full sm:col-span-1">
                    <div>
                        <p class="ml-0 sm:ml-4">Permit/Contract No.: <span class="text-gray-800 dark:text-gray-100 font-bold">{{ $permit->permit_number }}</span></p>
                    </div>
                    
                    <div>
                        <p class="ml-0 sm:ml-4">Mining Type: 
                            <span class="text-gray-800 dark:text-gray-100 font-bold uppercase">
                                {{ $permit->mining_type }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <p class="ml-0 sm:ml-4">Product: <span class="text-gray-800 dark:text-gray-100 font-bold">{{ implode(', ', safeJsonDecode($permit->product)) }}</span></p> 
                    </div>
                    
                    <div>
                        <p class="ml-0 sm:ml-4">Permit Type: <span class="text-gray-800 dark:text-gray-100 font-bold uppercase">{{ $permit->permit_type }}</span></p> 
                    </div>
                    
                    <div>
                        <p class="ml-0 sm:ml-4">Permit Location: <span class="text-gray-800 dark:text-gray-100 font-bold">{{ $permit->location }}</span></p> 
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Profile Edit Modal --}}
    <x-modal id="edit" maxWidth="2xl" wire:model="edit">
        <div class="p-4">
            <div class="bg-slate-800 rounded-t-lg mb-4 dark:bg-gray-200 p-4 text-gray-50 dark:text-slate-900 font-bold">
                Edit Company Profile
                <button @click="show = false" class="float-right focus:outline-none" wire:click='resetVariables'>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="saveProfile">
                <!-- Company Information -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="company_name">
                        Pangalan ng Kumpanya (Name of Company):
                        <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="company_name" wire:model.live="companyName"
                        class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                    @error('companyName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="name">
                        Pangalan ng Operator:
                        <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="name" wire:model.live="name"
                        class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="email">
                            Email Address:
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="email" id="email" wire:model.live="email"
                            class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="registrant_name">
                            Pangalan ng Naghrehistro (Name of Registrant):
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="registrant_name" wire:model.live="registrantName"
                            class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                        @error('registrantName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                @foreach ($thisPermits as $index => $permit)
                    <fieldset class="border border-gray-300 rounded-md p-2 mb-2 bg-gray-50 dark:bg-gray-600">
                        <div class="mb-6 grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-sm text-gray-700 dark:text-gray-100 font-bold" for="permit_number_{{ $index }}">
                                    Permit/Contract Number:
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="permit_number_{{ $index }}" wire:model="thisPermits.{{ $index }}.permit_number"
                                    class="w-full h-12 px-4 py-2 text-black dark:text-white border rounded-lg appearance-none bg-chalk dark:bg-gray-700 border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error("thisPermits.{$index}.permit_number") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Mining Type -->
                        <div class="mb-6">
                            <label class="text-sm text-gray-700 dark:text-gray-100 font-bold">
                                Uri ng Pagmimina (Type of Mining):
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="space-y-2">
                                @foreach(['surface o quarry' => 'Surface o Quarry', 'underground' => 'Underground', 'seabed' => 'Seabed'] as $value => $label)
                                    <div class="flex items-center">
                                        <input type="radio" wire:model="thisPermits.{{ $index }}.mining_type" value="{{ $value }}" 
                                            class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded-full focus:ring-blue-500">
                                        <label class="text-sm text-gray-700 dark:text-gray-100 ml-2">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error("thisPermits.{$index}.mining_type") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Permit Type -->
                        <div class="mb-6">
                            <label class="text-sm text-gray-700 dark:text-gray-100 font-bold">
                                Uri ng Permit o Kontrata (Permit Type):
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['ep' => 'EP', 'isag' => 'ISAG', 'mpp' => 'MPP', 'mpsa' => 'MPSA', 'patent' => 'Patent', 'gsqp' => 'GSQP', 'qp' => 'QP', 'smp' => 'SMP'] as $value => $label)
                                    <div class="flex items-center">
                                        <input type="radio" wire:model="thisPermits.{{ $index }}.permit_type" value="{{ $value }}" 
                                            class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded-full focus:ring-blue-500">
                                        <label class="text-sm text-gray-700 dark:text-gray-100 ml-2">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error("thisPermits.{$index}.permit_type") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-6">
                            <label class="text-sm text-gray-700 dark:text-gray-100 font-bold">
                                Lokasyon ng Permit o Kontrata (Location):
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['Cavite', 'Laguna', 'Batangas', 'Rizal', 'Quezon'] as $location)
                                    <div class="flex items-center">
                                        <input type="radio" wire:model="thisPermits.{{ $index }}.location" value="{{ $location }}" 
                                            class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded-full focus:ring-blue-500">
                                        <label class="text-sm text-gray-700 dark:text-gray-100 ml-2">{{ $location }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error("thisPermits.{$index}.location") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Product -->
                        <div class="mb-6">
                            <label class="text-sm text-gray-700 dark:text-gray-100 font-bold">
                                Produkto (Commodity):
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['Aggregates', 'Filling Materials', 'Pozzolan', 'Silica', 'Boulders (Marble)', 'Sand and Gravel', 'Shale', 'Volcanic Tuff', 'Boulders', 'Marine Aggregates'] as $product)
                                    <div class="flex items-center">
                                        <input type="checkbox" wire:model="thisPermits.{{ $index }}.product" value="{{ $product }}" 
                                            class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500">
                                        <label class="text-sm text-gray-700 dark:text-gray-100 ml-2">{{ $product }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error("thisPermits.{$index}.product") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if (count($thisPermits) != 1)
                            <div class="flex justify-end">
                                <p wire:click="removePermit({{ $index }})"
                                class="inline-flex items-center text-sm justify-center w-full h-8 cursor-pointer gap-3 px-5 py-3 font-medium text-gray-700 hover:text-white bg-red-300 rounded-md hover:bg-red-500 focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                    Tangalin and permit (Remove permit)
                                </p>
                            </div>
                        @endif
                    </fieldset>
                @endforeach
                <div class="flex justify-end mb-6">
                    <p wire:click='addPermit'
                    class="inline-flex items-center text-sm justify-center w-full h-8 cursor-pointer gap-3 px-5 py-3 font-medium text-white bg-blue-700 rounded-md hover:bg-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        Magdagdag pa ng permit (Add permit)
                    </p>
                </div>         

                {{-- Save and Cancel buttons --}}
                <div class="mt-4 flex justify-end col-span-2 sm:col-span-2 text-sm">
                    <button class="mr-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <div wire:loading wire:target="saveProfile" style="margin-bottom: 5px;">
                            <div class="spinner-border small text-primary" role="status">
                            </div>
                        </div>
                        Save
                    </button>
                    <p @click="show = false" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded cursor-pointer" wire:click='resetVariables'>
                        Cancel
                    </p>
                </div>
            </form>

        </div>
    </x-modal>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const timeString = now.toLocaleString('en-US', options);
        document.getElementById('clock').textContent = timeString;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>