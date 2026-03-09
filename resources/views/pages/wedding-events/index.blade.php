@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Wedding Events" />
    
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Wedding Events</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Manage wedding events and schedules
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
                        {{ request('status') ? ucfirst(request('status')) : 'All Events' }}
                    </button>
                    
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700 z-10"
                        x-cloak
                    >
                        <a href="{{ route('panel.wedding-events.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            All Events
                        </a>
                        <a href="{{ route('panel.wedding-events.index', ['status' => 'active']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            Active
                        </a>
                        <a href="{{ route('panel.wedding-events.index', ['status' => 'inactive']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            Inactive
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('panel.wedding-events.index') }}">
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
                            placeholder="Search events..." 
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[250px]"
                        />
                        @if(request('search'))
                            <a href="{{ route('panel.wedding-events.index') }}" class="absolute -translate-y-1/2 right-3 top-1/2 text-gray-400 hover:text-gray-600">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>

                <a 
                    href="{{ route('panel.wedding-events.create') }}" 
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.1665V15.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M4.16699 10H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Add New Event
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 px-5 mb-6 sm:grid-cols-4 sm:px-6">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-50 rounded-lg dark:bg-blue-500/10">
                        <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Events</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalEvents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 rounded-lg dark:bg-emerald-500/10">
                        <svg class="w-6 h-6 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Active</p>
                        <p class="text-2xl font-semibold text-emerald-600 dark:text-emerald-400">{{ $activeEvents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-50 rounded-lg dark:bg-purple-500/10">
                        <svg class="w-6 h-6 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Upcoming</p>
                        <p class="text-2xl font-semibold text-purple-600 dark:text-purple-400">{{ $upcomingEvents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-50 rounded-lg dark:bg-amber-500/10">
                        <svg class="w-6 h-6 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sort Order</p>
                        <p class="text-2xl font-semibold text-amber-600 dark:text-amber-400">Drag to sort</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if($events->isEmpty())
            <div class="px-6 py-12 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No wedding events found</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ request('search') ? 'No events match your search criteria' : 'Get started by creating your first wedding event' }}
                </p>
                @if(!request('search'))
                    <a 
                        href="{{ route('panel.wedding-events.create') }}" 
                        class="inline-flex items-center justify-center gap-2 mt-4 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4.1665V15.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M4.16699 10H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Add New Event
                    </a>
                @endif
            </div>
        @else
            <!-- Sortable Table -->
            <div class="overflow-hidden" x-data="sortableEvents()">
                <div class="max-w-full px-5 overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-gray-200 border-y dark:border-gray-700">
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">#</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Event</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Date & Time</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Location</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Image</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Status</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Sort</th>
                                <th scope="col" class="relative px-4 py-3 capitalize">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sortable-table" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($events as $index => $event)
                                <tr data-id="{{ $event->id }}" class="sortable-row">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $events->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="cursor-move handle" title="Drag to reorder">
                                                <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $event->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                                    {{ Str::limit($event->description, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $event->formatted_date_time }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $event->location_name }}
                                        </div>
                                        @if($event->gmaps_link)
                                            <a href="{{ $event->gmaps_link }}" target="_blank" class="text-xs text-brand-500 hover:underline inline-flex items-center gap-1 mt-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                View Map
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($event->image)
                                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100">
                                                <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($event->is_active)
                                            <span class="px-2 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-full dark:bg-emerald-500/10 dark:text-emerald-400">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-400">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $event->sort_order }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Toggle Active/Inactive -->
                                            <form action="{{ route('panel.wedding-events.toggle-active', $event) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button 
                                                    type="submit"
                                                    class="inline-flex items-center justify-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                    title="{{ $event->is_active ? 'Set Inactive' : 'Set Active' }}"
                                                >
                                                    @if($event->is_active)
                                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M4.16675 10H15.8334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    @else
                                                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M10 4.1665V15.8332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M4.16699 10H15.8337" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            <!-- View Button -->
                                            <a 
                                                href="{{ route('panel.wedding-events.show', $event) }}"
                                                class="inline-flex items-center justify-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                title="View Details"
                                            >
                                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.5 4.1665H15.8333C16.2754 4.1665 16.6993 4.3421 17.0118 4.65466C17.3244 4.96722 17.5 5.39114 17.5 5.83317V15.8332C17.5 16.2752 17.3244 16.6991 17.0118 17.0117C16.6993 17.3242 16.2754 17.4998 15.8333 17.4998H4.16667C3.72464 17.4998 3.30072 17.3242 2.98816 17.0117C2.67559 16.6991 2.5 16.2752 2.5 15.8332V5.83317C2.5 5.39114 2.67559 4.96722 2.98816 4.65466C3.30072 4.3421 3.72464 4.1665 4.16667 4.1665H7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                    <path d="M12.5 2.5H7.5C6.857 2.5 6.333 3.024 6.333 3.667V4.333C6.333 4.976 6.857 5.5 7.5 5.5H12.5C13.143 5.5 13.667 4.976 13.667 4.333V3.667C13.667 3.024 13.143 2.5 12.5 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                            </a>

                                            <!-- Edit Button -->
                                            <a 
                                                href="{{ route('panel.wedding-events.edit', $event) }}"
                                                class="inline-flex items-center justify-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                title="Edit"
                                            >
                                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.8334 10.0002V15.8335C15.8334 16.2755 15.6578 16.6995 15.3452 17.012C15.0327 17.3246 14.6087 17.5002 14.1667 17.5002H4.16675C3.72472 17.5002 3.3008 17.3246 2.98824 17.012C2.67568 16.6995 2.50008 16.2755 2.50008 15.8335V5.8335C2.50008 5.39147 2.67568 4.96755 2.98824 4.65499C3.3008 4.34243 3.72472 4.16683 4.16675 4.16683H10.0001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                    <path d="M14.1667 2.5L17.5 5.83333L9.16667 14.1667H5.83334V10.8333L14.1667 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('panel.wedding-events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this wedding event?');">
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
                {{ $events->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    function sortableEvents() {
        return {
            init() {
                const table = document.getElementById('sortable-table');
                if (!table) return;

                new Sortable(table, {
                    animation: 150,
                    handle: '.handle',
                    onEnd: (evt) => {
                        this.updateOrder();
                    }
                });
            },
            updateOrder() {
                const items = [];
                document.querySelectorAll('#sortable-table .sortable-row').forEach((row, index) => {
                    items.push({
                        id: row.dataset.id,
                        sort_order: index + 1
                    });
                });

                fetch('{{ route("panel.wedding-events.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update sort order display
                        document.querySelectorAll('#sortable-table td:nth-child(7)').forEach((cell, index) => {
                            cell.textContent = index + 1;
                        });
                        
                        // Show success toast
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    }
                })
                .catch(error => console.error('Error updating order:', error));
            }
        };
    }
</script>
@endpush