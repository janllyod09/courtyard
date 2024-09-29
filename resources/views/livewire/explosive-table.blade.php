<div class="w-full flex justify-center">
    <div class="w-full bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md">
        <h1 class="text-lg font-bold text-center text-black dark:text-white mb-6">
            Explosives Consumption Report
        </h1>

        <!-- Search and Filter -->
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-end">
            <!-- Search Input -->
            <div class="w-full sm:w-1/2 mb-4 sm:mb-0 sm:mr-4">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="Search Mine Operator or Tenement" 
                class="w-full px-4 py-2 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-gray-300" 
            />
            </div>
        
            <!-- Year Dropdown -->
            <div class="w-full sm:w-1/3">
            <select 
                wire:model.live="year" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
            >
                <option value="">All Years</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            </div>
        </div>
        

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 overflow-hidden">
                <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl">
                    <tr class="whitespace-nowrap">
                        <th class="px-4 py-2 text-center">Mine Operator</th>
                        <th class="px-4 py-2 text-center">Tenement / Permit No.</th>
                        <th class="px-4 py-2 text-center">Blasting Contractor</th>
                        <th class="px-4 py-2 text-center">Dynamite</th>
                        <th class="px-4 py-2 text-center">Detonating Cord</th>
                        <th class="px-4 py-2 text-center">Non-Electric Blasting Caps</th>
                        <th class="px-4 py-2 text-center">Electronic Blasting Caps</th>
                        <th class="px-4 py-2 text-center">Fuse Lighter</th>
                        <th class="px-4 py-2 text-center">Connectors</th>
                        <th class="px-4 py-2 text-center">Ammonium Nitrate</th>
                        <th class="px-4 py-2 text-center">Shotshell Primer "209"</th>
                        <th class="px-4 py-2 text-center">Primer</th>
                        <th class="px-4 py-2 text-center">Emulsion</th>
                        <th class="px-4 py-2 text-center">Others</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consumptions as $consumption)
                    <tr class="whitespace-nowrap">
                        <td class="px-4 py-2 text-center">{{ $consumption['mine_operator'] }}</td>
                        <td class="px-4 py-2 text-center">
                            @foreach ($consumption['permit_no'] as $item)
                                {{ $item->permit_number }} <br>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 text-center">{{ $consumption['blasting_contractor'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['dynamite'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['detonating_cord'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['non_elec_blasting_caps'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['elec_blasting_caps'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['fuse_lighter'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['connectors'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['ammonium_nitrate'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['shotshell_primer'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['primer'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['emulsion'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $consumption['others'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
