<header id="site-header" class="site-header header-static site-header-12 no-border sticky-top">
    <div class="octf-main-header py-2">
        <div class="octf-area-wrap">
            <div class="container-fluid octf-mainbar-container">
                <div class="octf-mainbar">
                    <div class="octf-mainbar-row octf-row">
                        <div class="octf-col logo-col">
                            <div id="site-logo" class="site-logo py-0">

                                <a href="{{ url('/') }}" class="logo-text-wrapper">
                                    <div class="d-flex align-items-center">

                                        <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}"
                                        onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';"
                                         alt="{{getSetting('system_title')}}">

                                        <div class="logo-text text-center">
                                            <p class="mb-0">SWASTIK ENGINEERS</p>
                                            <span>An ISO 9001: 2008 Certified Organization</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="octf-col menu-col">
                            <div id="topnav">
                                <!-- Navigation Menu-->
                                <ul class="navigation-menu">
                                    <li>
                                        <a href="">Home</a>
                                    </li>
                                    <li>
                                        <a href="">About Us</a>
                                    </li>
                                    <li class="has-submenu me-4 ">
                                        <a href="javascript:void(0)">Products</a><span class="menu-arrow"></span>
                                        <ul class="submenu megamenu">
                                            @if (!empty($category_data))
                                                @foreach ($category_data as $key => $data)
                                                   @if(!empty($data->sub_category) && sizeof($data->sub_category)>0)
                                                        <li class="mega-menu-item  py-lg-3 ">
                                                            <div>
                                                                <ul class="d-flex row">
                                                                    <div class="pb-0 mb-0">
                                                                        <a href="{{ route('category.show', $data->slug) }}"
                                                                            class="">
                                                                            <div class="megamenu-head">
                                                                                {{ $data->name }}
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    @if (!empty($data->sub_category))
                                                                        @foreach ($data->sub_category as $key => $sub_cat)
                                                                            <li>
                                                                                <a href="{{ route('category.show', $sub_cat->slug) }}"
                                                                                    class="sub-menu-item d-flex">
                                                                                    <div>
                                                                                        {{$sub_cat->name ?? '' }}
                                                                                    </div>
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>

                                    <li class="has-submenu single-submenu me-4">
                                        <a href="javascript:void(0)">Brands</a>
                                        <span class="menu-arrow"></span>
                                        <ul class="submenu megamenu">
                                            {{-- @dd($brand_cat_list) --}}
                                            @if (!empty($brand_category_data))
                                                @foreach ($brand_category_data as $key => $catData)
                                                    @if (!empty($catData))
                                                        @foreach ($catData->cat as $key => $data)
                                                            @if(!empty($data->brands) && sizeof($data->brands)>0)
                                                            <li class="mega-menu-item  py-lg-3 ">
                                                                <div>
                                                                    <ul class="d-flex row">

                                                                        <div class="pb-0 mb-0">
                                                                            <a href="{{ route('category.show', $data->slug) }}"
                                                                                class="">
                                                                                <div class="megamenu-head">
                                                                                    {{ $data->name }}
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        @if (!empty($data->brands))
                                                                            @foreach ($data->brands as $key => $brand_cat)
                                                                                <li>
                                                                                    <a href="{{ route('brand.show', $brand_cat->slug) }} "
                                                                                        class="sub-menu-item d-flex">
                                                                                        <div>{{ $brand_cat->name }}
                                                                                        </div>
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif

                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach

                                            @endif
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{route('career.index')}}">Career</a>
                                    </li>
                                    {{-- <li>
                                        <a href="">Contact Us</a>
                                    </li> --}}
                                </ul>

                            </div>
                        </div>
                        <div class="octf-col cta-col text-right">
                            <!-- Call To Action -->
                            <div class="octf-btn-cta">

                                <div class="octf-header-module">
                                    <div class="btn-cta-group btn-cta-header i12 d-flex">
                                        <a class="d-flex text-link align-self-center"
                                            href="tel:{{ getSetting('navbar_contact_number') }}">
                                            <span class="align-self-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 384 384">
                                                    <path
                                                        d="M353.188,252.052c-23.51,0-46.594-3.677-68.469-10.906c-10.719-3.656-23.896-0.302-30.438,6.417l-43.177,32.594   c-50.073-26.729-80.917-57.563-107.281-107.26l31.635-42.052c8.219-8.208,11.167-20.198,7.635-31.448   c-7.26-21.99-10.948-45.063-10.948-68.583C132.146,13.823,118.323,0,101.333,0H30.813C13.823,0,0,13.823,0,30.813   C0,225.563,158.438,384,353.188,384c16.99,0,30.813-13.823,30.813-30.813v-70.323C384,265.875,370.177,252.052,353.188,252.052z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span>{{ getSetting('navbar_contact_number') }}</span>
                                        </a>
                                        <a class="octf-btn  btn-host-head " href="{{ route('home.contactUs') }}">
                                            <span>Contact Us</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header_mobile">
        <div class="container">
            <div class="mlogo_wrapper clearfix">
                <div >

                    <div id="site-logo" class="site-logo py-0">
                        <a href="{{ url('/') }}" class="logo-text-wrapper">
                            <div class="d-flex align-items-center">
                                <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}"
                                onerror="this.onerror=null;this.src='{{ asset('backend/assets/img/placeholder-thumb.png') }}';"
                                    alt="{{getSetting('system_title')}}">
                                <div class="logo-text text-center">
                                    <p class="mb-0">SWASTIK ENGINEERS</p>
                                    <span>An ISO 9001: 2008 Certified Organization</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div id="mmenu_toggle">
                    <button></button>
                </div>
            </div>
            <div class="mmenu_wrapper">
                <div class="mobile_nav collapse">
                    <ul id="menu-main-menu" class="mobile_mainmenu">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a href="">About Us</a>
                        </li>
                        <li class="menu-item-has-children"><a href="#">Products</a>
                            <ul class="sub-menu">
                                @if (!empty($category_data))
                                    @foreach ($category_data as $key => $data)
                                        <li class="menu-item-has-children"><a
                                                href="{{ route('category.show', $data->slug) }}">
                                                {{ $data->name }}
                                            </a>
                                            <ul class="sub-menu">
                                                @if (!empty($data->sub_category))
                                                    @foreach ($data->sub_category as $key => $sub_cat)
                                                        <li><a href="{{ route('category.show', $sub_cat->slug) }}">
                                                                {{ Str::limit($sub_cat->name, 20) }}</a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </li>


                        <li class="menu-item-has-children"><a href="#">Brands</a>
                            <ul class="sub-menu">
                                @if (!empty($brand_category_data))
                                    @foreach ($brand_category_data as $key => $catData)
                                        @if (!empty($catData))
                                            @foreach ($catData->cat as $key => $data)
                                                <li class="menu-item-has-children"><a
                                                        href="{{ route('category.show', $data->slug) }}">
                                                        {{ $data->name }}
                                                    </a>
                                                    <ul class="sub-menu">
                                                        @if (!empty($data->brands))
                                                            @foreach ($data->brands as $key => $brand_data)
                                                                <li><a
                                                                        href="{{ route('category.show', $brand_data->slug) }}">
                                                                        {{ Str::limit($brand_data->name, 20) }}</a></li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                            </ul>
                        </li>

                        <li>
                            <a href="{{route('career.index')}}">Career</a>
                        </li>
                        <li>
                            <a href="{{ route('home.contactUs') }}">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
