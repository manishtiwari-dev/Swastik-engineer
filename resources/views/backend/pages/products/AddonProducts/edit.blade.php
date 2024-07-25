<x-backend.app-layout>


@section('title')
    {{ localize('Update AddOn-Product') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto flex-grow-1">
                                <div class="tt-page-title">
                                    <h2 class="h5 mb-0">{{ localize('Update AddOn-Product') }} <sup
                                            class="badge bg-soft-warning px-2">{{ $lang_key }}</sup></h2>
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <select id="language" class="w-100 form-control text-capitalize country-flag-select"
                                    data-toggle="select2" onchange="localizeData(this.value)">
                                    @foreach (\App\Models\Language::all() as $key => $language)
                                        <option value="{{ $language->code }}"
                                            {{ $lang_key == $language->code ? 'selected' : '' }}
                                            data-flag="{{ staticAsset('backend/assets/img/flags/' . $language->flag . '.png') }}">
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.addon-products.update') }}" method="POST" class="pb-650" id="product-form">
                    @csrf

                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="lang_key" value="{{ $lang_key }}">

                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">{{ localize('Product Name') }}</label>
                                <input class="form-control" type="text" id="name"
                                    placeholder="{{ localize('Type your product name') }}" name="name"
                                    value="{{ $product->collectLocalization('name', $lang_key) }}" required>
                                <span class="fs-sm text-muted">
                                    {{ localize('Product name is required and recommended to be unique.') }}
                                </span>
                            </div>

                            @if (env('DEFAULT_LANGUAGE') == $lang_key)
                                <div class="mb-4">
                                    <label for="slug" class="form-label">{{ localize('Product Slug') }}</label>
                                    <input class="form-control" type="text" id="slug"
                                        placeholder="{{ localize('Type your product name') }}" name="slug"
                                        value="{{ $product->slug }}">
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="short_description"
                                    class="form-label">{{ localize('Short Description') }}</label>
                                <textarea class="form-control" id="short_description"
                                    placeholder="{{ localize('Type your product short description') }}" rows="5" name="short_description">{{ $product->collectLocalization('short_description', $lang_key) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label">{{ localize('Description') }}</label>
                                <textarea id="description" class="editor" name="description">{{ $product->collectLocalization('description', $lang_key) }}</textarea>
                            </div>

                        </div>
                    </div>
                    <!--basic information end-->

                    @if (env('DEFAULT_LANGUAGE') == $lang_key)
                        <!--product image and gallery start-->
                        <div class="card mb-4" id="section-2">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Images') }}</h5>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Thumbnail') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Product Thumbnail') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="image"
                                                    value="{{ $product->thumbnail_image }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Gallery') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Gallery Images') }}</span>

                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="multiple">
                                                <input type="hidden" name="gallery_images"
                                                    value="{{ $product->gallery_images }}">
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
                        <!--product image and gallery end-->

                        <!--product category start-->
                        <div class="card mb-4" id="section-3">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Product Categories') }}</h5>
                                <div class="mb-4">
                                    @php
                                        $product_categories = $product->categories()->pluck('category_id');
                                    @endphp
                                    <select class="select2 form-control" multiple="multiple"
                                        data-placeholder="{{ localize('Select Categories') }}" name="category_ids[]"
                                        required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product_categories->contains($category->id) ? 'selected' : '' }}>
                                                {{ $category->collectLocalization('name') }}</option>
                                            @foreach ($category->childrenCategories as $childCategory)
                                                @include(
                                                    'backend.pages.products.products.subCategory',
                                                    [
                                                        'subCategory' => $childCategory,
                                                        'product_categories' => $product_categories,
                                                    ]
                                                )
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--product category end-->

                        <!--product tag start-->
                        <div class="card mb-4" id="section-4">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Product Tags') }}</h5>
                                <div class="mb-4">
                                    @php
                                        $productTags = $product->tags()->pluck('tag_id');
                                    @endphp
                                    <select class="select2 form-control" multiple="multiple"
                                        data-placeholder="{{ localize('Select Categories') }}" name="tag_ids[]">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                {{ $productTags->contains($tag->id) ? 'selected' : '' }}>
                                                {{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--product tag end-->

                        <!--product price sku and stock start-->
                        <div class="card mb-4" id="section-5">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-4">{{ localize('Price') }}</h5>
                                </div>

                                <!-- without variation start-->
                                <div class="noVariation">
                                    <div class="row g-3">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <input type="number" min="0" step="0.0001" id="price"
                                                    name="price" placeholder="{{ localize('Product price') }}"
                                                    class="form-control" value="{{ $product->price ?? '' }}" required >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- without variation start end-->
                            </div>
                            <!--for variation row end-->
                        </div>
                        <!--product price sku and stock end-->

                        <!--product tax start-->
                        <div class="card mb-4" id="section-6">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Product Taxes') }} ({{ localize('Default 0%') }})
                                </h5>
                                <div class="row g-3">
                                    @foreach ($taxes as $tax)
                                        @php
                                            $tax_value = 0;
                                            $tax_type = 'flat';
                                            foreach ($product->taxes as $productTax) {
                                                if ($productTax->tax_id == $tax->id) {
                                                    $tax_value = $productTax->tax_value;
                                                    $tax_type = $productTax->tax_type;
                                                }
                                            }
                                        @endphp

                                        <div class="col-lg-6">
                                            <div class="mb-0">
                                                <label class="form-label">{{ $tax->name }}</label>
                                                <input type="hidden" value="{{ $tax->id }}" name="tax_ids[]">
                                                <input type="number" lang="en" min="0" step="0.01"
                                                    placeholder="{{ localize('Tax') }}" name="taxes[]"
                                                    class="form-control" required value="{{ $tax_value }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-0">
                                                <label class="form-label">{{ localize('Percent or Fixed') }}</label>
                                                <select class="select2 form-control" name="tax_types[]">
                                                    <option value="percent"
                                                        {{ $tax->tax_type == 'percent' ? 'selected' : '' }}>
                                                        {{ localize('Percent') }} % </option>
                                                    <option value="flat"
                                                        {{ $tax->tax_type == 'flat' ? 'selected' : '' }}>
                                                        {{ localize('Fiexed') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!--product tax end-->

                        <!--product sell target & status start-->
                        <div class="row g-3" id="section-7">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="mb-4">{{ localize('Product Status') }}</h5>
                                        <div class="tt-select-brand">
                                            <select class="select2 form-control" id="is_published"
                                                name="is_published">
                                                <option value="1"
                                                    {{ $product->is_published == 1 ? 'selected' : '' }}>
                                                    {{ localize('Published') }}</option>
                                                <option value="0"
                                                    {{ $product->is_published == 0 ? 'selected' : '' }}>
                                                    {{ localize('Unpublished') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--product sell target & status end-->

                        <!--seo meta description start-->
                        <div class="card mb-4" id="section-8">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('SEO Meta Configuration') }}</h5>

                                <div class="mb-4">
                                    <label for="meta_title" class="form-label">{{ localize('Meta Title') }}</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                        placeholder="{{ localize('Type meta title') }}" class="form-control"
                                        value="{{ $product->meta_title }}">
                                    <span class="fs-sm text-muted">
                                        {{ localize('Set a meta tag title. Recommended to be simple and unique.') }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <label for="meta_description"
                                        class="form-label">{{ localize('Meta Description') }}</label>
                                    <textarea class="form-control" name="meta_description" id="meta_description" rows="4"
                                        placeholder="{{ localize('Type your meta description') }}">{{ $product->meta_description }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Meta Image') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Meta Image') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="meta_image"
                                                    value="{{ $product->meta_img }}">
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
                        <!--seo meta description end-->
                    @endif

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
                        <h5 class="mb-4">{{ localize('Product Information') }}</h5>
                        <div class="tt-vertical-step">
                        
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                </li>
                                @if (env('DEFAULT_LANGUAGE') == $lang_key)
                                <li>
                                    <a href="#section-2">{{ localize('Product Images') }}</a>
                                </li>
                                <li>
                                    <a href="#section-3">{{ localize('Category') }}</a>
                                </li>
                                <li>
                                    <a href="#section-4">{{ localize('Product tags') }}</a>
                                </li>
                               
                                <li>
                                    <a href="#section-5">{{ localize('Price') }}</a>
                                </li>
                            
                                <li>
                                    <a href="#section-6">{{ localize('Product Taxes') }}</a>
                                </li>

                                <li>
                                    <a href="#section-7">{{ localize('Status') }}</a>
                                </li>
                                <li>
                                    <a href="#section-8">{{ localize('SEO Meta Options') }}</a>
                                </li>
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@push('scripts')
    @include('backend.inc.product-scripts')
@endpush

</x-backend.app-layout>