<x-backend.app-layout>

@section('title')
    {{ localize('Website Homepage Configuration') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Recent Added Products') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!--slider info start-->
                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="mb-3">
                                @php
                                    $recent_added_products = getSetting('recent_added_products') != null ? json_decode(getSetting('recent_added_products')) : [];
                                @endphp
                                <label class="form-label">{{ localize('Best Selling Products') }}</label>
                                <input type="hidden" name="types[]" value="recent_added_products">
                                <select class="select2 form-control" multiple="multiple"
                                    data-placeholder="{{ localize('Select products') }}" name="recent_added_products[]"
                                    required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if (in_array($product->id, $recent_added_products)) selected @endif>
                                            {{ $product->collectLocalization('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--slider info end-->
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar">
                    <div class="card-body">
                        <h5 class="mb-3">{{ localize('Homepage Configuration') }}</h5>
                        <div class="tt-vertical-step-link">
                            <ul class="list-unstyled">
                                @include('backend.pages.appearance.homepage.inc.rightSidebar')
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
            getChosenFilesCount();
            showSelectedFilePreviewOnLoad();
        });
    </script>
@endpush

</x-backend.app-layout>