@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Wishes Management" />
    
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Wishes List</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Manage and moderate wishes from visitors
                </p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <!-- Filter Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 10H15M2.5 5H17.5M7.5 15H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        {{ request('filter') ? ucfirst(request('filter')) : 'All Wishes' }}
                    </button>
                    
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700 z-10"
                        x-cloak
                    >
                        <a href="{{ route('panel.wishes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            All Wishes
                        </a>
                        <a href="{{ route('panel.wishes.index', ['filter' => 'pending']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            Pending
                        </a>
                        <a href="{{ route('panel.wishes.index', ['filter' => 'approved']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            Approved
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('panel.wishes.index') }}">
                    <div class="relative">
                        <button type="submit" class="absolute -translate-y-1/2 left-4 top-1/2">
                            <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill=""/>
                            </svg>
                        </button>
                        <input 
                            type="text" 
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search wishes..." 
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[250px]"
                        />
                        @if(request('search'))
                            <a href="{{ route('panel.wishes.index') }}" class="absolute -translate-y-1/2 right-3 top-1/2 text-gray-400 hover:text-gray-600">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 px-5 mb-6 sm:grid-cols-3 sm:px-6">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-50 rounded-lg dark:bg-blue-500/10">
                        <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Wishes</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalWishes }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-50 rounded-lg dark:bg-orange-500/10">
                        <svg class="w-6 h-6 text-orange-500 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-semibold text-orange-600 dark:text-orange-400">{{ $pendingWishes }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg dark:bg-emerald-500/10">
                        <svg class="w-6 h-6 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Approved</p>
                        <p class="text-2xl font-semibold text-emerald-600 dark:text-emerald-400">{{ $approvedWishes }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if($wishes->isEmpty())
            <div class="px-6 py-12 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No wishes found</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ request('search') ? 'No wishes match your search criteria' : 'No wishes have been submitted yet' }}
                </p>
            </div>
        @else
            <!-- Bulk Actions -->
            <div class="px-5 mb-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button 
                        onclick="submitBulkApprove()"
                        id="bulk-approve-btn"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled
                    >
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.0834 5.4165L7.50008 14.9998L3.33341 10.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Approve Selected (<span id="selected-count">0</span>)
                    </button>
                    
                    <button 
                        onclick="submitBulkDelete()"
                        id="bulk-delete-btn"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-400 px-4 py-2 text-sm font-medium text-white hover:bg-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled
                    >
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.16699 5.8335H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7.5 9.1665V13.3332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12.5 9.1665V13.3332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M5.83301 5.8335L6.73959 15.0735C6.79744 15.688 7.31839 16.1668 7.9354 16.1668H12.0646C12.6816 16.1668 13.2026 15.688 13.2604 15.0735L14.167 5.8335" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Delete Selected (<span id="selected-count-delete">0</span>)
                    </button>
                </div>

                <!-- Bulk Action Forms -->
                <form id="bulk-approve-form" method="POST" action="{{ route('panel.wishes.bulk-approve') }}">
                    @csrf
                    <div id="bulk-approve-inputs"></div>
                </form>
                
                <form id="bulk-delete-form" method="POST" action="{{ route('panel.wishes.bulk-delete') }}">
                    @csrf
                    <div id="bulk-delete-inputs"></div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-hidden">
                <div class="max-w-full px-5 overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-gray-200 border-y dark:border-gray-700">
                                <th scope="col" class="px-4 py-3 w-10">
                                    <input type="checkbox" id="select-all" class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700">
                                </th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">#</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Name</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Email</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Message</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Status</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Date</th>
                                <th scope="col" class="relative px-4 py-3 capitalize">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($wishes as $index => $wish)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="row-checkbox w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700" value="{{ $wish->id }}">
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $wishes->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $wish->name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $wish->email ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                                            <span title="{{ $wish->message }}">
                                                {{ \Str::limit($wish->message, 100) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($wish->is_approved)
                                            <span class="px-2 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-full dark:bg-emerald-500/10 dark:text-emerald-400">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium text-orange-700 bg-orange-50 rounded-full dark:bg-orange-500/10 dark:text-orange-400">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $wish->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Approve/Reject Button -->
                                            @if(!$wish->is_approved)
                                                <form action="{{ route('panel.wishes.approve', $wish) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button 
                                                        type="submit"
                                                        class="inline-flex items-center justify-center p-2 text-emerald-600 rounded-lg hover:bg-emerald-50 hover:text-emerald-700 dark:text-emerald-400 dark:hover:bg-emerald-500/10"
                                                        title="Approve"
                                                    >
                                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M17.0834 5.4165L7.50008 14.9998L3.33341 10.8332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('panel.wishes.reject', $wish) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button 
                                                        type="submit"
                                                        class="inline-flex items-center justify-center p-2 text-orange-600 rounded-lg hover:bg-orange-50 hover:text-orange-700 dark:text-orange-400 dark:hover:bg-orange-500/10"
                                                        title="Reject"
                                                    >
                                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.16675 10H15.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete Button -->
                                            <form action="{{ route('panel.wishes.destroy', $wish) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this wish?');">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="inline-flex items-center justify-center p-2 text-red-400 rounded-lg hover:bg-red-50 hover:text-red-500 dark:text-red-400 dark:hover:bg-red-500/10"
                                                    title="Delete"
                                                >
                                                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4.16699 5.8335H15.8337" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M7.5 9.1665V13.3332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M12.5 9.1665V13.3332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        <path d="M5.83301 5.8335L6.73959 15.0735C6.79744 15.688 7.31839 16.1668 7.9354 16.1668H12.0646C12.6816 16.1668 13.2026 15.688 13.2604 15.0735L14.167 5.8335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-white/[0.05]">
                {{ $wishes->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const approveBtn = document.getElementById('bulk-approve-btn');
        const deleteBtn = document.getElementById('bulk-delete-btn');
        const selectedCountSpan = document.getElementById('selected-count');
        const selectedCountDeleteSpan = document.getElementById('selected-count-delete');
        const approveInputs = document.getElementById('bulk-approve-inputs');
        const deleteInputs = document.getElementById('bulk-delete-inputs');
        
        // Hide forms initially
        document.getElementById('bulk-approve-form').style.display = 'none';
        document.getElementById('bulk-delete-form').style.display = 'none';
        
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            const count = selected.length;
            
            selectedCountSpan.textContent = count;
            selectedCountDeleteSpan.textContent = count;
            
            // Enable/disable buttons
            approveBtn.disabled = count === 0;
            deleteBtn.disabled = count === 0;
            
            // Update select all checkbox
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = count === rowCheckboxes.length;
                selectAllCheckbox.indeterminate = count > 0 && count < rowCheckboxes.length;
            }
            
            // Update form inputs
            updateFormInputs(selected);
        }
        
        function updateFormInputs(selectedCheckboxes) {
            // Clear existing inputs
            approveInputs.innerHTML = '';
            deleteInputs.innerHTML = '';
            
            // Add selected IDs to forms
            selectedCheckboxes.forEach(checkbox => {
                const id = checkbox.value;
                
                // Add to approve form
                const approveInput = document.createElement('input');
                approveInput.type = 'hidden';
                approveInput.name = 'ids[]';
                approveInput.value = id;
                approveInputs.appendChild(approveInput);
                
                // Add to delete form
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'ids[]';
                deleteInput.value = id;
                deleteInputs.appendChild(deleteInput);
            });
        }
        
        // Select all functionality
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });
        }
        
        // Individual row checkboxes
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
        
        // Submit functions
        window.submitBulkApprove = function() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            if (selected.length > 0 && confirm('Approve selected wishes?')) {
                document.getElementById('bulk-approve-form').submit();
            }
        };
        
        window.submitBulkDelete = function() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            if (selected.length > 0 && confirm('Delete selected wishes?')) {
                document.getElementById('bulk-delete-form').submit();
            }
        };
    });
</script>
@endpush