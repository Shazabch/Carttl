<div>
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        @csrf

        <div class="mb-2">
            <label>Name:</label>
            <input type="text" wire:model.lazy="name" class="form-control">
        </div>

        <div class="mb-2">
            <label>Number:</label>
            <input type="text" wire:model.lazy="number" class="form-control">
        </div>

        <div class="mb-2">
            <label>Brand ID:</label>
            <input type="text" wire:model.lazy="brand_id" class="form-control">
        </div>

        <div class="mb-2">
            <label>Make ID:</label>
            <input type="text" wire:model.lazy="make_id" class="form-control">
        </div>

        <div class="mb-2">
            <label>Mileage:</label>
            <input type="text" wire:model.lazy="mileage" class="form-control">
        </div>

        <div class="mb-2">
            <label>Specification:</label>
            <input type="text" wire:model.lazy="specification" class="form-control">
        </div>

        <div class="mb-2">
            <label>FAQ:</label>
            <input type="text" wire:model.lazy="faq" class="form-control">
        </div>

        <div class="mb-2">
            <label>Notes:</label>
            <textarea wire:model.lazy="notes" class="form-control"></textarea>
        </div>


        <div class="mb-2">
            <label>Images (max 6):</label>
            <input
                type="file"
                wire:model="images"
                multiple
                id="imageUpload"
                class="filepond"
            >
        </div>
        <button class="btn btn-primary mt-2">Submit</button>
    </form>

    @if (session()->has('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

</div>
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        FilePond.registerPlugin(FilePondPluginImagePreview);

        const input = document.querySelector('#imageUpload');

        const pond = FilePond.create(input, {
            allowMultiple: true,
            maxFiles: 6
        });

        // Clear after save
        window.Livewire.on('reset-filepond', () => {
            pond.removeFiles();
        });
    });
</script>
@endpush