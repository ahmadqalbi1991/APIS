@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.storeCustody') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Current Custody</label>
                                <input type="text" name="current_custody" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <input type="text" name="status" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="text" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Change Date</label>
                                <input type="text" name="change_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Receiving Party</label>
                                <input type="text" name="receiving_party" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Initialized By</label>
                                <input type="text" name="initialized_by" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Partner to send to</label>
                                <input type="text" name="partner_to_send_to" class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Select Order</label>
                                <select name="order_id" id="order_id" class="form-control">
                                    <option value="">Select Order</option>
                                    @foreach($orders as $order)
                                        <option value="{{ $order->id }}">INV_{{ $order->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="" id="asset_id" name="asset_id">
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Select Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->company->company_name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h4 for="">Final Address</h4>
                                </div>
                                <div class="col-3">
                                    <label for="">Country</label>
                                    <select name="address_country" data-key="1" id="country_1"
                                            class="form-control country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">State</label>
                                    <select name="address_state" id="states_1" class="form-control">
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">City</label>
                                    <select name="address_city" id="cities_1" class="form-control">
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="final_address" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <h4 for="">Final Location</h4>
                                </div>
                                <div class="col-3">
                                    <label for="">Country</label>
                                    <select name="location_country" id="country_2" data-key="2"
                                            class="form-control country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">State</label>
                                    <select name="location_state" id="states_2" class="form-control">
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">City</label>
                                    <select name="location_city" id="cities_2" class="form-control">
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="final_location" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">Add Custody</button>
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
            $('input[name="start_date"]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                showDropdowns: false,
                minYear: 2000,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: 'Y-M-DD HH:mm'
                }
            });

            $('input[name="change_date"]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                singleDatePicker: true,
                showDropdowns: false,
                minYear: 2000,
                maxYear: parseInt(moment().format('YYYY'), 10),
                locale: {
                    format: 'Y-M-DD HH:mm'
                }
            });

            $('#order_id').on('change', function () {
                $.ajax({
                    url: '{{ route("admin.orders.get-customer-id") }}',
                    type: 'get',
                    data: {id: $(this).val()},
                    success: function (response) {
                        $('#customer_id').val(response.user_id)
                        $('#asset_id').val(response.asset_id)
                    }
                })
            });

            $('#country_1').on('change', function () {
                $.ajax({
                    url: '{{ route("get-states") }}',
                    type: 'get',
                    data: {id: $(this).val()},
                    success: function (response) {
                        $('#states_1').html(response);
                    }
                })
            })

            $('#states_1').on('change', function () {
                $.ajax({
                    url: '{{ route("get-cities") }}',
                    type: 'get',
                    data: {id: $(this).val()},
                    success: function (response) {
                        $('#cities_1').html(response);
                    }
                })
            })

            $('#states_2').on('change', function () {
                $.ajax({
                    url: '{{ route("get-cities") }}',
                    type: 'get',
                    data: {id: $(this).val()},
                    success: function (response) {
                        $('#cities_2').html(response);
                    }
                })
            })

            $('#country_2').on('change', function () {
                $.ajax({
                    url: '{{ route("get-states") }}',
                    type: 'get',
                    data: {id: $(this).val()},
                    success: function (response) {
                        $('#states_2').html(response);
                    }
                })
            })
        </script>
    @endpush
@endsection
