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
                            <h2 class="h5 mb-lg-0">{{ localize('Home Page Content Configuration') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
              
                @if(!empty($contentObj) && !empty($contentObj->id))
                <form action="{{ route('admin.appearance.homepage.updateContent') }}" method="POST"
                    enctype="multipart/form-data">
                <input type="hidden" value="{{$contentObj->id}}" name="id">
                @else
                    <form action="{{ route('admin.appearance.homepage.storeContent') }}" method="POST"
                    enctype="multipart/form-data">
                @endif
                    @csrf
                    <!--About-us info start-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('About-us') }}</h5>

                            <div class="mb-4">
                                <label for="title" class="form-label">{{ localize('Title') }}</label>
                                <input type="text" name="abount_us_title" id="title" value="{{$contentObj->abount_us_title ?? ''}}"
                                    placeholder="{{ localize('Type title') }}" class="form-control" required>
                            </div>  

                            <div class="mb-4">
                                <label for="experience" class="form-label">{{ localize('Experience') }}</label>
                                <input type="text" name="abount_us_experience" id="experience" value="{{$contentObj->abount_us_experience ?? ''}}"
                                    placeholder="{{ localize('Type experience') }}" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="form-label">{{ localize('Html') }}</label>
                                <textarea  class="editor" name="about_us_html" required>
                                    {{$contentObj->about_us_html ?? ''}}
                                </textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">{{ localize('Image') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Choose Image') }}</span>
                                    <!-- choose media -->
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden"  name="about_us_image"  value="{{ $contentObj->about_us_image ?? '' }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- choose media -->
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--About-us info end-->

                     <!--OUR STRENGTH info start-->
                     <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Our Strength') }}</h5>

                            <div class="mb-4">
                                <label for="title" class="form-label">{{ localize('Title') }}</label>
                                <input type="text" name="our_strength_title" id="title" value="{{ $contentObj->our_strength_title ?? '' }}"
                                    placeholder="{{ localize('Type title') }}" class="form-control" required>
                            </div>  

                            <div class="mb-4">
                                <label for="title" class="form-label">{{ localize('Html') }}</label>
                                <textarea  class="editor" name="our_strength_html" required>
                                    {{ $contentObj->our_strength_html ?? '' }}
                                </textarea>
                            </div>

                        </div>
                    </div>
                    <!--OUR STRENGTH info end-->

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