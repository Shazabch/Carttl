{{--
    The root element.
    - `position-relative` allows the dropdown to be positioned within this container.
    - `wire:click.outside` is a Livewire helper that closes the dropdown when the user
      clicks anywhere else on the page.
--}}
<div class="form-group position-relative" wire:click.outside="showDropdown = false">

    {{-- The input label, linked to the input by its unique ID. --}}
    <label for="{{ $componentId }}">{{ $label }}</label>

    <input
        id="{{ $componentId }}"
        type="text"
        class="form-control"
        placeholder="{{ $placeholder }}"

        {{-- This value logic is key: it shows the selected name if available,
             otherwise it reflects the real-time search term. --}}
        value="{{ $selectedName ?: $searchTerm }}"

        {{-- Binds the input to the $searchTerm property in the component class. --}}
        wire:model.live.debounce.300ms="searchTerm"

        {{-- Calls our method to load initial items when the input is clicked/focused. --}}
        wire:focus="loadInitialResults"

        autocomplete="off"
    >

    {{-- The Dropdown List --}}
    @if($showDropdown)
        <div class="list-group position-absolute w-100 mt-1" style="z-index: 1000;height:200px;overflow:scroll;">

            @forelse($results as $result)
                {{-- A selectable result item from the database. --}}
                <a

                    class="list-group-item list-group-item-action"

                    wire:click.prevent="selectItem({{ $result->id }}, '{{ addslashes($result->{$searchColumn}) }}')"
                >
                    {{ $result->{$searchColumn} }}
                </a>
            @empty

                @if($allowAdding && !empty($searchTerm))
                    {{-- The "Add New" option, shown only if allowed and the user has typed something. --}}
                    <a

                        class="list-group-item list-group-item-action list-group-item-success"
                        wire:click.prevent="addNew"
                    >
                        <i class="fas fa-plus"></i> Add "{{ $searchTerm }}"
                    </a>
                @else
                    {{-- A standard "No results" message. --}}
                    <span class="list-group-item">No results found.</span>
                @endif
            @endforelse
        </div>
    @endif
</div>