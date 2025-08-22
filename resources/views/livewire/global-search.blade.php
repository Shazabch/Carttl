<div class="search-container">
    {{-- This button will now open the search via Livewire --}}
    <a href="#" class="header-icon" wire:click.prevent="showSearch">
        <img src="{{ asset('images/icons/search.svg') }}" alt="Search">
    </a>

    {{-- The main search container --}}
    <div
        @class(['modern-car-search', 'active' => $isActive])
        wire:click.outside="hideSearch"
    >
        @if ($isActive)
            <input
                type="text"
                placeholder="Search cars by title"
                class="search-input"
                wire:model.live.debounce.300ms="query"
                wire:keydown.escape="hideSearch"
                autofocus
            >

            @if(!empty($query) && strlen($query) > 2)
                <ul class="search-results">
                    @forelse($vehicles as $vehicle)
                        <li wire:click="selectVehicle({{ $vehicle->id }})">{{ $vehicle->title }}</li>
                    @empty
                        <li>No results found for "{{ $query }}"</li>
                    @endforelse
                </ul>
            @endif
        @endif
    </div>

    <style>
        /* This is the new wrapper that provides the positioning context */
        .search-container {
            position: relative;
            /* Adjust size if necessary, for example: */
            /* width: 40px; */
            /* height: 40px; */
        }

        .modern-car-search {
            display: none; /* Hidden by default */
            position: absolute;
            
            /* --- MODIFIED FOR TOP RIGHT CORNER --- */
            top: 100%;   /* Position it just below the container */
            right: 0;    /* Align to the right edge of the container */
            width: 350px; /* Use a fixed width instead of a percentage */
            /* ------------------------------------ */
            
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            border-radius: 8px; /* Optional: for a softer look */
            overflow: hidden;   /* Optional: ensures children conform to border-radius */
        }

        .modern-car-search.active {
            display: block; /* Show when active */
        }

        .search-input {
            width: 100%;
            padding: 15px;
            border: none;
            outline: none;
            font-size: 1rem;
        }

        .search-results {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 400px;
            overflow-y: auto;
        }

        .search-results li {
            padding: 12px 15px;
            cursor: pointer;
            border-top: 1px solid #f0f0f0;
        }

        .search-results li:hover {
            background-color: #f7f7f7;
        }
    </style>
</div>
