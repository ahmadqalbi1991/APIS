@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5>Orders</h5>
                    </div>
                    <div class="col-6 text-right">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#add-order-modal"
                           class="btn btn-primary">Create Custom Order</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.orders.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Asset</label>
                                <select name="asset_id" id="asset_id" class="form-control">
                                    <option value="">Select Asset</option>
                                    @foreach($assets as $key => $asset)
                                        <option value="{{ $asset->id }}">{{ $asset->model }} ({{ $asset->manufacture }}
                                            )
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Customer</label>
                                <select name="user_id" id="asset_id" class="form-control">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $key => $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->company->company_name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="number" name="price" id="" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tax</label>
                                <input type="number" name="tax" id="" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Service Charges</label>
                                <input type="number" name="service_charges" id="" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Order Date</label>
                                <input type="text" name="order_date" id="" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Order For</label>
                                <select name="order_for" id="" class="form-control">
                                    <option value="sale" selected>Sale</option>
                                    <option value="purchased">Purchased</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-success">Save Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript"
                src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $('input[name="order_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: false,
                minYear: 2000,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: 'Y-M-DD'
                }
            });
        </script>
    @endpush
@endsection
