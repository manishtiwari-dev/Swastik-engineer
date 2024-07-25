<ul class="tt-side-nav">

    <!-- dashboard -->
    <li class="side-nav-item nav-item">
        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
            <span class="tt-nav-link-icon"><i data-feather="pie-chart"></i></span>
            <span class="tt-nav-link-text">{{ localize('Dashboard')}}</span>
        </a>
    </li>

    <!-- products -->
    @php
    $productsActiveRoutes = ['admin.addon-products.index', 'admin.addon-products.create', 'admin.addon-products.edit',
        'admin.variations.index', 'admin.variations.edit', 'admin.variationValues.index', 'admin.variationValues.edit',
        'admin.taxes.index', 'admin.taxes.edit', 'admin.categories.index', 'admin.categories.create',
        'admin.categories.edit', 'admin.products.index', 'admin.products.create', 'admin.products.edit'];
    @endphp

    @canany(['products', 'categories', 'variations', 'taxes'])
    <li class="side-nav-item nav-item {{ areActiveRoutes($productsActiveRoutes, 'tt-menu-item-active') }}">
        <a data-bs-toggle="collapse" href="#sidebarProducts"
            aria-expanded="{{ areActiveRoutes($productsActiveRoutes, 'true') }}" aria-controls="sidebarProducts"
            class="side-nav-link tt-menu-toggle">
            <span class="tt-nav-link-icon"><i data-feather="shopping-bag"></i></span>
            <span class="tt-nav-link-text">{{ localize('Products') }}</span>
        </a>

        <div class="collapse {{ areActiveRoutes($productsActiveRoutes, 'show') }}" id="sidebarProducts">
            <ul class="side-nav-second-level">

                @can('products')
                <li
                    class="{{ areActiveRoutes(['admin.products.index', 'admin.products.create', 'admin.products.edit'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.products.index') }}"
                        class="{{ areActiveRoutes(['admin.products.index', 'admin.products.create', 'admin.products.edit']) }}">{{
                        localize('All Products') }}</a>
                </li>
                @endcan

                <!--AddOn Product-->
                {{-- @can('products')
                <li
                    class="{{ areActiveRoutes(['admin.addon-products.index', 'admin.addon-products.create', 'admin.addon-products.edit'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.addon-products.index') }}"
                        class="{{ areActiveRoutes(['admin.addon-products.index', 'admin.addon-products.create', 'admin.addon-products.edit']) }}">
                        {{localize('AddOn-Products') }}
                    </a>
                </li>
                @endcan --}}

                @can('categories')
                <li
                    class="{{ areActiveRoutes(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ areActiveRoutes(['admin.categories.index', 'admin.categories.create', 'admin.categories.edit']) }}">{{
                        localize('All Categories') }}</a>
                </li>
                @endcan

                {{-- @can('variations')
                <li class="{{ areActiveRoutes(
                                ['admin.variations.index', 'admin.variations.edit', 'admin.variationValues.index', 'admin.variationValues.edit'],
                                'tt-menu-item-active',
                            ) }}">
                    <a href="{{ route('admin.variations.index') }}" class="{{ areActiveRoutes([
                                    'admin.variations.index',
                                    'admin.variations.edit',
                                    'admin.variationValues.index',
                                    'admin.variationValues.edit',
                                ]) }}">{{ localize('All Variations') }}</a>
                </li>
                @endcan --}}

                @can('brands')
                <li class="{{ areActiveRoutes(['admin.brands.index', 'admin.brands.edit'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.brands.index') }}"
                        class="{{ areActiveRoutes(['admin.brands.index', 'admin.brands.edit']) }}">{{ localize('All Brands') }}</a>
                </li>
                @endcan

                {{-- @can('taxes')
                <li class="{{ areActiveRoutes(['admin.taxes.index', 'admin.taxes.edit'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.taxes.index') }}" class="{{ areActiveRoutes(['admin.taxes.index']) }}">{{
                        localize('All Taxes') }}</a>
                </li>
                @endcan --}}
            </ul>
        </div>
    </li>
    @endcan



    <!-- orders -->
    {{-- @can('orders')
    <li
        class="side-nav-item nav-item {{ areActiveRoutes(['admin.orders.index', 'admin.orders.show'], 'tt-menu-item-active') }}">
        <a href="{{ route('admin.orders.index') }}"
            class="side-nav-link {{ areActiveRoutes(['admin.orders.index', 'admin.orders.show']) }}">
            <span class="tt-nav-link-icon"><i data-feather="shopping-cart"></i></span>
            <span class="tt-nav-link-text">
                <span>{{ localize('Orders') }}</span>

                @php
                $newOrdersCount = \App\Models\Order::isPlaced()->count();
                @endphp

                @if ($newOrdersCount > 0)
                <small class="badge bg-danger">{{ localize('New') }}</small>
                @endif
            </span>
        </a>
    </li>
    @endcan --}}


    <!-- Priduct Enquiries -->

    @can('product_enquiries')

    <li class="side-nav-item nav-item {{ areActiveRoutes(['admin.enquiries.index'], 'tt-menu-item-active') }}">
        <a href="{{ route('admin.enquiries.index') }}"
            class="side-nav-link {{ areActiveRoutes(['admin.enquiries.index']) }}">
            <span class="tt-nav-link-icon"><i data-feather="shopping-cart"></i></span>
            <span class="tt-nav-link-text">
                <span>{{ localize('Enquiries') }}</span>

                @php
                    $newMsgCount = \App\Models\ProductEnquiry::where('is_seen', 0)->count();
                @endphp

                @if ($newMsgCount > 0)
                    <small class="badge bg-danger">{{ localize('New') }}</small>
                @endif
            </span>
        </a>
    </li>
    @endcan


    <!-- Support -->
    <li class="side-nav-title side-nav-item nav-item">
        <span class="tt-nav-title-text">{{ localize('Support') }}</span>
    </li>

    @can('contact_us_messages')
        <li class="side-nav-item nav-item {{ areActiveRoutes(['admin.queries.index'], 'tt-menu-item-active') }}">
            <a href="{{ route('admin.queries.index') }}"
                class="side-nav-link {{ areActiveRoutes(['admin.queries.index']) }}">
                <span class="tt-nav-link-icon"><i data-feather="hash"></i></span>
                <span class="tt-nav-link-text">
                    <span>{{ localize('Contacts') }}</span>

                    @php
                        $newMsgCount = \App\Models\ContactUsMessage::where('is_seen', 0)->count();
                    @endphp

                    @if ($newMsgCount > 0)
                        <small class="badge bg-danger">{{ localize('New') }}</small>
                    @endif
                </span>
            </a>
        </li>
    @endcan

     <!-- Support -->
     <li class="side-nav-title side-nav-item nav-item">
        <span class="tt-nav-title-text">{{ localize('Human resources') }}</span>
    </li>

    @can('human_resources')
        <li class="side-nav-item nav-item {{ areActiveRoutes(['admin.recruitment.index'], 'tt-menu-item-active') }}">
            <a href="{{ route('admin.recruitment.index') }}"
                class="side-nav-link {{ areActiveRoutes(['admin.recruitment.index']) }}">
                <span class="tt-nav-link-icon"><i data-feather="hash"></i></span>
                <span class="tt-nav-link-text">
                    <span>{{ localize('Recruitment') }}</span>

                    @php
                        $newMsgCount = \App\Models\Career::where('is_seen', 0)->count();
                    @endphp

                    @if ($newMsgCount > 0)
                        <small class="badge bg-danger">{{ localize('New') }}</small>
                    @endif
                </span>
            </a>
        </li>
    @endcan


    {{-- <!-- Users -->
    <li class="side-nav-title side-nav-item nav-item">
        <span class="tt-nav-title-text">{{ localize('Users') }}</span>
    </li>

    <!-- customers -->
    @can('customers')
    <li class="side-nav-item nav-item">
        <a href="{{ route('admin.customers.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon"> <i data-feather="users"></i></span>
            <span class="tt-nav-link-text">{{ localize('Customers') }}</span>
        </a>
    </li>
    @endcan --}}


    <!-- Contents -->
    <li class="side-nav-title side-nav-item nav-item">
        <span class="tt-nav-title-text">{{ localize('Contents') }}</span>
    </li>

    <!-- tags -->
    @php
    $tagsActiveRoutes = ['admin.tags.index', 'admin.tags.edit'];
    @endphp
    @can('tags')
    <li class="side-nav-item nav-item {{ areActiveRoutes($tagsActiveRoutes, 'tt-menu-item-active') }}">
        <a href="{{ route('admin.tags.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon"> <i data-feather="tag"></i></span>
            <span class="tt-nav-link-text">{{ localize('Tags') }}</span>
        </a>
    </li>
    @endcan

    <!-- pages -->
    @php
    $pagesActiveRoutes = ['admin.pages.index', 'admin.pages.create', 'admin.pages.edit'];
    @endphp
    @can('pages')
    <li class="side-nav-item nav-item {{ areActiveRoutes($pagesActiveRoutes, 'tt-menu-item-active') }}">
        <a href="{{ route('admin.pages.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon"> <i data-feather="copy"></i></span>
            <span class="tt-nav-link-text">{{ localize('Pages') }}</span>
        </a>
    </li>
    @endcan


    <!-- Blog Systems -->
    @php
        $blogActiveRoutes = ['admin.blogs.index', 'admin.blogs.create', 'admin.blogs.edit', 'admin.blogCategories.index', 'admin.blogCategories.edit'];
    @endphp
    @canany(['blogs', 'blog_categories'])
        <li class="side-nav-item nav-item {{ areActiveRoutes($blogActiveRoutes, 'tt-menu-item-active') }}">
            <a data-bs-toggle="collapse" href="#blogSystem"
                aria-expanded="{{ areActiveRoutes($blogActiveRoutes, 'true') }}" aria-controls="blogSystem"
                class="side-nav-link tt-menu-toggle">
                <span class="tt-nav-link-icon"><i data-feather="file-text"></i></span>
                <span class="tt-nav-link-text">{{ localize('Blogs') }}</span>
            </a>
            <div class="collapse {{ areActiveRoutes($blogActiveRoutes, 'show') }}" id="blogSystem">
                <ul class="side-nav-second-level">
                    @can('blogs')
                        <li
                            class="{{ areActiveRoutes(['admin.blogs.index', 'admin.blogs.create', 'admin.blogs.edit'], 'tt-menu-item-active') }}">
                            <a href="{{ route('admin.blogs.index') }}"
                                class="{{ areActiveRoutes(['admin.blogs.index', 'admin.blogs.create', 'admin.blogs.edit']) }}">{{ localize('All Blogs') }}</a>
                        </li>
                    @endcan

                    @can('blog_categories')
                        <li
                            class="{{ areActiveRoutes(['admin.blogCategories.index', 'admin.blogCategories.edit'], 'tt-menu-item-active') }}">
                            <a href="{{ route('admin.blogCategories.index') }}">{{ localize('Categories') }}</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
    @endcan


    <!-- media manager -->
    @can('media_manager')
    <li class="side-nav-item">
        <a href="{{ route('admin.mediaManager.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon"> <i data-feather="folder"></i></span>
            <span class="tt-nav-link-text">{{ localize('Media Manager') }}</span>
        </a>
    </li>
    @endcan



    <!-- Settings -->
    <li class="side-nav-title side-nav-item nav-item">
        <span class="tt-nav-title-text">{{ localize('Settings') }}</span>
    </li>

    <!-- Appearance -->
    @php
    $appearanceActiveRoutes = ['admin.appearance.header', 'admin.appearance.homepage.hero',
    'admin.appearance.homepage.editHero', 'admin.appearance.homepage.topCategories',
    'admin.appearance.homepage.topTrendingProducts', 'admin.appearance.homepage.featuredProducts',
    'admin.appearance.homepage.bestDeals','admin.appearance.homepage.bestSelling',
    'admin.appearance.products.details.editWidget'];

    $homepageActiveRoutes = ['admin.appearance.homepage.hero', 'admin.appearance.homepage.editHero',
    'admin.appearance.homepage.topCategories', 'admin.appearance.homepage.topTrendingProducts',
    'admin.appearance.homepage.featuredProducts', 'admin.appearance.homepage.bestDeals','admin.appearance.homepage.bestSelling'];

    @endphp

    @canany(['homepage','header', 'footer'])
    <li class="side-nav-item nav-item {{ areActiveRoutes($appearanceActiveRoutes, 'tt-menu-item-active') }}">
        <a data-bs-toggle="collapse" href="#Appearance"
            aria-expanded="{{ areActiveRoutes($appearanceActiveRoutes, 'true') }}" aria-controls="Appearance"
            class="side-nav-link tt-menu-toggle">
            <span class="tt-nav-link-icon"><i data-feather="layout"></i></span>
            <span class="tt-nav-link-text">{{ localize('Appearance') }}</span>
        </a>
        <div class="collapse {{ areActiveRoutes($appearanceActiveRoutes, 'show') }}" id="Appearance">
            <ul class="side-nav-second-level">

                @can('homepage')
                <li class="{{ areActiveRoutes($homepageActiveRoutes, 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.appearance.homepage.hero') }}"
                        class="{{ areActiveRoutes($homepageActiveRoutes) }}">{{ localize('Homepage') }}</a>
                </li>
                @endcan

                @can('header')
                <li class="{{ areActiveRoutes(['admin.appearance.header'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.appearance.header') }}"
                        class="{{ areActiveRoutes(['admin.appearance.header']) }}">{{ localize('Header') }}</a>
                </li>
                @endcan

                @can('footer')
                <li class="{{ areActiveRoutes(['admin.appearance.footer'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.appearance.footer') }}"
                        class="{{ areActiveRoutes(['admin.appearance.footer']) }}">{{ localize('Footer') }}</a>
                </li>
                @endcan
            </ul>
        </div>
    </li>
    @endcanany


    <!-- Roles & Permission -->
    @php
    $rolesActiveRoutes = ['admin.roles.index', 'admin.roles.create', 'admin.roles.edit'];
    @endphp
    @can('roles_and_permissions')
    <li class="side-nav-item nav-item {{ areActiveRoutes($rolesActiveRoutes, 'tt-menu-item-active') }}">
        <a href="{{ route('admin.roles.index') }}" class="side-nav-link">
            <span class="tt-nav-link-icon"><i data-feather="unlock"></i></span>
            <span class="tt-nav-link-text">{{ localize('Roles & Permissions') }}</span>
        </a>
    </li>
    @endcan


    <!-- system settings -->
    @php
    $settingsActiveRoutes = ['admin.generalSettings', 'admin.orderSettings', 'admin.smtpSettings.index'];
    @endphp

    @canany(['smtp_settings','sms_settings' ,'general_settings', 'currency_settings', 'language_settings'])
    <li class="side-nav-item nav-item {{ areActiveRoutes($settingsActiveRoutes, 'tt-menu-item-active') }}">
        <a data-bs-toggle="collapse" href="#systemSetting"
            aria-expanded="{{ areActiveRoutes($settingsActiveRoutes, 'true') }}" aria-controls="systemSetting"
            class="side-nav-link tt-menu-toggle">
            <span class="tt-nav-link-icon"><i data-feather="settings"></i></span>
            <span class="tt-nav-link-text">{{ localize('System Settings') }}</span>
        </a>
        <div class="collapse {{ areActiveRoutes($settingsActiveRoutes, 'show') }}" id="systemSetting">
            <ul class="side-nav-second-level">

                @can('sms_settings')
                <li class="{{ areActiveRoutes(['admin.settings.smsSettings'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.settings.smsSettings') }}"
                        class="{{ areActiveRoutes(['admin.settings.smsSettings']) }}">{{ localize('SMS Settings') }}</a>
                </li>
                @endcan

                @can('order_settings')
                <li
                    class="{{ areActiveRoutes(['admin.orderSettings', 'admin.timeslot.edit'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.orderSettings') }}"
                        class="{{ areActiveRoutes(['admin.generalSettings']) }}">{{ localize('Enquiry Settings') }}</a>
                </li>
                @endcan

                <li class="d-none {{ areActiveRoutes(['admin.smtpSettings.index'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.smtpSettings.index') }}"
                        class="{{ areActiveRoutes(['admin.smtpSettings.index']) }}">{{ localize('Admin Store') }}</a>
                </li>

                @can('smtp_settings')
                <li class="{{ areActiveRoutes(['admin.smtpSettings.index'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.smtpSettings.index') }}"
                        class="{{ areActiveRoutes(['admin.smtpSettings.index']) }}">{{ localize('SMTP Settings') }}</a>
                </li>
                @endcan

                @can('general_settings')
                <li class="{{ areActiveRoutes(['admin.generalSettings'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.generalSettings') }}"
                        class="{{ areActiveRoutes(['admin.generalSettings']) }}">{{ localize('General Settings') }}</a>
                </li>
                @endcan

                {{-- @can('payment_settings')
                <li class="{{ areActiveRoutes(['admin.settings.paymentMethods'], 'tt-menu-item-active') }}">
                    <a href="{{ route('admin.settings.paymentMethods') }}"
                        class="{{ areActiveRoutes(['admin.settings.paymentMethods']) }}">{{ localize('Payment Methods')
                        }}</a>
                </li>
                @endcan --}}
            </ul>
        </div>
    </li>
    @endcan
</ul>
