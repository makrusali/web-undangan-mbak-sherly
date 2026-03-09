@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Guests Management" />
    
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Guests List</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Showing {{ $guests->firstItem() }} to {{ $guests->lastItem() }} of {{ $guests->total() }} guests
                </p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <!-- Import Button -->
                <button 
                    type="button"
                    x-data
                    @click="$dispatch('open-import-modal')"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8334 10.8335V14.1668C15.8334 14.6088 15.6578 15.0328 15.3452 15.3453C15.0327 15.6579 14.6087 15.8335 14.1667 15.8335H5.83341C5.39139 15.8335 4.96746 15.6579 4.6549 15.3453C4.34234 15.0328 4.16675 14.6088 4.16675 14.1668V10.8335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M10 4.1665V11.6665M10 11.6665L12.5 9.1665M10 11.6665L7.5 9.1665" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Import
                </button>

                <!-- Download Template Button -->
                <a 
                    href="{{ route('panel.guests.template') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8334 10.8335V14.1668C15.8334 14.6088 15.6578 15.0328 15.3452 15.3453C15.0327 15.6579 14.6087 15.8335 14.1667 15.8335H5.83341C5.39139 15.8335 4.96746 15.6579 4.6549 15.3453C4.34234 15.0328 4.16675 14.6088 4.16675 14.1668V10.8335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M10 11.6665V4.1665M10 11.6665L12.5 9.1665M10 11.6665L7.5 9.1665" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Template
                </a>

                <form method="GET" action="{{ route('panel.guests.index') }}">
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
                            placeholder="Search by name, phone or address..." 
                            class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[300px]"
                        />
                    </div>
                </form>
                <a 
                    href="{{ route('panel.guests.create') }}" 
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.1665V15.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M4.16699 10H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Add Guest
                </a>
            </div>
        </div>

        <!-- Import Modal -->
        <div 
            x-data="{ open: false }"
            x-on:open-import-modal.window="open = true"
            x-cloak
        >
            <!-- Modal Backdrop -->
            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:leave="transition ease-in duration-200"
                class="fixed inset-0! bg-gray-500/50 dark:bg-gray-900/50 z-99999!"
                @click="open = false"
            ></div>

            <!-- Modal Panel -->
            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="fixed inset-0 z-[99999] flex items-center justify-center p-4"
                @click.away="open = false"
            >
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-full dark:bg-gray-800">
                    <form action="{{ route('panel.guests.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Import Guests
                            </h3>
                            <button 
                                type="button"
                                @click="open = false"
                                class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                            >
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p>Please upload an Excel file (.xlsx, .xls) with the following columns:</p>
                                <ul class="mt-2 list-disc list-inside">
                                    <li>name <span class="text-error-500">*</span></li>
                                    <li>phone <span class="text-error-500">*</span> (with country code, e.g., +62)</li>
                                    <li>address <span class="text-gray-400">(optional)</span></li>
                                </ul>
                                <p class="mt-2">
                                    <a href="{{ route('panel.guests.template') }}" class="text-brand-500 hover:text-brand-600">
                                        Download template file
                                    </a>
                                </p>
                            </div>

                            <!-- File Input -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Excel File <span class="text-error-500">*</span>
                                </label>
                                <input 
                                    type="file" 
                                    name="file" 
                                    accept=".xlsx,.xls,.csv"
                                    required
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                                />
                                <p class="mt-1 text-xs text-gray-500">Maximum file size: 2MB</p>
                            </div>

                            <!-- Import Options -->
                            <div class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    name="skip_duplicates" 
                                    id="skip_duplicates"
                                    value="1"
                                    class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700"
                                >
                                <label for="skip_duplicates" class="text-sm text-gray-700 dark:text-gray-400">
                                    Skip duplicate phone numbers
                                </label>
                            </div>

                            <div class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    name="update_existing" 
                                    id="update_existing"
                                    value="1"
                                    class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700"
                                >
                                <label for="update_existing" class="text-sm text-gray-700 dark:text-gray-400">
                                    Update existing guests (based on phone number)
                                </label>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                            <button 
                                type="button"
                                @click="open = false"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors"
                            >
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.8334 10.8335V14.1668C15.8334 14.6088 15.6578 15.0328 15.3452 15.3453C15.0327 15.6579 14.6087 15.8335 14.1667 15.8335H5.83341C5.39139 15.8335 4.96746 15.6579 4.6549 15.3453C4.34234 15.0328 4.16675 14.6088 4.16675 14.1668V10.8335" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M10 4.1665V11.6665M10 11.6665L12.5 9.1665M10 11.6665L7.5 9.1665" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if($guests->isEmpty())
            <div class="px-6 py-12 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No guests found</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ request('search') ? 'No guests match your search criteria' : 'Get started by adding your first guest' }}
                </p>
                @if(!request('search'))
                    <a 
                        href="{{ route('panel.guests.create') }}" 
                        class="inline-flex items-center justify-center gap-2 mt-4 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4.1665V15.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M4.16699 10H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Add Guest
                    </a>
                @endif
            </div>
        @else
            <!-- Table -->
            <div class="overflow-hidden">
                <div class="max-w-full px-5 overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-gray-200 border-y dark:border-gray-700">
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">#</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Name</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Phone</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Address</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Created At</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">WhatsApp</th>
                                <th scope="col" class="relative px-4 py-3 capitalize">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($guests as $index => $guest)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $guests->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td class="py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                                                <span class="text-sm font-medium">{{ $guest->name ? strtoupper(substr($guest->name, 0, 1)) : '?' }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $guest->name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $guest->phone ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $guest->address }}">
                                            {{ $guest->address ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $guest->created_at ? $guest->created_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($guest->phone)
                                            @php
                                                $whatsappUrl = $guest->whatsapp_link;
                                            @endphp
                                            <a 
                                                href="{{ $whatsappUrl }}" 
                                                target="_blank"
                                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-green-600 transition-colors"
                                                title="Send WhatsApp message"
                                            >
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 2C6.477 2 2 6.477 2 12C2 14.136 2.648 16.116 3.775 17.738L2.075 21.575C1.975 21.775 2.075 22 2.3 22L6.262 20.3C7.884 21.352 9.864 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="white" fill-opacity="0.8"/>
                                                    <path d="M17.1 14.7C16.8 15.4 16 16 15.2 16.1C14.6 16.2 13.9 16.1 12.9 15.7C11.6 15.2 10.4 14.3 9.3 13.2C8.2 12.1 7.3 10.9 6.8 9.6C6.4 8.6 6.3 7.9 6.5 7.3C6.6 6.5 7.2 5.7 7.9 5.4C8.2 5.3 8.5 5.3 8.7 5.3C8.9 5.3 9.1 5.3 9.2 5.6C9.4 6 9.8 6.8 9.9 7C9.9 7.1 10 7.3 9.9 7.5C9.8 7.7 9.7 7.9 9.5 8.2C9.4 8.4 9.2 8.6 9.1 8.8C8.9 9.1 8.8 9.3 9 9.7C9.6 10.7 10.4 11.6 11.3 12.3C11.7 12.6 12 12.8 12.3 12.9C12.7 13.1 12.9 13 13.2 12.8C13.4 12.7 13.6 12.5 13.8 12.3C14 12.1 14.2 12 14.5 12.1C14.8 12.2 15.6 12.6 15.9 12.8C16.2 13 16.3 13.2 16.4 13.4C16.4 13.7 16.3 14.2 17.1 14.7Z" fill="white"/>
                                                </svg>
                                                Send
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400">No phone</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex justify-center relative">
                                            <x-common.table-dropdown>
                                                <x-slot name="button">
                                                    <button type="button" class="text-gray-500 dark:text-gray-400">
                                                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z" fill="currentColor" />
                                                        </svg>
                                                    </button>
                                                </x-slot>
                                                
                                                <x-slot name="content">
                                                    <a href="{{ route('panel.guests.show', $guest) }}" class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" role="menuitem">
                                                        View Details
                                                    </a>
                                                    <a href="{{ route('panel.guests.edit', $guest) }}" class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300" role="menuitem">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('panel.guests.destroy', $guest) }}" method="POST" class="block" onsubmit="return confirm('Are you sure you want to delete this guest?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex w-full px-3 py-2 font-medium text-left text-red-500 rounded-lg text-theme-xs hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-500/10 dark:text-red-400 dark:hover:text-red-300">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </x-slot>
                                            </x-common.table-dropdown>
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
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-400">
                        Showing {{ $guests->firstItem() }} to {{ $guests->lastItem() }} of {{ $guests->total() }} results
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if($guests->onFirstPage())
                            <span class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-400 opacity-50 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 sm:px-3.5">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z" fill="currentColor"/>
                                </svg>
                                <span class="hidden sm:inline">Previous</span>
                            </span>
                        @else
                            <a href="{{ $guests->previousPageUrl() }}" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:px-3.5">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z" fill="currentColor"/>
                                </svg>
                                <span class="hidden sm:inline">Previous</span>
                            </a>
                        @endif

                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-400 sm:hidden">
                            Page {{ $guests->currentPage() }} of {{ $guests->lastPage() }}
                        </span>

                        <ul class="hidden items-center gap-0.5 sm:flex">
                            @for($i = 1; $i <= $guests->lastPage(); $i++)
                                @if($i == 1 || $i == $guests->lastPage() || ($i >= $guests->currentPage() - 1 && $i <= $guests->currentPage() + 1))
                                    <li>
                                        @if($i == $guests->currentPage())
                                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-500 text-white text-theme-sm font-medium">{{ $i }}</span>
                                        @else
                                            <a href="{{ $guests->url($i) }}" class="flex h-10 w-10 items-center justify-center rounded-lg text-theme-sm font-medium text-gray-700 hover:bg-brand-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500">{{ $i }}</a>
                                        @endif
                                    </li>
                                @elseif($i == 2 && $guests->currentPage() > 3)
                                    <li><span class="flex h-10 w-10 items-center justify-center text-gray-500">...</span></li>
                                @elseif($i == $guests->lastPage() - 1 && $guests->currentPage() < $guests->lastPage() - 2)
                                    <li><span class="flex h-10 w-10 items-center justify-center text-gray-500">...</span></li>
                                @endif
                            @endfor
                        </ul>

                        @if($guests->hasMorePages())
                            <a href="{{ $guests->nextPageUrl() }}" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:px-3.5">
                                <span class="hidden sm:inline">Next</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z" fill="currentColor"/>
                                </svg>
                            </a>
                        @else
                            <span class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-400 opacity-50 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 sm:px-3.5">
                                <span class="hidden sm:inline">Next</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z" fill="currentColor"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection