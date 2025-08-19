@props(['existingImages' => [],'is_prev' => true])

<div
    x-data="{
        previews: [],
        uploading: false,
        progress: 0,
        totalFiles: 0,
        processedFiles: 0,

        init() {
            let existing = @json($existingImages);
            this.previews = existing.map(img => ({ url: img.url, name: img.name, existing: true }));
        },

        handleFiles(event) {
            const files = event.target.files;
            if (!files.length) return;

            this.uploading = true;
            this.progress = 0;
            this.totalFiles = files.length;
            this.processedFiles = 0;

            // Create an array to track upload promises
            const uploadPromises = [];

            Array.from(files).forEach(file => {
                // Create a preview immediately
                const preview = {
                    url: URL.createObjectURL(file),
                    name: file.name,
                    existing: false
                };
                this.previews.push(preview);

                // Create a promise for each file upload
                const promise = new Promise((resolve, reject) => {
                    @this.upload(
                        '{{ $attributes->wire("model")->value() }}',
                        file,
                        (uploadedFilename) => resolve(),
                        () => reject(),
                        (event) => {
                            // Update progress for this file
                            const fileProgress = event.detail.progress;
                            this.progress = Math.floor(
                                (this.processedFiles + (fileProgress / 100)) / this.totalFiles * 100
                            );
                        }
                    );
                });

                uploadPromises.push(promise);
            });

            // Process all uploads
            Promise.all(uploadPromises)
                .then(() => {
                    this.uploading = false;
                    this.progress = 100;
                    setTimeout(() => this.progress = 0, 1000);
                })
                .catch(() => {
                    this.uploading = false;
                    alert('Some files failed to upload');
                })
                .finally(() => {
                    this.processedFiles = 0;
                    event.target.value = '';
                });
        },

        removePreview(name) {
            this.previews = this.previews.filter(p => p.name !== name);
            @this.dispatch('remove-image', { imageName: name });
        }
    }"
    @remove-upload.window="removePreview($event.detail.name)"
>
    {{-- File input --}}
    <input
        x-ref="fileInput"
        type="file"
        multiple
        class="d-none"
        @change="handleFiles(event)"
    >

    {{-- Upload area --}}
    <div
        @click="$refs.fileInput.click()"
        class="border-dashed rounded d-flex align-items-center justify-content-center bg-light mb-3"
        style="height: 150px; cursor: pointer; border: 2px dashed #ccc; position: relative;"
    >
        <template x-if="!uploading">
            <span class="text-muted">Click to upload multiple images</span>
        </template>

        {{-- Progress bar --}}
        <template x-if="uploading">
            <div class="w-100 px-3">
                <div class="progress" style="height: 20px;">
                    <div
                        class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar"
                        :style="'width: ' + progress + '%'"
                        :aria-valuenow="progress"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    >
                        <span x-text="progress + '%'"></span>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                    <span class="text-muted ms-2">
                        Uploading <span x-text="processedFiles"></span> of <span x-text="totalFiles"></span> files...
                    </span>
                </div>
            </div>
        </template>
    </div>

    {{-- Preview Gallery --}}
    @if($is_prev)
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
    @endif
</div>