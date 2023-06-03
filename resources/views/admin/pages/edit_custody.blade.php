@extends('admin.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.updateCustody', ['id' => $custody->id]) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Current Custody</label>
                                <input type="text" value="{{ $custody->current_custody }}" name="current_custody" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <input type="text" value="{{ $custody->status }}" name="status" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="text" value="{{ $custody->start_date }}" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Change Date</label>
                                <input type="text" value="{{ $custody->change_date }}" name="change_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Receiving Party</label>
                                <input type="text" value="{{ $custody->receiving_party }}" name="receiving_party" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Initialized By</label>
                                <input type="text" value="{{ $custody->initialized_by }}" name="initialized_by" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Partner to send to</label>
                                <input type="text" value="{{ $custody->partner_to_send_to }}" name="partner_to_send_to" class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Select Order</label>
                                <select name="order_id" id="order_id" class="form-control">
                                    <option value="">Select Order</option>
                                    @foreach($orders as $order)
                                        <option @if($order->id === $custody->order_id) selected @endif value="{{ $order->id }}">INV_{{ $order->id }}</option>
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
                                        <option @if($customer->id === $custody->customer_id) selected @endif value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                            <option @if($country->id === $custody->address_country) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">State</label>
                                    <select name="address_state" id="states_1" class="form-control">
                                        @foreach($address_states as $state)
                                            <option @if($state->id === $custody->address_state) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">City</label>
                                    <select name="address_city" id="cities_1" class="form-control">
                                        @foreach($address_cities as $city)
                                            <option @if($city->id === $custody->address_city) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" value="{{ $custody->final_address }}" name="final_address" class="form-control">
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
                                            <option @if($country->id === $custody->location_country) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">State</label>
                                    <select name="location_state" id="states_2" class="form-control">
                                        @foreach($location_states as $state)
                                            <option @if($state->id === $custody->location_state) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="">City</label>
                                    <select name="location_city" id="cities_2" class="form-control">
                                        @foreach($location_cities as $city)
                                            <option @if($city->id === $custody->location_city) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" value="{{ $custody->final_location }}" name="final_location" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">Save Custody</button>
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
