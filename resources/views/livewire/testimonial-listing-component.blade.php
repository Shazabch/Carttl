<div>
    <section class="section-testimonail ox-hidden">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6 text-center">
                    <h3 class="sec-h-top">Testimonials</h3>
                    <h2 class="h-35 fw-700">What our customers are saying about us</h2>
                </div>
            </div>
        </div>
        <div class="testimonail_slider slider-testimonal owl-carousel owl-theme">
            @foreach($testimonials as $item)
            <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            {{$item->comment}}
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="{{ asset('storage/' . $item->image_path) }}" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">{{ $item->name}}</strong>
                                <span class="item-wrap-title">{{ $item->rank}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach



            {{--
            <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item" data-aos="fade-left" data-aos-duration="1000" data-aos-easing="ease-out-cubic">
                <div class="item-wrap">
                    <div class="item-wrap-header">
                        <ul class="item-wrap-stars">
                            <li>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="item-wrap-content">
                        <p>
                            Renting a car from nova ride was a great decision. Not only did I get a reliable and comfortable
                            vehicle, but the prices were also very competitive.
                        </p>
                    </div>
                    <div class="item-wrap-bio">
                        <div class="item-wrap-details">
                            <div class="item-avatar">
                                <img loading="lazy" decoding="async" width="60" height="60" src="https://demo.awaikenthemes.com/novaride/wp-content/uploads/2024/08/author-1.jpg" class="attachment-full size-full" alt="">
                            </div>
                            <div class="item-wrap-info">
                                <strong class="item-wrap-name">Floyd Miles</strong>
                                <span class="item-wrap-title">Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            --}}
        </div>
    </section>
</div>