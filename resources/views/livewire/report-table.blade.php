<div class="w-full">


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
                                            <th scope="col" class="px-5 py-3 font-medium text-left uppercase">
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
                                            <th class="px-5 py-3 text-gray-100 font-medium text-center uppercase sticky right-0 z-10 bg-gray-600 dark:bg-gray-600">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-neutral-200 dark:divide-gray-400 text-xs">
                                        @foreach ($reports as $report)
                                            <tr class="text-neutral-800 dark:text-neutral-200">
                                                <td class="px-5 py-4 text-left font-medium whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($report->month)->format('F') }}
                                                </td>
                                                <td class="px-5 py-4 text-left font-medium whitespace-nowrap">
                                                    {{ $report->date_encoded }}
                                                </td>
                                                <td class="px-5 py-4 text-left font-medium whitespace-nowrap">
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
                                                    {{ $report->minutes }}
                                                </td>
                                                <td class="px-5 py-4 font-medium text-center whitespace-nowrap sticky right-0 z-10 bg-white dark:bg-gray-800">
                                                    <div class="relative">
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
                                    <div class="grid grid-cols-3 gap-4 mt-6">
                                        <div class="col-span-full sm:col-span-1">
                                            <label for="surname" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Encoder</label>
                                            <input type="text" id="surname" wire:model='surname' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" readonly>
                                        </div>
                                        <div class="col-span-full sm:col-span-1">
                                            <label for="surname" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Company</label>
                                            <input type="text" id="surname" wire:model='surname' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" readonly>
                                        </div>
                                        <div class="col-span-full sm:col-span-1">
                                            <label for="surname" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Permit Number</label>
                                            <input type="text" id="surname" wire:model='surname' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700" readonly>
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
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="manHours" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang ng oras paggawa (Manhours Worked) <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" id="manHours" wire:model='manHours' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mt-8 mb-8">
                                        <div class="col-span-2 sm:col-span-1 grid grid-cols-2 gap-4">
                                            <div class="col-span-2 sm:col-span-1">
                                                <label for="maleWorkers" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang ng Empleyado (Manpower)</label>
                                                <label for="maleWorkers" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Lalake (Male) <span class="text-red-500">*</span></label>
                                                <input type="number" id="maleWorkers" wire:model='maleWorkers' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                            </div>
                                            <div class="col-span-2 sm:col-span-1">
                                                <div class="customdiv"></div>
                                                <label for="femaleWorkers" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Babae (Female) <span class="text-red-500">*</span></label>
                                                <input type="number" id="femaleWorkers" wire:model='femaleWorkers' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
                                            </div>
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <div class="customdiv"></div>
                                            <label for="serviceContractors" class="block text-sm font-medium text-gray-700 dark:text-slate-400">Bilang ng Service Contractors <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" id="serviceContractors" wire:model='serviceContractors' class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-700">
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
                                    <h1>Step 2</h1>


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

                                <div class="{{ $currentStep === 3 ? '' : 'hidden' }}">
                                    <h1>Step 3</h1>


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
                                    <h1>Step 4</h1>


                                    <div class="w-full flex justify-between items-center">
                                        <button wire:click='previousStep' 
                                            class="mt-4 sm:mt-1 px-2 py-1.5 bg-blue-500 rounded-md text-sm
                                            hover:bg-blue-600 focus:outline-none
                                            text-white">
                                            << Prev
                                        </button>
                                        <button wire:click='saveReport' 
                                            class="mt-4 sm:mt-1 px-6 py-1.5 bg-green-500 rounded-md text-sm
                                            hover:bg-green-600 focus:outline-none
                                            text-white">
                                            Submit
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
