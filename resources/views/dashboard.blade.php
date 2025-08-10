@extends('master')
@section('content')
       <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3 text-primary">Travel Dashboard</h3>
              </div>
            </div>

            <!-- Stats Row -->
            <div class="row">
              <!-- Total Bookings -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round shadow-lg">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                          <i class="fas fa-bookmark"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category text-info">Total Bookings</p>
                          <h4 class="card-title text-dark">1,294</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Active Trips -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round shadow-lg">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                          <i class="fas fa-plane-departure"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category text-warning">Active Trips</p>
                          <h4 class="card-title text-dark">1303</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Completed Packages -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round shadow-lg">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                          <i class="fas fa-flag-checkered"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category text-success">Completed Packages</p>
                          <h4 class="card-title text-dark">345</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Revenue -->
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round shadow-lg">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                          <i class="fas fa-dollar-sign"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category text-danger">Revenue</p>
                          <h4 class="card-title text-dark">$1,345,678</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts Section -->
            <div class="row">
              <!-- User Statistics -->
              <div class="col-md-8">
                <div class="card card-round shadow-lg">
                  <div class="card-header bg-primary text-white">
                    <div class="card-head-row">
                      <div class="card-title">Trip Statistics</div>
                      <div class="card-tools">
                        <a href="#" class="btn btn-label-light btn-round btn-sm">
                          <span class="btn-label">
                            <i class="fa fa-pencil"></i>
                          </span>
                          Export
                        </a>
                        <a href="#" class="btn btn-label-light btn-round btn-sm">
                          <span class="btn-label">
                            <i class="fa fa-print"></i>
                          </span>
                          Print
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                      <canvas id="tripStatisticsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                  </div>
                </div>
              </div>

              <!-- Daily Revenue -->
              <div class="col-md-4">
                <div class="card card-primary card-round shadow-lg">
                  <div class="card-header bg-success text-white">
                    <div class="card-head-row">
                      <div class="card-title">Daily Revenue</div>
                      <div class="card-tools">
                        <div class="dropdown">
                          <button class="btn btn-sm btn-label-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Export
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-category">March 25 - April 02</div>
                  </div>
                  <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                      <h1>$15,678.90</h1>
                    </div>
                    <div class="pull-in">
                      <canvas id="dailyRevenueChart"></canvas>
                    </div>
                  </div>
                </div>

                <!-- Active Users -->
                <div class="card card-round shadow-lg">
                  <div class="card-body pb-0">
                    <div class="h1 fw-bold float-end text-primary">+12%</div>
                    <h2 class="mb-2">24</h2>
                    <p class="text-muted">Users Booking Online</p>
                    <div class="pull-in sparkline-fix">
                      <div id="userActivityChart"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
      </div>
@endsection
