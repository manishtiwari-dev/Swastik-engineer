<x-backend.guest-layout>
  
    @section('title'){{  ('Login') }}@endsection

    <section class="login-section py-5">
        <div class="container">
   
            <div class="row justify-content-center">
                <div class="col-lg-5 col-12 bg-white d-flex p-0 tt-login-col shadow">
                    <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100" action="{{ route('admin.login') }}" method="POST" id="login-form">
                        @csrf
                        <div class="mb-5 text-center">
                            <a href="{{url('/')}}">
                                <img src="{{ uploadedAsset(getSetting('admin_panel_logo')) }}" alt="{{getSetting('system_title')}}">
                            </a>
                        </div>
                        

                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="input-field">
                                    <span class="login-email ">
                                        <label class="fw-bold text-dark fs-sm mb-1">Email</label>
                                        <input type="email" id="email" name="email" placeholder="Enter your email" class="theme-input mb-1" value="" required="">
                                    </span>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-field check-password">
                                    <label class="fw-bold text-dark fs-sm mb-1">Password</label>
                                    <div class="check-password">
                                        <input type="password" name="password" id="password" placeholder="Password" class="theme-input" required="">
                                        <span class="eye eye-icon"><i class="fa-solid fa-eye"></i></span>
                                    </div>
                                    @error('password')
                                     <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <div class="checkbox d-inline-flex align-items-center gap-2">
                                <div class="theme-checkbox flex-shrink-0">
                                    <input type="checkbox" id="save-password" name="remember">
                                    <span class="checkbox-field"><i class="fa-solid fa-check"></i></span>
                                </div>
                                <label for="save-password" class="fs-sm"> Remember me</label>
                            </div>
                            <a href="{{route('admin.password.request')}}" class="fs-sm">Forgot Password</a>
                        </div>

                        
                        <div class="row g-4 mt-3">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary w-100 sign-in-btn" onclick="handleSubmit()">Sign In</button>
                            </div>

                        </div>

                        <div class="row g-4 mt-3">
                          
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // disable login button
        function handleSubmit() {
            $('#login-form').on('submit', function(e) {
                $('.sign-in-btn').prop('disabled', true);
            });
        }

        $(document).ready(function(){
  
            $('.eye-icon').on('click', function(){
     
                var passInput=$("#password");
                if(passInput.attr('type')==='password')
                {
                    passInput.attr('type','text');
                }else{
                    passInput.attr('type','password');
                }
            })
        })

    </script>
@endpush
</x-backend.guest-layout>

