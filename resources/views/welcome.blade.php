<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jatraa - Your Complete Travel Solution</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global Styles */
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #2980b9;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-accent {
            background: var(--accent);
        }

        .btn-accent:hover {
            background: #c0392b;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: var(--primary);
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            width: 70px;
            height: 4px;
            background: var(--secondary);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-title p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .logo h1 {
            color: var(--primary);
            font-size: 1.8rem;
        }

        .logo span {
            color: var(--secondary);
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            font-size: 1rem;
            transition: color 0.3s;
            position: relative;
        }

        nav ul li a:hover {
            color: var(--secondary);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--secondary);
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1368&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
            margin-top: 70px;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero-btns {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* Search Form */
        .search-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-group input,
        .form-group select {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: var(--light);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        /* Destinations Section */
        .destinations {
            padding: 100px 0;
            background: #f5f7fa;
        }

        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .destination-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .destination-card:hover {
            transform: translateY(-10px);
        }

        .destination-img {
            height: 200px;
            overflow: hidden;
        }

        .destination-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .destination-card:hover .destination-img img {
            transform: scale(1.1);
        }

        .destination-info {
            padding: 20px;
        }

        .destination-info h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .destination-info p {
            color: #666;
            margin-bottom: 15px;
        }

        .destination-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .destination-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent);
        }

        /* Testimonials Section */
        .testimonials {
            padding: 100px 0;
            background: white;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: var(--light);
            padding: 30px;
            border-radius: 10px;
            position: relative;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 5rem;
            color: rgba(52, 152, 219, 0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .testimonial-content {
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }

        .author-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: var(--primary);
        }

        .author-info p {
            color: #666;
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1474&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 70px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--secondary);
            bottom: 0;
            left: 0;
        }

        .footer-col p {
            margin-bottom: 15px;
            color: #bbb;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--secondary);
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #bbb;
            font-size: 0.9rem;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.8rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 15px;
            }

            nav {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 80%;
                height: calc(100vh - 70px);
                background: white;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                transition: left 0.3s;
            }

            nav.active {
                left: 0;
            }

            nav ul {
                flex-direction: column;
                padding: 20px;
            }

            nav ul li {
                margin: 15px 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-btns {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .logo h1 {
                font-size: 1.5rem;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .cta h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="https://via.placeholder.com/40" alt="Jatraa Logo">
                <h1>Jatra<span>aa</span></h1>
            </div>
            <nav id="main-nav">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#destinations">Destinations</a></li>
                    <li><a href="#packages">Packages</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <button class="mobile-menu-btn" id="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1>Explore The World With Jatraa</h1>
                <p>Discover amazing destinations, both international and domestic, with our expert travel management services. Your dream vacation starts here.</p>
                <div class="hero-btns">
                    <a href="#destinations" class="btn">Explore Destinations</a>
                    <a href="#contact" class="btn btn-accent">Contact Us</a>
                </div>

                <!-- Search Form -->
                <div class="search-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <input type="text" id="destination" placeholder="Where to?">
                        </div>
                        <div class="form-group">
                            <label for="check-in">Check In</label>
                            <input type="date" id="check-in">
                        </div>
                        <div class="form-group">
                            <label for="check-out">Check Out</label>
                            <input type="date" id="check-out">
                        </div>
                        <div class="form-group">
                            <label for="travelers">Travelers</label>
                            <select id="travelers">
                                <option value="1">1 Traveler</option>
                                <option value="2">2 Travelers</option>
                                <option value="3">3 Travelers</option>
                                <option value="4">4 Travelers</option>
                                <option value="5+">5+ Travelers</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn search-btn">Search Packages</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Jatraa?</h2>
                <p>We provide comprehensive travel solutions with exceptional service to make your journey memorable and hassle-free.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Global Network</h3>
                    <p>Access to over 5000 destinations worldwide with our extensive network of partners and affiliates.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3>Best Prices</h3>
                    <p>We guarantee the best prices for flights, hotels, and packages with our price match policy.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Our dedicated support team is available round the clock to assist you during your travels.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Travel Insurance</h3>
                    <p>Comprehensive insurance options to protect you against unforeseen circumstances.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-passport"></i>
                    </div>
                    <h3>Visa Assistance</h3>
                    <p>Expert guidance and support for all your visa and documentation requirements.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3>Custom Itineraries</h3>
                    <p>Tailor-made travel plans designed specifically for your preferences and budget.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Destinations Section -->
    <section class="destinations" id="destinations">
        <div class="container">
            <div class="section-title">
                <h2>Popular Destinations</h2>
                <p>Explore our most sought-after destinations, from exotic international locales to breathtaking domestic spots.</p>
            </div>

            <div class="destinations-grid">
                <div class="destination-card">
                    <div class="destination-img">
                        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Bali">
                    </div>
                    <div class="destination-info">
                        <h3>Bali, Indonesia</h3>
                        <p>Experience the tropical paradise with stunning beaches, vibrant culture, and lush landscapes.</p>
                        <div class="destination-meta">
                            <span><i class="fas fa-plane"></i> Flight Included</span>
                            <span class="destination-price">$1,299</span>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-img">
                        <img src="https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1530&q=80" alt="Paris">
                    </div>
                    <div class="destination-info">
                        <h3>Paris, France</h3>
                        <p>The city of love and lights, famous for its art, fashion, gastronomy and culture.</p>
                        <div class="destination-meta">
                            <span><i class="fas fa-plane"></i> Flight Included</span>
                            <span class="destination-price">$1,899</span>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-img">
                        <img src="https://images.unsplash.com/photo-1583422409516-2895a77efded?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Tokyo">
                    </div>
                    <div class="destination-info">
                        <h3>Tokyo, Japan</h3>
                        <p>A dynamic metropolis where traditional culture meets cutting-edge technology.</p>
                        <div class="destination-meta">
                            <span><i class="fas fa-plane"></i> Flight Included</span>
                            <span class="destination-price">$2,199</span>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-img">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="New York">
                    </div>
                    <div class="destination-info">
                        <h3>New York, USA</h3>
                        <p>The city that never sleeps, offering endless entertainment, culture, and iconic landmarks.</p>
                        <div class="destination-meta">
                            <span><i class="fas fa-plane"></i> Flight Included</span>
                            <span class="destination-price">$1,599</span>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-img">
                        <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1632&q=80" alt="Cape Town">
                    </div>
                    <div class="destination-info">
                        <h3>Cape Town, South Africa</h3>
                        <p>Breathtaking landscapes, wildlife, and a rich cultural heritage await in this coastal city.</p>
                        <div class="destination-meta">
                            <span><i class="fas fa-plane"></i> Flight Included</span>
                            <span class="destination-price">$1,799</span>
                        </div>
                    </div>
                </div>

                <div class="destination-card">
                    <div class="destination-img">
                        <img src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Sundarbans">
                    </div>
                    <div class="destination-info">
                        <h3>Sundarbans, Bangladesh</h3>
                        <p>Explore the world's largest mangrove forest and its unique wildlife, including the Royal Bengal Tiger.</p>
                        <div class="destination-meta">
                            <span><i class="fas fa-bus"></i> Transport Included</span>
                            <span class="destination-price">$299</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Travelers Say</h2>
                <p>Hear from our satisfied customers about their experiences traveling with Jatraa.</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>Jatraa made our honeymoon to Bali absolutely perfect. Every detail was taken care of, from the flights to the romantic beachfront villa. Their local guide was incredibly knowledgeable and helped us discover hidden gems we would have never found on our own.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah J.">
                        </div>
                        <div class="author-info">
                            <h4>Sarah J.</h4>
                            <p>Honeymoon Traveler</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>As a frequent business traveler, I rely on Jatraa to handle all my corporate travel needs. Their 24/7 support has saved me multiple times when flights were canceled or changed last minute. The mobile app makes managing itineraries a breeze.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="https://randomuser.me/api/portraits/men/44.jpg" alt="Michael T.">
                        </div>
                        <div class="author-info">
                            <h4>Michael T.</h4>
                            <p>Business Traveler</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <p>Our family trip to Japan was unforgettable thanks to Jatraa. They created a perfect itinerary that balanced cultural experiences with fun activities for our kids. The guides were exceptional at engaging our children while teaching us about Japanese traditions.</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-img">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Ayesha R.">
                        </div>
                        <div class="author-info">
                            <h4>Ayesha R.</h4>
                            <p>Family Traveler</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready for Your Next Adventure?</h2>
            <p>Let us handle the details while you focus on making memories. Contact our travel experts today to start planning your dream vacation.</p>
            <a href="#contact" class="btn btn-accent">Get Started Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>About Jatraa</h3>
                    <p>Jatraa is a premier travel management company specializing in both international and domestic travel solutions. We're committed to delivering exceptional service and unforgettable experiences.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#destinations">Destinations</a></li>
                        <li><a href="#packages">Packages</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Services</h3>
                    <ul class="footer-links">
                        <li><a href="#">Flight Bookings</a></li>
                        <li><a href="#">Hotel Reservations</a></li>
                        <li><a href="#">Tour Packages</a></li>
                        <li><a href="#">Visa Assistance</a></li>
                        <li><a href="#">Travel Insurance</a></li>
                        <li><a href="#">Corporate Travel</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Travel Street, Dhaka, Bangladesh</p>
                    <p><i class="fas fa-phone"></i> +880 1234 567890</p>
                    <p><i class="fas fa-envelope"></i> info@jatraa.com</p>
                    <p><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 6:00 PM</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2023 Jatraa Travel Management System. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mainNav = document.getElementById('main-nav');

        mobileMenuBtn.addEventListener('click', () => {
            mainNav.classList.toggle('active');
            mobileMenuBtn.innerHTML = mainNav.classList.contains('active')
                ? '<i class="fas fa-times"></i>'
                : '<i class="fas fa-bars"></i>';
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                if(this.getAttribute('href') === '#') return;

                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });

                    // Close mobile menu if open
                    if(mainNav.classList.contains('active')) {
                        mainNav.classList.remove('active');
                        mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            });
        });

        // Sticky header on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            header.classList.toggle('sticky', window.scrollY > 0);
        });
    </script>
</body>
</html>
