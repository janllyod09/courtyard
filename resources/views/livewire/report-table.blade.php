<div class="w-full"
x-data="{ 
    selectedSubTab: 'nlta',
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
       @media (min-width: 768px){
           .customdiv{
                padding: 11px 0;
           }
       }
   </style>

    <div class="flex justify-center w-full">
        <div class="w-full bg-white rounded-2xl p3 sm:p-8 shadow dark:bg-gray-800 overflow-x-visible relative">
            <div class="pb-4 mb-3">
                <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white {{ $create ? 'hidden' : '' }}">
                    Monthly Safety and Health Reports
                </h1>
                <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white {{ $create ? '' : 'hidden' }}">
                    Create Safety and Health Report
                </h1>
                <button wire:click='toggleCreateReport' 
                    class="absolute top-2 right-2 text-black dark:text-white whitespace-nowrap mx-2 {{ $create ? '' : 'hidden' }}">
                    <i class="bi bi-x-circle" title="Cancel"></i>
                </button>
            </div>

            <div class="mb-6 flex flex-col sm:flex-row items-end justify-between">

                 <!-- Select Date -->
                 <div class="mr-0 sm:mr-4 relative {{ $create ? 'hidden' : '' }}">
                    <label for="date" class="absolute bottom-10 block text-sm font-medium text-gray-700 dark:text-slate-400">Select Month</label>
                    <input type="month" id="date" wire:model.live='date'
                    class="mb-0 mt-1 px-2 py-1.5 block w-full shadow-sm sm:text-sm border border-gray-400 hover:bg-gray-300 rounded-md 
                        dark:hover:bg-slate-600 dark:border-slate-600
                        dark:text-gray-300 dark:bg-gray-800 mb-4 sm:mb-0">
                </div>

                <div class="w-full sm:w-2/3 flex flex-col sm:flex-row sm:justify-end sm:space-x-4 {{ $create ? 'hidden' : '' }}">
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
                        <div class="overflow-hidden border dark:border-gray-700 rounded-lg {{ $create ? 'hidden' : '' }}">
                            <div class="overflow-x-auto">

                                <table class="w-full min-w-full">
                                    <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl text-xs">
                                        <tr class="whitespace-nowrap">
                                            <th scope="col" class="px-5 py-3 font-medium text-left uppercase">
                                                Month
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-left uppercase">
                                                Date Encoded
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Non-Lost Time Accident
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Lost Time Accident (Non-Fatal)
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Lost Time Accident (Fatal)
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Days Lost
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Manhours Worked
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Number of Employees
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Minutes of CSHC Meetings
                                            </th>
                                            <th scope="col" class="px-5 py-3 font-medium text-center uppercase">
                                                Status
                                            </th>
                                            <th class="px-5 py-3 text-gray-100 font-medium text-center uppercase sticky right-0 z-10 bg-gray-600 dark:bg-gray-600">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-200 dark:divide-gray-400 text-xs">
                                        @foreach ($reports as $report)
                                            <tr class="text-neutral-800 dark:text-neutral-200">
                                                <td class="px-5 py-4 text-left font-medium whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($report->month)->format('F') }}, {{ \Carbon\Carbon::parse($report->month)->format('Y') }}
                                                </td>
                                                <td class="px-5 py-4 text-left font-medium whitespace-nowrap">
                                                    {{ $report->date_encoded }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    {{ $report->non_lost_time_accident }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    {{ $report->non_fatal_lost_time_accident }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    {{ $report->fatal_lost_time_accident }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    {{ $report->days_lost }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    {{ $report->man_hours }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    {{ $report->male_workers + $report->female_workers }}
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    @if($report->minutes)
                                                        @php
                                                            $filePath = $report->minutes;
                                                            $fileName = basename($filePath);
                                                        @endphp
                                                        
                                                        <div class="flex items-center justify-center space-x-2">
                                                            <span>{{ $fileName }}</span>
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
                                                </td>
                                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap">
                                                    @if($report->status)
                                                        <span class="text-xs text-white bg-green-500 rounded-lg py-1.5 px-4">Approved</span>
                                                    @else
                                                        <span class="text-xs text-white bg-orange-500 rounded-lg py-1.5 px-4">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-4 font-medium text-center whitespace-nowrap sticky right-0 z-10 bg-white dark:bg-gray-800">
                                                    <div class="relative">
                                                        @if(!$report->status)
                                                            <button wire:click="toggleEditReport({{ $report->id }})" 
                                                                class="peer inline-flex items-center justify-center px-4 py-2 -m-5 
                                                                -mr-2 font-medium tracking-wide text-blue-500 hover:text-blue-600 
                                                                focus:outline-none" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                            <button wire:click="toggleDelete({{ $report->id }})" 
                                                                class=" text-red-600 hover:text-red-900 dark:text-red-600 
                                                                dark:hover:text-red-900" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                        <button wire:click="exportReport({{ $report->id }})" 
                                                            class="peer inline-flex items-center justify-center px-4 py-2 -m-5 -mr-2 
                                                            text-sm font-medium tracking-wide text-green-500 hover:text-green-600 focus:outline-none"
                                                            title="Export Report">
                                                            <img class="flex dark:hidden ml-3 mt-4" src="/images/icons8-xls-export-dark.png" width="18" alt="" wire:target="exportReport({{ $report->id }})"  wire:loading.remove>
                                                            <img class="hidden dark:block ml-3 mt-4" src="/images/icons8-xls-export-light.png" width="18" alt="" wire:target="exportReport({{ $report->id }})" wire:loading.remove>
                                                            <div wire:loading wire:target="exportReport({{ $report->id }})">
                                                                <div class="mt-4 ml-3 spinner-border small text-primary" role="status">
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($reports->isEmpty())
                                    <div class="p-4 text-center text-gray-500 dark:text-gray-300">
                                        No records!
                                    </div> 
                                @endif
                           
                            </div>
                            <div class="p-5 text-neutral-500 dark:text-neutral-200 bg-gray-200 dark:bg-gray-700">
                                {{ $reports->links() }}
                            </div>
                         </div>
                        <div class="overflow-hidden border dark:border-gray-700 rounded-lg {{ $create ? '' : 'hidden' }}">
                            <div x-data="{ currentStep: @entangle('currentStep'), totalSteps: 4 }">
                                <div class="w-full bg-gray-200 h-2.5 dark:bg-gray-700">
                                    <div 
                                        class="bg-blue-600 h-2.5 transition-all duration-300 ease-in-out" 
                                        :style="{ width: `${(currentStep / totalSteps) * 100}%` }"
                                    ></div>
                                </div>
                            </div>
                            <div class="overflow-x-auto p-4">

                                <div class="{{ $currentStep === 1 ? '' : 'hidden' }}">
                                    <p class="text-sm">Step {{ $currentStep }} of 4</p>

                                    <div class="grid grid-cols-3 gap-4 mt-6">
                                        <div class="col-span-full sm:col-span-1">
                                            <label for="encoder" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Encoder</label>
                                            <input type="text" id="encoder" wire:model='encoder' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" readonly>
                                        </div>
                                        <div class="col-span-full sm:col-span-1">
                                            <label for="company" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Company</label>
                                            <input type="text" id="company" wire:model='company' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" readonly>
                                        </div>
                                        <div class="col-span-full sm:col-span-1">
                                            <label for="permitNumber" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Permit Number</label>
                                            <input type="text" id="permitNumber" wire:model='permitNumber' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" readonly>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <p class="font-bold text-sm text-gray-800 dark:text-gray-100">PAUNAWA: (Chapter XIX of The Philippine Mining Act of 1995)</p>
                                        <p class="text-wrap text-sm text-gray-800 dark:text-gray-100">"Sinumang tao na naghaharap ng anumang palsong aplikasyon, pahayag, o ebidensya sa pamahalaan o nag-iiwan o 
                                            sadyang nagbibigay ng palsong pahayag na nauugnay sa mga mina, operasyon sa pagmimina, o 
                                            kasunduan sa mineral, mga kasunduan sa pananalapi o teknikal na tulong, at mga permit, 
                                            kapag nahatulan, ay parurusahan ng multa na hindi lalampas sa sampung libong piso."</p>
                                        <p class="text-wrap text-sm mt-4 text-gray-800 dark:text-gray-100">“Any person who knowingly presents any false application, declaration, or evidence to the 
                                            government or publishes or causes to be published any prospectus or other information 
                                            containing false statement relating to mines, mining operations or mineral agreements, 
                                            financial or technical assistance agreements, and permits shall, upon conviction, 
                                            be penalized by a fine of not exceeding ten thousand pesos.”</p>
                                    </div>       
                                    
                                    <div class="grid grid-cols-2 gap-4 mt-8">
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="month" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Safety and Health Reports para sa buwan ng (month of) <span class="text-red-500">*</span></label>
                                            <input type="month" id="month" wire:model='month' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                            @error('month')
                                                <span class="text-red-500 text-sm">The month is required!</span>
                                            @enderror
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="manHours" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang ng oras paggawa (Manhours Worked) <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" id="manHours" wire:model='manHours' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                            @error('manHours')
                                                <span class="text-red-500 text-sm">The manhours is required!</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mt-8 mb-8">
                                        <div class="col-span-2 sm:col-span-1 grid grid-cols-2 gap-4">
                                            <div class="col-span-2 sm:col-span-1">
                                                <label for="maleWorkers" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang ng Empleyado (Manpower)</label>
                                                <label for="maleWorkers" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Lalake (Male) <span class="text-red-500">*</span></label>
                                                <input type="number" id="maleWorkers" wire:model='maleWorkers' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                                @error('maleWorkers')
                                                    <span class="text-red-500 text-sm">The count of male manpower is required!</span>
                                                @enderror
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <div class="customdiv"></div>
                                                <label for="femaleWorkers" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Babae (Female) <span class="text-red-500">*</span></label>
                                                <input type="number" id="femaleWorkers" wire:model='femaleWorkers' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                                @error('femaleWorkers')
                                                    <span class="text-red-500 text-sm">The count of female manpower is required!</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <div class="customdiv"></div>
                                            <label for="serviceContractors" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang ng Service Contractors <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" id="serviceContractors" wire:model='serviceContractors' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                            @error('serviceContractors')
                                                <span class="text-red-500 text-sm">The count of service contractor is required!</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="w-full flex justify-end items-center">
                                        <button wire:click='nextStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            Next >>
                                        </button>
                                    </div>
                                </div>

                                <div class="{{ $currentStep === 2 ? '' : 'hidden' }}">
                                    <p class="text-sm">Step {{ $currentStep }} of 4</p>

                                    <div class="flex gap-6 overflow-x-auto mb-4 pb-2">
                                        <div @click="selectedSubTab = 'nlta'" 
                                                :class="{ 'font-bold dark:text-gray-300 text-gray-800': selectedSubTab === 'nlta', 'text-slate-700 font-medium dark:text-slate-300 dark:hover:text-white hover:text-black': selectedSubTab !== 'nlta' }" 
                                                class="h-min py-2 text-sm text-nowrap sm:mr-4">
                                            <label for="nlta" 
                                            :class="{ 'text-gray-800 dark:text-gray-100': selectedSubTab === 'nlta', 'text-gray-400 dark:text-slate-400': selectedSubTab !== 'nlta' }"
                                                class="block text-sm font-medium">Non-Lost Time Accident</label>
                                            <input type="number" id="nlta" wire:model.live='nlta' class="mt-1 p-2 block shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 100px">
                                        </div>
                                        <div @click="selectedSubTab = 'nflta'" 
                                                :class="{ 'text-gray-800 dark:text-gray-100': selectedSubTab === 'nflta', 'text-gray-400 dark:text-slate-400': selectedSubTab !== 'nflta' }" 
                                                class="h-min py-2 text-sm text-nowrap sm:mr-4">
                                            <label for="nflta" 
                                                class="block text-sm font-medium">Non-Fatal Lost Time Accident</label>
                                            <div class="flex gap-2">
                                                <input type="number" id="nflta" wire:model.live='nflta' class="mt-1 p-2 block shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 100px">
                                                <input type="number" id="nfltaDaysLost" wire:model='nfltaDaysLost' class="mt-1 p-2 block shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 100px" placeholder="Days Lost">
                                            </div>
                                        </div>
                                        <div @click="selectedSubTab = 'flta'" 
                                                :class="{ 'text-gray-800 dark:text-gray-100': selectedSubTab === 'flta', 'text-gray-400 dark:text-slate-400': selectedSubTab !== 'flta' }" 
                                                class="h-min py-2 text-sm text-nowrap sm:mr-4">
                                            <label for="flta" 
                                                class="block text-sm font-medium">Fatal Lost Time Accident</label>
                                            <div class="flex gap-2">
                                                <input type="number" id="flta" wire:model.live='flta' class="mt-1 p-2 block shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 100px">
                                                <input type="number" id="fltaDaysLost" wire:model='fltaDaysLost' class="mt-1 p-2 block shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 100px" placeholder="Days Lost">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="-my-2 overflow-x-auto">
                                        <div class="inline-block w-full py-2 align-middle">
                                            <div class="overflow-visible">
                                                <div class="w-full flex justify-center items-center mb-4" x-show="selectedSubTab === 'nlta'">
                                                    <h1 class="text-gray-800 dark:text-gray-100 uppercase">Non-Lost Time Accident</h1>
                                                 </div>
                                                <div class="w-full flex justify-center items-center mb-4" x-show="selectedSubTab === 'nflta'">
                                                    <h1 class="text-gray-800 dark:text-gray-100 uppercase">Non-Fatal Lost Time Accident</h1>
                                                 </div>
                                                <div class="w-full flex justify-center items-center mb-4" x-show="selectedSubTab === 'flta'">
                                                    <h1 class="text-gray-800 dark:text-gray-100 uppercase">Fatal Lost Time Accident</h1>
                                                 </div>

                                                <div class="overflow-visible">
                                                    <div x-show="selectedSubTab === 'nlta'" class="overflow-visible"  x-data="{selectedSubTab1: '1',}" x-cloak>
                                                        <div class="flex overflow-x-auto pb-2 relative z-10">
                                                            @foreach($nltaPersons as $index => $person)
                                                                <div @click="selectedSubTab1 = '{{ $index + 1 }}'" 
                                                                        :class="{ 'font-bold dark:text-gray-300 border-b-2 border-blue-500': selectedSubTab1 === '{{ $index + 1 }}', 'text-slate-500 dark:hover:text-white hover:text-black': selectedSubTab1 !== '{{ $index + 1 }}' }" 
                                                                        class="h-min pt-2 pb-2 px-4 text-sm text-nowrap -mb-2">
                                                                        {{ $index + 1 }}
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @foreach($nltaPersons as $index => $person)
                                                            <div class="overflow-visible border dark:border-gray-700 bg-gray-50 dark:bg-slate-700 p-4 mb-8" x-show="selectedSubTab1 === '{{ $index + 1 }}'">
                                                                <h1 class="my-4 text-gray-800 dark:text-gray-100 font-bold">Person: {{ $index + 1 }}</h1>
                                                                <div class="grid grid-cols-3 gap-4 overflow-visible">

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pangalan (Name)</label>
                                                                        <input type="text" id="name" wire:model='nltaPersons.{{ $index }}.name' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.name')
                                                                            <span class="text-red-500 text-sm">The name is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Kasarian (Gender)</label>
                                                                        <select name="gender" id="gender" wire:model='nltaPersons.{{ $index }}.gender' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                            <option value="" class="text-gray-400 dark:text-gray-700">Pumili ng Kasarian (Gender)</option>
                                                                            <option value="Male">Lalake (Male)</option>
                                                                            <option value="Female">Babae (Female)</option>
                                                                        </select>
                                                                        @error('nltaPersons.' . $index . '.gender')
                                                                            <span class="text-red-500 text-sm">The gender is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Posisyon (Position)</label>
                                                                        <input type="text" id="position" wire:model='nltaPersons.{{ $index }}.position' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.position')
                                                                            <span class="text-red-500 text-sm">The position is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="dateOfAccidentIllness" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Petsa ng Aksidente/Karamdaman (Date of Accident/Illness)</label>
                                                                        <input type="date" id="dateOfAccidentIllness" wire:model='nltaPersons.{{ $index }}.dateOfAccidentIllness' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.dateOfAccidentIllness')
                                                                            <span class="text-red-500 text-sm">The date of accident/illness is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="time" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Oras (Time)</label>
                                                                        <input type="time" id="time" wire:model='nltaPersons.{{ $index }}.time' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.time')
                                                                            <span class="text-red-500 text-sm">The time is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinangyarihan (Location)</label>
                                                                        <input type="text" id="location" wire:model='nltaPersons.{{ $index }}.location' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.location')
                                                                            <span class="text-red-500 text-sm">The location is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="serviceContractor" wire:model.live='nltaPersons.{{ $index }}.serviceContractor' class="">
                                                                            <label for="serviceContractor" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Service Contractor?</label>
                                                                            @error('nltaPersons.' . $index . '.serviceContractor')
                                                                                <span class="text-red-500 text-sm">The service contractor is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <input type="text" id="company" wire:model='nltaPersons.{{ $index }}.company' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" 
                                                                            {{ $nltaPersons[$index]['serviceContractor'] ? '' : 'readonly' }} placeholder="Kumpanya (Company)">
                                                                        @error('nltaPersons.' . $index . '.company')
                                                                            <span class="text-red-500 text-sm">The company is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <div class="customdiv"></div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="physicalInjury" wire:model='nltaPersons.{{ $index }}.physicalInjury' class=" cursor-pointer">
                                                                            <label for="physicalInjury" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinsala sa katawan (Physical Injuries)</label>
                                                                            @error('nltaPersons.' . $index . '.physicalInjury')
                                                                                <span class="text-red-500 text-sm">The physical injuries is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="propertyDamage" wire:model='nltaPersons.{{ $index }}.propertyDamage' class="cursor-pointer">
                                                                            <label for="propertyDamage" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinsala sa kagamitan (Property Damage)</label>
                                                                            @error('nltaPersons.' . $index . '.propertyDamage')
                                                                                <span class="text-red-500 text-sm">The property damage is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                                                        
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="cause" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Dahilan ng Aksidente o Karamdaman (Cause of Accident/Illness)</label>
                                                                        <input type="text" id="cause" wire:model='nltaPersons.{{ $index }}.cause' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.cause')
                                                                            <span class="text-red-500 text-sm">The cause of accident/illness is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="unsafeAct" wire:model.live='nltaPersons.{{ $index }}.unsafeAct' class="cursor-pointer">
                                                                            <label for="unsafeAct" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Panganib dulot ng Kapabayaan (Unsafe Acts)</label>
                                                                            @error('nltaPersons.' . $index . '.unsafeAct')
                                                                                <span class="text-red-500 text-sm">The unsafe act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="unsafeActDescription" 
                                                                            wire:model="nltaPersons.{{ $index }}.unsafeActDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500  {{ $nltaPersons[$index]['unsafeAct'] ? '' : 'hidden' }}
                                                                            focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Ilarawan (Description)"
                                                                        ></textarea>
                                                                        @error('nltaPersons.' . $index . '.unsafeActDescription')
                                                                            <span class="text-red-500 text-sm">The unsafe act description is required!</span>
                                                                        @enderror
                                                                    </div>
                                                                                                                                                                    
                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="unsafeConditions" wire:model.live='nltaPersons.{{ $index }}.unsafeConditions' class="cursor-pointer">
                                                                            <label for="unsafeConditions" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Panganib dulot ng Sitwasyon (Unsafe Conditions)</label>
                                                                            @error('nltaPersons.' . $index . '.unsafeConditions')
                                                                                <span class="text-red-500 text-sm">The unsafe act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="unsafeConditionsDescription" 
                                                                            wire:model="nltaPersons.{{ $index }}.unsafeConditionsDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $nltaPersons[$index]['unsafeConditions'] ? '' : 'hidden' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Ilarawan (Description)"
                                                                        ></textarea>
                                                                        @error('nltaPersons.' . $index . '.unsafeConditionsDescription')
                                                                            <span class="text-red-500 text-sm">The unsafe conditions description is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full grid grid-cols-2 gap-4 mt-4 overflow-visible">

                                                                        {{-- Uri ng Aksidente (Kind of Accident) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Uri ng Aksidente (Kind of Accident)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Contact with objects and equipment</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="struct_against_object" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Tumama sa isang bagay (Struck against object)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="struct_against_object" class="ml-2 text-gray-900 dark:text-gray-300">Tumama sa isang bagay (Struck against object)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="struct_by_object" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Tinamaan ng isang bagay (Struck by object)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="struct_by_object" class="ml-2 text-gray-900 dark:text-gray-300">Tinamaan ng isang bagay (Struck by object)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-equipment" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Naipit sa makinarya o sa dalawang bagay (Caught in or crushed by equipment or objects)" class="h-4 w-4">
                                                                                        <label for="caught-equipment" class="ml-2 text-gray-900 dark:text-gray-300">Naipit sa makinarya o sa dalawang bagay (Caught in or crushed by equipment or objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-collapsing" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Naipit sa mga gumuguhong bagay (Caught in or crushed in collapsing materials)" class="h-4 w-4">
                                                                                        <label for="caught-collapsing" class="ml-2 text-gray-900 dark:text-gray-300">Naipit sa mga gumuguhong bagay (Caught in or crushed in collapsing materials)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-unspecified" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), contact" class="h-4 w-4">
                                                                                        <label for="caught-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Falls</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-lower-level" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Pagkahulog sa mas mababang lebel (Fall of a person to lower level)" class="h-4 w-4">
                                                                                        <label for="fall-lower-level" class="ml-2 text-gray-900 dark:text-gray-300">Pagkahulog sa mas mababang lebel (Fall of a person to lower level)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-same-level" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Pagkadulas (Fall of a person on the same level)" class="h-4 w-4">
                                                                                        <label for="fall-same-level" class="ml-2 text-gray-900 dark:text-gray-300">Pagkadulas (Fall of a person on the same level)</label>
                                                                                    </li>
                                                                                    
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-material" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Tinamaan ng nahuhulog na bagay (Fall of material or structures" class="h-4 w-4">
                                                                                        <label for="fall-material" class="ml-2 text-gray-900 dark:text-gray-300">Tinamaan ng nahuhulog na bagay (Fall of material or structures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-unspecified" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), falls" class="h-4 w-4">
                                                                                        <label for="fall-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Bodily Exertion</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-lifting" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa pagbuhat (Over-exertion in lifting objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-lifting" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa pagbuhat (Over-exertion in lifting objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-pushing" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa pagtulak o paghila (Over-exertion in pushing or pulling objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-pushing" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa pagtulak o paghila (Over-exertion in pushing or pulling objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-handling" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa paghawak o paghagis (Over-exertion in handling or throwing objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-handling" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa paghawak o paghagis (Over-exertion in handling or throwing objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="wrong-movements" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Maling galaw (Wrong movements)" class="h-4 w-4">
                                                                                        <label for="wrong-movements" class="ml-2 text-gray-900 dark:text-gray-300">Maling galaw (Wrong movements)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-unspecified" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), exertion" class="h-4 w-4">
                                                                                        <label for="over-exertion-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Exposure to harmful substances or environments</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="electric-current" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Nadikit sa kuryente (Contact with electric current)" class="h-4 w-4">
                                                                                        <label for="electric-current" class="ml-2 text-gray-900 dark:text-gray-300">Nadikit sa kuryente (Contact with electric current)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="extreme-temps" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Napaso (Contact or exposure to extreme temperatures)" class="h-4 w-4">
                                                                                        <label for="extreme-temps" class="ml-2 text-gray-900 dark:text-gray-300">Napaso (Contact or exposure to extreme temperatures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="weather-exposure" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Nabilad (Exposure to extreme weather conditions)"class="h-4 w-4">
                                                                                        <label for="weather-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Nabilad (Exposure to extreme weather conditions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="noise-exposure" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Malakas na ingay o tunog (Exposure to noise)" class="h-4 w-4">
                                                                                        <label for="noise-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Malakas na ingay o tunog (Exposure to noise)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="radiation-exposure" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Exposure to radiation" class="h-4 w-4">
                                                                                        <label for="radiation-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Exposure to radiation</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="oxygen-deficiency" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Hindi makahinga (Oxygen deficiency)" class="h-4 w-4">
                                                                                        <label for="oxygen-deficiency" class="ml-2 text-gray-900 dark:text-gray-300">Hindi makahinga (Oxygen deficiency)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="chemical-contact" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Nadikit sa kemikal (Contact with chemicals)" class="h-4 w-4">
                                                                                        <label for="chemical-contact" class="ml-2 text-gray-900 dark:text-gray-300">Nadikit sa kemikal (Contact with chemicals)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="exposure-unspecified" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), exposure" class="h-4 w-4">
                                                                                        <label for="exposure-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Fires and explosion</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fire-hazard" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Apoy (Fires)" class="h-4 w-4">
                                                                                        <label for="fire-hazard" class="ml-2 text-gray-900 dark:text-gray-300">Apoy (Fires)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="explosion-hazard" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Pagsabog (Explosions)" class="h-4 w-4">
                                                                                        <label for="explosion-hazard" class="ml-2 text-gray-900 dark:text-gray-300">Pagsabog (Explosions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fire-explosion-unspecified" type="checkbox" wire:model="nltaPersons.{{ $index }}.kindOfAccident" value="Hindi Matukoy (Unspecified), fire" class="h-4 w-4">
                                                                                        <label for="fire-explosion-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi Matukoy (Unspecified)</label>
                                                                                    </li>                                                                            
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Uri ng pinsala (Type of Injury) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Uri ng pinsala (Type of Injury)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li class="flex items-center">
                                                                                        <input id="contusion" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Pasa o bugbog (Contusion, bruises, hematoma)" class="h-4 w-4">
                                                                                        <label for="contusion" class="ml-2 text-gray-900 dark:text-gray-300">Pasa o bugbog (Contusion, bruises, hematoma)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="abrasions" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Gasgas (Abrasions)" class="h-4 w-4">
                                                                                        <label for="abrasions" class="ml-2 text-gray-900 dark:text-gray-300">Gasgas (Abrasions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="cuts" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Hiwa, laslas, o tusok (Cuts, lacerations, punctures)" class="h-4 w-4">
                                                                                        <label for="cuts" class="ml-2 text-gray-900 dark:text-gray-300">Hiwa, laslas, o tusok (Cuts, lacerations, punctures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="concussion" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Nabagok (Concussion)" class="h-4 w-4">
                                                                                        <label for="concussion" class="ml-2 text-gray-900 dark:text-gray-300">Nabagok (Concussion)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="avulsion" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Napilas (Avulsion)" class="h-4 w-4">
                                                                                        <label for="avulsion" class="ml-2 text-gray-900 dark:text-gray-300">Napilas (Avulsion)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="amputation" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Naputol (Amputation)" class="h-4 w-4">
                                                                                        <label for="amputation" class="ml-2 text-gray-900 dark:text-gray-300">Naputol (Amputation)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="crushing_injuries" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Napisa (Crushing injuries)" class="h-4 w-4">
                                                                                        <label for="crushing_injuries" class="ml-2 text-gray-900 dark:text-gray-300">Napisa (Crushing injuries)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="sprains" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Sprains" class="h-4 w-4">
                                                                                        <label for="sprains" class="ml-2 text-gray-900 dark:text-gray-300">Sprains</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="dislocation" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Nabalian (Dislocation/Fractures)" class="h-4 w-4">
                                                                                        <label for="dislocation" class="ml-2 text-gray-900 dark:text-gray-300">Nabalian (Dislocation/Fractures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="burn" type="checkbox" wire:model="nltaPersons.{{ $index }}.typeOfInjury" value="Nasunog (Burn)" class="h-4 w-4">
                                                                                        <label for="burn" class="ml-2 text-gray-900 dark:text-gray-300">Nasunog (Burn)</label>
                                                                                    </li>                                                                            
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Parte ng Katawan na Napinsala (Part of the Body Injured) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Parte ng Katawan na Napinsala (Part of the Body Injured)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg sm:overflow-x-hidden
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <table class="min-w-full table-auto border-collapse">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="px-4 py-2 text-left">Parte (Part)</th>
                                                                                            <th class="px-4 py-2">Left (Kaliwa)</th>
                                                                                            <th class="px-4 py-2">Right (Kanan)</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <!-- Head -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Head</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Ulo/Mukha/Sentido (Back/Face/Temple)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="head_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Ulo/Mukha/Sentido (Back/Face/Temple), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="head_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Ulo/Mukha/Sentido (Back/Face/Temple), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="eye_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="eye_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tenga/Pisngi (Ear/Cheek)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ear_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Tenga/Pisngi (Ear/Cheek), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ear_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Tenga/Pisngi (Ear/Cheek), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Ilong (Nose)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="nose_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Ilong (Nose), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="nose_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Ilong (Nose), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Bumbunan/Anit (Skull/Scalp)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="scalp_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Bumbunan/Anit (Skull/Scalp), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="scalp_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Bumbunan/Anit (Skull/Scalp), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Panga (Jaw)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="jaw_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Panga (Jaw), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="jaw_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Panga (Jaw), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Labi/Ngipin (Lip/Teeth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="lip_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Labi/Ngipin (Lip/Teeth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="lip_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Labi/Ngipin (Lip/Teeth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Leeg/Batok (Neck/Nape)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="neck_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Leeg/Batok (Neck/Nape), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="neck_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Leeg/Batok (Neck/Nape), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Trunk -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Trunk</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Likod/Gulugod (Back/Vertebra)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="back_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Likod/Gulugod (Back/Vertebra), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="back_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Likod/Gulugod (Back/Vertebra), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="chest_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="chest_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tadyang (Rib)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="rib_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Tadyang (Rib), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="rib_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Tadyang (Rib), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="buttock_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="buttock_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Collar Bone</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="collar_bone_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Collar Bone, l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="collar_bone_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Collar Bone, r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Extremities -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Extremities</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Balikat/Braso (Upper Shoulder/Arm)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shoulder_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Balikat/Braso (Upper Shoulder/Arm), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shoulder_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Balikat/Braso (Upper Shoulder/Arm), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Siko/Bisig (Elbow/Forearm)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="elbow_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Siko/Bisig (Elbow/Forearm), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="elbow_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Siko/Bisig (Elbow/Forearm), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pulso/Kamay (Wrist/Hand)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="wrist_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Pulso/Kamay (Wrist/Hand), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="wrist_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Pulso/Kamay (Wrist/Hand), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Fingers -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Fingers</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinlalaki (Thumb)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thumb_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Thumb), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thumb_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Thumb), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hintuturo (Index)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="index_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hintuturo (Index), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="index_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hintuturo (Index), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Gitna (Middle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middle_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middle_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Palasingsingan (Ring)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ring_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Palasingsingan (Ring), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ring_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Palasingsingan (Ring), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinliliit (Little)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="little_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hinliliit (Little), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="little_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hinliliit (Little), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Lower Extremities -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Lower</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hita (Thigh)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thigh_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hita (Thigh), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thigh_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hita (Thigh), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tuhod (Knee)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="knee_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Tuhod (Knee), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="knee_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Tuhod (Knee), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Binti (Leg)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shin_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Binti (Leg), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shin_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Binti (Leg), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Sakong (Ankle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ankle_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Sakong (Ankle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ankle_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Sakong (Ankle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Paa (Foot)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="foot_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Paa (Foot), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="foot_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Paa (Foot), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Toes -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Toes</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinlalaki (Big Toe)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="bigtoe_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Big Toe), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="bigtoe_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Big Toe), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pangalawa (Second)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="secondtoe_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Pangalawa (Second), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="secondtoe_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Pangalawa (Second), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Gitna (Middle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middletoe_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middletoe_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pangapat (Fourth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fourthtoe_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Pangapat (Fourth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fourthtoe_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Pangapat (Fourth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Panglima (Fifth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fifthtoe_left" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Panglima (Fifth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fifthtoe_right" type="checkbox" wire:model="nltaPersons.{{ $index }}.partOfBodyInjured" value="Panglima (Fifth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <div class="col-span-full sm:col-span-1 mt-4">
                                                                                    <label for="otherParts" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Iba pang bahagi (Others)</label>
                                                                                    <input type="text" id="otherParts" wire:model='nltaPersons.{{ $index }}.otherParts' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                                    @error('nltaPersons.' . $index . '.otherParts')
                                                                                        <span class="text-red-500 text-sm">The otherParts of accident/illness is required!</span>
                                                                                    @enderror
                                                                                </div>                                                                    
                                                                            </div>
                                                                        </div>

                                                                        {{-- Paraan ng Paggamot (Treatment) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Paraan ng Paggamot (Treatment)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li class="flex items-center">
                                                                                        <input id="rest" type="checkbox" wire:model="nltaPersons.{{ $index }}.treatment" value="Pahinga (Rest)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="rest" class="ml-2 text-gray-900 dark:text-gray-300">Pahinga (Rest)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="first_aid" type="checkbox" wire:model="nltaPersons.{{ $index }}.treatment" value="Nilapatan ng pang unang lunas (first aid)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="first_aid" class="ml-2 text-gray-900 dark:text-gray-300">Nilapatan ng pang unang lunas (first aid)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="medication" type="checkbox" wire:model="nltaPersons.{{ $index }}.treatment" value="Binigyan ng gamot (administered medication)" class="h-4 w-4">
                                                                                        <label for="medication" class="ml-2 text-gray-900 dark:text-gray-300">Binigyan ng gamot (administered medication)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="hospitalized" type="checkbox" wire:model="nltaPersons.{{ $index }}.treatment" value="Dinala sa ospital (taken to the hospital)" class="h-4 w-4">
                                                                                        <label for="hospitalized" class="ml-2 text-gray-900 dark:text-gray-300">Dinala sa ospital (taken to the hospital)</label>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="cost_of_mitigation" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Gastos ng Kumpanya sa Pagpapagamot (Cost of Mitigation)</label>
                                                                        <input type="number" step="0.01" id="cost_of_mitigation" wire:model='nltaPersons.{{ $index }}.cost_of_mitigation' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.cost_of_mitigation')
                                                                            <span class="text-red-500 text-sm">The cost of mitigation is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="cost_of_property_damage" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Gastos ng Kumpanya sa mga nasirang kagamitan (Cost of Damage to Property)</label>
                                                                        <input type="number" step="0.01" id="cost_of_property_damage" wire:model='nltaPersons.{{ $index }}.cost_of_property_damage' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nltaPersons.' . $index . '.cost_of_property_damage')
                                                                            <span class="text-red-500 text-sm">The cost of property damage is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="performingWork" wire:model.live='nltaPersons.{{ $index }}.performingWork' class="cursor-pointer">
                                                                            <label for="performingWork" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Trabaho ba niya ang ginagawa niya noong naaksidente siya (was the personnel performing routine work?)</label>
                                                                            @error('nltaPersons.' . $index . '.performingWork')
                                                                                <span class="text-red-500 text-sm">The performing routine work act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="performingWorkDescription" 
                                                                            wire:model="nltaPersons.{{ $index }}.performingWorkDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $nltaPersons[$index]['performingWork'] ? 'hidden' : '' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Kung hindi, ano ang ginagawa niya, at bakit? (If no, what was the personnel doing? And why?)"
                                                                        ></textarea>
                                                                        @error('nltaPersons.' . $index . '.performingWorkDescription')
                                                                            <span class="text-red-500 text-sm">The performing routine work description is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <label for="performingWork" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Maikling salaysay ng mga pangyayari (Brief description of the incident)</label>
                                                                        <textarea 
                                                                            id="incidentDescription" 
                                                                            wire:model="nltaPersons.{{ $index }}.incidentDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"></textarea>
                                                                        @error('nltaPersons.' . $index . '.incidentDescription')
                                                                            <span class="text-red-500 text-sm">The incident description is required!</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                     </div>

                                                    <div x-show="selectedSubTab === 'nflta'" x-data="{selectedSubTab1: '1',}" x-cloak>
                                                        <div class="flex overflow-x-auto pb-2">
                                                            @foreach($nfltaPersons as $index => $person)
                                                                <div @click="selectedSubTab1 = '{{ $index + 1 }}'" 
                                                                        :class="{ 'font-bold dark:text-gray-300 border-b-2 border-blue-500': selectedSubTab1 === '{{ $index + 1 }}', 'text-slate-500 dark:hover:text-white hover:text-black': selectedSubTab1 !== '{{ $index + 1 }}' }" 
                                                                        class="h-min pt-2 pb-2 px-4 text-sm text-nowrap -mb-2">
                                                                        {{ $index + 1 }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                     
                                                        @foreach($nfltaPersons as $index => $person)
                                                            <div class="overflow-visible border dark:border-gray-700 bg-gray-50 dark:bg-slate-700 p-4 mb-8" x-show="selectedSubTab1 === '{{ $index + 1 }}'">
                                                                <h1 class="my-4 text-gray-800 dark:text-gray-100 font-bold">Person: {{ $index + 1 }}</h1>
                                                                <div class="grid grid-cols-3 gap-4 overflow-visible">

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pangalan (Name)</label>
                                                                        <input type="text" id="name" wire:model='nfltaPersons.{{ $index }}.name' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.name')
                                                                            <span class="text-red-500 text-sm">The name is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Kasarian (Gender)</label>
                                                                        <select name="gender" id="gender" wire:model='nfltaPersons.{{ $index }}.gender' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                            <option value="" class="text-gray-400 dark:text-gray-700">Pumili ng Kasarian (Gender)</option>
                                                                            <option value="Male">Lalake (Male)</option>
                                                                            <option value="Female">Babae (Female)</option>
                                                                        </select>
                                                                        @error('nfltaPersons.' . $index . '.gender')
                                                                            <span class="text-red-500 text-sm">The gender is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Posisyon (Position)</label>
                                                                        <input type="text" id="position" wire:model='nfltaPersons.{{ $index }}.position' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.position')
                                                                            <span class="text-red-500 text-sm">The position is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="dateOfAccidentIllness" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Petsa ng Aksidente/Karamdaman (Date of Accident/Illness)</label>
                                                                        <input type="date" id="dateOfAccidentIllness" wire:model='nfltaPersons.{{ $index }}.dateOfAccidentIllness' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.dateOfAccidentIllness')
                                                                            <span class="text-red-500 text-sm">The date of accident/illness is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="time" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Oras (Time)</label>
                                                                        <input type="time" id="time" wire:model='nfltaPersons.{{ $index }}.time' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.time')
                                                                            <span class="text-red-500 text-sm">The time is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinangyarihan (Location)</label>
                                                                        <input type="text" id="location" wire:model='nfltaPersons.{{ $index }}.location' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.location')
                                                                            <span class="text-red-500 text-sm">The location is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="serviceContractor" wire:model.live='nfltaPersons.{{ $index }}.serviceContractor' class="">
                                                                            <label for="serviceContractor" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Service Contractor?</label>
                                                                            @error('nfltaPersons.' . $index . '.serviceContractor')
                                                                                <span class="text-red-500 text-sm">The service contractor is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <input type="text" id="company" wire:model='nfltaPersons.{{ $index }}.company' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" 
                                                                            {{ $nfltaPersons[$index]['serviceContractor']? '' : 'readonly' }} placeholder="Kumpanya (Company)">
                                                                        @error('nfltaPersons.' . $index . '.company')
                                                                            <span class="text-red-500 text-sm">The company is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <div class="customdiv"></div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="physicalInjury" wire:model='nfltaPersons.{{ $index }}.physicalInjury' class=" cursor-pointer">
                                                                            <label for="physicalInjury" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinsala sa katawan (Physical Injuries)</label>
                                                                            @error('nfltaPersons.' . $index . '.physicalInjury')
                                                                                <span class="text-red-500 text-sm">The physical injuries is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="propertyDamage" wire:model='nfltaPersons.{{ $index }}.propertyDamage' class="cursor-pointer">
                                                                            <label for="propertyDamage" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinsala sa kagamitan (Property Damage)</label>
                                                                            @error('nfltaPersons.' . $index . '.propertyDamage')
                                                                                <span class="text-red-500 text-sm">The property damage is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                                                        
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="cause" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Dahilan ng Aksidente o Karamdaman (Cause of Accident/Illness)</label>
                                                                        <input type="text" id="cause" wire:model='nfltaPersons.{{ $index }}.cause' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.cause')
                                                                            <span class="text-red-500 text-sm">The cause of accident/illness is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="unsafeAct" wire:model.live='nfltaPersons.{{ $index }}.unsafeAct' class="cursor-pointer">
                                                                            <label for="unsafeAct" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Panganib dulot ng Kapabayaan (Unsafe Acts)</label>
                                                                            @error('nfltaPersons.' . $index . '.unsafeAct')
                                                                                <span class="text-red-500 text-sm">The unsafe act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="unsafeActDescription" 
                                                                            wire:model="nfltaPersons.{{ $index }}.unsafeActDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $nfltaPersons[$index]['unsafeAct']  ? '' : 'hidden' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Ilarawan (Description)"
                                                                        ></textarea>
                                                                        @error('nfltaPersons.' . $index . '.unsafeActDescription')
                                                                            <span class="text-red-500 text-sm">The unsafe act description is required!</span>
                                                                        @enderror
                                                                    </div>
                                                                                                                                                                    
                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="unsafeConditions" wire:model.live='nfltaPersons.{{ $index }}.unsafeConditions' class="cursor-pointer">
                                                                            <label for="unsafeConditions" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Panganib dulot ng Sitwasyon (Unsafe Conditions)</label>
                                                                            @error('nfltaPersons.' . $index . '.unsafeConditions')
                                                                                <span class="text-red-500 text-sm">The unsafe act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="unsafeConditionsDescription" 
                                                                            wire:model="nfltaPersons.{{ $index }}.unsafeConditionsDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $nfltaPersons[$index]['unsafeConditions'] ? '' : 'hidden' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Ilarawan (Description)"
                                                                        ></textarea>
                                                                        @error('nfltaPersons.' . $index . '.unsafeConditionsDescription')
                                                                            <span class="text-red-500 text-sm">The unsafe conditions description is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full grid grid-cols-2 gap-4 mt-4 overflow-visible">

                                                                        {{-- Uri ng Aksidente (Kind of Accident) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Uri ng Aksidente (Kind of Accident)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Contact with objects and equipment</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="struct_against_object" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Tumama sa isang bagay (Struck against object)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="struct_against_object" class="ml-2 text-gray-900 dark:text-gray-300">Tumama sa isang bagay (Struck against object)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="struct_by_object" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Tinamaan ng isang bagay (Struck by object)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="struct_by_object" class="ml-2 text-gray-900 dark:text-gray-300">Tinamaan ng isang bagay (Struck by object)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-equipment" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Naipit sa makinarya o sa dalawang bagay (Caught in or crushed by equipment or objects)" class="h-4 w-4">
                                                                                        <label for="caught-equipment" class="ml-2 text-gray-900 dark:text-gray-300">Naipit sa makinarya o sa dalawang bagay (Caught in or crushed by equipment or objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-collapsing" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Naipit sa mga gumuguhong bagay (Caught in or crushed in collapsing materials)" class="h-4 w-4">
                                                                                        <label for="caught-collapsing" class="ml-2 text-gray-900 dark:text-gray-300">Naipit sa mga gumuguhong bagay (Caught in or crushed in collapsing materials)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-unspecified" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), contact" class="h-4 w-4">
                                                                                        <label for="caught-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Falls</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-lower-level" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Pagkahulog sa mas mababang lebel (Fall of a person to lower level)" class="h-4 w-4">
                                                                                        <label for="fall-lower-level" class="ml-2 text-gray-900 dark:text-gray-300">Pagkahulog sa mas mababang lebel (Fall of a person to lower level)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-same-level" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Pagkadulas (Fall of a person on the same level)" class="h-4 w-4">
                                                                                        <label for="fall-same-level" class="ml-2 text-gray-900 dark:text-gray-300">Pagkadulas (Fall of a person on the same level)</label>
                                                                                    </li>
                                                                                    
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-material" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Tinamaan ng nahuhulog na bagay (Fall of material or structures" class="h-4 w-4">
                                                                                        <label for="fall-material" class="ml-2 text-gray-900 dark:text-gray-300">Tinamaan ng nahuhulog na bagay (Fall of material or structures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-unspecified" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), falls" class="h-4 w-4">
                                                                                        <label for="fall-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Bodily Exertion</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-lifting" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa pagbuhat (Over-exertion in lifting objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-lifting" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa pagbuhat (Over-exertion in lifting objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-pushing" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa pagtulak o paghila (Over-exertion in pushing or pulling objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-pushing" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa pagtulak o paghila (Over-exertion in pushing or pulling objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-handling" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa paghawak o paghagis (Over-exertion in handling or throwing objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-handling" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa paghawak o paghagis (Over-exertion in handling or throwing objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="wrong-movements" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Maling galaw (Wrong movements)" class="h-4 w-4">
                                                                                        <label for="wrong-movements" class="ml-2 text-gray-900 dark:text-gray-300">Maling galaw (Wrong movements)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-unspecified" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), exertion" class="h-4 w-4">
                                                                                        <label for="over-exertion-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Exposure to harmful substances or environments</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="electric-current" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Nadikit sa kuryente (Contact with electric current)" class="h-4 w-4">
                                                                                        <label for="electric-current" class="ml-2 text-gray-900 dark:text-gray-300">Nadikit sa kuryente (Contact with electric current)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="extreme-temps" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Napaso (Contact or exposure to extreme temperatures)" class="h-4 w-4">
                                                                                        <label for="extreme-temps" class="ml-2 text-gray-900 dark:text-gray-300">Napaso (Contact or exposure to extreme temperatures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="weather-exposure" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Nabilad (Exposure to extreme weather conditions)"class="h-4 w-4">
                                                                                        <label for="weather-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Nabilad (Exposure to extreme weather conditions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="noise-exposure" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Malakas na ingay o tunog (Exposure to noise)" class="h-4 w-4">
                                                                                        <label for="noise-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Malakas na ingay o tunog (Exposure to noise)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="radiation-exposure" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Exposure to radiation" class="h-4 w-4">
                                                                                        <label for="radiation-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Exposure to radiation</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="oxygen-deficiency" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Hindi makahinga (Oxygen deficiency)" class="h-4 w-4">
                                                                                        <label for="oxygen-deficiency" class="ml-2 text-gray-900 dark:text-gray-300">Hindi makahinga (Oxygen deficiency)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="chemical-contact" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Nadikit sa kemikal (Contact with chemicals)" class="h-4 w-4">
                                                                                        <label for="chemical-contact" class="ml-2 text-gray-900 dark:text-gray-300">Nadikit sa kemikal (Contact with chemicals)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="exposure-unspecified" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), exposure" class="h-4 w-4">
                                                                                        <label for="exposure-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Fires and explosion</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fire-hazard" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Apoy (Fires)" class="h-4 w-4">
                                                                                        <label for="fire-hazard" class="ml-2 text-gray-900 dark:text-gray-300">Apoy (Fires)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="explosion-hazard" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Pagsabog (Explosions)" class="h-4 w-4">
                                                                                        <label for="explosion-hazard" class="ml-2 text-gray-900 dark:text-gray-300">Pagsabog (Explosions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fire-explosion-unspecified" type="checkbox" wire:model="nfltaPersons.{{ $index }}.kindOfAccident" value="Hindi Matukoy (Unspecified), fire" class="h-4 w-4">
                                                                                        <label for="fire-explosion-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi Matukoy (Unspecified)</label>
                                                                                    </li>                                                                            
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Uri ng pinsala (Type of Injury) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Uri ng pinsala (Type of Injury)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li class="flex items-center">
                                                                                        <input id="contusion" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Pasa o bugbog (Contusion, bruises, hematoma)" class="h-4 w-4">
                                                                                        <label for="contusion" class="ml-2 text-gray-900 dark:text-gray-300">Pasa o bugbog (Contusion, bruises, hematoma)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="abrasions" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Gasgas (Abrasions)" class="h-4 w-4">
                                                                                        <label for="abrasions" class="ml-2 text-gray-900 dark:text-gray-300">Gasgas (Abrasions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="cuts" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Hiwa, laslas, o tusok (Cuts, lacerations, punctures)" class="h-4 w-4">
                                                                                        <label for="cuts" class="ml-2 text-gray-900 dark:text-gray-300">Hiwa, laslas, o tusok (Cuts, lacerations, punctures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="concussion" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Nabagok (Concussion)" class="h-4 w-4">
                                                                                        <label for="concussion" class="ml-2 text-gray-900 dark:text-gray-300">Nabagok (Concussion)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="avulsion" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Napilas (Avulsion)" class="h-4 w-4">
                                                                                        <label for="avulsion" class="ml-2 text-gray-900 dark:text-gray-300">Napilas (Avulsion)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="amputation" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Naputol (Amputation)" class="h-4 w-4">
                                                                                        <label for="amputation" class="ml-2 text-gray-900 dark:text-gray-300">Naputol (Amputation)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="crushing_injuries" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Napisa (Crushing injuries)" class="h-4 w-4">
                                                                                        <label for="crushing_injuries" class="ml-2 text-gray-900 dark:text-gray-300">Napisa (Crushing injuries)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="sprains" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Sprains" class="h-4 w-4">
                                                                                        <label for="sprains" class="ml-2 text-gray-900 dark:text-gray-300">Sprains</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="dislocation" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Nabalian (Dislocation/Fractures)" class="h-4 w-4">
                                                                                        <label for="dislocation" class="ml-2 text-gray-900 dark:text-gray-300">Nabalian (Dislocation/Fractures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="burn" type="checkbox" wire:model="nfltaPersons.{{ $index }}.typeOfInjury" value="Nasunog (Burn)" class="h-4 w-4">
                                                                                        <label for="burn" class="ml-2 text-gray-900 dark:text-gray-300">Nasunog (Burn)</label>
                                                                                    </li>                                                                            
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Parte ng Katawan na Napinsala (Part of the Body Injured) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Parte ng Katawan na Napinsala (Part of the Body Injured)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg sm:overflow-x-hidden
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <table class="min-w-full table-auto border-collapse">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="px-4 py-2 text-left">Parte (Part)</th>
                                                                                            <th class="px-4 py-2">Left (Kaliwa)</th>
                                                                                            <th class="px-4 py-2">Right (Kanan)</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <!-- Head -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Head</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Ulo/Mukha/Sentido (Back/Face/Temple)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="head_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Ulo/Mukha/Sentido (Back/Face/Temple), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="head_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Ulo/Mukha/Sentido (Back/Face/Temple), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="eye_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="eye_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tenga/Pisngi (Ear/Cheek)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ear_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Tenga/Pisngi (Ear/Cheek), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ear_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Tenga/Pisngi (Ear/Cheek), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Ilong (Nose)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="nose_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Ilong (Nose), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="nose_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Ilong (Nose), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Bumbunan/Anit (Skull/Scalp)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="scalp_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Bumbunan/Anit (Skull/Scalp), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="scalp_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Bumbunan/Anit (Skull/Scalp), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Panga (Jaw)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="jaw_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Panga (Jaw), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="jaw_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Panga (Jaw), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Labi/Ngipin (Lip/Teeth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="lip_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Labi/Ngipin (Lip/Teeth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="lip_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Labi/Ngipin (Lip/Teeth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Leeg/Batok (Neck/Nape)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="neck_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Leeg/Batok (Neck/Nape), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="neck_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Leeg/Batok (Neck/Nape), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Trunk -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Trunk</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Likod/Gulugod (Back/Vertebra)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="back_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Likod/Gulugod (Back/Vertebra), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="back_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Likod/Gulugod (Back/Vertebra), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="chest_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="chest_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tadyang (Rib)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="rib_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Tadyang (Rib), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="rib_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Tadyang (Rib), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="buttock_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="buttock_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Collar Bone</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="collar_bone_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Collar Bone, l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="collar_bone_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Collar Bone, r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Extremities -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Extremities</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Balikat/Braso (Upper Shoulder/Arm)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shoulder_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Balikat/Braso (Upper Shoulder/Arm), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shoulder_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Balikat/Braso (Upper Shoulder/Arm), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Siko/Bisig (Elbow/Forearm)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="elbow_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Siko/Bisig (Elbow/Forearm), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="elbow_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Siko/Bisig (Elbow/Forearm), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pulso/Kamay (Wrist/Hand)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="wrist_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Pulso/Kamay (Wrist/Hand), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="wrist_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Pulso/Kamay (Wrist/Hand), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Fingers -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Fingers</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinlalaki (Thumb)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thumb_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Thumb), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thumb_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Thumb), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hintuturo (Index)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="index_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hintuturo (Index), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="index_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hintuturo (Index), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Gitna (Middle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middle_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middle_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Palasingsingan (Ring)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ring_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Palasingsingan (Ring), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ring_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Palasingsingan (Ring), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinliliit (Little)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="little_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hinliliit (Little), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="little_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hinliliit (Little), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Lower Extremities -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Lower</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hita (Thigh)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thigh_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hita (Thigh), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thigh_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hita (Thigh), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tuhod (Knee)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="knee_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Tuhod (Knee), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="knee_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Tuhod (Knee), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Binti (Leg)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shin_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Binti (Leg), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shin_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Binti (Leg), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Sakong (Ankle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ankle_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Sakong (Ankle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ankle_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Sakong (Ankle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Paa (Foot)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="foot_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Paa (Foot), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="foot_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Paa (Foot), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Toes -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Toes</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinlalaki (Big Toe)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="bigtoe_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Big Toe), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="bigtoe_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Big Toe), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pangalawa (Second)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="secondtoe_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Pangalawa (Second), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="secondtoe_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Pangalawa (Second), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Gitna (Middle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middletoe_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middletoe_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pangapat (Fourth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fourthtoe_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Pangapat (Fourth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fourthtoe_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Pangapat (Fourth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Panglima (Fifth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fifthtoe_left" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Panglima (Fifth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fifthtoe_right" type="checkbox" wire:model="nfltaPersons.{{ $index }}.partOfBodyInjured" value="Panglima (Fifth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <div class="col-span-full sm:col-span-1 mt-4">
                                                                                    <label for="otherParts" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Iba pang bahagi (Others)</label>
                                                                                    <input type="text" id="otherParts" wire:model='nfltaPersons.{{ $index }}.otherParts' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                                    @error('nfltaPersons.' . $index . '.otherParts')
                                                                                        <span class="text-red-500 text-sm">The otherParts of accident/illness is required!</span>
                                                                                    @enderror
                                                                                </div>                                                                    
                                                                            </div>
                                                                        </div>

                                                                        {{-- Paraan ng Paggamot (Treatment) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Paraan ng Paggamot (Treatment)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li class="flex items-center">
                                                                                        <input id="rest" type="checkbox" wire:model="nfltaPersons.{{ $index }}.treatment" value="Pahinga (Rest)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="rest" class="ml-2 text-gray-900 dark:text-gray-300">Pahinga (Rest)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="first_aid" type="checkbox" wire:model="nfltaPersons.{{ $index }}.treatment" value="Nilapatan ng pang unang lunas (first aid)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="first_aid" class="ml-2 text-gray-900 dark:text-gray-300">Nilapatan ng pang unang lunas (first aid)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="medication" type="checkbox" wire:model="nfltaPersons.{{ $index }}.treatment" value="Binigyan ng gamot (administered medication)" class="h-4 w-4">
                                                                                        <label for="medication" class="ml-2 text-gray-900 dark:text-gray-300">Binigyan ng gamot (administered medication)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="hospitalized" type="checkbox" wire:model="nfltaPersons.{{ $index }}.treatment" value="Dinala sa ospital (taken to the hospital)" class="h-4 w-4">
                                                                                        <label for="hospitalized" class="ml-2 text-gray-900 dark:text-gray-300">Dinala sa ospital (taken to the hospital)</label>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="cost_of_mitigation" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Gastos ng Kumpanya sa Pagpapagamot (Cost of Mitigation)</label>
                                                                        <input type="number" step="0.01" id="cost_of_mitigation" wire:model='nfltaPersons.{{ $index }}.cost_of_mitigation' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.cost_of_mitigation')
                                                                            <span class="text-red-500 text-sm">The cost of mitigation is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="cost_of_property_damage" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Gastos ng Kumpanya sa mga nasirang kagamitan (Cost of Damage to Property)</label>
                                                                        <input type="number" step="0.01" id="cost_of_property_damage" wire:model='nfltaPersons.{{ $index }}.cost_of_property_damage' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('nfltaPersons.' . $index . '.cost_of_property_damage')
                                                                            <span class="text-red-500 text-sm">The cost of property damage is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="performingWork" wire:model.live='nfltaPersons.{{ $index }}.performingWork' class="cursor-pointer">
                                                                            <label for="performingWork" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Trabaho ba niya ang ginagawa niya noong naaksidente siya (was the personnel performing routine work?)</label>
                                                                            @error('nfltaPersons.' . $index . '.performingWork')
                                                                                <span class="text-red-500 text-sm">The performing routine work act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="performingWorkDescription" 
                                                                            wire:model="nfltaPersons.{{ $index }}.performingWorkDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $nfltaPersons[$index]['performingWork'] ? 'hidden' : '' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Kung hindi, ano ang ginagawa niya, at bakit? (If no, what was the personnel doing? And why?)"
                                                                        ></textarea>
                                                                        @error('nfltaPersons.' . $index . '.performingWorkDescription')
                                                                            <span class="text-red-500 text-sm">The performing routine work description is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <label for="performingWork" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Maikling salaysay ng mga pangyayari (Brief description of the incident)</label>
                                                                        <textarea 
                                                                            id="incidentDescription" 
                                                                            wire:model="nfltaPersons.{{ $index }}.incidentDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"></textarea>
                                                                        @error('nfltaPersons.' . $index . '.incidentDescription')
                                                                            <span class="text-red-500 text-sm">The incident description is required!</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                     </div>
                                                    <div x-show="selectedSubTab === 'flta'" x-data="{selectedSubTab1: '1',}" x-cloak>
                                                        <div class="flex overflow-x-auto pb-2">
                                                            @foreach($fltaPersons as $index => $person)
                                                                <div @click="selectedSubTab1 = '{{ $index + 1 }}'" 
                                                                        :class="{ 'font-bold dark:text-gray-300 border-b-2 border-blue-500': selectedSubTab1 === '{{ $index + 1 }}', 'text-slate-500 dark:hover:text-white hover:text-black': selectedSubTab1 !== '{{ $index + 1 }}' }" 
                                                                        class="h-min pt-2 pb-2 px-4 text-sm text-nowrap -mb-2">
                                                                        {{ $index + 1 }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                       
                                                        @foreach($fltaPersons as $index => $person)
                                                            <div class="overflow-visible border dark:border-gray-700 bg-gray-50 dark:bg-slate-700 p-4 mb-8" x-show="selectedSubTab1 === '{{ $index + 1 }}'">
                                                                <h1 class="my-4 text-gray-800 dark:text-gray-100 font-bold">Person: {{ $index + 1 }}</h1>
                                                                <div class="grid grid-cols-3 gap-4 overflow-visible">

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pangalan (Name)</label>
                                                                        <input type="text" id="name" wire:model='fltaPersons.{{ $index }}.name' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.name')
                                                                            <span class="text-red-500 text-sm">The name is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Kasarian (Gender)</label>
                                                                        <select name="gender" id="gender" wire:model='fltaPersons.{{ $index }}.gender' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                            <option value="" class="text-gray-400 dark:text-gray-700">Pumili ng Kasarian (Gender)</option>
                                                                            <option value="Male">Lalake (Male)</option>
                                                                            <option value="Female">Babae (Female)</option>
                                                                        </select>
                                                                        @error('fltaPersons.' . $index . '.gender')
                                                                            <span class="text-red-500 text-sm">The gender is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Posisyon (Position)</label>
                                                                        <input type="text" id="position" wire:model='fltaPersons.{{ $index }}.position' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.position')
                                                                            <span class="text-red-500 text-sm">The position is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="dateOfAccidentIllness" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Petsa ng Aksidente/Karamdaman (Date of Accident/Illness)</label>
                                                                        <input type="date" id="dateOfAccidentIllness" wire:model='fltaPersons.{{ $index }}.dateOfAccidentIllness' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.dateOfAccidentIllness')
                                                                            <span class="text-red-500 text-sm">The date of accident/illness is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="time" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Oras (Time)</label>
                                                                        <input type="time" id="time" wire:model='fltaPersons.{{ $index }}.time' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.time')
                                                                            <span class="text-red-500 text-sm">The time is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinangyarihan (Location)</label>
                                                                        <input type="text" id="location" wire:model='fltaPersons.{{ $index }}.location' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.location')
                                                                            <span class="text-red-500 text-sm">The location is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="serviceContractor" wire:model.live='fltaPersons.{{ $index }}.serviceContractor' class="">
                                                                            <label for="serviceContractor" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Service Contractor?</label>
                                                                            @error('fltaPersons.' . $index . '.serviceContractor')
                                                                                <span class="text-red-500 text-sm">The service contractor is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <input type="text" id="company" wire:model='fltaPersons.{{ $index }}.company' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" 
                                                                            {{ $fltaPersons[$index]['serviceContractor'] ? '' : 'readonly' }} placeholder="Kumpanya (Company)">
                                                                        @error('fltaPersons.' . $index . '.company')
                                                                            <span class="text-red-500 text-sm">The company is required!</span>
                                                                        @enderror
                                                                    </div>
                                                
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <div class="customdiv"></div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="physicalInjury" 
                                                                            true-value="1" false-value="0"
                                                                            wire:model='fltaPersons.{{ $index }}.physicalInjury' class=" cursor-pointer">
                                                                            <label for="physicalInjury" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinsala sa katawan (Physical Injuries)</label>
                                                                            @error('fltaPersons.' . $index . '.physicalInjury')
                                                                                <span class="text-red-500 text-sm">The physical injuries is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="propertyDamage" 
                                                                            true-value="1" false-value="0"
                                                                            wire:model='fltaPersons.{{ $index }}.propertyDamage' class="cursor-pointer">
                                                                            <label for="propertyDamage" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Pinsala sa kagamitan (Property Damage)</label>
                                                                            @error('fltaPersons.' . $index . '.propertyDamage')
                                                                                <span class="text-red-500 text-sm">The property damage is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                                                        
                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <label for="cause" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Dahilan ng Aksidente o Karamdaman (Cause of Accident/Illness)</label>
                                                                        <input type="text" id="cause" wire:model='fltaPersons.{{ $index }}.cause' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.cause')
                                                                            <span class="text-red-500 text-sm">The cause of accident/illness is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="unsafeAct" wire:model.live='fltaPersons.{{ $index }}.unsafeAct' class="cursor-pointer">
                                                                            <label for="unsafeAct" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Panganib dulot ng Kapabayaan (Unsafe Acts)</label>
                                                                            @error('fltaPersons.' . $index . '.unsafeAct')
                                                                                <span class="text-red-500 text-sm">The unsafe act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="unsafeActDescription" 
                                                                            wire:model="fltaPersons.{{ $index }}.unsafeActDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $fltaPersons[$index]['unsafeAct']  ? '' : 'hidden' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Ilarawan (Description)"
                                                                        ></textarea>
                                                                        @error('fltaPersons.' . $index . '.unsafeActDescription')
                                                                            <span class="text-red-500 text-sm">The unsafe act description is required!</span>
                                                                        @enderror
                                                                    </div>
                                                                                                                                                                    
                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="unsafeConditions" wire:model.live='fltaPersons.{{ $index }}.unsafeConditions' class="cursor-pointer">
                                                                            <label for="unsafeConditions" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Panganib dulot ng Sitwasyon (Unsafe Conditions)</label>
                                                                            @error('fltaPersons.' . $index . '.unsafeConditions')
                                                                                <span class="text-red-500 text-sm">The unsafe act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="unsafeConditionsDescription" 
                                                                            wire:model="fltaPersons.{{ $index }}.unsafeConditionsDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $fltaPersons[$index]['unsafeConditions'] ? '' : 'hidden' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Ilarawan (Description)"
                                                                        ></textarea>
                                                                        @error('fltaPersons.' . $index . '.unsafeConditionsDescription')
                                                                            <span class="text-red-500 text-sm">The unsafe conditions description is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full grid grid-cols-2 gap-4 mt-4 overflow-visible">

                                                                        {{-- Uri ng Aksidente (Kind of Accident) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Uri ng Aksidente (Kind of Accident)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Contact with objects and equipment</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="struct_against_object" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Tumama sa isang bagay (Struck against object)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="struct_against_object" class="ml-2 text-gray-900 dark:text-gray-300">Tumama sa isang bagay (Struck against object)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="struct_by_object" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Tinamaan ng isang bagay (Struck by object)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="struct_by_object" class="ml-2 text-gray-900 dark:text-gray-300">Tinamaan ng isang bagay (Struck by object)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-equipment" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Naipit sa makinarya o sa dalawang bagay (Caught in or crushed by equipment or objects)" class="h-4 w-4">
                                                                                        <label for="caught-equipment" class="ml-2 text-gray-900 dark:text-gray-300">Naipit sa makinarya o sa dalawang bagay (Caught in or crushed by equipment or objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-collapsing" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Naipit sa mga gumuguhong bagay (Caught in or crushed in collapsing materials)" class="h-4 w-4">
                                                                                        <label for="caught-collapsing" class="ml-2 text-gray-900 dark:text-gray-300">Naipit sa mga gumuguhong bagay (Caught in or crushed in collapsing materials)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="caught-unspecified" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), contact" class="h-4 w-4">
                                                                                        <label for="caught-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Falls</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-lower-level" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Pagkahulog sa mas mababang lebel (Fall of a person to lower level)" class="h-4 w-4">
                                                                                        <label for="fall-lower-level" class="ml-2 text-gray-900 dark:text-gray-300">Pagkahulog sa mas mababang lebel (Fall of a person to lower level)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-same-level" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Pagkadulas (Fall of a person on the same level)" class="h-4 w-4">
                                                                                        <label for="fall-same-level" class="ml-2 text-gray-900 dark:text-gray-300">Pagkadulas (Fall of a person on the same level)</label>
                                                                                    </li>
                                                                                    
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-material" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Tinamaan ng nahuhulog na bagay (Fall of material or structures" class="h-4 w-4">
                                                                                        <label for="fall-material" class="ml-2 text-gray-900 dark:text-gray-300">Tinamaan ng nahuhulog na bagay (Fall of material or structures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fall-unspecified" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), falls" class="h-4 w-4">
                                                                                        <label for="fall-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Bodily Exertion</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-lifting" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa pagbuhat (Over-exertion in lifting objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-lifting" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa pagbuhat (Over-exertion in lifting objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-pushing" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa pagtulak o paghila (Over-exertion in pushing or pulling objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-pushing" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa pagtulak o paghila (Over-exertion in pushing or pulling objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-handling" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Nabinat sa paghawak o paghagis (Over-exertion in handling or throwing objects)" class="h-4 w-4">
                                                                                        <label for="over-exertion-handling" class="ml-2 text-gray-900 dark:text-gray-300">Nabinat sa paghawak o paghagis (Over-exertion in handling or throwing objects)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="wrong-movements" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Maling galaw (Wrong movements)" class="h-4 w-4">
                                                                                        <label for="wrong-movements" class="ml-2 text-gray-900 dark:text-gray-300">Maling galaw (Wrong movements)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="over-exertion-unspecified" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Hindi matukoy (Unspecified), exertion " class="h-4 w-4">
                                                                                        <label for="over-exertion-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Exposure to harmful substances or environments</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="electric-current" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Nadikit sa kuryente (Contact with electric current)" class="h-4 w-4">
                                                                                        <label for="electric-current" class="ml-2 text-gray-900 dark:text-gray-300">Nadikit sa kuryente (Contact with electric current)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="extreme-temps" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Napaso (Contact or exposure to extreme temperatures)" class="h-4 w-4">
                                                                                        <label for="extreme-temps" class="ml-2 text-gray-900 dark:text-gray-300">Napaso (Contact or exposure to extreme temperatures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="weather-exposure" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Nabilad (Exposure to extreme weather conditions)"class="h-4 w-4">
                                                                                        <label for="weather-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Nabilad (Exposure to extreme weather conditions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="noise-exposure" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Malakas na ingay o tunog (Exposure to noise)" class="h-4 w-4">
                                                                                        <label for="noise-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Malakas na ingay o tunog (Exposure to noise)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="radiation-exposure" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Exposure to radiation" class="h-4 w-4">
                                                                                        <label for="radiation-exposure" class="ml-2 text-gray-900 dark:text-gray-300">Exposure to radiation</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="oxygen-deficiency" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Hindi makahinga (Oxygen deficiency)" class="h-4 w-4">
                                                                                        <label for="oxygen-deficiency" class="ml-2 text-gray-900 dark:text-gray-300">Hindi makahinga (Oxygen deficiency)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="chemical-contact" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Nadikit sa kemikal (Contact with chemicals)" class="h-4 w-4">
                                                                                        <label for="chemical-contact" class="ml-2 text-gray-900 dark:text-gray-300">Nadikit sa kemikal (Contact with chemicals)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="exposure-unspecified" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value=" Hindi matukoy (Unspecified), exposure" class="h-4 w-4">
                                                                                        <label for="exposure-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi matukoy (Unspecified)</label>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="font-bold text-gray-700 dark:text-gray-100">Fires and explosion</p>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fire-hazard" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Apoy (Fires)" class="h-4 w-4">
                                                                                        <label for="fire-hazard" class="ml-2 text-gray-900 dark:text-gray-300">Apoy (Fires)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="explosion-hazard" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Pagsabog (Explosions)" class="h-4 w-4">
                                                                                        <label for="explosion-hazard" class="ml-2 text-gray-900 dark:text-gray-300">Pagsabog (Explosions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="fire-explosion-unspecified" type="checkbox" wire:model="fltaPersons.{{ $index }}.kindOfAccident" value="Hindi Matukoy (Unspecified), fires" class="h-4 w-4">
                                                                                        <label for="fire-explosion-unspecified" class="ml-2 text-gray-900 dark:text-gray-300">Hindi Matukoy (Unspecified)</label>
                                                                                    </li>                                                                            
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Uri ng pinsala (Type of Injury) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Uri ng pinsala (Type of Injury)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li class="flex items-center">
                                                                                        <input id="contusion" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Pasa o bugbog (Contusion, bruises, hematoma)" class="h-4 w-4">
                                                                                        <label for="contusion" class="ml-2 text-gray-900 dark:text-gray-300">Pasa o bugbog (Contusion, bruises, hematoma)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="abrasions" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Gasgas (Abrasions)" class="h-4 w-4">
                                                                                        <label for="abrasions" class="ml-2 text-gray-900 dark:text-gray-300">Gasgas (Abrasions)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="cuts" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Hiwa, laslas, o tusok (Cuts, lacerations, punctures)" class="h-4 w-4">
                                                                                        <label for="cuts" class="ml-2 text-gray-900 dark:text-gray-300">Hiwa, laslas, o tusok (Cuts, lacerations, punctures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="concussion" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Nabagok (Concussion)" class="h-4 w-4">
                                                                                        <label for="concussion" class="ml-2 text-gray-900 dark:text-gray-300">Nabagok (Concussion)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="avulsion" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Napilas (Avulsion)" class="h-4 w-4">
                                                                                        <label for="avulsion" class="ml-2 text-gray-900 dark:text-gray-300">Napilas (Avulsion)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="amputation" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Naputol (Amputation)" class="h-4 w-4">
                                                                                        <label for="amputation" class="ml-2 text-gray-900 dark:text-gray-300">Naputol (Amputation)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="crushing_injuries" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Napisa (Crushing injuries)" class="h-4 w-4">
                                                                                        <label for="crushing_injuries" class="ml-2 text-gray-900 dark:text-gray-300">Napisa (Crushing injuries)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="sprains" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Sprains" class="h-4 w-4">
                                                                                        <label for="sprains" class="ml-2 text-gray-900 dark:text-gray-300">Sprains</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="dislocation" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Nabalian (Dislocation/Fractures)" class="h-4 w-4">
                                                                                        <label for="dislocation" class="ml-2 text-gray-900 dark:text-gray-300">Nabalian (Dislocation/Fractures)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="burn" type="checkbox" wire:model="fltaPersons.{{ $index }}.typeOfInjury" value="Nasunog (Burn)" class="h-4 w-4">
                                                                                        <label for="burn" class="ml-2 text-gray-900 dark:text-gray-300">Nasunog (Burn)</label>
                                                                                    </li>                                                                            
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                        {{-- Parte ng Katawan na Napinsala (Part of the Body Injured) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Parte ng Katawan na Napinsala (Part of the Body Injured)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg sm:overflow-x-hidden
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <table class="min-w-full table-auto border-collapse">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="px-4 py-2 text-left">Parte (Part)</th>
                                                                                            <th class="px-4 py-2">Left (Kaliwa)</th>
                                                                                            <th class="px-4 py-2">Right (Kanan)</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <!-- Head -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Head</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Ulo/Mukha/Sentido (Back/Face/Temple)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="head_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Ulo/Mukha/Sentido (Back/Face/Temple), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="head_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Ulo/Mukha/Sentido (Back/Face/Temple), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="eye_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="eye_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Mata/Talukap ng Mata/Noo (Eye/Lid/Forehead), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tenga/Pisngi (Ear/Cheek)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ear_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Tenga/Pisngi (Ear/Cheek), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ear_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Tenga/Pisngi (Ear/Cheek), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Ilong (Nose)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="nose_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Ilong (Nose), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="nose_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Ilong (Nose), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Bumbunan/Anit (Skull/Scalp)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="scalp_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Bumbunan/Anit (Skull/Scalp), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="scalp_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Bumbunan/Anit (Skull/Scalp), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Panga (Jaw)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="jaw_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Panga (Jaw), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="jaw_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Panga (Jaw), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Labi/Ngipin (Lip/Teeth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="lip_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Labi/Ngipin (Lip/Teeth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="lip_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Labi/Ngipin (Lip/Teeth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Leeg/Batok (Neck/Nape)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="neck_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Leeg/Batok (Neck/Nape), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="neck_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Leeg/Batok (Neck/Nape), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Trunk -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Trunk</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Likod/Gulugod (Back/Vertebra)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="back_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Likod/Gulugod (Back/Vertebra), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="back_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Likod/Gulugod (Back/Vertebra), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="chest_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="chest_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Dibdib/Tagiliran/Tiyan (Chest/Side/Abdomen), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tadyang (Rib)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="rib_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Tadyang (Rib), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="rib_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Tadyang (Rib), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="buttock_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="buttock_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Puwitan/Baywang/Balakang (Buttock/Hip/Pelvis), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Collar Bone</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="collar_bone_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Collar Bone, l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="collar_bone_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Collar Bone, r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Extremities -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Extremities</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Balikat/Braso (Upper Shoulder/Arm)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shoulder_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Balikat/Braso (Upper Shoulder/Arm), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shoulder_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Balikat/Braso (Upper Shoulder/Arm), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Siko/Bisig (Elbow/Forearm)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="elbow_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Siko/Bisig (Elbow/Forearm), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="elbow_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Siko/Bisig (Elbow/Forearm), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pulso/Kamay (Wrist/Hand)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="wrist_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Pulso/Kamay (Wrist/Hand), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="wrist_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Pulso/Kamay (Wrist/Hand), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Fingers -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Fingers</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinlalaki (Thumb)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thumb_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Thumb), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thumb_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Thumb), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hintuturo (Index)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="index_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hintuturo (Index), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="index_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hintuturo (Index), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Gitna (Middle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middle_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middle_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Palasingsingan (Ring)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ring_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Palasingsingan (Ring), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ring_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Palasingsingan (Ring), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinliliit (Little)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="little_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hinliliit (Little), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="little_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hinliliit (Little), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Lower Extremities -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Lower</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hita (Thigh)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thigh_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hita (Thigh), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="thigh_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hita (Thigh), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Tuhod (Knee)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="knee_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Tuhod (Knee), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="knee_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Tuhod (Knee), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Binti (Leg)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shin_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Binti (Leg), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="shin_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Binti (Leg), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Sakong (Ankle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ankle_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Sakong (Ankle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="ankle_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Sakong (Ankle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Paa (Foot)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="foot_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Paa (Foot), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="foot_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Paa (Foot), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Toes -->
                                                                                        <tr>
                                                                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 font-bold">Toes</td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Hinlalaki (Big Toe)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="bigtoe_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Big Toe), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="bigtoe_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Hinlalaki (Big Toe), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pangalawa (Second)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="secondtoe_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Pangalawa (Second), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="secondtoe_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Pangalawa (Second), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Gitna (Middle)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middletoe_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="middletoe_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Gitna (Middle), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Pangapat (Fourth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fourthtoe_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Pangapat (Fourth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fourthtoe_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Pangapat (Fourth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr class="border-y border-gray-300 dark:border-gray-500">
                                                                                            <td class="px-4 py-2">Panglima (Fifth)</td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fifthtoe_left" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Panglima (Fifth), l" class="h-4 w-4">
                                                                                            </td>
                                                                                            <td class="px-4 py-2 text-center">
                                                                                                <input id="fifthtoe_right" type="checkbox" wire:model="fltaPersons.{{ $index }}.partOfBodyInjured" value="Panglima (Fifth), r" class="h-4 w-4">
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <div class="col-span-full sm:col-span-1 mt-4">
                                                                                    <label for="otherParts" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Iba pang bahagi (Others)</label>
                                                                                    <input type="text" id="otherParts" wire:model='fltaPersons.{{ $index }}.otherParts' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                                    @error('fltaPersons.' . $index . '.otherParts')
                                                                                        <span class="text-red-500 text-sm">The otherParts of accident/illness is required!</span>
                                                                                    @enderror
                                                                                </div>                                                                    
                                                                            </div>
                                                                        </div>

                                                                        {{-- Paraan ng Paggamot (Treatment) --}}
                                                                        <div class="col-span-full sm:col-span-1 w-full relative" x-data="{ open: false }" @click.outside="open = false">
                                                                            <div @click="open = !open"
                                                                                class="mt-4 sm:mt-1 inline-flex items-center bg-white dark:bg-gray-700 cursor-pointer
                                                                                justify-center w-full px-2 py-1.5 text-sm font-medium tracking-wide flex justify-between
                                                                                text-neutral-800 dark:text-neutral-200 transition-colors duration-200 
                                                                                rounded-lg border border-gray-300 focus:outline-none">
                                                                                <span>Paraan ng Paggamot (Treatment)</span> 
                                                                                <i class="bi bi-chevron-down w-5 h-5 ml-2"></i>
                                                                            </div>
                                                    
                                                                            <div x-show="open"
                                                                                class="absolute bottom-12 z-20 w-full p-3 border border-gray-400 bg-white rounded-lg 
                                                                                shadow-2xl dark:bg-gray-800 max-h-80 overflow-y-auto scrollbar-thin1">
                                                                                <ul class="space-y-2 text-sm">
                                                                                    <li class="flex items-center">
                                                                                        <input id="rest" type="checkbox" wire:model="fltaPersons.{{ $index }}.treatment" value="Pahinga (Rest)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="rest" class="ml-2 text-gray-900 dark:text-gray-300">Pahinga (Rest)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="first_aid" type="checkbox" wire:model="fltaPersons.{{ $index }}.treatment" value="Nilapatan ng pang unang lunas (first aid)"
                                                                                            class="h-4 w-4">
                                                                                        <label for="first_aid" class="ml-2 text-gray-900 dark:text-gray-300">Nilapatan ng pang unang lunas (first aid)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="medication" type="checkbox" wire:model="fltaPersons.{{ $index }}.treatment" value="Binigyan ng gamot (administered medication)" class="h-4 w-4">
                                                                                        <label for="medication" class="ml-2 text-gray-900 dark:text-gray-300">Binigyan ng gamot (administered medication)</label>
                                                                                    </li>
                                                                                    <li class="flex items-center">
                                                                                        <input id="hospitalized" type="checkbox" wire:model="fltaPersons.{{ $index }}.treatment" value="Dinala sa ospital (taken to the hospital)" class="h-4 w-4">
                                                                                        <label for="hospitalized" class="ml-2 text-gray-900 dark:text-gray-300">Dinala sa ospital (taken to the hospital)</label>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="cost_of_mitigation" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Gastos ng Kumpanya sa Pagpapagamot (Cost of Mitigation)</label>
                                                                        <input type="number" step="0.01" id="cost_of_mitigation" wire:model='fltaPersons.{{ $index }}.cost_of_mitigation' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.cost_of_mitigation')
                                                                            <span class="text-red-500 text-sm">The cost of mitigation is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full sm:col-span-1">
                                                                        <div class="customdiv"></div>
                                                                        <label for="cost_of_property_damage" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Gastos ng Kumpanya sa mga nasirang kagamitan (Cost of Damage to Property)</label>
                                                                        <input type="number" step="0.01" id="cost_of_property_damage" wire:model='fltaPersons.{{ $index }}.cost_of_property_damage' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                                        @error('fltaPersons.' . $index . '.cost_of_property_damage')
                                                                            <span class="text-red-500 text-sm">The cost of property damage is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="checkbox" id="performingWork" wire:model.live='fltaPersons.{{ $index }}.performingWork' class="cursor-pointer">
                                                                            <label for="performingWork" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Trabaho ba niya ang ginagawa niya noong naaksidente siya (was the personnel performing routine work?)</label>
                                                                            @error('fltaPersons.' . $index . '.performingWork')
                                                                                <span class="text-red-500 text-sm">The performing routine work act is required!</span>
                                                                            @enderror
                                                                        </div>
                                                                        <textarea 
                                                                            id="performingWorkDescription" 
                                                                            wire:model="fltaPersons.{{ $index }}.performingWorkDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm {{ $fltaPersons[$index]['performingWork'] ? 'hidden' : '' }}
                                                                            focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"
                                                                            placeholder="Kung hindi, ano ang ginagawa niya, at bakit? (If no, what was the personnel doing? And why?)"
                                                                        ></textarea>
                                                                        @error('fltaPersons.' . $index . '.performingWorkDescription')
                                                                            <span class="text-red-500 text-sm">The performing routine work description is required!</span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-span-full mt-4">
                                                                        <label for="performingWork" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Maikling salaysay ng mga pangyayari (Brief description of the incident)</label>
                                                                        <textarea 
                                                                            id="incidentDescription" 
                                                                            wire:model="fltaPersons.{{ $index }}.incidentDescription" 
                                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:text-gray-300 dark:bg-gray-700"
                                                                            rows="3"></textarea>
                                                                        @error('fltaPersons.' . $index . '.incidentDescription')
                                                                            <span class="text-red-500 text-sm">The incident description is required!</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Next and Previous --}}
                                    <div class="w-full flex justify-between items-center mt-6">
                                        <button wire:click='previousStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            << Prev
                                        </button>
                                        <button wire:click='nextStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            Next >>
                                        </button>
                                    </div>
                                </div>

                                <div class="{{ $currentStep === 3 ? '' : 'hidden' }}">
                                    <p class="text-sm">Step {{ $currentStep }} of 4</p>

                                    {{-- Deseases --}}
                                    <fieldset class="p-4 border border-gray-500 rounded-md mb-6 relative mt-4" style="padding-top: 60px" x-data="{selectedSubTab1: '1',}" x-cloak>
                                        <h1 class="text-gray-700 dark:text-gray-100 font-bold">Mga naitalang sakit ngayong buwan (Kinds of  diseases recorded this month)</h1>
                                        <button type="button" wire:click="addDesease" 
                                            class="bg-green-500 hover:bg-green-700 text-white absolute top-4 right-4
                                            font-bold px-2 py-1 rounded mb-4" title="Add">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>

                                        <div class="flex overflow-x-auto pb-2 relative z-10">
                                            @foreach($deseases as $index => $desease)
                                                <div @click="selectedSubTab1 = '{{ $index + 1 }}'" 
                                                        :class="{ 'font-bold dark:text-gray-300 border-b-2 border-blue-500': selectedSubTab1 === '{{ $index + 1 }}', 'text-slate-500 dark:hover:text-white hover:text-black': selectedSubTab1 !== '{{ $index + 1 }}' }" 
                                                        class="h-min pt-2 pb-2 px-4 text-sm text-nowrap -mb-2">
                                                        {{ $index + 1 }}
                                                </div>
                                            @endforeach
                                        </div>

                                        @foreach ($deseases as $index => $desease)
                                            <fieldset class="p-4 border border-gray-500 mb-6 relative"  x-show="selectedSubTab1 === '{{ $index + 1 }}'">
                                                <i class="fas fa-times flex cursor-pointer text-red-500 hover:text-red-700 absolute top-4 right-4 {{ $index + 1 === 1 ? 'hidden' : '' }}" title="Remove" wire:click="removeDesease({{ $index }})"></i>
                                                <div class="grid grid-cols-3 gap-4">
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="desease" class="block text-sm font-medium text-gray-700 dark:text-slate-400"><span class="font-bold text-gray-700 dark:text-gray-100">{{ $index + 1 }}.</span> Naitalang sakit (Recorded desease)</label>
                                                        <input type="text" id="desease" wire:model='deseases.{{ $index }}.desease' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                        @error('deseases.' . $index . '.desease')
                                                            <span class="text-red-500 text-sm">The desease is required!</span>
                                                        @enderror
                                                    </div>
                                
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="count" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang (no. of Cases)</label>
                                                        <input type="number" id="count" wire:model='deseases.{{ $index }}.count' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                        @error('deseases.' . $index . '.count')
                                                            <span class="text-red-500 text-sm">The count is required!</span>
                                                        @enderror
                                                    </div>
                                
                                                    <div class="col-span-full sm:col-span-1">
                                                        <label for="response" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Response</label>
                                                        <input type="text" id="response" wire:model='deseases.{{ $index }}.response' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700">
                                                        @error('deseases.' . $index . '.response')
                                                            <span class="text-red-500 text-sm">The response is required!</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </fieldset>
                                        @endforeach
                                    </fieldset>

                                    {{-- Minutes Upload --}}
                                    <div class="col-span-2 sm:col-span-1 mb-6">
                                        <label for="new_childs_name_{{ $index }}" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Minutes of Monthly CSHC Meetings <span class="text-red-500">*</span>
                                            <i class="fas fa-times flex sm:hidden cursor-pointer text-red-500 hover:text-red-700 float-right mr-1" wire:click="removeNewChild({{ $index }})"></i>
                                        </label>
                                        <input type="file" id="minutes" wire:model="minutes" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md  dark:text-gray-300 dark:bg-gray-700" accept="application/pdf">

    
                                        @error('minutes')
                                            <span class="text-red-500 text-sm">The minutes is required!</span>
                                        @enderror
                                    </div>

                                    <div class="w-full flex justify-between items-center">
                                        <button wire:click='previousStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            << Prev
                                        </button>
                                        <button wire:click='nextStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            Next >>
                                        </button>
                                    </div>
                                </div>

                                <div class="{{ $currentStep === 4 ? '' : 'hidden' }}">
                                    <p class="text-sm">Step {{ $currentStep }} of 4</p>

                                    <div class="overflow-x-auto mb-6 mt-4">
                                        <table class="w-full min-w-full border border-neutral-200 dark:border-gray-400 rounded-md">
                                            <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl">
                                                <tr class="whitespace-nowrap">
                                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-gray-700 dark:text-gray-100 text-left uppercase">
                                                        Explosives Consumption Report for this month
                                                    </th>
                                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                    </th>
                                                    <th scope="col" class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl">
                                                <tr class="whitespace-nowrap">
                                                    <th scope="col" class="px-5 py-3 text-xs font-medium text-left uppercase">
                                                        Blasting Contractor <br>
                                                        <input type="text" step="0.01" id="blastingContractor" wire:model="blastingContractor" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700 w-full">
                                                    </th>
                                                    <th scope="col" class="px-5 py-3 text-xs font-medium text-center uppercase">
                                                    </th>
                                                    <th scope="col" class="px-5 py-3 text-xs font-medium text-left uppercase">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <thead class="bg-slate-200 dark:bg-slate-700 rounded-xl">
                                                <tr class="whitespace-nowrap">
                                                    <th scope="col" class="px-5 py-3 text-xs font-medium text-left uppercase">
                                                        Kind of Explosives and Accessories
                                                    </th>
                                                    <th scope="col" class="px-5 py-3 text-xs font-medium text-center uppercase">
                                                        Unit
                                                    </th>
                                                    <th scope="col" class="px-5 py-3 text-xs font-medium text-left uppercase">
                                                        Quantity Used
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-neutral-200 dark:divide-gray-400">
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Dynamite
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        cs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="dynamite" wire:model="dynamite" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Detonating Cord
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        m
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="detonatingCord" wire:model="detonatingCord" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Non-Electric Blasting Caps
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        pcs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="nonElecBlastingCaps" wire:model="nonElecBlastingCaps" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Electronic Blasting Caps 
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        pcs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="elecBlastingCaps" wire:model="elecBlastingCaps" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Fuse Lighter
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        pcs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="fuseLighter" wire:model="fuseLighter" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Connectors
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        pcs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="connectors" wire:model="connectors" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Ammonium Nitrate
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        kgs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="ammoniumNitrate" wire:model="ammoniumNitrate" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Shotshell Primer "209"
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        pcs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="shotshellPrimer" wire:model="shotshellPrimer" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Primer
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        pcs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="primer" wire:model="primer" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        Emulsion
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap">
                                                        kgs
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap">
                                                        <input type="number" step="0.01" id="emulsion" wire:model="emulsion" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap border-b border-neutral-200 dark:border-gray-400">
                                                        Others:
                                                    </td>
                                                    <td class="px-5 py-2 text-center text-xs font-medium whitespace-nowrap border-b border-neutral-200 dark:border-gray-400">
            
                                                    </td>
                                                    <td class="px-5 py-2 text-left text-xs font-medium whitespace-nowrap border-b border-neutral-200 dark:border-gray-400">
                                                        <input type="number" step="0.01" id="others" wire:model="others" class="mt-1 p-2 block float-center shadow-sm sm:text-xs border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" style="width: 130px">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="w-full flex justify-between items-center">
                                        <button wire:click='previousStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            << Prev
                                        </button>
                                        <button wire:click='submit' 
                                            class="mt-4 sm:mt-1 px-6 py-1.5 bg-green-500 rounded-md text-sm
                                            hover:bg-green-600 focus:outline-none
                                            text-white" wire:loading.attr='disabled' wire:target="saveChildren">
                                            <span wire:loading.remove wire:target="saveChildren">Submit</span>
                                            <div wire:loading wire:target="saveChildren" style="margin-bottom: 5px;">
                                                <div class="spinner-border small text-primary" role="status">
                                                </div>
                                            </div>
                                        </button>
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
