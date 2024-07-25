<footer id="site-footer" class="site-footer footer-12">
  <div class="container-fluid">
      <div class="space-20"></div>
      <div class="row">
          <div class="col-md-4 mb-4 mb-md-0 align-self-center">
              <p class="copyright-text-12 mb-0">
                {!! getSetting('copyright_text') !!}
              </p>
          </div>
          @php
          $quick_links = getSetting('quick_links') != null ? json_decode(getSetting('quick_links')) : [];
          $pages = \App\Models\Page::whereIn('id', $quick_links)->get();
          @endphp
          <div class="col-md-6 text-md-right align-self-center">
              <ul class="ft-menu-i12">
                @if(!empty($pages))
                  @foreach ($pages as $item)    
                    <li><a href="{{ route('home.pages.show', $item->slug) }}">{{ $item->collectLocalization('title') }}</a></li>
                  @endforeach
                @endif  
              </ul>
          </div>
          <div class="col-lg-2">
          <span class="fs-14">
            Made With <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"  height="18px"  x="0px" y="0px" viewBox="0 0 122.88 107.41" style="enable-background:new 0 0 122.88 107.41" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;fill:#ff0000ab}</style><g><path class="st0" d="M60.83,17.19C68.84,8.84,74.45,1.62,86.79,0.21c23.17-2.66,44.48,21.06,32.78,44.41 c-3.33,6.65-10.11,14.56-17.61,22.32c-8.23,8.52-17.34,16.87-23.72,23.2l-17.4,17.26L46.46,93.56C29.16,76.9,0.95,55.93,0.02,29.95 C-0.63,11.75,13.73,0.09,30.25,0.3C45.01,0.5,51.22,7.84,60.83,17.19L60.83,17.19L60.83,17.19z"/></g></svg> <a href="https://invoidea.com/"  class="text-dark" target="_blank">Invoidea</a>
        </span>
          </div>
      </div>
      <div class="space-20"></div>
  </div>
</footer><!-- #site-footer -->