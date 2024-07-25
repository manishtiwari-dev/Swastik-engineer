<x-frontend.app-layout>

    @section('title')
        {{ localize('Conatct Us') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
    @endsection

    <!-- contactus-section -->
    <div class="content contact-us-wrapper">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <div class="row align-items-center">
                        <div class="col-lg-4 address-section border-end pe-lg-5 mb-5">
                            <h3 class="mb-4">Head Office</h3>
                            <h6 class="mb-2">India</h6>
                            <p>
                                {{ getSetting('topbar_location') }}
                            </p>
                        </div>
                        <div class="col-lg-7 mb-5 mb-lg-0 ms-auto ">
                            <h2 class="mb-3">Fill the form<br> It's easy.</h2>

                            <form class="DataForm needs-validation" method="post" id="contactForm"
                                action="{{ route('contactUs.store') }}" method="POST"  novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Name*" required>

                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Email*" required>

                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <input type="text" class="form-control" name="phone" id="phone"
                                            placeholder="Phone">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <textarea class="form-control" name="message" id="message" cols="30" rows="7"
                                            placeholder="Write your message*"></textarea>

                                        @error('message')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="octf-btn octf-btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).on('submit', '#contactForm', function(event) {
                event.preventDefault();
                $('#contactForm').addClass('was-validated');
                if ($('#contactForm')[0].checkValidity() === false) {
                    event.preventDefault();
                } else {
                    $('#contactForm')[0].submit()
                }
            });
        </script>
    @endpush
</x-frontend.app-layout>
