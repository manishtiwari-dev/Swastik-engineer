<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="description" content="{{ getSetting('global_meta_description') }}">
  <meta name="keywords" content="{{ getSetting('global_meta_keywords') }}">

   <!--favicon icon-->
   <link rel="icon" href="{{ uploadedAsset(getSetting('favicon')) }}" type="image/png" sizes="16x16">

   <!--title-->
   <title>@yield('title')</title>
   
    @yield('meta')
   <!--Css Block Start-->
    @include('frontend.inc.style')
   <!--Css Block End-->

</head>

<body>
    <div id="page" class="site">
        <!--Header Section Start-->
        {{-- @include('frontend.inc.header') --}}
        <x-frontend.top-nav-bar/>

        <!--Header Section End-->
       
        <!-- Page Content -->
        {{ $slot }}
        
        <!--Footer Section Start-->
        @include('frontend.inc.footer')
        <!--Footer Section End-->

    </div>

    <a id="back-to-top" href="#" class="show color-12"><i class="flaticon-up-arrow"></i></a>

   <!--Script Section Start-->
   @include('frontend.inc.script')
   <!--Script Section End-->
   @stack('scripts')

</body>

</html>