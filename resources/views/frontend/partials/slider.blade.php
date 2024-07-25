<!-- ==slider== -->
<div>
  <div class="slider">
      <ul>
        @if(!empty($sliders))
            @foreach ($sliders as $slider)
                <li style="background: url('{{ uploadedAsset($slider->desktop_image) }}')no-repeat; width:100%;background-size: cover;
                        background-position: center">
                    <article class="center-y padding_2x">
                        <h3 class="big title">{{$slider->title ?? ''}}</h3>
                        <p class="text-dark">{{$slider->description ?? ''}}</p>
                        @if(!empty($slider->button_name))
                            <div>
                                <a href="{{$slider->link ?? ''}}" class="octf-btn">{{$slider->button_name ?? ''}}</a>
                            </div>
                        @endif
                    </article>
                </li>
            @endforeach
        
            <aside>
                @foreach ($sliders as $slider)
                <a href="#"></a>
                @endforeach
            </aside>
        @endif
      </ul>
  </div>
</div>