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
                            <h2 class="h5 mb-lg-0">{{ localize('Slider Section Configuration') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4" id="section-1">
                            <table class="table tt-footable" data-use-parent-width="true">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="7%">{{ localize('S/L') }}</th>
                                        <th>{{ localize('Image') }}</th>
                                        <th>{{ localize('Title') }}</th>
                                        <th data-breakpoints="xs sm">{{ localize('Description') }}</th>
                                        <th data-breakpoints="xs sm">{{ localize('Link') }}</th>
                                        <th data-breakpoints="xs sm">{{ localize('Status') }}</th>
                                        <th data-breakpoints="xs sm" class="text-end">
                                            {{ localize('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($sliders))
                                    @foreach ($sliders as $key => $slider)
                                        <tr>
                                            <td class="text-center align-middle">
                                                {{ $key + 1 }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="avatar avatar-lg">
                                                    <img class="rounded" src="{{ uploadedAsset($slider->mobile_image) }}"
                                                        alt="" />
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="fs-sm mb-0">
                                                    {{ $slider->title }}</h6>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="fs-sm mb-0">
                                                    {{ $slider->description }}</h6>
                                            </td>

                                            <td class="align-middle">
                                                <h6 class="fs-sm mb-0" title="{{ $slider->link }}">
                                                    {{ $slider->button_name }}
                                                </h6>
                                            </td>

                                            <td class="align-middle">
                                                <h6 class="fs-sm mb-0">{{ $slider->status=='1' ? 'Active' :'InActive' }}</h6>
                                            </td>

                                            <td class="text-end align-middle">
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>

                                                    
                                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                                        
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.appearance.homepage.editHero', ['id' => $slider->id, 'lang_key' => $locale]) }}&localize">
                                                            <i data-feather="edit-3"
                                                                class="me-2"></i>{{ localize('Edit') }}
                                                        </a>

                                                        <a href="#" class="dropdown-item confirm-delete"
                                                            data-href="{{ route('admin.appearance.homepage.deleteHero', $slider->id) }}"
                                                            title="{{ localize('Delete') }}">
                                                            <i data-feather="trash-2" class="me-2"></i>
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.appearance.homepage.storeHero') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!--slider info start-->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Add New Slider') }}</h5>

                            <div class="mb-4">
                                <label for="title" class="form-label">{{ localize('Title') }}</label>
                                <input type="text" name="title" id="title"
                                    placeholder="{{ localize('Type title') }}" class="form-control" required>
                            </div>


                            <div class="mb-4">
                                <label for="Description" class="form-label">{{ localize('Description') }}</label>
                                <input type="text" name="description" id="Description"
                                    placeholder="{{ localize('Type description') }}" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="button_name" class="form-label">{{ localize('Button Name') }}</label>
                                <input type="text" name="button_name" id="button_name"
                                    placeholder="Contact Us" class="form-control">
                            </div>

                            <div class="mb-4">
                                <label for="link" class="form-label">{{ localize('Link') }}</label>
                                <input type="url" name="link" id="link"
                                    placeholder="{{ env('APP_URL') }}/example" class="form-control">
                            </div>


                            <div class="mb-4">
                                <label class="form-label">{{ localize('Status') }}</label>
                                <select class="select2Max3 form-control" name="status" required>                                
                                    <option value="1">{{ localize('Active') }}</option>
                                    <option value="0" selected> {{ localize('InActive') }}</option>   
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
                                            <input type="hidden" name="desktop_image">
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
                                            <input type="hidden" name="mobile_image">
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
                                    <i data-feather="save" class="me-1"></i> {{ localize('Save Slider') }}
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