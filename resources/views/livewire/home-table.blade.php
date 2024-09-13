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

        <div>
            <p class="ml-0 sm:ml-4">Permit/Contract No.: <span class="font-bold">{{ $client->contact_num }}</span></p>
        </div>
        
        <div>
            <p class="ml-0 sm:ml-4">Mining Type: 
                <span class="font-bold">
                    {{ implode(', ', array_map('formatMiningType', safeJsonDecode($client->mining_type))) }}
                </span>
            </p>
        </div>
        
        <div>
            <p class="ml-0 sm:ml-4">Product: <span class="font-bold">{{ implode(', ', safeJsonDecode($client->product)) }}</span></p> 
        </div>
        
        <div>
            <p class="ml-0 sm:ml-4">Permit Type: <span class="font-bold uppercase">{{ implode(', ', safeJsonDecode($client->permit_type)) }}</span></p> 
        </div>
        
        <div>
            <p class="ml-0 sm:ml-4">Permit Location: <span class="font-bold">{{ implode(', ', safeJsonDecode($client->permit_location)) }}</span></p> 
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

                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="email">
                            Email Address:
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="email" id="email" wire:model.live="email"
                            class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="contact_num">
                            Permit/Contract Number:
                            <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="contact_num" wire:model.live="contactNum"
                            class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                        @error('contactNum') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Permit and Contract Details -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">
                            Uri ng Pagmimina (Type of Mining):
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="miningType" value="surface_quarry" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Surface o Quarry</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="miningType" value="underground" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Underground</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="miningType" value="seabed" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Seabed</label>
                            </div>
                        </div>
                        @error('miningType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">
                            Uri ng Permit o Kontrata (Permit Type):
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitType" value="ep" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">EP</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitType" value="mpp" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">MPP</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitType" value="qcp" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">QCP</label>
                            </div>
                        </div>
                        @error('permitType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <!-- Location and Commodities -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Lokasyon ng Permit o Kontrata (Location):
                        <span class="text-red-600">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First column for locations -->
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitLocation" value="Cavite" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Cavite</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitLocation" value="Laguna" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Laguna</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitLocation" value="Batangas" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Batangas</label>
                            </div>
                        </div>
                        <!-- Second column for locations -->
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitLocation" value="Rizal" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Rizal</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="permitLocation" value="Quezon" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Quezon</label>
                            </div>
                        </div>
                    </div>
                    @error('permitLocation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Produkto (Commodity):
                        <span class="text-red-600">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Aggregates" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Aggregates</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Filling Materials" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Filling Materials</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Pozzolan" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Pozzolan</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Silica" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Silica</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Boulders (Marble)" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Boulders (Marble)</label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Sand and Gravel" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Sand and Gravel</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Shale" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Shale</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Volcanic Tuff" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Volcanic Tuff</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Boulders" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Boulders</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model.live="product" value="Marine Aggregates" class="fw-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-50 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 ml-2">Marine Aggregates</label>
                            </div>
                        </div>
                    </div>
                    @error('product') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>           

                <!-- Registrant Information -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-400" for="registrant_name">
                        Pangalan ng Naghrehistro (Name of Registrant):
                        <span class="text-red-600">*</span>
                    </label>
                    <input type="text" id="registrant_name" wire:model.live="registrantName"
                        class="w-full mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                    @error('registrantName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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