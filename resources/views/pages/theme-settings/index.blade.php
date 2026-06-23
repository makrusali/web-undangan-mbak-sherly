@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Theme Settings" />

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 dark:bg-emerald-500/10">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-emerald-600 dark:text-emerald-500">{{ session('success') }}</p>
            </div>
        </div>
    @endif

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

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="POST" action="{{ route('panel.theme-settings.update', $setting->id) }}" enctype="multipart/form-data" id="settingsForm">
            @csrf
            @method('PUT')

            <!-- Color Settings -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Color Settings</h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Primary Color -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Primary Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                name="primary_color"
                                value="{{ $setting->primary_color ?? '#6366f1' }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer dark:border-gray-700"
                            />
                            <input 
                                type="text" 
                                name="primary_color_text"
                                value="{{ $setting->primary_color ?? '#6366f1' }}"
                                placeholder="#6366f1"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                            />
                        </div>
                    </div>

                    <!-- Secondary Color -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Secondary Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                name="secondary_color"
                                value="{{ $setting->secondary_color ?? '#8b5cf6' }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer dark:border-gray-700"
                            />
                            <input 
                                type="text" 
                                name="secondary_color_text"
                                value="{{ $setting->secondary_color ?? '#8b5cf6' }}"
                                placeholder="#8b5cf6"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                            />
                        </div>
                    </div>

                    <!-- Accent Color -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Accent Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                name="accent_color"
                                value="{{ $setting->accent_color ?? '#f59e0b' }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer dark:border-gray-700"
                            />
                            <input 
                                type="text" 
                                name="accent_color_text"
                                value="{{ $setting->accent_color ?? '#f59e0b' }}"
                                placeholder="#f59e0b"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                            />
                        </div>
                    </div>

                    <!-- Light Color -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Light Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                name="light_color"
                                value="{{ $setting->light_color ?? '#f3f4f6' }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer dark:border-gray-700"
                            />
                            <input 
                                type="text" 
                                name="light_color_text"
                                value="{{ $setting->light_color ?? '#f3f4f6' }}"
                                placeholder="#f3f4f6"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                            />
                        </div>
                    </div>

                    <!-- Very Light Color -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Very Light Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                name="very_light_color"
                                value="{{ $setting->very_light_color ?? '#ffffff' }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer dark:border-gray-700"
                            />
                            <input 
                                type="text" 
                                name="very_light_color_text"
                                value="{{ $setting->very_light_color ?? '#ffffff' }}"
                                placeholder="#ffffff"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                            />
                        </div>
                    </div>

                    <!-- Dark Color -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Dark Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                name="dark_color"
                                value="{{ $setting->dark_color ?? '#1f2937' }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer dark:border-gray-700"
                            />
                            <input 
                                type="text" 
                                name="dark_color_text"
                                value="{{ $setting->dark_color ?? '#1f2937' }}"
                                placeholder="#1f2937"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Images -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Background Images</h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Background Image/Video -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Background Image or Video
                        </label>
                        @if($setting && $setting->backgrond_image)
                            <div class="mb-3 relative inline-block">
                                @if($setting->isBackgroundVideo())
                                    <video class="w-48 h-32 object-cover rounded-lg border border-gray-200" autoplay muted loop playsinline>
                                        <source src="{{ $setting->background_url }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ $setting->background_url }}" class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                                @endif
                                <button type="button" onclick="deleteImage('background')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="backgrond_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp,video/mp4,video/quicktime,video/ogg,video/webm"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                        <p class="mt-1 text-xs text-gray-500">Max 20MB. Supported: JPEG, PNG, JPG, GIF, WebP, MP4, MOV, OGG, WebM</p>
                    </div>

                    <!-- Decor Top Left -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Decor Top Left
                        </label>
                        @if($setting && $setting->decor_top_left_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->decor_top_left_image) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('decor_top_left')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="decor_top_left_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>

                    <!-- Decor Top Right -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Decor Top Right
                        </label>
                        @if($setting && $setting->decor_top_right_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->decor_top_right_image) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('decor_top_right')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="decor_top_right_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>

                    <!-- Decor Bottom Left -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Decor Bottom Left
                        </label>
                        @if($setting && $setting->decor_bottom_left_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->decor_bottom_left_image) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('decor_bottom_left')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="decor_bottom_left_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>

                    <!-- Decor Bottom Right -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Decor Bottom Right
                        </label>
                        @if($setting && $setting->decor_bottom_right_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->decor_bottom_right_image) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('decor_bottom_right')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="decor_bottom_right_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>

                    <!-- Decor Falling Petal -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Decor Falling Petal
                        </label>
                        @if($setting && $setting->decor_falling_petal_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->decor_falling_petal_image) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('decor_falling_petal')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="decor_falling_petal_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>
                </div>
            </div>

            <!-- Alpha Settings -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Alpha Settings</h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- BG Mask Alpha -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Background Mask Alpha <span class="text-xs text-gray-500">(0.0 - 1.0)</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <input 
                                type="range" 
                                name="bg_mask_alpha"
                                min="0" 
                                max="1" 
                                step="0.05"
                                value="{{ $setting->bg_mask_alpha ?? '0.5' }}"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                oninput="this.nextElementSibling.value = this.value"
                            />
                            <input 
                                type="number" 
                                name="bg_mask_alpha_text"
                                value="{{ $setting->bg_mask_alpha ?? '0.5' }}"
                                min="0" 
                                max="1" 
                                step="0.05"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-20 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 text-center focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            />
                        </div>
                        <p class="mt-1 text-xs text-gray-500">0 = fully transparent, 1 = fully opaque</p>
                    </div>

                    <!-- Hero Mask Alpha -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Hero Mask Alpha <span class="text-xs text-gray-500">(0.0 - 1.0)</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <input 
                                type="range" 
                                name="hero_mask_alpha"
                                min="0" 
                                max="1" 
                                step="0.05"
                                value="{{ $setting->hero_mask_alpha ?? '0.3' }}"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                oninput="this.nextElementSibling.value = this.value"
                            />
                            <input 
                                type="number" 
                                name="hero_mask_alpha_text"
                                value="{{ $setting->hero_mask_alpha ?? '0.3' }}"
                                min="0" 
                                max="1" 
                                step="0.05"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-20 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 text-center focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            />
                        </div>
                        <p class="mt-1 text-xs text-gray-500">0 = fully transparent, 1 = fully opaque</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button 
                    type="reset"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    Reset
                </button>
                <button 
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-6 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.0834 5.4165L7.50008 14.9998L3.33341 10.8332" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<style>
    input[type="color"] {
        padding: 2px;
        cursor: pointer;
    }
    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    input[type="color"]::-webkit-color-swatch {
        border: none;
        border-radius: 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sync color inputs
        document.querySelectorAll('input[type="color"]').forEach(colorInput => {
            const textInput = document.querySelector(`input[name="${colorInput.name}_text"]`);
            if (textInput) {
                colorInput.addEventListener('input', function() {
                    textInput.value = this.value;
                });
                textInput.addEventListener('input', function() {
                    colorInput.value = this.value;
                });
            }
        });

        // Sync range inputs
        document.querySelectorAll('input[type="range"]').forEach(rangeInput => {
            const numberInput = document.querySelector(`input[name="${rangeInput.name}_text"]`);
            if (numberInput) {
                rangeInput.addEventListener('input', function() {
                    numberInput.value = this.value;
                });
                numberInput.addEventListener('input', function() {
                    rangeInput.value = this.value;
                });
            }
        });
    });

    function deleteImage(type) {
        if (!confirm('Are you sure you want to delete this image?')) return;
        
        let url = '';
        switch(type) {
            case 'background':
                url = '{{ route("panel.theme-settings.delete-background") }}';
                break;
            case 'decor_top_left':
                url = '{{ route("panel.theme-settings.delete-decor-top-left") }}';
                break;
            case 'decor_top_right':
                url = '{{ route("panel.theme-settings.delete-decor-top-right") }}';
                break;
            case 'decor_bottom_left':
                url = '{{ route("panel.theme-settings.delete-decor-bottom-left") }}';
                break;
            case 'decor_bottom_right':
                url = '{{ route("panel.theme-settings.delete-decor-bottom-right") }}';
                break;
            case 'decor_falling_petal':
                url = '{{ route("panel.theme-settings.delete-decor-falling-petal") }}';
                break;
        }
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
</script>
@endpush