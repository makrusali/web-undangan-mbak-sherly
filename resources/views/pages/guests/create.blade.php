@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Create Guests" />

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

    <form method="POST" action="{{ route('panel.guests.store') }}" x-data="{
        guests: [{
            name: '',
            phone: '+62',
            max_person: null,
            address: ''
        }],
        errors: @json($errors->getMessages()),
        addGuest() {
            this.guests.push({
                name: '',
                phone: '+62',
                address: '',
                max_person: null,
            });
        },
        removeGuest(index) {
            if (this.guests.length > 1) {
                this.guests.splice(index, 1);
            }
        },
        hasError(field, index) {
            return this.errors[`guests.${index}.${field}`] || 
                   this.errors[`guests.${index}.${field}`] || 
                   this.errors[`guests.*.${field}`];
        },
        getError(field, index) {
            const error = this.errors[`guests.${index}.${field}`] || 
                         this.errors[`guests.${index}.${field}`] || 
                         this.errors[`guests.*.${field}`];
            return error ? error[0] : '';
        }
    }">
        @csrf
        
        <div class="space-y-4">

            <template x-for="(guest, index) in guests" :key="index">
                <div>
                    <x-common.component-card title="Guest">
                        <div class="space-y-4">
                            <!-- Name Field -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Name <span class="text-error-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    :name="'guests[' + index + '][name]'"
                                    x-model="guest.name"
                                    placeholder="Enter guest name"
                                    :class="'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 ' + (hasError('name', index) ? 'border-error-500' : 'border-gray-300')"
                                />
                                <template x-if="hasError('name', index)">
                                    <p class="mt-1 text-sm text-error-600 dark:text-error-500" x-text="getError('name', index)"></p>
                                </template>
                            </div>

                            <!-- Phone Field with +62 default -->
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
                                        :name="'guests[' + index + '][phone]'"
                                        x-model="guest.phone"
                                        placeholder="+62 812 3456 7890"
                                        :class="'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[62px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 ' + (hasError('phone', index) ? 'border-error-500' : 'border-gray-300')"
                                    />
                                </div>
                                <template x-if="hasError('phone', index)">
                                    <p class="mt-1 text-sm text-error-600 dark:text-error-500" x-text="getError('phone', index)"></p>
                                </template>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Max Person
                                </label>
                                <div class="relative">
                                    <span class="absolute top-1/2 left-0 -translate-y-1/2 border-r border-gray-200 px-3.5 py-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-gray-500" viewBox="0 0 512 512" class="ionicon"><path d="M332.64 64.58C313.18 43.57 286 32 256 32c-30.16 0-57.43 11.5-76.8 32.38-19.58 21.11-29.12 49.8-26.88 80.78C156.76 206.28 203.27 256 256 256s99.16-49.71 103.67-110.82c2.27-30.7-7.33-59.33-27.03-80.6M432 480H80a31 31 0 0 1-24.2-11.13c-6.5-7.77-9.12-18.38-7.18-29.11C57.06 392.94 83.4 353.61 124.8 326c36.78-24.51 83.37-38 131.2-38s94.42 13.5 131.2 38c41.4 27.6 67.74 66.93 76.18 113.75 1.94 10.73-.68 21.34-7.18 29.11A31 31 0 0 1 432 480"/></svg>
                                    </span>
                                    <input 
                                        type="tel" 
                                        :name="'guests[' + index + '][max_person]'"
                                        x-model="guest.max_person"
                                        placeholder=""
                                        :class="'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[62px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 ' + (hasError('max_person', index) ? 'border-error-500' : 'border-gray-300')"
                                    />
                                </div>
                                <template x-if="hasError('max_person', index)">
                                    <p class="mt-1 text-sm text-error-600 dark:text-error-500" x-text="getError('max_person', index)"></p>
                                </template>
                            </div>

                            <!-- Address Field (Optional) -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Address <span class="text-gray-400 text-xs">(optional)</span>
                                </label>
                                <textarea 
                                    :name="'guests[' + index + '][address]'"
                                    x-model="guest.address"
                                    rows="3"
                                    placeholder="Enter guest address"
                                    :class="'dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 ' + (hasError('address', index) ? 'border-error-500' : 'border-gray-300')"
                                ></textarea>
                                <template x-if="hasError('address', index)">
                                    <p class="mt-1 text-sm text-error-600 dark:text-error-500" x-text="getError('address', index)"></p>
                                </template>
                            </div>

                            <!-- Remove Button (only show if more than 1 guest) -->
                            <div class="flex justify-end" x-show="guests.length > 1">
                                <button 
                                    type="button"
                                    @click="removeGuest(index)"
                                    class="inline-flex items-center gap-2 rounded-lg border border-error-300 bg-error-50 px-4 py-2 text-sm font-medium text-error-600 hover:bg-error-100 transition-colors dark:border-error-700 dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20"
                                >
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.16699 5.8335H15.8337" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M7.5 9.1665V13.3332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M12.5 9.1665V13.3332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M5.83301 5.8335L6.73959 15.0735C6.79744 15.688 7.31839 16.1668 7.9354 16.1668H12.0646C12.6816 16.1668 13.2026 15.688 13.2604 15.0735L14.167 5.8335" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </x-common.component-card>
                </div>
            </template>

            <!-- Add More Button -->
            <div class="flex justify-center">
                <button 
                    type="button"
                    @click="addGuest"
                    class="inline-flex items-center gap-2 rounded-lg border border-dashed border-gray-300 bg-gray-50 px-6 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.1665V15.8332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M4.16699 10H15.8337" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Add Another Guest
                </button>
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
                    Save Guests
                </button>
            </div>
        </div>
    </form>
@endsection