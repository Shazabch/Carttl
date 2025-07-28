@props([
	'uploadedFiles' => null,
])
 @once
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    @endonce

    @once
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginImagePreview);
        </script>
    @endonce
@if($uploadedFiles != null)

    {{-- if Multiple Files --}}
    @if(is_array($uploadedFiles))

        @foreach($uploadedFiles as $file)
            @if(!empty($file) && file_exists(public_path($file)))
                {{-- if Image --}}
                @if( collect(['jpg', 'png', 'jpeg', 'webp'])->contains(pathinfo( public_path($file),PATHINFO_EXTENSION)))
                    <img src="{{ asset($file) }}" class="" height="100" width="100" alt=" " />
                @else
                    <a target="_blank" href="{{ asset($file) }}">{{ $file }}</a>
                @endif

            @endif
        @endforeach

    {{-- if Single File --}}
    @else
                {{-- if Image --}}
                @if( collect(['jpg', 'png', 'jpeg', 'webp'])->contains(pathinfo( public_path($uploadedFiles),PATHINFO_EXTENSION)))
                    <img src="{{ asset($uploadedFiles) }}" class="" height="100" width="100" alt=" " />
                @else
                <a target="_blank" href="{{ asset($uploadedFiles) }}">{{ $uploadedFiles }}</a>
                @endif
    @endif

@endif

<div
    wire:ignore
    x-data
    x-init="
        () => {
            const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
            post.setOptions({
                allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
                server: {
                    process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                    },
                },
                allowImagePreview: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
                allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
                allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
                maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!}
            });
            window.addEventListener('clear-filepond-files', e => {
                post.removeFiles();
            });
        }
    "
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>




