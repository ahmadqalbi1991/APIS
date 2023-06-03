@extends('customers.main')
@push('style_link')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>My Orders</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered myTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Order Date</th>
                                        <th>Asset</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="text-center">
                                                <a href="?order_id={{ $order->id }}">
                                                    <i class="ft-eye"></i>
                                                </a>
                                            </td>
                                            <td>INV_{{ $order->id }}</td>
                                            <td>{{ $order->order_date }}</td>
                                            <td>{{ $order->manufacture }} ({{ $order->model }})</td>
                                            <td>{{ $order->status }}</td>
                                            <td>$ {{ $order->price + $order->tax + $order->service_charges }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if(request()->has('order_id'))
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                Order Detail
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <strong>Order #</strong>
                                    </div>
                                    <div class="col-9">
                                        INV_{{$order_detail->order_id}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Price </strong>
                                    </div>
                                    <div class="col-9">
                                        $ {{$order_detail->price}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Tax </strong>
                                    </div>
                                    <div class="col-9">
                                        $ {{$order_detail->tax}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Service Charges </strong>
                                    </div>
                                    <div class="col-9">
                                        $ {{$order_detail->service_charges}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Asset Model</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->model}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Asset Manufacture</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->manufacture}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Asset Serial</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->serial}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Status</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->status}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Current Custody</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->current_custody}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Start Date</strong>
                                    </div>
                                    <div class="col-9">
                                        {{\Carbon\Carbon::parse($order_detail->start_date)->format('d M, Y')}}
                                    </div>
                                    <div class="col-3">
                                        <strong>End Date</strong>
                                    </div>
                                    <div class="col-9">
                                        {{\Carbon\Carbon::parse($order_detail->change_date)->format('d M, Y')}}
                                    </div>
                                    <div class="col-3">
                                        <strong>Pickup Address</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->final_address}}, {{ $order_detail->city_1 }}
                                        , {{ $order_detail->state_1 }}, {{ $order_detail->country_1 }}
                                    </div>
                                    <div class="col-3">
                                        <strong>Drop Address</strong>
                                    </div>
                                    <div class="col-9">
                                        {{$order_detail->final_location}}, {{ $order_detail->city_2 }}
                                        , {{ $order_detail->state_2 }}, {{ $order_detail->country_2 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.myTable').DataTable();
            });
        </script>
    @endpush
@endsection
