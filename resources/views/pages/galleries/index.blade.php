@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Gallery Management" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Header -->
        <div class="flex flex-col gap-2 mb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Gallery Images</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Manage and sort your gallery images
                </p>
            </div>
            
            <!-- Upload Button -->
            <button 
                type="button"
                x-data
                @click="$dispatch('open-upload-modal')"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
            >
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.8334 10.8335V14.1668C15.8334 14.6088 15.6578 15.0328 15.3452 15.3453C15.0327 15.6579 14.6087 15.8335 14.1667 15.8335H5.83341C5.39139 15.8335 4.96746 15.6579 4.6549 15.3453C4.34234 15.0328 4.16675 14.6088 4.16675 14.1668V10.8335" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M10 4.1665V11.6665M10 11.6665L12.5 9.1665M10 11.6665L7.5 9.1665" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Upload Images
            </button>
        </div>

        <!-- Upload Modal -->
        @include('components.modals.upload-modal')

        <!-- Gallery Grid -->
        <div x-data="gallerySorter()" x-init="initSortable()" class="relative">
            <!-- Loading Overlay -->
            <div x-show="loading" class="absolute inset-0 bg-white/80 dark:bg-gray-900/80 z-10 flex items-center justify-center rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Updating order...</span>
                </div>
            </div>

            <!-- Empty State -->
            @if($galleries->isEmpty())
                <div class="py-12 text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No images found</h3>
                    <p class="text-gray-500 dark:text-gray-400">Get started by uploading your first image</p>
                    <button 
                        @click="$dispatch('open-upload-modal')"
                        class="inline-flex items-center justify-center gap-2 mt-4 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors"
                    >
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.8334 10.8335V14.1668C15.8334 14.6088 15.6578 15.0328 15.3452 15.3453C15.0327 15.6579 14.6087 15.8335 14.1667 15.8335H5.83341C5.39139 15.8335 4.96746 15.6579 4.6549 15.3453C4.34234 15.0328 4.16675 14.6088 4.16675 14.1668V10.8335" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M10 4.1665V11.6665M10 11.6665L12.5 9.1665M10 11.6665L7.5 9.1665" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Upload Images
                    </button>
                </div>
            @else
                <!-- Sortable Grid -->
                <div id="gallery-grid" class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($galleries as $gallery)
                        <div class="gallery-item relative group" data-id="{{ $gallery->id }}">
                            <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                <!-- Drag Handle -->
                                <div class="absolute top-2 left-2 z-10 cursor-move bg-white dark:bg-gray-800 rounded-full p-1.5 shadow-md opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                    </svg>
                                </div>
                                
                                <!-- Delete Button -->
                                <button 
                                    @click="deleteImage({{ $gallery->id }})"
                                    class="absolute top-2 right-2 z-10 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-md opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <!-- Image -->
                                <img 
                                    src="{{ $gallery->image_url }}" 
                                    alt="Gallery image"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                />

                                <!-- Sort Order Badge -->
                                <div class="absolute bottom-2 left-2 z-10 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $gallery->sort_order }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        function gallerySorter() {
            return {
                loading: false,
                initSortable() {
                    const grid = document.getElementById('gallery-grid');
                    if (!grid) return;

                    new Sortable(grid, {
                        animation: 150,
                        handle: '.cursor-move',
                        draggable: '.gallery-item',
                        onEnd: (evt) => {
                            this.updateOrder();
                        }
                    });
                },
                updateOrder() {
                    this.loading = true;
                    const items = [];
                    document.querySelectorAll('.gallery-item').forEach((el, index) => {
                        items.push({
                            id: el.dataset.id,
                            sort_order: index + 1
                        });
                    });

                    fetch('{{ route("panel.galleries.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ items })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update sort order badges
                            document.querySelectorAll('.gallery-item .absolute.bottom-2.left-2.z-10').forEach((badge, index) => {
                                badge.textContent = index + 1;
                            });
                            
                            // Show success toast
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error updating order:', error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
                },
                deleteImage(id) {
                    if (confirm('Are you sure you want to delete this image?')) {
                        this.performDelete(id);
                    }
                },
                performDelete(id) {
                    fetch(`{{ url('panel/galleries') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove element from DOM
                            document.querySelector(`.gallery-item[data-id="${id}"]`).remove();
                            
                            // Show success message
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting image:', error);
                    });
                }
            }
        }
    </script>
@endpush