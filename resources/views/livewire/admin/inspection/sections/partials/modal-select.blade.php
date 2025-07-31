<div x-data="{ open: false }" class="form-item">
    <label class="form-item-label">{{ $label }}</label>
    <div class="mb-2 min-h-25px">
        @forelse ($reportData[$property] ?? [] as $item)
            <span class="tag tag-red">
                {{ $item }}
                <a href="#" wire:click.prevent="toggleArrayValue('{{ $property }}', '{{ $item }}')" class="text-white ms-2">×</a>
            </span>
        @empty
            <span class="text-muted">Click button to select.</span>
        @endforelse
    </div>

    <button type="button" @click="open = true" class="btn select-response-btn">
        Select Response
    </button>

    {{-- Modal --}}
    <div x-show="open"
         class="modal fade show"
         style="display: block; position: relative; z-index: 1055;" {{-- <--- CHANGE 1: ADDED STYLES --}}
         @keydown.escape.window="open = false"
         x-trap.inert.noscroll="open"
         x-cloak> {{-- Add x-cloak for good measure --}}

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $label }}</h5>
                    <button type="button" class="btn-close" @click="open = false"></button>
                </div>
                <div class="modal-body">
                    @foreach($options as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $option }}" id="{{ $property }}-{{ $loop->index }}"
                               wire:click="toggleArrayValue('{{ $property }}', '{{ $option }}')"
                               {{ in_array($option, $reportData[$property] ?? []) ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $property }}-{{ $loop->index }}">
                            {{ $option }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="open = false">Done</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Backdrop --}}
    <div x-show="open" class="modal-backdrop fade show" x-cloak></div> {{-- <--- CHANGE 2: Add x-cloak --}}
</div>