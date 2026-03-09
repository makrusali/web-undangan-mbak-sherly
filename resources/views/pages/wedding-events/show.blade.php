@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Event Details" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Event Information</h4>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('panel.wedding-events.edit', $weddingEvent) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors"
                >
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8334 10.0002V15.8335C15.8334 16.2755 15.6578 16.6995 15.3452 17.012C15.0327 17.3246 14.6087 17.5002 14.1667 17.5002H4.16675C3.72472 17.5002 3.3008 17.3246 2.98824 17.012C2.67568 16.6995 2.50008 16.2755 2.50008 15.8335V5.8335C2.50008 5.39147 2.67568 4.96755 2.98824 4.65499C3.3008 4.34243 3.72472 4.16683 4.16675 4.16683H10.0001" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M14.1667 2.5L17.5 5.83333L9.16667 14.1667H5.83334V10.8333L14.1667 2.5Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Edit
                </a>
                <a 
                    href="{{ route('panel.wedding-events.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Event Image -->
            <div class="col-span-1 md:col-span-2">
                @if($weddingEvent->image)
                    <div class="rounded-lg overflow-hidden bg-gray-100 max-h-96">
                        <img src="{{ $weddingEvent->image_url }}" alt="{{ $weddingEvent->name }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="flex items-center justify-center h-48 bg-gray-100 rounded-lg dark:bg-gray-800">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Event Name -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Event Name</label>
                <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $weddingEvent->name }}</p>
            </div>

            <!-- Date and Time -->
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Date</label>
                <p class="mt-1 text-base text-gray-900 dark:text-white">
                    {{ $weddingEvent->date->format('l, d F Y') }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Time</label>
                <p class="mt-1 text-base text-gray-900 dark:text-white">
                    {{ $weddingEvent->formatted_time }}
                </p>
            </div>

            <!-- Location -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Location</label>
                <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $weddingEvent->location_name }}</p>
            </div>

            <!-- Google Maps Link -->
            @if($weddingEvent->gmaps_link)
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Google Maps</label>
                <div class="mt-1 flex items-center gap-2">
                    <a href="{{ $weddingEvent->gmaps_link }}" target="_blank" class="text-brand-500 hover:underline inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Open in Google Maps
                    </a>
                    <button 
                        onclick="navigator.clipboard.writeText('{{ $weddingEvent->gmaps_link }}')"
                        class="text-xs text-gray-500 hover:text-gray-700 inline-flex items-center gap-1"
                        title="Copy link"
                    >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copy
                    </button>
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($weddingEvent->description)
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <p class="text-base text-gray-900 dark:text-white whitespace-pre-line">{{ $weddingEvent->description }}</p>
                </div>
            </div>
            @endif

            <!-- Status and Sort Order -->
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <div class="mt-1">
                    @if($weddingEvent->is_active)
                        <span class="px-3 py-1 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-full dark:bg-emerald-500/10 dark:text-emerald-400">
                            Active
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-400">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sort Order</label>
                <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $weddingEvent->sort_order }}</p>
            </div>

            <!-- Metadata -->
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $weddingEvent->created_at->format('F d, Y h:i A') }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $weddingEvent->updated_at->format('F d, Y h:i A') }}
                </p>
            </div>
        </div>
    </div>
@endsection