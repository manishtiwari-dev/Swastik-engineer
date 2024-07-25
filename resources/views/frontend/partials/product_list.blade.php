@if(!empty($products))
@foreach ($products as $product)
<div class="col-lg-3 col-md-3 col-sm-6 item">
    <div class="product-item">
        <div class="product-media">
            <a href="{{ route('products.show', $product->slug) }}">
                <img src="{{ uploadedAsset($product->thumbnail_image) }}" 
                alt="{{ $product->collectLocalization('name') }}" 
                onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';">
            </a>
        </div>
        <h2 class="product__title text-center"><a href="{{ route('products.show', $product->slug) }}">{{ $product->collectLocalization('name') }}</a></h2>
    </div>
</div>

@endforeach
@endif