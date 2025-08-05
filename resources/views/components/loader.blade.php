@props([
    'text' => 'Processing...'
])


<div wire:loading.flex
     class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-900 bg-opacity-75 flex-col items-center justify-center">

    {{-- The Spinner --}}
    <div class="loader ease-linear rounded-full border-4 border-t-4 h-12 w-12 mb-4"></div>

    {{-- The Text --}}
    <h2 class="text-center text-white text-xl font-semibold">{{ $text }}</h2>
    <p class="w-1/3 text-center text-white">Please wait, this may take a moment.</p>
</div>


<style>
    .loader {
      border-color: #4A5568; /* A dark gray for the non-animated part of the ring */
      border-top-color: #FBBF24; /* A nice, modern golden color (Tailwind's amber-400) */
      -webkit-animation: spinner 1.5s linear infinite;
      animation: spinner 1.5s linear infinite;
    }

    @-webkit-keyframes spinner {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spinner {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>