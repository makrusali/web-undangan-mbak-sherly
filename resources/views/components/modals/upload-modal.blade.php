<div 
    x-data="{
        open: false,
        isDragging: false,
        files: [],
        uploading: false,
        uploadProgress: 0,
        handleDrop(e) {
            this.isDragging = false;
            const droppedFiles = Array.from(e.dataTransfer.files);
            this.handleFiles(droppedFiles);
        },
        handleFiles(selectedFiles) {
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
            const validFiles = selectedFiles.filter(file => validTypes.includes(file.type));
            
            if (validFiles.length > 0) {
                this.files = [...this.files, ...validFiles];
            }
        },
        removeFile(index) {
            this.files.splice(index, 1);
        },
        uploadFiles() {
            if (this.files.length === 0) return;
            
            this.uploading = true;
            this.uploadProgress = 0;
            
            const formData = new FormData();
            this.files.forEach(file => {
                formData.append('images[]', file);
            });

            // Simulate progress (since Fetch API doesn't have progress events)
            const progressInterval = setInterval(() => {
                if (this.uploadProgress < 90) {
                    this.uploadProgress += 10;
                }
            }, 200);

            fetch('{{ route("panel.galleries.upload") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                clearInterval(progressInterval);
                this.uploadProgress = 100;
                
                if (data.success) {
                    // Reset form
                    setTimeout(() => {
                        this.files = [];
                        this.uploading = false;
                        this.open = false;
                        
                        // Show success message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                        
                        // Refresh page after successful upload
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 500);
                }
            })
            .catch(error => {
                clearInterval(progressInterval);
                this.uploading = false;
                this.uploadProgress = 0;
                console.error('Upload error:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'An error occurred while uploading files',
                });
            });
        }
    }"
    x-on:open-upload-modal.window="open = true"
    x-cloak
>
    <!-- Modal Backdrop -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500/50 bg-opacity-75 dark:bg-gray-900/50 dark:bg-opacity-75 z-99999!"
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
        <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full dark:bg-gray-800">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Upload Images
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
            <div class="p-6">
                <!-- Upload Progress Bar -->
                <div x-show="uploading" class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <span>Uploading...</span>
                        <span x-text="uploadProgress + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-brand-500 h-2 rounded-full transition-all duration-300" :style="'width: ' + uploadProgress + '%'"></div>
                    </div>
                </div>

                <!-- Dropzone -->
                <div 
                    class="transition border border-gray-300 border-dashed cursor-pointer dark:hover:border-brand-500 dark:border-gray-700 rounded-xl hover:border-brand-500"
                    :class="{ 'opacity-50 pointer-events-none': uploading }"
                >
                    <div 
                        @drop.prevent="handleDrop($event)"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @click="$refs.fileInput.click()"
                        :class="isDragging 
                            ? 'border-brand-500 bg-gray-100 dark:bg-gray-800' 
                            : 'border-gray-300 bg-gray-50 dark:border-gray-700 dark:bg-gray-900'"
                        class="dropzone rounded-xl border-dashed border-gray-300 p-7 lg:p-10 transition-colors cursor-pointer"
                    >
                        <!-- Hidden File Input -->
                        <input 
                            x-ref="fileInput"
                            type="file" 
                            @change="handleFiles(Array.from($event.target.files)); $event.target.value = ''"
                            accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/svg+xml"
                            multiple
                            class="hidden"
                            @click.stop
                            :disabled="uploading"
                        />

                        <div class="flex flex-col items-center m-0">
                            <!-- Icon Container -->
                            <div class="mb-[22px] flex justify-center">
                                <div class="flex h-[68px] w-[68px] items-center justify-center rounded-full bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    <svg class="fill-current" width="29" height="28" viewBox="0 0 29 28" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5019 3.91699C14.2852 3.91699 14.0899 4.00891 13.953 4.15589L8.57363 9.53186C8.28065 9.82466 8.2805 10.2995 8.5733 10.5925C8.8661 10.8855 9.34097 10.8857 9.63396 10.5929L13.7519 6.47752V18.667C13.7519 19.0812 14.0877 19.417 14.5019 19.417C14.9161 19.417 15.2519 19.0812 15.2519 18.667V6.48234L19.3653 10.5929C19.6583 10.8857 20.1332 10.8855 20.426 10.5925C20.7188 10.2995 20.7186 9.82463 20.4256 9.53184L15.0838 4.19378C14.9463 4.02488 14.7367 3.91699 14.5019 3.91699ZM5.91626 18.667C5.91626 18.2528 5.58047 17.917 5.16626 17.917C4.75205 17.917 4.41626 18.2528 4.41626 18.667V21.8337C4.41626 23.0763 5.42362 24.0837 6.66626 24.0837H22.3339C23.5766 24.0837 24.5839 23.0763 24.5839 21.8337V18.667C24.5839 18.2528 24.2482 17.917 23.8339 17.917C23.4197 17.917 23.0839 18.2528 23.0839 18.667V21.8337C23.0839 22.2479 22.7482 22.5837 22.3339 22.5837H6.66626C6.25205 22.5837 5.91626 22.2479 5.91626 21.8337V18.667Z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Text Content -->
                            <h4 class="mb-3 font-semibold text-gray-800 text-theme-xl dark:text-white/90">
                                <span x-show="!isDragging">Drag & Drop Files Here</span>
                                <span x-show="isDragging" x-cloak>Drop Files Here</span>
                            </h4>

                            <span class="text-center mb-5 block w-full max-w-[290px] text-sm text-gray-700 dark:text-gray-400">
                                Drag and drop your PNG, JPG, WebP, SVG images here or browse
                            </span>

                            <span class="font-medium underline text-theme-sm text-brand-500">
                                Browse File
                            </span>
                        </div>
                    </div>

                    <!-- File Preview List -->
                    <div x-show="files.length > 0" class="mt-4 p-4 border-t border-gray-200 dark:border-gray-700" x-cloak>
                        <h5 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            Selected Files: <span x-text="files.length"></span>
                        </h5>
                        <ul class="space-y-2 max-h-60 overflow-y-auto">
                            <template x-for="(file, index) in files" :key="index">
                                <li class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300" x-text="file.name"></span>
                                    </div>
                                    <button 
                                        @click.stop="removeFile(index)"
                                        type="button"
                                        class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                        :disabled="uploading"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-gray-700">
                <button 
                    type="button"
                    @click="open = false"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                    :disabled="uploading"
                >
                    Cancel
                </button>
                <button 
                    type="button"
                    @click="uploadFiles()"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="files.length === 0 || uploading"
                >
                    <svg x-show="!uploading" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.8334 10.8335V14.1668C15.8334 14.6088 15.6578 15.0328 15.3452 15.3453C15.0327 15.6579 14.6087 15.8335 14.1667 15.8335H5.83341C5.39139 15.8335 4.96746 15.6579 4.6549 15.3453C4.34234 15.0328 4.16675 14.6088 4.16675 14.1668V10.8335" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M10 4.1665V11.6665M10 11.6665L12.5 9.1665M10 11.6665L7.5 9.1665" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <span x-show="!uploading">Upload Files</span>
                    <span x-show="uploading">Uploading...</span>
                </button>
            </div>
        </div>
    </div>
</div>