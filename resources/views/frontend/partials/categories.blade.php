<!--Category Start-->
<section class=" mt-5">
  <div class="container">
    <div class="row">
      <div class="five-item-carousel owl-carousel owl-theme">
        @foreach ($categories as $categoryItem)
        <div class="category-box">
          <div class="inner-box">
            <div class="upper-box">
              <a href="{{ route('category.show',$categoryItem->slug) }}">
              <div class="image">
                <img src="{{ uploadedAsset($categoryItem->collectLocalization('thumbnail_image')) }}"
                onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';"
                class="img-fluid" alt="{{ $categoryItem->collectLocalization('name') }}" />
              </div>
              </a>
            </div>
            <div class="lower-box">
              <h3><a href="{{ route('category.show',$categoryItem->slug) }}">{{ $categoryItem->collectLocalization('name') }}</a></h3>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<!--Category End-->