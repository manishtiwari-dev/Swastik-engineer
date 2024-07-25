<x-backend.guest-layout>
    <section class="login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-12 bg-white d-flex p-4 tt-login-col shadow">
                    <form method="POST" action="{{ route('admin.password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <input type="hidden" name="email" value="{{ $request->email }}" >

                        <div class="mb-5 text-center">
                            <a href="{{url('/')}}">
                                <img src="{{ uploadedAsset(getSetting('navbar_logo')) }}" alt="{{getSetting('system_title')}}">
                            </a>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <div class="input-field">
                                    <span class="reset-email">
                                        <label class="fw-bold text-dark fs-sm mb-1" for="password">Password</label>
                                        <input type="password" id="password" name="password"  placeholder="Enter your password" class="theme-input mb-1 "  required="">
                                    </span>
                                    
                                    @error('password')
                                       <small class="text-danger"> {{$message}} </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="input-field">
                                    <span class="reset-email ">
                                        <label class="fw-bold text-dark fs-sm mb-1" for="password_confirmation">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"  placeholder="Enter your confirm password" class="theme-input mb-1 "  required="">
                                    </span>
                                    @error('password_confirmation')
                                       <small class="text-danger"> {{$message}} </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary mt-4">
                                    Reset Password
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-backend.guest-layout>