  <footer class="text-white pt-5 pb-3">
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
  </footer>
