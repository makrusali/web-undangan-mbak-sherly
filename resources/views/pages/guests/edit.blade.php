@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Guest" />

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
        <form method="POST" action="{{ route('panel.guests.update', $guest) }}">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <!-- Name Field -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Name <span class="text-error-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{ old('name', $guest->name) }}"
                        placeholder="Enter guest name"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('name') border-error-500 @enderror"
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Phone <span class="text-error-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute top-1/2 left-0 -translate-y-1/2 border-r border-gray-200 px-3.5 py-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.94 5.065C3.973 3.497 5.823 2.5 8 2.5C11.3137 2.5 14 5.18629 14 8.5C14 10.677 13.003 12.527 11.435 13.56C10.762 13.987 10 14.291 9.226 14.475C9.079 14.513 8.927 14.542 8.773 14.562C8.387 14.607 8 14.323 8 13.935V12.5C5.514 12.5 3.5 10.486 3.5 8C3.5 7.376 3.64 6.784 3.889 6.258L2.94 5.065ZM8 4.5C9.933 4.5 11.5 6.067 11.5 8C11.5 8.643 11.349 9.252 11.084 9.792L9.999 8.707C9.999 8.471 9.999 8.236 9.999 8C9.999 6.895 9.104 6 8 6C7.764 6 7.529 6 7.293 6L6.208 4.916C6.748 4.651 7.357 4.5 8 4.5ZM4.775 7.224C4.595 7.786 4.5 8.383 4.5 9C4.5 9.617 4.595 10.214 4.775 10.776L6.207 9.343C6.071 8.904 6 8.459 6 8C6 7.541 6.071 7.096 6.207 6.657L4.775 7.224ZM9.343 6.207C8.904 6.071 8.459 6 8 6C7.541 6 7.096 6.071 6.657 6.207L8.089 7.639C8.422 7.448 8.791 7.33 9.179 7.295L9.343 6.207ZM6.657 9.793C7.096 9.929 7.541 10 8 10C8.459 10 8.904 9.929 9.343 9.793L7.911 8.361C7.578 8.552 7.209 8.67 6.821 8.705L6.657 9.793Z" fill="#667085"/>
                            </svg>
                        </span>
                        <input 
                            type="tel" 
                            name="phone"
                            value="{{ old('phone', $guest->phone) }}"
                            placeholder="+62 812 3456 7890"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[62px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('phone') border-error-500 @enderror"
                        />
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Address <span class="text-gray-400 text-xs">(optional)</span>
                    </label>
                    <textarea 
                        name="address"
                        rows="4"
                        placeholder="Enter guest address"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('address') border-error-500 @enderror"
                    >{{ old('address', $guest->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a 
                        href="{{ route('panel.guests.index') }}"
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
                        Update Guest
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection