<x-backend.app-layout>

@section('title')
    {{ localize('Order Settings') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Enquiry Settings') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 pb-650">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                    class="mb-4">
                    @csrf

                    <!--order settings-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Enquiry Information') }}</h5>
                            {{-- <div class="mb-3">
                                <label for="order_code_prefix"
                                    class="form-label">{{ localize('Order Code Prefix') }}</label>
                                <input type="hidden" name="types[]" value="order_code_prefix">
                                <input type="text" id="order_code_prefix" name="order_code_prefix"
                                    class="form-control" placeholder="{{ localize('#Grostore-') }}"
                                    value="{{ getSetting('order_code_prefix') }}">
                            </div>
                            <div class="mb-3">
                                <label for="order_code_start"
                                    class="form-label">{{ localize('Order Code Starts From') }}</label>
                                <input type="hidden" name="types[]" value="order_code_start">
                                <input type="number" min="1" id="order_code_start" name="order_code_start"
                                    class="form-control" placeholder="{{ localize('1001') }}"
                                    value="{{ getSetting('order_code_start') }}">
                            </div> --}}

                            <div class="mb-3">
                                <label for="order_contact_number" class="form-label">{{ localize('Enquiry SMS Alert Number') }}</label>
                                <input type="hidden" name="types[]" value="order_contact_number">
                                <input type="text" id="order_contact_number" name="order_contact_number"
                                    class="form-control"
                                    value="{{ getSetting('order_contact_number') }}">
                            </div>

                            {{-- <div class="mb-3">
                                <label for="order_partial_status" class="form-label">{{ localize('Order Partial Payment') }}</label>
                                <input type="hidden" name="types[]" value="order_partial_status">
                                <select id="order_partial_status" class="form-control text-uppercase select2"
                                    name="order_partial_status" data-toggle="select2">
                                    <option value="" disabled selected>{{ localize('Select Status') }}</option>
                                    <option value="On" {{ getSetting('order_partial_status') == 'On' ? 'selected' : '' }}>
                                        {{ localize('On') }}
                                    </option>

                                    <option value="Off" {{ getSetting('order_partial_status') == 'Off' ? 'selected' : '' }}>
                                        {{ localize('Off') }}
                                    </option>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="order_partial_amount" class="form-label">{{ localize('Order Partial Payment Amount') }}</label>
                                <input type="hidden" name="types[]" value="order_partial_amount">
                                <input type="text" id="order_partial_amount" name="order_partial_amount"
                                    class="form-control"
                                    value="{{ getSetting('order_partial_amount') }}">
                            </div>


                            <div class="mb-3">
                                <label for="invoice_thanksgiving"
                                    class="form-label">{{ localize('Invoice Thank You Message') }}</label>
                                <input type="hidden" name="types[]" value="invoice_thanksgiving">
                                <textarea rows="4" id="invoice_thanksgiving" name="invoice_thanksgiving" class="form-control"
                                    placeholder="{{ localize('Type your thank you message for invoice') }}">{{ getSetting('invoice_thanksgiving') }}</textarea>
                            </div> --}}

                        </div>
                    </div>
                    <!--order settings-->


                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit">
                            <i data-feather="save" class="me-1"></i> {{ localize('Save Configuration') }}
                        </button>
                    </div>
                </form>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Configure Order Settings') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Enquiry Information') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@push('scripts')
    <script>
        "use strict";

        // runs when the document is ready --> for media files
        $(document).ready(function() {
            //
        });
    </script>
@endpush

</x-backend.app-layout>
