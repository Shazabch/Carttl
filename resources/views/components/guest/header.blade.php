   <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
       <div class="container">
           <a class="navbar-brand" href="{{ route('home') }}">Golden<span>X</span></a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
               aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="mainNav">
               <ul class="navbar-nav ms-auto align-items-lg-center">
                   <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                   <li class="nav-item"><a class="nav-link" href="{{ route('auctions') }}">Auctions</a></li>
                   <li class="nav-item"><a class="nav-link" href="#">Sell Cars</a></li>
                   <li class="nav-item"><a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a></li>
                   <li class="nav-item ms-lg-3"><a class="btn btn-warning me-2" href="{{ route('account.login') }}">Sign
                           In</a></li>
                   <li class="nav-item"><a class="btn btn-outline-warning"
                           href="{{ route('account.register') }}">Register</a></li>
               </ul>
           </div>
       </div>
   </nav>
