<div wire:click="toggleFavorite">
    <div class="wishlist-btn @if($isFavorited) active  @endif" wire:loading.remove wire:target="toggleFavorite">
        <i class="far fa-heart  "></i>
        <span wire:loading wire:target="toggleFavorite" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    </div>
</div>