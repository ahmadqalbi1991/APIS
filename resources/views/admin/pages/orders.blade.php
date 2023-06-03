@extends('admin.main')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5>Orders</h5>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.orders.create-order') }}"
                           class="btn btn-primary">Create Custom Order</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Asset</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key =>  $order)
                        @php
                        $total = $order->price + $order->tax + $order->service_charges;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>INV_{{ $order->id }}</td>
                            <td>{{ $order->customer->name }} ({{ $order->customer->company->company_name }})</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                            <td>{{ $order->asset->manufacture }}({{ $order->asset->model }})</td>
                            <td>${{ $total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

            $(function () {
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": false, "autoWidth": false,
                    "buttons": ["csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
@endsection
