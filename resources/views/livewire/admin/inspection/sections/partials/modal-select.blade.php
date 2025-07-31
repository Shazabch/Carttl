<div class="form-item">
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

    <button type="button" wire:click="openModal('{{ $property }}')" class="btn select-response-btn">
        Select Response
    </button>

    {{-- This is the pure Livewire modal implementation --}}
    @if ($modalForProperty === $property)
        <div class="modal-backdrop fade show" wire:click="closeModal"></div>
        <div class="modal fade show" style="display: block;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $label }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">

                        {{-- =================================== --}}
                        {{--      THE MISSING FOREACH LOOP       --}}
                        {{-- =================================== --}}

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
                        <button type="button" class="btn btn-primary" wire:click="closeModal">Done</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>