<x-backend.app-layout>

@section('title')
    {{ localize('Orders') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Orders') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-4" id="section-1">
                    <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                        <div class="card-header border-bottom-0">
                            <div class="row justify-content-between g-3">
                                <div class="col-auto flex-grow-1 d-none">
                                    <div class="tt-search-box">
                                        <div class="input-group">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                    data-feather="search"></i></span>
                                            <input class="form-control rounded-start w-100" type="text"
                                                id="search" name="search"
                                                placeholder="{{ localize('Search by name/phone') }}"
                                                @isset($searchKey)
                                            value="{{ $searchKey }}"
                                            @endisset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto flex-grow-1">
                                    <div class="input-group mb-3">
                                        @if (getSetting('order_code_prefix') != null)
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text rounded-end-0">{{ getSetting('order_code_prefix') }}</span>
                                            </div>
                                        @endif
                                        <input type="text" class="form-control" placeholder="{{ localize('code') }}"
                                            name="code"
                                            @isset($searchCode)
                                            value="{{ $searchCode }}"
                                            @endisset>
                                    </div>
                                </div> 
                                <div class="col-auto">
                                    <select class="form-select select2" name="payment_status"
                                        data-minimum-results-for-search="Infinity" id="payment_status">
                                        <option value="">{{ localize('Payment Status') }}</option>
                                        <option value="0"
                                            @if (isset($paymentStatus) && $paymentStatus ==0) selected @endif>
                                            {{ localize('Failed') }}</option>
                                        <option value="1"
                                            @if (isset($paymentStatus) && $paymentStatus == 1) selected @endif>
                                            {{ localize('Unpaid') }}</option>
                                        <option value="2"
                                            @if (isset($paymentStatus) && $paymentStatus == 2) selected @endif>
                                            {{ localize('Paid') }}</option>
                                    </select>
                                </div>
                            
                                <div class="col-auto">
                                    <select class="form-select select2" name="order_status"
                                        data-minimum-results-for-search="Infinity" id="update_delivery_status">
                                        <option value="">{{ localize('Order Status') }}</option>
                                        <option value="1" @if (isset($orderStatus) && $orderStatus == 1) selected @endif>
                                            {{ localize('Deliverd') }}</option>
                                        <option value="2" @if (isset($orderStatus) && $orderStatus == 2) selected @endif>
                                            {{ localize('Cancelled') }}
                                        <option value="3" @if (isset($orderStatus) && $orderStatus == 3) selected @endif>
                                            {{ localize('Placed') }}
                                        <option value="4" @if (isset($orderStatus) && $orderStatus == 4) selected @endif>
                                            {{ localize('Failed') }}
                                        <option value="5" @if (isset($orderStatus) && $orderStatus == 5) selected @endif>
                                            {{ localize('Pending') }}
                                        </option>
                                    </select>
                                </div>

                    
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="search" width="18"></i>
                                        {{ localize('Search') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table tt-footable border-top align-middle" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-center">{{ localize('S/L') }}
                                </th>
                                <th>{{ localize('Order Code') }}</th>
                                <th data-breakpoints="xs sm md">{{ localize('Customer') }}</th>
                                <th>{{ localize('Placed On') }}</th>
                                <th data-breakpoints="xs">{{ localize('Items') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Payment') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Status') }}</th>
                                <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td class="text-center">
                                        {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}</td>

                                    <td class="fs-sm">
                                        {{ getSetting('order_code_prefix') }}{{ $order->order_code }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img class="rounded-circle"
                                                    src="{{ uploadedAsset(optional($order->user)->avatar) }}"
                                                    alt="avatar"
                                                    onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';" />
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="fs-sm mb-0">{{ optional($order->user)->name }}</h6>
                                                <span class="text-muted fs-sm">
                                                    {{ $order->phone_no ?? '-'}}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="fs-sm">{{ date('d M, Y', strtotime($order->created_at)) }}</span>
                                    </td>

                                    <td class="tt-tb-price">
                                        <span class="fw-bold">
                                            {{ $order->orderItems()->count() }}
                                        </span>
                                    </td>

                                    <td>
                                    
                                        @switch($order->payment_status)
                                            @case(0)
                                                <span class="badge bg-soft-danger rounded-pill text-capitalize">{{ localize('Failed') }}</span>
                                                @break
                                            @case(1)
                                                <span class="badge bg-soft-warning rounded-pill text-capitalize">{{ localize('Unpaid') }}</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-soft-success rounded-pill text-capitalize"> {{ localize('Paid') }}</span>
                                                @break

                                            @default
                                                
                                        @endswitch
                                    </td>

                                    <td>
                                    
                                    @switch($order->order_status)
                                        @case(1)
                                            <span class="badge bg-soft-success rounded-pill text-capitalize">{{ localize('Deliverd') }}</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-soft-danger rounded-pill text-capitalize">{{ localize('Cancelled') }}</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-soft-primary rounded-pill text-capitalize"> {{ localize('Placed') }}</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-soft-danger rounded-pill text-capitalize">{{ localize('Failed') }}</span>
                                            @break
                                        @case(5)
                                            <span class="badge bg-soft-warning rounded-pill text-capitalize"> {{ localize('Pending') }}</span>
                                            @break

                                        @default
                                            
                                    @endswitch

                                    </td>

                                
                                    <td class="text-end">
                                        @can('manage_orders')
                                            <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                                class="btn btn-sm p-0 tt-view-details" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View Details">
                                                <i data-feather="eye"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--pagination start-->
                    <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                        <span>{{ localize('Showing') }}
                            {{ $orders->firstItem() }}-{{ $orders->lastItem() }} {{ localize('of') }}
                            {{ $orders->total() }} {{ localize('results') }}</span>
                        <nav>
                            {{ $orders->appends(request()->input())->links() }}
                        </nav>
                    </div>
                    <!--pagination end-->
                </div>
            </div>
        </div>
    </div>
</section>


</x-backend.app-layout>
