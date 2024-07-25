@if(!empty($certificates) && sizeof($certificates)>0)
<section style=" background-color: #f7eeee42;">
    <div class="space-60 d-none d-md-block"></div>
  
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="ot-heading text-center">
                    <h2 class="sub-title">Certifications</h2>
                    <h3 class="title-12">In Recognition of Our Reliability and Quality - Cerifications</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="space-20 d-none d-md-block"></div>


    <div class="container section-box-i9">
        <div class="box-img-row">
            <div class="row">
                @foreach ($certificates as $certificate)
                <div class="col-xl-6 px-xl-0">
                    <div class="img-box-i9">
                        <div class="img-main">
                            <img src="{{ uploadedAsset($certificate->image) }}" alt="">
                        </div>
                        <div class="desc-box-i9">
                            {{-- <h3>{{$certificate->title ?? ''}}</h3> --}}
                            <p class="">{{$certificate->title ?? ''}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="space-50 d-none d-md-block"></div>

</section>
@endif