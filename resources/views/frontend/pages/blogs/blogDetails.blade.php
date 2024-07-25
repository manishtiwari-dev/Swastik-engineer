<x-frontend.app-layout>

    @section('title')
    {{ localize('Blog Details') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
    @endsection
   
    <div class="container mt-5">
        <div class="row">

            <h2 style="text-align: center;">{{$blog->title ?? ''}}</h2>
            <p style="text-align: center;"><br></p>
            <p style="text-align: center;"><span
                    style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;">{{$blog->short_description ?? ''}}</span></p>
            <p style="text-align: center;"><img src="{{ uploadedAsset($blog->banner) }}"  alt="{{ $blog->collectLocalization('title') }}" data-filename="event-img.jpg" style="width: 601px;"><span
                    style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;"><br></span>
            </p>
            <div style="text-align: center;">
            {!! $blog->collectLocalization('description') !!}
            </div>
        </div>
    </div>

</x-frontend.app-layout>