<div>
    <section class="blog-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-10">
                <div class="blog-content-top">
                    <p class="blog-date">{{ \Carbon\Carbon::parse($selected_blog->created_at)->format('F d Y h:i A') }}</p>
                    <h1 class="blog-title">{{$selected_blog->title}}</h1>
                    <p class="mt-4 mb-5 px-sm-5">
                       {{$selected_blog->content}}
                    </p>
                    <div class="author-wrapper">
                        <img src="{{ asset('images/c38ec63b-c441-4574-8b3a-8c69a2aa9595.webp') }}" alt="Author Image">
                        <div>
                            <h5>By Criabel</h5>
                            <p>Founder & CEO of GoldenX</p>
                        </div>
                    </div>
                </div>
                <div class="blog-content-body">
                    <img src="{{ asset('storage/' . $selected_blog->image) }}" class="blog-thumbnail" alt="">
                    <p>
                        The Mitsubishi Attrage is making waves in the world of compact cars by cleverly combining affordability, efficiency, and modern design with strong safety measures. As cities become more crowded and sustainability becomes crucial, this latest version of the Attrage caters to those who value practicality, but won't compromise on contemporary tech.
                    </p>
                    <p>
                        As a non-technical startup founder, you may feel overwhelmed by the technical aspects of your business. However, having a basic understanding of certain technical skills can significantly enhance your ability to lead and make informed decisions. Here are six essential technical skills that every non-technical founder should consider acquiring:
                    </p>
                    <h2>Heading 2</h2>
                    <p>
                        As a non-technical startup founder, you may feel overwhelmed by the technical aspects of your business. However, having a basic understanding of certain technical skills can significantly enhance your ability to lead and make informed decisions. Here are six essential technical skills that every non-technical founder should consider acquiring:
                    </p>
                    <h3>Heading 3</h3>
                    <p>
                        As a non-technical startup founder, you may feel overwhelmed by the technical aspects of your business. However, having a basic understanding of certain technical skills can significantly enhance your ability to lead and make informed decisions. Here are six essential technical skills that every non-technical founder should consider acquiring:
                    </p>
                    <h4>Heading 4</h4>
                    <p>
                        As a non-technical startup founder, you may feel overwhelmed by the technical aspects of your business. However, having a basic understanding of certain technical skills can significantly enhance your ability to lead and make informed decisions. Here are six essential technical skills that every non-technical founder should consider acquiring:
                    </p>
                    <h5>Heading 5</h5>
                    <p>
                        As a non-technical startup founder, you may feel overwhelmed by the technical aspects of your business. However, having a basic understanding of certain technical skills can significantly enhance your ability to lead and make informed decisions. Here are six essential technical skills that every non-technical founder should consider acquiring:
                    </p>
                    <h6>Heading 6</h6>
                    <p>
                        As a non-technical startup founder, you may feel overwhelmed by the technical aspects of your business. However, having a basic understanding of certain technical skills can significantly enhance your ability to lead and make informed decisions. Here are six essential technical skills that every non-technical founder should consider acquiring:
                    </p>
                    <ul>
                        <li><strong>Basic Coding Knowledge:</strong> Understanding the fundamentals of coding can help you communicate effectively with your development team and grasp the technical challenges they face.</li>
                        <li><strong>Data Analysis:</strong> Being able to analyze data can provide insights into customer behavior, market trends, and business performance, enabling you to make data-driven decisions.</li>
                        <li><strong>Project Management Tools:</strong> Familiarity with project management software can help you keep track of tasks, deadlines, and team collaboration.</li>
                        <li><strong>SEO Basics:</strong> Knowing the basics of search engine optimization can help you improve your website's visibility and attract more customers.</li>
                        <li><strong>Cybersecurity Awareness:</strong> Understanding basic cybersecurity principles can help you protect your business from potential threats and data breaches.</li>
                        <li><strong>Cloud Computing:</strong> Familiarity with cloud services can enhance your business's scalability and flexibility, allowing for better resource management.</li>
                    </ul>
                    <p>
                        By investing time in learning these skills, you can empower yourself to lead your startup more effectively and bridge the gap between technical and non-technical aspects of your business.
                    </p>
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
                            <a href="{{ route('get-blog',$blog->id) }}" class="read-more-icon d-inline-block">
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
