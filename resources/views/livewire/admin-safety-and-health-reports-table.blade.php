<div class="w-full flex justify-center">
    <div class="w-full bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md">
        <h1 class="text-lg font-bold text-center text-black dark:text-white mb-6">
            MGB CALABARZON CUMULATIVE SAFETY AND HEALTH REPORT {{ $selectedYear }}
        </h1>
        
        <div class="mb-4 flex justify-between items-end">
            <!-- Search Mine Operators -->
            <div class="w-1/3">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search Mine Operators</label>
                <input wire:model.live="search" type="text" id="search" placeholder="Enter mine operator name" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
            </div>
            
            <!-- Year Selection -->
            <div class="w-1/3">
                <label for="year-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Year</label>
                <select wire:model.live="selectedYear" id="year-select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500">
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
                        <th class="px-4 py-2 text-center">Quarter</th>
                        <th class="px-4 py-2 text-center">NLTA</th>
                        <th class="px-4 py-2 text-center">LTA-NF</th>
                        <th class="px-4 py-2 text-center">LTA-F</th>
                        <th class="px-4 py-2 text-center">Days Lost</th>
                        <th class="px-4 py-2 text-center">Manhours Worked</th>
                        <th class="px-4 py-2 text-center">No. of Male Employees</th>
                        <th class="px-4 py-2 text-center">No. of Female Employees</th>
                        <th class="px-4 py-2 text-center">Total Employees</th>
                        <th class="px-4 py-2 text-center">Recorded Diseases</th>
                        <th class="px-4 py-2 text-center">No. of Cases</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $mineOperator => $data)
                        @foreach (['First Quarter', 'Second Quarter', 'Third Quarter', 'Fourth Quarter'] as $quarterName)
                            <tr class="whitespace-nowrap">
                                <td class="px-4 py-2 text-center">{{ $mineOperator }}</td>
                                <td class="px-4 py-2 text-center">{{ $data['Tenement'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $quarterName }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['NLTA'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['LTA-NF'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['LTA-F'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['Days Lost'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['Manhours Worked'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['Male Employees'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['Female Employees'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['Total Employees'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['Recorded Diseases'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $data[$quarterName]['No. of Cases'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
