

@props(['value' => ''])

<div
    wire:ignore
    {{ $attributes }}
    x-data="{
        // Entangle the 'value' property with the property passed via wire:model
        value: @entangle($attributes->wire('model')),

        // Initialize the editor
        init() {
            ClassicEditor
                .create(this.$refs.editor)
                .then(editor => {
                    // Set the initial data from the parent component
                    editor.setData(this.value);

                    // When the editor's content changes, update the 'value' property
                    // This automatically syncs the data back to the parent Livewire component
                    editor.model.document.on('change:data', () => {
                        this.value = editor.getData();
                    });

                    // When the parent component resets, clear the editor
                    // You would dispatch this 'form-reset' event from your parent
                    Livewire.on('form-reset', () => {
                        editor.setData('');
                    });
                })
                .catch(error => {
                    console.error('CKEditor Error:', error);
                });
        }
    }"
>
    <div>
        {{-- Give the textarea a ref so Alpine can find it --}}
        <textarea x-ref="editor" class="form-control">{{ $value }}</textarea>
    </div>
</div>