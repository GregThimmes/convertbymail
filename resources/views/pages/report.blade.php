@extends('layouts.app', [
    'namePage' => 'Report',
    'class' => '',
    'activePage' => 'report',
])

@section('content')

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{ $name }}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Dashboards</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Default</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total traffic</h5>
                                    <span class="h2 font-weight-bold mb-0">350,897</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow"><i class="ni ni-active-40"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Today's Traffic</h5>
                                    <span class="h2 font-weight-bold mb-0">2,356</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow"><i class="ni ni-chart-pie-35"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Yesterdays Traffic</h5>
                                    <span class="h2 font-weight-bold mb-0">924</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow"><i class="ni ni-money-coins"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Filtered Traffic</h5>
                                    <span class="h2 font-weight-bold mb-0">49,65%</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow"><i class="ni ni-chart-bar-32"></i></div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-default">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>
                            <h5 class="h3 text-white mb-0">Traffic</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                            <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                        </div>
                        <!-- Chart wrapper -->
                        <canvas id="chart-sales-dark" class="chart-canvas chartjs-render-monitor" style="display: block; height: 350px; width: 741px;" width="1482" height="700"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col"><h3 class="mb-0">Daily Clicks</h3></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Page name</th>
                                <th scope="col">Visitors</th>
                                <th scope="col">Unique users</th>
                                <th scope="col">Bounce rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">/dashboard/</th>
                                <td>4,569</td>
                                <td>340</td>
                                <td><i class="fas fa-arrow-up text-success mr-3"></i> 46,53%</td>
                            </tr>
                            <tr>
                                <th scope="row">/dashboard/index.html</th>
                                <td>3,985</td>
                                <td>319</td>
                                <td><i class="fas fa-arrow-down text-warning mr-3"></i> 46,53%</td>
                            </tr>
                            <tr>
                                <th scope="row">/dashboard/charts.html</th>
                                <td>3,513</td>
                                <td>294</td>
                                <td><i class="fas fa-arrow-down text-warning mr-3"></i> 36,49%</td>
                            </tr>
                            <tr>
                                <th scope="row">/dashboard/tables.html</th>
                                <td>2,050</td>
                                <td>147</td>
                                <td><i class="fas fa-arrow-up text-success mr-3"></i> 50,87%</td>
                            </tr>
                            <tr>
                                <th scope="row">/dashboard/profile.html</th>
                                <td>1,795</td>
                                <td>190</td>
                                <td><i class="fas fa-arrow-down text-danger mr-3"></i> 46,53%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
   <script type="text/javascript" charset="utf-8">
    //
// Charts
//

'use strict';

//
// Sales chart
//

var SalesChart = (function() {

    // Variables

    var $chart = $('#chart-sales-dark');


    // Methods

    function init($this, labels, clicks) {
        console.log(clicks);
        var salesChart = new Chart($this, {
            type: 'line',
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: Charts.colors.gray[700],
                            zeroLineColor: Charts.colors.gray[700]
                        },
                        ticks: {

                        }
                    }]
                }
            },
            data: {
                labels: labels,
                datasets: [{
                    label: 'Clicks',
                    data: clicks
                }]
            }
        });

        // Save to jQuery object

        $this.data('chart', salesChart);

    };

    // Events

    if ($chart.length) {

        fetch('../ajax/report?id={{ $id }}').then(function(response) {
            return response.json();
          }).then(function(data) {

            var labels = [];
            var clicks = [];

            for (var key in data) {
              var arr = data[key];
              labels.push(arr.Daily);
              clicks.push(arr.Clicks);
           }

           init($chart, labels, clicks);
     
       });
    }

})();
  </script>
@endpush