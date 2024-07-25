<x-frontend.app-layout>

    @section('title')
        {{ localize('Home') }} {{ getSetting('title_separator') }} {{ localize('Career') }}
    @endsection

    @if(session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }}">
        {{ session('flash_notification.message') }}
    </div>
@endif

    <div class="content contact-us-wrapper">
        <section class="no-padding-bottom ">
            <div class="col-xl-12 text-center">
                <div class="ot-heading ">
                    <h2 class="title-12">Career</h2>
                </div>
                <div class="col-xl-6 offset-xl-3 text-center">
                    <p>Leave your resume if you are interested in a vacancy. We will definitely contact you.</p>
                </div>
            </div>
        </section>
        <section class="no-padding-top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-md-6 mx-auto border p-4">
                        <div>
                            <form action="{{ route('career.store') }}" class="DataForm needs-validation" method="POST"
                                id="careerForm" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <input type="text" name="name" class="form-control"
                                                id="exampleInputName" placeholder="Your Name*" required>
                                                
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        
                                            <div class="invalid-feedback">Please enter  name</div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control"
                                                id="exampleInputphone" aria-describedby="emailHelp"
                                                placeholder="Your Phone No.*" required>
                                                
                                        @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                            <div class="invalid-feedback">Please enter phone number</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                placeholder="Your Email*" required>
                                                @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            <div class="invalid-feedback">Please enter email</div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" id="coverletter" name="cover_letter" placeholder="Cover letter...." required></textarea>
                                            @error('cover_letter')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <div class="invalid-feedback">Please enter cover letter</div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group mt-3">
                                            <label class="mr-4">Upload Your Resume<span
                                                    class="red">*</span></label>
                                            <input type="file" class="form-control" name="attachment">
                                            <div class="invalid-feedback">Please upload resume</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex mt-3 gap-2">
                                    <div class="form-check">
                                        <input type="checkbox" value=""
                                            class="form-check-input d-inline mt-1 confirmation_class"
                                            name="confirmation_check" >

                                        <input type="hidden" name="confirmation" id="confirm">
                                      
                                        <label for="" class="form-check-label">By using this form you agree with
                                            the
                                            storage and handling of your data by this website. </label>
                                        <div class="invalid-feedback">
                                            You must agree before submitting.
                                        </div>
                                    </div>
                                </div>
                                <div class=" contact-btn mt-3">
                                    <button type="submit"
                                        class="octf-btn octf-btn-primary rounded careerFormbtn">Submit
                                        Application</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script>
            $('.confirmation_class').on('click', function() {
                let check = $(this).prop('checked') === true ? 1 : 0;
                console.log(check);
                $("#confirm").val(check);
            });

            $(document).on('submit', '.DataForm', function(event) {
                event.preventDefault();
                // alert('frgdr');
                $('.DataForm').addClass('was-validated');
                if ($('.DataForm')[0].checkValidity() === false) {
                    event.preventDefault();
                } else {
                    $('.DataForm')[0].submit()
                }
            });
        </script>
    @endpush
</x-frontend.app-layout>
