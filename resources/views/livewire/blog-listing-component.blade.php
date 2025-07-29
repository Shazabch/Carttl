<div>
    <section class="section-blog ox-hidden">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center">
                    <h3 class="sec-h-top">Latest Blog</h3>
                    <h2 class="h-35 fw-700">Insights That Fuel Every Car Deal</h2>
                </div>
            </div>
            <div class="row g-4 align-items-stretch">
                <!-- Featured Post -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="featured-post position-relative">
                        <div class="feature-post-img">
                            <img src="{{ asset('storage/' . $featuredBlog->image) }}" class="img-fluid w-100 h-100 object-fit-cover rounded-4" alt="Featured Post">
                        </div>
                        <div class="featured-content text-white">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>{{ $this->formateDate($featuredBlog->created_at)}}</span>
                            </div>
                            <h4 class="p-22 fw-600 my-3">{{$featuredBlog->title ?? ''}}</h4>
                            <a href="#" class="read-more-icon d-inline-block">
                                <span class="icon-circle"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Side Posts -->
                <div class="col-lg-6 d-flex flex-column gap-4">
                    <!-- Single Side Post -->
                     @foreach($blogs as $item)
                    <div class="side-post row align-items-center" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                        <div class="col-sm-4 mb-3 mb-lg-0">
                            <div class="side-post-img">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>{{ $this->formateDate($item->created_at)}}</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">{{$item->title ?? ''}}
                            </h6>
                            <a href="#"
                                class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>




            <!-- ///// DATA FOR FUTURE USE  -->

            {{--
            <div class="row g-4 align-items-stretch">
                <!-- Featured Post -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                    <div class="featured-post position-relative">
                        <div class="feature-post-img">
                            <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-1.jpg" class="img-fluid w-100 h-100 object-fit-cover rounded-4" alt="Featured Post">
                        </div>
                        <div class="featured-content text-white">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h4 class="p-22 fw-600 my-3">Top Tips For Booking Your Car Rental: What You Need To Know</h4>
                            <a href="#" class="read-more-icon d-inline-block">
                                <span class="icon-circle"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Side Posts -->
                <div class="col-lg-6 d-flex flex-column gap-4">
                    <!-- Single Side Post -->
                    <div class="side-post row align-items-center" data-aos="fade-left" data-aos-delay="0" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                        <div class="col-sm-4 mb-3 mb-lg-0">
                            <div class="side-post-img">
                                <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-2.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">Exploring Your Rental Car Options: Sedan, SUV, Or Convertible?
                            </h6>
                            <a href="#"
                                class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="side-post row align-items-center" data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                        <div class="col-sm-4 mb-3 mb-lg-0">
                            <div class="side-post-img">
                                <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-2.jpg"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">Exploring Your Rental Car Options: Sedan, SUV, Or Convertible?
                            </h6>
                            <a href="#" class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="side-post row align-items-center" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                        <div class="col-sm-4 mb-3 mb-lg-0">
                            <div class="side-post-img">
                                <img src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/post-2.jpg"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="d-flex align-items-center mb-1 text-muted small">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>August 5, 2024</span>
                            </div>
                            <h6 class="my-3 p-20 fw-600">Exploring Your Rental Car Options: Sedan, SUV, Or Convertible?
                            </h6>
                            <a href="#"
                                class="text-accent fw-semibold text-decoration-none d-flex align-items-center gap-2">
                                Read Story
                                <div class="icon-circle-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
    </section>
</div>