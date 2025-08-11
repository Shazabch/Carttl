<div wire:click="toggleFavorite">
    <button class="btn-icon @if($isFavorited) active  @endif" data-bs-toggle="tooltip" title="Add to Watchlist">
        <i class="far fa-heart"></i>
        <span wire:loading wire:target="toggleFavorite" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    </button>
</div>