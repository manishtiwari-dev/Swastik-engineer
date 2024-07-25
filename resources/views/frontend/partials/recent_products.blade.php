@forelse ($products as $product)
    
<div class="col-lg-4 col-md-4 col-sm-4 d-flex p-0">
    <a href="{{ route('products.show', $product->slug) }}">
      <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="{{ $product->collectLocalization('name') }}" 
      onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';" class="img-fluid">
    </a>
</div>
<div class="col-lg-4 col-md-4 col-sm-4  d-flex p-0">
    <div class="content-block w-100 d-flex justify-content-center align-items-center text-center section-heading py-5 px-4" style="background-image: url(./assets/images/background/bg-img.webp);background-color: #d9efd2" ;="">
      <div class="text-center">
        <a href="{{ route('products.show', $product->slug) }}">
          <p class="text-dark"> {{ $product->collectLocalization('name') }}</p>
          <div class="btn btn-solid mb-3">
            Shop Now
          </div>
        </a>
      </div>
    </div>
</div>

@empty
    
@endforelse