<x-backend.app-layout>

@section('title')
    {{ localize('Payment Methods Settings') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Payment Methods Settings') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.settings.updatePaymentMethods') }}" method="POST"
                    enctype="multipart/form-data" class="pb-650">
                    @csrf

                    <!--cod settings-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Cash On Delivery') }}</h5>
                            <input type="hidden" name="payment_methods[]" value="cod">
                            <div class="mb-3">
                                <label class="form-label">{{ localize('Enable COD') }}</label>
                                <select id="enable_cod" class="form-control select2" name="enable_cod"
                                    data-toggle="select2">
                                    <option value="0" {{ getSetting('enable_cod') == '0' ? 'selected' : '' }}>
                                        {{ localize('Disable') }}</option>
                                    <option value="1" {{ getSetting('enable_cod') == '1' ? 'selected' : '' }}>
                                        {{ localize('Enable') }}</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <!--cod settings-->


                    <!--paypal settings-->
                    <div class="card mb-4" id="section-2">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Paypal Credentials') }}</h5>
                            <input type="hidden" name="payment_methods[]" value="paypal">
                            <div class="mb-3">
                                <label for="PAYPAL_CLIENT_ID"
                                    class="form-label">{{ localize('Paypal Client ID') }}</label>
                                <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                                <input type="text" id="PAYPAL_CLIENT_ID" name="PAYPAL_CLIENT_ID" class="form-control"
                                    value="{{ env('PAYPAL_CLIENT_ID') }}">
                            </div>
                            <div class="mb-3">
                                <label for="PAYPAL_CLIENT_SECRET"
                                    class="form-label">{{ localize('Paypal Client Secret') }}</label>
                                <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                                <input type="text" id="PAYPAL_CLIENT_SECRET" name="PAYPAL_CLIENT_SECRET"
                                    class="form-control" value="{{ env('PAYPAL_CLIENT_SECRET') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ localize('Enable Paypal') }}</label>
                                <select id="enable_paypal" class="form-control select2" name="enable_paypal"
                                    data-toggle="select2">
                                    <option value="0" {{ getSetting('enable_paypal') == '0' ? 'selected' : '' }}>
                                        {{ localize('Disable') }}</option>
                                    <option value="1" {{ getSetting('enable_paypal') == '1' ? 'selected' : '' }}>
                                        {{ localize('Enable') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ localize('Enable Test Sandbox Mode') }}</label>
                                <select id="paypal_sandbox" class="form-control select2" name="paypal_sandbox"
                                    data-toggle="select2">
                                    <option value="0" {{ getSetting('paypal_sandbox') == '0' ? 'selected' : '' }}>
                                        {{ localize('Disable') }}</option>
                                    <option value="1" {{ getSetting('paypal_sandbox') == '1' ? 'selected' : '' }}>
                                        {{ localize('Enable') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--paypal settings-->

                    <!--razorpay settings-->
                    <div class="card mb-4" id="section-5">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Razorpay Credentials') }}</h5>
                            <input type="hidden" name="payment_methods[]" value="razorpay">
                            <div class="mb-3">
                                <label for="RAZORPAY_KEY" class="form-label">{{ localize('Razorpay Key') }}</label>
                                <input type="hidden" name="types[]" value="RAZORPAY_KEY">
                                <input type="text" id="RAZORPAY_KEY" name="RAZORPAY_KEY" class="form-control"
                                    value="{{ env('RAZORPAY_KEY') }}">
                            </div>
                            <div class="mb-3">
                                <label for="RAZORPAY_SECRET"
                                    class="form-label">{{ localize('Razorpay Secret') }}</label>
                                <input type="hidden" name="types[]" value="RAZORPAY_SECRET">
                                <input type="text" id="RAZORPAY_SECRET" name="RAZORPAY_SECRET"
                                    class="form-control" value="{{ env('RAZORPAY_SECRET') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ localize('Enable Razorpay') }}</label>
                                <select id="enable_razorpay" class="form-control select2" name="enable_razorpay"
                                    data-toggle="select2">
                                    <option value="0"
                                        {{ getSetting('enable_razorpay') == '0' ? 'selected' : '' }}>
                                        {{ localize('Disable') }}</option>
                                    <option value="1"
                                        {{ getSetting('enable_razorpay') == '1' ? 'selected' : '' }}>
                                        {{ localize('Enable') }}</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <!--razorpay settings-->

        

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
                        <h5 class="mb-4">{{ localize('Payment Methods Settings') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Cash On Delivery') }}</a>
                                </li>
                                <li>
                                    <a href="#section-2">{{ localize('Paypal Credentials') }}</a>
                                </li>
                                
                                <li>
                                    <a href="#section-5">{{ localize('Razorpay Credentials') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</x-backend.app-layout>