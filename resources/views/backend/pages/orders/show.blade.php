<x-backend.app-layout>

@section('title')
    {{ localize('Order Details') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Order Details') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <div class="card mb-4" id="section-1">
                    <div class="card-header border-bottom-0">

                        <!--order status-->
                        <div class="row justify-content-between align-items-center g-3">
                            <div class="col-12 col-lg-12 flex-grow-1">
                                <h5 class="mb-0">{{ localize('Invoice') }}
                                    <span
                                        class="text-accent">{{ getSetting('order_code_prefix') }}{{ $order->order_code }}
                                    </span>
                                </h5>
                                <span class="text-muted">{{ localize('Order Date') }}:
                                    {{ date('d M, Y', strtotime($order->created_at)) }}
                                </span>
                            </div>
                       
                            <div class="col-6 col-lg-4">
                                <div class="input-group">
                                    <select class="form-select select2" name="payment_status"
                                        data-minimum-results-for-search="Infinity" id="update_payment_status">
                                        <option value="" disabled>
                                            {{ localize('Payment Status') }}
                                        </option>
                                        <option value="0"
                                        @if ($order->payment_status == 0) selected @endif>
                                        {{ localize('Failed') }}</option>

                                        <option value="1"
                                            @if ($order->payment_status == 1) selected @endif>
                                            {{ localize('Unpaid') }}</option>

                                        <option value="2"
                                            @if ($order->payment_status == 2) selected @endif>
                                            {{ localize('Paid') }}</option>

                                        <option value="3"
                                            @if ($order->payment_status == 3) selected @endif>
                                            {{ localize('Partially Paid') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="input-group">
                                    <select class="form-select select2" name="order_status"
                                        data-minimum-results-for-search="Infinity" id="order_status">
                                        <option value="" disabled>{{ localize('Delivery Status') }}</option>
                                        <option value="1" @if ($order->order_status ==1) selected @endif>
                                            {{ localize('Deliverd') }}</option>
                                        <option value="2" @if ($order->order_status ==2) selected @endif>
                                            {{ localize('Cancelled') }}
                                        <option value="3" @if ($order->order_status ==3) selected @endif>
                                            {{ localize('Placed') }}
                                        <option value="4" @if ($order->order_status ==4) selected @endif>
                                            {{ localize('Failed') }}
                                        <option value="5" @if ($order->order_status ==5) selected @endif>
                                            {{ localize('Pending') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <a href="{{ route('admin.orders.downloadInvoice', $order->order_id) }}"
                                    class="btn btn-primary">
                                    <i data-feather="download" width="18"></i>
                                    {{ localize('Download Invoice') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!--customer info-->
                    <div class="card-body">
                        <div class="row justify-content-between g-3">
                            <div class="col-xl-7 col-lg-6">
                                <div class="welcome-message">
                                    <h6 class="mb-2">{{ localize('Customer Info') }}</h6>
                                    <p class="mb-0">{{ localize('Name') }}: {{ optional($order->user)->name }}</p>
                                    @if(!empty($order->user->email))
                                    <p class="mb-0">{{ localize('Email') }}: {{ optional($order->user)->email }}</p>
                                    @endif
                                    <p class="mb-0">{{ localize('Phone') }}: {{ $order->phone_no ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-6">
                                <div class="shipping-address d-flex justify-content-md-end">
                                    <div class="border-end pe-2">
                                        <h6 class="mb-2">{{ localize('Shipping Address') }}</h6>
                                        @php
                                            $shippingAddress = $order->billingAddress;
                                        @endphp
                                      
                                        <p class="mb-0">
                                            @if (!empty($shippingAddress))
                                                {{ $shippingAddress->address }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center bg-secondary">
                            <h6 class="text-danger mb-0 py-2">Order Type : {{$order->delivery_type ==1 ? 'Delivery' : ' Take Away'}}</h6>
                        </div>
                    </div>

                    <!--order details-->
                    <table class="table tt-footable border-top" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                <th>{{ localize('Products') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Unit Price') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('QTY') }}</th>
                                <th data-breakpoints="xs sm" class="text-end">{{ localize('Total Price') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->orderItems as $key => $product)
                            
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm"> <img
                                                    src="{{ uploadedAsset(getProductImage($product->product_type,$product->product_id)->thumbnail_image) }}"
                                                    alt="{{ $product->product_name }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';"
                                                    class="rounded-circle">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="fs-sm mb-0">
                                                    {{ $product->product_name ?? '' }} 
                                                @if ($product->product_type==2)
                                                    <span class="badge bg-success">  AddOn</span>        
                                                @endif
                                                </h6>
                                               
                                                <div class="text-muted">
                                                    <span class="fs-xs">
                                                        {{$product->product_variation ?? ''}}
                                                    </span>
                                                </div>
                                                @if(!empty($product->order_message))
                                                <h6 title="{{localize('Message')}}: {{$product->order_message ?? ''}}" class="fs-sm mb-0">{{localize('Message')}}: {{$product->order_message ?? ''}}</h6>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="tt-tb-price">
                                        <span class="fw-bold">
                                            {{ formatPrice($product->unit_price) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">{{ $product->qty }}</td>

                                    <td class="tt-tb-price text-end">
                                        <span class="text-accent fw-bold">{{ formatPrice($product->total_price) }}</span>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(!empty($order->order_note))
                    <p class="my-3 px-lg-4 px-3">
                           Order Note : {!! $order->order_note ?? '' !!}
                    </p>
                    @endif
                    <!--grand total-->
                    <div class="card-body">
                        <div class="card-footer border-top-0 px-4 py-3 rounded">
                            <div class="row g-4">
                                <div class="col-lg-2 col-md-6">
                                    <h6 class="mb-1">{{ localize('Payment Method') }}</h6>
                                    <span>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
                                </div>

                                <div class="col-lg-2 col-md-6">
                                    <h6 class="mb-1">{{ localize('Sub Total') }}</h6>
                                    <strong>{{ formatPrice($order->sub_total_amount) }}</strong>
                                </div>

                            
                                <div class="col-lg-3 col-md-6 text-lg-end ">
                                    <h6 class="mb-1">{{ localize('Grand Total') }}</h6>
                                    <strong
                                        class="text-accent">{{ formatPrice($order->grand_total_amount) }}</strong>
                                </div>

                                @if ($order->payment_status == 3) 
                                    <div class="col-lg-2 col-md-6">
                                        <h6 class="mb-1">{{ localize('Paid Amount') }}</h6>
                                        <strong
                                            class="text-accent">{{ formatPrice($order->paid_amount ?? 0) }}</strong>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <h6 class="mb-1">{{ localize('Pending Amount') }}</h6>
                                        <strong
                                            class="text-accent">{{ formatPrice($order->pending_amount ?? 0) }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="tt-sticky-sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Order Logs') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    @if(!empty($order->orderUpdates))
                                    @foreach ($order->orderUpdates as $orderUpdate)
                                        <li>
                                            <a class="{{ $loop->first ? 'active' : '' }}">
                                                {{ $orderUpdate->note }} <br> By
                                                <span
                                                    class="text-capitalize">{{ optional($orderUpdate->user)->name }}</span>
                                                at
                                                {{ date('d M, Y', strtotime($orderUpdate->created_at)) }}.</a>
                                        </li>
                                    @endforeach
                                    @else
                                        <li>
                                            <a class="active">{{ localize('No logs found') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@push('scripts')
    <script type="text/javascript">
        "use strict";

        // payment status
        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->order_id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('admin.orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                notifyMe('success', '{{ localize('Payment status has been updated') }}');
                window.location.reload();
            });
        });

        // delivery status 
        $('#order_status').on('change', function() {
            var order_id = {{ $order->order_id }};
            var status = $('#order_status').val();
            $.post('{{ route('admin.orders.update_order_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                notifyMe('success', '{{ localize('Delivery status has been updated') }}');
                window.location.reload();
            });
        });
    </script>
@endpush


</x-backend.app-layout>