<!-- resources/views/components/full-page-loading.blade.php -->
<div
    wire:loading.delay
    class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
    style="z-index: 9999; background-color: rgba(25, 25, 25, 0.6);"> {{-- Darker, richer overlay --}}

    <div class="text-center">
        {{-- The spinner's color is changed to a modern gold/amber color --}}
        <div class="spinner-border" role="status"
             style="width: 4rem; height: 4rem; color: #FBBF24;"> {{-- Amber-400 from Tailwind, a great gold color --}}
            <span class="visually-hidden"></span>
        </div>

        {{-- The text color is also updated to match the spinner --}}
        <p class="mt-3 fw-bold" style="color: #FBBF24;">Loading...</p>
    </div>
</div>