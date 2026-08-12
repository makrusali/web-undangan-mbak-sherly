@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Invitation Settings" />

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
        <form method="POST" action="{{ route('panel.invitation-settings.update') }}" enctype="multipart/form-data" id="settingsForm">
            @csrf
            @method('PUT')

            <!-- Hero Image Section -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Hero Image</h4>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            First Section Image
                        </label>
                        @if($setting && $setting->hero_image)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->hero_image) }}" class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('hero')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="hero_image"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                        <p class="mt-1 text-xs text-gray-500">Recommended size: 1920x1080px. Max 5MB.</p>
                    </div>
                </div>
            </div>

            <!-- Invitation Texts -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Invitation Texts</h4>
                <div class="space-y-6">
                    <!-- Invitation Text with Quill -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Invitation Text
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Use <span class="bg-gray-100 px-1 rounded">@{{guest}}</span> and <span class="bg-gray-100 px-1 rounded">@{{max_guest}}</span> as placeholders</p>
                        <input type="hidden" name="invitation_text" id="invitation_text_input" value="{{ $setting->invitation_text ?? '' }}">
                        <div id="invitation_text_editor" class="quill-editor mb-4" style="height: 200px;">{!! $setting->invitation_text ?? '' !!}</div>
                    </div>

                    <!-- Message Template with Quill -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            WhatsApp Message Template
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Use <span class="bg-gray-100 px-1 rounded">@{{guest}}</span>, <span class="bg-gray-100 px-1 rounded">@{{invitation_url}}</span>, and <span class="bg-gray-100 px-1 rounded">@{{event_details}}</span> as placeholders</p>
                        <input type="hidden" name="message_template" id="message_template_input" value="{{ $setting->message_template ?? '' }}">
                        <div id="message_template_editor" class="quill-editor mb-4" style="height: 200px;">{!! $setting->message_template ?? '' !!}</div>
                    </div>

                    <!-- Max Guest -->
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Maksimal Orang per Undangan
                        </label>
                        <div class="flex items-center gap-4">
                            <select 
                                name="max_guest"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-32 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                            >
                                <option value="">Pilih</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ ($setting->max_guest ?? '') == $i ? 'selected' : '' }}>{{ $i }} Orang</option>
                                @endfor
                            </select>
                            <span class="text-sm text-gray-500">Maksimal 10 orang per undangan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Groom Information -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Groom Information</h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nickname -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nickname
                        </label>
                        <input 
                            type="text" 
                            name="groom_nickname"
                            value="{{ $setting->groom_nickname ?? '' }}"
                            placeholder="e.g., Andi"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="groom_fullname"
                            value="{{ $setting->groom_fullname ?? '' }}"
                            placeholder="e.g., Andi Pratama Putra"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <!-- Parents with Quill -->
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Parents
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Format nama orang tua dengan gaya yang diinginkan</p>
                        <input type="hidden" name="groom_parents" id="groom_parents_input" value="{{ $setting->groom_parents ?? '' }}">
                        <div id="groom_parents_editor" class="quill-editor mb-4" style="height: 120px;">{!! $setting->groom_parents ?? '' !!}</div>
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Instagram (optional)
                        </label>
                        <input 
                            type="text" 
                            name="groom_instagram"
                            value="{{ $setting->groom_instagram ?? '' }}"
                            placeholder="@username"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <!-- Photo -->
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Photo
                        </label>
                        @if($setting && $setting->groom_photo)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->groom_photo) }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('groom')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="groom_photo"
                            accept="image/jpeg,image/png,image/jpg"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>
                </div>
            </div>
            
            <!-- Bride Information -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Bride Information</h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nickname -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nickname
                        </label>
                        <input 
                            type="text" 
                            name="bride_nickname"
                            value="{{ $setting->bride_nickname ?? '' }}"
                            placeholder="e.g., Siska"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Full Name
                        </label>
                        <input 
                            type="text" 
                            name="bride_fullname"
                            value="{{ $setting->bride_fullname ?? '' }}"
                            placeholder="e.g., Siska Dewi Lestari"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <!-- Parents with Quill -->
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Parents
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Format nama orang tua dengan gaya yang diinginkan</p>
                        <input type="hidden" name="bride_parents" id="bride_parents_input" value="{{ $setting->bride_parents ?? '' }}">
                        <div id="bride_parents_editor" class="quill-editor mb-4" style="height: 120px;">{!! $setting->bride_parents ?? '' !!}</div>
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Instagram (optional)
                        </label>
                        <input 
                            type="text" 
                            name="bride_instagram"
                            value="{{ $setting->bride_instagram ?? '' }}"
                            placeholder="@username"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <!-- Photo -->
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Photo
                        </label>
                        @if($setting && $setting->bride_photo)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->bride_photo) }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('bride')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="bride_photo"
                            accept="image/jpeg,image/png,image/jpg"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>
                </div>
            </div>

            <!-- Love Story with Quill -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Love Story</h4>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Our Love Story
                    </label>
                    <input type="hidden" name="love_story" id="love_story_input" value="{{ $setting->love_story ?? '' }}">
                    <div id="love_story_editor" class="quill-editor mb-4" style="height: 250px;">{!! $setting->love_story ?? '' !!}</div>
                </div>
            </div>

            <!-- Couple Photo & Thanks Message -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Couple Photo & Thanks Message</h4>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Couple Photo
                        </label>
                        @if($setting && $setting->couple_photo)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ Storage::url($setting->couple_photo) }}" class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                                <button type="button" onclick="deleteImage('couple')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="couple_photo"
                            accept="image/jpeg,image/png,image/jpg"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                    </div>

                    <!-- Thanks Message with Quill -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Thank You Message
                        </label>
                        <input type="hidden" name="thanks_message" id="thanks_message_input" value="{{ $setting->thanks_message ?? '' }}">
                        <div id="thanks_message_editor" class="quill-editor mb-4" style="height: 200px;">{!! $setting->thanks_message ?? '' !!}</div>
                    </div>
                </div>
            </div>

            <!-- Song/Audio -->
            <div class="mb-8">
                <h4 class="text-md font-semibold text-gray-800 dark:text-white/90 mb-4">Background Music</h4>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Song Title
                        </label>
                        <input 
                            type="text" 
                            name="song_title"
                            value="{{ $setting->song_title ?? '' }}"
                            placeholder="e.g., Perfect - Ed Sheeran"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Artist
                        </label>
                        <input 
                            type="text" 
                            name="song_artist"
                            value="{{ $setting->song_artist ?? '' }}"
                            placeholder="e.g., Ed Sheeran"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white-30"
                        />
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Audio File
                        </label>
                        @if($setting && $setting->song_file)
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg flex items-center gap-4">
                                <div class="flex items-center gap-3 flex-1">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-700">{{ $setting->song_title ?? basename($setting->song_file) }}</p>
                                        <p class="text-xs text-gray-500">{{ $setting->song_artist ?? 'Unknown Artist' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="previewSong()" class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors" title="Preview">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick="deleteImage('song')" class="p-2 text-red-500 hover:bg-red-50 rounded-full transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <input 
                            type="file" 
                            name="song_file"
                            accept="audio/mp3,audio/wav,audio/m4a,audio/ogg"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400"
                        />
                        <p class="mt-1 text-xs text-gray-500">Supported formats: MP3, WAV, M4A, OGG. Max 10MB.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
                            <input 
                                type="checkbox" 
                                name="song_autoplay"
                                value="1"
                                {{ ($setting && $setting->song_autoplay) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700"
                            />
                            <span>Autoplay music when page loads</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-8">
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400">
                    <input 
                        type="checkbox" 
                        name="is_active"
                        value="1"
                        {{ ($setting && $setting->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600 dark:bg-gray-700"
                    />
                    <span>Active (invitation is visible to guests)</span>
                </label>
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

    <!-- Audio Preview Modal -->
    <div id="songPreviewModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center" onclick="closePreviewModal(event)">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Preview Lagu</h3>
                <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600">{{ $setting->song_title ?? 'Untitled' }}</p>
                <p class="text-xs text-gray-500">{{ $setting->song_artist ?? 'Unknown Artist' }}</p>
            </div>
            <audio id="songPreview" controls class="w-full">
                <source src="{{ $setting->song_file_url ?? '' }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    </div>
@endsection

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .quill-editor {
        border-radius: 0.5rem;
        background: white;
        margin-bottom: 1rem;
    }
    .ql-toolbar {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        background: #f9fafb;
    }
    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        background: white;
        font-size: 14px;
    }
    .dark .ql-container {
        background: #1f2937;
        color: #e5e7eb;
    }
    .dark .ql-toolbar {
        background: #374151;
        border-color: #4b5563;
    }
    .dark .ql-stroke {
        stroke: #e5e7eb;
    }
    .dark .ql-fill {
        fill: #e5e7eb;
    }
    .dark .ql-picker {
        color: #e5e7eb;
    }
    .dark .ql-picker-options {
        background: #1f2937;
        border-color: #4b5563;
    }
</style>
@endpush

@push('scripts')
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editors
        const editors = {};
        
        // Editor configurations - now includes all text fields
        const editorConfigs = [
            { id: 'invitation_text_editor', inputId: 'invitation_text_input' },
            { id: 'message_template_editor', inputId: 'message_template_input' },
            { id: 'love_story_editor', inputId: 'love_story_input' },
            { id: 'thanks_message_editor', inputId: 'thanks_message_input' },
            { id: 'groom_parents_editor', inputId: 'groom_parents_input' },
            { id: 'bride_parents_editor', inputId: 'bride_parents_input' }
        ];

        // Common toolbar options with more formatting options
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link'],
            ['clean']
        ];

        // Initialize each editor
        editorConfigs.forEach(config => {
            const editorElement = document.getElementById(config.id);
            if (editorElement) {
                const editor = new Quill(editorElement, {
                    theme: 'snow',
                    modules: {
                        toolbar: toolbarOptions
                    },
                    placeholder: 'Write something...'
                });

                // Set initial content
                const input = document.getElementById(config.inputId);
                if (input && input.value) {
                    editor.root.innerHTML = input.value;
                }

                editors[config.id] = editor;
            }
        });

        // Update hidden inputs before form submit
        document.getElementById('settingsForm').addEventListener('submit', function() {
            editorConfigs.forEach(config => {
                const editor = editors[config.id];
                const input = document.getElementById(config.inputId);
                if (editor && input) {
                    input.value = editor.root.innerHTML;
                }
            });
        });
    });

    function deleteImage(type) {
        if (!confirm('Are you sure you want to delete this image?')) return;
        
        let url = '';
        switch(type) {
            case 'hero':
                url = '{{ route("panel.invitation-settings.delete-hero") }}';
                break;
            case 'groom':
                url = '{{ route("panel.invitation-settings.delete-groom") }}';
                break;
            case 'bride':
                url = '{{ route("panel.invitation-settings.delete-bride") }}';
                break;
            case 'couple':
                url = '{{ route("panel.invitation-settings.delete-couple") }}';
                break;
            case 'song':
                url = '{{ route("panel.invitation-settings.delete-song") }}';
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
    
    function previewSong() {
        const modal = document.getElementById('songPreviewModal');
        const audio = document.getElementById('songPreview');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        audio.play();
    }
    
    function closePreviewModal(event) {
        if (event && event.target !== event.currentTarget) return;
        
        const modal = document.getElementById('songPreviewModal');
        const audio = document.getElementById('songPreview');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        audio.pause();
        audio.currentTime = 0;
    }
</script>
@endpush