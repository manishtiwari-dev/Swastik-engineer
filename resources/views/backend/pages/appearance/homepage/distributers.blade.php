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
                            <h2 class="h5 mb-lg-0">{{ localize('Select Top Categories') }}</h2>
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
                    <!--top categories info start-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="">
                                @php
                                    $top_distributers = getSetting('top_distributer_ids') != null ? json_decode(getSetting('top_distributer_ids')) : [];
                                @endphp
                                <input type="hidden" name="types[]" value="top_distributer_ids">
                                <select class="select2 form-control" multiple="multiple"
                                    data-placeholder="{{ localize('Select top distributers') }}" name="top_distributer_ids[]"
                                    required>
                                    @foreach ($distributers as $distributer)
                                        <option value="{{ $distributer->id }}"
                                            @if (in_array($distributer->id, $top_distributers)) selected @endif>
                                            {{ $distributer->collectLocalization('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--top categories info end-->


                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
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
                        <h5 class="mb-4">{{ localize('Homepage Configuration') }}</h5>
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

</x-backend.app-layout>
