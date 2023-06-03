@extends('customers.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row">
            </div>
            <div class="content-body"><!-- Chart -->
                <div class="row match-height">
                    <div class="col-12">
                        <div class="">
                            <div id="gradient-line-chart1" class="height-250 GradientlineShadow1"></div>
                        </div>
                    </div>
                </div>
                <!-- Chart -->
                <!-- eCommerce statistic -->
                <div class="row">
                    <div class="{{ request()->has('location') ? 'col-6' : 'col-12' }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="card pull-up ecom-card-1 bg-white">
                                    <div class="card-content ecom-card2" style="height: 600px">
                                        <h5 class="text-muted danger position-absolute p-1">Assets by location</h5>
                                        <div>
                                            <i class="ft-pie-chart danger font-large-1 float-right p-1"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div
                                                    class="progress-stats-container ct-golden-section position-relative pt-3"
                                                    style="height: 500px">
                                                    <canvas id="pie-chart"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="card">
                                                    <div class="card-body">
                                                        @foreach($locations as $key => $location)
                                                            <a href="?location={{ $ids[$key] }}"><span class="loc-color"
                                                                                                       style="background-color: {{ $pie_colors[$key] }}; height: 15px; width: 30px; display: inline-block"></span> {{ $location }}
                                                            </a><br>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card pull-up ecom-card-1 bg-white">
                                    <div class="card-content ecom-card2" style="height: 600px">
                                        <h5 class="text-muted danger position-absolute p-1">Assets by devices</h5>
                                        <div>
                                            <i class="ft-pie-chart danger font-large-1 float-right p-1"></i>
                                        </div>
                                        <div class="progress-stats-container ct-golden-section position-relative pt-3"
                                             style="height: 500px">
                                            <canvas id="bar-chart" style="height: 100%"></canvas>
                                        </div>
                                    </div>
                                    <div class="assets-list">
                                        <ul>
                                            @foreach($items as $key => $item)
                                                <li><a href="{{ route('assets', ['asset_id' => $ids[$key]]) }}">{{ $item }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(request()->has('location'))
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Assets by Locations</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>View</th>
                                                <th>Model</th>
                                                <th>Manufacture</th>
                                                <th>Serial</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($assets as $asset)
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="{{ route('assets', ['asset_id' => $asset->id]) }}"><i
                                                                class="ft-eye"></i></a>
                                                    </td>
                                                    <td>{{ $asset->model }}</td>
                                                    <td>{{ $asset->manufacture }}</td>
                                                    <td>{{ $asset->serial }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!--/ eCommerce statistic -->
            </div>
        </div>
    </div>
    @push('scripts')
        <script !src="">
            $(window).on("load", function () {
                var ctx = $("#pie-chart");
                var chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    responsiveAnimationDuration: 500,
                };
                var chartData = {
                    labels: JSON.parse('<?php echo json_encode($locations) ?>'),
                    datasets: [{
                        label: 'Devices',
                        data: JSON.parse('<?php echo json_encode($pie_values) ?>'),
                        backgroundColor: JSON.parse('<?php echo json_encode($pie_colors) ?>'),
                        borderColor: JSON.parse('<?php echo json_encode($pie_colors) ?>'),
                        borderWidth: 1
                    }]
                };

                var config = {
                    type: 'pie',
                    options: chartOptions,
                    data: chartData
                };
                var pieSimpleChart = new Chart(ctx, config);

                const ctx1 = document.getElementById('bar-chart').getContext('2d');
                const myChart = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: JSON.parse('<?php echo json_encode($items) ?>'),
                        datasets: [{
                            label: 'Devices',
                            data: JSON.parse('<?php echo json_encode($values) ?>'),
                            backgroundColor: '#fa636c',
                            borderColor: '#fa636c',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
