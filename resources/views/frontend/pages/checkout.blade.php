<x-frontend.app-layout>
    @section('title')
        {{ localize('Checkout') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
    @endsection
     <!-- checkout section-->
      <div class="space-5"></div>
      <section class="flex-1">
        <div class="container">
            <form id="checkout-form" class="needs-validation" novalidate action="{{ route('checkout.complete') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-5 order-lg-2">
                    <div class="pl-lg-3 ">
                        <div class="bg-gray-1 rounded-lg">
                            <!-- Order Summary -->
                            <div class="p-4 mb-4 checkout-table">
                                <!-- Title -->
                                <div class="border-bottom mb-3">
                                    <h4 class="section-title mb-0 pb-2">Your Order</h4>
                                </div>
                                <!-- End Title -->
    
                                <!-- Product Content -->
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="product-name fs-16">Product</th>
                                            <th class="product-total fs-16">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($carts as $cart)
                                        <tr class="cart_item">
                                            <td>{{$cart->product->collectLocalization('name')}}<strong class="product-quantity ps-2">× {{$cart->qty}}</strong></td>
                                            <td> {{ formatPrice(variationDiscountedPrice($cart->product_variation->product, $cart->product_variation)) }}</td>
                                        </tr>
                                        {{-- @dd($cart); --}}
                                        @if(!empty($cart->AddOnProducts))
                                            @forelse ($cart->AddOnProducts as $product)
                                                <tr class="cart_item">
                                                    <td>{{$product->collectLocalization('name')}}<strong class="product-quantity ps-2">× {{$cart->addons[$product->id]}}</strong> <span class="border addons-btn ">Addons</span> </td>
                                                    <td>{{formatPrice(($product->price)*($cart->addons[$product->id]))}}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        @endif
    
                                        @empty
                                        @endforelse
                                    </tbody>
    
                                    <tfoot>
                                        <tr>
                                            <td class="fs-16">Subtotal</td>
                                            <td >{{formatPrice(getSubTotal($carts, false, '', false))}}</td>
                                        </tr>
                                        
                                        @if(getTotalTax($carts) !=0)
                                        <tr>
                                            <th class="fs-16">+ {{ localize('Tax') }}</th>
                                            <td class="fs-16">{{ formatPrice(getTotalTax($carts)) }}</td>
                                        </tr>
                                        @endif
                                        
                                        @php
                                            $total = getSubTotal($carts, false, '', false) + getTotalTax($carts);
                                        @endphp
                                        <input type="hidden" id="total_amount" value="{{$total}}">
                                        <tr>
                                            <th class="fs-16">{{ localize('Total') }}</th>
                                            <td class="fs-16"><strong>{{ formatPrice($total) }}</strong></td>
                                        </tr>

                                        <tr>
                                            <td> 
                                                <div class="custom-control custom-radio d-flex align-items-center gap-2">
                                                    <input type="radio" class="custom-control-input parse_payment " name="parse_payment"  value="full_payment" checked required>
                                                    <label class="custom-control-label form-label fw-500 mb-0">Full Payment</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-radio d-flex align-items-center gap-2">
                                                    <input type="radio" class="custom-control-input parse_payment " name="parse_payment"  value="part_payment" required>
                                                    <label class="custom-control-label form-label fw-500 mb-0">Partial Payment</label>
                                                </div>
                                            </td>
                                        </tr>

                                        
                                        @if(getSetting('order_partial_status')=="On")
                                            <tr class="partialy_payment d-none">
                                                <th class="fs-16">{{ localize('Payable Amount') }}</th>
                                                <th class="fs-16 partialy_amount">
                                                    <input type="number" class="form-control" value="{{getSetting('order_partial_amount')}}" name="partially_input" id="partially_input">
                                                    <label class="amount_label">Min Amount : {{getSetting('order_partial_amount')}}</label><br/>
                                                    <small class="text-danger price_error"></small>
                                                </th>
                                            </tr>
                                            @error('price')
                                            <tr > 
                                               <td colspan="2"> 
                                                <small class="text-danger">{{$message}}</small>
                                               </td>
                                           </tr>
                                           @enderror
                                            <tr class="partialy_payment d-none">
                                                <th class="fs-16">{{ localize('Pending Amount') }}</th>
                                                <th class="fs-16 pending_amount">{{getCurrencySymbol()}}{{$total}}</th>
                                            </tr>
                                    
                                        @endif
                                    </tfoot>
                                </table>
                                <!-- End Product Content -->
                                <div class="mb-3">
                                    <div class=" payment-wrapper">
                                        <div class="border-bottom">
                                            <div class="py-3">
                                                <div class="custom-control custom-radio d-flex align-items-center gap-2">
                                                    <input type="radio" class="custom-control-input" name="payment_method" id="cod" checked value="cod" required>
                                                    <label class="custom-control-label form-label fw-500 mb-0">
                                                       Pay with UPI<a href="#" class="text-blue"></a>
                                                    </label>
                                                    @error('payment_method')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                        <!-- End Card -->
                                        {{-- @if (getSetting('enable_paytm') == 1)
                                        <div class="border-bottom">
                                            <div class="py-3">
                                                <div class="custom-control custom-radio d-flex align-items-center gap-2">
                                                    <input type="radio" class="custom-control-input" name="payment_method" id="paytm" value="paytm" required>
                                                    <label class="custom-control-label form-label fw-500 mb-0" >
                                                        PayTm <a href="#" class="text-blue"></a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endif --}}
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-solid w-100">Place order</button>
                            </div>
                            <!-- End Order Summary -->
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-7 order-lg-1">
                        <div class="checkout-title mb-3">
                        <h4>Billing Details</h4>
                        </div>
                        <div class="row clearfix billing-detail-form">
                            <!--Form Group-->
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="field-label">Customer Name <sup class="text-danger">*</sup></div>
                                <input type="text" class="form-control" name="customer_name"  value="{{old('customer_name')}}" placeholder="" required>
                                @error('customer_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <!--Form Group-->
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div class="field-label">Phone <sup class="text-danger">*</sup></div>
                                    <input type="text" class="form-control" name="customer_phone" value="{{old('customer_phone')}}" placeholder="" required>
                                    @error('customer_phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                            </div>

                            <!--Form Group-->
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div class="field-label">Email Address </div>
                                <input type="text" class="form-control" name="customer_email" value="{{old('customer_email')}}" placeholder="" >
                                @error('customer_email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        <!--Form Group-->
                            <div class="form-group col-lg-6 col-md-6 col-sm-12 mb-3">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="form-check align-items-center d-flex gap-1">
                                        <input class="form-check-input deliveryType" type="radio" value="2" name="deliveryType" id="deliveryType1" checked>
                                        <label class="form-check-label fw-bold"  for="deliveryType1">
                                        Take away
                                        </label>
                                    </div> 
                                    <div class="form-check align-items-center d-flex gap-1">
                                        <input class="form-check-input deliveryType" type="radio" value="1" name="deliveryType" id="deliveryType2" >
                                        <label class="form-check-label fw-bold" for="deliveryType2">
                                        Delivery
                                        </label>
                                    </div> 
                                </div>
                            </div>
                            <!--Form Group-->
                            
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 d-none addressBar">
                                <div class="field-label">Address <sup class="text-danger address_req d-none">*</sup></div>
                                <input type="text" class="form-control" name="customer_address" value="{{old('customer_address')}}" placeholder="" >
    
                                @error('customer_address')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
    
                            </div>
                            <!-- ==== -->
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                 <div class="field-label">Additional Information </div>
                                <textarea class="form-control" placeholder="Message" id="floatingTextarea" name="order_note"></textarea>
                            </div>
                                 
                        </div>
                    </div>
                    
                </div>
          </form>
        </div>
      </section>
    
    
      @push('scripts')
          <script>
            
            var min_price={{getSetting('order_partial_amount')}};
            var max_price={{getSubTotal($carts, false, '', false) + getTotalTax($carts)}};
            var currency = "{{getCurrencySymbol()}}";

            $(".deliveryType").on("click",function() {
                
                if($(this).val()==1) {
                    $('.addressBar').removeClass('d-none');
                    $('.address_req').removeClass('d-none');
                    $('input[name="customer_address"]').attr('required','');

                }
                else {
                    $('.addressBar').addClass('d-none');
                    $('.address_req').addClass('d-none');
                    $('input[name="customer_address"]').removeAttr('required');
                    $('input[name="customer_address"]').val('');
                }
                
            });
            $(".parse_payment").on("click",function() {
                if($(this).val()=="part_payment") {
                    $(".partialy_payment").removeClass('d-none');
                    $("#partially_input").attr('required','');

                    var total=$('#total_amount').val();

                    var percentAmount=(Number(total)*10)/100;
                    
                    if(percentAmount>=min_price){
                       $('#partially_input').val(percentAmount);
                       pendingAmount=max_price-percentAmount;
                       $('.pending_amount').text(currency+pendingAmount);
                    }
                }
                else {
                    $(".partialy_payment").addClass('d-none');
                    $("#partially_input").removeAttr('required');
                }
            });

            $("#partially_input").on("blur",function() {
                var inputamount=$(this).val();
          
                

                if(inputamount<=min_price){
                    $(this).val(min_price);
                    $('.amount_label').text('Min Amount : '+min_price);
                }

                if(inputamount>max_price){
                    $('.amount_label').text('Max Amount : '+max_price);
                    $(this).val(max_price);
                } 

                if(inputamount==''){
                    $('.pending_amount').text(currency+max_price)
                } 
                let current_val =  $(this).val();
                if((inputamount>=min_price && inputamount<=max_price) || (current_val == min_price)) {
                    pendingAmount=max_price-current_val;
                    $('.pending_amount').text(currency+pendingAmount);
                } 
                
            });

        
            $(document).on('submit', '#checkout-form', function (e) {
                e.preventDefault();
                $('#checkout-form').addClass('was-validated');
                if ($('#checkout-form')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {
                    if($("#partially_input").val() < min_price) 
                    $('.price_error').text("Please enter minimum amount");
                    else
                    $('#checkout-form')[0].submit();
                }
            });
          </script>
      @endpush
    
    </x-frontend.app-layout>