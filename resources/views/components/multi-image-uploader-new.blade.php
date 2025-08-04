@props(['label', 'existingImages' => []]) {{-- Accept array of existing images --}}

<div
    x-data="{
        previewUrls: @js($existingImages), // Array of URLs
        updatePreview(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                this.previewUrls.push(URL.createObjectURL(files[i]));
            }
        },
        removeImage(index) {
            this.previewUrls.splice(index, 1); // Remove specific image
            @this.removeUpload('{{ $attributes->wire('model')->value() }}', index); // Livewire removal
        },
        clearAll() {
            this.$refs.fileInput.value = null;
            @this.set('{{ $attributes->wire('model')->value() }}', []); // Reset Livewire array
            this.previewUrls = [];
        }
    }"
>
    <label class="form-label">{{ $label }}</label>

    {{-- Hidden file input with multiple support --}}
    <input
        x-ref="fileInput"
        type="file"
        multiple {{-- Enable multiple selection --}}
        class="d-none"
        {{ $attributes->whereStartsWith('wire:model') }}
        @change="updatePreview"
    >

    {{-- Dropzone to trigger file input --}}
    <div @click="$refs.fileInput.click()" class="border rounded bg-light p-4 text-center mb-3" style="cursor: pointer">
        <div class="py-5">
            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
            <p class="mb-1">Click to upload images</p>
            <small class="text-muted">(Multiple selection allowed)</small>
        </div>
    </div>

    {{-- Preview Gallery --}}
    <div class="d-flex flex-wrap gap-3 mt-3">
        <template x-for="(url, index) in previewUrls" :key="index">
            <div class="position-relative" style="width: 120px;">
                <img
                    :src="url"
                    class="img-fluid rounded border shadow-sm"
                    style="height: 120px; width: 120px; object-fit: cover"
                >
                {{-- Remove button per image --}}
                <button
                    @click.prevent="removeImage(index)"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle"
                    style="width: 24px; height: 24px"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </template>
    </div>

    {{-- Clear All Button --}}
    <button
        x-show="previewUrls.length > 0"
        @click.prevent="clearAll"
        class="btn btn-sm btn-outline-danger mt-3"
    >
        <i class="fas fa-trash me-1"></i> Clear All Images
    </button>
</div>