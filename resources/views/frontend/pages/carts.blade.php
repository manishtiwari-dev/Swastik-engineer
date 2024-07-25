<x-frontend.app-layout>

@section('title')
{{ localize('Home') }} {{ getSetting('title_separator') }} {{ localize('Cart') }}
@endsection

<!-- cart section-->
<div class="space-5"></div>

@if(!empty($carts) && sizeof($carts)>0)
<section>
<div class="container">
    <div class="row ">
    <h4>Shopping Cart</h4>
    </div>
    <div class="row mt-3">
    <div class="col-lg-8 ">
    @forelse ($carts as $cart)
    <!--Main Product-->
    <div>
        <div class="col-lg-12 border p-3 mb-3">
            <div class="row">
            <div class="col-lg-3">
                <img src="{{uploadedAsset($cart->product->thumbnail_image)}}" class="img-fluid" alt="{{$cart->product->collectLocalization('name')}}">
            </div>
            <div class="col-lg-6">
                <h5 class="mb-2">{{$cart->product->collectLocalization('name')}}</h5>
                <div class="cart_itemd d-flex align-items-center gap-1 mb-2">
                <div class="fw-500"> Qty: </div>
                <span class="qtyDown btn" id="" onclick="handleCartItem('decrease','product',{{ $cart->id }})">-</span>
                <input style=" border: 1px solid #eeeeee;margin:0px;text-align: center;width: 35px !important;font-size: 12px;"
                    class="form-control" readonly value="{{ $cart->qty }}" min="1" id="" max="10">
                <span class="qtyUp btn" id="" onclick="handleCartItem('increase','product', {{ $cart->id }})">+</span>
                </div>
                @php
                    $attributes=json_decode($cart->attributes);
                @endphp
                @if($attributes->eggless==1)
                    <div class="mb-2 fw-500">Eggless</div>
                @endif
                @if($attributes->heartshape==1)
                    <div class="mb-2 fw-500">Heartshape</div>
                @endif

                <div class=" d-flex gap-1 fw-500">
                <div>Weight</div> :
                <div>{{$cart->product_variation->code ?? ''}}</div>
                </div>

                <div class=" d-flex gap-1 fw-500">
                    <button type="button" class="close-btn ms-3"
                        onclick="handleCartItem('delete','product',{{ $cart->id }})">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
              
            </div>
            <div class="col-lg-3 text-lg-end mt-2 mt-lg-0">
                <div class="fw-600 prize-wrapper">
                <span class="moneySymbol pe-0">₹</span>
                <span class="money fw-500"> {{ formatPrice(variationDiscountedPrice($cart->product_variation->product, $cart->product_variation)) }}</span>
                </div>
                <div class=" fs-15">
                <span class="text-color">
                    <span class="moneySymbol fs-15 pe-0">{{$cart->product_variation->product->discount_type=="flat" ? "₹" : "" }} {{$cart->product_variation->product->discount_value}}</span>
                    <span class="discountRate">{{$cart->product_variation->product->discount_type=="percent" ? "% off" : "off" }}</span>
                </span>
              
                </div>
            </div>
            
            </div>
        </div>
    </div>
    <!--Add Ons-->
    @if(!empty($cart->AddOnProducts))
        @forelse ($cart->AddOnProducts as $product)
        <div>
            <div class="col-lg-12  border p-3">
                <div class="row">
                <div class="col-lg-3">
                    <img src="{{ uploadedAsset($product->thumbnail_image) }}" class="img-fluid" alt="{{$product->collectLocalization('name')}}">
                </div>
                <div class="col-lg-6">
                    <div class="d-flex gap-2">
                    <h5 class="mb-2">{{$product->collectLocalization('name')}}</h5>
                    <span class="border addons-btn ">Addons</span>
                    </div>
                </div>
                <div class="col-lg-3 text-lg-end mt-2 mt-lg-0">
                    <div class="fw-600 prize-wrapper">
                    <span class="moneySymbol pe-0">₹</span>
                    <span class="money fw-500">{{$product->price}}</span>
                    </div>
                </div>
                <div class=" d-flex gap-1 fw-500">
                    <button type="button" class="close-btn ms-3"
                        onclick="handleCartItem('delete','addon',{{ $cart->id }})">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
                </div>
            </div>
        </div>
        @empty
            
        @endforelse
    @endif

    @empty
    <h5 class="text-center">{{ localize('No data found') }}</h5>
    @endforelse
    </div>
    <div class="col-lg-4 sticky-top mt-4 mt-lg-0">
        <div class="border p-4">
            <h5>Price details (1 items)</h5>
            <div class=" d-flex justify-content-between mt-3">
            <span>MRP Total</span>
            <div class="">
                <span class="moneySymbol pe-0 fs-15">₹</span>
                <span class="money fw-500 fs-15">450</span>
            </div>
            </div>
            <div class=" d-flex justify-content-between mt-2">
            <span>MRP Discount</span>
            <div class="text-decoration-line-through text-color">
                <span class="moneySymbol pe-0 fs-15">₹</span>
                <span class="money fw-500 fs-15">00</span>
            </div>
            </div>
            <div class="border-top my-3"></div>
            <div class="total-amount">
            <div class=" d-flex justify-content-between mt-2">
                <h5>Total Amount</h5>
                <div class="prize-wrapper">
                <span class="moneySymbol pe-0">₹</span>
                <span class="money fw-500 ">450</span>
                </div>
            </div>
            </div>
            
        <!-- checkout-btn -->
        <div class="checkout-btn mt-4">
            <a href="" class="btn btn-solid w-100">
            Continue To Checkout
            </a>
        </div>
        </div>
        

    </div>
    </div>
</div>

@if(!empty($AddOnProducts) && sizeof($AddOnProducts)>0)
<div class="container">
    <div class="row">
    <div class="col-lg-8">
        <div class="addon-products mt-4">
        <h4 class="text-black mb-2">
            Add More Fun To Celebration.....
        </h4>
        <div class="row">   
            @forelse ($AddOnProducts as $item)
            <div class="col-lg-4 col-md-4 col-6">
                <div class="product-box">
                    <div class="img-wrapper">
                    <div class="front">
                        <img src="{{ uploadedAsset($item->thumbnail_image) }}"  class="img-fluid lazyloaded" alt="{{$item->collectLocalization('name')}}">
                    </div>
                    <div class=" cart-wrap">
                        <a href="" class="cart-btn">
                        <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                        <a class="action-wishlist wishlist-btn" href="">
                        <i class="fa-regular fa-heart"></i>
                        </a>
                        <a class="quick-view" href=""><i class="fa-solid fa-magnifying-glass"></i></a>
                    </div>
                    </div>
                    <div class="product-detail pt-4">
                    <a href="" class="d-flex  align-items-top">
                        <div class="text-start">
                        <h6>
                            {{$item->collectLocalization('name')}}
                        </h6>
                        <h4>
                            ₹{{$item->price}}
                        </h4>
                        </div>
                        <div class="add_icon_image"><img src="{{asset('frontend/assets/images/background/add-icon.svg')}}" alt="add"></div>
                    </a>
                    </div>
                </div>
            </div>
            @empty
                
            @endforelse
           
        </div>
        </div>
    </div>
    </div>
</div>
@endif

</section>

@else
<h5 class="text-center">No product in the cart pls add.</h5>
@endif

@push('scripts')
    <script>
    // handleCartItem
    function handleCartItem(action,type,id) {
        let data = {
            _token: "{{ csrf_token() }}",
            action: action,
            id: id,
            type:type,
        };

        $.ajax({
            type: "POST",
            url: '{{ route('carts.update') }}',
            data: data,
            success: function(data) {
                // if (data.success == true) {

                    // $('.apply-coupon-btn').removeClass('d-none');
                    // $('.clear-coupon-btn').addClass('d-none');
                    // $('.apply-coupon-btn').prop('disabled', false);
                    // $('.apply-coupon-btn').html(TT.localize.applyCoupon);
                    // updateCarts(data);

                    location.reload();
                // }
            }
        });
    }
    </script>
@endpush
</x-frontend.app-layout>