<div class="w-full">

    <style>
        .scrollbar-thin1::-webkit-scrollbar {
            width: 5px;
        }

        .scrollbar-thin1::-webkit-scrollbar-thumb {
            background-color: #c0c0c04b;
        }

        .scrollbar-thin1::-webkit-scrollbar-track {
            background-color: #ffffff23;
        }

        @media (max-width: 1024px) {
            .custom-d {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .m-scrollable {
                width: 100%;
                overflow-x: scroll;
            }
        }

        @media (min-width:1024px) {
            .custom-p {
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
    </style>

    <div class="flex justify-center w-full">
        <div class="w-full bg-white rounded-2xl p-3 sm:p-6 shadow dark:bg-gray-800 overflow-x-visible">
            <div class="pb-4 mb-3 pt-4 sm:pt-0">
                <h1 class="text-lg font-bold text-center text-slate-800 dark:text-white">List of Candidates</h1>
            </div>

            <div class="mb-6 flex flex-col sm:flex-row items-end justify-between">
                <div class="w-full sm:w-1/3 sm:mr-4">
                    <label for="search"
                        class="block text-sm font-medium text-gray-700 dark:text-slate-400 mb-1">Search</label>
                    <input type="text" id="search" wire:model.live="search"
                        class="px-2 py-1.5 block w-full shadow-sm sm:text-sm border border-gray-400 hover:bg-gray-300 rounded-md
                            dark:hover:bg-slate-600 dark:border-slate-600
                            dark:text-gray-300 dark:bg-gray-800"
                        placeholder="Enter name of candidates">
                </div>
            </div>

            <!-- Table -->
            <div class="w-full">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
                        <div class="inline-block w-full py-2 align-middle">
                            <div class="overflow-hidden border dark:border-gray-700 rounded-lg">
                                <div class="overflow-x-auto">
                                    <table class="w-full min-w-full">
                                        <thead class="bg-gray-200 dark:bg-gray-700 rounded-xl">
                                            <tr class="whitespace-nowrap">
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                    Fullname
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                    Address
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                    Position
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-left uppercase">
                                                    Qualification
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                    Property Title
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                    HOA Due Certificate
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                    Special Power of Attorney
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                    Signed Certificate of Candidacy
                                                </th>
                                                <th scope="col"
                                                    class="px-5 py-3 text-sm font-medium text-center uppercase">
                                                    Status
                                                </th>
                                                <th
                                                    class="px-5 py-3 text-gray-100 text-sm font-medium text-center uppercase sticky right-0 z-10 bg-gray-600 dark:bg-gray-600">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-200 dark:divide-gray-400">
                                            @foreach ($users as $user)
                                                <tr class="text-neutral-800 dark:text-neutral-200">
                                                    <!-- Fullname -->
                                                    <td
                                                        class="px-5 py-4 text-left text-sm font-medium whitespace-nowrap">
                                                        {{ $user->firstname }} {{ $user->middlename }}
                                                        {{ $user->lastname }}
                                                    </td>

                                                    <!-- Address -->
                                                    <td
                                                        class="px-5 py-4 text-left text-sm font-medium whitespace-nowrap">
                                                        {{ $user->address ?? 'N/A' }}
                                                    </td>

                                                    <!-- Position -->
                                                    <td
                                                        class="px-5 py-4 text-left text-sm font-medium whitespace-nowrap">
                                                        {{ $user->position ?? 'N/A' }}
                                                    </td>

                                                    <!-- Qualification -->
                                                    <td
                                                        class="px-5 py-4 text-left text-sm font-medium whitespace-nowrap">
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

                                                    <!-- Property Title -->
                                                    {{-- <td
                                                        class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                        @if ($user->property_title_path)
                                                            <a href="{{ Storage::url($user->property_title_path) }}"
                                                                target="_blank"
                                                                class="text-sky-800 dark:text-sky-600 hover:underline">
                                                                Property Title
                                                            </a>
                                                        @else
                                                            <span class="text-gray-500">Not uploaded</span>
                                                        @endif
                                                    </td>

                                                    <!-- HOA Due Certificate -->
                                                    <td
                                                        class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
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

                                                    <!-- Special Power of Attorney -->
                                                    <td
                                                        class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
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
                                                    <td
                                                        class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                        @if ($user->upload_file_path)
                                                            <a href="{{ Storage::url($user->upload_file_path) }}"
                                                                target="_blank"
                                                                class="text-sky-800 dark:text-sky-600 hover:underline">
                                                                Signed Certificate of Candidacy
                                                            </a>
                                                        @else
                                                            <span class="text-gray-500">Not uploaded</span>
                                                        @endif
                                                    </td> --}}
                                                    <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                        @if ($user->property_title_path)
                                                            Property Title
                                                            @if (in_array(pathinfo($user->property_title_path, PATHINFO_EXTENSION), ['pdf', 'docx', 'txt', 'csv']))
                                                                <a class="btn-submit"
                                                                    href="{{ asset('attachments/' . $user->property_title_path) }}"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye text-blue-500"></i>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-500">Not uploaded</span>
                                                        @endif
                                                    </td>

                                                    <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                        @if ($user->hoa_due_certificate_path)
                                                            Hoa Due Certificate
                                                            @if (in_array(pathinfo($user->hoa_due_certificate_path, PATHINFO_EXTENSION), ['pdf', 'docx', 'txt', 'csv']))
                                                                <a class="btn-submit"
                                                                    href="{{ asset('attachments/' . $user->hoa_due_certificate_path) }}"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye text-blue-500"></i>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-500">Not uploaded</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                        @if ($user->special_power_of_attorney_path)
                                                            Hoa Due Certificate
                                                            @if (in_array(pathinfo($user->special_power_of_attorney_path, PATHINFO_EXTENSION), ['pdf', 'docx', 'txt', 'csv']))
                                                                <a class="btn-submit"
                                                                    href="{{ asset('attachments/' . $user->special_power_of_attorney_path) }}"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye text-blue-500"></i>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-500">Not uploaded</span>
                                                        @endif
                                                    </td>

                                                    <td class="px-5 py-3 text-sm text-gray-800 dark:text-gray-200">
                                                        @if ($user->upload_file_path)
                                                            Signed Certificate of Candidacy
                                                            @if (in_array(pathinfo($user->upload_file_path, PATHINFO_EXTENSION), ['pdf', 'docx', 'txt', 'csv']))
                                                                <a class="btn-submit"
                                                                    href="{{ asset('attachments/' . $user->upload_file_path) }}"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye text-blue-500"></i>
                                                                </a>
                                                            @endif
                                                        @else
                                                            <span class="text-gray-500">Not uploaded</span>
                                                        @endif
                                                    </td>
                                                    <!-- Status Column -->
                                                    <td
                                                        class="px-5 py-4 text-center text-sm font-medium whitespace-nowrap">
                                                        @if ($user->status === 'Approved')
                                                            <span
                                                                class="w-fit inline-flex overflow-hidden rounded-2xl border border-green-600 bg-white text-xs font-medium text-green-600 dark:border-green-600 dark:bg-slate-900 dark:text-green-600">
                                                                <span
                                                                    class="px-2 py-1 bg-green-600/10 dark:bg-green-600/10">
                                                                    {{ $user->status }}
                                                                </span>
                                                            </span>
                                                        @elseif ($user->status === 'Disapproved')
                                                            <span
                                                                class="w-fit inline-flex overflow-hidden rounded-2xl border border-red-600 bg-white text-xs font-medium text-red-600 dark:border-red-600 dark:bg-slate-900 dark:text-red-600">
                                                                <span
                                                                    class="px-2 py-1 bg-red-600/10 dark:bg-red-600/10">
                                                                    {{ $user->status }}
                                                                </span>
                                                            </span>
                                                        @else
                                                            <span
                                                                class="w-fit inline-flex overflow-hidden rounded-2xl border border-amber-500 bg-white text-xs font-medium text-amber-500 dark:border-amber-500 dark:bg-slate-900 dark:text-amber-500">
                                                                <span
                                                                    class="px-2 py-1 bg-amber-500/10 dark:bg-amber-500/10">
                                                                    {{ $user->status }}
                                                                </span>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <!-- Action Column -->
                                                    <td
                                                        class="px-5 py-4 text-sm font-medium text-center whitespace-nowrap sticky right-0 z-10 bg-white dark:bg-gray-800">
                                                        @if ($user->status === 'For Review by ELECOM')
                                                            <button wire:click="approveUser({{ $user->id }})"
                                                                class="bg-green-500 text-white px-3 py-1 rounded">
                                                                Approve
                                                            </button>
                                                            <button wire:click="disapproveUser({{ $user->id }})"
                                                                class="bg-red-500 text-white px-3 py-1 rounded">
                                                                Disapprove
                                                            </button>
                                                        @elseif ($user->status === 'Not Applied Yet')
                                                            <span class="text-gray-500 italic">Not Applied Yet</span>
                                                        @else
                                                            {{-- <span
                                                                class="bg-blue-500 text-white px-3 py-1 rounded">{{ $user->status }}</span> --}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <div class="p-5 text-neutral-500 dark:text-neutral-200 bg-gray-200 dark:bg-gray-700">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
