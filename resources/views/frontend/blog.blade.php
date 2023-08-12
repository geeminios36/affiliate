<div class="our-blog-area section-space--ptb_90">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="section-title mb-20">
                    <h2 class="section-title">Explore our blog</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="more-button text-end">
                    <a href="{{ route('blog') }}" class="text-btn-normal font-weight--reguler font-lg-p"
                       tabindex="0">View All <i class="icon-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($blogs as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <!-- Single Blog Item Start -->
                    <div class="single-blog-item mt-30">
                        <div class="blog-thumbnail-box">
                            <a href="#" class="thumbnail">
                                <img
                                    src="{{ uploaded_asset($blog->banner) ?? 'assets/frontend/images/blog/8-570x370.webp' }}"
                                    width="366" height="238"
                                    class="img-fluid" alt="{{ $blog->title }}">
                            </a>
                            <a href="{{ url("blog").'/'. $blog->slug }}"
                               class="btn-blog">{{ translate('View More') }}</a>
                        </div>
                        <div class="blog-contents">
                            <h6 class="blog-title"><a href="#">{{ $blog->title }}</a></h6>
                            <div class="meta-tag-box">
                                <div class="meta date"><span>{{ date('H:i d/m/Y', strtotime($blog->created_at)) }}</span></div>
{{--                                <div class="meta author"><span><a href="#">Hastheme</a></span></div>--}}
                                @if($blog->category != null)
                                    <div class="meta cat">
                                        <span>in <a href="#">{{ $blog->category->category_name }}</a></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div><!-- Single Blog Item End -->
                </div>
            @endforeach
        </div>
    </div>
</div>
