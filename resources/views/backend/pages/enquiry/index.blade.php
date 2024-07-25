<x-backend.app-layout>

@section('title')
    {{ localize('Product Enquiries') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Product Enquiry') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-4" id="section-1">

                    <table class="table  border-top align-middle" data-use-parent-width="true">
                        <thead>
                            <tr>
                                <th class="text-center">{{ localize('S/L') }}</th>
                                <th>{{ localize('Name') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Email') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Phone') }}</th>
                                <th data-breakpoints="xs sm">{{ localize('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $key => $message)
                                <tr class="{{ $message->is_seen == 0 ? 'fw-bold' : 'fw-light' }}">
                                    <td class="text-center">
                                        {{ $key + 1 + ($messages->currentPage() - 1) * $messages->perPage() }}
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
                        </tbody>
                    </table>
                    <!--pagination start-->
                    <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                        <span>{{ localize('Showing') }}
                            {{ $messages->firstItem() }}-{{ $messages->lastItem() }} {{ localize('of') }}
                            {{ $messages->total() }} {{ localize('results') }}</span>
                        <nav>
                            {{ $messages->appends(request()->input())->links() }}
                        </nav>
                    </div>
                    <!--pagination end-->
                </div>
            </div>
        </div>
    </div>
</section>



</x-backend.app-layout>