@extends('main')
@section('content')
    <div class="notika-status-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 shadow">
                    <h3>Assets</h3>
                    <div>
                        <h4>Assets by devices</h4>
                        <span>Showing percentage of devices</span>
                        <canvas id="myChart" width="200" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div>
                        <h4>Assets by locations</h4>
                        <span>Showing percentage of devices by locations</span>
                        <canvas id="myChart1" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const ctx1 = document.getElementById('myChart1').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: JSON.parse('<?php echo json_encode($items) ?>'),
                    datasets: [{
                        label: 'Devices',
                        data: JSON.parse('<?php echo json_encode($values) ?>'),
                        backgroundColor: JSON.parse('<?php echo json_encode($colors) ?>'),
                        borderColor: JSON.parse('<?php echo json_encode($colors) ?>'),
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const myChart1 = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: JSON.parse('<?php echo json_encode($locations) ?>'),
                    datasets: [{
                        label: 'Devices',
                        data: JSON.parse('<?php echo json_encode($location_values) ?>'),
                        backgroundColor: JSON.parse('<?php echo json_encode($pie_colors) ?>'),
                        borderColor: JSON.parse('<?php echo json_encode($pie_colors) ?>'),
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
