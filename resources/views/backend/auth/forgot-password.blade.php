<x-backend.guest-layout>

    <section class="login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-12 bg-white d-flex p-4 tt-login-col shadow">
                    <form method="POST" action="{{ route('admin.password.email') }}">
                        @csrf
                        <div class="mb-5 text-center">
                            <a href="{{url('/')}}">
                                <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="{{getSetting('system_title')}}">
                            </a>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="input-field">
                                    <span class="reset-email ">
                                        <label class="fw-bold text-dark fs-sm mb-1">Email</label>
                                        <input type="email" id="email" name="email" value="{{old('email')}}"  placeholder="Enter your email" class="theme-input mb-1 " value="" required="">
                                    </span>
                                    @error('email')
                                       <small class="text-danger"> {{$message}} </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="d-flex align-items-center justify-content-between mt-4">
                                    <div class="checkbox d-inline-flex align-items-center gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            Reset Password
                                        </button>
                                    </div>
                                    <a href="{{route('admin.login')}}" class="fs-sm">Back To Login</a>
                                </div>
                            </div>
                            
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-backend.guest-layout>
