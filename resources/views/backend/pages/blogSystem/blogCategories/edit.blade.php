<x-backend.app-layout>

@section('title')
    {{ localize('Update Blog Category') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Update Category') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.blogCategories.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>
                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Category Name') }}</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    placeholder="{{ localize('Type category name') }}" required
                                    value="{{ $category->name }}">
                            </div>
                        </div>
                    </div>
                    <!--basic information end-->

                    <!-- submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- submit button end -->
                </form>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar d-none d-xl-block">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Category Information') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
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