@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Gifts Management" />
    
    <div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Gift Accounts</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Manage bank accounts for gifts and donations
                </p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <a 
                    href="{{ route('panel.gifts.create') }}" 
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.1665V15.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M4.16699 10H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Add New Account
                </a>
            </div>
        </div>

        <!-- Empty State -->
        @if($gifts->isEmpty())
            <div class="px-6 py-12 text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No gift accounts found</h3>
                <p class="text-gray-500 dark:text-gray-400">Get started by adding your first bank account</p>
                <a 
                    href="{{ route('panel.gifts.create') }}" 
                    class="inline-flex items-center justify-center gap-2 mt-4 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.1665V15.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M4.16699 10H15.8337" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Add New Account
                </a>
            </div>
        @else
            <!-- Table -->
            <div class="overflow-hidden">
                <div class="max-w-full px-5 overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-gray-200 border-y dark:border-gray-700">
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">#</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Bank Name</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Account Name</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Account Number</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Status</th>
                                <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Created At</th>
                                <th scope="col" class="relative px-4 py-3 capitalize">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($gifts as $index => $gift)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $loop->iteration }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $gift->bank_name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $gift->account_name }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-500 dark:text-gray-400">
                                            {{ $gift->account_number }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($gift->is_active)
                                            <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-500/20 dark:text-green-400">
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
                                            {{ $gift->created_at ? $gift->created_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Toggle Active/Inactive -->
                                            <form action="{{ route('panel.gifts.toggle-active', $gift) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button 
                                                    type="submit"
                                                    class="inline-flex items-center justify-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                    title="{{ $gift->is_active ? 'Set Inactive' : 'Set Active' }}"
                                                >
                                                    @if($gift->is_active)
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

                                            <!-- Edit Button -->
                                            <a 
                                                href="{{ route('panel.gifts.edit', $gift) }}"
                                                class="inline-flex items-center justify-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                                title="Edit"
                                            >
                                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.8334 10.0002V15.8335C15.8334 16.2755 15.6578 16.6995 15.3452 17.012C15.0327 17.3246 14.6087 17.5002 14.1667 17.5002H4.16675C3.72472 17.5002 3.3008 17.3246 2.98824 17.012C2.67568 16.6995 2.50008 16.2755 2.50008 15.8335V5.8335C2.50008 5.39147 2.67568 4.96755 2.98824 4.65499C3.3008 4.34243 3.72472 4.16683 4.16675 4.16683H10.0001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                    <path d="M14.1667 2.5L17.5 5.83333L9.16667 14.1667H5.83334V10.8333L14.1667 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('panel.gifts.destroy', $gift) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this gift account?');">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="inline-flex items-center justify-center p-2 text-red-500 rounded-lg hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-500/10 dark:hover:text-red-300"
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

            <!-- Optional: Summary -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <span>Total Accounts: <strong>{{ $gifts->count() }}</strong></span>
                    <span>Active: <strong class="text-green-600">{{ $gifts->where('is_active', true)->count() }}</strong></span>
                    <span>Inactive: <strong class="text-gray-600">{{ $gifts->where('is_active', false)->count() }}</strong></span>
                </div>
            </div>
        @endif
    </div>
@endsection