<div>

    <section class="px-2 py-12 mx-auto md:px-12 lg:px-32 max-w-7xl">
        <div class="max-w-lg mx-auto md:max-w-xl md:w-full">
            <div class="flex flex-col text-center">
                <h1 class="text-3xl font-semibold tracking-tight text-gray-900">Registration Form</h1>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }} Please Login <a clase="text-color-blue" href="{{ route('login') }}">Here</a></span>
                </div>
            @endif

            <div class="p-2 mt-8 border bg-gray-50 rounded-3xl">
                <div class="p-4 md:p-10 bg-white border shadow-lg rounded-2xl">
                    <form wire:submit.prevent="submit">
                        <!-- Company Information -->
                        <div class="mb-6">
                            <label class="text-sm text-gray-700 font-bold" for="company_name">
                                Pangalan ng Kumpanya (Name of Company):
                                <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="company_name" wire:model.live="companyName"
                                class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                            @error('companyName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="text-sm text-gray-700 font-bold" for="name">
                                Pangalan ng Operator:
                                <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="name" wire:model.live="name"
                                class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6 grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-sm text-gray-700 font-bold" for="email">
                                    Email Address:
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="email" id="email" wire:model.live="email"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>



                        @foreach ($permits as $index => $permit)
                            <fieldset class="border border-gray-300 rounded-md p-2 mb-2 bg-gray-50">
                                <div class="mb-6 grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="text-sm text-gray-700 font-bold" for="permit_number_{{ $index }}">
                                            Permit/Contract Number:
                                            <span class="text-red-600">*</span>
                                        </label>
                                        <input type="text" id="permit_number_{{ $index }}" wire:model="permits.{{ $index }}.permit_number"
                                            class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                        @error("permits.{$index}.permit_number") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Mining Type -->
                                <div class="mb-6">
                                    <label class="text-sm text-gray-700 font-bold">
                                        Uri ng Pagmimina (Type of Mining):
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        @foreach(['surface o quarry' => 'Surface o Quarry', 'underground' => 'Underground', 'seabed' => 'Seabed'] as $value => $label)
                                            <div class="flex items-center">
                                                <input type="radio" wire:model="permits.{{ $index }}.mining_type" value="{{ $value }}" 
                                                    class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded-full focus:ring-blue-500">
                                                <label class="text-sm text-gray-700 ml-2">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error("permits.{$index}.mining_type") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Permit Type -->
                                <div class="mb-6">
                                    <label class="text-sm text-gray-700 font-bold">
                                        Uri ng Permit o Kontrata (Permit Type):
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach(['ep' => 'EP', 'isag' => 'ISAG', 'mpp' => 'MPP', 'mpsa' => 'MPSA', 'patent' => 'Patent', 'gsqp' => 'GSQP', 'qp' => 'QP', 'smp' => 'SMP'] as $value => $label)
                                            <div class="flex items-center">
                                                <input type="radio" wire:model="permits.{{ $index }}.permit_type" value="{{ $value }}" 
                                                    class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded-full focus:ring-blue-500">
                                                <label class="text-sm text-gray-700 ml-2">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error("permits.{$index}.permit_type") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Location -->
                                <div class="mb-6">
                                    <label class="text-sm text-gray-700 font-bold">
                                        Lokasyon ng Permit o Kontrata (Location):
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach(['Cavite', 'Laguna', 'Batangas', 'Rizal', 'Quezon'] as $location)
                                            <div class="flex items-center">
                                                <input type="radio" wire:model="permits.{{ $index }}.location" value="{{ $location }}" 
                                                    class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded-full focus:ring-blue-500">
                                                <label class="text-sm text-gray-700 ml-2">{{ $location }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error("permits.{$index}.location") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Product -->
                                <div class="mb-6">
                                    <label class="text-sm text-gray-700 font-bold">
                                        Produkto (Commodity):
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach(['Aggregates', 'Filling Materials', 'Pozzolan', 'Silica', 'Boulders (Marble)', 'Sand and Gravel', 'Shale', 'Volcanic Tuff', 'Boulders', 'Marine Aggregates'] as $product)
                                            <div class="flex items-center">
                                                <input type="checkbox" wire:model="permits.{{ $index }}.product" value="{{ $product }}" 
                                                    class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500">
                                                <label class="text-sm text-gray-700 ml-2">{{ $product }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error("permits.{$index}.product") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                @if ($index > 0)
                                    <div class="flex justify-end">
                                        <p wire:click="removePermit({{ $index }})"
                                        class="inline-flex items-center text-sm justify-center w-full h-8 cursor-pointer gap-3 px-5 py-3 font-medium text-gray-700 hover:text-white bg-red-300 rounded-md hover:bg-red-500 focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                            Tangalin ang permit (Remove permit)
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
                                            

                        <!-- Registrant Information -->
                        <div class="mb-6">
                            <label class="text-sm text-gray-700 font-bold" for="registrant_name">
                                Pangalan ng Nagrehistro (Name of Registrant):
                                <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="registrant_name" wire:model.live="registrantName"
                                class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                            @error('registrantName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password Fields -->                     
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="relative inline-block" x-data="{ tooltip: false }">
                                    <!-- Info Icon -->
                                    <i class="bi bi-info-circle-fill text-blue-700 cursor-pointer"
                                    @mouseenter="tooltip = true" @mouseleave="tooltip = false"></i>
                                    <div x-show="tooltip" 
                                        class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 z-10 w-auto px-4 py-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 transition-opacity duration-300"
                                        style="display: none;">
                                        <ul class="list-none space-y-2 whitespace-nowrap">
                                            <li>- At least 8 characters</li>
                                            <li>- One uppercase letter</li>
                                            <li>- One number</li>
                                            <li>- One special character</li>
                                        </ul>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <label class="text-sm text-gray-700 font-bold" for="password">
                                    Password:
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="password" id="password" wire:model.live="password"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <div class="relative inline-block" x-data="{ tooltip: false }">
                                    <!-- Info Icon -->
                                    <i class="bi bi-info-circle-fill text-blue-700 cursor-pointer"
                                    @mouseenter="tooltip = true" @mouseleave="tooltip = false"></i>
                                    <div x-show="tooltip" 
                                        class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 z-10 w-auto px-4 py-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 transition-opacity duration-300"
                                        style="display: none;">
                                        <ul class="list-none space-y-2 whitespace-nowrap">
                                            <li>- At least 8 characters</li>
                                            <li>- One uppercase letter</li>
                                            <li>- One number</li>
                                            <li>- One special character</li>
                                        </ul>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <label class="text-sm text-gray-700 font-bold" for="c_password">
                                    Confirm Password:
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="password" id="c_password" wire:model.live="c_password"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('c_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                            class="inline-flex items-center justify-center w-full h-12 gap-3 px-5 py-3 font-medium text-white bg-blue-700 rounded-xl hover:bg-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            <span wire:loading.remove wire:target="submit">Submit</span>
                            <span wire:loading wire:target="submit">Loading...</span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Modal -->
                <div x-data="{ showModal: @entangle('showModal') }">
                    <div x-show="showModal" 
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90">
                         
                        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-full sm:w-4/5 md:w-2/3 lg:w-1/2 xl:w-1/3 text-center">
                            <h2 class="text-3xl font-semibold mb-6">Congratulations!</h2>
                            <p class="mb-6">Your registration was successful. You can now log in.</p>
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-6 py-3 text-white bg-blue-700 rounded-lg hover:bg-blue-500">
                                Go to Login
                            </a>
                        </div>
                    </div>
                </div>
                               
            </div>
        </div>
    </section>
    
</div>