<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="100" width="100" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->

    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <!-- Dashboard Section -->
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="dashboard.html">
                                    <span class="sub-item">Overview</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Travel Packages -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#travel-packages">
                        <i class="fas fa-suitcase"></i>
                        <p>Travel Setup</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="travel-packages">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link"
                                    href="{{ route('destinations.index') }}">Destinations</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('hotels.index') }}">Hotels</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('hotel-rooms.index') }}">Hotels
                                    Room</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('foods.index') }}">Foods</a></li>
                            <!-- <li class="nav-item"><a class="nav-link"
                                    href="{{ route('transports.index') }}">Transports</a></li> -->
                        </ul>
                    </div>
                </li>    <!-- Settings -->
                <li class="nav-item">
                    <a href="{{ route('packages.index') }}">
                        <i class="fas fa-cogs"></i>
                        <p>Packages</p>
                    </a>
                </li>

                <!-- Bookings Section -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#bookings">
                        <i class="fas fa-bookmark"></i>
                        <p>Bookings</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="bookings">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="bookings/pending.html">
                                    <span class="sub-item">Pending Bookings</span>
                                </a>
                            </li>
                            <li>
                                <a href="bookings/confirmed.html">
                                    <span class="sub-item">Confirmed Bookings</span>
                                </a>
                            </li>
                            <li>
                                <a href="bookings/cancelled.html">
                                    <span class="sub-item">Cancelled Bookings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Users Section -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#users">
                        <i class="fas fa-users"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="users/customers.html">
                                    <span class="sub-item">Customers</span>
                                </a>
                            </li>
                            <li>
                                <a href="users/agents.html">
                                    <span class="sub-item">Agents</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Reports Section -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#reports">
                        <i class="fas fa-chart-line"></i>
                        <p>Reports</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="reports">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="reports/overview.html">
                                    <span class="sub-item">Booking Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="reports/financial.html">
                                    <span class="sub-item">Financial Reports</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="settings.html">
                        <i class="fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
