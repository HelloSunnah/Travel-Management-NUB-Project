<header>
    <div class="container header-container">
        <div class="logo">
            <a href="{{ route('frontend') }}" class="d-flex align-items-center text-decoration-none">
                <img src="https://via.placeholder.com/40" alt="Jatraa Logo">
                <h1 class="ms-2">Jatra<span>aa</span></h1>
            </a>
        </div>
        <nav id="main-nav">
            <ul>
                <li><a href="{{ route('frontend') }}">Home</a></li>
                <li><a href="#destinations">Destinations</a></li>
                <li><a href="#packages">Packages</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </nav>
        <button class="mobile-menu-btn" id="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>
