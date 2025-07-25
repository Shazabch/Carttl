   {{-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
       <div class="container">
           <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{asset('images/golden-x.png')}}" alt="">
           </a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
               aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="mainNav">
               <ul class="navbar-nav ms-auto align-items-lg-center">
                   <li class="nav-item"><a class="nav-link  " href="{{ route('home') }}">Home</a></li>
                   <li class="nav-item"><a class="nav-link " href="{{ route('auctions') }}">Auctions</a></li>
                   <li class="nav-item"><a class="nav-link ('sell" href="{{ route('sell-cars') }}">Sell Cars</a></li>
                   <li class="nav-item"><a class="nav-link ('sellcar" href="{{ route('sell-car') }}">Sell </a></li>
                   <li class="nav-item"><a class="nav-link ('contact" href="{{ route('contact-us') }}">Contact Us</a>
                   </li>
                   <li class="nav-item"><a class="nav-link " href="{{ route('favorites') }}">
                           <i class="fas fa-heart"></i>
                           <i>favorites</i></a></li>
                   <li class="nav-item ms-lg-3"><a class="btn btn-warning me-2" href="{{ route('account.login') }}">Sign
                           In</a></li>
                   <li class="nav-item"><a class="btn btn-outline-warning"
                           href="{{ route('account.register') }}">Register</a></li>
               </ul>
               <div class="d-flex gap-2 align-items-center">
                    <li class="nav-item">
                        <a class="btn btn-warning" href="{{ route('account.login') }}">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-warning" href="{{ route('account.register') }}">Register</a>
                    </li>
               </div>
           </div>
       </div>
   </nav> --}}
<header class="header" id="header">
    <nav class="navbar container-fluid">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{asset('images/golden-x.png')}}" class="obj_fit_contain" alt="">
        </a>
        <div class="menu" id="menu">
            <ul class="menu-inner navbar-nav">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('auctions') }}">Auctions</a></li>
                <li class="nav-item"><a class="nav-link ('sell" href="{{ route('sell-cars') }}">Sell Cars</a></li>
                <li class="nav-item"><a class="nav-link ('contact" href="{{ route('contact-us') }}">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('favorites') }}">Favorites</a></li>
            </ul>
        </div>
        <div class="header-action">
            <button class="nav-link book-inspection" onclick="bookInspection()">Book Inspection</button>
            <a href="{{ route('account.login') }}" class="nav-link">
                <img src="{{asset('images/icons/user.svg')}}" alt="">
            </a>
            <div class="burger" id="burger">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </div>
        </div>
    </nav>
</header>