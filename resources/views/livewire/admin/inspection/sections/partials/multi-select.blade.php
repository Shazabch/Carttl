<div class="form-item">
    <label class="form-item-label">{{ $label }}</label>
    <div class="mb-2">
       @forelse ($reportData[$property] ?? null ?? [] as $item)
            <span class="tag
                @if(str_contains($item, 'Repainted')) tag-red
                @elseif(str_contains($item, 'cosmetic')) tag-green
                @elseif(str_contains($item, 'scratch')) tag-gray
                @elseif(str_contains($item, 'Dent')) tag-blue
                @else tag-purple @endif
            ">
                {{ $item }}
                <a href="#" wire:click.prevent="toggleArrayValue('{{ $property }}', '{{ $item }}')" class="text-white ms-2">×</a>
            </span>
        @empty
            <span class="text-muted">No conditions selected.</span>
        @endforelse
    </div>
    <div class="btn-group btn-group-toggle d-flex flex-wrap">
        @foreach($options as $option)
            <button type="button" wire:click="toggleArrayValue('{{ $property }}', '{{ $option }}')"
                    class="btn btn-sm m-1 {{ in_array($option, $reportData[$property] ?? null ?? []) ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ $option }}
            </button>
        @endforeach
    </div>
</div>