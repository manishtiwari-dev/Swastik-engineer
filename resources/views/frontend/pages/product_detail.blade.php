<x-frontend.app-layout>
    @section('title')
        {{ localize('Product Details') }} {{ getSetting('title_separator') }} {{ $product->collectLocalization('name') }}
    @endsection

    @section('meta')
        <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $product->meta_title }}">
    <meta itemprop="description" content="{{ $product->meta_description }}">
    <meta itemprop="image" content="{{ uploadedAsset($product->thumbnail_image) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $product->meta_title }}">
    <meta name="twitter:description" content="{{ $product->meta_description }}">
        <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploadedAsset($product->thumbnail_image) }}">
    <meta name="twitter:data1" content="{{ formatPrice($product->min_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $product->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('products.show', $product->slug) }}" />
    <meta property="og:image" content="{{ uploadedAsset($product->thumbnail_image) }}" />
    <meta property="og:description" content="{{ $product->meta_description }}" />
    <meta property="og:site_name" content="{{ getSetting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ formatPrice($product->min_price) }}" />
    <meta property="product:price:currency" content="{{ env('DEFAULT_CURRENCY') }}" />

@endsection

  @php
      $galleryImages = !empty($product->gallery_images) ? explode(',', $product->gallery_images) : [];
  @endphp 

  <!-- product-detail -->

  <div id="content" class="site-content">
    <div class="page-header flex-middle">
      <div class="container">
        <div class="inner flex-middle">
          <ul id="breadcrumbs" class="breadcrumbs none-style">
            <li><a href="{{ route('home') }}">Home</a></li>
            @if (!empty($product->categories[0]))
            <li><a href="{{ route('category.show', $product->categories[0]->slug) }}">{{ $product->categories[0]->name ?? '' }}</a></li>
            @endif
            <li class="active">{{ $product->collectLocalization('name') }}</li>
          </ul>
        </div>
      </div>
    </div>
    <section class="shop-single">
      <div class="container">
        
        <div class="row align-items-center">
          {{-- @if (!empty($product->categories[0]))
          <h6 class="text-center"> {{ $product->categories[0]->name ?? '' }} </h6> --}}
       
          <div class="col-lg-6 mb-4 mb-lg-0 text-center align-self-center">
            <div>
              <img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="{{ $product->collectLocalization('name') }}" class="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="summary entry-summary">
              <h3 class="single-product-title">{{ $product->collectLocalization('name') }}</h3>
             
            <div>   
              @if (!empty($product->categories[0]))
              <p class="">Category : {{ $product->categories[0]->name ?? '' }} </p>
              @endif
              Brand:@if (!empty($product->brands)) <a href="{{ route('brand.show', $product->brands->slug) }}">{{ $product->brands->name }}</a>@endif</div>
              <div>
             
                @if ($product->short_description)
                <strong>Overview</strong><a href=""></a>
                <p> {!! $product->collectLocalization('short_description') !!}</p>
                @endif
                @if(!empty($product->attachment))
                <p class="prodcont">{{ $product->collectLocalization('name') }}<a class="downfonttxt" target="_blank" href="{{asset('storage/'.$product->attachment)}}"> Download Broucher</a></p>
                @endif
                <div>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary octf-btn" data-bs-toggle="modal"
                    data-bs-target="#productEnquiryModal">
                    Enquiry
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="productEnquiryModal" tabindex="-1" aria-labelledby="productEnquiryModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="productEnquiryModalLabel">Enquiry </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                          <div class="container p-0">
                            <div class="row mx-0 ">
                              <form class="my-form needs-validation" id="createEnquiryForm" novalidate>
                                <p class="py-3 mb-0">
                                 Your Enquiry For {{ $product->collectLocalization('name') }}
                                </p>
                                <div class="row">
                                  <input type="hidden"  value="{{ $product->collectLocalization('id') }}"  id="product_id" name="product_id">
                                  <div class="col-lg-6">
                                    <div class="my-3">
                                      <input type="text" class="form-control "  placeholder="Name" name="name" required>
                                      <small class="text-danger errorMsg" id="error_name"></small>
                                     
                                    </div>
                                  </div>

                                  <div class="col-lg-6">
                                    <div class="my-3">
                                      <input type="tel"  class="form-control " placeholder="Phone" name="phone" required>
                                      <small class="text-danger errorMsg" id="error_phone"></small>

                                    </div>

                                  </div>

                                  <div class="col-lg-12">
                                    <div class="my-3">
                                      <input type="email" class="form-control " placeholder="Email"  name="email" >
                                    </div>
                                  </div>
                                  <div class="col-lg-12">
                                    <div class=" my-3">
                                     <textarea class="form-control " name="message" id="message" rows="4" placeholder="Message" ></textarea>
                                    </div>



                                  </div>
                                  <div class="grid grid-3 mb-3">
                                    <button class="btn-grid border-0 enquirySave" type="submit">
                                      <span class="front">Submit</span>
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="space-70"></div>
          </div>
        </div>
        <!-- product-attributes -->
        <div class="row py-5">
          <div class="col-md-6">
            @if ($product->description)
            <p> {!! $product->collectLocalization('description') !!}</p>
            @endif
          </div>
        </div>
      </div>  
    </section>
    <!-- Product Enquiry Form -->
   

    @if (!empty($relatedProducts) && sizeof($relatedProducts) > 0)
    <!-- Related Products -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center mb-2">
            <h3>Related Products</h3>
          </div>
        </div>
        <div class="row owl-carousel owl-theme">
          <!--Start-->
          {{-- @include('frontend.partials.product_list', ['products' => $relatedProducts]) --}}
          @foreach ($relatedProducts as $product)
            <div class=" item">
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

          <!--End-->


        </div>
      </div>
    </section> @endif

  </div>

          
          @push('scripts')
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

              
                <script>
                    $('.owl-carousel').owlCarousel({
                        loop: true,
                        margin: 5,
                        nav: true,
                        autoplay: true,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 3
                            },
                            1000: {
                                items: 4
                            }
                        }
                    })

                    $('.owl-carousel').on('mousewheel', '.owl-stage', function(e) {
                        if (e.deltaY > 0) {
                            $('.owl-carousel').trigger('next.owl');
                        } else {
                            $('.owl-carousel').trigger('prev.owl');
                        }
                        e.preventDefault();
                    });

                    $(document).on('click', '.enquirySave', function(event) {

                        event.preventDefault();
                        $('#createEnquiryForm').addClass('was-validated');
                        if ($('#createEnquiryForm')[0].checkValidity() === false) {
                            event.stopPropagation();

                        } else {

                            $.ajaxSetup({
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                },
                            });

                            var enquiryForm = document.getElementById("createEnquiryForm");
                            var formData = new FormData(enquiryForm);

                            $.ajax({
                                type: "POST",
                                url: "{{ route('products.enquiryStore') }}",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    $('.enquirySave').attr('disabled','');
                                    $('.front').html('Saving..');

                                },
                                success: function(response) {
                                    if (response.status == 400) {
                                        $.each(response.error, function(key, err_val) {
                                            $('#error_' + key).text(err_val);
                                        });
                                    } else if (response.status == 201) {
                                        $('.errorMsg').text(response.error);
                                    } else {
                                        $('#createEnquiryForm')[0].reset();
                                        $('#productEnquiryModal').modal('hide');
                                        swal("Thank You!", "Your Enquiry Saved Successfully", "success");
                                    }
                                },
                                complete: function() {
                                    $('.enquirySave').removeAttr('disabled');
                                    $('#createEnquiryForm').removeClass('was-validated');
                                    $('.front').html('Submit');

                                },

                                error: function(response) {

                                },
                            });
                        }
                    });
                </script>
                   {{-- <script>
            $(document).on('submit', '#createEnquiryForm', function(event) {
                event.preventDefault();
                $('#contactForm').addClass('was-validated');
                if ($('#contactForm')[0].checkValidity() === false) {
                    event.preventDefault(); 
                } else {
                    $('#contactForm')[0].submit()
                }
            });
        </script> --}}
    @endpush

        </x-frontend.app-layout>
