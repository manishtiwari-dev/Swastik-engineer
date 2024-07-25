@if(!empty($blogs))
    @foreach ($blogs as $blog)
        <div class="col-lg-4 col-md-6 col-12">
            <article class="post-box blog-item">
                <div class="post-inner">
                    <div class="entry-media">
                        <div class="post-cat">
                            <span class="posted-in">
                                <a href="{{ route('home.blogs.show', $blog->slug) }}" rel="category tag">{{ optional($blog->blog_category)->name }}</a>
                            </span>
                        </div>
                        <div class="news-event-img-wrapper"><a href="{{ route('home.blogs.show', $blog->slug) }}"><img src="{{ asset('frontend/assets/images/event-img.jpg')}}" alt="{{ $blog->collectLocalization('title') }}"></a></div>
                    </div>
                    <div class="inner-post">
                        <div class="entry-header">
                            <div class="entry-meta">
                                <span class="posted-on">- {{ date('F  d, Y', strtotime($blog->created_at)) }}</span>
                            </div><!-- .entry-meta -->

                            <h3 class="entry-title">
                                <a href="{{ route('home.blogs.show', $blog->slug) }}">{{ $blog->collectLocalization('title') }}</a>
                            </h3>
                        </div><!-- .entry-header -->
                    </div>
                </div>
            </article>
        </div>
    @endforeach
@endif