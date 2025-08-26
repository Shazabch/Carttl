<!-- Car Card 3 -->
<div class="car-list-item">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="listing-product-img">
                <img src="{{ $item->coverImage ?  asset('storage/' . $item->coverImage?->path) : asset('images/default-car.webp') }}" class="img-fluid rounded" alt="{{$item->title}}">
                <div class="overlap-car-box-card">
                    <div class="car-box-type p-left d-flex flex-wrap gap-2">
                        @if($item->is_hot)
                        <span class="car-box-badge hot">
                            Hot Listing
                        </span>
                        @endif

                        @if($item->inspected_by)
                        <span class="car-box-badge inspected">
                            Inspected
                        </span>
                        @endif

                        @if(!$item->is_auction && $item->status == 'sold')
                        <span class="car-box-badge sold">
                            Sold
                        </span>
                        @endif

                        @if($item->condition)
                        <span class="car-box-badge condition">
                            {{ucfirst($item->condition)}}
                        </span>
                        @endif
                    </div>
                    <livewire:favorite-button-component :vehicleId="$item->id" />
                </div>
            </div>
        </div>
        <div class="col-md-6 pt-md-0 pt-4">
            <h5  class="list-car-title">{{$item->title}}</h5>
            <div class="car-box-price mb-4">
                <h4 class="mb-0">Price:</h4>
                <h4 class="mb-0 car-box-price-text">{{format_currency($item->price)}}</h4>
            </div>
            <div class="car-box-specs">
                    <div class="spec_item">
                        <i class="fas fa-oil-can"></i>
                        <span>{{$item->engine_type}}</span>
                    </div>
                    <div class="spec_item">
                        <i class="fas fa-palette"></i>
                        <span>{{$item->color}}</span>
                    </div>
                    <div class="spec_item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>{{$item->drive_type ?? 'FWD'}}</span>
                    </div>
                </div>
            <a href="{{ route('car-detail-page',$item->id) }}" class="view-detail-btn mt-3">View Details</a>
        </div>
    </div>
</div>

