@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Create Wedding Event" />

    @if($errors->any())
        <div class="mb-4 rounded-lg bg-error-50 p-4 dark:bg-error-500/10">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-error-600 dark:text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-error-600 dark:text-error-500">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="POST" action="{{ route('panel.wedding-events.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-5">
                <!-- Event Name -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Event Name <span class="text-error-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g., Akad Nikah, Resepsi, Wedding Party"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('name') border-error-500 @enderror"
                        required
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Date <span class="text-error-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="date"
                            value="{{ old('date') }}"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('date') border-error-500 @enderror"
                            required
                        />
                        @error('date')
                            <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Time Start <span class="text-error-500">*</span>
                        </label>
                        <input 
                            type="time" 
                            name="time_start"
                            value="{{ old('time_start') }}"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('time_start') border-error-500 @enderror"
                            required
                        />
                        @error('time_start')
                            <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Time End <span class="text-gray-400 text-xs">(optional)</span>
                        </label>
                        <input 
                            type="time" 
                            name="time_end"
                            value="{{ old('time_end') }}"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('time_end') border-error-500 @enderror"
                        />
                        @error('time_end')
                            <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Name -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Location Name <span class="text-error-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="location_name"
                        value="{{ old('location_name') }}"
                        placeholder="e.g., Hotel Indonesia, Gedung Serbaguna, etc."
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('location_name') border-error-500 @enderror"
                        required
                    />
                    @error('location_name')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Google Maps Link -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Google Maps Link <span class="text-gray-400 text-xs">(optional)</span>
                    </label>
                    <input 
                        type="url" 
                        name="gmaps_link"
                        value="{{ old('gmaps_link') }}"
                        placeholder="https://maps.google.com/?q=..."
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('gmaps_link') border-error-500 @enderror"
                    />
                    @error('gmaps_link')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Description <span class="text-gray-400 text-xs">(optional)</span>
                    </label>
                    <textarea 
                        name="description"
                        rows="4"
                        placeholder="Enter event description, additional information, etc."
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('description') border-error-500 @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Event Image <span class="text-gray-400 text-xs">(optional, max 5MB)</span>
                    </label>
                    <input 
                        type="file" 
                        name="image"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400 @error('image') border-error-500 @enderror"
                    />
                    @error('image')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order and Status -->
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Sort Order
                        </label>
                        <input 
                            type="number" 
                            name="sort_order"
                            value="{{ old('sort_order') }}"
                            placeholder="Auto if empty"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('sort_order') border-error-500 @enderror"
                        />
                        @error('sort_order')
                            <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2 pt-8">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            id="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700"
                        />
                        <label for="is_active" class="text-sm text-gray-700 dark:text-gray-400">
                            Active (visible to users)
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a 
                        href="{{ route('panel.wedding-events.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                    >
                        Cancel
                    </a>
                    <button 
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-6 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.0834 5.4165L7.50008 14.9998L3.33341 10.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Create Event
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection