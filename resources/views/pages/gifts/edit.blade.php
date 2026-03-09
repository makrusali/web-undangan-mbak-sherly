@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Gift Account" />

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
        <form method="POST" action="{{ route('panel.gifts.update', $gift) }}">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <!-- Bank Name -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Bank Name <span class="text-error-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="bank_name"
                        value="{{ old('bank_name', $gift->bank_name) }}"
                        placeholder="e.g., Bank Central Asia (BCA)"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('bank_name') border-error-500 @enderror"
                        required
                    />
                    @error('bank_name')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Name -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Account Name <span class="text-error-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="account_name"
                        value="{{ old('account_name', $gift->account_name) }}"
                        placeholder="e.g., John Doe"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('account_name') border-error-500 @enderror"
                        required
                    />
                    @error('account_name')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Number -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Account Number <span class="text-error-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="account_number"
                        value="{{ old('account_number', $gift->account_number) }}"
                        placeholder="e.g., 1234567890"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('account_number') border-error-500 @enderror"
                        required
                    />
                    @error('account_number')
                        <p class="mt-1 text-sm text-error-600 dark:text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        value="1"
                        {{ old('is_active', $gift->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700"
                    />
                    <label for="is_active" class="text-sm text-gray-700 dark:text-gray-400">
                        Active (visible to users)
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a 
                        href="{{ route('panel.gifts.index') }}"
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
                        Update Account
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection