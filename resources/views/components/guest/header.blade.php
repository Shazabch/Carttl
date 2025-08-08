<header class="header" id="header">
    <nav class="navbar container-fluid">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset('images/golden-x.png') }}" class="obj_fit_contain" alt="">
        </a>
        <div class="menu" id="menu">
            <ul class="menu-inner navbar-nav">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('auctions') ? 'active' : '' }}" href="{{ route('auctions') }}">Auctions</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('buy-cars') ? 'active' : '' }} ('buy" href="{{ route('buy-cars') }}">Buy</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('sell-car') ? 'active' : '' }} ('sell" href="{{ route('sell-car') }}">Sell</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact-us') ? 'active' : '' }} ('contact" href="{{ route('contact-us') }}">Contact Us</a></li>
            </ul>
        </div>
        <div class="header-action">
            <a href="#" class="header-icon" id="openSearchBtn">
                <img src="{{ asset('images/icons/search.svg') }}" alt="">
            </a>
           @if(auth()->id())
             <a href="{{ route('account.dashboard') }}" class="header-icon">
                <img src="{{ asset('images/icons/user.svg') }}" alt="">
            </a>
          @else
           <a href="/login" class="header-icon">
                <img src="{{ asset('images/icons/user.svg') }}" alt="">
            </a>

          @endif
            <a href="{{ route('favorites') }}" class="header-icon">
                <img src="{{ asset('images/icons/heart.svg') }}" alt="">
            </a>
            <a href="{{ route('book-inspection') }}" class="theme_btn mt-0">
                <span>Book Inspection</span>
                <img src="{{asset('images/icons/arrow_right.svg')}}" alt="arrow right">
            </a>
            <div class="burger" id="burger">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </div>
        </div>
    </nav>
</header>
