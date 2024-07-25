    <!-- jQuery -->
    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/header-mobile.js') }}"></script>
    <script src="{{ asset('frontend/common/js/toastr.min.js') }}"></script>

    <script>
        // ajax toast 
        function notifyMe(level, message) {
            if (level == 'danger') {
                level = 'error';
            }
            toastr.options = {
                "timeOut": "50000",
                "closeButton": true,
                "positionClass": "toast-top-center",
            };
            toastr[level](message);
        }
        @foreach (session('flash_notification', collect())->toArray() as $message)

            notifyMe("{{ $message['level'] }}", "{{ $message['message'] }}");
        @endforeach


        @if (!empty($errors->all()))
            @foreach ($errors->all() as $error)
                notifyMe("error", '{{ $error }}')
            @endforeach
        @endif
    </script>
