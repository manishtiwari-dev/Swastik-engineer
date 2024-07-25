<x-backend.app-layout>

@section('title')
    {{ localize('Dashboard') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@can('dashboard')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Admin Dashboard') }}</h2>
                            </div>
                            <div class="tt-action">

                                @can('product_enquiries')
                                    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary"><i
                                            data-feather="shopping-cart" class="me-2"></i>{{ localize('Manage Enquries') }}</a>
                                @endcan

                                @can('add_products')
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary ms-2"><i
                                            data-feather="plus" class="me-2"></i>
                                        {{ localize('Add Product') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-xl-9">
                    <div class="row g-3">
                        @can('manage_orders')
                        <a href="{{ route('admin.enquiries.index') }}" class="col-sm-6 col-md-4 col-lg-4">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-primary rounded-circle">
                                                <span class="text-primary"> <i data-feather="shopping-bag"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\ProductEnquiry::count() }}</h4>
                                            <span class="text-muted">{{ localize('Total Enquiry') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
    
                        <a href="{{ route('admin.enquiries.index') }}"
                            class="col-sm-6 col-md-4 col-lg-4">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-warning rounded-circle">
                                                <span class="text-warning"> <i data-feather="clock"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\ProductEnquiry::where('is_seen',0)->count() }}</h4>
                                            <span class="text-muted">{{ localize('Pending') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                       
                        <a href="{{ route('admin.enquiries.index') }}"
                            class="col-sm-6 col-md-4 col-lg-4">
                            <div class="card h-100 flex-column">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-lg">
                                            <div class="text-center bg-soft-success rounded-circle">
                                                <span class="text-success"> <i data-feather="check-circle"></i></span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="mb-1">{{ \App\Models\ProductEnquiry::where('is_seen',1)->count() }}</h4>
                                            <span class="text-muted">{{ localize('Read') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endcan
                        <!-- total sales chart -->

                        <!-- sales this month chart -->
                        {{-- <div class="col-l2">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted">{{ localize('Enquiries This Months') }}</span>
                                    </div>
                                    <h4 class="fw-bold mb-0">{{ formatPrice($thisMonthSaleData->totalEarning) }}</h4>
                                </div>
                                <div id="thisMonthChart" class="px-3"></div>
                            </div>
                        </div> --}}
                        <!-- sales this month chart -->

                    </div>
                </div>

                <div class="col-xl-3">
                    <!-- top selling products -->
                    <div class="card h-100 flex-column">
                        <div class="card-body px-0">
                            <div class="px-3">
                                <h5 class="fw-bold mb-1">{{ localize('Top Trending Products') }}</h5>
                                <span class="text-muted">
                                    {{ localize('We have listed ' . \App\Models\Product::count() . ' total products.') }}</span>
                            </div>
                            <div class="tt-top-selling mt-3 " data-simplebar>
                                <ul class="tt-top-selling-list list-unstyled mb-0 px-3">
                                    @php
                                        $top_selling_products = \App\Models\Product::where('total_sale_count', '>', 0)
                                            ->orderBy('total_sale_count', 'DESC')
                                            ->take(15)
                                            ->get();
                                    @endphp
                                    @foreach ($top_selling_products as $product)
                                        <li class="py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <img class="rounded-circle"
                                                        src="{{ uploadedAsset($product->thumbnail_image) }}"
                                                        alt="" />
                                                </div>
                                                <div class="ms-2">
                                                    <h6 class="fs-md mb-0 tt-line-clamp tt-clamp-1">
                                                        {{ $product->collectLocalization('name') }}
                                                    </h6>
                                                   
                                                </div>
                                            </div>
                                            <span class="fw-bold heading-font text-end  cursor-pointer"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ localize('Total Sales') }}">({{ $product->total_sale_count }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- top selling products -->
                </div>
            </div>

          

            @can('orders')
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1">
                                        <h5 class="mb-1">{{ localize('Recent Enquiries') }}</h5>
                                        <span class="text-muted">{{ localize('Your 10 Most Recent Enquiry') }}</span>
                                    </div>

                                    <div class="col-auto">
                                        @can('product_enquiries')
                                            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-primary">
                                                <i data-feather="eye" width="18"></i>
                                                {{ localize('View All') }}
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>

                            @php
                                $messages = App\Models\ProductEnquiry::latest()->take(10)->get();
                            @endphp
                            <table class="table tt-footable border-top align-middle" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="ps-4">{{ localize('S/L') }}</th>
                                        <th>{{ localize('Name') }}</th>
                                        <th data-breakpoints="xs">{{ localize('Email') }}</th>
                                        <th data-breakpoints="xs">{{ localize('Phone') }}</th>
                                        <th data-breakpoints="xs">{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($messages) && sizeof($messages)>0)
                                        @foreach ($messages as $key => $message)
                                            <tr class="{{ $message->is_seen == 0 ? 'fw-bold' : 'fw-light' }}">
                                                <td class="text-center">
                                                    {{ $key + 1 }}
                                                </td>
            
                                                <td> {{ $message->name }} </td>
            
                                                <td>
                                                    <a href="mailto:{{ $message->email }}"
                                                        class="text-dark">{{ $message->email ?? localize('n/a') }}</a>
                                                </td>
            
                                                <td>
                                                    {{ $message->phone ?? localize('n/a') }}
                                                </td>
            
                                
                                                <td >
                                                    <div class="dropdown tt-tb-dropdown">
                                                        <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i data-feather="more-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow">
            
            
                                                            <a class="dropdown-item" href="detailModal_{{$message->id}}" data-bs-toggle="modal" data-bs-target="#detailModal_{{$message->id}}">
                                                                <i data-feather="eye" class="me-2"></i>{{localize('View Detail')}}
                                                            </a>
            
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.enquiries.markRead', ['id' => $message->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                                <i data-feather="check"
                                                                    class="me-2"></i>{{ $message->is_seen == 0 ? localize('Mark As Read') : localize('Mark As Unread') }}
                                                            </a>
            
                                                            <a class="dropdown-item" href="mailto:{{ $message->email ?? '' }}">
                                                                <i data-feather="message-circle"
                                                                    class="me-2"></i>{{ localize('Reply in Email') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
            
            
                                            <!--Detail Modal Start-->
                                            <div class="modal fade" id="detailModal_{{$message->id}}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel">Enquiry Detail</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-lg-12 mb-3">
                                                                    <strong>  Name</strong> : {{ $message->name }}
                                                                </div>
                                                                <div class="col-lg-12 mb-3">
                                                                    <strong>  Email</strong> : {{ $message->email  ?? localize('n/a') }}
                                                                </div>
            
                                                                <div class="col-lg-12 mb-3">
                                                                    <strong>  Phone</strong> : {{ $message->phone ?? localize('n/a') }}
                                                                </div>
                                                                <div class="col-lg-12 mb-3">
                                                                <strong> Product Name</strong> : {{ $message->product->collectLocalization('name') ?? localize('n/a')}}
                                                                </div>
            
                                                                <div class="col-lg-12 mb-3">
                                                                    <strong>  Message</strong> : {{ $message->message  ?? localize('n/a')}}
                                                                </div>
                                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!--Detail Modal End-->
                                            
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">
                                                No Record !
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan

         

        </div>
    </section>
@endcan


@push('scripts')

    <script>
        "use strict";
        // total earning chart
        var totalSales = {
            chart: {
                type: "area",
                height: 80,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: '{{ localize('Earning') }}',
                data: [{!! $totalSalesData->amount !!}],
            }, ],
            labels: [{!! $totalSalesData->labels !!}],
            xaxis: {
                type: "datetime",
            },
            yaxis: {
                min: 0,
            },
            colors: ["#FF7C08"],
        };
        new ApexCharts(document.querySelector("#totalSales"), totalSales).render();

        //pie chart top five
        var optionsTopFive = {
            chart: {
                type: "donut",
                height: 100,
                offsetY: 15,
                offsetX: -20,
            },
            series: {!! $totalCatSalesData->series !!},
            labels: [{!! $totalCatSalesData->labels !!}],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                        show: false,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                },
            }, ],
        };

        var chartTopFive = new ApexCharts(
            document.querySelector("#topFive"),
            optionsTopFive
        );
        chartTopFive.render();

        // last 30 days order chart 
        var optionsBar = {
            chart: {
                type: "bar",
                height: 80,
                width: "100%",
                stacked: true,
                offsetX: -3,
                sparkline: {
                    enabled: true,
                },
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: false,
                    },
                    columnWidth: "60%",
                    endingShape: "rounded",
                },
            },
            colors: ["#1E90FF"],
            series: [{
                name: "Orders",
                data: [{!! $totalOrdersData->amount !!}],
            }, ],
            labels: [{!! $totalOrdersData->labels !!}],
            xaxis: {
                type: "datetime",
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                crosshairs: {
                    show: false,
                },
                labels: {
                    show: false,
                    style: {
                        fontSize: "14px",
                    },
                },
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
                yaxis: {
                    lines: {
                        show: false,
                    },
                },
            },
            yaxis: {
                axisBorder: {
                    show: false,
                },
                labels: {
                    show: false,
                },
            },
            legend: {
                floating: false,
                position: "bottom",
                horizontalAlign: "right",
            },
            tooltip: {
                shared: true,
                intersect: false,
            },
        };
        var chartBar = new ApexCharts(document.querySelector("#last30DaysOrders"), optionsBar);
        chartBar.render();

        // this month sales 
        var options = {
            chart: {
                height: 210,
                width: "100%",
                type: "area",
                offsetX: -10,
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
                width: 2,
            },

            colors: ["#4EB529"],
            series: [{
                name: "Sales",
                data: [{!! $thisMonthSaleData->amount !!}],
            }],
            zoom: {
                enabled: false,
            },
            legend: {
                show: false,
                enabled: false,
            },
            labels: [{!! $thisMonthSaleData->labels !!}],
            xaxis: {
                labels: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },

            }
        };
        var chart = new ApexCharts(document.querySelector("#thisMonthChart"), options);
        chart.render();
    </script>
@endpush
</x-backend.app-layout>