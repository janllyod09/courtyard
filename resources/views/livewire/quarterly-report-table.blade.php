<div class="w-full"
x-data="{ 
    selectedTab: '',
    init() { 
        Livewire.on('formSubmitted', () => {
            // Reload the page
            window.location.reload();
        });
    } 
}" 
x-cloak
>

    <style>
        .scrollbar-thin1::-webkit-scrollbar {
                       width: 5px;
                   }

       .scrollbar-thin1::-webkit-scrollbar-thumb {
           background-color: #1a1a1a4b;
           /* cursor: grab; */
           border-radius: 0 50px 50px 0;
       }

       .scrollbar-thin1::-webkit-scrollbar-track {
           background-color: #ffffff23;
           border-radius: 0 50px 50px 0;
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

           .quarterData{
                widows: 100%;
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

       .quarterData{
            width: 400px;
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
       @media (min-width: 768px){
           .customdiv{
                padding: 11px 0;
           }
       }
   </style>

    <div class="flex justify-center w-full">
        <div class="w-full bg-white rounded-2xl p3 sm:p-8 shadow dark:bg-gray-800 overflow-x-visible relative">
            <div class="pb-4 mb-3">
                <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white mt-6 sm:mt-0">
                    Quarterly Emergency Drill Reports
                </h1>
            </div>

            <div class="mb-6 flex flex-col sm:flex-row items-end justify-start items-left sm:justify-between px-4 sm:px-0">

                 <!-- Select Year -->
                <div class="w-full mr-0 sm:mr-4 relative">
                    <label for="year" class="absolute bottom-10 block text-sm font-medium text-gray-700 dark:text-slate-400">Search Year</label>
                    <input type="number" id="year" wire:model.live='year'
                        min="1900" max="{{ date('Y') }}" step="1"
                        class="mb-0 mt-1 px-2 py-1.5 block w-36 shadow-sm sm:text-sm border border-gray-400 hover:bg-gray-300 rounded-md 
                                dark:hover:bg-slate-600 dark:border-slate-600
                                dark:text-gray-300 dark:bg-gray-800 sm:mb-0">
                </div>

                <div class="w-full sm:w-2/3 flex flex-col sm:flex-row sm:justify-end sm:space-x-4">
                    <div class="w-full sm:w-auto">
                        <button wire:click='toggleCreateReport' 
                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-green-500 text-white rounded-md text-sm
                            hover:bg-green-600 focus:outline-none dark:bg-gray-700 w-full
                            dark:hover:bg-green-600 dark:text-gray-300 dark:hover:text-white">
                            Create Report
                        </button>
                    </div>
                </div>

            </div>

            <!-- Table -->
            <div class="flex flex-col p-3">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block w-full py-2 align-middle">
                        <div class="overflow-hidden border dark:border-gray-700 rounded-lg">
                            <div class="overflow-x-auto">

                                <table class="w-full min-w-full">
                                    <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl text-xs">
                                        <tr class="whitespace-nowrap">
                                            <th scope="col" class="px-5 py-3 font-medium text-left uppercase">Year</th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">1st Quarter</th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">2nd Quarter</th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">3rd Quarter</th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">4th Quarter</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-200 dark:divide-gray-400 text-sm">
                                        @forelse ($years as $yearItem)
                                            <tr class="text-neutral-800 dark:text-neutral-200">
                                                <td class="px-5 py-4 text-left font-medium whitespace-nowrap">
                                                    {{ $yearItem->year }}
                                                </td>
                                                @for ($quarter = 1; $quarter <= 4; $quarter++)
                                                    <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                        @if (isset($reports[$yearItem->year][$quarter]))
                                                            @php
                                                                $report = $reports[$yearItem->year][$quarter]->first();
                                                            @endphp
                                                            <span class="text-gray-700 dark:text-gray-100">
                                                                {{ $report->type_of_emergency_drill }}
                                                            </span>
                                                            <div>
                                                                <i class="bi bi-eye-fill text-sm text-blue-500 cursor-pointer" title="View" wire:click='viewReport({{ $report->id }})'></i>
                                                                {{-- <i class="bi bi-file-earmark-arrow-down-fill text-sm text-green-500 cursor-pointer" title="Export"></i> --}}
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400 dark:text-gray-500">No Report</span> 
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>

                                @if ($years->isEmpty())
                                    <div class="p-4 text-center text-gray-500 dark:text-gray-300">
                                        No records!
                                    </div> 
                                @endif
                            </div>
                            <div class="p-5 text-neutral-500 dark:text-neutral-200 bg-gray-200 dark:bg-gray-700">
                                {{ $years->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>

    {{-- View Report Modal --}}
    <x-modal id="view" maxWidth="2xl" wire:model="viewThisReport" centered>
        <div class="p-4">
            <div class="bg-slate-800 rounded-t-lg mb-4 dark:bg-gray-200 p-4 text-gray-50 dark:text-slate-900 font-bold">
                Emergency Drill Report for {{ $year }} 
                @if($yearQuarter == 1)
                    1st Quarter
                @elseif($yearQuarter == 2)
                    2nd Quarter
                @elseif($yearQuarter == 3)
                    3rd Quarter
                @elseif($yearQuarter == 4)
                    4th Quarter
                @endif
                <button @click="show = false" class="float-right focus:outline-none" wire:click='resetVariables'>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4">

                <div class="col-span-1">
                    <label for="drill" class="text-sm block text-sm font-medium text-gray-700 dark:text-slate-400">Uri (Type of Emergency Drill Conducted)</label>
                    <p class="mt-1 block w-full dark:text-gray-100">{{ $drill }}</p>
                </div>

                <div class="col-span-1">
                    <label for="reportFile" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Report (PDF)</label>
                    @if($reportFile)
                        @php
                            $filePath = $reportFile;
                            $fileName = basename($filePath);
                        @endphp
                        
                        <div class="flex items-center justify-center space-x-2">
                            <span class="mt-1 block w-full dark:text-gray-100">{{ $fileName }}</span>
                            <button wire:click="downloadFile('{{ $filePath }}')" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" title="Download">
                                    <i class="bi bi-download" style="padding-right: 2px" wire:loading.remove wire:target="downloadFile('{{ $filePath }}')"></i>
                                    <div wire:loading wire:target="downloadFile('{{ $filePath }}')">
                                        <div class="spinner-border small text-primary" role="status">
                                        </div>
                                    </div>
                            </button>
                        </div>
                    @else
                        No file uploaded
                    @endif
                </div>

                <div class="col-span-1">
                    <label for="dateUploaded" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Petsa (Date Uploaded)</label>
                    <p class="mt-1 block w-full dark:text-gray-100">{{ $dateUploaded }}</p>
                </div>

                {{-- Save and Cancel buttons --}}
                <div class="mt-4 flex justify-end col-span-1 text-sm">
                    <button class="mr-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" wire:click='toggleEditReport({{ $reportId }})'>
                        <span>Edit</span>
                    </button>
                    <button class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click='toggleDelete({{ $reportId }})'>
                        <span>Delete</span>
                    </button>
                    {{-- <button class="mr-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" wire:click='exportReport'>
                        <div wire:loading wire:target="exportReport" style="margin-bottom: 5px;">
                            <div class="spinner-border small text-primary" role="status">
                            </div>
                        </div>
                        <span wire:loading.remove wire:target="exportReport">Export</span>
                    </button> --}}
                    <p @click="show = false" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded cursor-pointer" wire:click='resetVariables'>
                        Close
                    </p>
                </div>

            </div>
        </div>
    </x-modal>

    {{-- Quarterly Report Add and Edit Modal --}}
    <x-modal id="reportModal" maxWidth="2xl" wire:model="editReport" centered>
        <div class="p-4">
            <div class="bg-slate-800 rounded-t-lg mb-4 dark:bg-gray-200 p-4 text-gray-50 dark:text-slate-900 font-bold">
                {{ $addReport ? 'Create' : 'Edit' }} Emergency Drill Report
                <button @click="show = false" class="float-right focus:outline-none" wire:click='resetVariables'>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Form fields --}}
            <form wire:submit.prevent='saveReport'>
                <div class="grid grid-cols-2 gap-4">

                    <div class="col-span-2 sm:col-span-1">
                        <label for="yearReport" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Year <span class="text-red-500">*</span></label>
                        <input type="number" id="yearReport" wire:model='yearReport' 
                        min="1900" max="{{ date('Y') }}" step="1"
                        class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                        @error('yearReport')
                            <span class="text-red-500 text-sm">The year is required!</span>
                        @enderror
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="yearQuarter" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Reporting for Quarter <span class="text-red-500">*</span></label>
                        <select name="yearQuarter" id="yearQuarter" wire:model='yearQuarter' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                            <option value="">Select Quarter</option>
                            <option value="1">1st Quarter</option>
                            <option value="2">2nd Quarter</option>
                            <option value="3">3rd Quarter</option>
                            <option value="4">4th Quarter</option>
                        </select>
                        @error('yearQuarter')
                            <span class="text-red-500 text-sm">The quarter is required!</span>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="drill" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Uri (Type of Emergency Drill Conducted) <span class="text-red-500">*</span></label>
                        <select name="drill" id="drill" wire:model.live='drill' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                            <option value="">Select a Drill</option>
                            <option value="Fire Drill">Fire Drill</option>
                            <option value="Earthquake Drill">Earthquake Drill</option>
                            <option value="Medical Emergency Drill">Medical Emergency Drill</option>
                            <option value="Evacuation Drill">Evacuation Drill</option>
                            <option value="Severe Weather Drill">Severe Weather Drill</option>
                            <option value="Chemical Spill or Hazardous Material Drills">Chemical Spill or Hazardous Material Drills</option>
                            <option value="Bomb Threat Drill">Bomb Threat Drill</option>
                            <option value="Others">Others</option>
                        </select>
                        @error('drill')
                            <span class="text-red-500 text-sm">The emergency drill is required!</span>
                        @enderror
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="reportFile" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Report (PDF) <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="reportFile" wire:model="reportFile" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700" accept="application/pdf">

                        @error('reportFile')
                            <span class="text-red-500 text-sm">The report file is required!</span>
                        @enderror
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="dateUploaded" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Petsa (Date Uploaded) <span class="text-red-500">*</span></label>
                        <input type="text" id="dateUploaded" wire:model.live='dateUploaded' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700" readonly>
                        @error('dateUploaded')
                            <span class="text-red-500 text-sm">The date is required!</span>
                        @enderror
                    </div>

                    {{-- Save and Cancel buttons --}}
                    <div class="mt-4 flex justify-end col-span-2 sm:col-span-2 text-sm">
                        <button class="mr-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <div wire:loading wire:target="saveReport" style="margin-bottom: 5px;">
                                <div class="spinner-border small text-primary" role="status">
                                </div>
                            </div>
                            Save
                        </button>
                        <p @click="show = false" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded cursor-pointer" wire:click='resetVariables'>
                            Cancel
                        </p>
                    </div>

                </div>
            </form>

        </div>
    </x-modal>

    {{-- Delete Modal --}}
    <x-modal id="deleteModal" maxWidth="md" wire:model="deleteId" centered>
        <div class="p-4">
            <div class="mb-4 text-slate-900 dark:text-gray-100 font-bold">
                Confirm Deletion
                <button @click="show = false" class="float-right focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                Are you sure you want to delete this report?
            </label>
            <form wire:submit.prevent='deleteData'>
                <div class="mt-4 flex justify-end col-span-1 sm:col-span-1">
                    <button class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <div wire:loading wire:target="deleteData" style="margin-bottom: 5px;">
                            <div class="spinner-border small text-primary" role="status">
                            </div>
                        </div>
                        Delete
                    </button>
                    <p @click="show = false" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                        Cancel
                    </p>
                </div>
            </form>

        </div>
    </x-modal>

</div>
