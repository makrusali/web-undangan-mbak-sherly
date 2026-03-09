@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Guest Details" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Guest Information</h4>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('panel.guests.edit', $guest) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors"
                >
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8334 10.0002V15.8335C15.8334 16.2755 15.6578 16.6995 15.3452 17.012C15.0327 17.3246 14.6087 17.5002 14.1667 17.5002H4.16675C3.72472 17.5002 3.3008 17.3246 2.98824 17.012C2.67568 16.6995 2.50008 16.2755 2.50008 15.8335V5.8335C2.50008 5.39147 2.67568 4.96755 2.98824 4.65499C3.3008 4.34243 3.72472 4.16683 4.16675 4.16683H10.0001" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M14.1667 2.5L17.5 5.83333L9.16667 14.1667H5.83334V10.8333L14.1667 2.5Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Edit
                </a>
                <a 
                    href="{{ route('panel.guests.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Profile Image / Avatar -->
            <div class="col-span-1 md:col-span-2 flex items-center gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 text-2xl font-semibold">
                    {{ $guest->name ? strtoupper(substr($guest->name, 0, 1)) : '?' }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $guest->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Guest ID: #{{ $guest->id }}</p>
                </div>
            </div>

            <!-- Name Detail -->
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</label>
                <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $guest->name ?? 'N/A' }}</p>
            </div>

            <!-- Phone Detail -->
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</label>
                <div class="mt-1 flex items-center gap-2">
                    <p class="text-base text-gray-900 dark:text-white">{{ $guest->phone ?? 'N/A' }}</p>
                    @if($guest->phone)
                        @php
                            $message = $guest->message_template ?? "Hello " . ($guest->name ?? 'Guest') . ", welcome!";
                            $whatsappUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $guest->phone) . "?text=" . urlencode($message);
                        @endphp
                        <a 
                            href="{{ $whatsappUrl }}" 
                            target="_blank"
                            class="inline-flex items-center justify-center rounded-lg bg-green-500 px-2 py-1 text-xs font-medium text-white hover:bg-green-600 transition-colors"
                            title="Send WhatsApp message"
                        >
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                                <path d="M12 2C6.477 2 2 6.477 2 12C2 14.136 2.648 16.116 3.775 17.738L2.075 21.575C1.975 21.775 2.075 22 2.3 22L6.262 20.3C7.884 21.352 9.864 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="white"/>
                                <path d="M17.1 14.7C16.8 15.4 16 16 15.2 16.1C14.6 16.2 13.9 16.1 12.9 15.7C11.6 15.2 10.4 14.3 9.3 13.2C8.2 12.1 7.3 10.9 6.8 9.6C6.4 8.6 6.3 7.9 6.5 7.3C6.6 6.5 7.2 5.7 7.9 5.4C8.2 5.3 8.5 5.3 8.7 5.3C8.9 5.3 9.1 5.3 9.2 5.6C9.4 6 9.8 6.8 9.9 7C9.9 7.1 10 7.3 9.9 7.5C9.8 7.7 9.7 7.9 9.5 8.2C9.4 8.4 9.2 8.6 9.1 8.8C8.9 9.1 8.8 9.3 9 9.7C9.6 10.7 10.4 11.6 11.3 12.3C11.7 12.6 12 12.8 12.3 12.9C12.7 13.1 12.9 13 13.2 12.8C13.4 12.7 13.6 12.5 13.8 12.3C14 12.1 14.2 12 14.5 12.1C14.8 12.2 15.6 12.6 15.9 12.8C16.2 13 16.3 13.2 16.4 13.4C16.4 13.7 16.3 14.2 17.1 14.7Z" fill="#25D366"/>
                            </svg>
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            <!-- Address Detail -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Address</label>
                <p class="mt-1 text-base text-gray-900 dark:text-white">{{ $guest->address ?? 'No address provided' }}</p>
            </div>

            <!-- Metadata -->
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created At</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $guest->created_at ? $guest->created_at->format('F d, Y h:i A') : 'N/A' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $guest->updated_at ? $guest->updated_at->format('F d, Y h:i A') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>
@endsection