@props(['existingImages' => []])

<div
    x-data="{
        // This will hold our preview objects { url, file }
        previews: [],
        // Initialize with existing images when editing
        init() {
            let existing = @json($existingImages);
            this.previews = existing.map(img => ({ url: img.url, name: img.name, existing: true }));
        },

        // Handle new file selections
        handleFiles(event) {
            // Use Livewire's built-in uploader to send files to the backend
            @this.uploadMultiple('{{ $attributes->wire('model')->value() }}', event.target.files,
                // Success callback
                (uploadedFilename) => {
                    // We don't need to do anything here, Livewire handles the temporary files
                },
                // Error callback
                () => {},
                // Progress callback
                (event) => {}
            );

            // Add new previews to the array for immediate visual feedback
            Array.from(event.target.files).forEach(file => {
                this.previews.push({ url: URL.createObjectURL(file), name: file.name, existing: false });
            });
        },

        // Remove a preview (both new and existing)
        removePreview(name) {
            // Filter the previews array to remove the one with the matching name
            this.previews = this.previews.filter(p => p.name !== name);
            // Dispatch an event to the parent Livewire component to handle the actual removal
            @this.dispatch('remove-image', { imageName: name });
        }
    }"
    @remove-upload.window="removePreview($event.detail.name)"
>
    {{-- The hidden file input with the 'multiple' attribute --}}
    <input
        x-ref="fileInput"
        type="file"
        multiple
        class="d-none"
        @change="handleFiles(event)"
    >

    {{-- The "Click to Upload" area --}}
    <div
        @click="$refs.fileInput.click()"
        class="border-dashed rounded d-flex align-items-center justify-content-center bg-light mb-3"
        style="height: 150px; cursor: pointer; border: 2px dashed #ccc;"
    >
        <span class="text-muted">Click to upload multiple images</span>
    </div>

    {{-- The Preview Gallery --}}
    <div x-show="previews.length > 0">
        <div class="row g-3">
            <template x-for="preview in previews" :key="preview.name">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="position-relative">
                        <img :src="preview.url" class="img-fluid rounded border w-100" style="aspect-ratio: 1 / 1; object-fit: cover;">
                        <button
                            type="button"
                            @click.prevent="removePreview(preview.name)"
                            class="btn btn-danger btn-sm rounded-circle shadow-sm position-absolute top-0 end-0 m-1"
                            style="width: 28px; height: 28px; line-height: 1;"
                            title="Remove Image"
                        >
                            ×
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>