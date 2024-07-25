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
                            <h2 class="h5 mb-lg-0">{{ localize('Update Slider') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">

                <form action="{{ route('admin.appearance.homepage.updateHero') }}" method="POST"
                    enctype="multipart/form-data" id="section-1">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    @php
                        $slider = null;
                        if (!empty($sliders)) {
                            foreach ($sliders as $key => $thisSlider) {
                                if ($thisSlider->id == $id) {
                                    $slider = $thisSlider;
                                }
                            }
                        }
                    @endphp
                    <!--slider info start-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="title" class="form-label">{{ localize('Title') }}</label>
                                <input type="text" name="title" id="title"
                                    placeholder="{{ localize('Type title') }}" class="form-control"
                                    value="{{ $slider->title }}" required>
                            </div>


                            <div class="mb-4">
                                <label for="description" class="form-label">{{ localize('Description') }}</label>
                                <input type="text" name="description" id="description"
                                    placeholder="{{ localize('Type description') }}" class="form-control"
                                    value="{{ $slider->description ?? ''}}" required>
                            </div>

                            <div class="mb-4">
                                <label for="button_name" class="form-label">{{ localize('Button Name') }}</label>
                                <input type="text" name="button_name" id="button_name"
                                    placeholder="Contact Us" class="form-control"  value="{{ $slider->button_name ?? '' }}">
                            </div>

                            <div class="mb-4">
                                <label for="link" class="form-label">{{ localize('Link') }}</label>
                                <input type="url" name="link" id="link"
                                    placeholder="{{ env('APP_URL') }}/example" class="form-control"
                                    value="{{ $slider->link ?? '' }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">{{ localize('Status') }}</label>
                                <select class="select2Max3 form-control" name="status" required>

                                    <option value="1" @if ($slider->status=='1') selected @endif>
                                        {{ localize('Active') }}
                                    </option>

                                    <option value="0" @if ($slider->status=='0') selected @endif>
                                        {{ localize('InActive') }}
                                    </option>

                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">{{ localize('Desktop Slider Image') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Choose Desktop Slider Image') }}</span>
                                    <!-- choose media -->
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="desktop_image" value="{{ $slider->desktop_image }}">
                                            <div class="no-avatar rounded-circle">
                                                <span><i data-feather="plus"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- choose media -->
                                </div>
                            </div>


                            <div class="mb-4">
                                <label class="form-label">{{ localize('Mobile Slider Image') }}</label>
                                <div class="tt-image-drop rounded">
                                    <span class="fw-semibold">{{ localize('Choose Mobile Slider Image') }}</span>
                                    <!-- choose media -->
                                    <div class="tt-product-thumb show-selected-files mt-3">
                                        <div class="avatar avatar-xl cursor-pointer choose-media"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                            onclick="showMediaManager(this)" data-selection="single">
                                            <input type="hidden" name="mobile_image" value="{{ $slider->mobile_image }}">
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
                    <!--slider info end-->


                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
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
                        <h5 class="mb-4">{{ localize('Hero Section Configuration') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Update Slider') }}</a>
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
            getChosenFilesCount();
            showSelectedFilePreviewOnLoad();
        });
    </script>
@endpush

</x-backend.app-layout>
