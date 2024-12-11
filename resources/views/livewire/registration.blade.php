<div>
    <section class="px-2 py-12 mx-auto md:px-12 lg:px-32 max-w-7xl">
        <div class="max-w-lg mx-auto md:max-w-xl md:w-full">
            <div class="flex flex-col text-center">
                <h1 class="text-3xl font-semibold tracking-tight text-gray-900">Registration Form</h1>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('message') }} Please Login <a clase="text-color-blue"
                            href="{{ route('login') }}">Here</a></span>
                </div>
            @endif

            <div class="p-2 mt-8 border bg-gray-50 rounded-3xl">
                <div class="p-4 md:p-10 bg-white border shadow-lg rounded-2xl">
                    <form wire:submit.prevent="submit">
                        <div class="gap-6 lg:columns-2 sm:columns-1">
                            <div class="mb-6">
                                <label class="text-sm text-gray-700 font-bold" for="firstname">
                                    Firstname
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="firstname" wire:model.live="firstname"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('firstname')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="text-sm text-gray-700 font-bold" for="lastname">
                                    Lastname
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="lastname" wire:model.live="lastname"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('lastname')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="gap-6 lg:columns-2 sm:columns-1">
                            <div class="mb-6">
                                <label class="text-sm text-gray-700 font-bold" for="middlename">
                                    Middlename
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="middlename" wire:model.live="middlename"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('middlename')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="text-sm text-gray-700 font-bold" for="address">
                                    Address
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="address" wire:model.live="address"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6 grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-sm text-gray-700 font-bold" for="email">
                                    Email Address:
                                    <span class="text-red-600">*</span>
                                </label>
                                <input type="email" id="email" wire:model.live="email"
                                    class="w-full h-12 px-4 py-2 text-black border rounded-lg appearance-none bg-chalk border-zinc-300 placeholder-zinc-300 focus:border-zinc-300 focus:outline-none focus:ring-zinc-300 sm:text-sm">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
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
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
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
                                @error('c_password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
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
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

                        <div
                            class="bg-white p-8 rounded-lg shadow-lg w-full max-w-full sm:w-4/5 md:w-2/3 lg:w-1/2 xl:w-1/3 text-center">
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
