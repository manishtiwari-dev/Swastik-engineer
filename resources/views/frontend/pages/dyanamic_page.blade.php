<x-frontend.app-layout>
    @section('title')
        {{ localize('Home') }} {{ getSetting('title_separator') }} {{ $page_data->collectLocalization('title') }}
    @endsection
    
    <div class="container">
        <div class="row ">
            <div class="db-page">
            {!! $page_data->content ?? '' !!}
            </div>
        </div>
    </div>

</x-frontend.app-layout>