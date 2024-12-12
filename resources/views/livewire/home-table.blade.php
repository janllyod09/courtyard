<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" x-data="{
    selectedTab: '',
    init() {
        Livewire.on('formSubmitted', () => {
            // Reload the page
            window.location.reload();
        });
    }
}">


    <div id="clock" class="text-lg font-semibold mb-4 text-gray-400 dark:text-gray-500 h-10 text-center">
        <!-- Time will be displayed here -->
    </div>

    <div class="w-full flex justify-center">
        <div class="flex justify-center w-full">
            <div class="w-full bg-white rounded-2xl p3 sm:p-8 shadow dark:bg-gray-800 overflow-x-visible">
                <div class="pb-4 pt-4 sm:pt-1">
                    <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white">CERTIFICATE OF CANDIDACY -
                        HACMAI ELECTION 2025</h1>
                </div>

                <div class="flex flex md:flex-row items-center justify-start">
                    <div class="flex items-center mb-4 md:mb-0">
                        <button wire:click="openForm"
                            class="text-sm mt-4 sm:mt-1 px-2 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none dark:bg-gray-700 w-full dark:hover:bg-green-600 dark:text-gray-300 dark:hover:text-white">
                            Fillup Form
                        </button>
                    </div>
                    <div class="flex items-center mb-4 md:mb-0 ml-4">
                        <button wire:click="openUpload"
                            class="text-sm mt-4 sm:mt-1 px-2 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none dark:bg-gray-700 w-full dark:hover:bg-green-600 dark:text-gray-300 dark:hover:text-white">
                            Upload File
                        </button>
                    </div>
                </div>

                <div x-data="" class="flex flex-col">
                    <!-- Table for Leave Applications -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl">
                                <tr class="whitespace-nowrap">
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Name</th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Address</th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Position</th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Qualification
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Property Title
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        HOA Due Certificate
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Special Power of Attorney
                                    </th>
                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                        Uploaded File
                                    </th>
                                    <th
                                        class="px-5 py-3 text-gray-100 text-sm font-medium text-center sticky top-0 right-0 z-10 bg-gray-600 dark:bg-gray-600 uppercase">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (Auth::user() ? [$users->where('id', Auth::user()->id)->first()] : [] as $user)
                                    <tr class="border-b dark:border-gray-700 whitespace-nowrap">
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            {{ $user->lastname }}, {{ $user->firstname }} {{ $user->middlename }}
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            {{ $user->address }}
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            {{ $user->position ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            @if ($user->qualification)
                                                <ul class="list-disc list-inside">
                                                    @foreach (explode(',', $user->qualification) as $qualification)
                                                        <li>{{ trim($qualification) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            @if ($user->property_title_path)
                                                <a href="{{ Storage::disk('public')->url($user->property_title_path) }}"
                                                    target="_blank"
                                                    class="text-sky-800 dark:text-sky-600 hover:underline">
                                                    {{ $user->property_title_name }}
                                                </a>
                                            @else
                                                <span class="text-gray-500">Not uploaded</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            @if ($user->hoa_due_certificate_path)
                                                <a href="{{ Storage::url($user->hoa_due_certificate_path) }}"
                                                    target="_blank"
                                                    class="text-sky-800 dark:text-sky-600 hover:underline">
                                                    HOA Due Certificate
                                                </a>
                                            @else
                                                <span class="text-gray-500">Not uploaded</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            @if ($user->special_power_of_attorney_path)
                                                <a href="{{ Storage::url($user->special_power_of_attorney_path) }}"
                                                    target="_blank"
                                                    class="text-sky-800 dark:text-sky-600 hover:underline">
                                                    Special Power of Attorney
                                                </a>
                                            @else
                                                <span class="text-gray-500">Not uploaded</span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                            @if (auth()->user()->upload_file_path)
                                                <a href="{{ Storage::url(auth()->user()->upload_file_path) }}"
                                                    target="_blank"
                                                    class="text-sky-800 dark:text-sky-600 hover:underline">
                                                    Uploaded File
                                                </a>
                                            @else
                                                <span class="text-gray-500">Not uploaded</span>
                                            @endif
                                        </td>

                                        <td
                                            class="px-5 py-4 text-sm font-medium text-center whitespace-nowrap sticky right-0 z-10 bg-white dark:bg-gray-800">
                                            @if (Auth::user() && Auth::user()->id == $user->id)
                                                <!-- Check if the logged-in user is the same as the user -->
                                                <button wire:click="exportForm({{ $user->id }})"
                                                    class="sm:mt-0 inline-flex items-center
                                                    justify-center px-4 py-1.5 text-sm font-medium tracking-wide
                                                    text-neutral-800 dark:text-neutral-200 transition-colors duration-200"
                                                    type="button" title="Export Form">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            @else
                                                <!-- Optionally, display something else if it's not the logged-in user -->
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-5 py-3 text-sm text-center text-gray-800 dark:text-gray-200">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal id="fillUpForm" maxWidth="xl" wire:model="fillUpForm">
            <div class="p-4">
                <div class="bg-slate-800 rounded-t-lg dark:bg-gray-200 p-4 text-gray-50 dark:text-slate-900 font-bold">
                    Basic Information
                </div>

                <div class="border p-4">
                    <form>
                        <div class="gap-4">
                            <div class="gap-2 columns-1 w-full">
                                <label for="fullname"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-100">Fullname</label>
                                <input type="text" id="fullname" wire:model.live='fullname' disabled
                                    class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                            </div>

                            <div class="gap-2 columns-1 mt-2">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-100">Address</label>
                                <input type="text" id="address" wire:model.live="address" disabled
                                    class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                @error('address')
                                    <span class="text-red-500 text-sm">This field is
                                        required!</span>
                                @enderror
                            </div>

                            <div class="gap-2 lg:columns-1 sm:columns-1 mt-2">
                                <!-- Position Dropdown -->
                                <label for="position"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-100">Position</label>
                                <select id="position" wire:model="position"
                                    class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                    <option value="">Select a position</option>
                                    <option value="President">President</option>
                                    <option value="Vice President">Vice President</option>
                                    <option value="Secretary">Secretary</option>
                                    <option value="Treasurer">Treasurer</option>
                                    <option value="Auditor">Auditor</option>
                                    <option value="Board of Director (1 of 3 Slots)">Board of Director (1 of 3 Slots)
                                    </option>
                                </select>
                                @error('position')
                                    <span class="text-red-500 text-sm">This field is required!</span>
                                @enderror
                            </div>

                            <div class="gap-2 lg:columns-1 sm:columns-1 mt-2">
                                <!-- Qualification Checkboxes -->
                                <label for="qualification"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-100">Qualifications</label>
                                <div
                                    class="mt-1 p-2 block shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                    <label class="block">
                                        <input type="checkbox" value="Must be of legal age"
                                            wire:model="qualification">
                                        Must be of legal age
                                    </label>
                                    <label class="block">
                                        <input type="checkbox" value="Must be in good standing"
                                            wire:model="qualification">
                                        Must be in good standing
                                    </label>
                                    <label class="block">
                                        <input type="checkbox"
                                            value="Must be an actual resident of Courtyard of Maia Alta for at least six (6) months as certified by the association secretary"
                                            wire:model="qualification">
                                        Must be an actual resident of Courtyard of Maia Alta for at least six (6) months
                                        as certified by the association secretary
                                    </label>
                                    <label class="block">
                                        <input type="checkbox"
                                            value="Has not been convicted by final judgement of an offense involving moral turpitude"
                                            wire:model="qualification">
                                        Has not been convicted by final judgement of an offense involving moral
                                        turpitude
                                    </label>
                                    <label class="block">
                                        <input type="checkbox"
                                            value="Legitimate Spouse of a member may be a candidate in lieu of the member - in accordance with the provisions of Rule 9 of Implementing Rules and Regulations of Magna Carta for Homeowners and Homeowners Associations"
                                            wire:model="qualification">
                                        Legitimate Spouse of a member may be a candidate in lieu of the member - in
                                        accordance with the provisions of Rule 9 of Implementing Rules and Regulations
                                        of Magna Carta for Homeowners and Homeowners Associations
                                    </label>
                                </div>
                                @error('qualification')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-gray-800 dark:bg-gray-200 p-2 text-white flex justify-center rounded-b-lg border">
                    <button wire:click="submit" role="status"
                        class="btn bg-emerald-200 dark:bg-emerald-500 hover:bg-emerald-600 text-gray-800 dark:text-white whitespace-nowrap mx-2">
                        Submit
                    </button>
                    <button wire:click="closeForm" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded mx-2">
                        Close
                    </button>
                </div>
            </div>
        </x-modal>

        <x-modal id="uploadFile" maxWidth="xl" centered wire:model="uploadFile">
            <div class="p-4">
                <div class="bg-slate-800 rounded-t-lg dark:bg-gray-200 p-4 text-gray-50 dark:text-slate-900 font-bold">
                    File Upload
                </div>

                {{-- Form fields --}}
                <div class="border p-4 flex flex-col gap-6">
                    <!-- File Upload Field -->
                    <div class="flex flex-col">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileUpload">
                            Upload the Signed Certificate of Candidacy file
                        </label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            wire:model="file" id="fileUpload" type="file">

                        <button type="button" wire:click="removeFileUpload"
                            class="mt-2 text-red-600 hover:underline">
                            Remove File
                        </button>

                        @error('file')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Form fields --}}
                <div class="border p-4 flex flex-col gap-6 mb-4">
                    <!-- Property Title -->
                    <div class="flex flex-col">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="property_title">
                            Property Title
                        </label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            wire:model="files.property_title" id="property_title" type="file">
                        @if (Auth::user()->property_title_path)
                            <button type="button" wire:click="removeFile('property_title')">Remove</button>
                        @endif
                        @error('files.property_title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Updated HOA Due Certificate -->
                    <div class="flex flex-col">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="hoa_due_certificate">
                            Updated HOA Due Certificate
                        </label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            wire:model="files.hoa_due_certificate" id="hoa_due_certificate" type="file">
                        @if (Auth::user()->hoa_due_certificate_path)
                            <button type="button" wire:click="removeFile('hoa_due_certificate')">Remove</button>
                        @endif
                        @error('files.hoa_due_certificate')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Special Power of Attorney -->
                    <div class="flex flex-col">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="special_power_of_attorney">
                            Special Power of Attorney for Non-Owner/Care Taker
                        </label>
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            wire:model="files.special_power_of_attorney" id="special_power_of_attorney"
                            type="file">
                        @if (Auth::user()->special_power_of_attorney_path)
                            <button type="button"
                                wire:click="removeFile('special_power_of_attorney')">Remove</button>
                        @endif
                        @error('files.special_power_of_attorney')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="bg-gray-800 dark:bg-gray-200 p-2 text-white flex justify-center rounded-b-lg border">
                    <button wire:click="submitFile" wire:loading.attr="disabled" wire:target="submitFile"
                        class="btn bg-emerald-200 dark:bg-emerald-500 hover:bg-emerald-600 text-gray-800 dark:text-white whitespace-nowrap mx-2">
                        Submit
                        <div wire:loading wire:target="submitFile" class="ml-2 spinner-border text-white"
                            role="status">
                            <span class="sr-only">Submitting...</span>
                        </div>
                    </button>
                    <button wire:click="closeUpload" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded mx-2">
                        Close
                    </button>
                </div>
            </div>
        </x-modal>

    </div>
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
