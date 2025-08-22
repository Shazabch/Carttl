<div>
    <section class="blog-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-10">
                    <div class="blog-content-top">
                        <p class="blog-date">
                            {{ $selected_blog && $selected_blog->created_at 
        ? \Carbon\Carbon::parse($selected_blog->created_at)->format('F d Y h:i A') 
        : '' }}
                        </p>
                        <h1 class="blog-title">{{$selected_blog->title}}</h1>
                        <p class="mt-4 mb-5 px-sm-5">

                        </p>
                        <div class="author-wrapper">
                            <img src="{{ asset('images/blog-admin.jpeg') }}" alt="Author Image">
                            <div>
                                <h5>By GoldenX</h5>
                                <p>Admin</p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-content-body">
                        <img src="{{ asset('storage/' . $selected_blog->image) }}" class="blog-thumbnail" alt="">
                        {!!$selected_blog->content!!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-related ox-hidden">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <h2 class="h-35 fw-700">Related Blogs</h2>
                </div>
            </div>
            <div class="row">
                @foreach($related_blogs as $blog)
                <div class="col-lg-4" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="featured-post position-relative">
                        <div class="feature-post-img">
                            <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid w-100 h-100 object-fit-cover rounded-4" alt="Featured Post">
                        </div>
                        <div class="featured-content text-white">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('F d Y ') }}</span>
                            </div>
                            <h4 class="p-22 fw-600 my-3">{{$blog->title}}</h4>
                            <div class="text-end">
                                <a href="{{ route('get-blog',$blog->slug) }}" class="read-more-icon d-inline-block">
                                    <span class="icon-circle"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
</div>