<div class="w-full flex flex-col items-center">
    <div class="w-full bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md">
        <h1 class="text-lg font-bold text-center text-black dark:text-white mb-6">
            Accident Report
        </h1>
        
        <!-- Search and Filter -->
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-end">
            <!-- Search Input -->
            <div class="w-full sm:w-1/2 mb-4 sm:mb-0 sm:mr-4">
                <input type="text" class="w-full px-4 py-2 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-gray-300"
                    placeholder="Search by Mine Operator" wire:model.live="searchTerm">
            </div>
        
            <!-- Filter by Year -->
            <div class="w-full sm:w-1/3">
                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" wire:model.live="filterYear">
                    <option value="">All Years</option>
                    @foreach(range(date('Y'), date('Y') - 10) as $year) <!-- Show past 10 years -->
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        

        <!-- Accident Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 overflow-hidden">
                <thead class="bg-gray-200 dark:bg-gray-700">
                    <tr class="whitespace-nowrap">
                        <th class="px-4 py-2 text-center">Accident Type</th>
                        <th class="px-4 py-2 text-center">Mine Operator</th>
                        <th class="px-4 py-2 text-center">Tenement / Permit No.</th>
                        <th class="px-4 py-2 text-center">Days Lost</th>
                        <th class="px-4 py-2 text-center">Name of Injured Personnel</th>
                        <th class="px-4 py-2 text-center">Sex</th>
                        <th class="px-4 py-2 text-center">Age</th>
                        <th class="px-4 py-2 text-center">Position</th>
                        <th class="px-4 py-2 text-center">Service Contractor</th>
                        <th class="px-4 py-2 text-center">Date of Accident</th>
                        <th class="px-4 py-2 text-center">Time of Accident</th>
                        <th class="px-4 py-2 text-center">Location of Accident</th>
                        <th class="px-4 py-2 text-center">Kind of Accident</th>
                        <th class="px-4 py-2 text-center">Type of Injury</th>
                        <th class="px-4 py-2 text-center">Part of Body Injured</th>
                        <th class="px-4 py-2 text-center">Treatment</th>
                        <th class="px-4 py-2 text-center">Total Accident Cost</th>
                        <th class="px-4 py-2 text-center">Description of Accident</th>
                    </tr>
                </thead>
                <tbody>
                    @if($accidents->isEmpty())
                        <tr>
                            <td colspan="18" class="px-4 py-2 text-center">No accident records found.</td>
                        </tr>
                    @else
                        @foreach($accidents as $accident)
                            <tr class="whitespace-nowrap">
                                <td class="px-4 py-2 text-center">{{ $accident['accident_type'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['mine_operator'] }}</td>
                                <td class="px-4 py-2 text-center">
                                    @foreach ($accident['permit_no'] as $item)  
                                        {{ $item->permit_number }} <br>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 text-center">{{ $accident['days_lost'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['name'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['gender'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['age'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['position'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['service_contractor'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['date_of_accident'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['time_of_accident'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['location'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['kind_of_accident'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['type_of_injury'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['part_of_body_injured'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['treatment'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['total_accident_cost'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $accident['description_of_accident'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
