@extends('welcome')

@section('content')
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1>Explore The World With Jatraa</h1>
                <p>Discover amazing destinations, both international and domestic, with our expert travel management
                    services. Your dream vacation starts here.</p>
                <div class="hero-btns">
                    <a href="#destinations" class="btn">Explore Destinations</a>
                    <a href="#contact" class="btn btn-accent">Contact Us</a>
                </div>

                <!-- Search Form -->
                <div class="search-form">
                    <div class="form-grid">
                        <form method="GET" action="{{ route('packages.search') }}" class="row g-3 mb-4">
                            <!-- Destination -->
                            <div class="col-md-4">
                                <select name="destination_id" class="form-control">
                                    <option value="">Select Destination</option>
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}"
                                            {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                            <!-- End Date -->
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>

                            <!-- Search Button -->
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    @forelse($searchPackages as $package)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-lg rounded-3">
                                <div class="position-relative">
                                    <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">From
                                        ${{ $package->grand_total }}</span>
                                </div>
                                <div class="card-body text-start">
                                    <h5 class="card-title fw-bold">{{ $package->title }}</h5>
                                    <p class="mb-1"><i class="bi bi-geo-alt-fill text-danger"></i>
                                        <strong>Destination:</strong> {{ $package->destination->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><i class="bi bi-calendar-event text-primary"></i>
                                        <strong>Dates:</strong> {{ $package->start_date }} - {{ $package->end_date }}</p>
                                </div>
                                <div class="card-footer bg-white border-0 text-center pb-3">
                                    <a href="{{ route('booking.show', $package->id) }}"
                                        class="btn btn-outline-primary btn-sm fw-bold">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-white fs-5">No packages found for your search.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Jatraa?</h2>
                <p>We provide comprehensive travel solutions with exceptional service to make your journey memorable and
                    hassle-free.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Global Network</h3>
                    <p>Access to over 5000 destinations worldwide with our extensive network of partners and affiliates.
                    </p>
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
            <div class="section-title text-center mb-5">
                <h2>Popular Destinations</h2>
                <p>Explore our most sought-after destinations, from exotic international locales to breathtaking
                    domestic spots.</p>
            </div>

            <div class="destinations-grid">

                @foreach ($packages as $package)
                    <div class="destination-card">
                        <div class="destination-img">
                            <img src="{{ $package->image? asset('storage/' . $package->image): 'data:image/jpeg;base64,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' }}"
                                alt="{{ $package->title }}">
                        </div>
                        <div class="destination-info">
                            <h3>{{ $package->title }}</h3>
                            <p>{{ Str::limit($package->description, 80) }}</p>
                            <div class="destination-meta">
                                <span><i class="fas fa-bus"></i> {{ $package->peer_head_price }}</span>
                                <a href="{{ route('booking.show', $package->id) }}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach

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
                        <p>Jatraa made our honeymoon to Bali absolutely perfect. Every detail was taken care of, from
                            the flights to the romantic beachfront villa. Their local guide was incredibly knowledgeable
                            and helped us discover hidden gems we would have never found on our own.</p>
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
                        <p>As a frequent business traveler, I rely on Jatraa to handle all my corporate travel needs.
                            Their 24/7 support has saved me multiple times when flights were canceled or changed last
                            minute. The mobile app makes managing itineraries a breeze.</p>
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
                        <p>Our family trip to Japan was unforgettable thanks to Jatraa. They created a perfect itinerary
                            that balanced cultural experiences with fun activities for our kids. The guides were
                            exceptional at engaging our children while teaching us about Japanese traditions.</p>
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
            <p>Let us handle the details while you focus on making memories. Contact our travel experts today to start
                planning your dream vacation.</p>
            <a href="#contact" class="btn btn-accent">Get Started Now</a>
        </div>
    </section>
@endsection
