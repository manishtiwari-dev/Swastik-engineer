<x-backend.guest-layout>
<section class="login-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-lg-5 col-12 tt-login-img" data-background="https://lab2.invoidea.in/estore/public/frontend/default/assets/img/banner/login-banner.jpg?v=v2.6.0" style="background-image: url(&quot;https://lab2.invoidea.in/estore/public/frontend/default/assets/img/banner/login-banner.jpg?v=v2.6.0&quot;);"></div>
            <div class="col-lg-5 col-12 bg-white d-flex p-0 tt-login-col shadow">
                <form class="tt-login-form-wrap p-3 p-md-6 p-lg-6 py-7 w-100 " method="POST" action="{{ route('admin.register') }}" id="login-form">
                    @csrf                       
                    <div class="mb-7">
                        <a href="https://lab2.invoidea.in/estore">
                            <img src="https://lab2.invoidea.in/estore/public/uploads/media/6AkCyw6sfJrIG2NR2MuAzGRtkA48Rmgj8ND2Hc1k.png" alt="logo">
                        </a>
                    </div>
                    <h2 class="mb-4 h3">Hey there!
                        <br>Register as a Customer.
                    </h2>

                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="input-field">
                                <label class="fw-bold text-dark fs-sm mb-1">Full name<sup class="text-danger">*</sup>
                                </label>
                                <input type="text" id="name" name="name" placeholder="Enter your name" class="theme-input" value="" required="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-field">
                                <label class="fw-bold text-dark fs-sm mb-1">Email<sup class="text-danger">*</sup></label>
                                <input type="email" id="email" name="email" placeholder="Enter your email" class="theme-input" value="" required="">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="input-field check-password">
                                <label class="fw-bold text-dark fs-sm mb-1">Password<sup class="text-danger">*</sup></label>
                                <div class="check-password">
                                    <input type="password" name="password" placeholder="Password" class="theme-input" required="">
                                    <span class="eye eye-icon"><i class="fa-solid fa-eye"></i></span>
                                    <span class="eye eye-slash"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-field check-password">
                                <label class="fw-bold text-dark fs-sm mb-1">Confirm Password<sup class="text-danger">*</sup></label>
                                <div class="check-password">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="theme-input" required="">
                                    <span class="eye eye-icon"><i class="fa-solid fa-eye"></i></span>
                                    <span class="eye eye-slash"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mt-3">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary w-100 sign-in-btn" onclick="handleSubmit()">Sign Up</button>
                        </div>

                    </div>
                    <p class="mb-0 fs-xs mt-4">Already have an Account? <a href="{{route('admin.login')}}">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    "use strict";

    // disable login button
    function handleSubmit() {
        $('#login-form').on('submit', function(e) {
            $('.sign-in-btn').prop('disabled', true);
        });
    }
</script>
@endpush
</x-backend.guest-layout>