  {{-- <footer class="text-white pt-5 pb-3">
      <div class="container">
          <div class="row g-4">
              <div class="col-md-3 footer-section">
                  <h3><i class="fas fa-car me-2"></i>About GoldenX</h3>
                  <p>GoldenX is the premier destination for buying and selling premium, luxury, and classic vehicles
                      through a transparent auction process.</p>
                  <div>
                      <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                      <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                      <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                      <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                  </div>
              </div>
              <div class="col-md-3 footer-section">
                  <h3><i class="fas fa-link me-2"></i>Quick Links</h3>
                  <ul class="list-unstyled">
                      <li><a href="{{ route('home') }}"><i class="fas fa-home me-2"></i>Home</a></li>
                      <li><a href="#"><i class="fas fa-star me-2"></i>Featured Auctions</a></li>
                      <li><a href="#"><i class="fas fa-info-circle me-2"></i>How It Works</a></li>
                      <li><a href="#"><i class="fas fa-quote-left me-2"></i>Testimonials</a></li>
                      <li><a href="#"><i class="fas fa-plus-circle me-2"></i>Sell Your Car</a></li>
                  </ul>
              </div>
              <div class="col-md-3 footer-section">
                  <h3><i class="fas fa-headset me-2"></i>Support</h3>
                  <ul class="list-unstyled">
                      <li><a href="#"><i class="fas fa-question-circle me-2"></i>FAQ</a></li>
                      <li><a href="{{ route('contact-us') }}"><i class="fas fa-envelope me-2"></i>Contact Us</a></li>
                      <li><a href="#"><i class="fas fa-file-contract me-2"></i>Terms of Service</a></li>
                      <li><a href="#"><i class="fas fa-shield-alt me-2"></i>Privacy Policy</a></li>
                  </ul>
              </div>
              <div class="col-md-3 footer-section">
                  <h3><i class="fas fa-map-marker-alt me-2"></i>Contact Us</h3>
                  <p><i class="fas fa-building me-2 text-warning"></i>1234 Luxury Lane<br>Beverly Hills, CA
                      90210<br>United States</p>
                  <p><i class="fas fa-envelope me-2 text-warning"></i>Email: info@GoldenX.com<br>
                      <i class="fas fa-phone me-2 text-warning"></i>Phone: (800) 123-4567
                  </p>
              </div>
          </div>
          <div class="copyright">
              <p class="mb-0"><i class="fas fa-copyright me-2"></i>{{ now()->year }} GoldenX. All rights reserved
              </p>
          </div>
      </div>
  </footer> --}}
<footer class="main_footer">
    <div class="container">
        <div class="footer-top-outer">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <div class="footer_about_widget">
                            <figure class="footer_widget_logo">
                                <img src="{{asset('images/golden-x.png')}}" alt="goldex">
                            </figure>
                            <p>GoldenX is the premier destination for buying and selling premium, luxury, and classic vehicles through a transparent auction process.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="footer-widget footer_widget widget_nav_menu">
                                <h4 class="footer_widget_title">Quick Links</h4>
                                <div class="">
                                    <ul class="ft-menu">
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        <li><a href="#">Featured Auctions</a></li>
                                        <li><a href="#">How It Works</a></li>
                                        <li><a href="#">Testimonials</a></li>
                                        <li><a href="#">Sell Your Car</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="footer-widget footer_widget">
                                <h4 class="footer_widget_title">Community</h4>
                                <div>
                                    <ul class="ft-menu">
                                        <li><a href="https://july.finestwp.com/newwp/carola/area-details/">Area Details</a></li>
                                        <li><a href="https://july.finestwp.com/newwp/carola/blog-grid/">Blog Grid</a></li>
                                        <li><a href="https://july.finestwp.com/newwp/carola/faq/">Faq</a></li>
                                        <li><a href="https://july.finestwp.com/newwp/carola/service-areas/">Service Areas</a></li>
                                        <li><a href="https://july.finestwp.com/newwp/carola/testimonials/">Testimonials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="footer-widget footer_widget">
                                <h4 class="footer_widget_title">Contact Us</h4>
                                <div>
                                    <ul class="ft-menu icon_link">
                                        <li>
                                            <i class="fas fa-building me-2 text-warning"></i>
                                            <span>1234 Luxury Lane<br>Beverly Hills, CA 90210<br>United States</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope me-2 text-warning"></i>
                                            <a href="mailto:info@GoldenX.com">Email: info@GoldenX.com</a>
                                        </li>
                                        <li>
                                            <i class="fas fa-phone me-2 text-warning"></i>
                                            <a href="tel:(800) 123-4567">Phone: (800) 123-4567</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-outer">
            <div class="footer-bottom-text">
                Copyright © 2025  <a href="#">GoldenX</a> Inc. All Rights Reserved
            </div>
            <ul class="social-links">
                <li><strong>Follow Us On:</strong></li>
                <li><a target="_blank" href="https://www.facebook.com"><i class="icon fab fa-facebook-f"></i></a></li>
                <li><a target="_blank" href="https://www.twitter.com"><i class="icon fab fa-twitter"></i></a></li>
                <li><a target="_blank" href="https://www.linkedin.com"><i class="icon fab fa-linkedin-in"></i></a></li>
            </ul>
        </div>
    </div>
</footer>

