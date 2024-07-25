<x-frontend.app-layout>


  @if (!empty($category))
    @section('title')
      {{ $category->name ?? ''}} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
    @endsection
  @else
    @section('title')
    {{ localize('Products') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
    @endsection
  @endif


  <div id="content" class="site-content">

    <div class="page-header flex-middle ">
        <div class="container">
            <div class="inner flex-middle">
                <ul id="breadcrumbs" class="breadcrumbs none-style">
                    <li><a href="{{route('home')}}">Home</a></li>
                    @if (!empty($category))
                      <li class="active">{{ $category->name ?? ''}}</li>
                    @endif
                  @if (!empty($brands))
                    <li class="active">{{ $brands->name ?? ''}}</li>
                  @endif

                </ul>
            </div>
        </div>
    </div>

    <div class="container">
      <div class="row">
       <h1 class="text-center mt-4 product-title">

        @if (!empty($category))
          {{ $category->name ?? ''}}
        @endif

        @if (!empty($brands))
          {{ $brands->name ?? ''}}
        @endif

      </h1>
      </div>
    </div>

    <div class="shop-catalog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="product">
                        <div class="row">
                          @if(!empty($products) && sizeof($products)>0)
                          <!--Start-->
                          @include('frontend.partials.product_list',['products' => $products])
                          <!--End-->
                          @else
                          <div style="width: 500px;" class="d-flex justify-content-center mx-auto">
                            <img src="{{ asset('frontend/assets/images/product-not-found.svg') }}" alt="no-image">
                          </div>
                         @endif
                        </div>
                    </div>


                    {{ $products->links('vendor.pagination.bootstrap') }}
                </div>
            </div>
        </div>
    </div>

  </div>




</x-frontend.app-layout>
