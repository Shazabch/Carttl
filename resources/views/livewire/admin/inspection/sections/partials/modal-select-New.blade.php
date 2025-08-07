<div class="form-item">
    <label class="form-item-label">{{ $label }}</label>

    <div class="mb-2 min-h-25px">
        @forelse ($reportData[$property] ?? [] as $item)
            <span class="tag tag-primary">
                {{ $item }}
                <a href="#" wire:click.prevent="toggleArrayValue('{{ $property }}', '{{ $item }}')" class="text-white ms-2">×</a>
            </span>
        @empty
            <span class="text-muted">No option selected yet.</span>
        @endforelse
    </div>

    {{-- Inline toggle switches --}}
    <div class="row g-2">
        @foreach($options as $option)
            <div class="col-md-6">
                <div class="form-check form-switch">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="{{ $property }}-{{ $loop->index }}"
                        wire:click="toggleArrayValue('{{ $property }}', '{{ $option }}')"
                        {{ in_array($option, $reportData[$property] ?? []) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="{{ $property }}-{{ $loop->index }}">
                        {{ $option }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
