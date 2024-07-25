<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <!--required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--favicon icon-->
   <link rel="icon" href="{{ uploadedAsset(getSetting('favicon')) }}" type="image/png" sizes="16x16">

    <!--title-->
    <title>
        @yield('title')
    </title>

    <!--build:css-->
    @include('backend.inc.styles')
    <!-- end build -->
</head>

<body>
    <!--preloader start-->
    <div id="preloader" class="bg-light-subtle">
        <div class="preloader-wrap">
            {{-- <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" class="img-fluid"> --}}
            <div class="loading-bar"></div>
        </div>
    </div>
    <!--preloader end-->

    <!--sidebar section start-->
        @include('backend.inc.leftSidebar')
    <!--sidebar section end-->

    <!--main content wrapper start-->
    <main class="tt-main-wrapper bg-secondary-subtle" id="content">
        <!--header section start-->
        @include('backend.inc.navbar')
        <!--header section end-->

        <!-- Start Content-->
        {{$slot}}
        <!-- container -->

        <!--footer section start-->
       
        @include('backend.inc.footer')
        
        <!--footer section end-->

        <!-- media-manager -->
        @include('backend.inc.media-manager.media-manager')

    </main>
    <!--main content wrapper end-->

    <!-- delete modal -->
    @include('backend.inc.deleteModal')

    <!--build:js-->
    @include('backend.inc.scripts')
    <!--endbuild-->

    <!-- scripts from different pages -->
    @stack('scripts')

</body>

</html>
