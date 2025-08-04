@props(['label', 'existingImage' => null])

<div
    x-data="{
        previewUrl: '{{ $existingImage }}',
        updatePreview(event) {
            if (event.target.files.length > 0) {
                this.previewUrl = URL.createObjectURL(event.target.files[0]);
            }
        },
        clearPreview() {
            this.$refs.fileInput.value = null;
            @this.removeUpload('{{ $attributes->wire('model')->value() }}', this.$refs.fileInput.name);
            this.previewUrl = '{{ $existingImage }}';
        }
    }"
>
    <label class="form-label">{{ $label }}</label>

    {{-- The hidden file input remains the same --}}
    <input
        x-ref="fileInput"
        type="file"
        class="d-none"
        {{ $attributes->whereStartsWith('wire:model') }}
        @change="updatePreview(event)"
    >

    {{-- 1. This is now the main positioning container --}}
    <div class="position-relative">

        {{-- 2. The clickable image/placeholder area --}}
        {{-- When this is clicked, it opens the file dialog --}}
        <div @click="$refs.fileInput.click()" style="cursor: pointer;">
            <template x-if="previewUrl">
                <img :src="previewUrl" alt="Image Preview" class="img-fluid rounded border" style="max-height: 200px; width: 100%; object-fit: cover;">
            </template>
            <template x-if="!previewUrl">
                <div class="border rounded d-flex align-items-center justify-content-center bg-light" style="height: 150px;">
                    <span class="text-muted">Click to upload an image</span>
                </div>
            </template>
        </div>

        {{-- 3. THE ICON OVERLAY --}}
        {{-- This div only appears if there's an image. It's positioned at the top-right. --}}
        <div x-show="previewUrl" x-transition class="position-absolute top-0 end-0 m-2 d-flex gap-2">

            {{-- Change Icon --}}
            <button
                type="button"
                class="btn btn-light btn-sm rounded-circle shadow-sm"
                @click.prevent="$refs.fileInput.click()"
                title="Change Image"
                style="width: 32px; height: 32px;"
            >
                <i class="fas fa-pencil-alt"></i>
            </button>

            {{--
            <button
                type="button"
                class="btn btn-danger btn-sm rounded-circle shadow-sm"
                @click.prevent="clearPreview()"
                title="Remove Image"
                style="width: 32px; height: 32px;"
            >
                <i class="fas fa-trash"></i>
            </button>
             Remove Icon --}}
        </div>
    </div>
</div>